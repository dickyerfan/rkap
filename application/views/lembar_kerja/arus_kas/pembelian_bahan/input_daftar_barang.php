<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form action="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/simpan') ?>" method="post">
                                <div class="form-group mb-2">
                                    <label>No Per ID</label>
                                    <input type="text" name="no_per_id" class="form-control" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Pembagi</label>
                                    <input type="number" step="0.001" name="pembagi" class="form-control" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun" value="<?= date('Y') + 1 ?>" class="form-control" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Satuan</label>
                                    <select name="satuan" id="" class="form-select" required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg">buah</option>
                                        <option value="mtr">meter</option>
                                        <option value="pcs">Pcs</option>
                                    </select>
                                </div>

                                <button type="submit" class="neumorphic-button">
                                    <i class=" fas fa-save"></i> Simpan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>