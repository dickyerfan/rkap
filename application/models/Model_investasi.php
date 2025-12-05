<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_investasi extends CI_Model
{

    // public function get_investasi($tahun, $upk)
    // {
    //     $mapping_upk = [
    //         '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
    //         '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
    //         '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
    //         '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
    //         '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
    //         '27' => 'Perencanaan', '28' => 'SPI'
    //     ];

    //     // Ambil akun parent
    //     $akun = $this->db->query("
    //     SELECT id AS no_per_id, kode, name
    //     FROM no_per
    //     WHERE (kode LIKE '31.%' OR kode LIKE '42.%')
    //       AND CHAR_LENGTH(kode) <= 8
    //     ORDER BY kode ASC
    // ")->result_array();

    //     $data = [];

    //     foreach ($akun as $a) {
    //         $kode_parent = $a['kode'];
    //         $uraian_parent = $a['name'];

    //         // Ambil semua child akun untuk parent ini
    //         $child_akun = $this->db->query("
    //         SELECT kode, name 
    //         FROM no_per 
    //         WHERE kode LIKE '{$kode_parent}.%' 
    //           AND CHAR_LENGTH(kode) > 8
    //         ORDER BY kode ASC
    //     ")->result_array();

    //         $children = [];

    //         foreach ($child_akun as $ca) {
    //             $kode_child = $ca['kode'];
    //             $uraian_child = $ca['name'];

    //             // Query data per UPK untuk setiap child
    //             $this->db->select("
    //             r.cabang_id,
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
    //             GROUP_CONCAT(DISTINCT r.vol ORDER BY r.vol SEPARATOR ', ') AS vol_list,
    //             GROUP_CONCAT(DISTINCT r.sat ORDER BY r.sat SEPARATOR ', ') AS sat_list,
    //             AVG(r.harga) AS harga_avg
    //         ", false);
    //             $this->db->from('rkap_investasi r');
    //             $this->db->where('YEAR(r.bulan)', (int)$tahun);
    //             $this->db->where('r.no_per_id', $kode_child);

    //             if ($upk != 'all' && $upk !== '' && $upk !== null) {
    //                 $this->db->where('r.cabang_id', $upk);
    //             }

    //             $this->db->group_by('r.cabang_id');
    //             $rows = $this->db->get()->result_array();

    //             if ($rows) {
    //                 foreach ($rows as $r) {
    //                     $cabang_id = $r['cabang_id'] ?? '';
    //                     $nama_upk = $mapping_upk[$cabang_id] ?? ($cabang_id ?: 'Umum');

    //                     $children[] = [
    //                         'kode' => $kode_child,
    //                         'uraian' => $uraian_child,
    //                         'upk' => $nama_upk,
    //                         'cabang_id' => $cabang_id,
    //                         'vol' => $r['vol_list'] ?? '',
    //                         'sat' => $r['sat_list'] ?? '',
    //                         'harga' => (float)($r['harga_avg'] ?? 0),
    //                         'jan' => (float)$r['jan'],
    //                         'feb' => (float)$r['feb'],
    //                         'mar' => (float)$r['mar'],
    //                         'apr' => (float)$r['apr'],
    //                         'mei' => (float)$r['mei'],
    //                         'jun' => (float)$r['jun'],
    //                         'jul' => (float)$r['jul'],
    //                         'agu' => (float)$r['agu'],
    //                         'sep' => (float)$r['sep'],
    //                         'okt' => (float)$r['okt'],
    //                         'nov' => (float)$r['nov'],
    //                         'des' => (float)$r['des'],
    //                         'jumlah' => (float)$r['jumlah'],
    //                         'total_tahun' => (float)$r['jumlah']
    //                     ];
    //                 }
    //             }
    //         }

    //         $data[] = [
    //             'kode' => $kode_parent,
    //             'uraian' => $uraian_parent,
    //             'children' => $children
    //         ];
    //     }

    //     return $data;
    // }

    public function get_investasi($tahun, $upk)
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
        WHERE (kode LIKE '31.%' OR kode LIKE '42.01.%') 
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
                SUM(r.vol) AS vol_total,
                GROUP_CONCAT(DISTINCT r.sat ORDER BY r.sat SEPARATOR ', ') AS sat_list,
                AVG(r.harga) AS harga_avg
            ", false);

                $this->db->from('rkap_investasi r');
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
                            'pagu' => (float)($r['jumlah'] ?? 0),
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

    public function insert_or_update($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_investasi')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_investasi', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_investasi', $row);
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
        // Kita ambil semua bulan untuk item uraian ini
        $this->db->order_by('bulan', 'ASC');

        return $this->db->get('rkap_investasi')->result_array();
    }

    public function update_batch_investasi($data)
    {
        // Konfigurasi primary key untuk update batch
        $this->db->update_batch('rkap_investasi', $data, 'id_inves');
        // CodeIgniter tidak selalu mengembalikan jumlah baris yang terpengaruh
        // secara default untuk update_batch. Kita kembalikan saja jumlah data yang dicoba di-update.
        return count($data);
    }

    public function get_investasi_amdk($tahun, $upk)
    {
        $mapping_upk = [
            '13' => 'AMDK'
        ];

        // 1. Ambil semua parent akun
        //     $akun_query = $this->db->query("
        //     SELECT id AS no_per_id, kode, name
        //     FROM no_per
        //     WHERE (kode LIKE '31.%' OR kode LIKE '42.01.%') 
        //       AND CHAR_LENGTH(kode) <= 8
        //     ORDER BY kode ASC
        // ");

        $akun_query = $this->db->query("
                SELECT id AS no_per_id, kode, name
                FROM no_per
                WHERE (kode LIKE '31.%' OR kode LIKE '42.01.%') 
                AND CHAR_LENGTH(kode) <= 11
                AND cab_id = 13   
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
                SUM(r.vol) AS vol_total,
                GROUP_CONCAT(DISTINCT r.sat ORDER BY r.sat SEPARATOR ', ') AS sat_list,
                AVG(r.harga) AS harga_avg
            ", false);

                $this->db->from('rkap_amdk_investasi r');
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
                        $nama_upk = isset($mapping_upk[$cabang_id]) ? $mapping_upk[$cabang_id] : ($cabang_id ?: 'AMDK');

                        // PERUBAHAN: Gunakan data spesifik dari rkap_investasi
                        $children[] = [
                            'kode'  => $r['kode_rkap'] ?? $kode, // <-- Diambil dari r.no_per_id
                            'uraian' => $r['uraian_rkap'] ?? $uraian, // <-- Diambil dari r.uraian
                            'upk'   => $nama_upk,
                            'cabang_id' => $cabang_id,
                            'unique_key' => $r['unique_key'] ?? '',
                            'vol'   => $r['vol_total'] ?? '', // <-- Menggunakan vol_total
                            'sat'   => $r['sat_list'] ?? '',
                            'pagu' => (float)($r['jumlah'] ?? 0),
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

    public function insert_or_update_amdk($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_amdk_investasi')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_amdk_investasi', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_amdk_investasi', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }

    public function update_batch_investasi_amdk($data)
    {
        // Konfigurasi primary key untuk update batch
        $this->db->update_batch('rkap_amdk_investasi', $data, 'id_inves');
        // CodeIgniter tidak selalu mengembalikan jumlah baris yang terpengaruh
        // secara default untuk update_batch. Kita kembalikan saja jumlah data yang dicoba di-update.
        return count($data);
    }

    public function get_data_to_edit_amdk($cabang_id, $no_per_id, $uraian)
    {
        $this->db->where('cabang_id', $cabang_id);
        $this->db->where('no_per_id', $no_per_id);
        $this->db->where('uraian', $uraian);
        // Kita ambil semua bulan untuk item uraian ini
        $this->db->order_by('bulan', 'ASC');

        return $this->db->get('rkap_amdk_investasi')->result_array();
    }

    public function get_rekap_per_akun($tahun)
    {
        // Kita select Kode, Nama, Total Volume, dan Total Pagu (Uang)
        $this->db->select("
        r.no_per_id AS kode,
        np.name AS uraian,
        SUM(r.vol) AS total_vol,
        GROUP_CONCAT(DISTINCT r.sat SEPARATOR ', ') AS sat_list,
        SUM(r.pagu) AS total_biaya
    ");

        $this->db->from('rkap_investasi r');
        // Join ke tabel master akun (no_per) untuk ambil nama perkiraan
        $this->db->join('no_per np', 'r.no_per_id = np.kode', 'left');

        // Filter Tahun
        $this->db->where('YEAR(r.bulan)', (int)$tahun);

        // Filter Kode Akun (Sesuai logic asli: 31.% atau 42.01.%)
        $this->db->group_start();
        $this->db->like('np.kode', '31.', 'after');
        $this->db->or_like('np.kode', '42.01.', 'after');
        $this->db->group_end();

        // INI KUNCINYA: Grouping berdasarkan Kode Perkiraan saja
        $this->db->group_by('r.no_per_id, np.name');

        // Urutkan dari kode terkecil
        $this->db->order_by('r.no_per_id', 'ASC');

        return $this->db->get()->result_array();
    }
}
