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
                                <?php
                                $grand_total = 0;
                                foreach ($pendapatan as $komponen => $data) :
                                    $grand_total += $data['total'];
                                ?>
                                    <tr>
                                        <td class="text-start"><?= $komponen ?></td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($data['bulan'][$i], 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="fw-bold text-end pe-1"><?= number_format($data['total'], 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold bg-light">
                                    <td>Total</td>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        $total_bulan = 0;
                                        foreach ($pendapatan as $data) {
                                            $total_bulan += $data['bulan'][$i];
                                        }
                                        echo "<td class='text-end pe-1'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                                    }
                                    ?>
                                    <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.') ?></td>
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