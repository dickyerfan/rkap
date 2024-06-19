<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/permasalahan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/permasalahan/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_permasalahan" id="id_permasalahan" value="<?= $permasalahan->id_permasalahan; ?>">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_bagian">Sub Bagian :</label>
                                    <select name="sub_bagian" id="sub_bagian" class="form-select select2">
                                        <option value="Langganan" <?= $permasalahan->sub_bagian == "Langganan" ? 'selected' : '' ?>>Langganan</option>
                                        <option value="Penagihan" <?= $permasalahan->sub_bagian == "Penagihan" ? 'selected' : '' ?>>Penagihan</option>
                                        <option value="Umum" <?= $permasalahan->sub_bagian == "Umum" ? 'selected' : '' ?>>Umum</option>
                                        <option value="Personalia" <?= $permasalahan->sub_bagian == "Personalia" ? 'selected' : '' ?>>Personalia</option>
                                        <option value="Administrasi" <?= $permasalahan->sub_bagian == "Administrasi" ? 'selected' : '' ?>>Administrasi</option>
                                        <option value="Kas" <?= $permasalahan->sub_bagian == "Kas" ? 'selected' : '' ?>>Kas</option>
                                        <option value="Pembukuan" <?= $permasalahan->sub_bagian == "Pembukuan" ? 'selected' : '' ?>>Pembukuan</option>
                                        <option value="Rekening" <?= $permasalahan->sub_bagian == "Rekening" ? 'selected' : '' ?>>Rekening</option>
                                        <option value="SPI" <?= $permasalahan->sub_bagian == "SPI" ? 'selected' : '' ?>>SPI</option>
                                        <option value="Perencanaan" <?= $permasalahan->sub_bagian == "Perencanaan" ? 'selected' : '' ?>>Perencanaan</option>
                                        <option value="Pengawasan" <?= $permasalahan->sub_bagian == "Pengawasan" ? 'selected' : '' ?>>Pengawasan</option>
                                        <option value="Pemeliharaan" <?= $permasalahan->sub_bagian == "Pemeliharaan" ? 'selected' : '' ?>>Pemeliharaan</option>
                                        <option value="Peralatan" <?= $permasalahan->sub_bagian == "Peralatan" ? 'selected' : '' ?>>Peralatan</option>
                                        <option value="Lain-lain" <?= $permasalahan->sub_bagian == "Lain-lain" ? 'selected' : '' ?>>Lain-lain</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('sub_bagian'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="permasalahan">Permasalahan :</label>
                                    <textarea name="permasalahan" id="permasalahan" cols="30" rows="8" class="form-control"><?= $permasalahan->permasalahan; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('permasalahan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="penyebab">Penyebab :</label>
                                    <textarea name="penyebab" id="penyebab" cols="30" rows="8" class="form-control"><?= $permasalahan->penyebab; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('penyebab'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tindak_lanjut">Tindak lanjut :</label>
                                    <textarea name="tindak_lanjut" id="tindak_lanjut" cols="30" rows="8" class="form-control"><?= $permasalahan->tindak_lanjut; ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('tindak_lanjut'); ?></small>
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