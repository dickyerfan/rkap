<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/data_pendukung/pola_konsumsi_tarif') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/data_pendukung/save_pola_konsumsi') ?>" method="post">
                        <div class="form-group mb-3">
                            <label>UPK</label>
                            <select name="id_upk" class="form-control" required>
                                <option value="">-- Pilih UPK --</option>
                                <?php foreach ($upk as $row) : ?>
                                    <option value="<?= $row->id_upk ?>"><?= $row->nama_upk ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Pelanggan</label>
                            <select name="id_jp" class="form-control" required>
                                <option value="">-- Pilih Jenis Pelanggan --</option>
                                <?php foreach ($jenis as $row) : ?>
                                    <option value="<?= $row->id_jp ?>"><?= $row->nama_jp ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label>Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
                        </div>

                        <!-- Pola Konsumsi -->
                        <div class="form-group mb-3">
                            <label>Pola Konsumsi Rata-rata</label>
                            <input type="number" name="konsumsi_rata" step="0.01" class="form-control" placeholder="Masukkan biaya pola konsumsi Rata-rata" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>