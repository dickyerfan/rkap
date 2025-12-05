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
                        <p class="fw-bold"><?= $title . ' ' .  $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <table class="table table-sm table-bordered tableUtama">
                            <tr class="table-primary">
                                <th colspan="4" class="text-center fw-bold">LAPORAN LABA RUGI</th>
                            </tr>
                            <tr>
                                <td>Pendapatan Usaha</td>
                                <td class="text-end pe-2"> <?= number_format($pendapatan_usaha_total, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Beban Usaha & Pemeliharaan</td>
                                <td class="text-end pe-2"> <?= number_format($beban_usaha_total, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Laba/(Rugi) Usaha</th>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($laba_usaha, 0, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Beban Umum & Administrasi</td>
                                <td class="text-end pe-2"> <?= number_format($beban_umum_total, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Laba/(Rugi) Operasional</th>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($laba_operasional, 0, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pendapatan Non Usaha</td>
                                <td class="text-end pe-2"> <?= number_format($pendapatan_non_usaha, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Beban Non Usaha</td>
                                <td class="text-end pe-2"> <?= number_format($beban_non_usaha, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Selisih Non Usaha</th>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($selisih_non_usaha, 0, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Laba/(Rugi) Sebelum Pajak</th>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($laba_sebelum_pajak, 0, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Keuntungan Luar Biasa</td>
                                <td class="text-end pe-2"> <?= number_format($keuntungan_luar_biasa, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Kerugian Luar Biasa</td>
                                <td class="text-end pe-2"> <?= number_format($kerugian_luar_biasa, 0, ',', '.') ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Selisih Keuntungan/Kerugian</th>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($selisih_luar_biasa, 0, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Biaya Pajak</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($biaya_pajak, 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr class="table-success">
                                <th>RENCANA LABA BERSIH SETELAH PAJAK</th>
                                <td></td>
                                <td></td>
                                <td class="text-end pe-2"><strong> <?= number_format($laba_setelah_pajak, 0, ',', '.') ?></strong></td>
                            </tr>
                        </table>
                        <table class="table table-sm table-bordered tableUtama">
                            <tr class="table-primary">
                                <th colspan="3" class="text-center fw-bold">LAPORAN ARUS KAS</th>
                            </tr>
                            <tr>
                                <th>PENERIMAAN</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($total['penerimaan_total'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Penerimaan Operasional</td>
                                <td class="text-end pe-2"> <?= number_format($total['penerimaan_air'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Penerimaan Lain-lain</td>
                                <td class="text-end pe-2"> <?= number_format($total['penerimaan_lain_lain'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Penerimaan Usaha lainnya</td>
                                <td class="text-end pe-2"> <?= number_format($total['penerimaan_aktiva'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>

                            <tr>
                                <th>PENGELUARAN</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($total['total_beban'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Pengeluaran Operasional</td>
                                <td class="text-end pe-2"> <?= number_format($total['beban'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pengeluaraan Lain-lain</td>
                                <td class="text-end pe-2"> <?= number_format($total['beban_lain_lain'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pengeluaran Investasi</td>
                                <td class="text-end pe-2"> <?= number_format($total['investasi'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Pembayaran Jasa Produksi</td>
                                <td class="text-end pe-2"> <?= number_format($total['jasa_produksi'], 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Surplus(Defisit)</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($total['surplus'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <th>Saldo Awal</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($total['saldo_awal'], 0, ',', '.') ?></td>
                            </tr>
                            <tr class="table-success">
                                <th>Saldo Akhir</th>
                                <td></td>
                                <td class="text-end pe-2 fw-bold"> <?= number_format($total['saldo_akhir'], 0, ',', '.') ?></td>
                            </tr>
                        </table>
                        <br>
                        <br>
                        <br>
                        <table class="table table-sm table-bordered tableUtama">
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
                            <tr class="table-primary">
                                <th colspan="3" class="text-center fw-bold">RENCANA INVESTASI</th>
                            </tr>

                            <tr>
                                <td>Tanah</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.01']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Instalasi Sumber</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.02']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Instalasi Pompa</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.03']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Instalasi Pengolahan</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.04']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Instalasi Transmisi & Distribusi</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.05']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Bangunan / Gedung</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.06']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Peralatan & Perlengkapan</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.07']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Kendaraan/Alat Angkut</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.08']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Inventaris/Perabot Kantor</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['31.09']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr>
                                <td>Aktiva Tak Berwujud</td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($rekap_aset['42.01']); ?></td>
                                <td class="text-end pe-2"></td>
                            </tr>
                            <tr class="table-success fw-bold">
                                <th>TOTAL INVESTASI</th>
                                <td></td>
                                <td class="text-end pe-2">Rp <?= format_rupiah($grand_total_investasi); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>