<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_pemeliharaan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('admin/usulan_pemeliharaan/update') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_usulanPemeliharaan" id="id_usulanPemeliharaan" value="<?= $usulan_pemeliharaan->id_usulanPemeliharaan; ?>">
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
                                    <textarea name="latar_belakang" id="latar_belakang" cols="30" rows="8" class="form-control"><?= $usulan_pemeliharaan->latar_belakang; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('latar_belakang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">volume :</label>
                                    <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $usulan_pemeliharaan->volume; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="bagian_upk">Bagian UPK:</label>
                                    <select name="bagian_upk" id="bagian_upk" class="form-select">
                                        <option value="">Pilih Bagian UPK</option>
                                        <option value="pusat" <?= $usulan_pemeliharaan->bagian_upk == "pusat" ? 'selected' : '' ?>>pusat</option>
                                        <option value="umum" <?= $usulan_pemeliharaan->bagian_upk == "umum" ? 'selected' : '' ?>>umum</option>
                                        <option value="keuangan" <?= $usulan_pemeliharaan->bagian_upk == "keuangan" ? 'selected' : '' ?>>keuangan</option>
                                        <option value="langganan" <?= $usulan_pemeliharaan->bagian_upk == "langganan" ? 'selected' : '' ?>>langganan</option>
                                        <option value="pemeliharaan" <?= $usulan_pemeliharaan->bagian_upk == "pemeliharaan" ? 'selected' : '' ?>>pemeliharaan</option>
                                        <option value="perencanaan" <?= $usulan_pemeliharaan->bagian_upk == "perencanaan" ? 'selected' : '' ?>>perencanaan</option>
                                        <option value="spi" <?= $usulan_pemeliharaan->bagian_upk == "spi" ? 'selected' : '' ?>>spi</option>
                                        <option value="bondowoso" <?= $usulan_pemeliharaan->bagian_upk == "bondowoso" ? 'selected' : '' ?>>bondowoso</option>
                                        <option value="sukosari1" <?= $usulan_pemeliharaan->bagian_upk == "sukosari1" ? 'selected' : '' ?>>sukosari1</option>
                                        <option value="maesan" <?= $usulan_pemeliharaan->bagian_upk == "maesan" ? 'selected' : '' ?>>maesan</option>
                                        <option value="tegalampel" <?= $usulan_pemeliharaan->bagian_upk == "tegalampel" ? 'selected' : '' ?>>tegalampel</option>
                                        <option value="tapen" <?= $usulan_pemeliharaan->bagian_upk == "tapen" ? 'selected' : '' ?>>tapen</option>
                                        <option value="prajekan" <?= $usulan_pemeliharaan->bagian_upk == "prajekan" ? 'selected' : '' ?>>prajekan</option>
                                        <option value="tlogosari" <?= $usulan_pemeliharaan->bagian_upk == "tlogosari" ? 'selected' : '' ?>>tlogosari</option>
                                        <option value="wringin" <?= $usulan_pemeliharaan->bagian_upk == "wringin" ? 'selected' : '' ?>>wringin</option>
                                        <option value="curahdami" <?= $usulan_pemeliharaan->bagian_upk == "curahdami" ? 'selected' : '' ?>>curahdami</option>
                                        <option value="tamanan" <?= $usulan_pemeliharaan->bagian_upk == "tamanan" ? 'selected' : '' ?>>tamanan</option>
                                        <option value="tenggarang" <?= $usulan_pemeliharaan->bagian_upk == "tenggarang" ? 'selected' : '' ?>>tenggarang</option>
                                        <option value="tamankrocok" <?= $usulan_pemeliharaan->bagian_upk == "tamankrocok" ? 'selected' : '' ?>>tamankrocok</option>
                                        <option value="wonosari" <?= $usulan_pemeliharaan->bagian_upk == "wonosari" ? 'selected' : '' ?>>wonosari</option>
                                        <option value="klabang" <?= $usulan_pemeliharaan->bagian_upk == "klabang" ? 'selected' : '' ?>>klabang</option>
                                        <option value="sukosari2" <?= $usulan_pemeliharaan->bagian_upk == "sukosari2" ? 'selected' : '' ?>>sukosari2</option>
                                        <option value="amdk" <?= $usulan_pemeliharaan->bagian_upk == "amdk" ? 'selected' : '' ?>>amdk</option>
                                        <!-- <?php
                                                $upk = $this->Model_usulan_pemeliharaan->getUpk();
                                                foreach ($upk as $row) {
                                                    echo '<option value="' . $row->upk_bagian . '" ' . ($usulan_pemeliharaan->bagian_upk == $row->upk_bagian ? 'selected' : '') . '>' . $row->upk_bagian . '</option>';
                                                }
                                                ?> -->
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('bagian_upk'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="number" step="1" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= $usulan_pemeliharaan->no_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                </div> -->

                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <select class="form-control  select2" id="no_perkiraan" name="no_perkiraan">
                                        <option value="">-- Pilih No Perkiraan --</option>
                                        <?php foreach ($no_per as $row) : ?>
                                            <option value="<?= $row->kode; ?>" <?= ($usulan_pemeliharaan->no_perkiraan == $row->kode) ? 'selected' : ''; ?>>
                                                <?= $row->kode; ?> - <?= $row->name ?? '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                <div class="form-group">
                                    <label for="solusi">Solusi :</label>
                                    <textarea name="solusi" id="solusi" cols="30" rows="8" class="form-control"><?= $usulan_pemeliharaan->solusi; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('solusi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <!-- <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $usulan_pemeliharaan->satuan; ?>"> -->
                                    <select name="satuan" id="satuan" class="form-select">
                                        <option value="Meter" <?= $usulan_pemeliharaan->satuan == "Meter" ? 'selected' : '' ?>>Meter</option>
                                        <option value="Unit" <?= $usulan_pemeliharaan->satuan == "Unit" ? 'selected' : '' ?>>Unit</option>
                                        <option value="Ruangan" <?= $usulan_pemeliharaan->satuan == "Ruangan" ? 'selected' : '' ?>>Ruangan</option>
                                        <option value="Buah" <?= $usulan_pemeliharaan->satuan == "Buah" ? 'selected' : '' ?>>Buah</option>
                                        <option value="Pasang" <?= $usulan_pemeliharaan->satuan == "Pasang" ? 'selected' : '' ?>>Pasang</option>
                                        <option value="Box" <?= $usulan_pemeliharaan->satuan == "Box" ? 'selected' : '' ?>>Box</option>
                                        <option value="Botol" <?= $usulan_pemeliharaan->satuan == "Botol" ? 'selected' : '' ?>>Botol</option>
                                        <option value="Lusin" <?= $usulan_pemeliharaan->satuan == "Lusin" ? 'selected' : '' ?>>Lusin</option>
                                        <option value="Kg" <?= $usulan_pemeliharaan->satuan == "Kg" ? 'selected' : '' ?>>Kg</option>
                                        <option value="M2" <?= $usulan_pemeliharaan->satuan == "M2" ? 'selected' : '' ?>>M2</option>
                                        <option value="Rim" <?= $usulan_pemeliharaan->satuan == "Rim" ? 'selected' : '' ?>>Rim</option>
                                        <option value="Set" <?= $usulan_pemeliharaan->satuan == "Set" ? 'selected' : '' ?>>Set</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="foto_ket">Foto Kegiatan :</label>
                                    <input type="file" class="form-control" id="foto_ket" name="foto_ket" value="<?= $usulan_pemeliharaan->foto_ket; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('foto_ket'); ?></small>
                                    <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_perkiraan">Nama Perkiraan :</label>
                                    <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $usulan_pemeliharaan->nama_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <textarea name="ket" id="ket" cols="30" rows="8" class="form-control"><?= $usulan_pemeliharaan->ket; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Total Biaya :</label>
                                    <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $usulan_pemeliharaan->biaya; ?>">
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