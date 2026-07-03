<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_barang/kategori_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= $action ?>" method="POST">
                        <?php if (!empty($kategori)) : ?>
                            <input type="hidden" name="id" value="<?= $kategori->id ?>">
                        <?php endif; ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori :</label>
                                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= set_value('nama_kategori', !empty($kategori) ? $kategori->nama_kategori : '') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_kategori'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="kode_akun">Kode Akun :</label>
                                    <input type="text" class="form-control" id="kode_akun" name="kode_akun" value="<?= set_value('kode_akun', !empty($kategori) ? $kategori->kode_akun : '') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('kode_akun'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan :</label>
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"><?= set_value('keterangan', !empty($kategori) ? $kategori->keterangan : '') ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                                <div class="text-center">
                                    <button class="neumorphic-button mt-2" type="submit"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
