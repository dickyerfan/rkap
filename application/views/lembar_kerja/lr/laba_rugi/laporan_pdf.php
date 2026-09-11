<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RKAP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            margin: 20pt 20pt 30pt 80pt;
        }

        header table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        header td {
            border: none;
            padding: 2px;
            vertical-align: middle;
        }

        header p {
            margin: 0;
            font-size: 10pt;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        .title {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 6px 0;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
            font-size: 6.5pt;
        }

        table.data-table th {
            text-align: center;
            font-weight: bold;
        }

        table.data-table td.num {
            text-align: right;
        }

        table.data-table td.num-bold {
            text-align: right;
            font-weight: bold;
        }

        table.data-table td.center {
            text-align: center;
        }

        table.data-table tfoot td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 2px solid #6c757d;
        }
    </style>
</head>

<body>
    <header>
        <table>
            <tr>
                <td width="40">
                    <?php
                    $logo_path = FCPATH . 'assets/img/tirta.png';
                    if (file_exists($logo_path)) :
                        $logo_data = base64_encode(file_get_contents($logo_path));
                        $logo_mime = mime_content_type($logo_path);
                    ?>
                        <img src="data:<?= $logo_mime; ?>;base64,<?= $logo_data; ?>" alt="Logo" width="40">
                    <?php endif; ?>
                </td>
                <td>
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' . $tahun ?></p>
        <table class="data-table">
            <thead>
                <tr>
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
                    <td style="font-weight: bold;">PENDAPATAN USAHA</td>
                    <td colspan="13"></td>
                </tr>
                <tr>
                    <td>- Pendapatan Air</td>
                    <?php
                    $total = 0;
                    $arr = isset($pendapatan_air) ? $pendapatan_air : array_fill(1, 12, 0);
                    for ($m = 1; $m <= 12; $m++) :
                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                        $total += $v;
                    ?>
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                <tr>
                    <td>- Pendapatan Non Air</td>
                    <?php
                    $total = 0;
                    $arr = isset($pendapatan_non_air) ? $pendapatan_non_air : array_fill(1, 12, 0);
                    for ($m = 1; $m <= 12; $m++) :
                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                        $total += $v;
                    ?>
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">TOTAL PENDAPATAN USAHA</td>
                    <?php
                    $totalPendapatanUsaha = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($pendapatan_air[$m]) ? $pendapatan_air[$m] : 0;
                        $v2 = isset($pendapatan_non_air[$m]) ? $pendapatan_non_air[$m] : 0;
                        $v3 = isset($pendapatan_usaha_lainnya[$m]) ? $pendapatan_usaha_lainnya[$m] : 0;

                        $subPendapatan = $v1 + $v2 + $v3;
                        $totalPendapatanUsaha[$m] = $subPendapatan;
                        $grand_total += $subPendapatan;

                        echo '<td class="num-bold">' . number_format($subPendapatan, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <!-- BEBAN USAHA -->
                <tr>
                    <td style="font-weight: bold;">BEBAN USAHA</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">TOTAL BEBAN USAHA</td>
                    <?php
                    $totalBebanUsaha = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($beban_sumber_air[$m]) ? $beban_sumber_air[$m] : 0;
                        $v2 = isset($beban_pengolahan[$m]) ? $beban_pengolahan[$m] : 0;
                        $v3 = isset($beban_transmisi[$m]) ? $beban_transmisi[$m] : 0;
                        $v4 = isset($beban_sambungan[$m]) ? $beban_sambungan[$m] : 0;

                        $subBeban = $v1 + $v2 + $v3 + $v4;
                        $totalBebanUsaha[$m] = $subBeban;
                        $grand_total += $subBeban;

                        echo '<td class="num-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">LABA / (RUGI) KOTOR</td>
                    <?php
                    $totalLabaRugi = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($totalPendapatanUsaha[$m]) ? $totalPendapatanUsaha[$m] : 0;
                        $v2 = isset($totalBebanUsaha[$m]) ? $totalBebanUsaha[$m] : 0;

                        $labaRugiKotor = $v1 - $v2;
                        $totalLabaRugi[$m] = $labaRugiKotor;
                        $grand_total += $labaRugiKotor;

                        echo '<td class="num-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>


                <!-- BEBAN UMUM DAN ADMINISTRASI -->
                <tr>
                    <td style="font-weight: bold;">BEBAN UMUM DAN ADMINISTRASI</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">TOTAL BEBAN UMUM DAN ADMINISTRASI</td>
                    <?php
                    $totalBebanUmum = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($beban_umum[$m]) ? $beban_umum[$m] : 0;

                        $subBebanUmum = $v1;
                        $totalBebanUmum[$m] = $subBebanUmum;
                        $grand_total += $subBebanUmum;

                        echo '<td class="num-bold">' . number_format($subBebanUmum, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">LABA / (RUGI) OPERASIONAL</td>
                    <?php
                    $totalLro = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($totalLabaRugi[$m]) ? $totalLabaRugi[$m] : 0;
                        $v2 = isset($totalBebanUmum[$m]) ? $totalBebanUmum[$m] : 0;

                        $labaRugiKotor = $v1 - $v2;
                        $totalLro[$m] = $labaRugiKotor;
                        $grand_total += $labaRugiKotor;

                        echo '<td class="num-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <!-- PENDAPATAN (BEBAN) NON OPERASIONAL -->
                <tr>
                    <td style="font-weight: bold;">PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">JUMLAH PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                    <?php
                    $totalPbno = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($pendapatan_non_operasional[$m]) ? $pendapatan_non_operasional[$m] : 0;
                        $v2 = isset($beban_non_operasional[$m]) ? $beban_non_operasional[$m] : 0;

                        $subPbno = $v1 - $v2;
                        $totalPbno[$m] = $subPbno;
                        $grand_total += $subPbno;

                        echo '<td class="num-bold">' . number_format($subPbno, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">LABA / (RUGI) SEBELUM PAJAK</td>
                    <?php
                    $totalLsp = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($totalLro[$m]) ? $totalLro[$m] : 0;
                        $v2 = isset($totalPbno[$m]) ? $totalPbno[$m] : 0;

                        $subLsp = $v1 + $v2;
                        $totalLsp[$m] = $subLsp;
                        $grand_total += $subLsp;

                        echo '<td class="num-bold">' . number_format($subLsp, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <!-- LUAR BIASA -->
                <tr>
                    <td style="font-weight: bold;">KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">JUMLAH KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                    <?php
                    $totalKlb = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($keuntungan_luar_biasa[$m]) ? $keuntungan_luar_biasa[$m] : 0;
                        $v2 = isset($kerugian_luar_biasa[$m]) ? $kerugian_luar_biasa[$m] : 0;

                        $subKlb = $v1 - $v2;
                        $totalKlb[$m] = $subKlb;
                        $grand_total += $subKlb;

                        echo '<td class="num-bold">' . number_format($subKlb, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">PAJAK PENGHASILAN</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">LABA / (RUGI) SETELAH PAJAK</td>
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
                        $totalLrsp[$m] = $sublrsp;
                        $grand_total += $sublrsp;

                        echo '<td class="num-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
