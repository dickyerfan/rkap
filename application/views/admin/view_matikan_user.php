<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/pengaturan/aktivasiUser') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('admin/pengaturan/penggunaOff') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <label for="status" class="form-group">Menu Aktivasi User / Pengguna</label>
                                <select class="form-select" name="status" aria-label="Default select example">
                                    <option value="0" <?= $statusPengguna->status == 0 ? 'selected' : '' ?>>Non Aktif</option>
                                    <option value="1" <?= $statusPengguna->status == 1 ? 'selected' : '' ?>>Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>