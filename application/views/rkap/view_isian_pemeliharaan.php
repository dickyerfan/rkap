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
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Upk/Bagian</th>
                                        <th class="text-center">No Per</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Latar Belakang</th>
                                        <th class="text-center">Volume</th>
                                        <!-- <th class="text-center">Harga</th> -->
                                        <th class="text-center">Biaya</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $total_jumlah = 0;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanPemeliharaan;
                                        $harga = $row->biaya;
                                        $satuan = $row->volume;
                                        $jumlah = $harga * $satuan;
                                        $total_jumlah += $jumlah;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->bagian_upk ?></td>
                                            <td class="text-end"><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td><?= $row->latar_belakang ?></td>
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <!-- <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td> -->
                                            <!-- kode ini dipakai jika total adalah dari satuan kali harga -->
                                            <!-- <td class="text-end"><?= number_format($jumlah, 0, ',', '.') ?></td> -->
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/isian_pemeliharaan/edit_isian_pemeliharaan/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i> </a>
                                                <!-- <a href="<?= base_url('rkap/isian_pemeliharaan/detail_isian_pemeliharaan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <!-- <a href="<?= base_url('rkap/isian_pemeliharaan/hapus_isian_pemeliharaan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end">Total</th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                        <!-- <th class="text-end"><?= number_format($total_jumlah, 0, ',', '.') ?></th> -->
                                        <th></th>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>