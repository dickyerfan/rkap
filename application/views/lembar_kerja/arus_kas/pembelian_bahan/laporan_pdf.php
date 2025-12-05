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
            font-size: 0.65rem;
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
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <p class="text-center fw-bold">
                            <?= $title . ' ' .  $tahun; ?>
                        </p>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">No Per</th>
                                    <th class="text-center">Uraian</th>
                                    <th class="text-center">Vol</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Jan</th>
                                    <th class="text-center">Feb</th>
                                    <th class="text-center">Mar</th>
                                    <th class="text-center">Apr</th>
                                    <th class="text-center">Mei</th>
                                    <th class="text-center">Jun</th>
                                    <th class="text-center">Jul</th>
                                    <th class="text-center">Agu</th>
                                    <th class="text-center">Sep</th>
                                    <th class="text-center">Okt</th>
                                    <th class="text-center">Nov</th>
                                    <th class="text-center">Des</th>
                                    <th class="text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <?php if ($tahun == 2026) : ?>
                                <tbody>
                                    <?php
                                    $total_bulan = array_fill(1, 12, 0);
                                    $total_semua = 0;

                                    $exclude_bulan = array_fill(1, 12, 0);
                                    $exclude_total = 0;
                                    ?>

                                    <?php foreach ($barang as $b) : ?>
                                        <tr>
                                            <td class="text-center"><?= $b['no_per_id'] ?></td>
                                            <td><?= $b['nama_barang'] ?></td>
                                            <td class="text-center"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                                            <td class="text-end pe-1"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                                            <?php for ($m = 1; $m <= 12; $m++) :
                                                $nilai = $b['bulanData'][$m] ?? 0;
                                                $total_bulan[$m] += $nilai;

                                                if (in_array($b['id_barang'], [1, 2, 3])) {
                                                    $exclude_bulan[$m] += $nilai;
                                                }
                                            ?>
                                                <td class="text-end pe-1">
                                                    <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                                </td>
                                            <?php endfor; ?>

                                            <td class="text-end pe-1"><?= number_format($b['jumlah'], 0, ',', '.') ?></td>

                                            <?php
                                            $total_semua += $b['jumlah'];
                                            if (in_array($b['id_barang'], [1, 2, 3])) {
                                                $exclude_total += $b['jumlah'];
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr class="fw-bold bg-light">
                                        <td colspan="4" class="text-center">JUMLAH</td>
                                        <?php for ($m = 1; $m <= 12; $m++) :
                                            $final_bulan = $total_bulan[$m] - $exclude_bulan[$m];
                                        ?>
                                            <td class="text-end pe-1"><?= number_format($final_bulan, 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($total_semua - $exclude_total, 0, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            <?php else : ?>
                                <tbody>
                                    <?php
                                    $total_bulan = array_fill(1, 12, 0);
                                    $total_semua = 0;
                                    ?>

                                    <?php foreach ($barang as $b) : ?>
                                        <tr>
                                            <td class="text-center"><?= $b['no_per_id'] ?></td>
                                            <td><?= $b['nama_barang'] ?></td>
                                            <td class="text-center"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                                            <td class="text-end pe-1"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                                            <?php for ($m = 1; $m <= 12; $m++) :
                                                $nilai = $b['bulanData'][$m] ?? 0;
                                                $total_bulan[$m] += $nilai;
                                            ?>
                                                <td class="text-end pe-1">
                                                    <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                                </td>
                                            <?php endfor; ?>

                                            <td class="text-end pe-1">
                                                <?= number_format($b['jumlah'], 0, ',', '.') ?>
                                            </td>
                                        </tr>

                                        <?php $total_semua += $b['jumlah']; ?>
                                    <?php endforeach; ?>

                                    <tr class="fw-bold bg-light">
                                        <td colspan="4" class="text-center">JUMLAH</td>
                                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                                            <td class="text-end pe-1"><?= number_format($total_bulan[$m], 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>