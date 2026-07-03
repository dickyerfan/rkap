<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav">
                            <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('admin/proyeksi_upk') ?>"><button class="float-end neumorphic-button"><i class="fa-solid fa-arrow-left"></i> Kembali</button></a>
                        </div>
                    </nav>
                </div>

                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>

                    <?php $error_validasi = $this->session->flashdata('error_validasi'); ?>
                    <?php if (!empty($error_validasi)) : ?>
                        <div class="alert alert-danger">
                            <strong>Data tidak tersimpan, periksa kembali isian:</strong>
                            <ul class="mb-0">
                                <?php foreach ($error_validasi as $err) : ?>
                                    <li><?= $err ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                $bulan = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];
                ?>
                <div class="card-body">
                    <form action="<?= base_url('admin/proyeksi_upk/upload') ?>" method="post">
                        <input type="hidden" name="tahun_rkap" value="<?= $tahun ?>">

                        <div class="row mb-2">
                            <div class="col-auto">
                                <label class="fw-bold">Tahun RKAP : <?= $tahun ?></label>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered text-center" style="font-size: 0.85rem;">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>SR Baru</th>
                                        <th>Penutupan</th>
                                        <th>Pencabutan</th>
                                        <th>Pembukaan</th>
                                        <th>Tera Meter</th>
                                        <th>Ganti Meter</th>
                                        <th>Efi. Penagihan (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bulan as $i => $nama_bulan) :
                                        $row = null;
                                        foreach ($tampil as $t) {
                                            if ($t->bulan == $i) {
                                                $row = $t;
                                                break;
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td class="fw-bold"><?= $nama_bulan ?></td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="sr_baru[<?= $i ?>]" value="<?= $row->sr_baru ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="penutupan[<?= $i ?>]" value="<?= $row->penutupan ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="pencabutan[<?= $i ?>]" value="<?= $row->pencabutan ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="pembukaan[<?= $i ?>]" value="<?= $row->pembukaan ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="tera_meter[<?= $i ?>]" value="<?= $row->tera_meter ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" name="ganti_meter[<?= $i ?>]" value="<?= $row->ganti_meter ?? 0 ?>">
                                            </td>
                                            <td>
                                                <input type="number" step="0.1" class="form-control form-control-sm" name="efi_tagih[<?= $i ?>]" value="<?= $row->efi_tagih ?? 0 ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="neumorphic-button">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                        <a href="<?= base_url('admin/proyeksi_upk') ?>"><button type="button" class="neumorphic-button">Batal</button></a>
                    </form>
                </div>
            </div>
        </div>
    </main>