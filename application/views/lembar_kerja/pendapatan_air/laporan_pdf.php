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
        <div class="container-fluid px-2 mt-2">
            <div class="card-body">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun + 1 ?></p>
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
                                $uraianList = [
                                    'Pelanggan Akhir',
                                    'Pola Konsumsi',
                                    'Tarif Rata',
                                    'Penjualan Air',
                                    'Jasa Pemeliharaan',
                                    'Jasa Administrasi',
                                    'Tagihan Air'
                                ];

                                foreach ($uraianList as $judul) {
                                    echo "<tr><td colspan='14'><b>{$judul}</b></td></tr>";

                                    // loop per jenis pelanggan
                                    foreach ($data_pendapatan_air as $jp => $blok) {
                                        echo "<tr>";
                                        echo "<td>- {$jp}</td>";

                                        $jumlahKolom = 0;
                                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                                            $nilai = isset($blok[$judul][$bulan]) ? $blok[$judul][$bulan] : 0;
                                            echo "<td class='text-end pe-1'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                            if (in_array($judul, ['Pelanggan Akhir', 'Pola Konsumsi', 'Tarif Rata'])) {
                                                if ($bulan == 12) {
                                                    $jumlahKolom = $nilai; // ambil Desember
                                                }
                                            } else {
                                                $jumlahKolom += $nilai; // normal: sum
                                            }
                                        }
                                        echo "<td class='text-end pe-1'><b>" . number_format($jumlahKolom, 0, ',', '.') . "</b></td>";
                                        echo "</tr>";
                                    }

                                    // ===== TOTAL BAWAH =====
                                    echo "<tr style='background:#eee;font-weight:bold;'>";
                                    echo "<td>Jumlah {$judul}</td>";

                                    $grand = 0;
                                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                                        $totalBulan = 0;
                                        $countJenis = count($data_pendapatan_air);

                                        foreach ($data_pendapatan_air as $blok) {
                                            $totalBulan += $blok[$judul][$bulan] ?? 0;
                                        }

                                        if (in_array($judul, ['Pola Konsumsi', 'Tarif Rata'])) {
                                            // rata-rata per jenis pelanggan
                                            $nilai = $countJenis > 0 ? $totalBulan / $countJenis : 0;
                                            echo "<td class='text-end pe-1'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                            if ($bulan == 12) {
                                                $grand = $nilai; // ambil Desember
                                            }
                                        } elseif ($judul == 'Pelanggan Akhir') {
                                            echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                            if ($bulan == 12) {
                                                $grand = $totalBulan; // ambil Desember
                                            }
                                        } else {
                                            echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                            $grand += $totalBulan; // normal sum
                                        }
                                    }

                                    echo "<td class='text-end pe-1'>" . number_format($grand, 0, ',', '.') . "</td>";
                                    echo "</tr>";
                                }
                                ?>
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