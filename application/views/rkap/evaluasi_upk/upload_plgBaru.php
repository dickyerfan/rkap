<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Evaluasi_upk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                                    <select name="tahun_rkap" class="form-select">
                                        <?php
                                        $mulai = date('Y') - 2;
                                        for ($i = $mulai; $i < $mulai + 11; $i++) {
                                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                                            echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tahun_rkap'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="rkap">RKAP :</label>
                                    <input type="number" step="0.01" class="form-control" id="rkap" name="rkap" value="<?= set_value('rkap'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('rkap'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="realisasi">Realisasi :</label>
                                    <input type="number" step="0.01" class="form-control" id="realisasi" name="realisasi" value="<?= set_value('realisasi'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('realisasi'); ?></small>
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