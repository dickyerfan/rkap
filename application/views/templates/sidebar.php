<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav ustadz">
                    <!-- <a class="nav-link" href="<?= base_url('publik') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div>
                        Beranda
                    </a> -->
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#rkap" aria-expanded="false" aria-controls="rkap">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> R K A P</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="rkap" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('admin/potensi_sr') ?>" style="font-size: 0.8rem;">Potensi SR & Air Baku</a>
                            <a class="nav-link" href="<?= base_url('admin/rekap_sr') ?>" style="font-size: 0.8rem;">Rekap SR</a>
                            <a class="nav-link" href="<?= base_url('admin/evaluasi_upk') ?>" style="font-size: 0.8rem;">Evaluasi UPK</a>
                            <a class="nav-link" href="<?= base_url('admin/evaluasi_amdk') ?>" style="font-size: 0.8rem;">Evaluasi AMDK</a>
                            <a class="nav-link" href="<?= base_url('admin/potensi_amdk') ?>" style="font-size: 0.8rem;">Potensi AMDK</a>
                            <a class="nav-link" href="<?= base_url('admin/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                            <a class="nav-link" href="<?= base_url('admin/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                            <a class="nav-link" href="<?= base_url('admin/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                            <a class="nav-link" href="<?= base_url('admin/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                            <a class="nav-link" href="<?= base_url('admin/usulan_umum') ?>" style="font-size: 0.8rem;">Usulan Umum</a>
                            <a class="nav-link" href="<?= base_url('admin/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#atur" aria-expanded="false" aria-controls="atur">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-laptop"></i></div>
                        <div style="font-size: 0.8rem;"> Pengaturan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="atur" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if ($this->session->userdata('nama_pengguna') === 'administrator') : ?>
                                <a class="nav-link" href="<?= base_url('admin/pengaturan') ?>" style="font-size: 0.8rem;">Aktivasi Upload/Update</a>
                                <a class="nav-link" href="<?= base_url('admin/pengaturan/aktivasiUser') ?>" style="font-size: 0.8rem;">Aktivasi User</a>
                                <a class="nav-link" href="<?= base_url('admin/pengaturan/aktivasiAdmin') ?>" style="font-size: 0.8rem;">Aktivasi Admin</a>
                                <a class="nav-link" href="<?= base_url('rkap_admin') ?>" style="font-size: 0.8rem;"> Periode RKAP</a>

                            <?php endif; ?>
                            <a class="nav-link" href="<?= base_url('admin/pengaturan/kumpul_data') ?>" style="font-size: 0.8rem;">Cek Pengumpulan Data</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#lk" aria-expanded="false" aria-controls="lk">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Lembar Kerja</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="lk" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#laba_rugi" aria-expanded="false" aria-controls="laba_rugi">
                            <div class="sb-nav-link-icon ps-2"><i class="fa-fw fa fa-circle fa-xs"></i></div>
                            <div style="font-size: 0.8rem;"> Laba Rugi</div>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="laba_rugi" aria-labelledby="headingOne" data-bs-parent="#laba_rugi">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url('ringkasan') ?>" style="font-size: 0.8rem;">Ringkasan</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/laba_rugi') ?>" style="font-size: 0.8rem;">Proyeksi Laba Rugi</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/pelanggan') ?>" style="font-size: 0.8rem;">Perkembangan Pelanggan</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/produksi_air') ?>" style="font-size: 0.8rem;">Produksi Air</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>" style="font-size: 0.8rem;">Pendapatan Air</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/pendapatan_non_air') ?>" style="font-size: 0.8rem;">Pendapatan Non Air</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain') ?>" style="font-size: 0.8rem;">Pendapatan Usaha Lain</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha') ?>" style="font-size: 0.8rem;">Pendapatan Diluar Usaha</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/beban_sumber') ?>" style="font-size: 0.8rem;">Beban Sumber</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/beban_pengolahan') ?>" style="font-size: 0.8rem;">Beban Pengolahan</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/beban_trandis') ?>" style="font-size: 0.8rem;">Beban Trandis</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/beban_umum') ?>" style="font-size: 0.8rem;">Beban Umum</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/lr/beban_luar_usaha') ?>" style="font-size: 0.8rem;">Beban Diluar Usaha</a>
                                <!-- <a class="nav-link" href="" style="font-size: 0.8rem;">Beban Sumber Bagian</a>
                                <a class="nav-link" href="" style="font-size: 0.8rem;">Beban Pengolahan Bagian</a>
                                <a class="nav-link" href="" style="font-size: 0.8rem;">Beban Trandis Bagian</a>
                                <a class="nav-link" href="" style="font-size: 0.8rem;">Beban Umum Bagian</a> -->
                                <!-- <a class="nav-link" href="" style="font-size: 0.8rem;">RKAP AMDK</a> -->
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#rkap_amdk" aria-expanded="false" aria-controls="rkap_amdk">
                                    <div class="sb-nav-link-icon"></div>
                                    <div style="font-size: 0.8rem;"> RKAP AMDK</div>
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="rkap_amdk" aria-labelledby="headingOne" data-bs-parent="#rkap_amdk">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/laba_rugi_amdk') ?>" style="font-size: 0.8rem;">Laba Rugi </a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk') ?>" style="font-size: 0.8rem;">Arus Kas </a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/produksi') ?>" style="font-size: 0.8rem;">Produksi </a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops') ?>" style="font-size: 0.8rem;">Pendapatan Ops</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_na') ?>" style="font-size: 0.8rem;">Pendapatan Non Air</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk') ?>" style="font-size: 0.8rem;">Penerimaan</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku') ?>" style="font-size: 0.8rem;">By. Bahan baku</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan') ?>" style="font-size: 0.8rem;">By. Pemeliharaan</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/biaya') ?>" style="font-size: 0.8rem;">Biaya</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/gaji_amdk') ?>" style="font-size: 0.8rem;">Rencana Gaji</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk') ?>" style="font-size: 0.8rem;"> Investasi</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#arus_kas" aria-expanded="false" aria-controls="arus_kas">
                            <div class="sb-nav-link-icon ps-2"><i class="fa-fw fa fa-circle fa-xs"></i></div>
                            <div style="font-size: 0.8rem;"> Arus Kas</div>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="arus_kas" aria-labelledby="headingOne" data-bs-parent="#arus_kas">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/arus_kas') ?>" style="font-size: 0.8rem;">Proyeksi Arus Kas</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air') ?>" style="font-size: 0.8rem;">Penerimaan Air</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_non_air') ?>" style="font-size: 0.8rem;">Penerimaan Non Air</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_usaha_lain') ?>" style="font-size: 0.8rem;">Penerimaan Usaha Lainnya</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_luar_usaha') ?>" style="font-size: 0.8rem;">Penerimaan Diluar Usaha</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" style="font-size: 0.8rem;">Pengeluaran Tenaga Kerja</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops') ?>" style="font-size: 0.8rem;">Pengeluaran Operasional</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/pengeluaran_non_ops') ?>" style="font-size: 0.8rem;">Pengeluaran Non Ops</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan') ?>" style="font-size: 0.8rem;">Pembelian Bahan</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/investasi') ?>" style="font-size: 0.8rem;">Investasi</a>
                                <!-- <a class="nav-link" href="" style="font-size: 0.8rem;">Inventaris Bagian</a> -->
                            </nav>
                        </div>
                        <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#dataPendukung" aria-expanded="false" aria-controls="dataPendukung">
                            <div class="sb-nav-link-icon ps-2"><i class="fa-fw fa fa-circle fa-xs"></i></div>
                            <div style="font-size: 0.8rem;"> Data Isian</div>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="dataPendukung" aria-labelledby="headingOne" data-bs-parent="#dataPendukung">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?= base_url('lembar_kerja/data_pendukung') ?>" style="font-size: 0.8rem;">Jasa Tambahan</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/data_pendukung/pola_konsumsi_tarif') ?>" style="font-size: 0.8rem;">Pola Konsumsi & Tarif</a>
                            </nav>
                        </div> -->
                    </div>
                    <?php if ($this->session->userdata('nama_pengguna') === 'administrator') : ?>
                        <a class="nav-link" href="<?= base_url('user/admin') ?>">
                            <div class="sb-nav-link-icon"><i class="fa-fw fas fa-user"></i></div>
                            <div style="font-size: 0.8rem;"> Data User</div>
                        </a>

                    <?php endif; ?>
                    <a class="nav-link" href="<?= base_url('backup') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-database"></i></div>
                        <div style="font-size: 0.8rem;"> Back up</div>
                    </a>
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-sign-out-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Logout</div>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small" style="font-size: 0.7rem;">Anda Login sebagai :</div>
                <div class="small" style="font-size: 0.7rem;"><?= $this->session->userdata('level'); ?></div>
                <div class="small" style="font-size: 0.7rem;"><?= $this->session->userdata('nama_pengguna'); ?></div>
            </div>
        </nav>
    </div>