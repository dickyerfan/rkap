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
        <p class="title"><?= $title . ' ' . $tahun; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>URAIAN</th>
                    <th>%</th>
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
                $total_per_bulan = array_fill(1, 12, 0);
                foreach ($produksi as $produk) :
                ?>
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $produk['nama_produk'] ?>
                        </td>
                        <td></td>
                        <?php
                        $subtotal = 0;
                        for ($i = 1; $i <= 12; $i++) :
                            $val = $produk['produksi'][$i];
                            $subtotal += $val;
                            $total_per_bulan[$i] += $val;
                        ?>
                            <td class="num"><?= number_format($val, 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num-bold"><?= number_format($subtotal, 0, ',', '.') ?></td>
                    </tr>

                    <?php foreach ($produk['tarif'] as $kategori => $data_tarif) : ?>
                        <tr>
                            <!-- <td>- <?= 'Pendapatan ' . $produk['nama_produk'] . ' ' . $kategori   ?></td> -->
                            <td>- <?= $produk['nama_produk'] . ' ' . $kategori   ?></td>
                            <td class="center"><?= number_format($data_tarif['persen'], 0, ',', '.') ?></td>
                            <?php
                            for ($i = 1; $i <= 12; $i++) :
                                $val = $data_tarif['produksi'][$i];
                            ?>
                                <td class="num"><?= number_format($val, 0, ',', '.') ?></td>
                            <?php endfor; ?>
                            <td class="num"><?= number_format($data_tarif['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>

                <?php endforeach; ?>

                <!-- Baris total bawah -->
                <tr style="font-weight:bold;background-color:#6c757d;color:white;">
                    <td>JUMLAH TOTAL</td>
                    <td></td>
                    <?php
                    $grand_total = 0;
                    for ($i = 1; $i <= 12; $i++) :
                        $grand_total += $total_per_bulan[$i];
                    ?>
                        <td class="num"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
