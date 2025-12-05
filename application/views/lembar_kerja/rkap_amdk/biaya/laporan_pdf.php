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
            font-size: 0.7rem;
            height: 20px;
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
                        <p class="fw-bold mb-2 fs-6"><?= $title . ' ' .  $tahun; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <?php
                        $map_bulan = [
                            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                        ];

                        // kelompokkan berdasarkan parent kode
                        $grouped = [];
                        foreach ($biaya as $r) {
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

                        // ambil nama parent dari tabel no_per jika perlu, sementara kita ambil prefix
                        ?>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
                                    <th rowspan="2">U R A I A N</th>
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
                                        ->row('name') ?? 'Kelompok ' . $parent;
                                ?>
                                    <!-- Header parent -->
                                    <tr class="fw-bold table-secondary">
                                        <td><?= $parent ?></td>
                                        <td colspan="15"><?= strtoupper($parent_name) ?></td>
                                    </tr>

                                    <!-- Children -->
                                    <?php foreach ($data_parent['children'] as $child) : ?>
                                        <tr>
                                            <td><?= $child['kode'] ?></td>
                                            <td><?= $child['name'] ?></td>
                                            <td><?= $child['uraian'] ?></td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end pe-1"><?= number_format($child[$nama_bulan], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end pe-1 fw-bold"><?= number_format($child['total_tahun'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- Subtotal per parent -->
                                    <tr class="fw-bold bg-light">
                                        <td colspan="3" class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td>
                                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                            <td class="text-end pe-1">
                                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td class="text-end pe-1">
                                            <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php
                                    // akumulasi total seluruh AMDK
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                    }
                                    $total_semua += $data_parent['subtotal']['total_tahun'];
                                endforeach;
                                ?>

                                <!-- TOTAL AKHIR -->
                                <tr class="fw-bold table-primary">
                                    <td colspan="3" class="text-start">TOTAL BIAYA AMDK</td>
                                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                        <td class="text-end pe-1"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                    <?php endforeach; ?>
                                    <td class="text-end pe-1"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                </tr>
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