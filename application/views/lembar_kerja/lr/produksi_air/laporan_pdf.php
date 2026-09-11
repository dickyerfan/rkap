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

        <p style="font-weight: bold;">AIR PRODUKSI</p>
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
                <?php if (!empty($air_produksi)) : ?>
                    <?php
                    $grand_total = 0;
                    $total_per_bulan = array_fill(1, 12, 0);
                    $total_hari = array_sum($hari_tagihan);

                    foreach ($air_produksi as $row) :
                        $grand_total += $row['produksi_total'];
                        $produksi_per_bulan = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $produksi_per_bulan[$i] = $row['produksi_total'] * ($hari_tagihan[$i] / $total_hari);
                            $total_per_bulan[$i] += $produksi_per_bulan[$i];
                        }
                    ?>
                        <tr>
                            <td>- <?= $row['uraian'] ?></td>
                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                <td class="num"><?= number_format($produksi_per_bulan[$i], 0, ',', '.') ?></td>
                            <?php endfor; ?>
                            <td class="num-bold"><?= number_format($row['produksi_total'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr style="font-weight: bold;">
                        <td>Jumlah Produksi</td>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>

                <?php else : ?>
                    <tr>
                        <td colspan="15" class="center">Data tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p style="font-weight: bold;">AIR TERJUAL</p>
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
                $grand_total = array_fill(1, 12, 0);

                foreach ($air_terjual as $jp => $bulanData) {
                    echo "<tr>";
                    echo "<td>{$jp}</td>";

                    $jumlah = 0;
                    for ($m = 1; $m <= 12; $m++) {
                        $nilai = isset($bulanData[$m]) ? $bulanData[$m] : 0;
                        echo "<td class='num'>" . number_format($nilai, 0, ',', '.') . "</td>";
                        $jumlah += $nilai;
                        $grand_total[$m] += $nilai;
                    }

                    echo "<td class='num-bold'>" . number_format($jumlah, 0, ',', '.') . "</td>";
                    echo "</tr>";
                }

                echo "<tr style='background:#e9ecef;font-weight:bold;'>";
                echo "<td>JUMLAH</td>";
                $grand_sum = 0;
                for ($m = 1; $m <= 12; $m++) {
                    echo "<td class='num'>" . number_format($grand_total[$m], 0, ',', '.') . "</td>";
                    $grand_sum += $grand_total[$m];
                }
                echo "<td class='num'>" . number_format($grand_sum, 0, ',', '.') . "</td>";
                echo "</tr>";
                ?>
            </tbody>
        </table>

        <br><br><br>
        <p style="font-weight: bold;">KEHILANGAN AIR</p>
        <?php
        $total_produksi_bulan = isset($total_per_bulan) ? $total_per_bulan : array_fill(1, 12, 0);
        $total_terjual_bulan  = isset($grand_total) ? $grand_total : array_fill(1, 12, 0);

        $kehilangan_bulan = [];
        $total_kehilangan = 0;
        ?>
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
                    <td style="font-weight: bold;">Kehilangan Air (M3)</td>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <?php
                        $prod   = $total_produksi_bulan[$i] ?? 0;
                        $jual   = $total_terjual_bulan[$i] ?? 0;
                        $hilang = max(0, $prod - $jual);

                        $kehilangan_bulan[$i] = $hilang;
                        $total_kehilangan    += $hilang;
                        ?>
                        <td class="num"><?= number_format($hilang, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total_kehilangan, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Persentase Kehilangan (%)</td>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <?php
                        $prod = $total_produksi_bulan[$i] ?? 0;
                        $persen = ($prod > 0) ? ($kehilangan_bulan[$i] / $prod * 100) : 0;
                        ?>
                        <td class="num"><?= number_format($persen, 2, ',', '.') ?>%</td>
                    <?php endfor; ?>

                    <?php
                    $total_produksi_tahun = array_sum($total_produksi_bulan);
                    $persen_tahun = ($total_produksi_tahun > 0)
                        ? ($total_kehilangan / $total_produksi_tahun * 100)
                        : 0;
                    ?>
                    <td class="num-bold"><?= number_format($persen_tahun, 2, ',', '.') ?>%</td>
                </tr>
                <?php
                $total_pelanggan_akhir = isset($result['total']['Pelanggan Akhir'])
                    ? $result['total']['Pelanggan Akhir']
                    : array_fill(1, 12, 0);
                ?>
                <tr>
                    <td style="font-weight: bold;">Pelanggan Akhir</td>
                    <?php
                    $jumlah_pelanggan_setahun = 0;
                    for ($i = 1; $i <= 12; $i++) :
                        $pel = $total_pelanggan_akhir[$i] ?? 0;
                        $jumlah_pelanggan_setahun += $pel;
                    ?>
                        <td class="num"><?= number_format($pel, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($jumlah_pelanggan_setahun, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Pola Konsumsi (%)</td>
                    <?php
                    $total_pola_real = 0;
                    for ($i = 1; $i <= 12; $i++) :
                        $pelanggan = $total_pelanggan_akhir[$i] ?? 0;
                        $air_terjual = $total_terjual_bulan[$i] ?? 0;

                        $pola_real = ($air_terjual > 0) ? ($air_terjual / $pelanggan) : 0;

                        $total_pola_real += $pola_real;
                    ?>
                        <td class="num"><?= number_format($pola_real, 2, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total_pola_real / 12, 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
