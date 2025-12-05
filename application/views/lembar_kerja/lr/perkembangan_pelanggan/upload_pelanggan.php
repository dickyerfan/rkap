<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pelanggan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/lr/pelanggan/insert_data') ?>" method="post">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label>Nama UPK</label>
                                    <select name="id_upk" class="form-select" required>
                                        <option value="">-- Pilih UPK --</option>
                                        <?php foreach ($upk_list as $u) : ?>
                                            <option value="<?= $u->id_upk ?>"><?= $u->nama_upk ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Jenis Pelanggan</label>
                                    <select name="id_jp" class="form-select" required>
                                        <option value="">-- Pilih Jenis Pelanggan --</option>
                                        <?php foreach ($jenis_list as $j) : ?>
                                            <option value="<?= $j->id_jp ?>"><?= $j->nama_jp ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="tahun" value="<?= date('Y') + 1 ?>">
                                <div class="form-group mb-2">
                                    <label>Tahun RKAP</label>
                                    <!-- <input type="number" name="tahun" value="<?= date('Y') + 1 ?>" class="form-select" readonly> -->
                                    <input type="text" class="form-control" value="<?= date('Y') + 1 ?>" readonly>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Bulan</label>
                                    <select name="bulan" class="form-select" required>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= $i ?>"><?= date("F", mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label>Sambungan Awal</label>
                                    <input type="number" name="s_awal" class="form-control" value="0">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Sambungan Baru</label>
                                    <input type="number" name="s_baru" class="form-control" value="0">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Penutupan</label>
                                    <input type="number" name="penutupan" class="form-control" value="0">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Pembukaan</label>
                                    <input type="number" name="pembukaan" class="form-control" value="0">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Pencabutan</label>
                                    <input type="number" name="pencabutan" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>