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
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <div class="row justify-content-center mb-4">
                            <div class="col-lg-3 col-md-6 text-center mb-3">
                                <div class="p-3 border rounded-3 shadow-sm">
                                    <h6 class="fw-bold text-secondary mb-2">Upload Data</h6>
                                    <?php if ($upload && $upload->status == 1) : ?>
                                        <span class="badge bg-success px-4 py-2 fs-6">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger px-4 py-2 fs-6">Tidak Aktif</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 text-center mb-3">
                                <div class="p-3 border rounded-3 shadow-sm">
                                    <h6 class="fw-bold text-secondary mb-2">Update / Hapus Data</h6>
                                    <?php if ($update && $update->status_update == 1) : ?>
                                        <span class="badge bg-success px-4 py-2 fs-6">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-danger px-4 py-2 fs-6">Tidak Aktif</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <h6 class="text-uppercase fw-bold text-secondary">Tombol Aktivasi</h6>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-3 col-md-6 text-center mb-2">
                                <a href="<?= base_url('admin/pengaturan/uploadOff') ?>" class="btn btn-outline-primary w-100 py-2 rounded-pill shadow-sm">
                                    Upload Data
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-6 text-center mb-2">
                                <a href="<?= base_url('admin/pengaturan/updateOff') ?>" class="btn btn-outline-primary w-100 py-2 rounded-pill shadow-sm">
                                    Update / Hapus Data
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>