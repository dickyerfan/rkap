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
                            <div class="col-md-4">
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
                                    <label for="uraian">Uraian :</label>
                                    <select name="uraian" id="" class="form-select">
                                        <option value="">Pilih Uraian</option>
                                        <option value="Galon 19 ml">Galon 19 ml</option>
                                        <option value="Air Gelas 220 ml">Air Gelas 220 ml</option>
                                        <option value="Air Botol 330 ml">Air Botol 330 ml</option>
                                        <option value="Air Botol 500 ml">Air Botol 500 ml</option>
                                        <option value="Air Botol 1500 ml">Air Botol 1500 ml</option>
                                        <option value="Air Gelas 250 ml">Air Gelas 250 ml</option>
                                        <option value="Galon Baru / Non Air">Galon Baru / Non Air</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('uraian'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="tarif">Tarif :</label>
                                    <select name="tarif" id="" class="form-select">
                                        <option value="">Pilih tarif</option>
                                        <option value="User">User</option>
                                        <option value="Retail">Retail</option>
                                        <option value="Grosir">Grosir</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tarif'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga">Harga :</label>
                                    <input type="number" step="0.01" class="form-control" id="harga" name="harga" value="<?= set_value('harga'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Produksi :</label>
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