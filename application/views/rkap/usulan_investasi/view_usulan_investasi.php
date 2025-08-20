<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('rkap/usulan_inves/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a>
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
                                        <th>Latar Belakang</th>
                                        <th>Solusi/Usulan</th>
                                        <th>Volume</th>
                                        <!-- <th>Harga</th> -->
                                        <th>Total Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanInvestasi;
                                        $harga = $row->biaya;
                                        $satuan = $row->volume;
                                        $jumlah = $harga * $satuan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td><?= $row->latar_belakang ?></td>
                                            <td><?= $row->solusi ?></td>
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <!-- <td class="text-end"><?= number_format($jumlah, 0, ',', '.') ?></td> -->
                                            <td><?= $row->ket ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/usulan_inves/edit_usulan_investasi/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <!-- <a href="<?= base_url('rkap/usulan_inves/detail_usulan_investasi/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <a href="<?= base_url('rkap/usulan_inves/hapus_usulan_investasi/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">Total</th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                        <!-- <th class="text-end"><?= number_format(array_sum(array_map(function ($item) {
                                                                        return $item->biaya * $item->volume;
                                                                    }, $tampil)), 0, ',', '.') ?></th> -->
                                        <th colspan="2"></th>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>