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
        <p class="title"><?= $title . ' ' .  $tahun; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" class="center">Uraian</th>
                    <th rowspan="2" class="center">Vol</th>
                    <th rowspan="2" class="center">Sat</th>
                    <th rowspan="2" class="center">Harga</th>
                    <th colspan="12" class="center">B U L A N</th>
                    <th rowspan="2" class="center">Jumlah</th>
                </tr>
                <tr class="center">
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
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                $grand_bulanan = array_fill(1, 12, 0);
                foreach ($pemeliharaan as $jenis => $kategori_list) : ?>
                    <tr style="background-color:#0d6efd;color:white;font-weight:bold;">
                        <td colspan="17"><?= strtoupper($jenis) ?></td>
                    </tr>

                    <?php
                    $total_jenis = 0;
                    $total_jenis_bulanan = array_fill(1, 12, 0);
                    foreach ($kategori_list as $kategori => $items) : ?>
                        <tr style="background-color:#e9ecef;font-weight:bold;">
                            <td colspan="17">&nbsp;&nbsp;&nbsp;<?= strtoupper($kategori) ?></td>
                        </tr>

                        <?php
                        $total_kategori = 0;
                        $total_kategori_bulanan = array_fill(1, 12, 0);

                        foreach ($items as $p) :
                            $total_kategori += $p['total_tahun'];
                            for ($i = 1; $i <= 12; $i++) {
                                $total_kategori_bulanan[$i] += $p['per_bulan'];
                            }
                        ?>
                            <tr>
                                <td><?= $p['uraian'] ?></td>
                                <td class="center"><?= $p['volume'] ?></td>
                                <td class="center"><?= $p['satuan'] ?></td>
                                <td class="num"><?= number_format($p['harga'], 0, ',', '.') ?></td>

                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <td class="num"><?= number_format($p['per_bulan'], 0, ',', '.') ?></td>
                                <?php endfor; ?>

                                <td class="num-bold"><?= number_format($p['total_tahun'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr style="font-weight:bold;text-align:right;background-color:#f8f9fa;">
                            <td colspan="4" style="text-align:left;">Jumlah <?= $kategori ?></td>
                            <?php
                            for ($i = 1; $i <= 12; $i++) :
                                echo '<td>' . number_format($total_kategori_bulanan[$i], 0, ',', '.') . '</td>';
                                $total_jenis_bulanan[$i] += $total_kategori_bulanan[$i];
                            endfor;
                            ?>
                            <td><?= number_format($total_kategori, 0, ',', '.') ?></td>
                        </tr>

                        <?php $total_jenis += $total_kategori; ?>
                    <?php endforeach; ?>

                    <tr style="font-weight:bold;text-align:right;background-color:#fff3cd;">
                        <td colspan="4" style="text-align:left;">Jumlah <?= $jenis ?></td>
                        <?php
                        for ($i = 1; $i <= 12; $i++) :
                            echo '<td>' . number_format($total_jenis_bulanan[$i], 0, ',', '.') . '</td>';
                            $grand_bulanan[$i] += $total_jenis_bulanan[$i];
                        endfor;
                        ?>
                        <td><?= number_format($total_jenis, 0, ',', '.') ?></td>
                    </tr>

                    <?php $grand_total += $total_jenis; ?>
                <?php endforeach; ?>

                <tr style="font-weight:bold;text-align:right;background-color:#198754;color:white;">
                    <td colspan="4" style="text-align:left;">TOTAL KESELURUHAN</td>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <td><?= number_format($grand_bulanan[$i], 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
