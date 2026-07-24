<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/lr/pendapatan_air/tangki_air') ?>" method="get" id="formFilter">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="no_per_id"><strong>Kode Perkiraan</strong></label>
                                <select name="no_per_id" id="no_per_id" class="form-control" required onchange="document.getElementById('formFilter').submit();">
                                    <option value="">-- Pilih Kode Perkiraan --</option>
                                    <?php foreach ($no_per_list as $np) : ?>
                                        <option value="<?= $np['kode'] ?>" <?= $selected_no_per == $np['kode'] ? 'selected' : '' ?>>
                                            <?= $np['kode'] ?> - <?= $np['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <?php if ($selected_no_per) : ?>
                        <form action="<?= site_url('lembar_kerja/lr/pendapatan_air/save') ?>" method="post">
                            <input type="hidden" name="tahun" value="<?= $tahun ?>">
                            <input type="hidden" name="no_per_id" value="<?= $selected_no_per ?>">

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.8rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center" style="width: 200px;">URAIAN</th>
                                            <?php
                                            $nama_bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                            foreach ($nama_bulan as $nb) :
                                            ?>
                                                <th class="text-center"><?= $nb ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Jumlah Penggunaan rata2</strong></td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td>
                                                    <input type="number" step="0.01" name="penggunaan_rata2[<?= $i ?>]"
                                                        class="form-control form-control-sm text-end"
                                                        value="<?= isset($tangki_air_existing[$i]) ? $tangki_air_existing[$i]->penggunaan_rata2 : 0 ?>">
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah M3 rata2</strong></td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td>
                                                    <input type="number" step="0.01" name="m3_rata2[<?= $i ?>]"
                                                        class="form-control form-control-sm text-end"
                                                        value="<?= isset($tangki_air_existing[$i]) ? $tangki_air_existing[$i]->m3_rata2 : 0 ?>">
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr>
                                            <td><strong>Tarif rata2</strong></td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td>
                                                    <input type="number" step="0.01" name="tarif_rata2[<?= $i ?>]"
                                                        class="form-control form-control-sm text-end"
                                                        value="<?= isset($tangki_air_existing[$i]) ? $tangki_air_existing[$i]->tarif_rata2 : 0 ?>">
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="neumorphic-button mt-2">
                                <i class="fas fa-save"></i> Simpan Semua Bulan
                            </button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </main>
