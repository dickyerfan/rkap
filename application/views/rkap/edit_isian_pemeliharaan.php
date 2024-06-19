<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/isian_pemeliharaan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/isian_pemeliharaan/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_usulanPemeliharaan" id="id_usulanPemeliharaan" value="<?= $isian_pemeliharaan->id_usulanPemeliharaan; ?>">
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
                                    <label for="latar_belakang">Latar Belakang :</label>
                                    <textarea name="latar_belakang" id="latar_belakang" cols="30" rows="8" class="form-control" disabled><?= $isian_pemeliharaan->latar_belakang; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('latar_belakang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">volume :</label>
                                    <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $isian_pemeliharaan->volume; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="number" step="1" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= $isian_pemeliharaan->no_perkiraan; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label for="solusi">Solusi :</label>
                                    <textarea name="solusi" id="solusi" cols="30" rows="8" class="form-control" disabled><?= $isian_pemeliharaan->solusi; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('solusi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <select name="satuan" id="satuan" class="form-select" disabled>
                                        <option value="Meter" <?= $isian_pemeliharaan->satuan == "Meter" ? 'selected' : '' ?>>Meter</option>
                                        <option value="Unit" <?= $isian_pemeliharaan->satuan == "Unit" ? 'selected' : '' ?>>Unit</option>
                                        <option value="Ruangan" <?= $isian_pemeliharaan->satuan == "Ruangan" ? 'selected' : '' ?>>Ruangan</option>
                                        <option value="Buah" <?= $isian_pemeliharaan->satuan == "Buah" ? 'selected' : '' ?>>Buah</option>
                                        <option value="Pasang" <?= $isian_pemeliharaan->satuan == "Pasang" ? 'selected' : '' ?>>Pasang</option>
                                        <option value="Box" <?= $isian_pemeliharaan->satuan == "Box" ? 'selected' : '' ?>>Box</option>
                                        <option value="Botol" <?= $isian_pemeliharaan->satuan == "Botol" ? 'selected' : '' ?>>Botol</option>
                                        <option value="Lusin" <?= $isian_pemeliharaan->satuan == "Lusin" ? 'selected' : '' ?>>Lusin</option>
                                        <option value="Kg" <?= $isian_pemeliharaan->satuan == "Kg" ? 'selected' : '' ?>>Kg</option>
                                        <option value="M2" <?= $isian_pemeliharaan->satuan == "M2" ? 'selected' : '' ?>>M2</option>
                                        <option value="Rim" <?= $isian_pemeliharaan->satuan == "Rim" ? 'selected' : '' ?>>Rim</option>
                                        <option value="Set" <?= $isian_pemeliharaan->satuan == "Set" ? 'selected' : '' ?>>Set</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_perkiraan">Nama Perkiraan :</label>
                                    <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $isian_pemeliharaan->nama_perkiraan; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <textarea name="ket" id="ket" cols="30" rows="8" class="form-control" disabled><?= $isian_pemeliharaan->ket; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Biaya :</label>
                                    <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $isian_pemeliharaan->biaya; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('biaya'); ?></small>
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