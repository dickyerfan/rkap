<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/permasalahan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="satuan">Sub Bagian :</label>
                                    <select name="sub_bagian" id="sub_bagian" class="form-select select2">
                                        <option value="Langganan">Langganan</option>
                                        <option value="Penagihan">Penagihan</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Personalia">Personalia</option>
                                        <option value="administrasi">administrasi</option>
                                        <option value="Kas">Kas</option>
                                        <option value="Pembukuan">Pembukuan</option>
                                        <option value="Rekening">Rekening</option>
                                        <option value="SPI">SPI</option>
                                        <option value="Perencanaan">Perencanaan</option>
                                        <option value="Pengawasan">Pengawasan</option>
                                        <option value="Pemeliharaan">Pemeliharaan</option>
                                        <option value="Peralatan">Peralatan</option>
                                        <option value="Lain-lain">Lain-lain</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('sub_bagian'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="permasalahan">Permasalahan :</label>
                                    <textarea name="permasalahan" id="permasalahan" cols="30" rows="8" class="form-control"><?= set_value('permasalahan'); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('permasalahan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="penyebab">Penyebab :</label>
                                    <textarea name="penyebab" id="penyebab" cols="30" rows="8" class="form-control"><?= set_value('penyebab'); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('penyebab'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tindak_lanjut">Tindak lanjut :</label>
                                    <textarea name="tindak_lanjut" id="tindak_lanjut" cols="30" rows="8" class="form-control"><?= set_value('tindak_lanjut'); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('tindak_lanjut'); ?></small>
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