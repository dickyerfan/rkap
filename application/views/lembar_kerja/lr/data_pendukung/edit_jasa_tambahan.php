<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/data_pendukung') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('lembar_kerja/lr/data_pendukung/update_jasa_tambahan') ?>">
                        <input type="hidden" name="id" value="<?= $row->id ?>">
                        <input type="hidden" name="tahun" value="<?= $row->tahun ?>">

                        <!-- UPK -->
                        <div class="mb-3">
                            <label class="form-label">UPK</label>
                            <input type="text" class="form-control" value="<?php
                                                                            foreach ($list_upk as $upk) {
                                                                                if ($upk->id_upk == $row->id_upk) {
                                                                                    echo $upk->nama_upk;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            ?>" readonly>
                            <input type="hidden" name="id_upk" value="<?= $row->id_upk ?>">
                        </div>

                        <!-- Jenis Pelanggan -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Pelanggan / Jasa</label>
                            <input type="text" class="form-control" value="<?php
                                                                            foreach ($list_jp as $jp) {
                                                                                if ($jp->id_jp == $row->id_jp) {
                                                                                    echo $jp->nama_jp;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            ?>" readonly>
                            <input type="hidden" name="id_jp" value="<?= $row->id_jp ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jasa Administrasi</label>
                            <input type="number" step="1" name="jasa_admin" class="form-control" value="<?= number_format($row->jasa_admin, 0, '', '') ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jasa Pemeliharaan</label>
                            <input type="number" step="1" name="jasa_pemeliharaan" class="form-control" value="<?= number_format($row->jasa_pemeliharaan, 0, '', '') ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= site_url('lembar_kerja/lr/data_pendukung?tahun_rkap=' . $row->tahun) ?>" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>