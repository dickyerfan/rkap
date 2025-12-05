<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_amdk extends CI_Model
{
    public function getDataPendapatan($tahun)
    {
        // 1️⃣ Ambil data produksi per produk per bulan
        $sql_produksi = "
            SELECT p.id_produk, p.nama_produk, pr.bulan, pr.jumlah_produksi
            FROM rkap_amdk_produksi pr
            JOIN rkap_amdk_produk p ON p.id_produk = pr.id_produk
            WHERE pr.tahun_rkap = ?
            ORDER BY p.id_produk, pr.bulan
        ";
        $produksi_query = $this->db->query($sql_produksi, [$tahun])->result_array();

        // 2️⃣ Ambil data persentase per produk & tarif
        $sql_persen = "
            SELECT id_produk, id_tarif, persen
            FROM rkap_amdk_persentase
            WHERE tahun_rkap = ?
        ";
        $persen_query = $this->db->query($sql_persen, [$tahun])->result_array();

        // 3️⃣ Ambil data harga per produk & tarif
        $sql_harga = "
            SELECT h.id_produk, h.id_tarif, t.tarif, h.harga
            FROM rkap_amdk_harga h
            JOIN rkap_amdk_tarif t ON t.id_tarif = h.id_tarif
            WHERE h.tahun_rkap = ?
        ";
        $harga_query = $this->db->query($sql_harga, [$tahun])->result_array();

        // Simpan ke array agar cepat diakses
        $data_persen = [];
        foreach ($persen_query as $row) {
            $data_persen[$row['id_produk']][$row['id_tarif']] = $row['persen'];
        }

        $data_harga = [];
        foreach ($harga_query as $row) {
            $data_harga[$row['id_produk']][$row['id_tarif']] = [
                'tarif' => strtolower($row['tarif']),
                'harga' => $row['harga']
            ];
        }

        // 4️⃣ Format hasil akhir
        $result = [
            'produksi' => [],
            'harga' => [],
            'pendapatan' => []
        ];

        foreach ($produksi_query as $row) {
            $id_produk = $row['id_produk'];
            $nama_produk = $row['nama_produk'];
            $bulan = (int)$row['bulan'];
            $jumlah = (float)$row['jumlah_produksi'];

            // Pastikan array produk sudah ada
            if (!isset($result['produksi'][$id_produk])) {
                $result['produksi'][$id_produk] = [
                    'id_produk' => $id_produk,
                    'nama_produk' => $nama_produk,
                    'produksi' => array_fill(1, 12, 0),
                    'tarif' => []
                ];
                $result['harga'][$id_produk] = [
                    'id_produk' => $id_produk,
                    'nama_produk' => $nama_produk,
                    'harga' => 0,
                    'tarif' => []
                ];
                $result['pendapatan'][$id_produk] = [
                    'id_produk' => $id_produk,
                    'nama_produk' => $nama_produk,
                    'pendapatan' => array_fill(1, 12, 0),
                    'tarif' => []
                ];
            }

            // Simpan jumlah produksi total
            $result['produksi'][$id_produk]['produksi'][$bulan] = $jumlah;

            // Iterasi tarif per produk
            if (isset($data_harga[$id_produk])) {
                foreach ($data_harga[$id_produk] as $id_tarif => $tarif_info) {
                    $tarif_nama = $tarif_info['tarif'];
                    $harga = $tarif_info['harga'];
                    $persen = isset($data_persen[$id_produk][$id_tarif]) ? $data_persen[$id_produk][$id_tarif] : 0;

                    // Pastikan tarif sudah ada
                    if (!isset($result['produksi'][$id_produk]['tarif'][$tarif_nama])) {
                        $result['produksi'][$id_produk]['tarif'][$tarif_nama] = [
                            'persen' => $persen,
                            'produksi' => array_fill(1, 12, 0)
                        ];
                    }
                    if (!isset($result['harga'][$id_produk]['tarif'][$tarif_nama])) {
                        $result['harga'][$id_produk]['tarif'][$tarif_nama] = [
                            'persen' => $persen,
                            'harga' => $harga
                        ];
                    }
                    if (!isset($result['pendapatan'][$id_produk]['tarif'][$tarif_nama])) {
                        $result['pendapatan'][$id_produk]['tarif'][$tarif_nama] = [
                            'persen' => $persen,
                            'pendapatan' => array_fill(1, 12, 0)
                        ];
                    }

                    // Hitung jumlah produksi per tarif
                    $produksi_tarif = $jumlah * ($persen / 100);
                    $result['produksi'][$id_produk]['tarif'][$tarif_nama]['produksi'][$bulan] = $produksi_tarif;

                    // Harga tetap sama sepanjang tahun
                    $result['harga'][$id_produk]['tarif'][$tarif_nama]['harga'] = $harga;

                    // Hitung pendapatan per bulan per tarif
                    $pendapatan_bulan = $produksi_tarif * $harga;
                    $result['pendapatan'][$id_produk]['tarif'][$tarif_nama]['pendapatan'][$bulan] = $pendapatan_bulan;

                    // Simpan total pendapatan per produk
                    $result['pendapatan'][$id_produk]['pendapatan'][$bulan] += $pendapatan_bulan;
                }
            }
        }

        return $result;
    }


    public function insertHarga($data)
    {
        // Jika data sudah ada, update saja
        $cek = $this->db->get_where('rkap_amdk_harga', [
            'id_produk' => $data['id_produk'],
            'id_tarif' => $data['id_tarif'],
            'tahun_rkap' => $data['tahun_rkap']
        ])->row();

        if ($cek) {
            $this->db->where('id_harga', $cek->id_harga);
            return $this->db->update('rkap_amdk_harga', [
                'harga' => $data['harga'],
                'ptgs_update' => $data['ptgs_upload']
            ]);
        } else {
            return $this->db->insert('rkap_amdk_harga', $data);
        }
    }

    public function get_pendapatan_na($tahun)
    {
        $this->db->select('no_per_id, bulan, SUM(pagu) AS total_pagu');
        $this->db->from('rkap_rekap');
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->where_in('no_per_id', ['88.02.07', '88.02.08']);
        $this->db->group_by(['no_per_id', 'bulan']);
        $query = $this->db->get();
        $result = $query->result_array();

        // Mapping kode ke nama
        $produk_list = [
            '88.02.07' => 'Pendapatan Penjualan Galon',
            '88.02.08' => 'Pendapatan Penjualan AMDK Lainnya',
        ];

        // Inisialisasi data bulan (Jan–Des)
        $data = [];
        foreach ($produk_list as $kode => $nama) {
            for ($i = 1; $i <= 12; $i++) {
                $data[$nama]['bulan'][$i] = 0;
            }
            $data[$nama]['total'] = 0;
        }

        // Isi data hasil query
        foreach ($result as $row) {
            $kode = $row['no_per_id'];
            $bulan = (int)date('n', strtotime($row['bulan']));
            $total = $row['total_pagu'];

            if (isset($produk_list[$kode])) {
                $nama_produk = $produk_list[$kode];
                $data[$nama_produk]['bulan'][$bulan] = $total;
                $data[$nama_produk]['total'] += $total;
            }
        }
        return $data;
    }

    public function insert_or_update_pendapatan_na($id_upk, $cabang_id, $tahun, $data_input)
    {
        foreach ($data_input as $kode_perkiraan => $nilai_bulanan) {
            foreach ($nilai_bulanan as $bulan => $pagu) {
                if ($pagu === '' || $pagu === null) continue;

                $bulan_date = date('Y-m-d', strtotime("$tahun-$bulan-01"));

                // Cek apakah sudah ada data
                $cek = $this->db->get_where('rkap_rekap', [
                    'id_upk' => $id_upk,
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $kode_perkiraan,
                    'bulan' => $bulan_date
                ])->row();

                $data = [
                    'id_upk' => $id_upk,
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $kode_perkiraan,
                    'bulan' => $bulan_date,
                    'pagu' => $pagu
                ];

                if ($cek) {
                    // update
                    $this->db->where('id', $cek->id);
                    $this->db->update('rkap_rekap', $data);
                } else {
                    // insert baru
                    $this->db->insert('rkap_rekap', $data);
                }
            }
        }
    }

    public function save($tahun, $kode, $pagu)
    {

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = [
                'id_upk'    => null,
                'cabang_id' => 13, // fixed utk penagihan
                'no_per_id' => $kode,
                'bulan'     => $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01',
                'pagu'      => $pagu
            ];

            $this->db->where('YEAR(bulan)', $tahun);
            $this->db->where('MONTH(bulan)', $bulan);
            $this->db->where('no_per_id', $kode);
            $cek = $this->db->get('rkap_rekap')->row();

            if ($cek) {
                $this->db->where('id', $cek->id)->update('rkap_rekap', $data);
            } else {
                $this->db->insert('rkap_rekap', $data);
            }
        }

        return true;
    }
}
