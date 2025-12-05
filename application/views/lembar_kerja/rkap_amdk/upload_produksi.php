<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/produksi') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label>Tahun RKAP</label>
                                    <input type="number" name="tahun_rkap" class="form-control" value="<?= date('Y') + 1 ?>" readonly>
                                </div>
                                <div class="mb-2">
                                    <label>Produk</label>
                                    <select name="id_produk" class="form-select">
                                        <?php foreach ($produk as $p) : ?>
                                            <option value="<?= $p->id_produk ?>"><?= $p->nama_produk ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Jumlah Produksi per Bulan</label>
                                    <input type="number" name="jumlah_produksi" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>