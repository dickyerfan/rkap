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
            font-size: 0.65rem;
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
                        <p class="fw-bold mb-2 fs-6"><?= $title . ' ' .  $tahun; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
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
                                <tr>
                                    <td class="fw-bold">PENERIMAAN</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Penerimaan dari Pendapatan Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($penerimaan_air) ? $penerimaan_air : array_fill(1, 12, 0);
                                    $arr2 = isset($penerimaan_non_air) ? $penerimaan_non_air : array_fill(1, 12, 0);
                                    $arr3 = isset($penerimaan_lain_lain) ? $penerimaan_lain_lain : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $v2 = isset($arr2[$m]) ? $arr2[$m] : 0;
                                        $v3 = isset($arr3[$m]) ? $arr3[$m] : 0;
                                        $v4 = $v - $v2 - $v3;
                                        $total += $v4;
                                    ?>
                                        <td class="text-end"><?= number_format($v4, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                <tr>
                                    <td>- Penerimaan dari Pendapatan Non Air</td>
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
                                    <td>- Penerimaan dari Pendapatan Lain-lain</td>
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
                                    <td>- Penerimaan Aktiva Lancar lainnya</td>
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

                                        $subPenerimaan = ($v1 - $v2 - $v3) + $v2 + $v3 + $v4;
                                        $totalPenerimaan[$m] = $subPenerimaan; // simpan ke array
                                        $grand_total += $subPenerimaan;

                                        echo '<td class="text-end fw-bold">' . number_format($subPenerimaan, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">PENGELUARAN</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pegawai</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_pegawai) ? $beban_pegawai : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban B B M</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_bbm) ? $beban_bbm : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Kantor</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_kantor) ? $beban_kantor : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pemeliharaan</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_pemeliharaan) ? $beban_pemeliharaan : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pemakaian Barang AMDK</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_pemakaian_barang_amdk) ? $beban_pemakaian_barang_amdk : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Rupa-rupa</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_rupa_rupa) ? $beban_rupa_rupa : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pemeriksaan SNI</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_pemeriksaan_sni) ? $beban_pemeriksaan_sni : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Uji Kualitas Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_uji_kualitas_air) ? $beban_uji_kualitas_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban AMDK Lainnya</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_amdk_lainnya) ? $beban_amdk_lainnya : array_fill(1, 12, 0);
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
                                        $v1 = isset($beban_pegawai[$m]) ? $beban_pegawai[$m] : 0;
                                        $v2 = isset($beban_bbm[$m]) ? $beban_bbm[$m] : 0;
                                        $v3 = isset($beban_kantor[$m]) ? $beban_kantor[$m] : 0;
                                        $v4 = isset($beban_pemeliharaan[$m]) ? $beban_pemeliharaan[$m] : 0;
                                        $v5 = isset($beban_pemakaian_barang_amdk[$m]) ? $beban_pemakaian_barang_amdk[$m] : 0;
                                        $v6 = isset($beban_rupa_rupa[$m]) ? $beban_rupa_rupa[$m] : 0;
                                        $v7 = isset($beban_pemeriksaan_sni[$m]) ? $beban_pemeriksaan_sni[$m] : 0;
                                        $v8 = isset($beban_uji_kualitas_air[$m]) ? $beban_uji_kualitas_air[$m] : 0;
                                        $v9 = isset($beban_amdk_lainnya[$m]) ? $beban_amdk_lainnya[$m] : 0;

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
                                $saldo_awal = array_fill(1, 12, 0);
                                $saldo_akhir = array_fill(1, 12, 0);

                                $saldo_awal[1] = isset($saldo_awal_tahun) ? (float)$saldo_awal_tahun : 0;
                                for ($m = 1; $m <= 12; $m++) {
                                    $tk = isset($total_kotor[$m]) ? (float)$total_kotor[$m] : 0;
                                    $saldo_akhir[$m] = $saldo_awal[$m] + $tk;

                                    if ($m < 12) {
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
                                    echo '<td class="text-end fw-bold">' . number_format($saldo_awal[1], 0, ',', '.') . '</td>';
                                    ?>
                                </tr>

                                <tr>
                                    <td class="fw-bold">SALDO KAS SETARA KAS AKHIR TAHUN</td>
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        echo '<td class="text-end fw-bold">' . number_format($saldo_akhir[$m], 0, ',', '.') . '</td>';
                                    }
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