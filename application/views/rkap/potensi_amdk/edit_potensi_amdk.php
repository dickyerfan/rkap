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
                    <form class="user" action="<?= base_url('rkap/potensi_amdk/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_potensi_amdk" id="id_potensi_amdk" value="<?= $potensi_amdk->id_potensi_amdk; ?>">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="uraian">Nama Produk :</label>
                                    <select name="uraian" id="uraian" class="form-select select2" disabled>
                                        <option value="Galon 19 ml" <?= $potensi_amdk->uraian == "Galon 19 ml" ? 'selected' : '' ?>>Galon 19 ml</option>
                                        <option value="Air Gelas 220 ml" <?= $potensi_amdk->uraian == "Air Gelas 220 ml" ? 'selected' : '' ?>>Air Gelas 220 ml</option>
                                        <option value="Air Botol 330 ml" <?= $potensi_amdk->uraian == "Air Botol 330 ml" ? 'selected' : '' ?>>Air Botol 330 ml</option>
                                        <option value="Air Botol 500 ml" <?= $potensi_amdk->uraian == "Air Botol 500 ml" ? 'selected' : '' ?>>Air Botol 500 ml</option>
                                        <option value="Air Botol 1500 ml" <?= $potensi_amdk->uraian == "Air Botol 1500 ml" ? 'selected' : '' ?>>Air Botol 1500 ml</option>
                                        <option value="Air Gelas 250 ml" <?= $potensi_amdk->uraian == "Air Gelas 250 ml" ? 'selected' : '' ?>>Air Gelas 250 ml</option>
                                        <option value="Galon Baru / Non Air" <?= $potensi_amdk->uraian == "Galon Baru / Non Air" ? 'selected' : '' ?>>Galon Baru / Non Air</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('uraian'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="harga">Harga :</label>
                                    <input type="number" name="harga" id="harga" class="form-control" value="<?= $potensi_amdk->harga; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah Produksi :</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="<?= $potensi_amdk->jumlah; ?>">
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