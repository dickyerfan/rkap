<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold neumorphic-button" target="_blank" href="<?= base_url('rkap/evaluasi_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                        </div>
                        <div class="nav-item dropdown ms-auto">
                            <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input Data</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- <?php if ($statusEvaluasiAmdk && $statusEvaluasiAmdk->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Penambahan Tenaga Kerja</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_tenaga_kerja') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Penambahan Tenaga Kerja</a></li>
                                <?php endif; ?>
                                <?php if ($statusEvaluasiAmdk && $statusEvaluasiAmdk->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Piutang Usaha</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_piutang_usaha') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Piutang Usaha</a></li>
                                <?php endif; ?>
                                <?php if ($statusEvaluasiAmdk && $statusEvaluasiAmdk->status_update == 1) : ?>
                                    <li><a class="dropdown-item" href="#" style="font-size: 0.8rem;" onclick="showUploadWarning()"><i class="fas fa-upload"></i> Pendapatan Usaha</a></li>
                                <?php else : ?>
                                    <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_pendapatan_usaha') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Pendapatan Usaha</a></li>
                                <?php endif; ?> -->
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_tenaga_kerja') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Penambahan Tenaga Kerja</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_piutang_usaha') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Piutang Usaha</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_pendapatan_usaha') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Pendapatan Usaha</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_target') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Penjelasan Target <?= date('Y') ?></a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_usulanAdmin') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Usulan Bidang Administrasi</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('rkap/evaluasi_amdk/upload_usulanTeknik') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Usulan Bidang Teknik</a></li>
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
                            <h5>UNIT <?= strtoupper($this->session->userdata('upk_bagian'));  ?></h5>
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
                                    <tr>
                                        <td class="ps-3">Jumlah Tenaga Kerja</td>
                                        <td colspan="6"></td>
                                    </tr>
                                    <?php foreach ($tenaga_kerja as $row) :
                                        $realisasi = $row->realisasi;
                                        $rkap = $row->rkap;
                                        $id = $row->id_evaluasi_amdk;
                                        $naikTurun = $realisasi - $rkap;
                                        $persen = ($naikTurun / $rkap) * 100;
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <li><?= $row->uraian_evaluasi; ?></li>
                                            </td>
                                            <td class="text-center"><?= $row->satuan; ?></td>
                                            <td class="text-center"><?= $row->rkap; ?></td>
                                            <td class="text-center"><?= $row->realisasi; ?></td>
                                            <td class="text-center"><?= $naikTurun; ?></td>
                                            <td class="text-center"><?= $persen; ?></td>
                                            <td class="text-center"><a href="<?= base_url('rkap/evaluasi_amdk/edit_evaluasi_amdk/') ?><?= $id ?>"><i class="fas fa-edit text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Edit Data"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="ps-3">Nilai Piutang Usaha</td>
                                        <td colspan="6"></td>
                                    </tr>
                                    <?php foreach ($piutang_usaha as $row) :
                                        $realisasi = $row->realisasi;
                                        $rkap = $row->rkap;
                                        $id = $row->id_evaluasi_amdk;
                                        // $naikTurun = $realisasi - $rkap;
                                        // $persen = ($naikTurun / $rkap) * 100;
                                        $naikTurun = $realisasi - $rkap;
                                        if ($naikTurun < 0) {
                                            $naikTurun = 0;
                                        }

                                        if ($rkap != 0) {
                                            $persen = ($naikTurun / $rkap) * 100;
                                        } else {
                                            $persen = 0; // Atau nilai default lainnya
                                        }
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <li><?= $row->uraian_evaluasi; ?></li>
                                            </td>
                                            <td class="text-center"><?= $row->satuan; ?></td>
                                            <td class="text-center"><?= $row->rkap; ?></td>
                                            <td class="text-center"><?= $row->realisasi; ?></td>
                                            <td class="text-center"><?= $naikTurun; ?></td>
                                            <td class="text-center"><?= $persen; ?></td>
                                            <td class="text-center"><a href="<?= base_url('rkap/evaluasi_amdk/edit_evaluasi_amdk/') ?><?= $id ?>"><i class="fas fa-edit text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Edit Data"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="ps-3">Pendapatan Usaha</td>
                                        <td colspan="6"></td>
                                    </tr>
                                    <?php foreach ($pendapatan_usaha as $row) :
                                        $realisasi = $row->realisasi;
                                        $rkap = $row->rkap;
                                        $id = $row->id_evaluasi_amdk;
                                        // $naikTurun = $realisasi - $rkap;
                                        // $persen = ($naikTurun / $rkap) * 100;
                                        if ($naikTurun < 0) {
                                            $naikTurun = 0;
                                        }

                                        if ($rkap != 0) {
                                            $persen = ($naikTurun / $rkap) * 100;
                                        } else {
                                            $persen = 0; // Atau nilai default lainnya
                                        }
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <li><?= $row->uraian_evaluasi; ?></li>
                                            </td>
                                            <td class="text-center"><?= $row->satuan; ?></td>
                                            <td class="text-end pe-3"><?= number_format($row->rkap, 0, ',', '.'); ?></td>
                                            <td class="text-end pe-3"><?= number_format($row->realisasi, 0, ',', '.'); ?></td>
                                            <td class="text-end pe-3"><?= number_format($naikTurun, 0, ',', '.'); ?></td>
                                            <td class="text-center"><?= number_format($persen, 2, ',', '.'); ?></td>
                                            <td class="text-center"><a href="<?= base_url('rkap/evaluasi_amdk/edit_evaluasi_amdk/') ?><?= $id ?>"><i class="fas fa-edit text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Edit Data"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
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
                                                <td width="92%" class="ps-4">
                                                    <li><?= $row->uraian_target; ?></li>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_amdk/edit_target_sr/' . $row->id_target) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
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
                                                <td width="92%" class="ps-4">
                                                    <li><?= $row->usulan_teknik; ?></li>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_amdk/edit_usulan_teknik/' . $row->id_usulanTeknik) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
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
                                                <td width="92%" class="ps-4">
                                                    <li><?= $row->usulan_admin; ?></li>
                                                </td>
                                                <td><a href="<?= base_url('rkap/evaluasi_amdk/edit_usulan_admin/' . $row->id_usulanAdmin) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td>
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