<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/tampil_tahun_lalu') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form action="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/simpan_tahun_lalu') ?>" method="post">

                                <label>NAMA PRODUK</label>
                                <select name="id_produk" class="form-control" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach ($list_produk as $produk) : ?>
                                        <option value="<?= $produk->id_produk ?>"><?= $produk->nama_produk ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label>Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="<?= date('Y') + 1 ?>" readonly>

                                <label>Sisa Produk Tahun Lalu</label>
                                <input type="number" name="produk_lalu" class="form-control" required>

                                <label>Sisa Rupiah Tahun Lalu</label>
                                <input type="number" step="0.01" name="rupiah_lalu" class="form-control" required>

                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>