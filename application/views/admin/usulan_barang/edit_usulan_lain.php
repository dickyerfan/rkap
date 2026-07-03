<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('admin/usulan_barang/update_lain') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_usulanBarang" id="id_usulanBarang" value="<?= $usulan_lain->id_usulanBarang; ?>">
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
                                    <label for="nama_perkiraan">Nama Perkiraan :</label>
                                    <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $usulan_lain->nama_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">volume :</label>
                                    <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $usulan_lain->volume; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Total Biaya :</label>
                                    <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $usulan_lain->biaya; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <select class="form-control  select2" id="no_perkiraan" name="no_perkiraan">
                                        <option value="">-- Pilih No Perkiraan --</option>
                                        <?php foreach ($no_per as $row) : ?>
                                            <option value="<?= $row->kode; ?>" <?= ($usulan_lain->no_perkiraan == $row->kode) ? 'selected' : ''; ?>>
                                                <?= $row->kode; ?> - <?= $row->name ?? '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <select name="satuan" id="satuan" class="form-select">
                                        <option value="Meter" <?= $usulan_lain->satuan == "Meter" ? 'selected' : '' ?>>Meter</option>
                                        <option value="Unit" <?= $usulan_lain->satuan == "Unit" ? 'selected' : '' ?>>Unit</option>
                                        <option value="Ruangan" <?= $usulan_lain->satuan == "Ruangan" ? 'selected' : '' ?>>Ruangan</option>
                                        <option value="Buah" <?= $usulan_lain->satuan == "Buah" ? 'selected' : '' ?>>Buah</option>
                                        <option value="Pasang" <?= $usulan_lain->satuan == "Pasang" ? 'selected' : '' ?>>Pasang</option>
                                        <option value="Box" <?= $usulan_lain->satuan == "Box" ? 'selected' : '' ?>>Box</option>
                                        <option value="Botol" <?= $usulan_lain->satuan == "Botol" ? 'selected' : '' ?>>Botol</option>
                                        <option value="Lusin" <?= $usulan_lain->satuan == "Lusin" ? 'selected' : '' ?>>Lusin</option>
                                        <option value="Kg" <?= $usulan_lain->satuan == "Kg" ? 'selected' : '' ?>>Kg</option>
                                        <option value="M2" <?= $usulan_lain->satuan == "M2" ? 'selected' : '' ?>>M2</option>
                                        <option value="Rim" <?= $usulan_lain->satuan == "Rim" ? 'selected' : '' ?>>Rim</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <!-- <input type="text" class="form-control" id="ket" name="ket" value="<?= $usulan_lain->ket; ?>"> -->
                                    <textarea name="ket" id="ket" cols="30" rows="8" class="form-control"><?= $usulan_lain->ket; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
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