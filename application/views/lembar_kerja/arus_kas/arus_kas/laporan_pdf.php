<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 20pt 20pt 30pt 80pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 10pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 9pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 6.5pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.num { text-align: right; }
        table.data-table td.num-bold { text-align: right; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table tfoot td { font-weight: bold; background-color: #e9ecef; border-top: 2px solid #6c757d; }
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
        <p class="title"><?= $title . ' ' .  $tahun ?></p>
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
                <!-- PENERIMAAN -->
                <tr>
                    <td style="font-weight:bold;">PENERIMAAN</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                <tr>
                    <td>- Penerimaan Non Air</td>
                    <?php
                    $total = 0;
                    $arr = isset($penerimaan_non_air) ? $penerimaan_non_air : array_fill(1, 12, 0);
                    for ($m = 1; $m <= 12; $m++) :
                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                        $total += $v;
                    ?>
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">JUMLAH PENERIMAAN</td>
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

                        echo '<td class="num-bold">' . number_format($subPenerimaan, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <!-- PENGELUARAN -->
                <tr>
                    <td style="font-weight:bold;">PENGELUARAN</td>
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
                    <td>- Beban Lain -lain</td>
                    <?php
                    $total = 0;
                    $arr = isset($beban_lain_lain) ? $beban_lain_lain : array_fill(1, 12, 0);
                    for ($m = 1; $m <= 12; $m++) :
                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                        $total += $v;
                    ?>
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">JUMLAH PENGELUARAN</td>
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

                        echo '<td class="num-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold;">ARUS KAS DARI AKTIVITAS INVESTASI</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">ARUS KAS DARI AKTIVITAS PENDANAAN</td>
                    <td colspan="13"></td>
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
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>- Bagian Laba Pemda yang belum dibayar</td>
                    <?php
                    $total = 0;
                    $arr = isset($bagian_laba_pemda) ? $bagian_laba_pemda : array_fill(1, 12, 0);
                    for ($m = 1; $m <= 12; $m++) :
                        $v = isset($arr[$m]) ? $arr[$m] : 0;
                        $total += $v;
                    ?>
                        <td class="num"><?= number_format($v, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num-bold"><?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">ARUS KAS BERSIH UNTUK AKTIVITAS PENDANAAN</td>
                    <?php
                    $totalInvestasi = array_fill(1, 12, 0);
                    $grand_total = 0;

                    for ($m = 1; $m <= 12; $m++) {
                        $v1 = isset($penambahan_aset_tetap[$m]) ? $penambahan_aset_tetap[$m] : 0;
                        $v2 = isset($investasi[$m]) ? $investasi[$m] : 0;
                        $v3 = isset($jasa_produksi[$m]) ? $jasa_produksi[$m] : 0;
                        $v4 = isset($bagian_laba_pemda[$m]) ? $bagian_laba_pemda[$m] : 0;

                        $sublrsp = $v1 + $v2 + $v3 + $v4;
                        $totalInvestasi[$m] = $sublrsp; // simpan ke array
                        $grand_total += $sublrsp;

                        echo '<td class="num-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;">KENAIKAN /BERKURANG BERSIH KAS & SETARA KAS</td>
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

                        echo '<td class="num-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                    }
                    ?>
                    <td class="num-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
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
                    <td style="font-weight:bold;">SALDO KAS SETARA KAS AWAL TAHUN</td>
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        echo '<td class="num-bold">' . number_format($saldo_awal[$m], 0, ',', '.') . '</td>';
                    }
                    // Jumlah di sebelah kanan menampilkan saldo awal tahun (saldo_awal[1])
                    echo '<td class="num-bold">' . number_format($saldo_awal[1], 0, ',', '.') . '</td>';
                    ?>
                </tr>

                <!-- Tampilkan: SALDO KAS SETARA KAS AKHIR TAHUN -->
                <tr>
                    <td style="font-weight:bold;">SALDO KAS SETARA KAS AKHIR TAHUN</td>
                    <?php
                    for ($m = 1; $m <= 12; $m++) {
                        echo '<td class="num-bold">' . number_format($saldo_akhir[$m], 0, ',', '.') . '</td>';
                    }
                    // Jumlah di kanan: saldo akhir Desember
                    echo '<td class="num-bold">' . number_format($saldo_akhir[12], 0, ',', '.') . '</td>';
                    ?>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>