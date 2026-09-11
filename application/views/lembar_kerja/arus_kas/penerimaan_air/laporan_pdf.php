<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            margin: 20pt 20pt 30pt 80pt;
        }

        header table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        header td {
            border: none;
            padding: 2px;
            vertical-align: middle;
        }

        header p {
            margin: 0;
            font-size: 10pt;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        .title {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 6px 0;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
            font-size: 6.5pt;
        }

        table.data-table th {
            text-align: center;
            font-weight: bold;
        }

        table.data-table td.num {
            text-align: right;
        }

        table.data-table td.num-bold {
            text-align: right;
            font-weight: bold;
        }

        table.data-table td.center {
            text-align: center;
        }

        table.data-table tfoot td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 2px solid #6c757d;
        }
    </style>

</head>

<body>
    <header>
        <table>
            <tr>
                <td width="40">
                    <?php
                    $logo_path = FCPATH . 'assets/img/tirta.png';
                    if (file_exists($logo_path)) :
                        $logo_data = base64_encode(file_get_contents($logo_path));
                        $logo_mime = mime_content_type($logo_path);
                    ?>
                        <img src="data:<?= $logo_mime; ?>;base64,<?= $logo_data; ?>" alt="Logo" width="40">
                    <?php endif; ?>
                </td>
                <td>
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <?php
        // helper format
        function rupiah($v)
        {
            return $v !== null && $v != 0 ? number_format((float)$v, 0, ',', '.') : '-';
        }
        function fmt_int($v)
        {
            return $v !== null && $v != 0 ? number_format((int)$v) : '-';
        }

        // bulan bahasa Indonesia (index 1..12)
        $bulan_ind = [
            1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'
        ];

        // buat map nama bulan english -> index (karena model membuat label date('F'))
        $bulan_en_map = [
            'January' => 1, 'February' => 2, 'March' => 3, 'April' => 4, 'May' => 5, 'June' => 6,
            'July' => 7, 'August' => 8, 'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12
        ];

        // ambil $per_jenis, $overall_totals, $overall_grand, $tahun, $upk dari controller
        // jika tidak ada validasi, set default
        $per_jenis = isset($per_jenis) ? $per_jenis : [];
        $overall_totals = isset($overall_totals) ? $overall_totals : array_fill(1, 12, 0.0);
        $overall_grand = isset($overall_grand) ? $overall_grand : 0.0;
        $tahun = isset($tahun) ? $tahun : date('Y');
        $upk = isset($upk) ? $upk : null;

        // KODE BARU: efisiensi penagihan dari Target UPK (dikirim controller).
        // Default 100% ==> bila tidak ada data/tahun lama, hasil = seperti kode lama.
        $efi_efektif = isset($efi_efektif) ? $efi_efektif : array_fill(1, 12, 100.0);
        $efi_thl_efektif = isset($efi_thl_efektif) ? $efi_thl_efektif : 100.0;

        // pengaturan distribusi persentase (dikirim controller utk tahun >= 2027)
        // default tagihan 100/0 (penuh bulan berikutnya), Th Lalu 90/10.
        $dist_tagihan = isset($dist_tagihan) ? $dist_tagihan : ['p1' => 1.00, 'p2' => 0.00];
        $dist_thl     = isset($dist_thl) ? $dist_thl : ['p1' => 0.90, 'p2' => 0.10];

        // penanda metode: true = kode baru (efisiensi), false = kode lama
        $pakai_efisiensi = isset($pakai_efisiensi) ? (bool)$pakai_efisiensi : false;

        // judul dinamis
        $judul_upk = 'KONSOLIDASI';
        if ($upk) {
            $rowupk = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
            if ($rowupk) $judul_upk = strtoupper($rowupk->nama_upk);
        }

        // --- ambil lembar per bulan dari tabel rkap_pelanggan (sum p.jumlah) ---
        // key: lembar_map[id_jp][bulan] = jumlah
        $lembar_map = [];
        $this->db->select("p.id_jp, p.bulan, SUM(p.jumlah) AS lembar_sum");
        $this->db->from("rkap_pelanggan p");
        $this->db->where("p.tahun", $tahun);
        $this->db->where("p.id_kd", 6);
        if ($upk) $this->db->where("p.id_upk", $upk);
        $this->db->group_by(["p.id_jp", "p.bulan"]);
        $lm_rows = $this->db->get()->result_array();
        foreach ($lm_rows as $r) {
            $id_jp = $r['id_jp'];
            $bulan = (int)$r['bulan'];
            $lembar_map[$id_jp][$bulan] = (int)$r['lembar_sum'];
        }

        // --- sekarang aggregate per jenis (id_jp) ---
        // per_jenis currently keyed by id_upk||id_jp; we will aggregate by id_jp if $upk empty,
        // otherwise show only entries for that upk but still ensure single jenis tampil (id_jp unique)

        $aggregate = []; // key id_jp => aggregated block

        foreach ($per_jenis as $block) {
            // block contains 'id_upk', 'id_jp', 'rows' (including Th Lalu and month rows and 'Jumlah' possibly)
            $id_jp = $block['id_jp'];
            if (!$id_jp) continue;

            if (!isset($aggregate[$id_jp])) {
                // init
                $aggregate[$id_jp] = [
                    'id_jp' => $id_jp,
                    'nama_jp' => $this->db->get_where('rkap_jenis_plgn', ['id_jp' => $id_jp])->row()->nama_jp ?? 'LAINNYA',
                    'thl_lembar' => 0,
                    'thl_rupiah' => 0.0,
                    'penerimaan' => array_fill(1, 12, 0.0), // aggregated penerimaan per month (from th lalu + distribusi tagihan)
                    'tagihan_per_month' => array_fill(1, 12, 0.0), // total tagihan per month (sum)
                    'lembar_per_month' => array_fill(1, 12, 0), // will fill from lembar_map
                    'total_penerimaan' => 0.0
                ];
            }

            // iterate rows and accumulate (skip rows with label == 'Jumlah')
            foreach ($block['rows'] as $r) {
                $label = $r['label'];
                if (strtolower(trim($label)) === 'jumlah') {
                    // ignore precomputed 'Jumlah' row from model to prevent double
                    continue;
                }

                if (strtolower(trim($label)) === strtolower('Th Lalu') || strtolower(trim($label)) === 'th lalu') {
                    // accumulate th lalu
                    $aggregate[$id_jp]['thl_lembar'] += (int)($r['lembar'] ?? 0);
                    $aggregate[$id_jp]['thl_rupiah'] += (float)($r['tagihan'] ?? 0.0);
                    // add penerimaan distribution (r['penerimaan'] is an array 1..12)
                    if (!empty($r['penerimaan']) && is_array($r['penerimaan'])) {
                        for ($m = 1; $m <= 12; $m++) {
                            $aggregate[$id_jp]['penerimaan'][$m] += (float)($r['penerimaan'][$m] ?? 0.0);
                        }
                    }
                    $aggregate[$id_jp]['total_penerimaan'] += (float)($r['total'] ?? 0.0);
                } else {
                    // likely month row (label = English month name or Indonesian)
                    // try to map to month index
                    $idx = null;
                    $labtrim = trim($label);
                    // check english map
                    if (isset($bulan_en_map[$labtrim])) {
                        $idx = $bulan_en_map[$labtrim];
                    } else {
                        // check Indonesian names
                        $lower = strtolower($labtrim);
                        foreach ($bulan_ind as $k => $v) {
                            if (strtolower($v) === $lower || strtolower(substr($v, 0, 3)) === $lower) {
                                $idx = $k;
                                break;
                            }
                        }
                    }
                    if ($idx === null) {
                        // unknown label, skip
                        continue;
                    }

                    // accumulate tagihan (for that month)
                    $aggregate[$id_jp]['tagihan_per_month'][$idx] += (float)($r['tagihan'] ?? 0.0);

                    // penerimaan array: this row has penerimaan distributed to future months
                    if (!empty($r['penerimaan']) && is_array($r['penerimaan'])) {
                        for ($m = 1; $m <= 12; $m++) {
                            $aggregate[$id_jp]['penerimaan'][$m] += (float)($r['penerimaan'][$m] ?? 0.0);
                        }
                    }
                    $aggregate[$id_jp]['total_penerimaan'] += (float)($r['total'] ?? 0.0);
                }
            }
        }

        // fill lembar_per_month from lembar_map (note: lembar_map keyed by id_jp)
        foreach ($aggregate as $id_jp => &$ag) {
            for ($m = 1; $m <= 12; $m++) {
                $ag['lembar_per_month'][$m] = isset($lembar_map[$id_jp][$m]) ? (int)$lembar_map[$id_jp][$m] : 0;
            }
        }
        unset($ag);

        // if not memilih upk, we have already aggregated across all per_jenis passed by controller.
        // But in case per_jenis still had separate per UPK entries, above loop already summed them into $aggregate by id_jp

        // prepare grand totals from aggregate
        $grand_per_month = array_fill(1, 12, 0.0);
        $grand_sum_total = 0.0;
        foreach ($aggregate as $id_jp => $ag) {
            for ($m = 1; $m <= 12; $m++) {
                $grand_per_month[$m] += $ag['penerimaan'][$m];
            }
            $grand_sum_total += $ag['total_penerimaan'];
        }

        ?>
        <p class="title">
            RENCANA PENERIMAAN TAGIHAN REKENING AIR<br>
            <?= $judul_upk . " - TAHUN ANGGARAN " . $tahun ?>
        </p>
        <table class="data-table">
            <thead>
                <tr style="background-color:#f8f9fa;">
                    <th rowspan="2" style="width:100px">URAIAN</th>
                    <th rowspan="2" style="width:40px">Lbr</th>
                    <th rowspan="2" style="width:70px">Rp</th>
                    <th colspan="12">PENERIMAAN (Rp)</th>
                    <th rowspan="2" style="width:70px">JUMLAH</th>
                </tr>
                <tr style="background-color:#f8f9fa;">
                    <?php foreach ($bulan_ind as $b) : ?>
                        <th style="width:50px;" class="center"><?= $b ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($aggregate)) : ?>
                    <tr>
                        <td colspan="16" class="center">-- Tidak ada data --</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($aggregate as $id_jp => $ag) : ?>
                        <tr style="background-color:#cce5ff;font-weight:bold;">
                            <td colspan="16"><?= strtoupper($ag['nama_jp']) ?></td>
                        </tr>

                        <!-- Baris Th Lalu -->
                        <tr>
                            <td>&nbsp;&nbsp;- Th Lalu</td>
                            <td class="num"><?= fmt_int($ag['thl_lembar']) ?></td>
                            <td class="num"><?= $ag['thl_rupiah'] ? rupiah($ag['thl_rupiah']) : '-' ?></td>

                            <?php
                            $rupiah_lalu = (float)$ag['thl_rupiah'];
                            $penerimaan_th_lalu = array_fill(1, 12, 0.0);

                            // ============ KODE LAMA (tanpa efisiensi penagihan) ============
                            // if ($rupiah_lalu > 0) {
                            //     $penerimaan_th_lalu[1] = round($rupiah_lalu * 0.70, 2); // Januari
                            //     $sisa = $rupiah_lalu * 0.30;
                            //     $per_bulan = round($sisa / 10, 2);
                            //     for ($m = 2; $m <= 11; $m++) {
                            //         $penerimaan_th_lalu[$m] = $per_bulan;
                            //     }
                            //     // Desember = 0
                            // }
                            //
                            // $total_th_lalu = array_sum($penerimaan_th_lalu);
                            // ============ END KODE LAMA ============

                            // ============ KODE BARU (tahun >= 2027) ============
                            // Sisa piutang Th Lalu dibagi sesuai $dist_thl (default
                            // 90% di JANUARI dan 10% di FEBRUARI), masing-masing
                            // dikurangi RATA-RATA efi_tagih Jan-Des (efi_thl_efektif).
                            if ($pakai_efisiensi) {
                                $penerimaan_th_lalu[1] = round($rupiah_lalu * $dist_thl['p1'] * ($efi_thl_efektif / 100.0), 2); // Januari
                                $penerimaan_th_lalu[2] = round($rupiah_lalu * $dist_thl['p2'] * ($efi_thl_efektif / 100.0), 2); // Februari
                                // bulan lain = 0
                            } else {
                                // ===== KODE LAMA (tahun 2026 ke bawah) =====
                                // 70% di Januari, sisanya (30%) dibagi rata Feb-Nov.
                                // Hasilnya sudah pernah dicetak, tidak boleh berubah.
                                if ($rupiah_lalu > 0) {
                                    $penerimaan_th_lalu[1] = round($rupiah_lalu * 0.70, 2); // Januari
                                    $sisa = $rupiah_lalu * 0.30;
                                    $per_bulan = round($sisa / 10, 2);
                                    for ($m = 2; $m <= 11; $m++) {
                                        $penerimaan_th_lalu[$m] = $per_bulan;
                                    }
                                    // Desember = 0
                                }
                                // ===== END KODE LAMA =====
                            }

                            $total_th_lalu = array_sum($penerimaan_th_lalu);
                            // ============ END KODE BARU ============
                            ?>

                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                <td class="num">
                                    <?= $penerimaan_th_lalu[$m] != 0 ? rupiah($penerimaan_th_lalu[$m]) : '-' ?>
                                </td>
                            <?php endfor; ?>

                            <td class="num-bold"><?= rupiah($total_th_lalu) ?></td>
                        </tr>

                        <!-- Baris Januari..Desember (lembar dari rkap_pelanggan, tagihan dari aggregated tagihan_per_month) -->
                        <?php for ($m = 1; $m <= 12; $m++) :
                            $label = $bulan_ind[$m];
                            $lembar = $ag['lembar_per_month'][$m] ?? 0;
                            $tagihan = $ag['tagihan_per_month'][$m] ?? 0.0;
                            $penerimaan_row = array_fill(1, 12, 0.0);

                            // ============ KODE LAMA (tanpa efisiensi penagihan) ============
                            // if ($tagihan > 0 && $m < 12) {
                            //     $p1 = round($tagihan * 0.90, 2);
                            //     $p2 = round($tagihan * 0.10, 2);
                            //     $penerimaan_row[$m + 1] += $p1;
                            //     if ($m + 2 <= 12) $penerimaan_row[$m + 2] += $p2;
                            //     $row_total = $p1 + ($m + 2 <= 12 ? $p2 : 0.0);
                            // } else {
                            //     // m == 12 or tagihan == 0
                            //     $row_total = 0.0;
                            // }
                            // ============ END KODE LAMA ============

                            // ============ KODE BARU ============
                            // Tahun >= 2027 : tagihan dikurangi efisiensi penagihan
                            // bulan tsb (efi_efektif[$m]) lalu dibagi sesuai
                            // $dist_tagihan (default 90% bulan B+1 / 10% bulan B+2).
                            // Kolom Rp tetap menampilkan tagihan penuh (yang ditagih).
                            if ($pakai_efisiensi) {
                                $tagihan_ef = $tagihan * ($efi_efektif[$m] / 100.0);
                                $p1 = round($tagihan_ef * $dist_tagihan['p1'], 2);
                                $p2 = round($tagihan_ef * $dist_tagihan['p2'], 2);
                            } else {
                                // KODE LAMA (tahun 2026 ke bawah) : 90/10 tanpa efisiensi.
                                // Nilainya TETAP seperti kode lama (tidak berubah).
                                $p1 = round($tagihan * 0.90, 2);
                                $p2 = round($tagihan * 0.10, 2);
                            }
                            if ($tagihan > 0 && $m < 12) {
                                $penerimaan_row[$m + 1] += $p1;
                                if ($m + 2 <= 12) $penerimaan_row[$m + 2] += $p2;
                                $row_total = $p1 + ($m + 2 <= 12 ? $p2 : 0.0);
                            } else {
                                // m == 12 or tagihan == 0
                                $row_total = 0.0;
                            }
                            // ============ END KODE BARU ============
                        ?>
                            <tr>
                                <td>&nbsp;&nbsp;- <?= $label ?></td>
                                <td class="num"><?= $lembar ? number_format($lembar) : '-' ?></td>
                                <td class="num"><?= $tagihan ? rupiah($tagihan) : '-' ?></td>
                                <?php for ($mm = 1; $mm <= 12; $mm++) : ?>
                                    <td class="num">
                                        <?= $penerimaan_row[$mm] != 0 ? rupiah($penerimaan_row[$mm]) : '-' ?>
                                    </td>
                                <?php endfor; ?>
                                <td class="num"><?= $row_total != 0 ? rupiah($row_total) : '-' ?></td>
                            </tr>
                        <?php endfor; ?>

                        <!-- Baris Jumlah per jenis -->
                        <tr style="font-weight:bold;background-color:#e9ecef;">
                            <td>Jumlah <?= $ag['nama_jp'] ?></td>
                            <td>-</td>
                            <td>-</td>
                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                <td class="num"><?= rupiah($ag['penerimaan'][$m]) ?></td>
                            <?php endfor; ?>
                            <td class="num"><?= rupiah($ag['total_penerimaan']) ?></td>
                        </tr>

                    <?php endforeach; ?>

                    <!-- TOTAL SEMUA JENIS -->
                    <tr style="font-weight:bold;background-color:#cff4fc;">
                        <td>TOTAL </td>
                        <td>-</td>
                        <td>-</td>
                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                            <td class="num"><?= rupiah($grand_per_month[$m]) ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= rupiah($grand_sum_total) ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($upk == '') : ?>
            <p class="title">PENERIMAAN AIR LAINNYA</p>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>URAIAN</th>
                        <th>Jan</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Apr</th>
                        <th>Mei</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Agu</th>
                        <th>Sep</th>
                        <th>Okt</th>
                        <th>Nov</th>
                        <th>Des</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $uraian_list = [
                        'penggunaan_rata2' => 'Jumlah Penggunaan rata2',
                        'm3_rata2' => 'Jumlah M3 rata2',
                        'tarif_rata2' => 'Tarif rata2'
                    ];

                    foreach ($uraian_list as $key => $label) :
                        if (isset($tangki_air[$key])) :
                            $is_nilai_penjualan = ($key == 'nilai_penjualan');
                    ?>
                            <!-- <tr>
                                                    <td style="padding-left: 27px;"><?= $is_nilai_penjualan ? "<strong>{$label}</strong>" : $label; ?></td>
                                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                        <td class="num">
                                                            <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="num">
                                                        <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key]['total'], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key]['total'], 0, ',', '.'); ?>
                                                    </td>
                                                </tr> -->
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
                <tfoot>
                    <tr style="background:#eee;font-weight:bold;">
                        <td>Penerimaan Air Lainnya (TA)</td>
                        <?php
                        $grand_total = 0;
                        for ($i = 1; $i <= 12; $i++) {
                            $total_bulan = $tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i];
                            echo "<td class='num'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                            $grand_total += $total_bulan;
                        }
                        ?>
                        <td class="num"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                    </tr>
                    <tr style="background-color:#e9ecef;font-weight:bold;">
                        <td>TOTAL PENERIMAAN AIR</td>
                        <?php
                        $grand_total_rkap = 0;
                        for ($i = 1; $i <= 12; $i++) {
                            $total_bulan_rkap = $grand_per_month[$i] + ($tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i]);
                            echo "<td class='num'>" . number_format($total_bulan_rkap, 0, ',', '.') . "</td>";
                            $grand_total_rkap += $total_bulan_rkap;
                        }
                        ?>
                        <td class="num"><?= number_format($grand_total_rkap, 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>