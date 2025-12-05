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
                        <p><?= $title . ' ' .  $tahun; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">No Per</th>
                                    <th class="text-center">URAIAN</th>
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
                            <tbody>
                                <!-- Subsidi Tarif Air -->
                                <?php if (!empty($subsidi)) : ?>
                                    <tr class="table-secondary">
                                        <td></td>
                                        <td colspan="14"><b>Subsidi Selisih Tarif</b></td>
                                    </tr>
                                    <?php
                                    // inisialisasi subtotal
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
                                                <td class="text-end pe-1"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php $subsidi_total += $row['jumlah']; ?>
                                    <?php endforeach; ?>
                                    <!-- subtotal subsidi -->
                                    <tr class="table-warning fw-bold">
                                        <td></td>
                                        <td>&nbsp;&nbsp;Jumlah Subsidi Selisih Tarif</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($subsidi_total_bulan[$i], 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($subsidi_total, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endif; ?>

                                <!-- Jasa Penagihan Rekening/IT -->
                                <?php if (!empty($penagihan)) : ?>
                                    <tr class="table-secondary">
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
                                                <td class="text-end pe-1"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                        </tr>
                                        <?php $penagihan_total += $row['jumlah']; ?>
                                    <?php endforeach; ?>
                                    <!-- subtotal penagihan -->
                                    <tr class="table-warning fw-bold">
                                        <td></td>
                                        <td>&nbsp;&nbsp;Jumlah Jasa Penagihan</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($penagihan_total_bulan[$i], 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($penagihan_total, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endif; ?>

                                <!-- Grand Total -->
                                <?php if (!empty($subsidi) || !empty($penagihan)) : ?>
                                    <?php
                                    $grand_bulan = [];
                                    for ($i = 1; $i <= 12; $i++) {
                                        $grand_bulan[$i] = ($subsidi_total_bulan[$i] ?? 0) + ($penagihan_total_bulan[$i] ?? 0);
                                    }
                                    $grand_total = ($subsidi_total ?? 0) + ($penagihan_total ?? 0);
                                    ?>
                                    <tr class="table-success fw-bold">
                                        <td></td>
                                        <td>&nbsp;&nbsp;Jumlah Pendapatan Usaha Lain</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($grand_bulan[$i], 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.') ?></td>
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