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
                        <p><strong>AIR PRODUKSI</strong></p>
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
                                <?php if (!empty($air_produksi)) : ?>
                                    <?php
                                    $grand_total = 0;
                                    $total_per_bulan = array_fill(1, 12, 0); // inisialisasi total per bulan
                                    foreach ($air_produksi as $row) :
                                        $jan = $row['produksi_total'] / 12; // dibagi rata per bulan
                                        $grand_total += $row['produksi_total'];

                                        for ($i = 1; $i <= 12; $i++) {
                                            $total_per_bulan[$i] += $jan;
                                        }
                                    ?>
                                        <tr>
                                            <td>- <?= $row['uraian'] ?></td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td class="text-end"><?= number_format($jan, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end"><strong><?= number_format($row['produksi_total'], 0, ',', '.') ?></strong></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr>
                                        <td><strong>Jumlah Produksi</strong></td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <td class="text-end"><strong><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></strong></td>
                                        <?php endfor; ?>
                                        <td class="text-end"><strong><?= number_format($grand_total, 0, ',', '.') ?></strong></td>
                                    </tr>

                                <?php else : ?>
                                    <tr>
                                        <td colspan="15" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <p><strong>AIR TERJUAL</strong></p>
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
                                $grand_total = array_fill(1, 12, 0);

                                foreach ($air_terjual as $jp => $bulanData) {
                                    echo "<tr>";
                                    echo "<td>{$jp}</td>";

                                    $jumlah = 0;
                                    for ($m = 1; $m <= 12; $m++) {
                                        $nilai = isset($bulanData[$m]) ? $bulanData[$m] : 0;
                                        echo "<td class='text-end'>" . number_format($nilai, 0, ',', '.') . "</td>";
                                        $jumlah += $nilai;
                                        $grand_total[$m] += $nilai;
                                    }

                                    echo "<td class='text-end'><b>" . number_format($jumlah, 0, ',', '.') . "</b></td>";
                                    echo "</tr>";
                                }

                                // === TOTAL BAWAH ===
                                echo "<tr style='background:#eee;font-weight:bold;'>";
                                echo "<td>JUMLAH</td>";
                                $grand_sum = 0;
                                for ($m = 1; $m <= 12; $m++) {
                                    echo "<td class='text-end'>" . number_format($grand_total[$m], 0, ',', '.') . "</td>";
                                    $grand_sum += $grand_total[$m];
                                }
                                echo "<td class='text-end'>" . number_format($grand_sum, 0, ',', '.') . "</td>";
                                echo "</tr>";
                                ?>
                            </tbody>
                        </table>
                        <br><br><br>
                        <p><strong>KEHILANGAN AIR</strong></p>
                        <?php
                        // --- DATA PRODUKSI & AIR TERJUAL PER BULAN ---
                        $total_produksi_bulan = isset($total_per_bulan) ? $total_per_bulan : array_fill(1, 12, 0);
                        $total_terjual_bulan  = isset($grand_total) ? $grand_total : array_fill(1, 12, 0);

                        // --- HITUNG KEHILANGAN ---
                        $kehilangan_bulan = [];
                        $total_kehilangan = 0;
                        ?>
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
                                <tr>
                                    <td><strong>Kehilangan Air (M3)</strong></td>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <?php
                                        $prod   = $total_produksi_bulan[$i] ?? 0;
                                        $jual   = $total_terjual_bulan[$i] ?? 0;
                                        $hilang = max(0, $prod - $jual);

                                        $kehilangan_bulan[$i] = $hilang;
                                        $total_kehilangan    += $hilang;
                                        ?>
                                        <td class="text-end"><?= number_format($hilang, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end"><strong><?= number_format($total_kehilangan, 0, ',', '.') ?></strong></td>
                                </tr>

                                <!-- BARIS PERSENTASE KEHILANGAN -->
                                <tr>
                                    <td><strong>Persentase Kehilangan (%)</strong></td>
                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                        <?php
                                        $prod = $total_produksi_bulan[$i] ?? 0;
                                        $persen = ($prod > 0) ? ($kehilangan_bulan[$i] / $prod * 100) : 0;
                                        ?>
                                        <td class="text-end"><?= number_format($persen, 2, ',', '.') ?>%</td>
                                    <?php endfor; ?>

                                    <?php
                                    $total_produksi_tahun = array_sum($total_produksi_bulan);
                                    $persen_tahun = ($total_produksi_tahun > 0)
                                        ? ($total_kehilangan / $total_produksi_tahun * 100)
                                        : 0;
                                    ?>
                                    <td class="text-end"><strong><?= number_format($persen_tahun, 2, ',', '.') ?>%</strong></td>
                                </tr>
                                <?php
                                // Ambil total pelanggan akhir dari hasil model
                                $total_pelanggan_akhir = isset($result['total']['Pelanggan Akhir'])
                                    ? $result['total']['Pelanggan Akhir']
                                    : array_fill(1, 12, 0);
                                ?>
                                <tr>
                                    <td><strong>Pelanggan Akhir</strong></td>

                                    <?php
                                    $jumlah_pelanggan_setahun = 0;
                                    for ($i = 1; $i <= 12; $i++) :
                                        $pel = $total_pelanggan_akhir[$i] ?? 0;
                                        $jumlah_pelanggan_setahun += $pel;
                                    ?>
                                        <td class="text-end"><?= number_format($pel, 0, ',', '.') ?></td>
                                    <?php endfor; ?>

                                    <td class="text-end"><strong><?= number_format($jumlah_pelanggan_setahun, 0, ',', '.') ?></strong></td>
                                </tr>

                                <tr>
                                    <td><strong>Pola Konsumsi (%)</strong></td>

                                    <?php
                                    $total_pola_real = 0;
                                    for ($i = 1; $i <= 12; $i++) :
                                        $pelanggan = $total_pelanggan_akhir[$i] ?? 0;
                                        $air_terjual = $total_terjual_bulan[$i] ?? 0;

                                        $pola_real = ($air_terjual > 0) ? ($air_terjual / $pelanggan) : 0;

                                        $total_pola_real += $pola_real;
                                    ?>
                                        <td class="text-end"><?= number_format($pola_real, 2, ',', '.') ?></td>
                                    <?php endfor; ?>

                                    <td class="text-end"><strong><?= number_format($total_pola_real / 12, 2, ',', '.') ?></strong></td>
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