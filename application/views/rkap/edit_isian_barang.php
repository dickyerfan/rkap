<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/isian_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <?php if ($isian_barang) : ?>
                        <form class="user" action="<?= base_url('rkap/isian_barang/update') ?>" method="POST">
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <input type="hidden" name="id_usulanBarang" id="id_usulanBarang" value="<?= $isian_barang->id_usulanBarang ?? '' ?>">
                                    <div class="form-group">
                                        <label for="tahun_rkap">Tahun Pembuatan RKAP :</label>
                                        <select name="tahun_rkap" class="form-select" disabled>
                                            <?php
                                            $mulai = date('Y') - 2;
                                            for ($i = $mulai; $i < $mulai + 11; $i++) {
                                                $sel = ($isian_barang->tahun_rkap ?? date('Y')) == $i ? ' selected="selected"' : '';
                                                echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="latar_belakang">Latar Belakang :</label>
                                        <textarea name="latar_belakang" id="latar_belakang" cols="30" rows="8" class="form-control" disabled><?= $isian_barang->latar_belakang ?? '' ?></textarea>
                                        <small class="form-text text-danger pl-3"><?= form_error('latar_belakang'); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="volume">Volume :</label>
                                        <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $isian_barang->volume ?? '' ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="kategori">Kategori :</label>
                                        <select name="kategori" id="" class="form-select">
                                            <option value="">Pilih Kategori</option>
                                            <option value="ATK" <?= (isset($isian_barang->kategori) && $isian_barang->kategori == 'ATK') ? 'selected' : '' ?>>ATK</option>
                                            <option value="Inventaris" <?= (isset($isian_barang->kategori) && $isian_barang->kategori == 'Inventaris') ? 'selected' : '' ?>>Inventaris</option>
                                            <option value="Peralatan Teknik" <?= (isset($isian_barang->kategori) && $isian_barang->kategori == 'Peralatan Teknik') ? 'selected' : '' ?>>Peralatan Teknik</option>
                                            <option value="Lainnya" <?= (isset($isian_barang->kategori) && $isian_barang->kategori == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('kategori'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="no_perkiraan">No Perkiraan :</label>
                                        <input type="number" step="1" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= $isian_barang->no_perkiraan ?? '' ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="solusi">Solusi :</label>
                                        <textarea name="solusi" id="solusi" cols="30" rows="8" class="form-control" disabled><?= $isian_barang->solusi ?? '' ?></textarea>
                                        <small class="form-text text-danger pl-3"><?= form_error('solusi'); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="satuan">Satuan :</label>
                                        <select name="satuan" id="satuan" class="form-select">
                                            <option value="Meter" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Meter") ? 'selected' : '' ?>>Meter</option>
                                            <option value="Unit" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Unit") ? 'selected' : '' ?>>Unit</option>
                                            <option value="Ruangan" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Ruangan") ? 'selected' : '' ?>>Ruangan</option>
                                            <option value="Buah" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Buah") ? 'selected' : '' ?>>Buah</option>
                                            <option value="Pasang" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Pasang") ? 'selected' : '' ?>>Pasang</option>
                                            <option value="Box" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Box") ? 'selected' : '' ?>>Box</option>
                                            <option value="Botol" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Botol") ? 'selected' : '' ?>>Botol</option>
                                            <option value="Lusin" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Lusin") ? 'selected' : '' ?>>Lusin</option>
                                            <option value="Kg" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Kg") ? 'selected' : '' ?>>Kg</option>
                                            <option value="M2" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "M2") ? 'selected' : '' ?>>M2</option>
                                            <option value="Rim" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Rim") ? 'selected' : '' ?>>Rim</option>
                                            <option value="Set" <?= (isset($isian_barang->satuan) && $isian_barang->satuan == "Set") ? 'selected' : '' ?>>Set</option>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nama_perkiraan">Nama Barang :</label>
                                        <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $isian_barang->nama_perkiraan ?? '' ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="ket">Keterangan :</label>
                                        <textarea name="ket" id="ket" cols="30" rows="8" class="form-control" disabled><?= $isian_barang->ket ?? '' ?></textarea>
                                        <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="biaya">Biaya :</label>
                                        <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $isian_barang->biaya ?? '' ?>">
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
                    <?php else : ?>
                        <div class="alert alert-warning text-center">Data tidak ditemukan untuk tahun dan id yang dipilih.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>