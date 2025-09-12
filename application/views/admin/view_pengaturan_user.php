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
                <!-- <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-2 text-center">
                            <h6 class="fw-bold">Status UPK / Bagian</h6>
                            <?php if ($statusPengguna->status == 1) : ?>
                                <p class="neumorphic-button px-5 fs-5"> Aktif</p>
                            <?php else : ?>
                                <p class="neumorphic-button px-5 fs-5"> Tidak Aktif</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <h6 class="text-center text-uppercase fw-bold">Tombol Aktivasi</h6>
                        <div class="col-lg-2 text-center">
                            <span class="neumorphic-button bg-secondary"><a href="<?= base_url('admin/pengaturan/matikanUser') ?>" style="text-decoration: none;" class="text-light"> Klik Untuk Aktivasi</a></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-2 text-center">
                            <h6 class="fw-bold">Status Pengisi Data</h6>
                            <?php if ($statusPengisi->status == 1) : ?>
                                <p class="neumorphic-button px-5 fs-5"> Aktif</p>
                            <?php else : ?>
                                <p class="neumorphic-button px-5 fs-5"> Tidak Aktif</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <h6 class="text-center text-uppercase fw-bold">Tombol Aktivasi</h6>
                        <div class="col-lg-2 text-center">
                            <span class="neumorphic-button bg-secondary"><a href="<?= base_url('admin/pengaturan/matikanPengisi') ?>" style="text-decoration: none;" class="text-light"> Klik Untuk Aktivasi</a></span>
                        </div>
                    </div>
                </div> -->
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0 rounded-4 mb-4">
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-3">Status UPK</h6>
                                <?php if ($statusPenggunaUpk->status == 1) : ?>
                                    <span class="badge bg-success fs-6 px-3 py-2">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger fs-6 px-3 py-2">Tidak Aktif</span>
                                <?php endif; ?>

                                <hr class="my-4">

                                <h6 class="text-uppercase fw-bold mb-3">Tombol Aktivasi</h6>
                                <a href="<?= base_url('admin/pengaturan/matikanUserUpk') ?>" class="btn btn-outline-primary rounded-pill px-4">
                                    Klik Untuk Aktivasi
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-lg border-0 rounded-4">
                            <div class="card-body text-center">
                                <h6 class="fw-bold mb-3">Status Bagian</h6>
                                <?php if ($statusPenggunaBagian->status == 1) : ?>
                                    <span class="badge bg-success fs-6 px-3 py-2">Aktif</span>
                                <?php else : ?>
                                    <span class="badge bg-danger fs-6 px-3 py-2">Tidak Aktif</span>
                                <?php endif; ?>

                                <hr class="my-4">

                                <h6 class="text-uppercase fw-bold mb-3">Tombol Aktivasi</h6>
                                <a href="<?= base_url('admin/pengaturan/matikanUserBagian') ?>" class="btn btn-outline-primary rounded-pill px-4">
                                    Klik Untuk Aktivasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>