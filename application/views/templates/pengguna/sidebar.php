<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav ustadz">
                    <!-- <a class="nav-link" href="<?= base_url('publik') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div>
                        Beranda
                    </a> -->
                    <a class="nav-link" href="<?= base_url('pengguna') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
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
                    $rencana = ($upk_bagian === 'rencana');
                    $barang = ($upk_bagian === 'barang');
                    $pelihara = ($upk_bagian === 'pelihara');
                    $uangLangSpi = ($upk_bagian === 'langganan' || $upk_bagian === 'keuangan' || $upk_bagian === 'spi');
                    $pemRenUm = ($upk_bagian === 'pemeliharaan' || $upk_bagian === 'perencanaan' || $upk_bagian === 'umum');
                    ?>
                    <!-- <div class="collapse" id="rkap" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= $isAmdk ? 'javascript:void(0)' : base_url('rkap/potensi_sr') ?>" style="font-size: 0.8rem;">Potensi SR & Air Baku</a>
                            <a class="nav-link" href="<?= $isAmdk ? 'javascript:void(0)' : base_url('rkap/evaluasi_upk') ?>" style="font-size: 0.8rem;">Evaluasi UPK</a>
                            <a class="nav-link" href="<?= $isAmdk ? base_url('rkap/evaluasi_amdk') : 'javascript:void(0)' ?>" style="font-size: 0.8rem;">Evaluasi AMDK</a>
                            <a class="nav-link" href="<?= $rencana ? base_url('rkap/isian_inves') : base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                            <a class="nav-link" href="<?= $barang ? base_url('rkap/isian_barang') : base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                            <a class="nav-link" href="<?= $pelihara ? base_url('rkap/isian_pemeliharaan') : base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                        </nav>
                    </div> -->

                    <div class="collapse" id="rkap" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <?php if ($barang) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/isian_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                            <?php elseif ($rencana) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/isian_inves') ?>" style="font-size: 0.8rem;">Usulan Rencana</a>
                            <?php elseif ($pelihara) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/isian_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                            <?php elseif ($isAmdk) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_amdk') ?>" style="font-size: 0.8rem;">Evaluasi AMDK</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                            <?php elseif ($pemRenUm) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_pemeliharaan') ?>" style="font-size: 0.8rem;">Usulan Pemeliharaan</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                            <?php elseif ($uangLangSpi) : ?>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_program') ?>" style="font-size: 0.8rem;">Evaluasi & Program</a>
                                <a class="nav-link" href="<?= base_url('rkap/permasalahan') ?>" style="font-size: 0.8rem;">Permasalahan</a>
                            <?php else : ?>
                                <a class="nav-link" href="<?= base_url('rkap/potensi_sr') ?>" style="font-size: 0.8rem;">Potensi SR & Air Baku</a>
                                <a class="nav-link" href="<?= base_url('rkap/evaluasi_upk') ?>" style="font-size: 0.8rem;">Evaluasi UPK</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_inves') ?>" style="font-size: 0.8rem;">Usulan Investasi</a>
                                <a class="nav-link" href="<?= base_url('rkap/usulan_barang') ?>" style="font-size: 0.8rem;">Usulan Barang</a>
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
            </div>
        </nav>
    </div>