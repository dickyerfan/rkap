<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_penerimaan_amdk extends CI_Model
{

    public function getDataPenerimaan($tahun)
    {
        // ==========================================================
        // STEP 1: Get Production (Buah) and Revenue (Rp)
        // ==========================================================

        // 1.1 Ambil data produksi
        $sql_produksi = "
        SELECT p.id_produk, p.nama_produk, pr.bulan, pr.jumlah_produksi
        FROM rkap_amdk_produksi pr
        JOIN rkap_amdk_produk p ON p.id_produk = pr.id_produk
        WHERE pr.tahun_rkap = ?
        ORDER BY p.id_produk, pr.bulan
    ";
        $produksi_query = $this->db->query($sql_produksi, [$tahun])->result_array();

        // 1.2 Ambil data persentase
        $sql_persen = "
        SELECT id_produk, id_tarif, persen
        FROM rkap_amdk_persentase
        WHERE tahun_rkap = ?
    ";
        $persen_query = $this->db->query($sql_persen, [$tahun])->result_array();
        $data_persen = [];
        foreach ($persen_query as $row) {
            $data_persen[$row['id_produk']][$row['id_tarif']] = $row['persen'];
        }

        // 1.3 Ambil data harga
        $sql_harga = "
        SELECT h.id_produk, h.id_tarif, t.tarif, h.harga
        FROM rkap_amdk_harga h
        JOIN rkap_amdk_tarif t ON t.id_tarif = h.id_tarif
        WHERE h.tahun_rkap = ?
    ";
        $harga_query = $this->db->query($sql_harga, [$tahun])->result_array();
        $data_harga = [];
        foreach ($harga_query as $row) {
            $data_harga[$row['id_produk']][$row['id_tarif']] = [
                'tarif' => strtolower($row['tarif']),
                'harga' => $row['harga']
            ];
        }

        // 1.4 Hitung total pendapatan (Rp) DAN produksi (Buah)
        $data_bulanan_produk = [];
        foreach ($produksi_query as $row) {
            $id_produk = $row['id_produk'];
            $nama_produk = $row['nama_produk'];
            $bulan = (int)$row['bulan'];
            $jumlah_produksi = (float)$row['jumlah_produksi']; // Ini 'Buah'

            if (!isset($data_bulanan_produk[$id_produk])) {
                $data_bulanan_produk[$id_produk] = [
                    'id_produk' => $id_produk,
                    'nama_produk' => $nama_produk,
                    'pendapatan_bulanan' => array_fill(1, 12, 0), // Revenue (Rp)
                    'produksi_bulanan' => array_fill(1, 12, 0)   // Production (Buah)
                ];
            }

            // Simpan 'Buah'
            $data_bulanan_produk[$id_produk]['produksi_bulanan'][$bulan] = $jumlah_produksi;

            // Hitung 'Rp'
            $pendapatan_bulan_ini = 0;
            if (isset($data_harga[$id_produk])) {
                foreach ($data_harga[$id_produk] as $id_tarif => $tarif_info) {
                    $harga = $tarif_info['harga'];
                    $persen = $data_persen[$id_produk][$id_tarif] ?? 0;
                    $produksi_tarif = $jumlah_produksi * ($persen / 100);
                    $pendapatan_bulan_ini += $produksi_tarif * $harga;
                }
            }
            $data_bulanan_produk[$id_produk]['pendapatan_bulanan'][$bulan] += $pendapatan_bulan_ini;
        }

        // ==========================================================
        // STEP 2: Ambil Data Piutang Tahun Lalu (Buah dan Rp)
        // ==========================================================
        $sql_th_lalu = "
        SELECT id_produk, produk_lalu, rupiah_lalu
        FROM rkap_amdk_penerimaan_th_lalu
        WHERE tahun = ?
    ";
        $th_lalu_query = $this->db->query($sql_th_lalu, [$tahun])->result_array();
        $data_th_lalu = [];
        foreach ($th_lalu_query as $row) {
            $data_th_lalu[$row['id_produk']] = [
                'produk_lalu' => $row['produk_lalu'], // Buah
                'rupiah_lalu' => $row['rupiah_lalu']  // Rp
            ];
        }

        // ==========================================================
        // STEP 3: Format Hasil Akhir (Array untuk View Penerimaan)
        // ==========================================================
        $result = [];

        $nama_bulan = [
            1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($data_bulanan_produk as $id_produk => $produk) {

            $result[$id_produk] = [
                'id_produk' => $id_produk,
                'nama_produk' => $produk['nama_produk'],
                'rows' => [] // Ini akan berisi 'total_produk', 'th_lalu', dan 'bulanan'
            ];

            // Dapatkan revenue (Rp) dan produksi (Buah) bulanan
            $revenue = $produk['pendapatan_bulanan']; // Array [1 => 1000, 2 => 2000, ...]
            $produksi = $produk['produksi_bulanan'];   // Array [1 => 50, 2 => 60, ...]

            // Dapatkan data th lalu
            $th_lalu_buah_total = $data_th_lalu[$id_produk]['produk_lalu'] ?? 0;
            $th_lalu_rp_total = $data_th_lalu[$id_produk]['rupiah_lalu'] ?? 0;

            // --- 1. Siapkan Baris "Th Lalu" ---
            $baris_th_lalu = [
                'uraian' => '- Th Lalu',
                'tagihan_buah' => $th_lalu_buah_total, // Total Buah Th Lalu
                'tagihan_rp' => $th_lalu_rp_total,     // Total Rp Th Lalu
                'penerimaan' => array_fill(1, 13, 0)
            ];

            // Hitung penerimaan 'Th Lalu'
            $baris_th_lalu['penerimaan'][1] = $th_lalu_rp_total * 0.50; // Jan
            $baris_th_lalu['penerimaan'][2] = $th_lalu_rp_total * 0.30; // Feb
            $baris_th_lalu['penerimaan'][3] = $th_lalu_rp_total * 0.20; // Mar
            $baris_th_lalu['penerimaan'][13] = $baris_th_lalu['penerimaan'][1] + $baris_th_lalu['penerimaan'][2] + $baris_th_lalu['penerimaan'][3];

            $result[$id_produk]['rows']['th_lalu'] = $baris_th_lalu;

            // --- 2. Siapkan Baris Bulanan (- Januari s/d - Desember) ---
            $rows_bulanan = [];

            // Siapkan array untuk Baris Total Produk (baris bold paling atas)
            $baris_total_produk = [
                'uraian' => strtoupper($produk['nama_produk']),
                'tagihan_buah' => $baris_th_lalu['tagihan_buah'], // Mulai dengan total th lalu
                'tagihan_rp' => $baris_th_lalu['tagihan_rp'],     // Mulai dengan total th lalu
                'penerimaan' => $baris_th_lalu['penerimaan']   // Mulai dgn penerimaan th lalu
            ];

            for ($r = 1; $r <= 12; $r++) { // $r = bulan revenue (Baris)
                $nama_baris = $nama_bulan[$r];
                $revenue_bulan_r = $revenue[$r] ?? 0;
                $produksi_bulan_r = $produksi[$r] ?? 0;

                $baris_ini = [
                    'uraian' => '- ' . $nama_baris,
                    'tagihan_buah' => $produksi_bulan_r,
                    'tagihan_rp' => $revenue_bulan_r,
                    'penerimaan' => array_fill(1, 13, 0)
                ];

                // Hitung penerimaan 90/10
                $val_90 = $revenue_bulan_r * 0.90;
                $baris_ini['penerimaan'][$r] = $val_90;

                $val_10 = 0;
                if ($r < 12) {
                    $val_10 = $revenue_bulan_r * 0.10;
                    $baris_ini['penerimaan'][$r + 1] = $val_10;
                }

                $baris_ini['penerimaan'][13] = $val_90 + $val_10; // Total penerimaan baris ini

                // Simpan baris ini
                $rows_bulanan[$nama_baris] = $baris_ini;

                // Akumulasi ke baris total produk
                $baris_total_produk['tagihan_buah'] += $produksi_bulan_r;
                $baris_total_produk['tagihan_rp'] += $revenue_bulan_r;
                $baris_total_produk['penerimaan'][$r] += $val_90;
                if ($r < 12) {
                    $baris_total_produk['penerimaan'][$r + 1] += $val_10;
                }
            }

            // Simpan semua baris bulanan
            $result[$id_produk]['rows']['bulanan'] = $rows_bulanan;

            // --- 3. Selesaikan kalkulasi Baris Total Produk ---
            $baris_total_produk['penerimaan'][13] = 0;
            for ($i = 1; $i <= 12; $i++) {
                $baris_total_produk['penerimaan'][13] += $baris_total_produk['penerimaan'][$i];
            }
            $result[$id_produk]['rows']['total_produk'] = $baris_total_produk;
        }

        return $result;
    }

    // public function getDataPenerimaanNonAir($tahun)
    // {
    //     // --- STEP 1: Logika dari get_pendapatan_na Anda ---
    //     $this->db->select('no_per_id, bulan, SUM(pagu) AS total_pagu');
    //     $this->db->from('rkap_rekap');
    //     $this->db->where('YEAR(bulan)', $tahun);
    //     $this->db->where('no_per_id', '88.02.07');
    //     // $this->db->where_in('no_per_id', ['88.02.07', '88.02.08']);
    //     $this->db->group_by(['no_per_id', 'bulan']);
    //     $query = $this->db->get();
    //     $result_query = $query->result_array();

    //     $produk_list = [
    //         '88.02.07' => 'Pendapatan Penjualan Galon',
    //     ];

    //     // Inisialisasi data pendapatan (Revenue) bulanan
    //     $data_revenue = [];
    //     foreach ($produk_list as $kode => $nama) {
    //         $data_revenue[$nama] = [
    //             'pendapatan_bulanan' => array_fill(1, 12, 0)
    //         ];
    //     }

    //     foreach ($result_query as $row) {
    //         $kode = $row['no_per_id'];
    //         $bulan = (int)date('n', strtotime($row['bulan']));
    //         $total = (float)$row['total_pagu'];

    //         if (isset($produk_list[$kode])) {
    //             $nama_produk = $produk_list[$kode];
    //             $data_revenue[$nama_produk]['pendapatan_bulanan'][$bulan] = $total;
    //         }
    //     }

    //     // --- STEP 2: Format data agar sesuai struktur view ---
    //     // (Struktur ini sama persis dengan getDataPenerimaan)

    //     $result = [];
    //     $nama_bulan = [
    //         1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    //         7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    //     ];

    //     foreach ($data_revenue as $nama_produk => $produk) {

    //         $result[$nama_produk] = [
    //             'id_produk' => $nama_produk, // Kita gunakan nama sbg ID unik
    //             'nama_produk' => $nama_produk,
    //             'rows' => []
    //         ];

    //         // Dapatkan revenue (Rp) bulanan
    //         $revenue = $produk['pendapatan_bulanan']; // Array [1 => 1000, 2 => 2000, ...]

    //         // --- 1. Siapkan Baris "Th Lalu" (Kosong untuk Non Air) ---
    //         $baris_th_lalu = [
    //             'uraian' => '- Th Lalu',
    //             'tagihan_buah' => 0,
    //             'tagihan_rp' => 0,
    //             'penerimaan' => array_fill(1, 13, 0)
    //         ];
    //         $result[$nama_produk]['rows']['th_lalu'] = $baris_th_lalu;

    //         // --- 2. Siapkan Baris Bulanan (- Januari s/d - Desember) ---
    //         $rows_bulanan = [];

    //         // Siapkan array untuk Baris Total Produk
    //         $baris_total_produk = [
    //             'uraian' => strtoupper($nama_produk),
    //             'tagihan_buah' => 0, // Non Air tidak ada Tagihan Buah
    //             'tagihan_rp' => 0, // Akan diakumulasi
    //             'penerimaan' => $baris_th_lalu['penerimaan'] // Mulai dgn penerimaan th lalu (0)
    //         ];

    //         for ($r = 1; $r <= 12; $r++) { // $r = bulan revenue (Baris)
    //             $nama_baris = $nama_bulan[$r];
    //             $revenue_bulan_r = $revenue[$r] ?? 0;

    //             $baris_ini = [
    //                 'uraian' => '- ' . $nama_baris,
    //                 'tagihan_buah' => 0, // Kosong
    //                 'tagihan_rp' => $revenue_bulan_r, // Ini adalah Tagihan Rp
    //                 'penerimaan' => array_fill(1, 13, 0)
    //             ];

    //             // Hitung penerimaan 90/10
    //             $val_90 = $revenue_bulan_r * 0.90;
    //             $baris_ini['penerimaan'][$r] = $val_90;

    //             $val_10 = 0;
    //             if ($r < 12) {
    //                 $val_10 = $revenue_bulan_r * 0.10;
    //                 $baris_ini['penerimaan'][$r + 1] = $val_10;
    //             }

    //             $baris_ini['penerimaan'][13] = $val_90 + $val_10; // Total penerimaan baris ini

    //             // Simpan baris ini
    //             $rows_bulanan[$nama_baris] = $baris_ini;

    //             // Akumulasi ke baris total produk
    //             // $baris_total_produk['tagihan_buah'] += 0;
    //             $baris_total_produk['tagihan_rp'] += $revenue_bulan_r;
    //             $baris_total_produk['penerimaan'][$r] += $val_90;
    //             if ($r < 12) {
    //                 $baris_total_produk['penerimaan'][$r + 1] += $val_10;
    //             }
    //         }

    //         // Simpan semua baris bulanan
    //         $result[$nama_produk]['rows']['bulanan'] = $rows_bulanan;

    //         // --- 3. Selesaikan kalkulasi Baris Total Produk ---
    //         $baris_total_produk['penerimaan'][13] = 0;
    //         for ($i = 1; $i <= 12; $i++) {
    //             $baris_total_produk['penerimaan'][13] += $baris_total_produk['penerimaan'][$i];
    //         }
    //         $result[$nama_produk]['rows']['total_produk'] = $baris_total_produk;
    //     }

    //     return $result;
    // }

    public function getDataPenerimaanNonAir($tahun)
    {
        // --- STEP 1: Logika dari get_pendapatan_na Anda (DATA TAHUN INI) ---
        $this->db->select('no_per_id, bulan, SUM(pagu) AS total_pagu');
        $this->db->from('rkap_rekap');
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->where('no_per_id', '88.02.07');
        $this->db->group_by(['no_per_id', 'bulan']);
        $query = $this->db->get();
        $result_query = $query->result_array();

        $produk_list = [
            '88.02.07' => 'Pendapatan Penjualan Galon',
        ];

        $data_revenue = [];
        foreach ($produk_list as $kode => $nama) {
            $data_revenue[$nama] = [
                'pendapatan_bulanan' => array_fill(1, 12, 0)
            ];
        }

        foreach ($result_query as $row) {
            $kode = $row['no_per_id'];
            $bulan = (int)date('n', strtotime($row['bulan']));
            $total = (float)$row['total_pagu'];

            if (isset($produk_list[$kode])) {
                $nama_produk = $produk_list[$kode];
                $data_revenue[$nama_produk]['pendapatan_bulanan'][$bulan] = $total;
            }
        }

        // ==========================================================
        // [BARU] STEP 1.5: Ambil Data Piutang Tahun Lalu (Non Air)
        // ==========================================================
        $sql_th_lalu = "
        SELECT produk_lalu, rupiah_lalu
        FROM rkap_amdk_penerimaan_th_lalu
        WHERE tahun = ? AND id_produk = 9
    "; // id_produk = 9 sesuai permintaan Anda
        $th_lalu_query = $this->db->query($sql_th_lalu, [$tahun])->row();

        // Siapkan variabel untuk th lalu
        $th_lalu_buah_total = 0;
        $th_lalu_rp_total = 0;
        if ($th_lalu_query) {
            $th_lalu_buah_total = (float)($th_lalu_query->produk_lalu ?? 0);
            $th_lalu_rp_total = (float)($th_lalu_query->rupiah_lalu ?? 0);
        }

        // --- STEP 2: Format data agar sesuai struktur view ---
        $result = [];
        $nama_bulan = [
            1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($data_revenue as $nama_produk => $produk) {

            $result[$nama_produk] = [
                'id_produk' => $nama_produk,
                'nama_produk' => $nama_produk,
                'rows' => []
            ];

            $revenue = $produk['pendapatan_bulanan'];

            // --- 1. Siapkan Baris "Th Lalu" (Sudah diisi data) ---
            $baris_th_lalu = [
                'uraian' => '- Th Lalu',
                'tagihan_buah' => $th_lalu_buah_total,     // [PERBAIKAN] Menggunakan data query
                'tagihan_rp' => $th_lalu_rp_total,         // [PERBAIKAN] Menggunakan data query
                'penerimaan' => array_fill(1, 13, 0)
            ];

            // [PERBAIKAN] Hitung penerimaan 'Th Lalu'
            $baris_th_lalu['penerimaan'][1] = $th_lalu_rp_total * 0.50; // Jan
            $baris_th_lalu['penerimaan'][2] = $th_lalu_rp_total * 0.30; // Feb
            $baris_th_lalu['penerimaan'][3] = $th_lalu_rp_total * 0.20; // Mar
            $baris_th_lalu['penerimaan'][13] = $baris_th_lalu['penerimaan'][1] + $baris_th_lalu['penerimaan'][2] + $baris_th_lalu['penerimaan'][3];

            $result[$nama_produk]['rows']['th_lalu'] = $baris_th_lalu;

            // --- 2. Siapkan Baris Bulanan (- Januari s/d - Desember) ---
            $rows_bulanan = [];

            // Siapkan array untuk Baris Total Produk
            $baris_total_produk = [
                'uraian' => strtoupper($nama_produk),
                'tagihan_buah' => $baris_th_lalu['tagihan_buah'], // [PERBAIKAN] Mulai dengan data th lalu
                'tagihan_rp' => $baris_th_lalu['tagihan_rp'],     // [PERBAIKAN] Mulai dengan data th lalu
                'penerimaan' => $baris_th_lalu['penerimaan']   // [PERBAIKAN] Mulai dgn penerimaan th lalu
            ];

            for ($r = 1; $r <= 12; $r++) {
                $nama_baris = $nama_bulan[$r];
                $revenue_bulan_r = $revenue[$r] ?? 0;

                $baris_ini = [
                    'uraian' => '- ' . $nama_baris,
                    'tagihan_buah' => 0, // Benar, non-air th ini tidak ada buah
                    'tagihan_rp' => $revenue_bulan_r,
                    'penerimaan' => array_fill(1, 13, 0)
                ];

                // Hitung penerimaan 90/10
                $val_90 = $revenue_bulan_r * 0.90;
                $baris_ini['penerimaan'][$r] = $val_90;

                $val_10 = 0;
                if ($r < 12) {
                    $val_10 = $revenue_bulan_r * 0.10;
                    $baris_ini['penerimaan'][$r + 1] = $val_10;
                }

                $baris_ini['penerimaan'][13] = $val_90 + $val_10;

                $rows_bulanan[$nama_baris] = $baris_ini;

                // Akumulasi ke baris total produk
                $baris_total_produk['tagihan_rp'] += $revenue_bulan_r; // Akumulasi Tagihan Rp
                $baris_total_produk['penerimaan'][$r] += $val_90;
                if ($r < 12) {
                    $baris_total_produk['penerimaan'][$r + 1] += $val_10;
                }
            }

            $result[$nama_produk]['rows']['bulanan'] = $rows_bulanan;

            // --- 3. Selesaikan kalkulasi Baris Total Produk ---
            $baris_total_produk['penerimaan'][13] = 0; // Reset total
            for ($i = 1; $i <= 12; $i++) {
                // Hitung total penerimaan (sudah termasuk th lalu + 90/10)
                $baris_total_produk['penerimaan'][13] += $baris_total_produk['penerimaan'][$i];
            }
            $result[$nama_produk]['rows']['total_produk'] = $baris_total_produk;
        }

        return $result;
    }

    public function getTotalPenerimaanAirBulanan($tahun)
    {
        $data = $this->getDataPenerimaan($tahun);

        $total_bulan = array_fill(1, 12, 0);

        foreach ($data as $produk) {
            // Ambil baris total produk
            $rows = $produk['rows'];
            $total_produk = $rows['total_produk']['penerimaan'];

            for ($b = 1; $b <= 12; $b++) {
                $total_bulan[$b] += $total_produk[$b];
            }
        }

        return $total_bulan;
    }

    public function getTotalPenerimaanNonAirBulanan($tahun)
    {
        $data = $this->getDataPenerimaanNonAir($tahun);

        $total_bulan = array_fill(1, 12, 0);

        foreach ($data as $produk) {
            $rows = $produk['rows'];
            $total_produk = $rows['total_produk']['penerimaan'];

            for ($b = 1; $b <= 12; $b++) {
                $total_bulan[$b] += $total_produk[$b];
            }
        }

        return $total_bulan;
    }

    // data penerimaan tahun lalu
    public function insert_tahun_lalu($data)
    {
        return $this->db->insert('rkap_amdk_penerimaan_th_lalu', $data);
    }

    public function cek_tahun_lalu($id_produk, $tahun)
    {
        return $this->db->get_where('rkap_amdk_penerimaan_th_lalu', [
            'id_produk' => $id_produk,
            'tahun' => $tahun
        ])->num_rows() > 0;
    }

    public function get_tahun_lalu($tahun, $upk = null)
    {
        $this->db->select('
            a.*, 
            p.nama_produk
        ');
        $this->db->from('rkap_amdk_penerimaan_th_lalu a');
        $this->db->join('rkap_amdk_produk p', 'a.id_produk = p.id_produk', 'left');
        $this->db->where('a.tahun', $tahun);

        return $this->db->get()->result();
    }

    public function get_tahun_lalu_by_id($id)
    {
        $this->db->select('a.*, p.nama_produk');
        $this->db->from('rkap_amdk_penerimaan_th_lalu a');
        $this->db->join('rkap_amdk_produk p', 'a.id_produk = p.id_produk', 'left');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    public function update_tahun_lalu($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('rkap_amdk_penerimaan_th_lalu', $data);
    }
}
