<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark text-uppercase" style="text-decoration:none ;">Isian Pemeliharaan </a>
                    <!-- <a href="<?= base_url('rkap/usulan_pemeliharaan/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->

                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  date('Y') + 1 ?></h5>
                            <!-- <h5><?= strtoupper($this->session->userdata('nama_pengguna'));  ?></h5> -->
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table id="example" class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <!-- <tr class="text-center">
                                        <th rowspan="2" class="align-middle">No</th>
                                        <th rowspan="2" class="align-middle">UPK/Bagian</th>
                                        <th colspan="2">Perkiraan</th>
                                        <th colspan="2" class="align-middle">URAIAN TENTANG USULAN</th>
                                        <th rowspan="2" class="align-middle">Keterangan</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr> -->
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Upk/Bagian</th>
                                        <th class="text-center">No Per</th>
                                        <th class="text-center">Nama</th>
                                        <!-- <th class="text-center">Latar Belakang</th>
                                        <th class="text-center">Solusi/Usulan</th> -->
                                        <th class="text-center">Volume</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanPemeliharaan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->bagian_upk ?></td>
                                            <td class="text-end"><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <!-- <td><?= $row->latar_belakang ?></td>
                                            <td><?= $row->solusi ?></td> -->
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <td><?= $row->ket ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/isian_pemeliharaan/edit_isian_pemeliharaan/') ?><?= $id ?>"><span class="text-dark neumorphic-button" style="text-decoration: none;"><i class="fas fa-edit text-success"></i> Isi Harga</span></a>
                                                <!-- <a href="<?= base_url('rkap/isian_pemeliharaan/detail_isian_pemeliharaan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <!-- <a href="<?= base_url('rkap/isian_pemeliharaan/hapus_isian_pemeliharaan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
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