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
        <p class="title">Biaya Sumber</p>
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
        <table class="data-table">
            <thead>
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
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $parent ?></td>
                        <td><?= strtoupper($parent_name) ?></td>
                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                            <td class="num">
                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num">
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
                <tr style="font-weight:bold;background-color:#cce5ff;">
                    <td colspan="2">TOTAL BIAYA SUMBER</td>
                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                        <td class="num"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        <p class="title">Biaya Pengolahan</p>
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
        <table class="data-table">
            <thead>
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
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $parent ?></td>
                        <td><?= strtoupper($parent_name) ?></td>
                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                            <td class="num">
                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num">
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
                <tr style="font-weight:bold;background-color:#cce5ff;">
                    <td colspan="2">TOTAL BIAYA PENGOLAHAN</td>
                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                        <td class="num"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        <p class="title">Biaya Transmisi & Distribusi</p>
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
        <table class="data-table">
            <thead>
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
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $parent ?></td>
                        <td><?= strtoupper($parent_name) ?></td>
                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                            <td class="num">
                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num">
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
                <tr style="font-weight:bold;background-color:#cce5ff;">
                    <td colspan="2">TOTAL BIAYA TRANSMISI & DISTRIBUSI</td>
                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                        <td class="num"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        <p class="title">Biaya Umum & Administrasi</p>
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
        <table class="data-table">
            <thead>
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
                    <tr style="font-weight:bold;background-color:#f8f9fa;">
                        <td><?= $parent ?></td>
                        <td><?= strtoupper($parent_name) ?></td>
                        <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                            <td class="num">
                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num">
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
                <tr style="font-weight:bold;background-color:#cce5ff;">
                    <td colspan="2">TOTAL BIAYA UMUM & ADMINISTRASI</td>
                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                        <td class="num"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        <p class="title">Beban HPP Sambungan Baru</p>
        <table class="data-table">
            <thead>
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
                                    <td class="center">
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
            <tfoot style="font-weight:bold;background-color:#cce5ff;">
                <tr>
                    <td colspan="2">JUMLAH BEBAN HPP SAMBUNGAN BARU</td>
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