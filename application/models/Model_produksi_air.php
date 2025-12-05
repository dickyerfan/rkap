<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_produksi_air extends CI_Model
{

    // public function getDataProduksiAir($tahun, $upk = null)
    // {
    //     // ======================
    //     // 1️⃣ AIR TERJUAL
    //     // ======================
    //     $this->db->select("
    //     jp.nama_jp,
    //     p.bulan,
    //     SUM(p.jumlah) AS pelanggan_akhir,
    //     COALESCE(SUM(p.jumlah * pk.konsumsi_rata) / NULLIF(SUM(p.jumlah),0), 0) AS pola_konsumsi
    // ");
    //     $this->db->from('rkap_pelanggan p');
    //     $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = p.id_jp', 'left');
    //     $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
    //     $this->db->where('p.tahun', $tahun);
    //     $this->db->where('p.id_kd', 6); // hanya pelanggan akhir
    //     if ($upk) {
    //         $this->db->where('p.id_upk', $upk);
    //     }

    //     $this->db->group_by(['jp.nama_jp', 'p.bulan']);
    //     $this->db->order_by('jp.id_jp, p.bulan', 'ASC');
    //     $rows = $this->db->get()->result_array();

    //     $air_terjual = [];
    //     $total_air_terjual = 0;
    //     foreach ($rows as $r) {
    //         $jp = $r['nama_jp'] ?? 'LAINNYA';
    //         $bulan = (int)$r['bulan'];
    //         if (!isset($air_terjual[$jp])) {
    //             $air_terjual[$jp] = array_fill(1, 12, 0);
    //         }

    //         $pelanggan = (float)$r['pelanggan_akhir'];
    //         $pola = (float)$r['pola_konsumsi'];
    //         $hasil = $pelanggan * $pola;

    //         $air_terjual[$jp][$bulan] = $hasil;
    //         $total_air_terjual += $hasil;
    //     }

    //     // isi bulan kosong supaya lengkap 12 bulan
    //     foreach ($air_terjual as &$bulanData) {
    //         for ($m = 1; $m <= 12; $m++) {
    //             if (!isset($bulanData[$m])) $bulanData[$m] = 0;
    //         }
    //     }

    //     // ======================
    //     // 2️⃣ AMBIL SUMBER AIR
    //     // ======================
    //     $this->db->from('rkap_sumber');
    //     $this->db->where('tahun', $tahun);
    //     if ($upk) $this->db->where('id_upk', $upk);
    //     $sumber = $this->db->get()->result_array();

    //     // ======================
    //     // 3️⃣ HITUNG AIR PRODUKSI
    //     // ======================
    //     $air_produksi = [];
    //     if (count($sumber) == 1) {
    //         // jika hanya satu sumber, ambil 100%
    //         $produksi_total = $total_air_terjual * 100 / 80; // contoh 80% efisiensi
    //         $air_produksi[] = [
    //             'uraian' => $sumber[0]['uraian'],
    //             'persen' => 100,
    //             'produksi_total' => $produksi_total
    //         ];
    //     } elseif (count($sumber) > 1) {
    //         // jika lebih dari satu sumber
    //         $total_nilai = array_sum(array_column($sumber, 'nilai'));
    //         if ($total_nilai > 0) {
    //             foreach ($sumber as $sb) {
    //                 $persen = round(($sb['nilai'] / $total_nilai) * 100, 2);
    //                 $produksi_sb = ($total_air_terjual * 100 / 80) * $persen / 100;
    //                 $air_produksi[] = [
    //                     'uraian' => $sb['uraian'],
    //                     'persen' => $persen,
    //                     'produksi_total' => $produksi_sb
    //                 ];
    //             }
    //         }
    //     }

    //     // ======================
    //     // 4️⃣ NAMA UPK
    //     // ======================
    //     if ($upk) {
    //         $nama_upk = $this->db
    //             ->select('nama_upk')
    //             ->where('id_upk', $upk)
    //             ->get('rkap_nama_upk')
    //             ->row('nama_upk');
    //     } else {
    //         $nama_upk = 'KONSOLIDASI';
    //     }

    //     // ======================
    //     // 5️⃣ RETURN
    //     // ======================
    //     return [
    //         'nama_upk' => $nama_upk,
    //         'air_terjual' => $air_terjual,
    //         'air_produksi' => $air_produksi
    //     ];
    // }


    // kode ini hampir betul
    public function getDataProduksiAir($tahun, $upk = null)
    {
        // ======================
        // 1️⃣ AIR TERJUAL
        // ======================
        $this->db->select("
        jp.nama_jp,
        p.bulan,
        SUM(p.jumlah) AS pelanggan_akhir,
        COALESCE(SUM(p.jumlah * pk.konsumsi_rata) / NULLIF(SUM(p.jumlah),0), 0) AS pola_konsumsi
    ");
        $this->db->from('rkap_pelanggan p');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = p.id_jp', 'left');
        $this->db->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left');
        $this->db->where('p.tahun', $tahun);
        $this->db->where('p.id_kd', 6); // hanya pelanggan akhir

        // filter UPK jika ada
        if (!empty($upk) && strtolower($upk) !== 'all') {
            $this->db->where('p.id_upk', $upk);
        }
        $this->db->group_by(['jp.nama_jp', 'p.bulan']);
        $this->db->order_by('jp.id_jp, p.bulan', 'ASC');
        $rows = $this->db->get()->result_array();

        $air_terjual = [];
        $total_air_terjual = 0;
        foreach ($rows as $r) {
            $jp = $r['nama_jp'] ?? 'LAINNYA';
            $bulan = (int)$r['bulan'];
            if (!isset($air_terjual[$jp])) {
                $air_terjual[$jp] = array_fill(1, 12, 0);
            }

            $pelanggan = (float)$r['pelanggan_akhir'];
            $pola = (float)$r['pola_konsumsi'];
            $hasil = $pelanggan * $pola;

            $air_terjual[$jp][$bulan] = $hasil;
            $total_air_terjual += $hasil;
        }

        // isi bulan kosong supaya lengkap 12 bulan
        foreach ($air_terjual as &$bulanData) {
            for ($m = 1; $m <= 12; $m++) {
                if (!isset($bulanData[$m])) $bulanData[$m] = 0;
            }
        }

        // ======================
        // 2️⃣ AMBIL SUMBER AIR
        // ======================
        $this->db->from('rkap_sumber');
        $this->db->where('tahun', $tahun);
        if (!empty($upk) && strtolower($upk) !== 'all') {
            $this->db->where('id_upk', $upk);
        }
        $sumber = $this->db->get()->result_array();

        // Jika data sumber tidak ditemukan di level UPK, fallback ke data konsolidasi
        if (empty($sumber) && !empty($upk) && strtolower($upk) !== 'all') {
            $this->db->from('rkap_sumber');
            $this->db->where('tahun', $tahun);
            $sumber = $this->db->get()->result_array();
        }

        // ======================
        // 3️⃣ HITUNG AIR PRODUKSI
        // ======================
        $air_produksi = [];
        if (count($sumber) == 1) {
            // jika hanya satu sumber, ambil 100%
            $produksi_total = $total_air_terjual * 100 / 80; // contoh efisiensi 80%
            $air_produksi[] = [
                'uraian' => $sumber[0]['uraian'],
                'persen' => 100.00,
                'produksi_total' => $produksi_total
            ];
        } elseif (count($sumber) > 1) {
            // jika lebih dari satu sumber
            $total_nilai = array_sum(array_column($sumber, 'nilai'));
            if ($total_nilai > 0) {
                foreach ($sumber as $sb) {
                    $persen = round(($sb['nilai'] / $total_nilai) * 100, 2);
                    $produksi_sb = ($total_air_terjual * 100 / 80) * $persen / 100;
                    $air_produksi[] = [
                        'uraian' => $sb['uraian'],
                        'persen' => $persen,
                        'produksi_total' => $produksi_sb
                    ];
                }
            }
        }

        // ======================
        // 4️⃣ NAMA UPK
        // ======================
        if (!empty($upk) && strtolower($upk) !== 'all') {
            $nama_upk = $this->db
                ->select('nama_upk')
                ->where('id_upk', $upk)
                ->get('rkap_nama_upk')
                ->row('nama_upk');
        } else {
            $nama_upk = 'KONSOLIDASI';
        }

        // ======================
        // 4️⃣ NAMA UPK & REKAP KONSOLIDASI
        // ======================
        if (!empty($upk) && strtolower($upk) !== 'all') {
            $nama_upk = $this->db
                ->select('nama_upk')
                ->where('id_upk', $upk)
                ->get('rkap_nama_upk')
                ->row('nama_upk');
        } else {
            // 🔹 Ambil semua UPK
            $list_upk = $this->db->get('rkap_nama_upk')->result_array();
            $air_produksi = [];

            foreach ($list_upk as $u) {
                $id_upk = $u['id_upk'];
                $nama_upk_item = $u['nama_upk'];

                // Hitung total pelanggan akhir dan pola konsumsi per UPK
                $sub = $this->db->select("
            SUM(p.jumlah) AS pelanggan_akhir,
            COALESCE(SUM(p.jumlah * pk.konsumsi_rata) / NULLIF(SUM(p.jumlah),0), 0) AS pola_konsumsi
        ")
                    ->from('rkap_pelanggan p')
                    ->join('rkap_pola_konsumsi pk', 'pk.id_upk = p.id_upk AND pk.id_jp = p.id_jp AND pk.tahun = p.tahun', 'left')
                    ->where('p.tahun', $tahun)
                    ->where('p.id_kd', 6)
                    ->where('p.id_upk', $id_upk)
                    ->get()->row_array();

                $pelanggan = (float)$sub['pelanggan_akhir'];
                $pola = (float)$sub['pola_konsumsi'];
                $hasil = $pelanggan * $pola;

                if ($hasil > 0) {
                    // ambil sumber air
                    $sumber = $this->db->from('rkap_sumber')
                        ->where('tahun', $tahun)
                        ->where('id_upk', $id_upk)
                        ->get()->result_array();

                    $total_nilai = array_sum(array_column($sumber, 'nilai'));
                    $produksi_total = 0;
                    if ($total_nilai > 0) {
                        foreach ($sumber as $sb) {
                            $persen = round(($sb['nilai'] / $total_nilai) * 100, 2);
                            $produksi_total += ($hasil * 100 / 80) * $persen / 100;
                        }
                    } else {
                        $produksi_total = $hasil * 100 / 80; // fallback 80%
                    }

                    $air_produksi[] = [
                        'uraian' => strtoupper($nama_upk_item),
                        'persen' => 100,
                        'produksi_total' => $produksi_total
                    ];
                }
            }

            $nama_upk = 'KONSOLIDASI';
        }

        // ======================
        // 5️⃣ RETURN
        // ======================
        return [
            'nama_upk' => $nama_upk,
            'air_terjual' => $air_terjual,
            'air_produksi' => $air_produksi
        ];
    }

    public function getDataSumber($tahun, $upk = null)
    {
        $this->db->from('rkap_sumber sb');
        $this->db->join('rkap_nama_upk nu', 'nu.id_upk = sb.id_upk', 'left');
        $this->db->where('sb.tahun', $tahun);
        if ($upk) {
            $this->db->where('sb.id_upk', $upk);
        }
        return $this->db->get()->result_array();
    }

    // public function get_produksi($id_upk, $tahun)
    // {
    //     // Ambil semua sumber air untuk UPK & tahun ini
    //     $sumber = $this->db->where('id_upk', $id_upk)
    //         ->where('tahun', $tahun)
    //         ->get('rkap_sumber')
    //         ->result_array();

    //     $total_air_terjual = $this->get_total_air_terjual($id_upk, $tahun); // ambil dari fungsi air terjual

    //     // Jika hanya 1 sumber air
    //     if (count($sumber) == 1) {
    //         $produksi = $total_air_terjual * 100 / 80;
    //         return [
    //             [
    //                 'uraian' => $sumber[0]['uraian'],
    //                 'produksi' => $produksi
    //             ]
    //         ];
    //     }

    //     // Jika lebih dari 1 sumber air
    //     $total_nilai = array_sum(array_column($sumber, 'nilai'));
    //     $hasil = [];

    //     foreach ($sumber as $row) {
    //         $persen = round(($row['nilai'] / $total_nilai) * 100, 2);
    //         $produksi_sb = $total_air_terjual * $persen / 100;

    //         $hasil[] = [
    //             'uraian' => $row['uraian'],
    //             'persen' => $persen,
    //             'produksi' => $produksi_sb
    //         ];
    //     }

    //     return $hasil;
    // }
}
