<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; margin: 40pt 20pt 40pt 50pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 10pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 11pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 9pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.num { text-align: right; }
        table.data-table td.num-bold { text-align: right; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table tfoot td { font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #6c757d; }
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
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun + 1; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Uraian</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding-left:16px;font-weight:bold;">Pendapatan</td>
                    <td class="num"></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Pendapatan Air</td>
                    <td class="num"><?= number_format($pendapatan_air_total, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Pendapatan Non Air</td>
                    <td class="num"><?= number_format($pendapatan_non_air, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Pendapatan AMDK</td>
                    <td class="num"><?= number_format($total_pend_amdk, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;font-weight:bold;">Jumlah Pendapatan</td>
                    <td class="num-bold"><?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;font-weight:bold;">Biaya</td>
                    <td class="num"></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Biaya Usulan Barang</td>
                    <td class="num"><?= number_format($biayaUsulanBarang, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Biaya Usulan Investasi</td>
                    <td class="num"><?= number_format($biayaUsulanInvestasi, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Biaya Usulan Pemeliharaan</td>
                    <td class="num"><?= number_format($biayaUsulanPemeliharaan, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Biaya Usulan Pegawai & Umum</td>
                    <td class="num"><?= number_format($biayaUsulanUmum, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;">Biaya Usulan AMDK</td>
                    <td class="num"><?= number_format($total_biaya_amdk, 0, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td style="padding-left:16px;font-weight:bold;">Jumlah Biaya</td>
                    <td class="num-bold"><?= number_format($total_biaya, 0, ',', '.'); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td style="font-weight:bold;padding-left:16px;">LABA / RUGI</td>
                    <td class="num-bold"><?= number_format($laba_rugi, 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>
