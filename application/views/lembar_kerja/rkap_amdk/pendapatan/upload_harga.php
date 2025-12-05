<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="mb-3">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label>Produk</label>
                                <select name="id_produk" class="form-select" required>
                                    <option value="">Pilih Produk</option>
                                    <?php foreach ($produk as $p) : ?>
                                        <option value="<?= $p->id_produk; ?>"><?= $p->nama_produk; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Tarif</label>
                                <select name="id_tarif" class="form-select" required>
                                    <option value="">Pilih Tarif</option>
                                    <?php foreach ($tarif as $t) : ?>
                                        <option value="<?= $t->id_tarif; ?>"><?= $t->tarif; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>