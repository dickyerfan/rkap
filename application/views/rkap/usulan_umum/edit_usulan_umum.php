<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/usulan_umum') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/usulan_umum/update') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_usulanUmum" id="id_usulanUmum" value="<?= $usulan_umum->id_usulanUmum; ?>">
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
                                    <textarea name="latar_belakang" id="latar_belakang" cols="30" rows="8" class="form-control"><?= $usulan_umum->latar_belakang; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('latar_belakang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">volume :</label>
                                    <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $usulan_umum->volume; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">Kategori :</label>
                                    <select name="kategori" id="" class="form-select">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Umum" <?= $usulan_umum->kategori == 'Umum' ? 'selected' : '' ?>>Umum</option>
                                        <option value="Personalia" <?= $usulan_umum->kategori == 'Personalia' ? 'selected' : '' ?>>Personalia</option>
                                        <option value="Administrasi" <?= $usulan_umum->kategori == 'Administrasi' ? 'selected' : '' ?>>Administrasi</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kategori'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="number" step="1" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= $usulan_umum->no_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                </div>

                                <div class="form-group">
                                    <label for="solusi">Solusi :</label>
                                    <textarea name="solusi" id="solusi" cols="30" rows="8" class="form-control"><?= $usulan_umum->solusi; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('solusi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <select name="satuan" id="satuan" class="form-select">
                                        <option value="Meter" <?= $usulan_umum->satuan == "Meter" ? 'selected' : '' ?>>Meter</option>
                                        <option value="Unit" <?= $usulan_umum->satuan == "Unit" ? 'selected' : '' ?>>Unit</option>
                                        <option value="Ruangan" <?= $usulan_umum->satuan == "Ruangan" ? 'selected' : '' ?>>Ruangan</option>
                                        <option value="Buah" <?= $usulan_umum->satuan == "Buah" ? 'selected' : '' ?>>Buah</option>
                                        <option value="Pasang" <?= $usulan_umum->satuan == "Pasang" ? 'selected' : '' ?>>Pasang</option>
                                        <option value="Box" <?= $usulan_umum->satuan == "Box" ? 'selected' : '' ?>>Box</option>
                                        <option value="Botol" <?= $usulan_umum->satuan == "Botol" ? 'selected' : '' ?>>Botol</option>
                                        <option value="Lusin" <?= $usulan_umum->satuan == "Lusin" ? 'selected' : '' ?>>Lusin</option>
                                        <option value="Kg" <?= $usulan_umum->satuan == "Kg" ? 'selected' : '' ?>>Kg</option>
                                        <option value="M2" <?= $usulan_umum->satuan == "M2" ? 'selected' : '' ?>>M2</option>
                                        <option value="Rim" <?= $usulan_umum->satuan == "Rim" ? 'selected' : '' ?>>Rim</option>
                                        <option value="Set" <?= $usulan_umum->satuan == "Set" ? 'selected' : '' ?>>Set</option>
                                        <option value="Ls" <?= $usulan_umum->satuan == "Ls" ? 'selected' : '' ?>>Ls</option>
                                        <option value="Orang" <?= $usulan_umum->satuan == "Orang" ? 'selected' : '' ?>>Orang</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="foto_ket">Foto Kegiatan :</label>
                                    <input type="file" class="form-control" id="foto_ket" name="foto_ket" value="<?= $usulan_umum->foto_ket; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('foto_ket'); ?></small>
                                    <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_perkiraan">Nama Perkiraan :</label>
                                    <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $usulan_umum->nama_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <textarea name="ket" id="ket" cols="30" rows="8" class="form-control"><?= $usulan_umum->ket; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Biaya :</label>
                                    <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $usulan_umum->biaya; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('biaya'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="bagian_upk">Bagian UPK:</label>
                                    <select name="bagian_upk" id="bagian_upk" class="form-select">
                                        <option value="">Pilih Bagian UPK</option>
                                        <option value="pusat" <?= $usulan_umum->bagian_upk == "pusat" ? 'selected' : '' ?>>pusat</option>
                                        <option value="bondowoso" <?= $usulan_umum->bagian_upk == "bondowoso" ? 'selected' : '' ?>>bondowoso</option>
                                        <option value="sukosari1" <?= $usulan_umum->bagian_upk == "sukosari1" ? 'selected' : '' ?>>sukosari1</option>
                                        <option value="maesan" <?= $usulan_umum->bagian_upk == "maesan" ? 'selected' : '' ?>>maesan</option>
                                        <option value="tegalampel" <?= $usulan_umum->bagian_upk == "tegalampel" ? 'selected' : '' ?>>tegalampel</option>
                                        <option value="tapen" <?= $usulan_umum->bagian_upk == "tapen" ? 'selected' : '' ?>>tapen</option>
                                        <option value="prajekan" <?= $usulan_umum->bagian_upk == "prajekan" ? 'selected' : '' ?>>prajekan</option>
                                        <option value="tlogosari" <?= $usulan_umum->bagian_upk == "tlogosari" ? 'selected' : '' ?>>tlogosari</option>
                                        <option value="wringin" <?= $usulan_umum->bagian_upk == "wringin" ? 'selected' : '' ?>>wringin</option>
                                        <option value="curahdami" <?= $usulan_umum->bagian_upk == "curahdami" ? 'selected' : '' ?>>curahdami</option>
                                        <option value="tamanan" <?= $usulan_umum->bagian_upk == "tamanan" ? 'selected' : '' ?>>tamanan</option>
                                        <option value="tenggarang" <?= $usulan_umum->bagian_upk == "tenggarang" ? 'selected' : '' ?>>tenggarang</option>
                                        <option value="tamankrocok" <?= $usulan_umum->bagian_upk == "tamankrocok" ? 'selected' : '' ?>>tamankrocok</option>
                                        <option value="wonosari" <?= $usulan_umum->bagian_upk == "wonosari" ? 'selected' : '' ?>>wonosari</option>
                                        <option value="klabang" <?= $usulan_umum->bagian_upk == "klabang" ? 'selected' : '' ?>>klabang</option>
                                        <option value="sukosari2" <?= $usulan_umum->bagian_upk == "sukosari2" ? 'selected' : '' ?>>sukosari2</option>
                                        <option value="amdk" <?= $usulan_umum->bagian_upk == "amdk" ? 'selected' : '' ?>>amdk</option>
                                        <!-- <?php
                                                $upk = $this->Model_usulan_umum->getUpk();
                                                foreach ($upk as $row) {
                                                    echo '<option value="' . $row->upk_bagian . '" ' . ($usulan_umum->bagian_upk == $row->upk_bagian ? 'selected' : '') . '>' . $row->upk_bagian . '</option>';
                                                }
                                                ?> -->
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('bagian_upk'); ?></small>
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