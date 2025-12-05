<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?= site_url('lembar_kerja/lr/pendapatan_air/save') ?>" method="post">
                                <input type="text" name="tahun" class="form-control" value="<?= $tahun ?>" readonly>
                                <div class="mb-3">
                                    <label for="no_per_id">Kode Perkiraan</label>
                                    <select name="no_per_id" id="no_per_id" class="form-control" required>
                                        <option value="">-- Pilih Kode --</option>
                                        <?php foreach ($no_per_list as $np) : ?>
                                            <option value="<?= $np['kode'] ?>">
                                                <?= $np['kode'] ?> - <?= $np['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bulan">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control" required>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= $i; ?>"><?= date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="penggunaan_rata2">Jumlah Penggunaan rata2</label>
                                    <input type="number" step="0.01" name="penggunaan_rata2" class="form-control" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="m3_rata2">Jumlah M3 rata2</label>
                                    <input type="number" step="0.01" name="m3_rata2" class="form-control" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="tarif_rata2">Tarif rata2</label>
                                    <input type="number" step="0.01" name="tarif_rata2" class="form-control" required>
                                </div>
                                <button type="submit" class="neumorphic-button mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>