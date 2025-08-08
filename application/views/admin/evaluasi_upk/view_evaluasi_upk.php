<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a>
                        <form action="<?= base_url('admin/evaluasi_upk') ?>" method="post">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="bondowoso">Bondowoso</option>
                                    <option value="sukosari1">Sukosari 1</option>
                                    <option value="maesan">Maesan</option>
                                    <option value="tegalampel">Tegalampel</option>
                                    <option value="tapen">Tapen</option>
                                    <option value="prajekan">Prajekan</option>
                                    <option value="tlogosari">Tlogosari</option>
                                    <option value="wringin">Wringin</option>
                                    <option value="curahdami">Curahdami</option>
                                    <option value="tamanan">Tamanan</option>
                                    <option value="tenggarang">Tenggarang</option>
                                    <option value="tamankrocok">Tamankrocok</option>
                                    <option value="wonosari">Wonosari</option>
                                    <option value="klabang">Klabang</option>
                                    <option value="sukosari2">Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="#" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                            <!-- <a class="nav-link fw-bold" target="_blank" href="<?= base_url('admin/evaluasi_upk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a> -->
                        </div>
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                            <h5>UPK <?= strtoupper($namaUpk);  ?></h5>
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
                                        <th colspan="2">S/D Juli <?= $tahun; ?></th>
                                        <th colspan="2">Naik/Turun</th>
                                        <!-- <th rowspan="2" class="align-middle">Action</th> -->
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
                                            <!-- <td class="text-center"><a href="<?= base_url('rkap/evaluasi_upk/edit_evaluasi_upk/') ?><?= $id ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
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
                            <h6>Penjelasan pendapatan tahun <?= $tahun; ?> tidak mencapai target adalah :</h6>
                            <?php if (empty($target)) : ?>
                                <p class="text-danger">Belum ada Penjelasan yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($target as $row) : ?>
                                            <tr>
                                                <td width="90%" class="ps-4">
                                                    <li class="ps-2"><?= $row->uraian_target; ?></li>
                                                </td>
                                                <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_target_sr/' . $row->id_target) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
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
                            <h6>Usulan program dalam rangka peningkatan pendapatan tahun <?= $tahun + 1 ?></h6>
                            <h6>Bidang Teknik :</h6>
                            <?php if (empty($usulanTeknik)) : ?>
                                <p class="text-danger">Belum ada usulan Teknik yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($usulanTeknik as $row) : ?>
                                            <tr>
                                                <td width="90%" class="ps-4">
                                                    <li class="ps-2"><?= $row->usulan_teknik ?></li>
                                                </td>
                                                <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_teknik/' . $row->id_usulanTeknik) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>

                            <h6>Bidang Administrasi :</h6>
                            <?php if (empty($usulanAdmin)) : ?>
                                <p class="text-danger">Belum ada usulan administrasi yang diinputkan.</p>
                            <?php else : ?>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <?php foreach ($usulanAdmin as $row) : ?>
                                            <tr>
                                                <td width="90%" class="ps-4">
                                                    <li class="ps-2"><?= $row->usulan_admin ?></li>
                                                </td>
                                                <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_admin/' . $row->id_usulanAdmin) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
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
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="<?= base_url('admin/evaluasi_upk/export_pdf') ?>" method="post" target="_blank">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="bondowoso">Bondowoso</option>
                                    <option value="sukosari1">Sukosari 1</option>
                                    <option value="maesan">Maesan</option>
                                    <option value="tegalampel">Tegalampel</option>
                                    <option value="tapen">Tapen</option>
                                    <option value="prajekan">Prajekan</option>
                                    <option value="tlogosari">Tlogosari</option>
                                    <option value="wringin">Wringin</option>
                                    <option value="curahdami">Curahdami</option>
                                    <option value="tamanan">Tamanan</option>
                                    <option value="tenggarang">Tenggarang</option>
                                    <option value="tamankrocok">Tamankrocok</option>
                                    <option value="wonosari">Wonosari</option>
                                    <option value="klabang">Klabang</option>
                                    <option value="sukosari2">Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button" data-bs-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>