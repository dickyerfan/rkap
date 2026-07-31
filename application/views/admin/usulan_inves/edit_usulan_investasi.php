<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_inves') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('admin/usulan_inves/update') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_usulanInvestasi" id="id_usulanInvestasi" value="<?= $usulan_investasi->id_usulanInvestasi; ?>">
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
                                    <textarea name="latar_belakang" id="latar_belakang" cols="30" rows="8" class="form-control"><?= $usulan_investasi->latar_belakang; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('latar_belakang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">volume :</label>
                                    <input type="number" step="1" class="form-control" id="volume" name="volume" value="<?= $usulan_investasi->volume; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="bagian_upk">Bagian UPK:</label>
                                    <select name="bagian_upk" id="bagian_upk" class="form-select">
                                        <option value="">Pilih Bagian UPK</option>
                                        <option value="pusat" <?= $usulan_investasi->bagian_upk == "pusat" ? 'selected' : '' ?>>pusat</option>
                                        <option value="umum" <?= $usulan_investasi->bagian_upk == "umum" ? 'selected' : '' ?>>umum</option>
                                        <option value="keuangan" <?= $usulan_investasi->bagian_upk == "keuangan" ? 'selected' : '' ?>>keuangan</option>
                                        <option value="langganan" <?= $usulan_investasi->bagian_upk == "langganan" ? 'selected' : '' ?>>langganan</option>
                                        <option value="pemeliharaan" <?= $usulan_investasi->bagian_upk == "pemeliharaan" ? 'selected' : '' ?>>pemeliharaan</option>
                                        <option value="perencanaan" <?= $usulan_investasi->bagian_upk == "perencanaan" ? 'selected' : '' ?>>perencanaan</option>
                                        <option value="spi" <?= $usulan_investasi->bagian_upk == "spi" ? 'selected' : '' ?>>spi</option>
                                        <option value="bondowoso" <?= $usulan_investasi->bagian_upk == "bondowoso" ? 'selected' : '' ?>>bondowoso</option>
                                        <option value="sukosari1" <?= $usulan_investasi->bagian_upk == "sukosari1" ? 'selected' : '' ?>>sukosari1</option>
                                        <option value="maesan" <?= $usulan_investasi->bagian_upk == "maesan" ? 'selected' : '' ?>>maesan</option>
                                        <option value="tegalampel" <?= $usulan_investasi->bagian_upk == "tegalampel" ? 'selected' : '' ?>>tegalampel</option>
                                        <option value="tapen" <?= $usulan_investasi->bagian_upk == "tapen" ? 'selected' : '' ?>>tapen</option>
                                        <option value="prajekan" <?= $usulan_investasi->bagian_upk == "prajekan" ? 'selected' : '' ?>>prajekan</option>
                                        <option value="tlogosari" <?= $usulan_investasi->bagian_upk == "tlogosari" ? 'selected' : '' ?>>tlogosari</option>
                                        <option value="wringin" <?= $usulan_investasi->bagian_upk == "wringin" ? 'selected' : '' ?>>wringin</option>
                                        <option value="curahdami" <?= $usulan_investasi->bagian_upk == "curahdami" ? 'selected' : '' ?>>curahdami</option>
                                        <option value="tamanan" <?= $usulan_investasi->bagian_upk == "tamanan" ? 'selected' : '' ?>>tamanan</option>
                                        <option value="tenggarang" <?= $usulan_investasi->bagian_upk == "tenggarang" ? 'selected' : '' ?>>tenggarang</option>
                                        <option value="tamankrocok" <?= $usulan_investasi->bagian_upk == "tamankrocok" ? 'selected' : '' ?>>tamankrocok</option>
                                        <option value="wonosari" <?= $usulan_investasi->bagian_upk == "wonosari" ? 'selected' : '' ?>>wonosari</option>
                                        <option value="klabang" <?= $usulan_investasi->bagian_upk == "klabang" ? 'selected' : '' ?>>klabang</option>
                                        <option value="sukosari2" <?= $usulan_investasi->bagian_upk == "sukosari2" ? 'selected' : '' ?>>sukosari2</option>
                                        <option value="amdk" <?= $usulan_investasi->bagian_upk == "amdk" ? 'selected' : '' ?>>amdk</option>
                                        <!-- <?php
                                                $upk = $this->Model_usulan_inves->getUpk();
                                                foreach ($upk as $row) {
                                                    echo '<option value="' . $row->upk_bagian . '" ' . ($usulan_investasi->bagian_upk == $row->upk_bagian ? 'selected' : '') . '>' . $row->upk_bagian . '</option>';
                                                }
                                                ?> -->
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('bagian_upk'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="number" step="1" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= $usulan_investasi->no_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan'); ?></small>
                                </div> -->
                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <select class="form-control  select2" id="no_perkiraan" name="no_perkiraan">
                                        <option value="">-- Pilih No Perkiraan --</option>
                                        <?php foreach ($no_per as $row) : ?>
                                            <option value="<?= $row->kode; ?>" <?= ($usulan_investasi->no_perkiraan == $row->kode) ? 'selected' : ''; ?>>
                                                <?= $row->kode; ?> - <?= $row->name ?? '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="solusi">Solusi :</label>
                                    <textarea name="solusi" id="solusi" cols="30" rows="8" class="form-control"><?= $usulan_investasi->solusi; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('solusi'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <select name="satuan" id="satuan" class="form-select">
                                        <option value="Meter" <?= $usulan_investasi->satuan == "Meter" ? 'selected' : '' ?>>Meter</option>
                                        <option value="Unit" <?= $usulan_investasi->satuan == "Unit" ? 'selected' : '' ?>>Unit</option>
                                        <option value="Ruangan" <?= $usulan_investasi->satuan == "Ruangan" ? 'selected' : '' ?>>Ruangan</option>
                                        <option value="Buah" <?= $usulan_investasi->satuan == "Buah" ? 'selected' : '' ?>>Buah</option>
                                        <option value="Pasang" <?= $usulan_investasi->satuan == "Pasang" ? 'selected' : '' ?>>Pasang</option>
                                        <option value="Box" <?= $usulan_investasi->satuan == "Box" ? 'selected' : '' ?>>Box</option>
                                        <option value="Botol" <?= $usulan_investasi->satuan == "Botol" ? 'selected' : '' ?>>Botol</option>
                                        <option value="Lusin" <?= $usulan_investasi->satuan == "Lusin" ? 'selected' : '' ?>>Lusin</option>
                                        <option value="Kg" <?= $usulan_investasi->satuan == "Kg" ? 'selected' : '' ?>>Kg</option>
                                        <option value="M2" <?= $usulan_investasi->satuan == "M2" ? 'selected' : '' ?>>M2</option>
                                        <option value="Rim" <?= $usulan_investasi->satuan == "Rim" ? 'selected' : '' ?>>Rim</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="foto_ket">Foto Kegiatan :</label>
                                    <input type="file" class="form-control" id="foto_ket" name="foto_ket" value="<?= $usulan_investasi->foto_ket; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('foto_ket'); ?></small>
                                    <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama_perkiraan">Nama Perkiraan :</label>
                                    <input type="text" class="form-control" id="nama_perkiraan" name="nama_perkiraan" value="<?= $usulan_investasi->nama_perkiraan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_perkiraan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <textarea name="ket" id="ket" cols="30" rows="8" class="form-control"><?= $usulan_investasi->ket; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="biaya">Total Biaya :</label>
                                    <input type="number" step="1" class="form-control" id="biaya" name="biaya" value="<?= $usulan_investasi->biaya; ?>">
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