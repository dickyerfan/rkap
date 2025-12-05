<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?= site_url('lembar_kerja/lr/pendapatan_luar_usaha/save') ?>" method="post">
                                <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                <input type="hidden" name="cabang_id" value="<?= $cabang_id ?>">
                                <input type="text" class="form-control" value="<?= $tahun ?>" readonly>
                                <div class="mb-3">
                                    <label for="kode">Kode Perkiraan</label>
                                    <select name="kode" id="kode" class="form-control" required>
                                        <option value="">-- Pilih Kode --</option>
                                        <?php foreach ($no_per_list as $np) : ?>
                                            <option value="<?= $np['kode'] ?>">
                                                <?= $np['kode'] ?> - <?= $np['name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Bulan</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $bulan_list = [
                                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                        ];
                                        foreach ($bulan_list as $i => $bln) : ?>
                                            <tr>
                                                <td><?= $bln ?></td>
                                                <td class="text-center">
                                                    <input type="text" name="bulan_<?= $i ?>" value="" style="width:250px; text-align:right;">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- Tombol -->
                                <button type="submit" class="neumorphic-button mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>