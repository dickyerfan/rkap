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
                    <form class="user" action="<?= base_url('rkap/Potensi_sr/update_ket_potensi') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <input type="hidden" name="id_ket_potensi" id="id_ket_potensi" value="<?= $ketPotensi->id_ket_potensi; ?>">
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
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil" name="nama_wil" value="<?= $ketPotensi->nama_wil; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr" name="jumlah_sr" value="<?= $ketPotensi->jumlah_sr; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr'); ?></small>
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
                <!-- <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun RKAP :</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil[1]" name="nama_wil[1]" value="<?= is_array(set_value('nama_wil')) ? '' : set_value('nama_wil[1]'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil[1]'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr[1]" name="jumlah_sr[1]" value="<?= is_array(set_value('jumlah_sr')) ? '' : set_value('jumlah_sr[1]'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr[1]'); ?></small>
                                </div>
                            </div>
                        </div>
 
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun RKAP :</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil[]" name="nama_wil[]" value="<?= is_array(set_value('nama_wil')) ? '' : set_value('nama_wil'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil[]'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr[]" name="jumlah_sr[]" value="<?= is_array(set_value('jumlah_sr')) ? '' : set_value('jumlah_sr'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr[]'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun RKAP :</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil[]" name="nama_wil[]" value="<?= is_array(set_value('nama_wil')) ? '' : set_value('nama_wil'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil[]'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr[]" name="jumlah_sr[]" value="<?= is_array(set_value('jumlah_sr')) ? '' : set_value('jumlah_sr'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr[]'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun RKAP :</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil[]" name="nama_wil[]" value="<?= is_array(set_value('nama_wil')) ? '' : set_value('nama_wil'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil[]'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr[]" name="jumlah_sr[]" value="<?= is_array(set_value('jumlah_sr')) ? '' : set_value('jumlah_sr'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr[]'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun RKAP :</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nama_wil">Wilayah Potensi SR Baru :</label>
                                    <input type="text" class="form-control" id="nama_wil[]" name="nama_wil[]" value="<?= is_array(set_value('nama_wil')) ? '' : set_value('nama_wil'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_wil[]'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="jumlah_sr">Jumlah SR Baru :</label>
                                    <input type="number" class="form-control" id="jumlah_sr[]" name="jumlah_sr[]" value="<?= is_array(set_value('jumlah_sr')) ? '' : set_value('jumlah_sr'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_sr[]'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div> -->
            </div>
        </div>
    </main>