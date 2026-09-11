<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 20pt 20pt 30pt 80pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 10pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 9pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 6.5pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.num { text-align: right; }
        table.data-table td.num-bold { text-align: right; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table tfoot td { font-weight: bold; background-color: #e9ecef; border-top: 2px solid #6c757d; }
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
        <p class="title">
            <?= $title . ' ' .  $tahun; ?>
        </p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No Per</th>
                    <th>Uraian</th>
                    <th>Vol</th>
                    <th>Harga</th>
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
            <?php if ($tahun == 2026) : ?>
                <tbody>
                    <?php
                    $total_bulan = array_fill(1, 12, 0);
                    $total_semua = 0;

                    $exclude_bulan = array_fill(1, 12, 0);
                    $exclude_total = 0;
                    ?>

                    <?php foreach ($barang as $b) : ?>
                        <tr>
                            <td style="text-align:center;"><?= $b['no_per_id'] ?></td>
                            <td><?= $b['nama_barang'] ?></td>
                            <td style="text-align:center;"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                            <td class="num"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                            <?php for ($m = 1; $m <= 12; $m++) :
                                $nilai = $b['bulanData'][$m] ?? 0;
                                $total_bulan[$m] += $nilai;

                                if (in_array($b['id_barang'], [1, 2, 3])) {
                                    $exclude_bulan[$m] += $nilai;
                                }
                            ?>
                                <td class="num">
                                    <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                </td>
                            <?php endfor; ?>

                            <td class="num"><?= number_format($b['jumlah'], 0, ',', '.') ?></td>

                            <?php
                            $total_semua += $b['jumlah'];
                            if (in_array($b['id_barang'], [1, 2, 3])) {
                                $exclude_total += $b['jumlah'];
                            }
                            ?>
                        </tr>
                    <?php endforeach; ?>

                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td colspan="4" style="text-align:center;">JUMLAH</td>
                        <?php for ($m = 1; $m <= 12; $m++) :
                            $final_bulan = $total_bulan[$m] - $exclude_bulan[$m];
                        ?>
                            <td class="num"><?= number_format($final_bulan, 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($total_semua - $exclude_total, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            <?php else : ?>
                <tbody>
                    <?php
                    $total_bulan = array_fill(1, 12, 0);
                    $total_semua = 0;
                    ?>

                    <?php foreach ($barang as $b) : ?>
                        <tr>
                            <td style="text-align:center;"><?= $b['no_per_id'] ?></td>
                            <td><?= $b['nama_barang'] ?></td>
                            <td style="text-align:center;"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                            <td class="num"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                            <?php for ($m = 1; $m <= 12; $m++) :
                                $nilai = $b['bulanData'][$m] ?? 0;
                                $total_bulan[$m] += $nilai;
                            ?>
                                <td class="num">
                                    <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                </td>
                            <?php endfor; ?>

                            <td class="num">
                                <?= number_format($b['jumlah'], 0, ',', '.') ?>
                            </td>
                        </tr>

                        <?php $total_semua += $b['jumlah']; ?>
                    <?php endforeach; ?>

                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td colspan="4" style="text-align:center;">JUMLAH</td>
                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                            <td class="num"><?= number_format($total_bulan[$m], 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            <?php endif; ?>
        </table>
    </main>
</body>

</html>
