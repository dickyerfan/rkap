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
        .bg-warning { background-color: #fff3cd; }
        .bg-success { background-color: #d1e7dd; }
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
                    <th>No Per</th>
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
                <?php if (!empty($subsidi)) : ?>
                    <tr style="background-color: #e9ecef;">
                        <td></td>
                        <td colspan="14"><b>Subsidi Selisih Tarif</b></td>
                    </tr>
                    <?php
                    $subsidi_total_bulan = array_fill(1, 12, 0);
                    $subsidi_total = 0;
                    ?>
                    <?php foreach ($subsidi as $row) : ?>
                        <tr>
                            <td><?= $row['kode'] ?></td>
                            <td>&nbsp;&nbsp;<?= $row['name'] ?></td>
                            <?php
                            for ($i = 1; $i <= 12; $i++) :
                                $nilai = $row['bulan'][$i] ?? 0;
                                $subsidi_total_bulan[$i] += $nilai;
                            ?>
                                <td class="num"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                            <?php endfor; ?>
                            <td class="num"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                        </tr>
                        <?php $subsidi_total += $row['jumlah']; ?>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; background-color: #fff3cd;">
                        <td></td>
                        <td>&nbsp;&nbsp;Jumlah Subsidi Selisih Tarif</td>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($subsidi_total_bulan[$i], 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($subsidi_total, 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($penagihan)) : ?>
                    <tr style="background-color: #e9ecef;">
                        <td></td>
                        <td colspan="14"><b>Jasa Penagihan Rekening/IT</b></td>
                    </tr>
                    <?php
                    $penagihan_total_bulan = array_fill(1, 12, 0);
                    $penagihan_total = 0;
                    ?>
                    <?php foreach ($penagihan as $row) : ?>
                        <tr>
                            <td><?= $row['kode'] ?></td>
                            <td>&nbsp;&nbsp;<?= $row['name'] ?></td>
                            <?php
                            for ($i = 1; $i <= 12; $i++) :
                                $nilai = $row['bulan'][$i] ?? 0;
                                $penagihan_total_bulan[$i] += $nilai;
                            ?>
                                <td class="num"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                            <?php endfor; ?>
                            <td class="num"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                        </tr>
                        <?php $penagihan_total += $row['jumlah']; ?>
                    <?php endforeach; ?>
                    <tr style="font-weight: bold; background-color: #fff3cd;">
                        <td></td>
                        <td>&nbsp;&nbsp;Jumlah Jasa Penagihan</td>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($penagihan_total_bulan[$i], 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($penagihan_total, 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (!empty($subsidi) || !empty($penagihan)) : ?>
                    <?php
                    $grand_bulan = [];
                    for ($i = 1; $i <= 12; $i++) {
                        $grand_bulan[$i] = ($subsidi_total_bulan[$i] ?? 0) + ($penagihan_total_bulan[$i] ?? 0);
                    }
                    $grand_total = ($subsidi_total ?? 0) + ($penagihan_total ?? 0);
                    ?>
                    <tr style="font-weight: bold; background-color: #d1e7dd;">
                        <td></td>
                        <td>&nbsp;&nbsp;Jumlah Pendapatan Usaha Lain</td>
                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                            <td class="num"><?= number_format($grand_bulan[$i], 0, ',', '.') ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>
