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
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center  align-middle">Uraian</th>
                                    <th rowspan="2" class="text-center  align-middle">Vol</th>
                                    <th rowspan="2" class="text-center  align-middle">Sat</th>
                                    <th rowspan="2" class="text-center  align-middle">Harga</th>
                                    <th colspan="12" class="text-center  align-middler">B U L A N</th>
                                    <th rowspan="2" class="text-center  align-middle">Jumlah</th>
                                </tr>
                                <tr class="text-center">
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
                                $grand_total = 0;
                                $grand_bulanan = array_fill(1, 12, 0);
                                foreach ($pemeliharaan as $jenis => $kategori_list) : ?>
                                    <!-- Judul Jenis -->
                                    <tr class="bg-primary text-white fw-bold">
                                        <td colspan="17"><?= strtoupper($jenis) ?></td>
                                    </tr>

                                    <?php
                                    $total_jenis = 0;
                                    $total_jenis_bulanan = array_fill(1, 12, 0);
                                    foreach ($kategori_list as $kategori => $items) : ?>
                                        <!-- Judul Kategori -->
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="17">&nbsp;&nbsp;&nbsp;<?= strtoupper($kategori) ?></td>
                                        </tr>

                                        <?php
                                        $total_kategori = 0;
                                        $total_kategori_bulanan = array_fill(1, 12, 0);

                                        foreach ($items as $p) :
                                            $total_kategori += $p['total_tahun'];
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_kategori_bulanan[$i] += $p['per_bulan'];
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $p['uraian'] ?></td>
                                                <td class="text-center"><?= $p['volume'] ?></td>
                                                <td class="text-center"><?= $p['satuan'] ?></td>
                                                <td class="text-end pe-1"><?= number_format($p['harga'], 0, ',', '.') ?></td>

                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end pe-1"><?= number_format($p['per_bulan'], 0, ',', '.') ?></td>
                                                <?php endfor; ?>

                                                <td class="text-end pe-1 fw-bold"><?= number_format($p['total_tahun'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- Jumlah per kategori -->
                                        <tr class="fw-bold text-end bg-light">
                                            <td colspan="4" class="text-start">Jumlah <?= $kategori ?></td>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) :
                                                echo '<td class="pe-1">' . number_format($total_kategori_bulanan[$i], 0, ',', '.') . '</td>';
                                                $total_jenis_bulanan[$i] += $total_kategori_bulanan[$i];
                                            endfor;
                                            ?>
                                            <td class="pe-1"><?= number_format($total_kategori, 0, ',', '.') ?></td>
                                        </tr>

                                        <?php $total_jenis += $total_kategori; ?>
                                    <?php endforeach; ?>

                                    <!-- Jumlah per jenis -->
                                    <tr class="fw-bold text-end bg-warning">
                                        <td colspan="4" class="text-start">Jumlah <?= $jenis ?></td>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) :
                                            echo '<td class="pe-1">' . number_format($total_jenis_bulanan[$i], 0, ',', '.') . '</td>';
                                            $grand_bulanan[$i] += $total_jenis_bulanan[$i];
                                        endfor;
                                        ?>
                                        <td class="pe-1"><?= number_format($total_jenis, 0, ',', '.') ?></td>
                                    </tr>

                                    <?php $grand_total += $total_jenis; ?>
                                <?php endforeach; ?>

                                <!-- Total keseluruhan -->
                                <tr class="fw-bold text-end bg-success text-white">
                                    <td colspan="4" class="text-start">TOTAL KESELURUHAN</td>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <td class="pe-1"><?= number_format($grand_bulanan[$i], 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="pe-1"><?= number_format($grand_total, 0, ',', '.') ?></td>
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