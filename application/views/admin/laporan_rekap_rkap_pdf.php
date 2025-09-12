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
            font-size: 1.2rem;
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
            font-size: 1.2rem;
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
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid">

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center mb-2">
                        <p class="fw-bold"><?= $title . ' ' .  $tahun + 1; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">Uraian</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4 fw-bold">Pendapatan</td>
                                    <td class="text-end pe-4"></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Pendapatan Air</td>
                                    <td class="text-end pe-4"><?= number_format($pendapatan_air_total, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Pendapatan Non Air</td>
                                    <td class="text-end pe-4"><?= number_format($pendapatan_non_air, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Pendapatan AMDK</td>
                                    <td class="text-end pe-4"><?= number_format($total_pend_amdk, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Jumlah Pendapatan</td>
                                    <td class="text-end pe-4 fw-bold"><?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Biaya</td>
                                    <td class="text-end pe-4"></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Biaya Usulan Barang</td>
                                    <td class="text-end pe-4"><?= number_format($biayaUsulanBarang, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Biaya Usulan Investasi</td>
                                    <td class="text-end pe-4"><?= number_format($biayaUsulanInvestasi, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Biaya Usulan Pemeliharaan</td>
                                    <td class="text-end pe-4"><?= number_format($biayaUsulanPemeliharaan, 0, ',', '.'); ?></td>
                                <tr>
                                    <td class="ps-4">Biaya Usulan Pegawai & Umum</td>
                                    <td class="text-end pe-4"><?= number_format($biayaUsulanUmum, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4">Biaya Usulan AMDK</td>
                                    <td class="text-end pe-4"><?= number_format($total_biaya_amdk, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 fw-bold">Jumlah Biaya</td>
                                    <td class="text-end pe-4 fw-bold"><?= number_format($total_biaya, 0, ',', '.'); ?></td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th class=" fw-bold ps-4">LABA / RUGI</th>
                                    <th class="text-end pe-4"><?= number_format($laba_rugi, 0, ',', '.'); ?></th>
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