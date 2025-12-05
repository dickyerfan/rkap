<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('ringkasan') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('ringkasan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('ringkasan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center mb-2">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:0.8rem;">
                                    <tr class="table-primary">
                                        <th colspan="4" class="text-center fw-bold">LAPORAN LABA RUGI</th>
                                    </tr>

                                    <tr>
                                        <td>Pendapatan Usaha</td>
                                        <td class="text-end"> <?= number_format($pendapatan_usaha_total, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Beban Usaha & Pemeliharaan</td>
                                        <td class="text-end"> <?= number_format($beban_usaha_total, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Laba/(Rugi) Usaha</th>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($laba_usaha, 0, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Beban Umum & Administrasi</td>
                                        <td class="text-end"> <?= number_format($beban_umum_total, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Laba/(Rugi) Operasional</th>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($laba_operasional, 0, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pendapatan Non Usaha</td>
                                        <td class="text-end"> <?= number_format($pendapatan_non_usaha, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Beban Non Usaha</td>
                                        <td class="text-end"> <?= number_format($beban_non_usaha, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Selisih Non Usaha</th>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($selisih_non_usaha, 0, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Laba/(Rugi) Sebelum Pajak</th>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($laba_sebelum_pajak, 0, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Keuntungan Luar Biasa</td>
                                        <td class="text-end"> <?= number_format($keuntungan_luar_biasa, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Kerugian Luar Biasa</td>
                                        <td class="text-end"> <?= number_format($kerugian_luar_biasa, 0, ',', '.') ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Selisih Keuntungan/Kerugian</th>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($selisih_luar_biasa, 0, ',', '.') ?></strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Biaya Pajak</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($biaya_pajak, 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr class="table-success">
                                        <th>RENCANA LABA BERSIH SETELAH PAJAK</th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end"><strong> <?= number_format($laba_setelah_pajak, 0, ',', '.') ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:0.8rem;">
                                    <tr class="table-primary">
                                        <th colspan="3" class="text-center fw-bold">LAPORAN ARUS KAS</th>
                                    </tr>
                                    <tr>
                                        <th>PENERIMAAN</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($total['penerimaan_total'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penerimaan Operasional</td>
                                        <td class="text-end"> <?= number_format($total['penerimaan_air'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Penerimaan Lain-lain</td>
                                        <td class="text-end"> <?= number_format($total['penerimaan_lain_lain'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Penerimaan Usaha lainnya</td>
                                        <td class="text-end"> <?= number_format($total['penerimaan_aktiva'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <th>PENGELUARAN</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($total['total_beban'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pengeluaran Operasional</td>
                                        <td class="text-end"> <?= number_format($total['beban'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pengeluaraan Lain-lain</td>
                                        <td class="text-end"> <?= number_format($total['beban_lain_lain'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pengeluaran Investasi</td>
                                        <td class="text-end"> <?= number_format($total['investasi'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Pembayaran Jasa Produksi</td>
                                        <td class="text-end"> <?= number_format($total['jasa_produksi'], 0, ',', '.') ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Surplus(Defisit)</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($total['surplus'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Saldo Awal</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($total['saldo_awal'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr class="table-success">
                                        <th>Saldo Akhir</th>
                                        <td></td>
                                        <td class="text-end fw-bold"> <?= number_format($total['saldo_akhir'], 0, ',', '.') ?></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="table-responsive">
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
                                <table class="table table-bordered table-sm" style="font-size:0.8rem;">
                                    <tr class="table-primary">
                                        <th colspan="3" class="text-center fw-bold">RENCANA INVESTASI</th>
                                    </tr>

                                    <tr>
                                        <td>Tanah</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.01']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Instalasi Sumber</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.02']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Instalasi Pompa</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.03']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Instalasi Pengolahan</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.04']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Instalasi Transmisi & Distribusi</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.05']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan / Gedung</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.06']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Peralatan & Perlengkapan</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.07']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Kendaraan/Alat Angkut</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.08']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Inventaris/Perabot Kantor</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['31.09']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Aktiva Tak Berwujud</td>
                                        <td class="text-end">Rp <?= format_rupiah($rekap_aset['42.01']); ?></td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr class="table-success fw-bold">
                                        <th>TOTAL INVESTASI</th>
                                        <td></td>
                                        <td class="text-end">Rp <?= format_rupiah($grand_total_investasi); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:0.8rem;">
                                    <tr>
                                        <th colspan="2" class="text-center fw-bold">DATA LAINNYA</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH PELANGGAN</th>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH PEGAWAI</th>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Direksi</td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Pegawai Tetap</td>
                                        <td class="text-end"></td>
                                    </tr>
                                    <tr>
                                        <td>Pegawai Kontrak</td>
                                        <td class="text-end"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

    </main>