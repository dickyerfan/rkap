<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) . ' ' .  date('Y') ?></a> -->
                    <!-- <a href="<?= base_url('rkap/usulan_barang/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_barang_amdk/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('rkap/usulan_barang_amdk/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload ATK & Alat Cetak</button></a>
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
                                        <th rowspan="2" class="align-middle">No</th>
                                        <th colspan="2">Perkiraan</th>
                                        <th colspan="4" class="align-middle">URAIAN TENTANG USULAN</th>
                                        <th rowspan="2" class="align-middle">Keterangan</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>No Per</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <!-- <th>Latar Belakang</th>
                                        <th>Solusi/Usulan</th> -->
                                        <th>Volume</th>
                                        <th>Harga</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanBarang;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td><?= $row->kategori ?></td>
                                            <!-- <td><?= $row->latar_belakang ?></td>
                                            <td><?= $row->solusi ?></td> -->
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->harga_satuan, 0, ',', '.') ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <td><?= $row->ket ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/usulan_barang_amdk/detail_usulan_barang/') . $id ?>" style="margin:0 1px; text-decoration:none; display:inline-block;">
                                                    <i class="fa-solid fa-circle-info text-primary" style="vertical-align:middle;"></i>
                                                </a>
                                                <a href="<?= base_url('rkap/usulan_barang_amdk/edit_usulan_barang/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('rkap/usulan_barang_amdk/hapus_usulan_barang/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-end">Total</th>
                                        <th></th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>