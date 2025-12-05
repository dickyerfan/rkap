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
            font-size: 0.7rem;
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
            height: 15px;
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
                        <p>Biaya Sumber</p>
                        <?php
                        $map_bulan = [
                            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                        ];

                        // kelompokkan berdasarkan parent kode
                        $grouped = [];
                        foreach ($sumber as $r) {
                            // ambil parent prefix 3 segmen, misalnya "98.02.04"
                            $parts = explode('.', $r['kode']);
                            $parent = implode('.', array_slice($parts, 0, 3));
                            $grouped[$parent]['children'][] = $r;

                            // total per parent
                            foreach ($map_bulan as $b => $nama_bulan) {
                                if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                    $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                }
                                $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                            }
                            $grouped[$parent]['subtotal']['total_tahun'] =
                                ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                        }
                        ?>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
                                    <!-- <th rowspan="2">U R A I A N</th> -->
                                    <th colspan="12">B U L A N</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th>KODE</th>
                                    <th>NAMA</th>
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
                                $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                $total_semua = 0;

                                foreach ($grouped as $parent => $data_parent) :
                                    // ambil nama parent
                                    $parent_name = $this->db
                                        ->select('name')
                                        ->where('kode', $parent)
                                        ->get('no_per')
                                        ->row('name') ?? ' ' . $parent;
                                ?>
                                    <!-- Subtotal per parent -->
                                    <tr class="fw-bold bg-light">
                                        <td><?= $parent ?></td>
                                        <td><?= strtoupper($parent_name) ?></td>
                                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                            <td class="text-end">
                                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td class="text-end">
                                            <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                    }
                                    $total_semua += $data_parent['subtotal']['total_tahun'];
                                endforeach;
                                ?>

                                <!-- TOTAL AKHIR -->
                                <tr class="fw-bold table-primary">
                                    <td colspan="2" class="text-start">TOTAL BIAYA SUMBER</td>
                                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                        <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Biaya Pengolahan</p>
                        <div class="table-responsive">
                            <?php
                            $map_bulan = [
                                1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                            ];

                            // kelompokkan berdasarkan parent kode
                            $grouped = [];
                            foreach ($pengolahan as $r) {
                                // ambil parent prefix 3 segmen, misalnya "98.02.04"
                                $parts = explode('.', $r['kode']);
                                $parent = implode('.', array_slice($parts, 0, 3));
                                $grouped[$parent]['children'][] = $r;

                                // total per parent
                                foreach ($map_bulan as $b => $nama_bulan) {
                                    if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                        $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                    }
                                    $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                                }
                                $grouped[$parent]['subtotal']['total_tahun'] =
                                    ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                            }
                            ?>
                            <table class="table table-sm table-bordered tableUtama">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th colspan="2">PERKIRAAN</th>
                                        <!-- <th rowspan="2">U R A I A N</th> -->
                                        <th colspan="12">B U L A N</th>
                                        <th rowspan="2">JUMLAH</th>
                                    </tr>
                                    <tr>
                                        <th>KODE</th>
                                        <th>NAMA</th>
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
                                    $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                    $total_semua = 0;

                                    foreach ($grouped as $parent => $data_parent) :
                                        // ambil nama parent
                                        $parent_name = $this->db
                                            ->select('name')
                                            ->where('kode', $parent)
                                            ->get('no_per')
                                            ->row('name') ?? ' ' . $parent;
                                    ?>
                                        <!-- Subtotal per parent -->
                                        <tr class="fw-bold bg-light">
                                            <td><?= $parent ?></td>
                                            <td><?= strtoupper($parent_name) ?></td>
                                            <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end">
                                                    <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class="text-end">
                                                <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                    <?php
                                        foreach ($map_bulan as $b => $nama_bulan) {
                                            $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                        }
                                        $total_semua += $data_parent['subtotal']['total_tahun'];
                                    endforeach;
                                    ?>

                                    <!-- TOTAL AKHIR -->
                                    <tr class="fw-bold table-primary">
                                        <td colspan="2" class="text-start">TOTAL BIAYA PENGOLAHAN</td>
                                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                            <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                        <?php endforeach; ?>
                                        <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>Biaya Transmisi & Distribusi</p>
                        <?php
                        $map_bulan = [
                            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                        ];

                        // kelompokkan berdasarkan parent kode
                        $grouped = [];
                        foreach ($trandis as $r) {
                            // ambil parent prefix 3 segmen, misalnya "98.02.04"
                            $parts = explode('.', $r['kode']);
                            $parent = implode('.', array_slice($parts, 0, 3));
                            $grouped[$parent]['children'][] = $r;

                            // total per parent
                            foreach ($map_bulan as $b => $nama_bulan) {
                                if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                    $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                }
                                $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                            }
                            $grouped[$parent]['subtotal']['total_tahun'] =
                                ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                        }
                        ?>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
                                    <!-- <th rowspan="2">U R A I A N</th> -->
                                    <th colspan="12">B U L A N</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th>KODE</th>
                                    <th>NAMA</th>
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
                                $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                $total_semua = 0;

                                foreach ($grouped as $parent => $data_parent) :
                                    // ambil nama parent
                                    $parent_name = $this->db
                                        ->select('name')
                                        ->where('kode', $parent)
                                        ->get('no_per')
                                        ->row('name') ?? ' ' . $parent;
                                ?>
                                    <!-- Subtotal per parent -->
                                    <tr class="fw-bold bg-light">
                                        <td><?= $parent ?></td>
                                        <td><?= strtoupper($parent_name) ?></td>
                                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                            <td class="text-end">
                                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td class="text-end">
                                            <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                    }
                                    $total_semua += $data_parent['subtotal']['total_tahun'];
                                endforeach;
                                ?>

                                <!-- TOTAL AKHIR -->
                                <tr class="fw-bold table-primary">
                                    <td colspan="2" class="text-start">TOTAL BIAYA TRANSMISI & DISTRIBUSI</td>
                                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                        <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Biaya Umum & Administrasi</p>
                        <?php
                        $map_bulan = [
                            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                        ];

                        // kelompokkan berdasarkan parent kode
                        $grouped = [];
                        foreach ($umum as $r) {
                            // ambil parent prefix 3 segmen, misalnya "98.02.04"
                            $parts = explode('.', $r['kode']);
                            $parent = implode('.', array_slice($parts, 0, 3));
                            $grouped[$parent]['children'][] = $r;

                            // total per parent
                            foreach ($map_bulan as $b => $nama_bulan) {
                                if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                    $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                }
                                $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                            }
                            $grouped[$parent]['subtotal']['total_tahun'] =
                                ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                        }
                        ?>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
                                    <!-- <th rowspan="2">U R A I A N</th> -->
                                    <th colspan="12">B U L A N</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th>KODE</th>
                                    <th>NAMA</th>
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
                                $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                $total_semua = 0;

                                foreach ($grouped as $parent => $data_parent) :
                                    // ambil nama parent
                                    $parent_name = $this->db
                                        ->select('name')
                                        ->where('kode', $parent)
                                        ->get('no_per')
                                        ->row('name') ?? ' ' . $parent;
                                ?>
                                    <!-- Subtotal per parent -->
                                    <tr class="fw-bold bg-light">
                                        <td><?= $parent ?></td>
                                        <td><?= strtoupper($parent_name) ?></td>
                                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                            <td class="text-end">
                                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td class="text-end">
                                            <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                    }
                                    $total_semua += $data_parent['subtotal']['total_tahun'];
                                endforeach;
                                ?>

                                <!-- TOTAL AKHIR -->
                                <tr class="fw-bold table-primary">
                                    <td colspan="2" class="text-start">TOTAL BIAYA UMUM & ADMINISTRASI</td>
                                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                        <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Beban HPP Sambungan Baru</p>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2" rowspan="2">PERKIRAAN</th>
                                    <th colspan="12">B U L A N</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <!-- <th>KODE</th> -->
                                    <!-- <th colspan="2">NAMA</th> -->
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
                                // ambil variabel upk dari controller
                                $upk = isset($upk) ? $upk : 'all';

                                // 1. Inisialisasi Grand Total
                                $grand_total = [
                                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                ];
                                ?>
                                <?php foreach ($hpp as $parent) : ?>
                                    <?php if ($upk != 'all' && $upk != '') : ?>
                                        <!-- TAMPILKAN CHILDREN JIKA UPK DIPILIH -->
                                        <?php if (!empty($parent['children'])) : ?>
                                            <?php foreach ($parent['children'] as $c) : ?>
                                                <tr>
                                                    <!-- <td><?= $c['kode']; ?></td> -->
                                                    <td><?= $c['uraian']; ?></td>
                                                    <td class="text-end"><?= number_format($c['jan'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['feb'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['mar'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['apr'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['mei'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['jun'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['jul'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['agu'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['sep'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['okt'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['nov'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($c['des'], 0, ',', '.'); ?></td>
                                                    <td class="text-end fw-bold"><?= number_format($c['total_tahun'], 0, ',', '.'); ?></td>
                                                    <td class="text-center">
                                                        <!-- <a href="<?= base_url('lembar_kerja/lr/beban_trandis/edit/' . urlencode(base64_encode($c['unique_key']))) ?>"><i class="fas fa-edit"></i></a> -->
                                                        <a href="<?= base_url('lembar_kerja/lr/beban_trandis/edit_hpp/' . urlencode(base64_encode($c['kode'] . '||' . $c['uraian']))) ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php
                                    // hitung subtotal tetap jalan di dua kondisi (karena dipakai juga untuk grand total)
                                    $sub = [
                                        'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                        'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                    ];

                                    if (!empty($parent['children'])) {
                                        foreach ($parent['children'] as $c) {
                                            foreach ($sub as $k => $_) {
                                                if (isset($c[$k])) {
                                                    $sub[$k] += $c[$k];
                                                }
                                            }
                                        }
                                    }
                                    if (isset($c['total_tahun'])) {
                                        $sub['jumlah'] += $c['total_tahun'];
                                    }

                                    // 2. Tambahkan Subtotal ke Grand Total
                                    foreach ($grand_total as $k => $_) {
                                        if (isset($sub[$k])) {
                                            $grand_total[$k] += $sub[$k];
                                        }
                                    }
                                    ?>

                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="fw-bold table-primary">
                                <tr>
                                    <td colspan="2">JUMLAH BEBAN HPP SAMBUNGAN BARU</td>
                                    <td class="text-end"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>