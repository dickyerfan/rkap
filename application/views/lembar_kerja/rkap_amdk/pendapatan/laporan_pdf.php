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
                                    <th class="text-center">%</th>
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
                                $total_per_bulan = array_fill(1, 12, 0);
                                foreach ($produksi as $produk) :
                                ?>
                                    <tr class="fw-bold bg-light">
                                        <td><?= $produk['nama_produk'] ?>
                                        </td>
                                        <td></td>
                                        <?php
                                        $subtotal = 0;
                                        for ($i = 1; $i <= 12; $i++) :
                                            $val = $produk['produksi'][$i];
                                            $subtotal += $val;
                                            $total_per_bulan[$i] += $val;
                                        ?>
                                            <td class="text-end pe-1"><?= number_format($val, 0, ',', '.') ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1 fw-bold"><?= number_format($subtotal, 0, ',', '.') ?></td>
                                    </tr>

                                    <?php foreach ($produk['tarif'] as $kategori => $data_tarif) : ?>
                                        <tr>
                                            <!-- <td>- <?= 'Pendapatan ' . $produk['nama_produk'] . ' ' . $kategori   ?></td> -->
                                            <td>- <?= $produk['nama_produk'] . ' ' . $kategori   ?></td>
                                            <td class="text-center"><?= number_format($data_tarif['persen'], 0, ',', '.') ?></td>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) :
                                                $val = $data_tarif['produksi'][$i];
                                            ?>
                                                <td class="text-end pe-1"><?= number_format($val, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1"><?= number_format($data_tarif['subtotal'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>

                                <!-- Baris total bawah -->
                                <tr class="fw-bold bg-secondary text-white">
                                    <td>JUMLAH TOTAL</td>
                                    <td></td>
                                    <?php
                                    $grand_total = 0;
                                    for ($i = 1; $i <= 12; $i++) :
                                        $grand_total += $total_per_bulan[$i];
                                    ?>
                                        <td class="text-end pe-1"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="fw-bold">
                        KELOMPOK HARGA
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">URAIAN</th>
                                    <!-- <th class="text-center">Satuan</th> -->
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
                                <?php foreach ($pendapatan['harga'] as $produk) : ?>
                                    <tr class="fw-bold">
                                        <td><?= strtoupper($produk['nama_produk']); ?></td>
                                        <!-- <td class="text-center">-</td> -->
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($produk['harga']); ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1 fw-bold"><?= number_format($produk['harga'] * 12); ?></td>
                                    </tr>

                                    <?php foreach ($produk['tarif'] as $tarif => $row) : ?>
                                        <tr>
                                            <td class="ps-4">- <?= ucfirst($tarif); ?></td>
                                            <!-- <td class="text-center"><?= $row['persen']; ?>%</td> -->
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td class="text-end pe-1"><?= number_format($row['harga']); ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end pe-1 fw-bold"><?= number_format($row['harga'] * 12); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="fw-bold">
                        PENDAPATAN OPERASIONAL AMDK (Rp)
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">URAIAN</th>
                                    <th class="text-center">%</th>
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
                                <?php foreach ($pendapatan['pendapatan'] as $produk) : ?>
                                    <tr class="fw-bold">
                                        <td><?= strtoupper($produk['nama_produk']); ?></td>
                                        <td class="text-center">-</td>
                                        <?php
                                        $total = 0;
                                        for ($i = 1; $i <= 12; $i++) {
                                            echo '<td class="text-end pe-1">' . number_format($produk['pendapatan'][$i]) . '</td>';
                                            $total += $produk['pendapatan'][$i];
                                        }
                                        ?>
                                        <td class="text-end pe-1 fw-bold"><?= number_format($total); ?></td>
                                    </tr>

                                    <?php foreach ($produk['tarif'] as $tarif => $row) : ?>
                                        <tr>
                                            <td class="ps-4">- <?= ucfirst($tarif); ?></td>
                                            <td class="text-center"><?= number_format($row['persen'], 0); ?></td>
                                            <?php
                                            $subtotal = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo '<td class="text-end pe-1">' . number_format($row['pendapatan'][$i]) . '</td>';
                                                $subtotal += $row['pendapatan'][$i];
                                            }
                                            ?>
                                            <td class="text-end pe-1 fw-bold"><?= number_format($subtotal); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                            </tbody>
                            <!-- Total per bulan di bagian paling bawah -->
                            <?php
                            $total_per_bulan = array_fill(1, 12, 0);
                            $grand_total = 0;

                            foreach ($pendapatan['pendapatan'] as $produk) {
                                foreach ($produk['tarif'] as $tarif) {
                                    for ($i = 1; $i <= 12; $i++) {
                                        $total_per_bulan[$i] += $tarif['pendapatan'][$i];
                                    }
                                }
                            }

                            $grand_total = array_sum($total_per_bulan);
                            ?>
                            <tfoot>
                                <tr class="fw-bold bg-secondary text-white">
                                    <td>JUMLAH TOTAL</td>
                                    <td></td>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <td class="text-end pe-1"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                                    <?php endfor; ?>
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