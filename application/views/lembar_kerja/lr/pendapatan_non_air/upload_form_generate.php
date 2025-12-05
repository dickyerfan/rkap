<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pendapatan_non_air') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="<?= site_url('lembar_kerja/lr/pendapatan_non_air/proses_generate') ?>" method="post" class="form-inline">
                                <div class="form-group mr-3">
                                    <label class="mr-2">Pilih UPK :</label>
                                    <select name="id_upk" class="form-control mr-3" required>
                                        <option value="">-- Pilih UPK --</option>
                                        <?php foreach ($list_upk as $upk) : ?>
                                            <option value="<?= $upk->id_upk ?>"><?= strtoupper($upk->nama_upk) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- <div class="form-group mr-3">
                                    <label class="mr-2">Tahun RKAP:</label>
                                    <select name="tahun" class="form-control mr-3" required>
                                        <?php
                                        $currentYear = date('Y');
                                        for ($year = 2024; $year <= $currentYear + 20; $year++) : ?>
                                            <option value="<?= $year ?>" <?= $year == $currentYear ? 'selected' : '' ?>><?= $year ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div> -->
                                <div class="form-group mr-3">
                                    <input type="hidden" name="tahun" value="<?= date('Y') + 1 ?>">
                                    <label class="mr-2">Tahun RKAP:</label>
                                    <!-- <select name="tahun" class="form-control mr-3" required>
                                        <?php
                                        // Menghitung tahun depan
                                        $nextYear = date('Y') + 1;
                                        ?>
                                        <option value="<?= $nextYear ?>" selected><?= $nextYear ?></option>
                                    </select> -->
                                    <input type="text" class="form-control" value="<?= date('Y') + 1 ?>" readonly>
                                </div>
                                <div class="form-group mr-3">
                                    <label class="mr-2">Bulan :</label>
                                    <select name="bulan" class="form-control mr-3" required>
                                        <option value="">-- Pilih Bulan --</option>
                                        <?php
                                        $bulanArr = [
                                            1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
                                            5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
                                            9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
                                        ];
                                        foreach ($bulanArr as $num => $nama) : ?>
                                            <!-- <option value="<?= $num ?>" <?= $num == date('n') ? 'selected' : '' ?>><?= $nama ?></option> -->

                                            <option value="<?= $num ?>"><?= $nama ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Tombol -->
                                <button type="submit" class="neumorphic-button mt-2">Generate</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>