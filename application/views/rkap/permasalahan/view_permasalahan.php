<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) . ' ' .  date('Y') ?></a> -->

                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav">
                            <a href="<?= base_url('rkap/permasalahan/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('rkap/permasalahan/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a>
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
                            <h5><?= $title . ' ' .  date('Y') + 1 ?></h5>
                            <h5><?= strtoupper($this->session->userdata('nama_pengguna'));  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub Bagian</th>
                                        <th>Permasalahan</th>
                                        <th>Penyebab</th>
                                        <th>Tindak Lanjut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_permasalahan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->sub_bagian ?></td>
                                            <td><?= $row->permasalahan ?></td>
                                            <td><?= $row->penyebab ?></td>
                                            <td><?= $row->tindak_lanjut ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/permasalahan/edit_permasalahan/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <!-- <a href="<?= base_url('rkap/permasalahan/detail_permasalahan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <a href="<?= base_url('rkap/permasalahan/hapus_permasalahan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>