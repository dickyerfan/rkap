<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/produksi_air/data_efisiensi') ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="" class="mb-3">
                                <div class="form-group mb-3">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun" value="<?= $efisiensi['tahun'] ?>" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Efisiensi (%)</label>
                                    <input type="number" step="0.01" name="efisiensi" value="<?= $efisiensi['efisiensi'] ?>" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Keterangan</label>
                                    <input type="text" name="keterangan" value="<?= $efisiensi['keterangan'] ?>" class="form-control">
                                </div>
                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>