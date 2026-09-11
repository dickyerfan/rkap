<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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

        .bg-gray { background-color: #e9ecef; }
        .bg-light { background-color: #f8f9fa; }
        .bg-warning { background-color: #fff3cd; }
        .bg-success { background-color: #d1e7dd; }
        .bg-info { background-color: #cff4fc; }
        .bg-dark { background-color: #212529; color: #fff; }
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
        <p class="title"><?= $title . ' ' . $tahun ?></p>
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
                $uraianList = [
                    'Pelanggan Akhir'   => 'Pelanggan Akhir',
                    'Pola Konsumsi'     => 'Pola Konsumsi',
                    'Tarif Rata'        => 'Tarif Rata',
                    'Penjualan Air'     => 'Penjualan Air',
                    'Biaya Pemeliharaan'=> 'Jasa Pemeliharaan',
                    'Biaya Administrasi'=> 'Jasa Administrasi',
                    'Tagihan Air'       => 'Tagihan Air'
                ];

                foreach ($uraianList as $label => $key) {
                    echo "<tr><td colspan='14'><b>{$label}</b></td></tr>";

                    foreach ($data_pendapatan_air as $jp => $blok) {
                        echo "<tr>";
                        echo "<td>- {$jp}</td>";

                        $jumlahKolom = 0;
                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                            $nilai = isset($blok[$key][$bulan]) ? $blok[$key][$bulan] : 0;
                            $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                            echo "<td class='num'>" . number_format($nilai, $desimal, ',', '.') . "</td>";

                            if (in_array($key, ['Pelanggan Akhir', 'Pola Konsumsi', 'Tarif Rata'])) {
                                if ($bulan == 12) {
                                    $jumlahKolom = $nilai;
                                }
                            } else {
                                $jumlahKolom += $nilai;
                            }
                        }
                        $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                        echo "<td class='num-bold'>" . number_format($jumlahKolom, $desimal, ',', '.') . "</td>";
                        echo "</tr>";
                    }

                    echo "<tr style='background:#e9ecef;font-weight:bold;'>";
                    echo "<td>Jumlah {$label}</td>";

                    $grand = 0;
                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                        if (in_array($key, ['Pola Konsumsi', 'Tarif Rata'])) {
                            $nilai = $total_pendapatan_air[$key][$bulan] ?? 0;
                            $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                            echo "<td class='num'>" . number_format($nilai, $desimal, ',', '.') . "</td>";

                        } elseif ($key == 'Pelanggan Akhir') {
                            $totalBulan = 0;
                            foreach ($data_pendapatan_air as $blok) {
                                $totalBulan += $blok[$key][$bulan] ?? 0;
                            }
                            echo "<td class='num'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                            if ($bulan == 12) {
                                $grand = $totalBulan;
                            }
                        } else {
                            $totalBulan = 0;
                            foreach ($data_pendapatan_air as $blok) {
                                $totalBulan += $blok[$key][$bulan] ?? 0;
                            }
                            echo "<td class='num'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                            $grand += $totalBulan;
                        }
                    }

                    if ($key == 'Pola Konsumsi') {
                        $total_pola_tahun = 0;
                        $total_pel_tahun = 0;
                        for ($m = 1; $m <= 12; $m++) {
                            $pel = $total_pendapatan_air['Pelanggan Akhir'][$m] ?? 0;
                            $pola = $total_pendapatan_air['Pola Konsumsi'][$m] ?? 0;
                            $total_pola_tahun += $pel * $pola;
                            $total_pel_tahun += $pel;
                        }
                        $grand = ($total_pel_tahun > 0) ? $total_pola_tahun / $total_pel_tahun : 0;
                    }

                    $desimal_grand = ($key == 'Pola Konsumsi') ? 2 : 0;
                    echo "<td class='num'>" . number_format($grand, $desimal_grand, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if ($upk == 1 || $upk == '') : ?>
            <p class="title"><?= $title2 . ' ' . $tahun; ?></p>
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
                    <tr>
                        <td colspan="14"><strong>Pend Penj Air Lainnya</strong></td>
                    </tr>
                    <tr>
                        <td colspan="14" style="padding-left: 20px;">- Terminal Air (TA)</td>
                    </tr>

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
                            <tr>
                                <td style="padding-left: 27px;"><?= $is_nilai_penjualan ? "<strong>{$label}</strong>" : $label; ?></td>
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <td class="num">
                                        <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                    </td>
                                <?php endfor; ?>

                                <td class="num">
                                    <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key]['total'], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key]['total'], 0, ',', '.'); ?>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </tbody>
                <tfoot>
                    <tr style="background:#e9ecef;font-weight:bold;">
                        <td>Jumlah Pend Penj Air Lainnya</td>
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
                </tfoot>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>
