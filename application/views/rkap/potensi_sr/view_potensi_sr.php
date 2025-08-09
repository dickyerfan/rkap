<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a> -->
                    <!-- <a href="<?= base_url('rkap/Potensi_sr/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->

                    <!-- <div class="nav-item dropdown float-end">
                        <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input Data</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Potensi SR</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload_ket') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Pemetaan Lokasi SR Baru</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload_tbh_airbaku') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Penambahan Air Baku</a></li>
                        </ul>
                    </div> -->

                    <!-- <div class="nav-item dropdown float-end">
                        <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input/Update Data</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if ($statusPotensiSR->status_update == 1) : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/edit') ?>" style="font-size: 0.8rem;"><i class="fas fa-edit fa-fw"></i> Edit Potensi SR</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Input Potensi SR</a></li>
                            <?php endif; ?>

                            <?php if ($statusPemetaanSR->status_update == 1) : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Pemetaan_sr/edit') ?>" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Edit Pemetaan SR</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Pemetaan_sr/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Input Pemetaan SR</a></li>
                            <?php endif; ?>

                            <?php if ($statusPenambahanAirBaku->status_update == 1) : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Penambahan_air_baku/edit') ?>" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Edit Penambahan Air Baku</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Penambahan_air_baku/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Input Penambahan Air Baku</a></li>
                            <?php endif; ?>
                        </ul>
                    </div> -->
                    <!-- <div class="nav-item dropdown float-end">
                        <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input/Update Data</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <?php if ($statusPotensiSR && $statusPotensiSR->status_update == 1) : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/editPotensiSr/') . $this->session->userdata('upk_bagian') ?>" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Update Potensi SR</a></li>
                            <?php else : ?>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Potensi SR</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload_ket') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Pemetaan Lokasi SR Baru</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('rkap/Potensi_sr/upload_tbh_airbaku') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Penambahan Air Baku</a></li>
                        </ul>
                    </div> -->
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <!-- Link Ekspor Data PDF -->
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold neumorphic-button" target="_blank" href="<?= base_url('rkap/potensi_sr/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a></button>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="nav-item dropdown ms-auto">
                            <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input/Update Data</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if ($statusPotensiSR && $statusPotensiSR->status_update == 1) : ?>
                                    <!-- Kode untuk tombol update potensi sr -->
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/editPotensiSr/') . $this->session->userdata('upk_bagian') ?>" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Update Potensi SR</a></li>
                                <?php else : ?>
                                    <!-- Kode untuk tombol input data potensi SR -->
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Potensi SR</a></li>
                                <?php endif; ?>

                                <!-- Kode untuk tombol input data pemetaan lokasi SR baru -->
                                <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/upload_ket') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Pemetaan Lokasi SR Baru</a></li>

                                <!-- <?php if ($statusPemetaanSR && $statusPemetaanSR->status == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Input Pemetaan Lokasi SR Baru</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/upload_ket') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Pemetaan Lokasi SR Baru</a></li>
                                <?php endif; ?> -->

                                <!-- Kode untuk tombol input data penambahan air baku -->
                                <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/upload_tbh_airbaku') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Penambahan Air Baku</a></li>
                                <!-- <?php if ($statusPenambahanAirBaku && $statusPenambahanAirBaku->status == 1) : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/potensi_sr/upload_tbh_airbaku') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload"></i> Input Penambahan Air Baku</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;"><i class="fas fa-edit"></i> Input Penambahan Air Baku</a></li>
                                <?php endif; ?> -->
                            </ul>
                        </div>
                    </nav>

                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <?php
                foreach ($tampil as $row) :
                    $produksi_air = $row->kap_manf * $row->jam_op * 108;
                    $kebocoran_air = $produksi_air * $row->tk_bocor / 100;
                    $air_pelanggan = $produksi_air - $kebocoran_air;
                    $kebutuhan_air = $row->pola_kon * ($row->plg_aktif + $row->tambah_sr);
                    $sisa_air = $air_pelanggan - $kebutuhan_air;
                    $potensi = $sisa_air / $row->pola_kon;

                ?>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 text-center">
                                <h5><?= strtoupper($title) ?></h5>
                                <h5>UPK <?= strtoupper($row->bagian_upk);  ?></h5>
                                <h6 class="text-uppercase">Data Riil <?= $row->tahun_rkap ?></h6>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Kapasitas Produksi</td>
                                            <td>:</td>
                                            <td><?= number_format($row->kap_pro, 2, ',', '.'); ?></td>
                                            <td>liter/detik</td>
                                        </tr>
                                        <tr>
                                            <td>Kapasitas yang Dimanfaatkan</td>
                                            <td>:</td>
                                            <td><?= number_format($row->kap_manf, 2, ',', '.'); ?></td>
                                            <td>liter/detik</td>
                                        </tr>
                                        <tr>
                                            <td>Jam Operasional</td>
                                            <td>:</td>
                                            <td><?= number_format($row->jam_op, 1, ',', '.'); ?></td>
                                            <td>jam/hari</td>
                                        </tr>
                                        <tr>
                                            <td>Tingkat Kebocoran</td>
                                            <td>:</td>
                                            <td><?= number_format($row->tk_bocor, 0, ',', '.'); ?></td>
                                            <td>% (Persentase)</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Pelanggan Aktif (DRD Juli <?= $row->tahun_rkap ?>)</td>
                                            <td>:</td>
                                            <td><?= number_format($row->plg_aktif, 0, ',', '.'); ?></td>
                                            <td>SR (Sambungan Rumah)</td>
                                        </tr>
                                        <tr>
                                            <td>Tambahan SR s/d akhir tahun <?= $row->tahun_rkap ?></td>
                                            <td>:</td>
                                            <td><?= number_format($row->tambah_sr, 0, ',', '.'); ?></td>
                                            <td>asumsi</td>
                                        </tr>
                                        <tr>
                                            <td>Pola Konsumsi rata2 (s/d Juli <?= $row->tahun_rkap ?>)</td>
                                            <td>:</td>
                                            <td><?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                            <td>M3 (Meter Kubik)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h6 class="text-center">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></h6>
                        <div class="row justify-content-center p-3">
                            <div class="col-lg-9">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Produksi air 1 tahun</td>
                                            <td><?= number_format($row->kap_manf, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($produksi_air, 2, ',', '.');  ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Kebocoran air (....%)</td>
                                            <td><?= number_format($row->tk_bocor, 0, ',', '.')  ?> %</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($kebocoran_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Air yang didistribusikan ke pelanggan</td>
                                            <td>-</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($air_pelanggan, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Kebutuhan air</td>
                                            <td><?= number_format($row->plg_aktif + $row->tambah_sr, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 2, ',', '.') ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($kebutuhan_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Sisa Air</td>
                                            <td>-</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($sisa_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Potensi penambahan pelanggan tahun 2024</td>
                                            <td><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($potensi, 0, ',', '.')  ?></td>
                                            <td>SR</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="card-body">
                    <div class="row justify-content-center px-3">
                        <div class="col-lg-9">
                            <h6>Keterangan :</h6>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>1. Kemampuan Penambahan SR baru <?= $totalSr ?> SR</td>
                                    </tr>
                                    <tr>
                                        <td>2. Pemetaan Lokasi : (Dijelaskan apabila dibutuhkan tambahan jaringan)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center px-3">
                        <div class="col-lg-9 ps-5">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($keterangan as $row) : ?>
                                        <tr>
                                            <td><?= $row->nama_wil ?></td>
                                            <td>:</td>
                                            <td><?= $row->jumlah_sr ?></td>
                                            <td>SR</td>
                                            <td>
                                                <a href="<?= base_url('rkap/potensi_sr/edit_ket_potensi/' . $row->id_ket_potensi) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a>
                                                <a href="<?= base_url('rkap/potensi_sr/hapus_ket_potensi/' . $row->id_ket_potensi) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-trash"></i> Hapus</span></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row justify-content-center p-3">
                        <div class="col-lg-9">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>3. Perlu adanya penambahan air baku :</td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if (empty($airBaku)) : ?>
                                <p class="text-danger">Belum ada Penambahan air baku yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($airBaku as $row) : ?>
                                            <tr>
                                                <td width="90%" class="ps-4">
                                                    <li><?= $row->uraian ?></li>
                                                </td>
                                                <td><a href="<?= base_url('rkap/potensi_sr/edit_air_baku/' . $row->id_tambah_air_baku) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>