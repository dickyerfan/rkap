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
        <p class="title"><?= $title . ' ' .  $tahun ?></p>
        <?php
        $groups = $groups ?? [];
        $group_order = $group_order ?? [];
        $grand_totals = $grand_totals ?? array_fill(1, 12, 0);
        $grand_sum = $grand_sum ?? 0;

        $bulan_list = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>URAIAN</th>
                    <?php foreach ($bulan_list as $b) : ?>
                        <th class="center"><?= $b ?></th>
                    <?php endforeach; ?>
                    <th class="center">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($group_order)) : ?>
                    <tr>
                        <td colspan="<?= count($bulan_list) + 2 ?>" class="center">Tidak ada akun 88.x</td>
                    </tr>
                <?php else : ?>

                    <?php foreach ($group_order as $grp) :
                        $g = $groups[$grp];
                    ?>
                        <?php if (!empty($g['header'])) : ?>
                            <tr style="font-weight:bold;">
                                <td><?= $g['header']['kode'] ?></td>
                                <td><?= $g['header']['name'] ?></td>
                                <?php for ($m = 1; $m <= 12; $m++) :
                                    $val = $g['header']['bulan'][$m] ?? 0;
                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                ?>
                                    <td class="num"><?= $show ?></td>
                                <?php endfor; ?>
                                <td class="num"><?= ($g['header']['total'] == 0) ? '-' : number_format($g['header']['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php else : ?>
                            <tr style="font-weight:bold;">
                                <td><?= $g['group_parent_code'] ?></td>
                                <td><?= $g['group_label'] ?></td>
                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                    <td class="num">-</td>
                                <?php endfor; ?>
                                <td class="num">-</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($g['parents'] as $parent) : ?>
                            <tr style="background-color:#e9ecef;font-weight:bold;">
                                <td><?= $parent['kode'] ?></td>
                                <td><?= $parent['name'] ?></td>
                                <?php for ($m = 1; $m <= 12; $m++) :
                                    $val = $parent['bulan'][$m] ?? 0;
                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                ?>
                                    <td class="num"><?= $show ?></td>
                                <?php endfor; ?>
                                <td class="num"><?= ($parent['total'] == 0) ? '-' : number_format($parent['total'], 0, ',', '.') ?></td>
                            </tr>

                            <?php if ($grp !== '88.02') : ?>
                                <?php foreach ($parent['children'] as $child) : ?>
                                    <tr>
                                        <td><?= $child['kode'] ?></td>
                                        <td><?= $child['name'] ?></td>
                                        <?php for ($m = 1; $m <= 12; $m++) :
                                            $val = $child['bulan'][$m] ?? 0;
                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                        ?>
                                            <td class="num"><?= $show ?></td>
                                        <?php endfor; ?>
                                        <td class="num"><?= ($child['total'] == 0) ? '-' : number_format($child['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php foreach ($g['leftovers'] as $ld) : ?>
                            <tr>
                                <td><?= $ld['kode'] ?></td>
                                <td><?= $ld['name'] ?></td>
                                <?php for ($m = 1; $m <= 12; $m++) :
                                    $val = $ld['bulan'][$m] ?? 0;
                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                ?>
                                    <td class="num"><?= $show ?></td>
                                <?php endfor; ?>
                                <td class="num"><?= ($ld['total'] == 0) ? '-' : number_format($ld['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr style="background-color:#cff4fc;font-weight:bold;">
                            <td></td>
                            <td><?= ($grp === '88.01') ? 'Jumlah Pendapatan Lain2' : (($grp === '88.02') ? 'Jumlah Pendapatan AMDK' : 'Jumlah ' . $grp) ?></td>
                            <?php for ($m = 1; $m <= 12; $m++) :
                                $val = $g['totals'][$m] ?? 0;
                                $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                            ?>
                                <td class="num"><?= $show ?></td>
                            <?php endfor; ?>
                            <td class="num"><?= ($g['total_sum'] == 0) ? '-' : number_format($g['total_sum'], 0, ',', '.') ?></td>
                        </tr>

                    <?php endforeach; ?>

                    <tr style="background-color:#212529;color:white;font-weight:bold;">
                        <td></td>
                        <td>Jumlah total pendapatan diluar usaha</td>
                        <?php for ($m = 1; $m <= 12; $m++) :
                            $val = $grand_totals[$m] ?? 0;
                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                        ?>
                            <td class="num"><?= $show ?></td>
                        <?php endfor; ?>
                        <td class="num"><?= ($grand_sum == 0) ? '-' : number_format($grand_sum, 0, ',', '.') ?></td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>

</html>
