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
                    <th rowspan="2">URAIAN</th>
                    <th colspan="2">TAGIHAN</th>
                    <th colspan="13">PENERIMAAN (Rp)</th>
                </tr>
                <tr>
                    <th>Buah</th>
                    <th>Rupiah</th>
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
            <?php
            // Array untuk grand total di footer
            $footer_total_tagihan_buah = 0;
            $footer_total_tagihan_rp = 0;
            $footer_total_penerimaan = array_fill(1, 13, 0); // 1-12 bulan, 13 total
            ?>

            <tbody>
                <?php if (empty($penerimaan)) : ?>
                    <tr>
                        <td colspan="16">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($penerimaan as $produk) : ?>

                    <?php
                    $rows = $produk['rows'];
                    $total_produk = $rows['total_produk'];
                    $th_lalu = $rows['th_lalu'];
                    $bulanan = $rows['bulanan'];

                    // Akumulasi untuk footer
                    $footer_total_tagihan_buah += $total_produk['tagihan_buah'];
                    $footer_total_tagihan_rp += $total_produk['tagihan_rp'];
                    for ($i = 1; $i <= 13; $i++) {
                        $footer_total_penerimaan[$i] += $total_produk['penerimaan'][$i];
                    }
                    ?>

                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $total_produk['uraian']; ?></td>
                        <td class="num"><?= number_format($total_produk['tagihan_buah'], 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($total_produk['tagihan_rp'], 0, ',', '.'); ?></td>
                        <?php for ($i = 1; $i <= 13; $i++) : ?>
                            <td class="num"><?= number_format($total_produk['penerimaan'][$i], 0, ',', '.'); ?></td>
                        <?php endfor; ?>
                    </tr>

                    <tr>
                        <td style="padding-left:8px;"><?= $th_lalu['uraian']; ?></td>
                        <td class="num"><?= ($th_lalu['tagihan_buah'] == 0) ? '' : number_format($th_lalu['tagihan_buah'], 0, ',', '.'); ?></td>
                        <td class="num"><?= ($th_lalu['tagihan_rp'] == 0) ? '' : number_format($th_lalu['tagihan_rp'], 0, ',', '.'); ?></td>
                        <?php for ($i = 1; $i <= 13; $i++) : ?>
                            <td class="num">
                                <?= ($th_lalu['penerimaan'][$i] == 0) ? '' : number_format($th_lalu['penerimaan'][$i], 0, ',', '.'); ?>
                            </td>
                        <?php endfor; ?>
                    </tr>

                    <?php foreach ($bulanan as $nama_baris => $data_baris) : ?>
                        <tr>
                            <td style="padding-left:8px;"><?= $data_baris['uraian']; ?></td>
                            <td class="num"><?= ($data_baris['tagihan_buah'] == 0) ? '' : number_format($data_baris['tagihan_buah'], 0, ',', '.'); ?></td>
                            <td class="num"><?= ($data_baris['tagihan_rp'] == 0) ? '' : number_format($data_baris['tagihan_rp'], 0, ',', '.'); ?></td>
                            <?php for ($i = 1; $i <= 13; $i++) : ?>
                                <td class="num">
                                    <?= ($data_baris['penerimaan'][$i] == 0) ? '' : number_format($data_baris['penerimaan'][$i], 0, ',', '.'); ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background-color:#6c757d;color:white;">
                    <td>JUMLAH TOTAL</td>
                    <td class="num"><?= number_format($footer_total_tagihan_buah, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($footer_total_tagihan_rp, 0, ',', '.') ?></td>
                    <?php for ($i = 1; $i <= 13; $i++) : ?>
                        <td class="num"><?= number_format($footer_total_penerimaan[$i], 0, ',', '.') ?></td>
                    <?php endfor; ?>
                </tr>
            </tfoot>
        </table>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <p class="title"><?= $title2 . ' ' .  $tahun; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">URAIAN</th>
                    <th colspan="2">TAGIHAN</th>
                    <th colspan="13">PENERIMAAN (Rp)</th>
                </tr>
                <tr>
                    <th>Buah</th>
                    <th>Rupiah</th>
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
            <?php
            // Array untuk grand total di footer
            $footer_total_tagihan_buah = 0;
            $footer_total_tagihan_rp = 0;
            $footer_total_penerimaan = array_fill(1, 13, 0); // 1-12 bulan, 13 total
            ?>

            <tbody>
                <?php if (empty($non_air)) : ?>
                    <tr>
                        <td colspan="16">Data tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($non_air as $produk) : ?>

                    <?php
                    $rows = $produk['rows'];
                    $total_produk = $rows['total_produk'];
                    $th_lalu = $rows['th_lalu'];
                    $bulanan = $rows['bulanan'];

                    // Akumulasi untuk footer
                    $footer_total_tagihan_buah += $total_produk['tagihan_buah'];
                    $footer_total_tagihan_rp += $total_produk['tagihan_rp'];
                    for ($i = 1; $i <= 13; $i++) {
                        $footer_total_penerimaan[$i] += $total_produk['penerimaan'][$i];
                    }
                    ?>

                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $total_produk['uraian']; ?></td>
                        <td class="num"><?= number_format($total_produk['tagihan_buah'], 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($total_produk['tagihan_rp'], 0, ',', '.'); ?></td>
                        <?php for ($i = 1; $i <= 13; $i++) : ?>
                            <td class="num"><?= number_format($total_produk['penerimaan'][$i], 0, ',', '.'); ?></td>
                        <?php endfor; ?>
                    </tr>

                    <tr>
                        <td style="padding-left:8px;"><?= $th_lalu['uraian']; ?></td>
                        <td class="num"><?= ($th_lalu['tagihan_buah'] == 0) ? '' : number_format($th_lalu['tagihan_buah'], 0, ',', '.'); ?></td>
                        <td class="num"><?= ($th_lalu['tagihan_rp'] == 0) ? '' : number_format($th_lalu['tagihan_rp'], 0, ',', '.'); ?></td>
                        <?php for ($i = 1; $i <= 13; $i++) : ?>
                            <td class="num">
                                <?= ($th_lalu['penerimaan'][$i] == 0) ? '' : number_format($th_lalu['penerimaan'][$i], 0, ',', '.'); ?>
                            </td>
                        <?php endfor; ?>
                    </tr>

                    <?php foreach ($bulanan as $nama_baris => $data_baris) : ?>
                        <tr>
                            <td style="padding-left:8px;"><?= $data_baris['uraian']; ?></td>
                            <td class="num"><?= ($data_baris['tagihan_buah'] == 0) ? '' : number_format($data_baris['tagihan_buah'], 0, ',', '.'); ?></td>
                            <td class="num"><?= ($data_baris['tagihan_rp'] == 0) ? '' : number_format($data_baris['tagihan_rp'], 0, ',', '.'); ?></td>
                            <?php for ($i = 1; $i <= 13; $i++) : ?>
                                <td class="num">
                                    <?= ($data_baris['penerimaan'][$i] == 0) ? '' : number_format($data_baris['penerimaan'][$i], 0, ',', '.'); ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="font-weight:bold;background-color:#6c757d;color:white;">
                    <td>JUMLAH TOTAL</td>
                    <td class="num"><?= number_format($footer_total_tagihan_buah, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($footer_total_tagihan_rp, 0, ',', '.') ?></td>
                    <?php for ($i = 1; $i <= 13; $i++) : ?>
                        <td class="num"><?= number_format($footer_total_penerimaan[$i], 0, ',', '.') ?></td>
                    <?php endfor; ?>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>