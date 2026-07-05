<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav ustadz">
                    <!-- <a class="nav-link" href="<?= base_url('publik') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div>
                        Beranda
                    </a> -->
                    <a class="nav-link" href="<?= base_url('admin/dashboard_upk') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>
                    <a class="nav-link" href="<?= base_url('struktur') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-users"></i></div>
                        <div style="font-size: 0.8rem;"> Struktur</div>
                    </a>

                    <!-- <a class="nav-link" href="<?= base_url('pengaduan') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-comments"></i></div>
                        <div style="font-size: 0.8rem;"> Pengaduan</div>
                    </a> -->
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#rkap" aria-expanded="false" aria-controls="rkap">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> R K A P</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <?php
                    $upk_bagian = $this->session->userdata('upk_bagian');
                    $isAmdk = ($upk_bagian === 'amdk');
                    $perencanaan = ($upk_bagian === 'perencanaan');
                    $pemeliharaan = ($upk_bagian === 'pemeliharaan');
                    $umum = ($upk_bagian === 'umum' || $upk_bagian === 'hendi' || $upk_bagian === 'yuliatin');
                    $uangLangSpi = ($upk_bagian === 'langganan' || $upk_bagian === 'keuangan' || $upk_bagian === 'spi');
                    // $rencana = ($upk_bagian === 'rencana');
                    // $barang = ($upk_bagian === 'barang');
                    // $pelihara = ($upk_bagian === 'pelihara');
                    // $pemRenUm = ($upk_bagian === 'pemeliharaan' || $upk_bagian === 'perencanaan' || $upk_bagian === 'umum');
                    ?>

                    <div class="collapse" id="rkap" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if ($perencanaan) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                                <a class="nav-link" href="<?= base_url('rkap/isian_inves') ?>" style="font-size: 0.8rem;">Isian Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/isian_pemeliharaan') ?>" style="font-size: 0.8rem;">Isian Pemeliharaan</a>
                            <?php elseif ($umum) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan ATK & alat cetak</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_umum') ?>" style="font-size: 0.8rem;">Usulan Umum</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                                <a class="nav-link" href="<?= base_url('admin/usulan_barang/master_barang') ?>" style="font-size: 0.8rem;">Harga Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/isian_barang') ?>" style="font-size: 0.8rem;">Isian Barang</a>
                                <a class="nav-link" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" style="font-size: 0.8rem;">Biaya Tenaga Kerja</a>
                            <?php elseif ($isAmdk) : ?>
                                <!-- <a class="nav-link" href="<?= base_url('rkap/potensi_amdk') ?>" style="font-size: 0.8rem;">Potensi AMDK</a> -->
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_amdk') ?>" style="font-size: 0.8rem;">Evaluasi AMDK</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang_amdk') ?>" style="font-size: 0.8rem;">Usulan ATK & alat cetak</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#lk" aria-expanded="false" aria-controls="lk">
                                    <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                                    <div style="font-size: 0.8rem;"> Lembar Kerja</div>
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="lk" aria-labelledby="headingOne" data-bs-parent="#lk">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="<?= base_url('rkap/usulan_produksi_amdk') ?>" style="font-size: 0.8rem;">Usulan Produksi</a>
                                        <a class="nav-link" href="<?= base_url('rkap/pendapatan_ops_amdk') ?>" style="font-size: 0.8rem;">Pendapatan Ops</a>
                                        <a class="nav-link" href="<?= base_url('rkap/pendapatan_na_amdk') ?>" style="font-size: 0.8rem;">Pendapatan Non Air</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk') ?>" style="font-size: 0.8rem;">Penerimaan</a>
                                        <a class="nav-link" href="<?= base_url('rkap/bahan_baku') ?>" style="font-size: 0.8rem;">By. Bahan baku</a>
                                        <a class="nav-link" href="<?= base_url('rkap/pemeliharaan') ?>" style="font-size: 0.8rem;">By. Pemeliharaan</a>
                                        <a class="nav-link" href="<?= base_url('rkap/biaya') ?>" style="font-size: 0.8rem;">Biaya</a>
                                        <a class="nav-link" href="<?= base_url('rkap/investasi_amdk') ?>" style="font-size: 0.8rem;"> Investasi</a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk') ?>" style="font-size: 0.8rem;">Arus Kas </a>
                                        <a class="nav-link" href="<?= base_url('lembar_kerja/rkap_amdk/laba_rugi_amdk') ?>" style="font-size: 0.8rem;">Laba Rugi </a>
                                    </nav>
                                </div>
                            <?php elseif ($pemeliharaan) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                            <?php elseif ($uangLangSpi) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan ATK & alat cetak</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Usulan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                            <?php else : ?>
                                <a class="nav-link" href="<?= base_url('rkap/potensi_sr') ?>" style="font-size: 0.8rem;">Potensi SR & Air Baku</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_upk') ?>" style="font-size: 0.8rem;">Evaluasi UPK</a>
                                <a class="nav-link" href="<?= base_url('rkap/proyeksi_upk') ?>" style="font-size: 0.8rem;">Proyeksi UPK</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan ATK & alat cetak</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                            <?php endif; ?>
                        </nav>
                    </div>

                    <!-- <a class="nav-link" href="<?= base_url('user/admin') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-user"></i></div>
                        Data User
                    </a> -->
                    <!-- <a class="nav-link" href="<?= base_url('backup') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-database"></i></div>
                        Back up
                    </a> -->
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-sign-out-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Logout</div>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small" style="font-size: 0.7rem;">Anda Login sebagai :</div>
                <div class="small" style="font-size: 0.7rem;"><?= $this->session->userdata('level'); ?></div>
                <div class="small" style="font-size: 1rem;"><?= $this->session->userdata('nama_pengguna'); ?></div>
            </div>
        </nav>
    </div>