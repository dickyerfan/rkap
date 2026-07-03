<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/produksi/persen') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Produk</label>
                                    <select name="id_produk" class="form-control">
                                        <?php foreach ($produk as $p) : ?>
                                            <option value="<?= $p->id_produk ?>" <?= $row->id_produk == $p->id_produk ? 'selected' : '' ?>>
                                                <?= $p->nama_produk ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tarif</label>
                                    <select name="id_tarif" class="form-control">
                                        <?php foreach ($tarif as $t) : ?>
                                            <option value="<?= $t->id_tarif ?>" <?= $row->id_tarif == $t->id_tarif ? 'selected' : '' ?>>
                                                <?= $t->tarif ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Persen</label>
                                    <input type="number" step="0.01" name="persen" value="<?= $row->persen ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Tahun RKAP</label>
                                    <input type="number" name="tahun_rkap" value="<?= $row->tahun_rkap ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6  text-center">
                                <button class="neumorphic-button text-center mt-2">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>