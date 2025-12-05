<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_air extends CI_Model
{
    public function getDataPendapatanAir($tahun, $upk = null)
    {
        // Ambil baris per bulan per jenis pelanggan dari rkap_pelanggan (id_kd = 6)
        $this->db->select("
        p.id_upk,
        u.nama_upk,
        p.id_jp,
        jp.nama_jp,
        p.bulan,
        p.jumlah AS pelanggan_akhir,
        COALESCE(pk.konsumsi_rata, 0) AS konsumsi_rata,
        COALESCE(tr.tarif_rata, 0) AS tarif_rata,
        COALESCE(jt.jasa_pemeliharaan, 0) AS jasa_pemeliharaan,
        COALESCE(jt.jasa_admin, 0) AS jasa_admin
    ");
        $this->db->from('rkap_pelanggan p');
        $this->db->join('rkap_nama_upk u', 'u.id_upk = p.id_upk', 'left');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = p.id_jp', 'left');
        $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
        $this->db->join('rkap_tarif_rata tr', 'tr.id_upk = p.id_upk AND tr.id_jp = p.id_jp AND tr.tahun = p.tahun', 'left');
        $this->db->join('rkap_jasa_tambahan jt', 'jt.id_upk = p.id_upk AND jt.id_jp = p.id_jp AND jt.tahun = p.tahun', 'left');

        $this->db->where('p.tahun', $tahun);
        $this->db->where('p.id_kd', 6); // sambungan akhir

        if ($upk) {
            $this->db->where('p.id_upk', $upk);
        }

        $this->db->order_by('jp.id_jp', 'ASC');
        $rows = $this->db->get()->result_array();

        $nama_upk = !empty($rows) ? $rows[0]['nama_upk'] : '';

        // struktur per jenis pelanggan
        $data = [];

        // temporary accumulators per jenis per bulan
        // we'll keep:
        // pelanggan_sum[b] = sum pelanggan
        // pola_num[b] = sum(pelanggan * konsumsi) -> for weighted avg
        // tarif_num[b] = sum(pelanggan * tarif) -> for weighted avg
        // penjualan_sum[b] = sum(pelanggan * konsumsi * tarif)
        // jasa_admin_sum[b] = sum(pelanggan * jasa_admin)
        // jasa_pem_sum[b] = sum(pelanggan * jasa_pemeliharaan)
        foreach ($rows as $r) {
            $jp = $r['nama_jp'] ?? 'LAINNYA';
            $bulan = (int)$r['bulan'];
            if ($bulan < 1 || $bulan > 12) $bulan = 1;

            if (!isset($data[$jp])) {
                $data[$jp] = [
                    'Pelanggan Akhir'   => array_fill(1, 12, 0),
                    'Pola Konsumsi'     => array_fill(1, 12, 0), // will fill weighted avg later
                    'Tarif Rata'        => array_fill(1, 12, 0), // will fill weighted avg later
                    'Penjualan Air'     => array_fill(1, 12, 0),
                    'Jasa Pemeliharaan' => array_fill(1, 12, 0),
                    'Jasa Administrasi' => array_fill(1, 12, 0),
                    'Tagihan Air'       => array_fill(1, 12, 0),
                    // internal accumulators:
                    '_acc' => [
                        'pel' => array_fill(1, 12, 0),
                        'pola_num' => array_fill(1, 12, 0),
                        'tarif_num' => array_fill(1, 12, 0),
                        'penjualan' => array_fill(1, 12, 0),
                        'jasa_admin' => array_fill(1, 12, 0),
                        'jasa_pem' => array_fill(1, 12, 0)
                    ]
                ];
            }

            $pel = (float)$r['pelanggan_akhir'];
            $pola = (float)$r['konsumsi_rata'];
            $tarif = (float)$r['tarif_rata'];
            $jp_jasa_pem = (float)$r['jasa_pemeliharaan'];
            $jp_jasa_adm = (float)$r['jasa_admin'];

            // per-row penjualan and jasa (note: jasa harus dikali jumlah pelanggan)
            $penjualan_row = $pel * $pola * $tarif;
            $jasa_pem_amount = $pel * $jp_jasa_pem;
            $jasa_adm_amount = $pel * $jp_jasa_adm;

            // accumulators
            $data[$jp]['_acc']['pel'][$bulan] += $pel;
            $data[$jp]['_acc']['pola_num'][$bulan] += $pel * $pola;
            $data[$jp]['_acc']['tarif_num'][$bulan] += $pel * $tarif;
            $data[$jp]['_acc']['penjualan'][$bulan] += $penjualan_row;
            $data[$jp]['_acc']['jasa_admin'][$bulan] += $jasa_adm_amount;
            $data[$jp]['_acc']['jasa_pem'][$bulan] += $jasa_pem_amount;
        }

        // finalize: compute weighted averages and totals per jenis per bulan
        $total = [
            'Pelanggan Akhir'   => array_fill(1, 12, 0),
            'Pola Konsumsi'     => array_fill(1, 12, 0),
            'Tarif Rata'        => array_fill(1, 12, 0),
            'Penjualan Air'     => array_fill(1, 12, 0),
            'Jasa Pemeliharaan' => array_fill(1, 12, 0),
            'Jasa Administrasi' => array_fill(1, 12, 0),
            'Tagihan Air'       => array_fill(1, 12, 0),
        ];
        foreach ($data as $jp => &$block) {
            for ($m = 1; $m <= 12; $m++) {
                $pel_sum = $block['_acc']['pel'][$m];
                // Pelanggan Akhir (jumlah)
                $block['Pelanggan Akhir'][$m] = (int) $pel_sum;

                // pola konsumsi = weighted avg (pel * pola) / pel_sum
                $block['Pola Konsumsi'][$m] = $pel_sum > 0 ? ($block['_acc']['pola_num'][$m] / $pel_sum) : 0;

                // tarif rata = weighted avg (pel * tarif) / pel_sum
                $block['Tarif Rata'][$m] = $pel_sum > 0 ? ($block['_acc']['tarif_num'][$m] / $pel_sum) : 0;

                // penjualan air (sum)
                $block['Penjualan Air'][$m] = $block['_acc']['penjualan'][$m];

                // jasa sums (already multiplied by pel)
                $block['Jasa Pemeliharaan'][$m] = $block['_acc']['jasa_pem'][$m];
                $block['Jasa Administrasi'][$m] = $block['_acc']['jasa_admin'][$m];

                // tagihan air
                $block['Tagihan Air'][$m] = $block['Penjualan Air'][$m] + $block['Jasa Pemeliharaan'][$m] + $block['Jasa Administrasi'][$m];

                // === akumulasi ke TOTAL ===
                $total['Pelanggan Akhir'][$m]   += $block['Pelanggan Akhir'][$m];
                $total['Pola Konsumsi'][$m]     += $block['Pola Konsumsi'][$m] * $block['Pelanggan Akhir'][$m]; // weighted
                $total['Tarif Rata'][$m]        += $block['Tarif Rata'][$m] * $block['Pelanggan Akhir'][$m];   // weighted
                $total['Penjualan Air'][$m]     += $block['Penjualan Air'][$m];
                $total['Jasa Pemeliharaan'][$m] += $block['Jasa Pemeliharaan'][$m];
                $total['Jasa Administrasi'][$m] += $block['Jasa Administrasi'][$m];
                $total['Tagihan Air'][$m]       += $block['Tagihan Air'][$m];
            }
            // drop internal accumulator to keep return clean
            unset($block['_acc']);
        }
        // hitung rata-rata konsumsi dan tarif
        for ($m = 1; $m <= 12; $m++) {
            $pel_sum = $total['Pelanggan Akhir'][$m];
            if ($pel_sum > 0) {
                $total['Pola Konsumsi'][$m] = $total['Pola Konsumsi'][$m] / $pel_sum;
                $total['Tarif Rata'][$m]    = $total['Tarif Rata'][$m] / $pel_sum;
            }
        }
        unset($r, $rows);

        // return $data;
        return [
            'nama_upk' => $nama_upk,
            'data'     => $data,
            'total'    => $total
        ];
    }

    private function getKodePerkiraan($id_upk)
    {
        $mapping = [
            1  => ['penjualan' => '81.01.01.01', 'pemeliharaan' => '81.01.02.01', 'admin' => '81.01.03.01'], // Bondowoso
            2  => ['penjualan' => '81.01.01.02', 'pemeliharaan' => '81.01.02.02', 'admin' => '81.01.03.02'], // Sukosari 1
            3  => ['penjualan' => '81.01.01.03', 'pemeliharaan' => '81.01.02.03', 'admin' => '81.01.03.03'], // Maesan
            4  => ['penjualan' => '81.01.01.04', 'pemeliharaan' => '81.01.02.04', 'admin' => '81.01.03.04'], // Tegalampel
            5  => ['penjualan' => '81.01.01.05', 'pemeliharaan' => '81.01.02.05', 'admin' => '81.01.03.05'], // Tapen
            6  => ['penjualan' => '81.01.01.06', 'pemeliharaan' => '81.01.02.06', 'admin' => '81.01.03.06'], // Prajekan
            7  => ['penjualan' => '81.01.01.07', 'pemeliharaan' => '81.01.02.07', 'admin' => '81.01.03.07'], // Tlogosari
            8  => ['penjualan' => '81.01.01.08', 'pemeliharaan' => '81.01.02.08', 'admin' => '81.01.03.08'], // Wringin
            9  => ['penjualan' => '81.01.01.09', 'pemeliharaan' => '81.01.02.09', 'admin' => '81.01.03.09'], // Curahdami
            10 => ['penjualan' => '81.01.01.10', 'pemeliharaan' => '81.01.02.10', 'admin' => '81.01.03.10'], // Tamanan
            11 => ['penjualan' => '81.01.01.11', 'pemeliharaan' => '81.01.02.11', 'admin' => '81.01.03.11'], // Tenggarang
            12 => ['penjualan' => '81.01.01.12', 'pemeliharaan' => '81.01.02.12', 'admin' => '81.01.03.12'], // Tamankrocok
            13 => ['penjualan' => '81.01.01.13', 'pemeliharaan' => '81.01.02.13', 'admin' => '81.01.03.13'], // Wonosari
            14 => ['penjualan' => '81.01.01.14', 'pemeliharaan' => '81.01.02.14', 'admin' => '81.01.03.14'], // Klabang
            15 => ['penjualan' => '81.01.01.15', 'pemeliharaan' => '81.01.02.15', 'admin' => '81.01.03.15'], // Sukosari 2
        ];

        return $mapping[$id_upk] ?? null;
    }

    public function insertRekapPendapatanAir($tahun, $upk)
    {
        $result = $this->getDataPendapatanAir($tahun, $upk);
        $data   = $result['total'];

        $upkRow = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
        if (!$upkRow) return false;

        $cabang_id = $upkRow->kode;

        // ambil kode perkiraan sesuai id_upk
        $kode = $this->getKodePerkiraan($upk);
        if (!$kode) return false;

        // loop bulan 1-12
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // hapus dulu agar tidak dobel
            $this->db->where('id_upk', $upk);
            $this->db->where('bulan', sprintf('%04d-%02d-01', $tahun, $bulan));
            $this->db->delete('rkap_rekap');

            // insert penjualan air
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['penjualan'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Penjualan Air'][$bulan],
            ]);

            // insert jasa pemeliharaan
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['pemeliharaan'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Jasa Pemeliharaan'][$bulan],
            ]);

            // insert jasa administrasi
            $this->db->insert('rkap_rekap', [
                'id_upk'    => $upk,
                'cabang_id' => $cabang_id,
                'no_per_id' => $kode['admin'],
                'bulan'     => sprintf('%04d-%02d-01', $tahun, $bulan),
                'pagu'      => $data['Jasa Administrasi'][$bulan],
            ]);
        }

        return true;
    }

    public function getTangkiAir($upk, $tahun)
    {
        $this->db->from('rkap_tangki_air');

        if ($upk) {
            $this->db->where('id_upk', $upk);
        }

        // $this->db->where('id_upk', $upk);
        $this->db->where('tahun', $tahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function save_tangki_air($data)
    {
        $this->db->where('cabang_id', $data['cabang_id']);
        $this->db->where('tahun', $data['tahun']);
        $this->db->where('bulan', $data['bulan']);
        $query = $this->db->get('rkap_tangki_air');

        if ($query->num_rows() > 0) {
            $this->db->where('cabang_id', $data['cabang_id']);
            $this->db->where('tahun', $data['tahun']);
            $this->db->where('bulan', $data['bulan']);
            return $this->db->update('rkap_tangki_air', $data);
        } else {
            return $this->db->insert('rkap_tangki_air', $data);
        }
    }

    public function save_rekap_tangki($data)
    {
        // Cek apakah data rekap sudah ada
        $this->db->where('id_upk', $data['id_upk']);
        $this->db->where('cabang_id', $data['cabang_id']);
        $this->db->where('bulan', $data['bulan']);
        $query = $this->db->get('rkap_rekap');

        if ($query->num_rows() > 0) {
            // Jika sudah ada, lakukan update
            $this->db->where('id_upk', $data['id_upk']);
            $this->db->where('cabang_id', $data['cabang_id']);
            $this->db->where('bulan', $data['bulan']);
            return $this->db->update('rkap_rekap', [
                'no_per_id' => $data['no_per_id'],
                'pagu'      => $data['pagu']
            ]);
        } else {
            // Jika belum ada, insert baru
            return $this->db->insert('rkap_rekap', $data);
        }
    }
}
