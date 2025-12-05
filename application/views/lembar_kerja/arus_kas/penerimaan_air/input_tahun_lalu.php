<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/simpan_tahun_lalu') ?>" method="post">

                                <label>UPK</label>
                                <select name="id_upk" class="form-control" required>
                                    <option value="">-- Pilih UPK --</option>
                                    <?php foreach ($list_upk as $upk) : ?>
                                        <option value="<?= $upk->id_upk ?>"><?= $upk->nama_upk ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label>Jenis Pelanggan</label>
                                <select name="id_jp" class="form-control" required>
                                    <option value="">-- Pilih Jenis Pelanggan --</option>
                                    <?php foreach ($list_jp as $jp) : ?>
                                        <option value="<?= $jp->id_jp ?>"><?= $jp->nama_jp ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label>Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="<?= date('Y') + 1 ?>" readonly>

                                <label>Sisa Lembar Tahun Lalu</label>
                                <input type="number" name="lembar_lalu" class="form-control" required>

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