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
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
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
                                // ambil variabel upk dari controller
                                $upk = isset($upk) ? $upk : 'all';

                                // 1. Inisialisasi Grand Total
                                $grand_total = [
                                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                ];
                                ?>
                                <?php foreach ($biaya as $parent) : ?>
                                    <?php if ($upk != 'all' && $upk != '') : ?>
                                        <!-- TAMPILKAN CHILDREN JIKA UPK DIPILIH -->
                                        <?php if (!empty($parent['children'])) : ?>
                                            <?php foreach ($parent['children'] as $c) : ?>
                                                <tr>
                                                    <td><?= $c['kode']; ?></td>
                                                    <td><?= $c['uraian']; ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['jan'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['feb'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['mar'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['apr'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['mei'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['jun'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['jul'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['agu'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['sep'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['okt'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['nov'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1"><?= number_format($c['des'], 0, ',', '.'); ?></td>
                                                    <td class="text-end pe-1 fw-bold"><?= number_format($c['total_tahun'], 0, ',', '.'); ?></td>
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

                                    // 2. Tambahkan Subtotal ke Grand Total
                                    foreach ($grand_total as $k => $_) {
                                        if (isset($sub[$k])) {
                                            $grand_total[$k] += $sub[$k];
                                        }
                                    }
                                    ?>

                                    <!-- SUBTOTAL (selalu tampil) -->
                                    <tr class="fw-bold">
                                        <td><?= $parent['kode']; ?></td>
                                        <td><?= $parent['uraian']; ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['jan'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['feb'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['mar'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['apr'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['mei'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['jun'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['jul'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['agu'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['sep'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['okt'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['nov'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['des'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($sub['jumlah'], 0, ',', '.'); ?></td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="fw-bold" style="background-color: #e9ecef; border-top: 2px solid #6c757d;">
                                <tr>
                                    <td colspan="2">JUMLAH BIAYA UMUM & ADMINISTRASI</td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                                    <td class="text-end pe-1"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
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