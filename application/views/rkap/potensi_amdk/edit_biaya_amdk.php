<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/potensi_amdk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/potensi_amdk/update_biaya') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_biaya_amdk" id="id_biaya_amdk" value="<?= $biaya_amdk->id_biaya_amdk; ?>">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun Pembuatan RKAP :</label>
                                    <select name="tahun_rkap" class="form-select" disabled>
                                        <?php
                                        $mulai = date('Y') - 2;
                                        for ($i = $mulai; $i < $mulai + 11; $i++) {
                                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                                            echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_biaya">Tipe Biaya :</label>
                                    <select name="tipe_biaya" id="tipe_biaya" class="form-select select2">
                                        <option value="Biaya Pegawai" <?= $biaya_amdk->tipe_biaya == "Biaya Pegawai" ? 'selected' : '' ?>>Biaya Pegawai</option>
                                        <option value="Biaya Operasional" <?= $biaya_amdk->tipe_biaya == "Biaya Operasional" ? 'selected' : '' ?>>Biaya Operasional</option>
                                        <option value="Biaya Lain2" <?= $biaya_amdk->tipe_biaya == "Biaya Lain2" ? 'selected' : '' ?>>Biaya Lain2</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tipe_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="nama_biaya">Nama Biaya :</label>
                                    <input type="text" name="nama_biaya" id="nama_biaya" class="form-control" value="<?= $biaya_amdk->nama_biaya; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="rincian_biaya">Rincian Biaya :</label>
                                    <input type="text" name="rincian_biaya" id="rincian_biaya" class="form-control" value="<?= $biaya_amdk->rincian_biaya; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('rincian_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan :</label>
                                    <input type="text" name="keterangan" id="keterangan" class="form-control" value="<?= $biaya_amdk->keterangan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Biaya :</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?= $biaya_amdk->jumlah; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>