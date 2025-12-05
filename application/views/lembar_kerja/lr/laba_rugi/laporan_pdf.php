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
        <div class="container-fluid">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <p class="fw-bold"><?= $title . ' ' .  $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center mt-2">
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
                                <!-- PENDAPATAN -->
                                <tr>
                                    <td class="fw-bold">PENDAPATAN USAHA</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Pendapatan Air</td>
                                    <?php
                                    $total = 0;
                                    // pastikan array ber-index 1..12
                                    $arr = isset($pendapatan_air) ? $pendapatan_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                <tr>
                                    <td>- Pendapatan Non Air</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pendapatan_non_air) ? $pendapatan_non_air : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Pendapatan Usaha Lainnya</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pendapatan_usaha_lainnya) ? $pendapatan_usaha_lainnya : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">TOTAL PENDAPATAN USAHA</td>
                                    <?php
                                    $totalPendapatanUsaha = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($pendapatan_air[$m]) ? $pendapatan_air[$m] : 0;
                                        $v2 = isset($pendapatan_non_air[$m]) ? $pendapatan_non_air[$m] : 0;
                                        $v3 = isset($pendapatan_usaha_lainnya[$m]) ? $pendapatan_usaha_lainnya[$m] : 0;

                                        $subPendapatan = $v1 + $v2 + $v3;
                                        $totalPendapatanUsaha[$m] = $subPendapatan; // simpan ke array
                                        $grand_total += $subPendapatan;

                                        echo '<td class="text-end fw-bold">' . number_format($subPendapatan, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <!-- BEBAN USAHA -->
                                <tr>
                                    <td class="fw-bold">BEBAN USAHA</td>
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
                                    <td class="fw-bold">TOTAL BEBAN USAHA</td>
                                    <?php
                                    $totalBebanUsaha = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($beban_sumber_air[$m]) ? $beban_sumber_air[$m] : 0;
                                        $v2 = isset($beban_pengolahan[$m]) ? $beban_pengolahan[$m] : 0;
                                        $v3 = isset($beban_transmisi[$m]) ? $beban_transmisi[$m] : 0;
                                        $v4 = isset($beban_sambungan[$m]) ? $beban_sambungan[$m] : 0;

                                        $subBeban = $v1 + $v2 + $v3 + $v4;
                                        $totalBebanUsaha[$m] = $subBeban; // simpan ke array
                                        $grand_total += $subBeban;

                                        echo '<td class="text-end fw-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">LABA / (RUGI) KOTOR</td>
                                    <?php
                                    $totalLabaRugi = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($totalPendapatanUsaha[$m]) ? $totalPendapatanUsaha[$m] : 0;
                                        $v2 = isset($totalBebanUsaha[$m]) ? $totalBebanUsaha[$m] : 0;

                                        $labaRugiKotor = $v1 - $v2;
                                        $totalLabaRugi[$m] = $labaRugiKotor; // simpan ke array
                                        $grand_total += $labaRugiKotor;

                                        echo '<td class="text-end fw-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>


                                <!-- BEBAN UMUM DAN ADMINISTRASI -->
                                <tr>
                                    <td class="fw-bold">BEBAN UMUM DAN ADMINISTRASI</td>
                                    <td colspan="13 "></td>
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
                                    <td class="fw-bold">TOTAL BEBAN UMUM DAN ADMINISTRASI</td>
                                    <?php
                                    $totalBebanUmum = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($beban_umum[$m]) ? $beban_umum[$m] : 0;

                                        $subBebanUmum = $v1;
                                        $totalBebanUmum[$m] = $subBebanUmum; // simpan ke array
                                        $grand_total += $subBebanUmum;

                                        echo '<td class="text-end fw-bold">' . number_format($subBebanUmum, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">LABA / (RUGI) OPERASIONAL</td>
                                    <?php
                                    $totalLro = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($totalLabaRugi[$m]) ? $totalLabaRugi[$m] : 0;
                                        $v2 = isset($totalBebanUmum[$m]) ? $totalBebanUmum[$m] : 0;

                                        $labaRugiKotor = $v1 - $v2;
                                        $totalLro[$m] = $labaRugiKotor; // simpan ke array
                                        $grand_total += $labaRugiKotor;

                                        echo '<td class="text-end fw-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <!-- PENDAPATAN (BEBAN) NON OPERASIONAL -->
                                <tr>
                                    <td class="fw-bold">PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Pendapatan Non Operasional</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pendapatan_non_operasional) ? $pendapatan_non_operasional : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Non Operasional</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($beban_non_operasional) ? $beban_non_operasional : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">JUMLAH PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                                    <?php
                                    $totalPbno = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($pendapatan_non_operasional[$m]) ? $pendapatan_non_operasional[$m] : 0;
                                        $v2 = isset($beban_non_operasional[$m]) ? $beban_non_operasional[$m] : 0;

                                        $subPbno = $v1 - $v2;
                                        $totalPbno[$m] = $subPbno; // simpan ke array
                                        $grand_total += $subPbno;

                                        echo '<td class="text-end fw-bold">' . number_format($subPbno, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <tr>
                                    <td class="fw-bold">LABA / (RUGI) SEBELUM PAJAK</td>
                                    <?php
                                    $totalLsp = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($totalLro[$m]) ? $totalLro[$m] : 0;
                                        $v2 = isset($totalPbno[$m]) ? $totalPbno[$m] : 0;

                                        $subLsp = $v1 + $v2;
                                        $totalLsp[$m] = $subLsp; // simpan ke array
                                        $grand_total += $subLsp;

                                        echo '<td class="text-end fw-bold">' . number_format($subLsp, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>

                                <!-- LUAR BIASA -->
                                <tr>
                                    <td class="fw-bold">KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                                    <td colspan="13 "></td>
                                </tr>
                                <tr>
                                    <td>- Keuntungan Luar Biasa</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($keuntungan_luar_biasa) ? $keuntungan_luar_biasa : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Kerugian Luar Biasa</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($kerugian_luar_biasa) ? $kerugian_luar_biasa : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">JUMLAH KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                                    <?php
                                    $totalKlb = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($keuntungan_luar_biasa[$m]) ? $keuntungan_luar_biasa[$m] : 0;
                                        $v2 = isset($kerugian_luar_biasa[$m]) ? $kerugian_luar_biasa[$m] : 0;

                                        $subKlb = $v1 - $v2;
                                        $totalKlb[$m] = $subKlb; // simpan ke array
                                        $grand_total += $subKlb;

                                        echo '<td class="text-end fw-bold">' . number_format($subKlb, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">PAJAK PENGHASILAN</td>
                                    <td colspan="13 "></td>
                                </tr>

                                <!-- PAJAK -->
                                <tr>
                                    <td>- Taksiran Pajak (Pasal 25)</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pajak_25) ? $pajak_25 : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Pajak Kini</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pajak_kini) ? $pajak_kini : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td>- Beban Pajak Ditangguhkan</td>
                                    <?php
                                    $total = 0;
                                    $arr = isset($pajak_tangguh) ? $pajak_tangguh : array_fill(1, 12, 0);
                                    for ($m = 1; $m <= 12; $m++) :
                                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                                        $total += $v;
                                    ?>
                                        <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                    <?php endfor; ?>
                                    <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">LABA / (RUGI) SETELAH PAJAK</td>
                                    <?php
                                    $totalLrsp = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    for ($m = 1; $m <= 12; $m++) {
                                        $v1 = isset($totalLsp[$m]) ? $totalLsp[$m] : 0;
                                        $v2 = isset($totalKlb[$m]) ? $totalKlb[$m] : 0;
                                        $v3 = isset($pajak_25[$m]) ? $pajak_25[$m] : 0;
                                        $v4 = isset($pajak_kini[$m]) ? $pajak_kini[$m] : 0;
                                        $v5 = isset($pajak_tangguh[$m]) ? $pajak_tangguh[$m] : 0;

                                        $sublrsp = $v1 + $v2 - $v3 - $v4 - $v5;
                                        $totalLrsp[$m] = $sublrsp; // simpan ke array
                                        $grand_total += $sublrsp;

                                        echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                                    }
                                    ?>
                                    <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
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