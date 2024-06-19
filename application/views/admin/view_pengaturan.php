<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <!-- <div class="row justify-content-center px-3">
                        <div class="col-lg-12">
                            <h5>Upload & Update Data</h5>
                            <h6>Potensi SR</h6>
                            <h6>Pemetaan Lokasi SR Baru</h6>
                            <h6>Penambahan Air Baku</h6>
                            <h6>Penambahan Pelanggan Baru</h6>
                            <h6>Jumlah Pelanggan Aktif</h6>
                            <h6>Jumlah Yang Direkeningkan</h6>
                            <h6>Air Terjual</h6>
                            <h6>Pendapatan Air</h6>
                            <h6>Penjelasan Target</h6>
                            <h6>Usulan Bidang Administrasi</h6>
                            <h6>Usulan Bidang Teknik</h6>
                        </div>
                    </div> -->
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-2 text-center">
                            <h6 class="fw-bold">Upload Data</h6>
                            <?php if ($upload->status == 1) : ?>
                                <p class="neumorphic-button px-5 fs-5"> Aktif</p>
                            <?php else : ?>
                                <p class="neumorphic-button px-5 fs-5"> Tidak Aktif</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-2 text-center">
                            <h6 class="fw-bold">Update/Hapus Data</h6>
                            <?php if ($update->status_update == 1) : ?>
                                <span class="neumorphic-button px-5 fs-5"> Aktif</span>
                            <?php else : ?>
                                <span class="neumorphic-button px-5 fs-5"> Tidak Aktif</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <h6 class="text-center text-uppercase fw-bold">Tombol Aktivasi</h6>
                        <div class="col-lg-2 text-center">
                            <span class="neumorphic-button bg-secondary"><a href="<?= base_url('admin/pengaturan/uploadOff') ?>" style="text-decoration: none;" class="text-light"> Upload Data</a></span>
                            <!-- <table class="table table-sm">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nama File</th>
                                        <th>Upload</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Potensi SR</td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Pemetaan Lokasi SR Baru
                                        <td class="text-center"><a href="<?= base_url('admin/pengaturan/updateOff') ?>"><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Penambahan Air Baku
                                        <td class="text-center"><a href="<?= base_url('admin/pengaturan/updateOff') ?>"><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Penambahan Pelanggan Baru
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Pelanggan Aktif
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Yang Direkeningkan
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Air Terjual
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Pendapatan Air
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Penjelasan Target
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Usulan Bidang Administrasi
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                    <tr>
                                        <td>Usulan Bidang Teknik
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                        <td class="text-center"><a href=""><span class="btn btn-secondary btn-sm "><i class="fas fa-edit"></i> Non Aktif</span></a></td>
                                    </tr>
                                </tbody>
                            </table> -->
                        </div>
                        <div class="col-lg-2 text-center">
                            <span class="neumorphic-button bg-secondary"><a href="<?= base_url('admin/pengaturan/updateOff') ?>" style="text-decoration: none;" class="text-light"> Update / Hapus Data</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>