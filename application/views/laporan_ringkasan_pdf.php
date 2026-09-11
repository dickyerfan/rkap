<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 40pt 20pt 40pt 50pt; }
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
            <tr style="background-color:#cce5ff;">
                <th colspan="4">LAPORAN LABA RUGI</th>
            </tr>
            <tr>
                <td>Pendapatan Usaha</td>
                <td class="num"> <?= number_format($pendapatan_usaha_total, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Beban Usaha & Pemeliharaan</td>
                <td class="num"> <?= number_format($beban_usaha_total, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Laba/(Rugi) Usaha</th>
                <td></td>
                <td class="num"><strong> <?= number_format($laba_usaha, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Beban Umum & Administrasi</td>
                <td class="num"> <?= number_format($beban_umum_total, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Laba/(Rugi) Operasional</th>
                <td></td>
                <td class="num"><strong> <?= number_format($laba_operasional, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Pendapatan Non Usaha</td>
                <td class="num"> <?= number_format($pendapatan_non_usaha, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Beban Non Usaha</td>
                <td class="num"> <?= number_format($beban_non_usaha, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Selisih Non Usaha</th>
                <td></td>
                <td class="num"><strong> <?= number_format($selisih_non_usaha, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
            <tr>
                <th>Laba/(Rugi) Sebelum Pajak</th>
                <td></td>
                <td class="num"><strong> <?= number_format($laba_sebelum_pajak, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
            <tr>
                <td>Keuntungan Luar Biasa</td>
                <td class="num"> <?= number_format($keuntungan_luar_biasa, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Kerugian Luar Biasa</td>
                <td class="num"> <?= number_format($kerugian_luar_biasa, 0, ',', '.') ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Selisih Keuntungan/Kerugian</th>
                <td></td>
                <td class="num"><strong> <?= number_format($selisih_luar_biasa, 0, ',', '.') ?></strong></td>
                <td></td>
            </tr>
            <tr>
                <th>Biaya Pajak</th>
                <td></td>
                <td class="num-bold"> <?= number_format($biaya_pajak, 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr style="background-color:#d1e7dd;">
                <th>RENCANA LABA BERSIH SETELAH PAJAK</th>
                <td></td>
                <td></td>
                <td class="num"><strong> <?= number_format($laba_setelah_pajak, 0, ',', '.') ?></strong></td>
            </tr>
        </table>
        <table class="data-table">
            <tr style="background-color:#cce5ff;">
                <th colspan="3">LAPORAN ARUS KAS</th>
            </tr>
            <tr>
                <th>PENERIMAAN</th>
                <td></td>
                <td class="num-bold"> <?= number_format($total['penerimaan_total'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Penerimaan Operasional</td>
                <td class="num"> <?= number_format($total['penerimaan_air'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Penerimaan Lain-lain</td>
                <td class="num"> <?= number_format($total['penerimaan_lain_lain'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Penerimaan Usaha lainnya</td>
                <td class="num"> <?= number_format($total['penerimaan_aktiva'], 0, ',', '.') ?></td>
                <td></td>
            </tr>

            <tr>
                <th>PENGELUARAN</th>
                <td></td>
                <td class="num-bold"> <?= number_format($total['total_beban'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td>Pengeluaran Operasional</td>
                <td class="num"> <?= number_format($total['beban'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Pengeluaraan Lain-lain</td>
                <td class="num"> <?= number_format($total['beban_lain_lain'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Pengeluaran Investasi</td>
                <td class="num"> <?= number_format($total['investasi'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <td>Pembayaran Jasa Produksi</td>
                <td class="num"> <?= number_format($total['jasa_produksi'], 0, ',', '.') ?></td>
                <td></td>
            </tr>
            <tr>
                <th>Surplus(Defisit)</th>
                <td></td>
                <td class="num-bold"> <?= number_format($total['surplus'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <th>Saldo Awal</th>
                <td></td>
                <td class="num-bold"> <?= number_format($total['saldo_awal'], 0, ',', '.') ?></td>
            </tr>
            <tr style="background-color:#d1e7dd;">
                <th>Saldo Akhir</th>
                <td></td>
                <td class="num-bold"> <?= number_format($total['saldo_akhir'], 0, ',', '.') ?></td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table class="data-table">
            <?php
            // 1. Inisialisasi variabel total per kategori aset
            $rekap_aset = [
                '31.01' => 0,  // Tanah
                '31.02' => 0, // Instalasi Sumber
                '31.03' => 0, // Instalasi Pompa
                '31.04' => 0, // Instalasi Pengolahan
                '31.05' => 0, // Instalasi Transmisi & Distribusi
                '31.06' => 0,  // Bangunan / Gedung
                '31.07' => 0,  // Peralatan & Perlengkapan
                '31.08' => 0,  // Kendaraan/Alat Angkut
                '31.09' => 0,  // Inventaris/Perabot Kantor
                '42.01' => 0,  // Aktiva Tak Berwujud
            ];
            $grand_total_investasi = 0;

            // 2. Loop data hasil query Model dan lakukan agregasi
            foreach ($investasi as $row) {
                $kode_akun = $row['kode']; // Misal: 31.03.01.01

                $pagu = $row['total_biaya'];

                // Cek ke kategori mana akun ini masuk
                foreach ($rekap_aset as $prefix => $total) {
                    if (strpos($kode_akun, $prefix) === 0) {
                        $rekap_aset[$prefix] += $pagu;
                    }
                }

                // Hitung total keseluruhan
                $grand_total_investasi += $pagu;
            }

            // Fungsi helper untuk format Rupiah
            function format_rupiah($angka)
            {
                return number_format($angka, 0, ',', '.');
            }
            ?>
            <tr style="background-color:#cce5ff;">
                <th colspan="3">RENCANA INVESTASI</th>
            </tr>

            <tr>
                <td>Tanah</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.01']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Instalasi Sumber</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.02']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Instalasi Pompa</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.03']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Instalasi Pengolahan</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.04']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Instalasi Transmisi & Distribusi</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.05']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Bangunan / Gedung</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.06']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Peralatan & Perlengkapan</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.07']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Kendaraan/Alat Angkut</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.08']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Inventaris/Perabot Kantor</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['31.09']); ?></td>
                <td class="num"></td>
            </tr>
            <tr>
                <td>Aktiva Tak Berwujud</td>
                <td class="num">Rp <?= format_rupiah($rekap_aset['42.01']); ?></td>
                <td class="num"></td>
            </tr>
            <tr style="background-color:#d1e7dd;font-weight:bold;">
                <th>TOTAL INVESTASI</th>
                <td></td>
                <td class="num">Rp <?= format_rupiah($grand_total_investasi); ?></td>
            </tr>
        </table>
    </main>
</body>

</html>
