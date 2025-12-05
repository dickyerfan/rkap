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
                                    <th rowspan="2" class="text-center align-middle">NO</th>
                                    <th rowspan="2" class="text-center  align-middle">Uraian</th>
                                    <th rowspan="2" class="text-center  align-middle">Prod</th>
                                    <th rowspan="2" class="text-center  align-middle">Volume</th>
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
                                $no = 1;
                                $produk_sekarang = null;
                                $grand_total_per_bulan = array_fill(1, 12, 0);
                                $grand_total_tahun = 0;
                                $subtotal_per_produk = array_fill(1, 12, 0);
                                $total_tahun_produk = 0;
                                ?>

                                <?php foreach ($bahan_baku as $bahan) : ?>
                                    <?php
                                    $nilai_per_bulan = $bahan['total_tahun'] / 12;
                                    $subtotal = $bahan['total_tahun'];
                                    $jumlah_produksi = $bahan['jumlah_produksi'];

                                    // Jika produk berubah, tampilkan header baru
                                    if ($produk_sekarang !== $bahan['nama_produk']) :
                                        // Jika bukan produk pertama, tampilkan total produk sebelumnya
                                        if ($produk_sekarang !== null) : ?>
                                            <tr style="font-weight:bold;background:#f9f9f9;">
                                                <td colspan="5" class="text-start">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end pe-1"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end pe-1"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endif;

                                        // Reset subtotal untuk produk baru
                                        $subtotal_per_produk = array_fill(1, 12, 0);
                                        $total_tahun_produk = 0;
                                        $no = 1;
                                        $produk_sekarang = $bahan['nama_produk'];
                                        ?>
                                        <!-- JUDUL PRODUK -->
                                        <tr>
                                            <td colspan="2" class="text-center fw-bold">BAHAN BAKU <?= strtoupper($produk_sekarang); ?></td>
                                            <td colspan="16"></td>
                                        </tr>
                                    <?php endif; ?>

                                    <!-- Baris bahan -->
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-left"><?= $bahan['nama_bahan']; ?></td>
                                        <td class="text-end pe-1"><?= number_format($jumlah_produksi, 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($bahan['volume'], 0, ',', '.'); ?></td>
                                        <td class="text-end pe-1"><?= number_format($bahan['harga_satuan'], 0, ',', '.'); ?></td>

                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($nilai_per_bulan, 0, ',', '.'); ?></td>
                                            <?php
                                            $subtotal_per_produk[$i] += $nilai_per_bulan;
                                            $grand_total_per_bulan[$i] += $nilai_per_bulan;
                                            ?>
                                        <?php endfor; ?>

                                        <td class="text-end pe-1"><?= number_format($subtotal, 0, ',', '.'); ?></td>
                                    </tr>

                                    <?php
                                    $total_tahun_produk += $subtotal;
                                    $grand_total_tahun += $subtotal;
                                    ?>
                                <?php endforeach; ?>

                                <!-- TOTAL PRODUK TERAKHIR -->
                                <?php if ($produk_sekarang !== null) : ?>
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-start">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end pe-1"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                                        <?php endfor; ?>
                                        <td class="text-end pe-1"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <!-- TOTAL KESELURUHAN -->
                                <tr style="font-weight:bold;background:#e3e3e3;">
                                    <td colspan="5" class="text-start">JUMLAH</td>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <td class="text-end pe-1"><?= number_format($grand_total_per_bulan[$i], 0, ',', '.'); ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end pe-1"><?= number_format($grand_total_tahun, 0, ',', '.'); ?></td>
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