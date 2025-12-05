<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <!-- <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('rkap_admin') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap  ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('rkap_admin') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                    </nav>
                </div> -->
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <!-- <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5 class="text-center fw-bold"><?= $title; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <form method="post" action="<?= base_url('rkap_admin/update'); ?>">
                                    <label for="tahun">Tahun:</label>
                                    <input type="number" name="tahun" value="<?= date('Y') + 1; ?>" class="form-control" style="width:150px;" required>

                                    <label for="status_periode">Status:</label>
                                    <select name="status_periode" class="form-control" style="width:200px;" required>
                                        <option value="dibuka_pengguna">Dibuka untuk Pengguna</option>
                                        <option value="dibuka_admin">Dibuka untuk Admin</option>
                                        <option value="ditutup">Ditutup Semua</option>
                                    </select>

                                    <button type="submit" class="neumorphic-button mt-2">Simpan</button>
                                </form>

                                <hr>
                                <h5>Riwayat Status</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Tahun</th>
                                        <th>Status</th>
                                        <th>Diperbarui Oleh</th>
                                        <th>Terakhir Diubah</th>
                                    </tr>
                                    <?php foreach ($status as $row) : ?>
                                        <tr>
                                            <td><?= $row['tahun']; ?></td>
                                            <td><?= $row['status_periode']; ?></td>
                                            <td><?= $row['updated_by']; ?></td>
                                            <td><?= $row['updated_at']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="card-body">
                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-12 text-center">
                            <h4 class="text-center fw-bold"><?= $title; ?></h4>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-10">
                            <h5 class="text-primary fw-bold">PENGATURAN PERIODE AKTIF</h5>
                            <hr class="mt-0">
                            <form method="post" action="<?= base_url('rkap_admin/update'); ?>">
                                <div class="row g-3 align-items-end" style="font-size: 1.5rem;">
                                    <div class="col-md-4">
                                        <label for="tahun" class="form-label">Tahun:</label>
                                        <input type="number" name="tahun" id="tahun" value="<?= date('Y') + 1; ?>" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="status_periode" class="form-label">Status:</label>
                                        <select name="status_periode" id="status_periode" class="form-select" required>
                                            <option value="ditutup">Ditutup Semua</option>
                                            <option value="dibuka_admin">Dibuka untuk Admin</option>
                                            <option value="dibuka_pengguna">Dibuka untuk Pengguna</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-save me-1"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <h5 class="fw-bold"><i class="fas fa-history me-2"></i> Riwayat Status</h5>
                            <hr class="mb-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" style="font-size: 1.5rem;">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                            <th scope="col">Tahun</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Diperbarui Oleh</th>
                                            <th scope="col">Terakhir Diubah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($status)) : ?>
                                            <tr>
                                                <td colspan="4" class="text-center fst-italic">
                                                    Belum ada riwayat data.
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($status as $row) : ?>
                                                <tr class="align-middle text-center">
                                                    <td><strong><?= $row['tahun']; ?></strong></td>
                                                    <td>
                                                        <?php
                                                        // Logika untuk Badge Status
                                                        $status_text = $row['status_periode'];
                                                        $badge_class = 'bg-secondary'; // Default
                                                        $text_display = 'Tidak Dikenal';

                                                        if ($status_text == 'dibuka_pengguna') {
                                                            $badge_class = 'bg-success';
                                                            $text_display = 'Dibuka (Pengguna)';
                                                        } elseif ($status_text == 'dibuka_admin') {
                                                            $badge_class = 'bg-warning text-dark';
                                                            $text_display = 'Dibuka (Admin)';
                                                        } elseif ($status_text == 'ditutup') {
                                                            $badge_class = 'bg-danger';
                                                            $text_display = 'Ditutup Semua';
                                                        }
                                                        ?>
                                                        <span class="badge <?= $badge_class; ?>"><?= $text_display; ?></span>
                                                    </td>
                                                    <td><?= $row['updated_by']; ?></td>
                                                    <td><?= $row['updated_at']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>