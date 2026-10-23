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
        <table class="data-table">
            <thead>
                <tr>
                    <th colspan="2">PERKIRAAN</th>
                    <th>UPK</th>
                    <th colspan="12">B U L A N</th>
                    <th rowspan="2">JUMLAH</th>
                </tr>
                <tr>
                    <th width="5%">KODE</th>
                    <th width="25%">NAMA</th>
                    <th>BAGIAN</th>
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
                $grand_total = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                ];
                ?>
                <?php if (!empty($detail)) : ?>
                    <?php foreach ($detail as $row) : ?>
                        <tr>
                            <td><?= $row['kode']; ?></td>
                            <td><?= $row['uraian']; ?></td>
                            <td class="center"><?= $row['upk']; ?></td>
                            <td class="num"><?= number_format($row['jan'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['feb'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['mar'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['apr'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['mei'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['jun'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['jul'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['agu'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['sep'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['okt'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['nov'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($row['des'], 0, ',', '.'); ?></td>
                            <td class="num-bold"><?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php
                        $grand_total['jan'] += $row['jan'];
                        $grand_total['feb'] += $row['feb'];
                        $grand_total['mar'] += $row['mar'];
                        $grand_total['apr'] += $row['apr'];
                        $grand_total['mei'] += $row['mei'];
                        $grand_total['jun'] += $row['jun'];
                        $grand_total['jul'] += $row['jul'];
                        $grand_total['agu'] += $row['agu'];
                        $grand_total['sep'] += $row['sep'];
                        $grand_total['okt'] += $row['okt'];
                        $grand_total['nov'] += $row['nov'];
                        $grand_total['des'] += $row['des'];
                        $grand_total['jumlah'] += $row['jumlah'];
                        ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="16" class="center">Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">JUMLAH <?= strtoupper($nama_akun); ?></td>
                    <td class="num"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                    <td class="num"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>
