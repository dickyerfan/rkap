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
                        <td width="5%">
                            <img src="<?= base_url('assets/img/tirta.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                            <p>Perumdam Ijen Tirta Bondowoso</p>
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
                        <p><?= $title . ' ' . $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th colspan="2">PERKIRAAN</th>
                                    <th>UPK</th>
                                    <th colspan="12">B U L A N</th>
                                    <th rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th>KODE</th>
                                    <th>NAMA</th>
                                    <th>BAGIAN</th>
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
                                $grand_total = [
                                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                ];
                                ?>
                                <?php if (!empty($detail)) : ?>
                                    <?php foreach ($detail as $row) : ?>
                                        <tr>
                                            <td><?= $row['kode']; ?></td>
                                            <td><?= $row['uraian']; ?></td>
                                            <td><?= $row['upk']; ?></td>
                                            <td class="text-end"><?= number_format($row['jan'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['feb'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['mar'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['apr'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['mei'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['jun'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['jul'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['agu'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['sep'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['okt'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['nov'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row['des'], 0, ',', '.'); ?></td>
                                            <td class="text-end fw-bold"><?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                        </tr>
                                        <?php
                                        $grand_total['jan'] += $row['jan'];
                                        $grand_total['feb'] += $row['feb'];
                                        $grand_total['mar'] += $row['mar'];
                                        $grand_total['apr'] += $row['apr'];
                                        $grand_total['mei'] += $row['mei'];
                                        $grand_total['jun'] += $row['jun'];
                                        $grand_total['jul'] += $row['jul'];
                                        $grand_total['agu'] += $row['agu'];
                                        $grand_total['sep'] += $row['sep'];
                                        $grand_total['okt'] += $row['okt'];
                                        $grand_total['nov'] += $row['nov'];
                                        $grand_total['des'] += $row['des'];
                                        $grand_total['jumlah'] += $row['jumlah'];
                                        ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="15" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot class="fw-bold" style="background-color: #e9ecef; border-top: 2px solid #6c757d;">
                                <tr>
                                    <td colspan="3">JUMLAH <?= strtoupper($nama_akun); ?></td>
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
