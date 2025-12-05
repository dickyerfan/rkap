<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.8rem;
        }

        header p,
        .text-center p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        hr {
            height: 1px;
            background-color: black !important;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.6rem;
            height: 10px;
            vertical-align: middle;
        }
    </style>

</head>

<body>
    <header>
        <div class="container-fluid">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td width="10%">
                            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card-body">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
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
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th>URAIAN</th>
                                    <?php foreach ($bulan_list as $b) : ?>
                                        <th class="text-center"><?= $b ?></th>
                                    <?php endforeach; ?>
                                    <th class="text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($group_order)) : ?>
                                    <tr>
                                        <td colspan="<?= count($bulan_list) + 2 ?>" class="text-center">Tidak ada akun 88.x</td>
                                    </tr>
                                <?php else : ?>

                                    <?php foreach ($group_order as $grp) :
                                        $g = $groups[$grp];
                                        // header (88.01.00) row
                                    ?>
                                        <?php if (!empty($g['header'])) : ?>
                                            <tr class="fw-bold">
                                                <td><?= $g['header']['kode'] ?></td>
                                                <td><?= $g['header']['name'] ?></td>
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $val = $g['header']['bulan'][$m] ?? 0;
                                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                ?>
                                                    <td class="text-end pe-1"><?= $show ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1"><?= ($g['header']['total'] == 0) ? '-' : number_format($g['header']['total'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php else : ?>
                                            <tr class="fw-bold">
                                                <td><?= $g['group_parent_code'] ?></td>
                                                <td><?= $g['group_label'] ?></td>
                                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                    <td class="text-end pe-1">-</td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1">-</td>
                                            </tr>
                                        <?php endif; ?>

                                        <!-- parents (level-3): tampilkan SUBTOTAL parent di baris parent (di atas anak-anak) -->
                                        <?php foreach ($g['parents'] as $parent) : ?>
                                            <tr class="table-secondary fw-bold">
                                                <td><?= $parent['kode'] ?></td>
                                                <td><?= $parent['name'] ?></td>
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $val = $parent['bulan'][$m] ?? 0;
                                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                ?>
                                                    <td class="text-end pe-1"><?= $show ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1"><?= ($parent['total'] == 0) ? '-' : number_format($parent['total'], 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- children (level-4) : tampilkan hanya untuk grup selain 88.02 -->
                                            <?php if ($grp !== '88.02') : ?>
                                                <?php foreach ($parent['children'] as $child) : ?>
                                                    <tr>
                                                        <td><?= $child['kode'] ?></td>
                                                        <td><?= $child['name'] ?></td>
                                                        <?php for ($m = 1; $m <= 12; $m++) :
                                                            $val = $child['bulan'][$m] ?? 0;
                                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                        ?>
                                                            <td class="text-end pe-1"><?= $show ?></td>
                                                        <?php endfor; ?>
                                                        <td class="text-end pe-1"><?= ($child['total'] == 0) ? '-' : number_format($child['total'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                        <!-- leftovers (items in group not belonging to a parent3) -->
                                        <?php foreach ($g['leftovers'] as $ld) : ?>
                                            <tr>
                                                <td><?= $ld['kode'] ?></td>
                                                <td><?= $ld['name'] ?></td>
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $val = $ld['bulan'][$m] ?? 0;
                                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                ?>
                                                    <td class="text-end pe-1"><?= $show ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1"><?= ($ld['total'] == 0) ? '-' : number_format($ld['total'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- subtotal group -->
                                        <tr class="table-info fw-bold">
                                            <td></td>
                                            <td><?= ($grp === '88.01') ? 'Jumlah Pendapatan Lain2' : (($grp === '88.02') ? 'Jumlah Pendapatan AMDK' : 'Jumlah ' . $grp) ?></td>
                                            <?php for ($m = 1; $m <= 12; $m++) :
                                                $val = $g['totals'][$m] ?? 0;
                                                $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                            ?>
                                                <td class="text-end pe-1"><?= $show ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1"><?= ($g['total_sum'] == 0) ? '-' : number_format($g['total_sum'], 0, ',', '.') ?></td>
                                        </tr>

                                    <?php endforeach; ?>

                                    <!-- GRAND TOTAL -->
                                    <tr class="table-dark text-white fw-bold">
                                        <td></td>
                                        <td>Jumlah total pendapatan diluar usaha</td>
                                        <?php for ($m = 1; $m <= 12; $m++) :
                                            $val = $grand_totals[$m] ?? 0;
                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                        ?>
                                            <td class="text-end pe-1"><?= $show ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= ($grand_sum == 0) ? '-' : number_format($grand_sum, 0, ',', '.') ?></td>
                                    </tr>

                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>