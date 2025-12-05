<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_beban extends CI_Model
{

    public function get_biaya_umum($tahun, $upk)
    {
        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        // 1. Ambil semua parent akun
        $akun_query = $this->db->query("
        SELECT id AS no_per_id, kode, name
        FROM no_per
        WHERE (kode LIKE '96.%') 
        AND CHAR_LENGTH(kode) <= 8
        ORDER BY kode ASC
        ");

        if (!$akun_query) {
            return [];
        }

        $akun = $akun_query->result_array();

        // 2. Buat daftar semua kode header untuk pengecekan
        $all_header_kodes = array_column($akun, 'kode');

        $data = [];

        foreach ($akun as $a) {
            $kode   = $a['kode'];
            $uraian = $a['name'];
            $children = [];

            // 3. Cek apakah header ini punya child-header lain di dalam daftar
            $has_child_header = false;
            foreach ($all_header_kodes as $other_kode) {
                if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
                    $has_child_header = true;
                    break;
                }
            }

            // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
            if (!$has_child_header) {

                // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
                $this->db->select("
                r.cabang_id,
                r.no_per_id AS kode_rkap, 
                r.uraian AS uraian_rkap, 
                CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
                SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
                SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
                SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
                SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
                SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
                SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
                SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
                SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
                SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
                SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
                SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
                SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
                SUM(r.pagu) AS jumlah, 

            ", false);

                $this->db->from('rkap_biaya r');
                $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
                $this->db->like('np.kode', $kode, 'after');
                $this->db->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $this->db->where('r.cabang_id', $upk);
                }

                // PERUBAHAN: Group by lebih spesifik
                $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
                $rows = $this->db->get()->result_array();

                if ($rows) {
                    foreach ($rows as $r) {
                        $cabang_id = $r['cabang_id'] ?? '';
                        $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

                        // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
                        $children[] = [
                            'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
                            'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
                            'upk'   => $nama_upk,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
                            'sat'   => $r['sat_list'] ?? '',
                            'pagu'  => (float)($r['jumlah'] ?? 0),
                            'harga' => (float)($r['harga_avg'] ?? 0),
                            'jan'   => (float)($r['jan'] ?? 0),
                            'feb'   => (float)($r['feb'] ?? 0),
                            'mar'   => (float)($r['mar'] ?? 0),
                            'apr'   => (float)($r['apr'] ?? 0),
                            'mei'   => (float)($r['mei'] ?? 0),
                            'jun'   => (float)($r['jun'] ?? 0),
                            'jul'   => (float)($r['jul'] ?? 0),
                            'agu'   => (float)($r['agu'] ?? 0),
                            'sep'   => (float)($r['sep'] ?? 0),
                            'okt'   => (float)($r['okt'] ?? 0),
                            'nov'   => (float)($r['nov'] ?? 0),
                            'des'   => (float)($r['des'] ?? 0),
                            'jumlah' => (float)($r['jumlah'] ?? 0),
                            'total_tahun' => (float)($r['jumlah'] ?? 0),
                        ];
                    }
                }
            } // end if(!$has_child_header)

            // 5. push parent + children
            $data[] = [
                'kode' => $kode,
                'uraian' => $uraian,
                'children' => $children
            ];
        }

        return $data;
    }

    public function insert_or_update_umum($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }


    public function get_biaya_pengolahan($tahun, $upk)
    {
        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        // 1. Ambil semua parent akun
        $akun_query = $this->db->query("
        SELECT id AS no_per_id, kode, name
        FROM no_per
        WHERE (kode LIKE '92.%') 
        AND CHAR_LENGTH(kode) <= 8
        ORDER BY kode ASC
        ");

        if (!$akun_query) {
            return [];
        }

        $akun = $akun_query->result_array();

        // 2. Buat daftar semua kode header untuk pengecekan
        $all_header_kodes = array_column($akun, 'kode');

        $data = [];

        foreach ($akun as $a) {
            $kode   = $a['kode'];
            $uraian = $a['name'];
            $children = [];

            // 3. Cek apakah header ini punya child-header lain di dalam daftar
            $has_child_header = false;
            foreach ($all_header_kodes as $other_kode) {
                if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
                    $has_child_header = true;
                    break;
                }
            }

            // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
            if (!$has_child_header) {

                // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
                $this->db->select("
                r.cabang_id,
                r.no_per_id AS kode_rkap, 
                r.uraian AS uraian_rkap, 
                CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
                SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
                SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
                SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
                SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
                SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
                SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
                SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
                SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
                SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
                SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
                SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
                SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
                SUM(r.pagu) AS jumlah, 

            ", false);

                $this->db->from('rkap_biaya r');
                $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
                $this->db->like('np.kode', $kode, 'after');
                $this->db->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $this->db->where('r.cabang_id', $upk);
                }

                // PERUBAHAN: Group by lebih spesifik
                $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
                $rows = $this->db->get()->result_array();

                if ($rows) {
                    foreach ($rows as $r) {
                        $cabang_id = $r['cabang_id'] ?? '';
                        $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

                        // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
                        $children[] = [
                            'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
                            'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
                            'upk'   => $nama_upk,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
                            'sat'   => $r['sat_list'] ?? '',
                            'pagu'  => (float)($r['jumlah'] ?? 0),
                            'harga' => (float)($r['harga_avg'] ?? 0),
                            'jan'   => (float)($r['jan'] ?? 0),
                            'feb'   => (float)($r['feb'] ?? 0),
                            'mar'   => (float)($r['mar'] ?? 0),
                            'apr'   => (float)($r['apr'] ?? 0),
                            'mei'   => (float)($r['mei'] ?? 0),
                            'jun'   => (float)($r['jun'] ?? 0),
                            'jul'   => (float)($r['jul'] ?? 0),
                            'agu'   => (float)($r['agu'] ?? 0),
                            'sep'   => (float)($r['sep'] ?? 0),
                            'okt'   => (float)($r['okt'] ?? 0),
                            'nov'   => (float)($r['nov'] ?? 0),
                            'des'   => (float)($r['des'] ?? 0),
                            'jumlah' => (float)($r['jumlah'] ?? 0),
                            'total_tahun' => (float)($r['jumlah'] ?? 0),
                        ];
                    }
                }
            } // end if(!$has_child_header)

            // 5. push parent + children
            $data[] = [
                'kode' => $kode,
                'uraian' => $uraian,
                'children' => $children
            ];
        }

        return $data;
    }

    public function insert_or_update_pengolahan($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }
    // public function get_biaya_lu($tahun, $upk)
    // {
    //     $mapping_upk = [
    //         '13' => 'AMDK',
    //         '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
    //         '27' => 'Perencanaan', '28' => 'SPI'
    //     ];

    //     // 1. Ambil semua parent akun
    //     $akun_query = $this->db->query("
    //     SELECT id AS no_per_id, kode, name
    //     FROM no_per
    //     WHERE (kode LIKE '98.%' OR kode LIKE '99.%')
    //     AND CHAR_LENGTH(kode) <= 8
    //     ORDER BY kode ASC
    //     ");

    //     if (!$akun_query) {
    //         return [];
    //     }

    //     $akun = $akun_query->result_array();

    //     // 2. Buat daftar semua kode header untuk pengecekan
    //     $all_header_kodes = array_column($akun, 'kode');

    //     $data = [];

    //     foreach ($akun as $a) {
    //         $kode   = $a['kode'];
    //         $uraian = $a['name'];
    //         $children = [];

    //         // 3. Cek apakah header ini punya child-header lain di dalam daftar
    //         $has_child_header = false;
    //         foreach ($all_header_kodes as $other_kode) {
    //             if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
    //                 $has_child_header = true;
    //                 break;
    //             }
    //         }

    //         // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
    //         if (!$has_child_header) {

    //             // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
    //             $this->db->select("
    //             r.cabang_id,
    //             r.no_per_id AS kode_rkap, 
    //             r.uraian AS uraian_rkap, 
    //             CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
    //             SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
    //             SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
    //             SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
    //             SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
    //             SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
    //             SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
    //             SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
    //             SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
    //             SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
    //             SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
    //             SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
    //             SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
    //             SUM(r.pagu) AS jumlah, 

    //         ", false);

    //             $this->db->from('rkap_biaya r');
    //             $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
    //             $this->db->like('np.kode', $kode, 'after');
    //             $this->db->where('YEAR(r.bulan)', (int)$tahun);

    //             if ($upk != 'all' && $upk !== '' && $upk !== null) {
    //                 $this->db->where('r.cabang_id', $upk);
    //             }

    //             // PERUBAHAN: Group by lebih spesifik
    //             $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
    //             $rows = $this->db->get()->result_array();

    //             if ($rows) {
    //                 foreach ($rows as $r) {
    //                     $cabang_id = $r['cabang_id'] ?? '';
    //                     // $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

    //                     // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
    //                     $children[] = [
    //                         'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
    //                         'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
    //                         // 'upk'   => $nama_upk,
    //                         'cabang_id' => $cabang_id,
    //                         'unique_key' => $r['unique_key'] ?? '',
    //                         'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
    //                         'sat'   => $r['sat_list'] ?? '',
    //                         'pagu'  => (float)($r['jumlah'] ?? 0),
    //                         'harga' => (float)($r['harga_avg'] ?? 0),
    //                         'jan'   => (float)($r['jan'] ?? 0),
    //                         'feb'   => (float)($r['feb'] ?? 0),
    //                         'mar'   => (float)($r['mar'] ?? 0),
    //                         'apr'   => (float)($r['apr'] ?? 0),
    //                         'mei'   => (float)($r['mei'] ?? 0),
    //                         'jun'   => (float)($r['jun'] ?? 0),
    //                         'jul'   => (float)($r['jul'] ?? 0),
    //                         'agu'   => (float)($r['agu'] ?? 0),
    //                         'sep'   => (float)($r['sep'] ?? 0),
    //                         'okt'   => (float)($r['okt'] ?? 0),
    //                         'nov'   => (float)($r['nov'] ?? 0),
    //                         'des'   => (float)($r['des'] ?? 0),
    //                         'jumlah' => (float)($r['jumlah'] ?? 0),
    //                         'total_tahun' => (float)($r['jumlah'] ?? 0),
    //                     ];
    //                 }
    //             }
    //         } // end if(!$has_child_header)

    //         // 5. push parent + children
    //         $data[] = [
    //             'kode' => $kode,
    //             'uraian' => $uraian,
    //             'children' => $children
    //         ];
    //     }

    //     return $data;
    // }

    public function get_biaya_lu($tahun, $upk)
    {
        $mapping_upk = [
            '13' => 'AMDK',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        // 1. Ambil semua parent akun
        $akun_query = $this->db->query("
        SELECT id AS no_per_id, kode, name
        FROM no_per
        WHERE (kode LIKE '98.%' OR kode LIKE '99.%')
        AND CHAR_LENGTH(kode) <= 8
        ORDER BY kode ASC
    ");

        if (!$akun_query) {
            return [];
        }

        $akun = $akun_query->result_array();
        $all_header_kodes = array_column($akun, 'kode');
        $data = [];

        foreach ($akun as $a) {
            $kode   = $a['kode'];
            $uraian = $a['name'];
            $children = [];

            // 3. Cek apakah header ini punya child-header lain
            $has_child_header = false;
            foreach ($all_header_kodes as $other_kode) {
                if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
                    $has_child_header = true;
                    break;
                }
            }

            // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
            if (!$has_child_header) {

                // Kolom yang sama di kedua tabel (tanpa kolom ID auto-increment)
                $select_columns = "r.cabang_id, r.no_per_id, r.uraian, r.pagu, r.bulan";

                // --- Query 1: rkap_biaya ---
                // Bersihkan Query Builder untuk query baru
                $this->db->reset_query();
                $q1 = $this->db->select($select_columns, FALSE)
                    ->from('rkap_biaya r')
                    ->join('no_per np', 'r.no_per_id = np.kode', 'left')
                    ->like('np.kode', $kode, 'after')
                    ->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $q1->where('r.cabang_id', $upk);
                }
                $query_rkap_biaya = $q1->get_compiled_select();

                // --- Query 2: rkap_amdk_biaya ---
                // Bersihkan Query Builder untuk query baru
                $this->db->reset_query();
                $q2 = $this->db->select($select_columns, FALSE)
                    ->from('rkap_amdk_biaya r') // <--- TABEL BARU
                    ->join('no_per np', 'r.no_per_id = np.kode', 'left')
                    ->like('np.kode', $kode, 'after')
                    ->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $q2->where('r.cabang_id', $upk);
                }
                $query_rkap_amdk_biaya = $q2->get_compiled_select();

                // 4d. Gabungkan dengan UNION ALL dan GROUP BY
                $full_query = "
                SELECT 
                    T.cabang_id,
                    T.no_per_id AS kode_rkap, 
                    T.uraian AS uraian_rkap, 
                    CONCAT(T.cabang_id, '-', T.no_per_id, '-', REPLACE(T.uraian, ' ', '_')) AS unique_key,
                    SUM(CASE WHEN MONTH(T.bulan)=1 THEN T.pagu ELSE 0 END) AS jan,
                    SUM(CASE WHEN MONTH(T.bulan)=2 THEN T.pagu ELSE 0 END) AS feb,
                    SUM(CASE WHEN MONTH(T.bulan)=3 THEN T.pagu ELSE 0 END) AS mar,
                    SUM(CASE WHEN MONTH(T.bulan)=4 THEN T.pagu ELSE 0 END) AS apr,
                    SUM(CASE WHEN MONTH(T.bulan)=5 THEN T.pagu ELSE 0 END) AS mei,
                    SUM(CASE WHEN MONTH(T.bulan)=6 THEN T.pagu ELSE 0 END) AS jun,
                    SUM(CASE WHEN MONTH(T.bulan)=7 THEN T.pagu ELSE 0 END) AS jul,
                    SUM(CASE WHEN MONTH(T.bulan)=8 THEN T.pagu ELSE 0 END) AS agu,
                    SUM(CASE WHEN MONTH(T.bulan)=9 THEN T.pagu ELSE 0 END) AS sep,
                    SUM(CASE WHEN MONTH(T.bulan)=10 THEN T.pagu ELSE 0 END) AS okt,
                    SUM(CASE WHEN MONTH(T.bulan)=11 THEN T.pagu ELSE 0 END) AS nov,
                    SUM(CASE WHEN MONTH(T.bulan)=12 THEN T.pagu ELSE 0 END) AS des,
                    SUM(T.pagu) AS jumlah
                FROM (
                    {$query_rkap_biaya}
                    UNION ALL
                    {$query_rkap_amdk_biaya}
                ) AS T
                GROUP BY T.no_per_id, T.uraian, T.cabang_id
            ";

                $rows = $this->db->query($full_query)->result_array();

                // ... (Looping dan pengisian $children tetap sama)
                if ($rows) {
                    foreach ($rows as $r) {
                        $cabang_id = $r['cabang_id'] ?? '';
                        $children[] = [
                            'kode'      => $r['kode_rkap'] ?? $kode,
                            'uraian'    => $r['uraian_rkap'] ?? $uraian,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'       => '',
                            'sat'       => '',
                            'pagu'      => (float)($r['jumlah'] ?? 0),
                            'harga'     => (float)(0),
                            'jan'       => (float)($r['jan'] ?? 0),
                            'feb'       => (float)($r['feb'] ?? 0),
                            'mar'       => (float)($r['mar'] ?? 0),
                            'apr'       => (float)($r['apr'] ?? 0),
                            'mei'       => (float)($r['mei'] ?? 0),
                            'jun'       => (float)($r['jun'] ?? 0),
                            'jul'       => (float)($r['jul'] ?? 0),
                            'agu'       => (float)($r['agu'] ?? 0),
                            'sep'       => (float)($r['sep'] ?? 0),
                            'okt'       => (float)($r['okt'] ?? 0),
                            'nov'       => (float)($r['nov'] ?? 0),
                            'des'       => (float)($r['des'] ?? 0),
                            'jumlah'    => (float)($r['jumlah'] ?? 0),
                            'total_tahun' => (float)($r['jumlah'] ?? 0),
                        ];
                    }
                }
            }

            // 5. push parent + children
            $data[] = [
                'kode' => $kode,
                'uraian' => $uraian,
                'children' => $children
            ];
        }

        return $data;
    }

    public function insert_or_update_lu($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }

    public function get_biaya_sumber($tahun, $upk)
    {
        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        // 1. Ambil semua parent akun
        $akun_query = $this->db->query("
        SELECT id AS no_per_id, kode, name
        FROM no_per
        WHERE (kode LIKE '91.%') 
        AND CHAR_LENGTH(kode) <= 8
        ORDER BY kode ASC
    ");

        if (!$akun_query) {
            return [];
        }

        $akun = $akun_query->result_array();

        // 2. Buat daftar semua kode header untuk pengecekan
        $all_header_kodes = array_column($akun, 'kode');

        $data = [];

        foreach ($akun as $a) {
            $kode   = $a['kode'];
            $uraian = $a['name'];
            $children = [];

            // 3. Cek apakah header ini punya child-header lain di dalam daftar
            $has_child_header = false;
            foreach ($all_header_kodes as $other_kode) {
                if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
                    $has_child_header = true;
                    break;
                }
            }

            // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
            if (!$has_child_header) {

                // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
                $this->db->select("
                r.cabang_id,
                r.no_per_id AS kode_rkap, 
                r.uraian AS uraian_rkap, 
                CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
                SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
                SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
                SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
                SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
                SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
                SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
                SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
                SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
                SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
                SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
                SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
                SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
                SUM(r.pagu) AS jumlah, 

            ", false);

                $this->db->from('rkap_biaya r');
                $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
                $this->db->like('np.kode', $kode, 'after');
                $this->db->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $this->db->where('r.cabang_id', $upk);
                }

                // PERUBAHAN: Group by lebih spesifik
                $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
                $rows = $this->db->get()->result_array();

                if ($rows) {
                    foreach ($rows as $r) {
                        $cabang_id = $r['cabang_id'] ?? '';
                        $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

                        // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
                        $children[] = [
                            'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
                            'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
                            'upk'   => $nama_upk,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
                            'sat'   => $r['sat_list'] ?? '',
                            'pagu'  => (float)($r['jumlah'] ?? 0),
                            'harga' => (float)($r['harga_avg'] ?? 0),
                            'jan'   => (float)($r['jan'] ?? 0),
                            'feb'   => (float)($r['feb'] ?? 0),
                            'mar'   => (float)($r['mar'] ?? 0),
                            'apr'   => (float)($r['apr'] ?? 0),
                            'mei'   => (float)($r['mei'] ?? 0),
                            'jun'   => (float)($r['jun'] ?? 0),
                            'jul'   => (float)($r['jul'] ?? 0),
                            'agu'   => (float)($r['agu'] ?? 0),
                            'sep'   => (float)($r['sep'] ?? 0),
                            'okt'   => (float)($r['okt'] ?? 0),
                            'nov'   => (float)($r['nov'] ?? 0),
                            'des'   => (float)($r['des'] ?? 0),
                            'jumlah' => (float)($r['jumlah'] ?? 0),
                            'total_tahun' => (float)($r['jumlah'] ?? 0),
                        ];
                    }
                }
            } // end if(!$has_child_header)

            // 5. push parent + children
            $data[] = [
                'kode' => $kode,
                'uraian' => $uraian,
                'children' => $children
            ];
        }

        return $data;
    }

    public function insert_or_update_sumber($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }

    public function get_biaya_trandis($tahun, $upk)
    {
        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        // 1. Ambil semua parent akun
        $akun_query = $this->db->query("
        SELECT id AS no_per_id, kode, name
        FROM no_per
        WHERE (kode LIKE '93.%') 
        AND CHAR_LENGTH(kode) <= 8
        ORDER BY kode ASC
        ");

        if (!$akun_query) {
            return [];
        }

        $akun = $akun_query->result_array();

        // 2. Buat daftar semua kode header untuk pengecekan
        $all_header_kodes = array_column($akun, 'kode');

        $data = [];

        foreach ($akun as $a) {
            $kode   = $a['kode'];
            $uraian = $a['name'];
            $children = [];

            // 3. Cek apakah header ini punya child-header lain di dalam daftar
            $has_child_header = false;
            foreach ($all_header_kodes as $other_kode) {
                if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
                    $has_child_header = true;
                    break;
                }
            }

            // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
            if (!$has_child_header) {

                // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
                $this->db->select("
                r.cabang_id,
                r.no_per_id AS kode_rkap, 
                r.uraian AS uraian_rkap, 
                CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
                SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
                SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
                SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
                SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
                SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
                SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
                SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
                SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
                SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
                SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
                SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
                SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
                SUM(r.pagu) AS jumlah, 

            ", false);

                $this->db->from('rkap_biaya r');
                $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
                $this->db->like('np.kode', $kode, 'after');
                $this->db->where('YEAR(r.bulan)', (int)$tahun);

                if ($upk != 'all' && $upk !== '' && $upk !== null) {
                    $this->db->where('r.cabang_id', $upk);
                }

                // PERUBAHAN: Group by lebih spesifik
                $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
                $rows = $this->db->get()->result_array();

                if ($rows) {
                    foreach ($rows as $r) {
                        $cabang_id = $r['cabang_id'] ?? '';
                        $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

                        // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
                        $children[] = [
                            'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
                            'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
                            'upk'   => $nama_upk,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
                            'sat'   => $r['sat_list'] ?? '',
                            'pagu'  => (float)($r['jumlah'] ?? 0),
                            'harga' => (float)($r['harga_avg'] ?? 0),
                            'jan'   => (float)($r['jan'] ?? 0),
                            'feb'   => (float)($r['feb'] ?? 0),
                            'mar'   => (float)($r['mar'] ?? 0),
                            'apr'   => (float)($r['apr'] ?? 0),
                            'mei'   => (float)($r['mei'] ?? 0),
                            'jun'   => (float)($r['jun'] ?? 0),
                            'jul'   => (float)($r['jul'] ?? 0),
                            'agu'   => (float)($r['agu'] ?? 0),
                            'sep'   => (float)($r['sep'] ?? 0),
                            'okt'   => (float)($r['okt'] ?? 0),
                            'nov'   => (float)($r['nov'] ?? 0),
                            'des'   => (float)($r['des'] ?? 0),
                            'jumlah' => (float)($r['jumlah'] ?? 0),
                            'total_tahun' => (float)($r['jumlah'] ?? 0),
                        ];
                    }
                }
            } // end if(!$has_child_header)

            // 5. push parent + children
            $data[] = [
                'kode' => $kode,
                'uraian' => $uraian,
                'children' => $children
            ];
        }

        return $data;
    }

    public function insert_or_update_trandis($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }


    public function get_data_to_edit($cabang_id, $no_per_id, $uraian)
    {
        $this->db->where('cabang_id', $cabang_id);
        $this->db->where('no_per_id', $no_per_id);
        $this->db->where('uraian', $uraian);
        $this->db->order_by('bulan', 'ASC');

        return $this->db->get('rkap_biaya')->result_array();
    }

    public function update_batch($data)
    {
        // Konfigurasi primary key untuk update batch
        $this->db->update_batch('rkap_biaya', $data, 'id_by');
        // CodeIgniter tidak selalu mengembalikan jumlah baris yang terpengaruh
        // secara default untuk update_batch. Kita kembalikan saja jumlah data yang dicoba di-update.
        return count($data);
    }

    public function generate_laba_rugi($data)
    {
        if (empty($data)) return;

        foreach ($data as $row) {
            // Cek apakah kombinasi cabang_id + no_per_id + bulan sudah ada
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('bulan', $row['bulan']);
            $query = $this->db->get('rkap_rekap');

            if ($query->num_rows() > 0) {
                // Kalau sudah ada, update data
                $this->db->where('cabang_id', $row['cabang_id']);
                $this->db->where('no_per_id', $row['no_per_id']);
                $this->db->where('bulan', $row['bulan']);
                $this->db->update('rkap_rekap', [
                    'pagu'   => $row['pagu'],
                    'status' => $row['status']
                ]);
            } else {
                // Kalau belum ada, insert data baru
                $this->db->insert('rkap_rekap', $row);
            }
        }
    }

    // public function get_hpp($tahun, $upk)
    // {
    //     $mapping_upk = [
    //         '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
    //         '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
    //         '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
    //         '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
    //         '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
    //         '27' => 'Perencanaan', '28' => 'SPI'
    //     ];

    //     // 1. Ambil semua parent akun
    //     $akun_query = $this->db->query("
    //     SELECT id AS no_per_id, kode, name
    //     FROM no_per
    //     WHERE (kode LIKE '95.%') 
    //     AND CHAR_LENGTH(kode) <= 8
    //     ORDER BY kode ASC
    //     ");

    //     if (!$akun_query) {
    //         return [];
    //     }

    //     $akun = $akun_query->result_array();

    //     // 2. Buat daftar semua kode header untuk pengecekan
    //     $all_header_kodes = array_column($akun, 'kode');

    //     $data = [];

    //     foreach ($akun as $a) {
    //         $kode   = $a['kode'];
    //         $uraian = $a['name'];
    //         $children = [];

    //         // 3. Cek apakah header ini punya child-header lain di dalam daftar
    //         $has_child_header = false;
    //         foreach ($all_header_kodes as $other_kode) {
    //             if ($kode != $other_kode && strpos($other_kode, $kode . '.') === 0) {
    //                 $has_child_header = true;
    //                 break;
    //             }
    //         }

    //         // 4. HANYA jalankan kueri data jika ini adalah header "terdalam"
    //         if (!$has_child_header) {

    //             // PERUBAHAN: Ambil r.no_per_id dan r.uraian secara spesifik
    //             $this->db->select("
    //             r.cabang_id,
    //             r.no_per_id AS kode_rkap, 
    //             r.uraian AS uraian_rkap, 
    //             CONCAT(r.cabang_id, '-', r.no_per_id, '-', REPLACE(r.uraian, ' ', '_')) AS unique_key,
    //             SUM(CASE WHEN MONTH(r.bulan)=1  THEN r.pagu ELSE 0 END) AS jan,
    //             SUM(CASE WHEN MONTH(r.bulan)=2  THEN r.pagu ELSE 0 END) AS feb,
    //             SUM(CASE WHEN MONTH(r.bulan)=3  THEN r.pagu ELSE 0 END) AS mar,
    //             SUM(CASE WHEN MONTH(r.bulan)=4  THEN r.pagu ELSE 0 END) AS apr,
    //             SUM(CASE WHEN MONTH(r.bulan)=5  THEN r.pagu ELSE 0 END) AS mei,
    //             SUM(CASE WHEN MONTH(r.bulan)=6  THEN r.pagu ELSE 0 END) AS jun,
    //             SUM(CASE WHEN MONTH(r.bulan)=7  THEN r.pagu ELSE 0 END) AS jul,
    //             SUM(CASE WHEN MONTH(r.bulan)=8  THEN r.pagu ELSE 0 END) AS agu,
    //             SUM(CASE WHEN MONTH(r.bulan)=9  THEN r.pagu ELSE 0 END) AS sep,
    //             SUM(CASE WHEN MONTH(r.bulan)=10 THEN r.pagu ELSE 0 END) AS okt,
    //             SUM(CASE WHEN MONTH(r.bulan)=11 THEN r.pagu ELSE 0 END) AS nov,
    //             SUM(CASE WHEN MONTH(r.bulan)=12 THEN r.pagu ELSE 0 END) AS des,
    //             SUM(r.pagu) AS jumlah, 

    //         ", false);

    //             $this->db->from('rkap_biaya r');
    //             $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');
    //             $this->db->like('np.kode', $kode, 'after');
    //             $this->db->where('YEAR(r.bulan)', (int)$tahun);

    //             if ($upk != 'all' && $upk !== '' && $upk !== null) {
    //                 $this->db->where('r.cabang_id', $upk);
    //             }

    //             // PERUBAHAN: Group by lebih spesifik
    //             $this->db->group_by('r.no_per_id, r.uraian, r.cabang_id');
    //             $rows = $this->db->get()->result_array();

    //             if ($rows) {
    //                 foreach ($rows as $r) {
    //                     $cabang_id = $r['cabang_id'] ?? '';
    //                     $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'Umum');

    //                     // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
    //                     $children[] = [
    //                         'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
    //                         'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
    //                         'upk'   => $nama_upk,
    //                         'cabang_id' => $cabang_id,
    //                         'unique_key' => $r['unique_key'] ?? '',
    //                         'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
    //                         'sat'   => $r['sat_list'] ?? '',
    //                         'pagu'  => (float)($r['jumlah'] ?? 0),
    //                         'harga' => (float)($r['harga_avg'] ?? 0),
    //                         'jan'   => (float)($r['jan'] ?? 0),
    //                         'feb'   => (float)($r['feb'] ?? 0),
    //                         'mar'   => (float)($r['mar'] ?? 0),
    //                         'apr'   => (float)($r['apr'] ?? 0),
    //                         'mei'   => (float)($r['mei'] ?? 0),
    //                         'jun'   => (float)($r['jun'] ?? 0),
    //                         'jul'   => (float)($r['jul'] ?? 0),
    //                         'agu'   => (float)($r['agu'] ?? 0),
    //                         'sep'   => (float)($r['sep'] ?? 0),
    //                         'okt'   => (float)($r['okt'] ?? 0),
    //                         'nov'   => (float)($r['nov'] ?? 0),
    //                         'des'   => (float)($r['des'] ?? 0),
    //                         'jumlah' => (float)($r['jumlah'] ?? 0),
    //                         'total_tahun' => (float)($r['jumlah'] ?? 0),
    //                     ];
    //                 }
    //             }
    //         } // end if(!$has_child_header)

    //         // 5. push parent + children
    //         $data[] = [
    //             'kode' => $kode,
    //             'uraian' => $uraian,
    //             'children' => $children
    //         ];
    //     }

    //     return $data;
    // }

    // public function get_hpp($tahun, $upk)
    // {
    //     $mapping_upk = [
    //         '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
    //         '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
    //         '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
    //         '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
    //         '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
    //         '27' => 'Perencanaan', '28' => 'SPI'
    //     ];

    //     // Mapping UPK ke kode no_per (otomatis dari pola kode 95.01.xx)
    //     $kode_per_upk = [
    //         '01' => '95.01.01',
    //         '02' => '95.01.02',
    //         '03' => '95.01.03',
    //         '04' => '95.01.04',
    //         '05' => '95.01.05',
    //         '06' => '95.01.06',
    //         '07' => '95.01.07',
    //         '08' => '95.01.08',
    //         '09' => '95.01.09',
    //         '11' => '95.01.10',
    //         '12' => '95.01.11',
    //         '14' => '95.01.12',
    //         '15' => '95.01.13',
    //         '16' => '95.01.14',
    //         '22' => '95.01.15'
    //     ];

    //     // 1️⃣ Filter akun yang diambil
    //     if ($upk != 'all' && isset($kode_per_upk[$upk])) {
    //         $kode_awal = $kode_per_upk[$upk];
    //         $akun_query = $this->db->query("
    //         SELECT id AS no_per_id, kode, name
    //         FROM no_per
    //         WHERE kode LIKE '{$kode_awal}%'
    //         ORDER BY kode ASC
    //     ");
    //     } else {
    //         // default: semua UPK (konsolidasi)
    //         $akun_query = $this->db->query("
    //         SELECT id AS no_per_id, kode, name
    //         FROM no_per
    //         WHERE kode LIKE '95.%'
    //         AND CHAR_LENGTH(kode) <= 8
    //         ORDER BY kode ASC
    //     ");
    //     }

    //     if (!$akun_query) {
    //         return [];
    //     }

    //     $akun = $akun_query->result_array();
    // }

    public function get_hpp($tahun, $upk)
    {
        $kode_per_upk = [
            '01' => '95.01.01', '02' => '95.01.02', '03' => '95.01.03', '04' => '95.01.04',
            '05' => '95.01.05', '06' => '95.01.06', '07' => '95.01.07', '08' => '95.01.08',
            '09' => '95.01.09', '11' => '95.01.10', '12' => '95.01.11',
            '14' => '95.01.12', '15' => '95.01.13', '16' => '95.01.14', '22' => '95.01.15'
        ];

        if ($upk != 'all' && isset($kode_per_upk[$upk])) {
            $kode_awal = $kode_per_upk[$upk];
            $filter = "no_per_id LIKE '{$kode_awal}%'";
        } else {
            $filter = "no_per_id LIKE '95.%'";
        }

        // --- 1. Ambil data HPP dari tabel rkap_biaya ---
        $query = $this->db->query("
        SELECT 
            no_per_id,
            uraian,
            MONTH(bulan) AS bulan,
            SUM(pagu) AS total
        FROM rkap_biaya
        WHERE $filter
          AND YEAR(bulan) = '$tahun'
        GROUP BY no_per_id, uraian, MONTH(bulan)
        ORDER BY no_per_id ASC
    ");

        $hasil = $query->result_array();

        if (!$hasil) return [];

        // --- 2. Bentuk struktur hierarki ---
        $data = [];

        foreach ($hasil as $row) {
            $kode = $row['no_per_id'];
            $parent_kode = substr($kode, 0, 8); // contoh: 95.01.01

            if (!isset($data[$parent_kode])) {
                $data[$parent_kode] = [
                    'kode' => $parent_kode,
                    'uraian' => 'HPP',
                    'children' => []
                ];
            }

            // --- siapkan nilai default bulanan ---
            $bulan_array = [
                'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                'jul' => 0, 'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0
            ];

            $bulan_map = [
                1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr', 5 => 'mei', 6 => 'jun',
                7 => 'jul', 8 => 'agu', 9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
            ];

            $bulan_nama = $bulan_map[$row['bulan']] ?? '';

            // --- kalau sudah ada children yang sama, update bulan ---
            if (!isset($data[$parent_kode]['children'][$kode])) {
                $data[$parent_kode]['children'][$kode] = array_merge([
                    'kode' => $kode,
                    'uraian' => $row['uraian'],
                    'unique_key' => md5($kode . $row['uraian']),
                ], $bulan_array);
            }

            $data[$parent_kode]['children'][$kode][$bulan_nama] += $row['total'];
        }

        // --- 3. Hitung total_tahun per child ---
        foreach ($data as &$parent) {
            foreach ($parent['children'] as &$child) {
                $child['total_tahun'] = array_sum([
                    $child['jan'], $child['feb'], $child['mar'], $child['apr'], $child['mei'], $child['jun'],
                    $child['jul'], $child['agu'], $child['sep'], $child['okt'], $child['nov'], $child['des']
                ]);
            }

            // ubah children ke bentuk array numerik agar mudah di-foreach di view
            $parent['children'] = array_values($parent['children']);
        }

        return array_values($data);
    }
}
