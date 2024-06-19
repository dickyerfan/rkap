<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Potensi_sr') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <!-- <div class="form-group">
                                    <label for="tgl_lahir">Tahun RKAP :</label>
                                    <input type="date" class="form-control" id="tahun_rkap" name="tahun_rkap" value="<?= set_value('tahun_rkap'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tahun_rkap'); ?></small>
                                </div> -->
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
                                <div class="form-group">
                                    <label for="kap_pro">Kapasitas Produksi :</label>
                                    <input type="number" step="0.01" class="form-control" id="kap_pro" name="kap_pro" value="<?= set_value('kap_pro'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('kap_pro'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="kap_manf">Kapasitas Dimanfaatkan :</label>
                                    <input type="number" step="0.01" class="form-control" id="kap_manf" name="kap_manf" value="<?= set_value('kap_manf'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('kap_manf'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jam_op">Jam Operasional :</label>
                                    <input type="number" step="0.01" class="form-control" id="jam_op" name="jam_op" value="<?= set_value('jam_op'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jam_op'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="tk_bocor">Tingkat Kebocoran :</label>
                                    <input type="number" step="0.01" class="form-control" id="tk_bocor" name="tk_bocor" value="<?= set_value('tk_bocor'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tk_bocor'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="plg_aktif">Jumlah Pelanggan aktif :</label>
                                    <input type="number" class="form-control" id="plg_aktif" name="plg_aktif" value="<?= set_value('plg_aktif'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('plg_aktif'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tambah_sr">Tambahan SR s/d akhir tahun :</label>
                                    <input type="number" class="form-control" id="tambah_sr" name="tambah_sr" value="<?= set_value('tambah_sr'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tambah_sr'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="pola_kon">Pola Konsumsi rata2 :</label>
                                    <input type="number" step="0.01" class="form-control" id="pola_kon" name="pola_kon" value="<?= set_value('pola_kon'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('pola_kon'); ?></small>
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