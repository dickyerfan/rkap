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
                        <p><?= $title . ' ' .  $tahun ?></p>
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
                                // Mapping label tampil => key data di model
                                $uraianList = [
                                    'Pelanggan Akhir'   => 'Pelanggan Akhir',
                                    'Pola Konsumsi'     => 'Pola Konsumsi',
                                    'Tarif Rata'        => 'Tarif Rata',
                                    'Penjualan Air'     => 'Penjualan Air',
                                    'Biaya Pemeliharaan'=> 'Jasa Pemeliharaan',
                                    'Biaya Administrasi'=> 'Jasa Administrasi',
                                    'Tagihan Air'       => 'Tagihan Air'
                                ];

                                foreach ($uraianList as $label => $key) {
                                    echo "<tr><td colspan='14'><b>{$label}</b></td></tr>";

                                    // loop per jenis pelanggan
                                    foreach ($data_pendapatan_air as $jp => $blok) {
                                        echo "<tr>";
                                        echo "<td>- {$jp}</td>";

                                        $jumlahKolom = 0;
                                        for ($bulan = 1; $bulan <= 12; $bulan++) {
                                            $nilai = isset($blok[$key][$bulan]) ? $blok[$key][$bulan] : 0;
                                            $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                                            echo "<td class='text-end pe-1'>" . number_format($nilai, $desimal, ',', '.') . "</td>";

                                            if (in_array($key, ['Pelanggan Akhir', 'Pola Konsumsi', 'Tarif Rata'])) {
                                                if ($bulan == 12) {
                                                    $jumlahKolom = $nilai; // ambil Desember
                                                }
                                            } else {
                                                $jumlahKolom += $nilai; // normal: sum
                                            }
                                        }
                                        $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                                        echo "<td class='text-end pe-1'><b>" . number_format($jumlahKolom, $desimal, ',', '.') . "</b></td>";
                                        echo "</tr>";
                                    }

                                    // ===== TOTAL BAWAH =====
                                    echo "<tr style='background:#eee;font-weight:bold;'>";
                                    echo "<td>Jumlah {$label}</td>";

                                    $grand = 0;
                                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                                        if (in_array($key, ['Pola Konsumsi', 'Tarif Rata'])) {
                                            // Ambil dari total yang sudah dihitung rata-rata tertimbang di model
                                            $nilai = $total_pendapatan_air[$key][$bulan] ?? 0;
                                            $desimal = ($key == 'Pola Konsumsi') ? 2 : 0;
                                            echo "<td class='text-end pe-1'>" . number_format($nilai, $desimal, ',', '.') . "</td>";

                                        } elseif ($key == 'Pelanggan Akhir') {
                                            $totalBulan = 0;
                                            foreach ($data_pendapatan_air as $blok) {
                                                $totalBulan += $blok[$key][$bulan] ?? 0;
                                            }
                                            echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                            if ($bulan == 12) {
                                                $grand = $totalBulan;
                                            }
                                        } else {
                                            $totalBulan = 0;
                                            foreach ($data_pendapatan_air as $blok) {
                                                $totalBulan += $blok[$key][$bulan] ?? 0;
                                            }
                                            echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                            $grand += $totalBulan;
                                        }
                                    }

                                    // Hitung TOTAL (JUMLAH) berdasarkan jenis
                                    if ($key == 'Pola Konsumsi') {
                                        // Rata-rata tertimbang: Σ(pelanggan × pola) / Σ(pelanggan)
                                        $total_pola_tahun = 0;
                                        $total_pel_tahun = 0;
                                        for ($m = 1; $m <= 12; $m++) {
                                            $pel = $total_pendapatan_air['Pelanggan Akhir'][$m] ?? 0;
                                            $pola = $total_pendapatan_air['Pola Konsumsi'][$m] ?? 0;
                                            $total_pola_tahun += $pel * $pola;
                                            $total_pel_tahun += $pel;
                                        }
                                        $grand = ($total_pel_tahun > 0) ? $total_pola_tahun / $total_pel_tahun : 0;
                                    }

                                    $desimal_grand = ($key == 'Pola Konsumsi') ? 2 : 0;
                                    echo "<td class='text-end pe-1'>" . number_format($grand, $desimal_grand, ',', '.') . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php if ($upk == 1 || $upk == '') : ?>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <p><?= $title2 . ' ' .  $tahun; ?></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
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
                                            <td colspan="14"><strong>Pend Penj Air Lainnya</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="14" style="padding-left: 20px;">- Terminal Air (TA)</td>
                                        </tr>

                                        <?php
                                        // Definisikan baris dan labelnya agar mudah di-loop
                                        $uraian_list = [
                                            'penggunaan_rata2' => 'Jumlah Penggunaan rata2',
                                            'm3_rata2' => 'Jumlah M3 rata2',
                                            'tarif_rata2' => 'Tarif rata2'
                                        ];

                                        foreach ($uraian_list as $key => $label) :
                                            // Cek apakah data untuk baris ini ada
                                            if (isset($tangki_air[$key])) :
                                                $is_nilai_penjualan = ($key == 'nilai_penjualan');
                                        ?>
                                                <tr>
                                                    <td style="padding-left: 27px;"><?= $is_nilai_penjualan ? "<strong>{$label}</strong>" : $label; ?></td>
                                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                        <td class="text-end pe-1">
                                                            <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end pe-1">
                                                        <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key]['total'], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key]['total'], 0, ',', '.'); ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr style="background:#eee;font-weight:bold;">
                                            <td>Jumlah Pend Penj Air Lainnya</td>
                                            <?php
                                            $grand_total = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_bulan = $tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i];
                                                echo "<td class='text-end pe-1'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                                                $grand_total += $total_bulan;
                                            }
                                            ?>
                                            <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>