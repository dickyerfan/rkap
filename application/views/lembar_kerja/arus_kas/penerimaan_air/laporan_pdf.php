<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.8rem;
        }

        header p,
        .text-center p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        hr {
            height: 1px;
            background-color: black !important;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.6rem;
            height: 10px;
            vertical-align: middle;
        }
    </style>

</head>

<body>
    <header>
        <div class="container-fluid">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td width="10%">
                            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
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
                        <p class="text-center fw-bold">
                            RENCANA PENERIMAAN TAGIHAN REKENING AIR<br>
                            <?= $judul_upk . " - TAHUN ANGGARAN " . $tahun ?>
                        </p>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center bg-light align-middle">
                                <tr>
                                    <th rowspan="2" style="width:100px">URAIAN</th>
                                    <th rowspan="2" style="width:40px">Lbr</th>
                                    <th rowspan="2" style="width:70px">Rp</th>
                                    <th colspan="12">PENERIMAAN (Rp)</th>
                                    <th rowspan="2" style="width:70px">JUMLAH</th>
                                </tr>
                                <tr>
                                    <?php foreach ($bulan_ind as $b) : ?>
                                        <th style="width:50px;" class="text-center"><?= $b ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($aggregate)) : ?>
                                    <tr>
                                        <td colspan="16" class="text-center">-- Tidak ada data --</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($aggregate as $id_jp => $ag) : ?>
                                        <tr class="table-primary fw-bold">
                                            <td colspan="16"><?= strtoupper($ag['nama_jp']) ?></td>
                                        </tr>

                                        <!-- Baris Th Lalu -->
                                        <tr>
                                            <td>&nbsp;&nbsp;- Th Lalu</td>
                                            <td class="text-end pe-1"><?= fmt_int($ag['thl_lembar']) ?></td>
                                            <td class="text-end pe-1"><?= $ag['thl_rupiah'] ? rupiah($ag['thl_rupiah']) : '-' ?></td>

                                            <?php
                                            $rupiah_lalu = (float)$ag['thl_rupiah'];
                                            $penerimaan_th_lalu = array_fill(1, 12, 0.0);

                                            if ($rupiah_lalu > 0) {
                                                $penerimaan_th_lalu[1] = round($rupiah_lalu * 0.70, 2); // Januari
                                                $sisa = $rupiah_lalu * 0.30;
                                                $per_bulan = round($sisa / 10, 2);
                                                for ($m = 2; $m <= 11; $m++) {
                                                    $penerimaan_th_lalu[$m] = $per_bulan;
                                                }
                                                // Desember = 0
                                            }

                                            $total_th_lalu = array_sum($penerimaan_th_lalu);
                                            ?>

                                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                <td class="text-end pe-1">
                                                    <?= $penerimaan_th_lalu[$m] != 0 ? rupiah($penerimaan_th_lalu[$m]) : '-' ?>
                                                </td>
                                            <?php endfor; ?>

                                            <td class="text-end pe-1 fw-bold"><?= rupiah($total_th_lalu) ?></td>
                                        </tr>

                                        <!-- Baris Januari..Desember (lembar dari rkap_pelanggan, tagihan dari aggregated tagihan_per_month) -->
                                        <?php for ($m = 1; $m <= 12; $m++) :
                                            $label = $bulan_ind[$m];
                                            $lembar = $ag['lembar_per_month'][$m] ?? 0;
                                            $tagihan = $ag['tagihan_per_month'][$m] ?? 0.0;
                                            $penerimaan_row = array_fill(1, 12, 0.0);
                                            if ($tagihan > 0 && $m < 12) {
                                                $p1 = round($tagihan * 0.90, 2);
                                                $p2 = round($tagihan * 0.10, 2);
                                                $penerimaan_row[$m + 1] += $p1;
                                                if ($m + 2 <= 12) $penerimaan_row[$m + 2] += $p2;
                                                $row_total = $p1 + ($m + 2 <= 12 ? $p2 : 0.0);
                                            } else {
                                                // m == 12 or tagihan == 0
                                                $row_total = 0.0;
                                            }
                                        ?>
                                            <tr>
                                                <td>&nbsp;&nbsp;- <?= $label ?></td>
                                                <td class="text-end pe-1"><?= $lembar ? number_format($lembar) : '-' ?></td>
                                                <td class="text-end pe-1"><?= $tagihan ? rupiah($tagihan) : '-' ?></td>
                                                <?php for ($mm = 1; $mm <= 12; $mm++) : ?>
                                                    <td class="text-end pe-1">
                                                        <?= $penerimaan_row[$mm] != 0 ? rupiah($penerimaan_row[$mm]) : '-' ?>
                                                    </td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1"><?= $row_total != 0 ? rupiah($row_total) : '-' ?></td>
                                            </tr>
                                        <?php endfor; ?>

                                        <!-- Baris Jumlah per jenis -->
                                        <tr class="fw-bold table-secondary text-end pe-1">
                                            <td class="text-start">Jumlah <?= $ag['nama_jp'] ?></td>
                                            <td>-</td>
                                            <td>-</td>
                                            <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                <td><?= rupiah($ag['penerimaan'][$m]) ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1"><?= rupiah($ag['total_penerimaan']) ?></td>
                                        </tr>

                                    <?php endforeach; ?>

                                    <!-- TOTAL SEMUA JENIS -->
                                    <tr class="fw-bold table-info text-end pe-1">
                                        <td class="text-start">TOTAL </td>
                                        <td>-</td>
                                        <td>-</td>
                                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                                            <td><?= rupiah($grand_per_month[$m]) ?></td>
                                        <?php endfor; ?>
                                        <td><?= rupiah($grand_sum_total) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php if ($upk == '') : ?>
                            <P>PENERIMAAN AIR LAINNYA</P>
                            <table class="table table-sm table-bordered tableUtama">
                                <thead>
                                    <tr>
                                        <th class="text-center">URAIAN</th>
                                        <th class="text-center">Jan</th>
                                        <th class="text-center">Feb</th>
                                        <th class="text-center">Mar</th>
                                        <th class="text-center">Apr</th>
                                        <th class="text-center">Mei</th>
                                        <th class="text-center">Jun</th>
                                        <th class="text-center">Jul</th>
                                        <th class="text-center">Agu</th>
                                        <th class="text-center">Sep</th>
                                        <th class="text-center">Okt</th>
                                        <th class="text-center">Nov</th>
                                        <th class="text-center">Des</th>
                                        <th class="text-center">JUMLAH</th>
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
                                                        <td class="text-end pe-1">
                                                            <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end pe-1">
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
                                            echo "<td class='text-end pe-1'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                                            $grand_total += $total_bulan;
                                        }
                                        ?>
                                        <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr class="table-secondary fw-bold">
                                        <td>TOTAL PENERIMAAN AIR</td>
                                        <?php
                                        $grand_total_rkap = 0;
                                        for ($i = 1; $i <= 12; $i++) {
                                            $total_bulan_rkap = $grand_per_month[$i] + ($tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i]);
                                            echo "<td class='text-end pe-1'>" . number_format($total_bulan_rkap, 0, ',', '.') . "</td>";
                                            $grand_total_rkap += $total_bulan_rkap;
                                        }
                                        ?>
                                        <td class="text-end pe-1"><?= number_format($grand_total_rkap, 0, ',', '.'); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>