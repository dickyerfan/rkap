<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Evaluasi_program') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/evaluasi_program/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_evaluasi_program" id="id_evaluasi_program" value="<?= $evaluasi_program->id_evaluasi_program; ?>">
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
                                    <small class="form-text text-danger pl-3"><?= form_error('tahun_rkap'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="evaluasi">Evaluasi :</label>
                                    <textarea name="evaluasi" id="evaluasi" cols="30" rows="8" class="form-control"><?= set_value('evaluasi', $evaluasi_program->evaluasi); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('evaluasi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="tindak_lanjut">Tindak Lanjut :</label>
                                    <textarea name="tindak_lanjut" id="tindak_lanjut" cols="30" rows="8" class="form-control"><?= set_value('tindak_lanjut', $evaluasi_program->tindak_lanjut); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('tindak_lanjut'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan :</label>
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="8" class="form-control"><?= set_value('keterangan', $evaluasi_program->keterangan); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
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