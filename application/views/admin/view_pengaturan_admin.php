<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('admin/pengaturan/aktivasiAdmin') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="container mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="card shadow-lg border-0 rounded-3">
                                    <div class="card-header text-center bg-primary text-white rounded-top">
                                        <h5 class="mb-0">🔐 Pengaturan RKAP Tahun <?= $tahun ?></h5>
                                    </div>

                                    <div class="card-body text-center">
                                        <p class="fs-5 mb-3">Status saat ini:</p>

                                        <?php if ($is_locked) : ?>
                                            <span class="badge bg-danger fs-5 px-3 py-3 mb-3">Terkunci</span>
                                            <p class="text-muted">Data RKAP tahun ini sudah dikunci. Tidak dapat diubah lagi.</p>
                                            <a href="<?= base_url('admin/pengaturan/unlock/' . $tahun) ?>" class="btn btn-warning btn-lg mt-2">
                                                <i class="bi bi-unlock"></i> Buka Kunci
                                            </a>
                                        <?php else : ?>
                                            <span class="badge bg-success fs-5 px-3 py-3 mb-3">Terbuka</span>
                                            <p class="text-muted">Data RKAP masih terbuka. Silakan kunci setelah finalisasi.</p>
                                            <a href="<?= base_url('admin/pengaturan/lock/' . $tahun) ?>" class="btn btn-primary btn-lg mt-2 mb-2">
                                                <i class="bi bi-lock"></i> Kunci Data
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-footer text-center text-muted small">
                                        <i class="bi bi-info-circle"></i>
                                        Pengaturan ini hanya berlaku untuk tahun <strong><?= $tahun ?></strong>.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>