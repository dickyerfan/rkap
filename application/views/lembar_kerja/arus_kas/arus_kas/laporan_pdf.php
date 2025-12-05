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
            height: 15px;
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
                        <p><?= $title . ' ' .  $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="text-center align-middle">
                                <tr class="text-center">
                                    <th>URAIAN</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>Mei</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Ags</th>
                                    <th>Sep</th>
                                    <th>Okt</th>
                                    <th>Nov</th>
                                    <th>Des</th>
                                    <th>JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- PENERIMAAN -->
                                <tr>
                                    <td class="fw-bold">PENERIMAAN</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Penerimaan Air</td>
                                    <?php
                                    $total = 0;
                                    // pastikan array ber-index 1..12
                                    $arr = isset($penerimaan_air) ? $penerimaan_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                <tr>
                                    <td>- Penerimaan Non Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($penerimaan_non_air) ? $penerimaan_non_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Penerimaan lain-lain</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($penerimaan_lain_lain) ? $penerimaan_lain_lain : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Penerimaan Aktiva lainnya</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($penerimaan_aktiva_lainnya) ? $penerimaan_aktiva_lainnya : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">JUMLAH PENERIMAAN</td>
                                    <?php
                                    $totalPenerimaan = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($penerimaan_air[$m]) ? $penerimaan_air[$m] : 0;
                                        $v2 = isset($penerimaan_non_air[$m]) ? $penerimaan_non_air[$m] : 0;
                                        $v3 = isset($penerimaan_aktiva_lainnya[$m]) ? $penerimaan_aktiva_lainnya[$m] : 0;
                                        $v4 = isset($penerimaan_lain_lain[$m]) ? $penerimaan_lain_lain[$m] : 0;

                                        $subPenerimaan = $v1 + $v2 + $v3 + $v4;
                                        $totalPenerimaan[$m] = $subPenerimaan; // simpan ke array
                                        $grand_total += $subPenerimaan;

                                        echo '<td class="text-end fw-bold">' . number_format($subPenerimaan, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <!-- PENGELUARAN -->
                                <tr>
                                    <td class="fw-bold">PENGELUARAN</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Beban Sumber Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_sumber_air) ? $beban_sumber_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pengolahan Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_pengolahan) ? $beban_pengolahan : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Transmisi dan Distribusi</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_transmisi) ? $beban_transmisi : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Umum dan Administrasi</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_umum) ? $beban_umum : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban (HPP) Sambungan Baru</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_sambungan) ? $beban_sambungan : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Lain -lain</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_lain_lain) ? $beban_lain_lain : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Pembayaran Pajak</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pembayaran_pajak) ? $pembayaran_pajak : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Pembayaran Aktiva Lancar lain-lain</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pembayaran_aktiva_lainnya) ? $pembayaran_aktiva_lainnya : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Pembayaran Liabilitas Lancar lain-lain</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pembayaran_liabilitas_lainnya) ? $pembayaran_liabilitas_lainnya : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">JUMLAH PENGELUARAN</td>
                                    <?php
                                    $totalBebanUsaha = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($beban_sumber_air[$m]) ? $beban_sumber_air[$m] : 0;
                                        $v2 = isset($beban_pengolahan[$m]) ? $beban_pengolahan[$m] : 0;
                                        $v3 = isset($beban_transmisi[$m]) ? $beban_transmisi[$m] : 0;
                                        $v4 = isset($beban_sambungan[$m]) ? $beban_sambungan[$m] : 0;
                                        $v5 = isset($beban_umum[$m]) ? $beban_umum[$m] : 0;
                                        $v6 = isset($beban_lain_lain[$m]) ? $beban_lain_lain[$m] : 0;
                                        $v7 = isset($pembayaran_pajak[$m]) ? $pembayaran_pajak[$m] : 0;
                                        $v8 = isset($pembayaran_aktiva_lainnya[$m]) ? $pembayaran_aktiva_lainnya[$m] : 0;
                                        $v9 = isset($pembayaran_liabilitas_lainnya[$m]) ? $pembayaran_liabilitas_lainnya[$m] : 0;

                                        $subBeban = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8 + $v9;
                                        $totalBebanUsaha[$m] = $subBeban; // simpan ke array
                                        $grand_total += $subBeban;

                                        echo '<td class="text-end fw-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">ARUS KAS DARI AKTIVITAS INVESTASI</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Penambahan Aset Tetap</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($penambahan_aset_tetap) ? $penambahan_aset_tetap : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Arus Kas Bersih digunakan Investasi</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($investasi) ? $investasi : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ARUS KAS DARI AKTIVITAS PENDANAAN</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Pembayaran Jasa Produksi dan Tantiem</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($jasa_produksi) ? $jasa_produksi : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ARUS KAS BERSIH UNTUK AKTIVITAS PENDANAAN</td>
                                    <?php
                                    $totalInvestasi = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($penambahan_aset_tetap[$m]) ? $penambahan_aset_tetap[$m] : 0;
                                        $v2 = isset($investasi[$m]) ? $investasi[$m] : 0;
                                        $v3 = isset($jasa_produksi[$m]) ? $jasa_produksi[$m] : 0;

                                        $sublrsp = $v1 + $v2 + $v3;
                                        $totalInvestasi[$m] = $sublrsp; // simpan ke array
                                        $grand_total += $sublrsp;

                                        echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">KENAIKAN /BERKURANG BERSIH KAS & SETARA KAS</td>
                                    <?php
                                    $total_kotor = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($totalPenerimaan[$m]) ? $totalPenerimaan[$m] : 0;
                                        $v2 = isset($totalBebanUsaha[$m]) ? $totalBebanUsaha[$m] : 0;
                                        $v3 = isset($totalInvestasi[$m]) ? $totalInvestasi[$m] : 0;

                                        $sublrsp = $v1 - $v2 - $v3;
                                        $total_kotor[$m] = $sublrsp; // simpan ke array
                                        $grand_total += $sublrsp;

                                        echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>
                                <?php
                                // inisialisasi
                                $saldo_awal = array_fill(1, 12, 0);
                                $saldo_akhir = array_fill(1, 12, 0);

                                // set saldo awal Januari dari DB
                                $saldo_awal[1] = isset($saldo_awal_tahun) ? (float)$saldo_awal_tahun : 0;

                                // hitung berurutan: untuk m = 1..12 => saldo_akhir[m] = saldo_awal[m] + total_kotor[m]
                                // lalu saldo_awal[m+1] = saldo_akhir[m] (kecuali m=12)
                                for ($m = 1; $m <= 12; $m++) {
                                    $tk = isset($total_kotor[$m]) ? (float)$total_kotor[$m] : 0;
                                    $saldo_akhir[$m] = $saldo_awal[$m] + $tk;

                                    if ($m < 12) {
                                        // untuk bulan berikutnya
                                        $saldo_awal[$m + 1] = $saldo_akhir[$m];
                                    }
                                }
                                ?>
                                <tr>
                                    <td class="fw-bold">SALDO KAS SETARA KAS AWAL TAHUN</td>
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        echo '<td class="text-end fw-bold">' . number_format($saldo_awal[$m], 0, ',', '.') . '</td>';
                                    }
                                    // Jumlah di sebelah kanan menampilkan saldo awal tahun (saldo_awal[1])
                                    echo '<td class="text-end fw-bold">' . number_format($saldo_awal[1], 0, ',', '.') . '</td>';
                                    ?>
                                </tr>

                                <!-- Tampilkan: SALDO KAS SETARA KAS AKHIR TAHUN -->
                                <tr>
                                    <td class="fw-bold">SALDO KAS SETARA KAS AKHIR TAHUN</td>
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        echo '<td class="text-end fw-bold">' . number_format($saldo_akhir[$m], 0, ',', '.') . '</td>';
                                    }
                                    // Jumlah di kanan: saldo akhir Desember
                                    echo '<td class="text-end fw-bold">' . number_format($saldo_akhir[12], 0, ',', '.') . '</td>';
                                    ?>
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