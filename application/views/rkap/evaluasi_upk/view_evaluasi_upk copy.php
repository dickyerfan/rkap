<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) . ' ' .  date('Y') ?></a> -->
                    <!-- <a href="<?= base_url('rkap/Potensi_sr/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <!-- Link Ekspor Data PDF -->
                        <div class="navbar-nav">
                            <a class="nav-link neumorphic-button fw-bold" target="_blank" href="<?= base_url('rkap/evaluasi_upk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="nav-item dropdow ms-auto">
                            <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input Data</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if ($updatePlgBaru && $updatePlgBaru->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Penambahan Pelanggan Baru</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_plgBaru') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Penambahan Pelanggan Baru</a></li>
                                <?php endif; ?>
                                <?php if ($updatePlgAktif && $updatePlgAktif->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Jumlah Pelanggan Aktif</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_plgAktif') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Jumlah Pelanggan Aktif</a></li>
                                <?php endif; ?>
                                <?php if ($updateJumRek && $updateJumRek->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Jumlah Yang Direkeningkan</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_jmlRek') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Jumlah Yang Direkeningkan</a></li>
                                <?php endif; ?>
                                <?php if ($updateAirTerjual && $updateAirTerjual->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Air Terjual</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_airTerjual') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Air Terjual</a></li>
                                <?php endif; ?>
                                <?php if ($updatePendapatanAir && $updatePendapatanAir->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Pendapatan Air</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_pendapatanAir') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Pendapatan Air</a></li>
                                <?php endif; ?>

                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_target') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Penjelasan Target <?= date('Y') ?></a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_usulanTeknik') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Usulan Bidang Teknik</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_upk/upload_usulanAdmin') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Usulan Bidang Administrasi</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  date('Y') ?></h5>
                            <h5>UPK <?= strtoupper($this->session->userdata('upk_bagian'));  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <!-- <th>No</th> -->
                                        <th rowspan="2" class="align-middle">Uraian</th>
                                        <th rowspan="2" class="align-middle">Satuan</th>
                                        <th colspan="2">S/D Juli <?= date('Y') ?></th>
                                        <th colspan="2">Naik/Turun</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr class="text-center">
                                        <!-- <th>No</th> -->
                                        <th>RKAP</th>
                                        <th>Realisasi</th>
                                        <th>Satuan</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($plgBaru as $row) :
                                        $realisasi = $row->realisasi;
                                        $rkap = $row->rkap;
                                        $id = $row->id_evaluasi_upk;
                                        $naikTurun = $realisasi - $rkap;
                                        $persen = ($naikTurun / $rkap) * 100;
                                        // $persentase = abs($persen);

                                    ?>
                                        <tr>
                                            <!-- <td><?= $no++ ?></td> -->
                                            <td class="ps-4"><?= $row->uraian_evaluasi ?></td>
                                            <td class="text-center"><?= $row->satuan ?></td>
                                            <td class="text-end pe-4"><?= number_format($row->rkap, 0, ',', '.')  ?></td>
                                            <td class="text-end pe-4"><?= number_format($row->realisasi, 0, ',', '.')  ?></td>
                                            <td class="text-end pe-4"><?= $naikTurun ?></td>
                                            <td class="text-center"><?= number_format($persen, 2, ',', '.') ?></td>
                                            <td class="text-center"><a href="<?= base_url('rkap/evaluasi_upk/edit_evaluasi_upk/') ?><?= $id ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php
                                    $airTerjualRkap = 0;  // Nilai default
                                    $airTerjualRealisasi = 0;  // Nilai default
                                    if (isset($airTerjual)) {
                                        foreach ($airTerjual as $row) {
                                            $airTerjualRkap = $row->rkap;
                                            $airTerjualRealisasi = $row->realisasi;
                                        }
                                    }
                                    $pendapatanAirRkap = 0; // Nilai default
                                    $pendapatanAirRealisasi = 0; // Nilai default
                                    if (isset($pendapatanAir)) {
                                        foreach ($pendapatanAir as $row) {
                                            $pendapatanAirRkap = $row->rkap;
                                            $pendapatanAirRealisasi = $row->realisasi;
                                        }
                                    }

                                    $lembarAirRkap = 0;  // Nilai default
                                    $lembarAirRealisasi = 0;  // Nilai default
                                    if (isset($lembarAir)) {
                                        foreach ($lembarAir as $row) {
                                            $lembarAirRkap = $row->rkap;
                                            $lembarAirRealisasi = $row->realisasi;
                                        }
                                    }

                                    $polaKonsumsiRkap = ($lembarAirRkap != 0) ? $airTerjualRkap / $lembarAirRkap : 0;
                                    $tarifRataRkap = ($airTerjualRkap != 0) ? $pendapatanAirRkap / $airTerjualRkap : 0;

                                    $polaKonsumsiReal = ($lembarAirRealisasi != 0) ? $airTerjualRealisasi / $lembarAirRealisasi : 0;
                                    $tarifRataReal = ($airTerjualRealisasi != 0) ? $pendapatanAirRealisasi / $airTerjualRealisasi : 0;

                                    $naikTurunPola = $polaKonsumsiReal - $polaKonsumsiRkap;
                                    $persenPola = ($polaKonsumsiRkap != 0) ? ($naikTurunPola / $polaKonsumsiRkap) * 100 : 0;


                                    $naikTurunRata = $tarifRataReal - $tarifRataRkap;
                                    $persenRata = ($tarifRataRkap != 0) ? ($naikTurunRata / $tarifRataRkap) * 100 : 0;
                                    ?>
                                    <tr>
                                        <!-- <td>6</td> -->
                                        <td class="ps-4">Pola Konsumsi</td>
                                        <td class="text-center">M3</td>
                                        <td class="text-end pe-4"><?= number_format($polaKonsumsiRkap, 1, ',', '.');  ?></td>
                                        <td class="text-end pe-4"><?= number_format($polaKonsumsiReal, 1, ',', '.');  ?></td>
                                        <td class="text-end pe-4"><?= number_format($naikTurunPola, 1, ',', '.');  ?></td>
                                        <td class="text-center"><?= number_format($persenPola, 2, ',', '.');  ?></td>
                                    </tr>
                                    <tr>
                                        <!-- <td>7</td> -->
                                        <td class="ps-4">Tarif rata-rata</td>
                                        <td class="text-center">Rp</td>
                                        <td class="text-end pe-4"><?= number_format($tarifRataRkap, 2, ',', '.'); ?></td>
                                        <td class="text-end pe-4"><?= number_format($tarifRataReal, 2, ',', '.'); ?></td>
                                        <td class="text-end pe-4"><?= number_format($naikTurunRata, 2, ',', '.'); ?></td>
                                        <td class="text-center"><?= number_format($persenRata, 2, ',', '.') ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6>Penjelasan pendapatan tahun <?= date('Y') ?> tidak mencapai target adalah :</h6>
                            <?php if (empty($target)) : ?>
                                <p class="text-danger">Belum ada Penjelasan yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($target as $row) : ?>
                                            <tr>
                                                <td width="90%">
                                                    <ul>
                                                        <li class="ps-2"><?= $row->uraian_target; ?></li>
                                                    </ul>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_upk/edit_target_sr/' . $row->id_target) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6>Usulan program dalam rangka peningkatan pendapatan tahun <?= date('Y') + 1 ?></h6>
                            <h6>Bidang Teknik</h6>
                            <?php if (empty($usulanTeknik)) : ?>
                                <p class="text-danger">Belum ada usulan Teknik yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($usulanTeknik as $row) : ?>
                                            <tr>
                                                <td width="90%">
                                                    <ul>
                                                        <li class="ps-2"><?= $row->usulan_teknik ?></li>
                                                    </ul>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_teknik/' . $row->id_usulanTeknik) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <h6>Bidang Administrasi</h6>
                            <?php if (empty($usulanAdmin)) : ?>
                                <p class="text-danger">Belum ada usulan administrasi yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($usulanAdmin as $row) : ?>
                                            <tr>
                                                <td width="90%">
                                                    <ul>
                                                        <li class="ps-2"><?= $row->usulan_admin ?></li>
                                                    </ul>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_admin/' . $row->id_usulanAdmin) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
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