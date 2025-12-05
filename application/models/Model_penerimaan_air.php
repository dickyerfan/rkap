<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_penerimaan_air extends CI_Model
{

    // public function getDataPenerimaanAir($tahun, $upk = null)
    // {
    //     // 1️⃣ Ambil data tagihan air yang sudah ada

    //     $pendapatan = $this->getDataPendapatanAir($tahun, $upk);
    //     $data_tagihan = $pendapatan['data']; // per jenis pelanggan

    //     // 2️⃣ Struktur dasar data penerimaan
    //     $data_penerimaan = [];

    //     foreach ($data_tagihan as $jenis_pelanggan => $blok) {
    //         $data_penerimaan[$jenis_pelanggan] = [];

    //         // 2.1. Ambil total tagihan per bulan (Rp)
    //         for ($bulan = 1; $bulan <= 12; $bulan++) {
    //             $tagihan = $blok['Tagihan Air'][$bulan] ?? 0;

    //             // 2.2. Buat simulasi penerimaan (misal: 70% dibayar bulan berikutnya)
    //             // Anda bisa sesuaikan rumus ini nanti sesuai kebutuhan PDAM
    //             $penerimaan = array_fill(1, 12, 0);

    //             if ($bulan == 1) {
    //                 $penerimaan[$bulan] = $tagihan * 0.7; // contoh: 70% langsung dibayar bulan sama
    //                 $penerimaan[$bulan + 1] = $tagihan * 0.3; // sisanya bulan depan
    //             } else {
    //                 $penerimaan[$bulan] = $tagihan * 0.8; // misal 80% dibayar bulan sama
    //                 if ($bulan < 12) {
    //                     $penerimaan[$bulan + 1] += $tagihan * 0.2; // 20% bulan depan
    //                 }
    //             }

    //             // 2.3. Simpan ke data penerimaan
    //             $data_penerimaan[$jenis_pelanggan][$bulan] = [
    //                 'tagihan' => $tagihan,
    //                 'penerimaan' => $penerimaan
    //             ];
    //         }
    //     }

    //     // 3️⃣ Hitung total keseluruhan
    //     $total = array_fill(1, 12, 0);
    //     foreach ($data_penerimaan as $jp => $bulanData) {
    //         foreach ($bulanData as $bulan => $row) {
    //             foreach ($row['penerimaan'] as $b => $nilai) {
    //                 $total[$b] += $nilai;
    //             }
    //         }
    //     }

    //     return [
    //         'data' => $data_penerimaan,
    //         'total' => $total
    //     ];
    // }

    // public function getDataPendapatanAir($tahun, $upk = null)
    // {
    //     // Ambil baris per bulan per jenis pelanggan dari rkap_pelanggan (id_kd = 6)
    //     $this->db->select("
    //     p.id_upk,
    //     u.nama_upk,
    //     p.id_jp,
    //     jp.nama_jp,
    //     p.bulan,
    //     p.jumlah AS pelanggan_akhir,
    //     COALESCE(pk.konsumsi_rata, 0) AS konsumsi_rata,
    //     COALESCE(tr.tarif_rata, 0) AS tarif_rata,
    //     COALESCE(jt.jasa_pemeliharaan, 0) AS jasa_pemeliharaan,
    //     COALESCE(jt.jasa_admin, 0) AS jasa_admin
    // ");
    //     $this->db->from('rkap_pelanggan p');
    //     $this->db->join('rkap_nama_upk u', 'u.id_upk = p.id_upk', 'left');
    //     $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = p.id_jp', 'left');
    //     $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
    //     $this->db->join('rkap_tarif_rata tr', 'tr.id_upk = p.id_upk AND tr.id_jp = p.id_jp AND tr.tahun = p.tahun', 'left');
    //     $this->db->join('rkap_jasa_tambahan jt', 'jt.id_upk = p.id_upk AND jt.id_jp = p.id_jp AND jt.tahun = p.tahun', 'left');

    //     $this->db->where('p.tahun', $tahun);
    //     $this->db->where('p.id_kd', 6); // sambungan akhir

    //     if ($upk) {
    //         $this->db->where('p.id_upk', $upk);
    //     }

    //     $this->db->order_by('jp.id_jp', 'ASC');
    //     $rows = $this->db->get()->result_array();

    //     $nama_upk = !empty($rows) ? $rows[0]['nama_upk'] : '';

    //     // struktur per jenis pelanggan
    //     $data = [];

    //     // temporary accumulators per jenis per bulan
    //     // we'll keep:
    //     // pelanggan_sum[b] = sum pelanggan
    //     // pola_num[b] = sum(pelanggan * konsumsi) -> for weighted avg
    //     // tarif_num[b] = sum(pelanggan * tarif) -> for weighted avg
    //     // penjualan_sum[b] = sum(pelanggan * konsumsi * tarif)
    //     // jasa_admin_sum[b] = sum(pelanggan * jasa_admin)
    //     // jasa_pem_sum[b] = sum(pelanggan * jasa_pemeliharaan)
    //     foreach ($rows as $r) {
    //         $jp = $r['nama_jp'] ?? 'LAINNYA';
    //         $bulan = (int)$r['bulan'];
    //         if ($bulan < 1 || $bulan > 12) $bulan = 1;

    //         if (!isset($data[$jp])) {
    //             $data[$jp] = [
    //                 'Pelanggan Akhir'   => array_fill(1, 12, 0),
    //                 'Pola Konsumsi'     => array_fill(1, 12, 0), // will fill weighted avg later
    //                 'Tarif Rata'        => array_fill(1, 12, 0), // will fill weighted avg later
    //                 'Penjualan Air'     => array_fill(1, 12, 0),
    //                 'Jasa Pemeliharaan' => array_fill(1, 12, 0),
    //                 'Jasa Administrasi' => array_fill(1, 12, 0),
    //                 'Tagihan Air'       => array_fill(1, 12, 0),
    //                 // internal accumulators:
    //                 '_acc' => [
    //                     'pel' => array_fill(1, 12, 0),
    //                     'pola_num' => array_fill(1, 12, 0),
    //                     'tarif_num' => array_fill(1, 12, 0),
    //                     'penjualan' => array_fill(1, 12, 0),
    //                     'jasa_admin' => array_fill(1, 12, 0),
    //                     'jasa_pem' => array_fill(1, 12, 0)
    //                 ]
    //             ];
    //         }

    //         $pel = (float)$r['pelanggan_akhir'];
    //         $pola = (float)$r['konsumsi_rata'];
    //         $tarif = (float)$r['tarif_rata'];
    //         $jp_jasa_pem = (float)$r['jasa_pemeliharaan'];
    //         $jp_jasa_adm = (float)$r['jasa_admin'];

    //         // per-row penjualan and jasa (note: jasa harus dikali jumlah pelanggan)
    //         $penjualan_row = $pel * $pola * $tarif;
    //         $jasa_pem_amount = $pel * $jp_jasa_pem;
    //         $jasa_adm_amount = $pel * $jp_jasa_adm;

    //         // accumulators
    //         $data[$jp]['_acc']['pel'][$bulan] += $pel;
    //         $data[$jp]['_acc']['pola_num'][$bulan] += $pel * $pola;
    //         $data[$jp]['_acc']['tarif_num'][$bulan] += $pel * $tarif;
    //         $data[$jp]['_acc']['penjualan'][$bulan] += $penjualan_row;
    //         $data[$jp]['_acc']['jasa_admin'][$bulan] += $jasa_adm_amount;
    //         $data[$jp]['_acc']['jasa_pem'][$bulan] += $jasa_pem_amount;
    //     }

    //     // finalize: compute weighted averages and totals per jenis per bulan
    //     $total = [
    //         'Pelanggan Akhir'   => array_fill(1, 12, 0),
    //         'Pola Konsumsi'     => array_fill(1, 12, 0),
    //         'Tarif Rata'        => array_fill(1, 12, 0),
    //         'Penjualan Air'     => array_fill(1, 12, 0),
    //         'Jasa Pemeliharaan' => array_fill(1, 12, 0),
    //         'Jasa Administrasi' => array_fill(1, 12, 0),
    //         'Tagihan Air'       => array_fill(1, 12, 0),
    //     ];
    //     foreach ($data as $jp => &$block) {
    //         for ($m = 1; $m <= 12; $m++) {
    //             $pel_sum = $block['_acc']['pel'][$m];
    //             // Pelanggan Akhir (jumlah)
    //             $block['Pelanggan Akhir'][$m] = (int) $pel_sum;

    //             // pola konsumsi = weighted avg (pel * pola) / pel_sum
    //             $block['Pola Konsumsi'][$m] = $pel_sum > 0 ? ($block['_acc']['pola_num'][$m] / $pel_sum) : 0;

    //             // tarif rata = weighted avg (pel * tarif) / pel_sum
    //             $block['Tarif Rata'][$m] = $pel_sum > 0 ? ($block['_acc']['tarif_num'][$m] / $pel_sum) : 0;

    //             // penjualan air (sum)
    //             $block['Penjualan Air'][$m] = $block['_acc']['penjualan'][$m];

    //             // jasa sums (already multiplied by pel)
    //             $block['Jasa Pemeliharaan'][$m] = $block['_acc']['jasa_pem'][$m];
    //             $block['Jasa Administrasi'][$m] = $block['_acc']['jasa_admin'][$m];

    //             // tagihan air
    //             $block['Tagihan Air'][$m] = $block['Penjualan Air'][$m] + $block['Jasa Pemeliharaan'][$m] + $block['Jasa Administrasi'][$m];

    //             // === akumulasi ke TOTAL ===
    //             $total['Pelanggan Akhir'][$m]   += $block['Pelanggan Akhir'][$m];
    //             $total['Pola Konsumsi'][$m]     += $block['Pola Konsumsi'][$m] * $block['Pelanggan Akhir'][$m]; // weighted
    //             $total['Tarif Rata'][$m]        += $block['Tarif Rata'][$m] * $block['Pelanggan Akhir'][$m];   // weighted
    //             $total['Penjualan Air'][$m]     += $block['Penjualan Air'][$m];
    //             $total['Jasa Pemeliharaan'][$m] += $block['Jasa Pemeliharaan'][$m];
    //             $total['Jasa Administrasi'][$m] += $block['Jasa Administrasi'][$m];
    //             $total['Tagihan Air'][$m]       += $block['Tagihan Air'][$m];
    //         }
    //         // drop internal accumulator to keep return clean
    //         unset($block['_acc']);
    //     }
    //     // hitung rata-rata konsumsi dan tarif
    //     for ($m = 1; $m <= 12; $m++) {
    //         $pel_sum = $total['Pelanggan Akhir'][$m];
    //         if ($pel_sum > 0) {
    //             $total['Pola Konsumsi'][$m] = $total['Pola Konsumsi'][$m] / $pel_sum;
    //             $total['Tarif Rata'][$m]    = $total['Tarif Rata'][$m] / $pel_sum;
    //         }
    //     }
    //     unset($r, $rows);

    //     // return $data;
    //     return [
    //         'nama_upk' => $nama_upk,
    //         'data'     => $data,
    //         'total'    => $total
    //     ];
    // }

    // private function getKodePerkiraan($id_upk)
    // {
    //     $mapping = [
    //         1  => ['penjualan' => '81.01.01.01', 'pemeliharaan' => '81.01.02.01', 'admin' => '81.01.03.01'], // Bondowoso
    //         2  => ['penjualan' => '81.01.01.02', 'pemeliharaan' => '81.01.02.02', 'admin' => '81.01.03.02'], // Sukosari 1
    //         3  => ['penjualan' => '81.01.01.03', 'pemeliharaan' => '81.01.02.03', 'admin' => '81.01.03.03'], // Maesan
    //         4  => ['penjualan' => '81.01.01.04', 'pemeliharaan' => '81.01.02.04', 'admin' => '81.01.03.04'], // Tegalampel
    //         5  => ['penjualan' => '81.01.01.05', 'pemeliharaan' => '81.01.02.05', 'admin' => '81.01.03.05'], // Tapen
    //         6  => ['penjualan' => '81.01.01.06', 'pemeliharaan' => '81.01.02.06', 'admin' => '81.01.03.06'], // Prajekan
    //         7  => ['penjualan' => '81.01.01.07', 'pemeliharaan' => '81.01.02.07', 'admin' => '81.01.03.07'], // Tlogosari
    //         8  => ['penjualan' => '81.01.01.08', 'pemeliharaan' => '81.01.02.08', 'admin' => '81.01.03.08'], // Wringin
    //         9  => ['penjualan' => '81.01.01.09', 'pemeliharaan' => '81.01.02.09', 'admin' => '81.01.03.09'], // Curahdami
    //         10 => ['penjualan' => '81.01.01.10', 'pemeliharaan' => '81.01.02.10', 'admin' => '81.01.03.10'], // Tamanan
    //         11 => ['penjualan' => '81.01.01.11', 'pemeliharaan' => '81.01.02.11', 'admin' => '81.01.03.11'], // Tenggarang
    //         12 => ['penjualan' => '81.01.01.12', 'pemeliharaan' => '81.01.02.12', 'admin' => '81.01.03.12'], // Tamankrocok
    //         13 => ['penjualan' => '81.01.01.13', 'pemeliharaan' => '81.01.02.13', 'admin' => '81.01.03.13'], // Wonosari
    //         14 => ['penjualan' => '81.01.01.14', 'pemeliharaan' => '81.01.02.14', 'admin' => '81.01.03.14'], // Klabang
    //         15 => ['penjualan' => '81.01.01.15', 'pemeliharaan' => '81.01.02.15', 'admin' => '81.01.03.15'], // Sukosari 2
    //     ];

    //     return $mapping[$id_upk] ?? null;
    // }

    public function getDataPenerimaanAirDistribusi($tahun, $upk = null)
    {
        // 1) ambil data Th Lalu dari tabel rkap_penerimaan_th_lalu
        $this->db->select("id_upk, id_jp, tahun, lembar_lalu, rupiah_lalu");
        $this->db->from("rkap_penerimaan_th_lalu");
        $this->db->where("tahun", $tahun);
        if ($upk) $this->db->where("id_upk", $upk);
        $thl_rows = $this->db->get()->result_array();

        // index th lalu by id_upk + id_jp
        $thl_map = [];
        foreach ($thl_rows as $r) {
            $key = $r['id_upk'] . '||' . $r['id_jp'];
            $thl_map[$key] = $r; // contains lembar_lalu, rupiah_lalu
        }

        // 2) ambil data tagihan aktual per jenis pelanggan dari fungsi existing Anda
        // getDataPendapatanAir mengembalikan 'data' => array per jenis pelanggan (nama_jp => block)
        // but we need id_jp as key; if your getDataPendapatanAir returns nama_jp as keys,
        // we will instead re-query tagihan per id_upk,id_jp,bulan OR adapt by matching nama_jp.
        // For safety, let's compute tagihan per id_upk,id_jp,bulan via query similar to getDataPendapatanAir's raw rows.

        $this->db->select("
        p.id_upk, p.id_jp, p.bulan,
        SUM(p.jumlah * COALESCE(pk.konsumsi_rata,0) * COALESCE(tr.tarif_rata,0)) 
            + SUM(COALESCE(jt.jasa_pemeliharaan,0) * p.jumlah)
            + SUM(COALESCE(jt.jasa_admin,0) * p.jumlah) AS tagihan
    ");
        $this->db->from("rkap_pelanggan p");
        $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
        $this->db->join('rkap_tarif_rata tr', 'tr.id_upk = p.id_upk AND tr.id_jp = p.id_jp AND tr.tahun = p.tahun', 'left');
        $this->db->join('rkap_jasa_tambahan jt', 'jt.id_upk = p.id_upk AND jt.id_jp = p.id_jp AND jt.tahun = p.tahun', 'left');
        $this->db->where("p.tahun", $tahun);
        if ($upk) $this->db->where("p.id_upk", $upk);
        $this->db->where("p.id_kd", 6); // sambungan akhir (sesuai model anda)
        $this->db->group_by(["p.id_upk", "p.id_jp", "p.bulan"]);
        $raw_tagihan_rows = $this->db->get()->result_array();

        // build tagihan_map[id_upk||id_jp][bulan] = tagihan
        $tagihan_map = [];
        foreach ($raw_tagihan_rows as $r) {
            $key = $r['id_upk'] . '||' . $r['id_jp'];
            $bulan = (int)$r['bulan'];
            $tagihan = (float)$r['tagihan'];
            if (!isset($tagihan_map[$key])) {
                $tagihan_map[$key] = array_fill(1, 12, 0.0);
            }
            $tagihan_map[$key][$bulan] = $tagihan;
        }

        // 3) Ambil daftar distinct pasangan id_upk + id_jp yang perlu ditampilkan (gabungan dari thl_map dan tagihan_map)
        $keys = [];
        foreach ($thl_map as $k => $_) $keys[$k] = true;
        foreach ($tagihan_map as $k => $_) $keys[$k] = true;
        $keys = array_keys($keys);

        // 4) untuk tiap pasangan, bangun struktur baris:
        //    - baris TH LALU (jika ada)
        //    - baris - Januari .. - Desember (tagihan per bulan) dengan distribusi penerimaan
        //    - baris "Jumlah <jenis>" (subtotal per jenis)
        $result = [];
        $overall_totals = array_fill(1, 12, 0.0);
        $overall_grand = 0.0;

        foreach ($keys as $k) {
            list($id_upk, $id_jp) = explode('||', $k);

            // inisialisasi struktur per jenis
            $jenis_block = [
                'id_upk' => $id_upk,
                'id_jp' => $id_jp,
                'rows' => [], // each row: ['label'=>..., 'lembar'=>..., 'tagihan'=>..., 'penerimaan'=>[1..12], 'total'=>...]
                'subtotal' => array_fill(1, 12, 0.0),
                'subtotal_total' => 0.0
            ];

            // ----- BARIS 1: TH LALU (jika ada) -----
            if (isset($thl_map[$k])) {
                $r = $thl_map[$k];
                $rup = (float)$r['rupiah_lalu'];
                $lem = (int)$r['lembar_lalu'];

                $row = [
                    'label' => 'Th Lalu',
                    'lembar' => $lem,
                    'tagihan' => $rup,
                    'penerimaan' => array_fill(1, 12, 0.0),
                    'total' => $rup
                ];

                // distribusi Th Lalu:
                // Jan = 70%; Feb..Nov = (30% / 10); Des = 0
                $row['penerimaan'][1] = round($rup * 0.70, 2);
                $share = round(($rup * 0.30) / 10, 2);
                for ($m = 2; $m <= 11; $m++) {
                    $row['penerimaan'][$m] = $share;
                }
                $row['penerimaan'][12] = 0.0;

                // add into subtotal and overall totals
                for ($m = 1; $m <= 12; $m++) {
                    $jenis_block['subtotal'][$m] += $row['penerimaan'][$m];
                    $overall_totals[$m] += $row['penerimaan'][$m];
                }
                $jenis_block['subtotal_total'] += $row['total'];
                $overall_grand += $row['total'];

                $jenis_block['rows'][] = $row;
            }

            // ----- BARIS 2..13: Tagihan bulan Januari..Desember (data aktual) -----
            // For each month m, create a row: label "- <MonthName>" with tagihan for that month,
            // and penerimaan distributed as: if m == 12 => all zeros (kosong);
            // else penerimaan[m+1] += 0.9*tagihan; if m+2<=12 then penerimaan[m+2]+=0.1*tagihan;
            for ($m = 1; $m <= 12; $m++) {
                $tag = isset($tagihan_map[$k][$m]) ? (float)$tagihan_map[$k][$m] : 0.0;
                $row = [
                    'label' => date('F', mktime(0, 0, 0, $m, 1)), // english month name; you can map to Indonesian if needed
                    'lembar' => null, // Anda dapat isi jika ada data lembar per bulan
                    'tagihan' => $tag,
                    'penerimaan' => array_fill(1, 12, 0.0),
                    'total' => 0.0
                ];

                if ($tag > 0 && $m < 12) {
                    // distribusi untuk bulan m (1..11)
                    $p1m = round($tag * 0.90, 2); // bulan m+1
                    $p2m = round($tag * 0.10, 2); // bulan m+2 (jika ada)
                    $row['penerimaan'][$m + 1] += $p1m;
                    if ($m + 2 <= 12) {
                        $row['penerimaan'][$m + 2] += $p2m;
                    }
                    // total penerimaan baris = p1m + p2m (atau only p1m if m+2>12)
                    $row['total'] = $p1m + ($m + 2 <= 12 ? $p2m : 0.0);
                } else {
                    // m == 12 => kosongi semua (tagihan dipasang di kolom Tagihan tapi penerimaan kosong)
                    $row['total'] = 0.0;
                }

                // tambahkan ke subtotal / overall
                for ($mm = 1; $mm <= 12; $mm++) {
                    $jenis_block['subtotal'][$mm] += $row['penerimaan'][$mm];
                    $overall_totals[$mm] += $row['penerimaan'][$mm];
                }
                $jenis_block['subtotal_total'] += $row['total'];
                $overall_grand += $row['total'];

                $jenis_block['rows'][] = $row;
            }

            // ----- BARIS JUMLAH per jenis -----
            $jenis_block['rows'][] = [
                'label' => 'Jumlah',
                'lembar' => null,
                'tagihan' => null,
                'penerimaan' => $jenis_block['subtotal'],
                'total' => $jenis_block['subtotal_total']
            ];
            $result[] = $jenis_block;
        }

        return [
            'per_jenis' => $result,
            'overall_totals' => $overall_totals,
            'overall_grand' => $overall_grand
        ];
    }

    // data penerimaan tahun lalu
    public function insert_tahun_lalu($data)
    {
        return $this->db->insert('rkap_penerimaan_th_lalu', $data);
    }

    public function cek_tahun_lalu($id_upk, $id_jp, $tahun)
    {
        return $this->db->get_where('rkap_penerimaan_th_lalu', [
            'id_upk' => $id_upk,
            'id_jp' => $id_jp,
            'tahun' => $tahun
        ])->num_rows() > 0;
    }

    public function get_tahun_lalu($tahun, $upk = null)
    {
        $this->db->select('
            a.*, 
            u.nama_upk, 
            j.nama_jp
        ');
        $this->db->from('rkap_penerimaan_th_lalu a');
        $this->db->join('rkap_nama_upk u', 'a.id_upk = u.id_upk', 'left');
        $this->db->join('rkap_jenis_plgn j', 'a.id_jp = j.id_jp', 'left');
        $this->db->where('a.tahun', $tahun);

        if ($upk) {
            $this->db->where('a.id_upk', $upk);
        }

        return $this->db->get()->result();
    }

    public function get_tahun_lalu_by_id($id)
    {
        $this->db->select('a.*, u.nama_upk, j.nama_jp');
        $this->db->from('rkap_penerimaan_th_lalu a');
        $this->db->join('rkap_nama_upk u', 'a.id_upk = u.id_upk', 'left');
        $this->db->join('rkap_jenis_plgn j', 'a.id_jp = j.id_jp', 'left');
        $this->db->where('a.id', $id);
        return $this->db->get()->row();
    }

    public function update_tahun_lalu($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('rkap_penerimaan_th_lalu', $data);
    }
}
