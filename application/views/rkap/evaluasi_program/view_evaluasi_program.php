<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="navbar-nav">
                            <a class="nav-link neumorphic-button fw-bold" target="_blank" href="<?= base_url('rkap/evaluasi_program/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                        </div>

                        <div class="nav-item dropdow ms-auto">
                            <a class="nav-link neumorphic-button" style="font-size: 0.8rem; color:black;" href="<?= base_url('rkap/evaluasi_program/upload') ?>"><i class="fas fa-plus"></i> Input Data</a>
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
                            <h5>UPK / BAGIAN <?= strtoupper($this->session->userdata('upk_bagian'));  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Evaluasi RKAP Tahun <?= date('Y') ?> </th>
                                        <th>Program Tahun <?= date('Y') + 1; ?></th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_evaluasi_program;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row->evaluasi); ?></td>
                                            <td><?= htmlspecialchars($row->program); ?></td>
                                            <td><?= htmlspecialchars($row->keterangan); ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/evaluasi_program/edit_evaluasi_program/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('rkap/evaluasi_program/detail_evaluasi_program/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('rkap/evaluasi_program/hapus_evaluasi_program/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>