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
        <p class="title"><?= $title . ' ' .  $tahun; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">NO</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Uraian</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Prod</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Volume</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Harga</th>
                    <th colspan="12" style="text-align:center;vertical-align:middle;">B U L A N</th>
                    <th rowspan="2" style="text-align:center;vertical-align:middle;">Jumlah</th>
                </tr>
                <tr>
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
                $no = 1;
                $produk_sekarang = null;
                $grand_total_per_bulan = array_fill(1, 12, 0);
                $grand_total_tahun = 0;
                $subtotal_per_produk = array_fill(1, 12, 0);
                $total_tahun_produk = 0;
                ?>

                <?php foreach ($bahan_baku as $bahan) : ?>
                    <?php
                    $nilai_per_bulan = $bahan['total_tahun'] / 12;
                    $subtotal = $bahan['total_tahun'];
                    $jumlah_produksi = $bahan['jumlah_produksi'];

                    // Jika produk berubah, tampilkan header baru
                    if ($produk_sekarang !== $bahan['nama_produk']) :
                        // Jika bukan produk pertama, tampilkan total produk sebelumnya
                        if ($produk_sekarang !== null) : ?>
                            <tr style="font-weight:bold;background:#f9f9f9;">
                                <td colspan="5" style="text-align:left;">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <td class="num"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                                <?php endfor; ?>
                                <td class="num"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endif;

                        // Reset subtotal untuk produk baru
                        $subtotal_per_produk = array_fill(1, 12, 0);
                        $total_tahun_produk = 0;
                        $no = 1;
                        $produk_sekarang = $bahan['nama_produk'];
                        ?>
                        <!-- JUDUL PRODUK -->
                        <tr>
                            <td colspan="5" style="text-align:left;font-weight:bold;">BAHAN BAKU <?= strtoupper($produk_sekarang); ?></td>
                            <td colspan="16"></td>
                        </tr>
                    <?php endif; ?>

                    <!-- Baris bahan -->
                    <tr>
                        <td class="center"><?= $no++; ?></td>
                        <td style="text-align:left;"><?= $bahan['nama_bahan']; ?></td>
                        <td class="num"><?= number_format($jumlah_produksi, 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($bahan['volume'], 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($bahan['harga_satuan'], 0, ',', '.'); ?></td>

                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($nilai_per_bulan, 0, ',', '.'); ?></td>
                            <?php
                            $subtotal_per_produk[$i] += $nilai_per_bulan;
                            $grand_total_per_bulan[$i] += $nilai_per_bulan;
                            ?>
                        <?php endfor; ?>

                        <td class="num"><?= number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>

                    <?php
                    $total_tahun_produk += $subtotal;
                    $grand_total_tahun += $subtotal;
                    ?>
                <?php endforeach; ?>

                <!-- TOTAL PRODUK TERAKHIR -->
                <?php if ($produk_sekarang !== null) : ?>
                    <tr style="font-weight:bold;">
                        <td colspan="5" style="text-align:left;">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                    </tr>
                <?php endif; ?>

                <!-- TOTAL KESELURUHAN -->
                <tr style="font-weight:bold;background:#e3e3e3;">
                    <td colspan="5" style="text-align:left;">JUMLAH</td>
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <td class="num"><?= number_format($grand_total_per_bulan[$i], 0, ',', '.'); ?></td>
                    <?php endfor; ?>
                    <td class="num"><?= number_format($grand_total_tahun, 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
