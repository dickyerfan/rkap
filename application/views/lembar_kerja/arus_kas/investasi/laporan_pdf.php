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
                    <th>Kode</th>
                    <th>Uraian</th>
                    <th>Lokasi</th>
                    <th>Vol</th>
                    <th>Sat</th>
                    <th>Nilai</th>
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
                    <th>Jml</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                ];
                ?>

                <?php foreach ($biaya as $parent) : ?>
                    <tr style="font-weight: bold; background-color: #f8f9fa;">
                        <td><?= $parent['kode']; ?></td>
                        <td><?= $parent['uraian']; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <?php if (!empty($parent['children'])) : ?>
                        <?php foreach ($parent['children'] as $c) : ?>
                            <tr>
                                <td><?= $c['kode']; ?></td>
                                <td><?= $c['uraian']; ?></td>
                                <td><?= $c['upk']; ?></td>
                                <td class="center"><?= $c['vol']; ?></td>
                                <td class="center"><?= $c['sat']; ?></td>
                                <td class="num"><?= number_format($c['pagu'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['jan'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['feb'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['mar'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['apr'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['mei'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['jun'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['jul'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['agu'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['sep'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['okt'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['nov'], 0, ',', '.'); ?></td>
                                <td class="num"><?= number_format($c['des'], 0, ',', '.'); ?></td>
                                <td class="num-bold"><?= number_format($c['total_tahun'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <?php
                        $sub = [
                            'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                            'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                        ];
                        foreach ($parent['children'] as $c) {
                            foreach ($sub as $k => $_) {
                                if (isset($c[$k])) {
                                    $sub[$k] += $c[$k];
                                }
                            }
                        }

                        $has_child_in_biaya = false;
                        foreach ($biaya as $check) {
                            if ($check['kode'] !== $parent['kode'] && strpos($check['kode'], $parent['kode'] . '.') === 0) {
                                $has_child_in_biaya = true;
                                break;
                            }
                        }

                        if ($has_child_in_biaya) {
                            foreach ($biaya as $child_entry) {
                                if ($child_entry['kode'] !== $parent['kode'] && strpos($child_entry['kode'], $parent['kode'] . '.') === 0) {
                                    if (!empty($child_entry['children'])) {
                                        foreach ($child_entry['children'] as $c) {
                                            foreach ($sub as $k => $_) {
                                                if (isset($c[$k])) {
                                                    $sub[$k] += $c[$k];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        if (!$has_child_in_biaya) {
                            foreach ($grand_total as $k => $_) {
                                if (isset($sub[$k])) {
                                    $grand_total[$k] += $sub[$k];
                                }
                            }
                        }
                        ?>
                        <tr style="font-weight: bold; background-color: #f0f0f0;">
                            <td colspan="6">Subtotal <?= $parent['uraian']; ?></td>
                            <td class="num"><?= number_format($sub['jan'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['feb'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['mar'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['apr'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['mei'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['jun'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['jul'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['agu'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['sep'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['okt'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['nov'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['des'], 0, ',', '.'); ?></td>
                            <td class="num"><?= number_format($sub['jumlah'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="6">TOTAL</td>
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
