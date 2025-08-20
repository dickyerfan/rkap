<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Potensi_amdk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
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
                                    <select name="tipe_biaya" id="" class="form-select">
                                        <option value="">Pilih Tipe Biaya</option>
                                        <option value="Biaya Pegawai">Biaya Pegawai</option>
                                        <option value="Biaya Operasional">Biaya Operasional</option>
                                        <option value="Biaya Lain2">Biaya Lain2</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tipe_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="nama_biaya">Nama Biaya :</label>
                                    <input type="text" step="0.01" class="form-control" id="nama_biaya" name="nama_biaya" value="<?= set_value('nama_biaya'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="rincian_biaya">Rincian Biaya :</label>
                                    <input type="text" step="0.01" class="form-control" id="rincian_biaya" name="rincian_biaya" value="<?= set_value('rincian_biaya'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('rincian_biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan :</label>
                                    <input type="text" step="0.01" class="form-control" id="keterangan" name="keterangan" value="<?= set_value('keterangan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Biaya :</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= set_value('jumlah'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>