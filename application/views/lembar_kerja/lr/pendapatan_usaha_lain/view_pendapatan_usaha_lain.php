<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                // Buat range tahun dari 10 tahun lalu sampai tahun sekarang
                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                // Jika ada data tahun di depan tahun sekarang (misal user pilih tahun depan) ikut dimasukkan
                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Data</button> </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No Per</th>
                                            <th class="text-center">URAIAN</th>
                                            <th class="text-center">Jan</th>
                                            <th class="text-center">Feb</th>
                                            <th class="text-center">Mar</th>
                                            <th class="text-center">Apr</th>
                                            <th class="text-center">Mei</th>
                                            <th class="text-center">Jun</th>
                                            <th class="text-center">Jul</th>
                                            <th class="text-center">Agu</th>
                                            <th class="text-center">Sep</th>
                                            <th class="text-center">Okt</th>
                                            <th class="text-center">Nov</th>
                                            <th class="text-center">Des</th>
                                            <th class="text-center">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Subsidi Tarif Air -->
                                        <?php if (!empty($subsidi)) : ?>
                                            <tr class="table-secondary">
                                                <td></td>
                                                <td colspan="14"><b>Subsidi Selisih Tarif</b></td>
                                            </tr>
                                            <?php
                                            // inisialisasi subtotal
                                            $subsidi_total_bulan = array_fill(1, 12, 0);
                                            $subsidi_total = 0;
                                            ?>
                                            <?php foreach ($subsidi as $row) : ?>
                                                <tr>
                                                    <td><?= $row['kode'] ?></td>
                                                    <td>&nbsp;&nbsp;<?= $row['name'] ?></td>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) :
                                                        $nilai = $row['bulan'][$i] ?? 0;
                                                        $subsidi_total_bulan[$i] += $nilai;
                                                    ?>
                                                        <td class="text-end"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                                </tr>
                                                <?php $subsidi_total += $row['jumlah']; ?>
                                            <?php endforeach; ?>
                                            <!-- subtotal subsidi -->
                                            <tr class="table-warning fw-bold">
                                                <td></td>
                                                <td>&nbsp;&nbsp;Jumlah Subsidi Selisih Tarif</td>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($subsidi_total_bulan[$i], 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($subsidi_total, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <!-- Jasa Penagihan Rekening/IT -->
                                        <?php if (!empty($penagihan)) : ?>
                                            <tr class="table-secondary">
                                                <td></td>
                                                <td colspan="14"><b>Jasa Penagihan Rekening/IT</b></td>
                                            </tr>
                                            <?php
                                            $penagihan_total_bulan = array_fill(1, 12, 0);
                                            $penagihan_total = 0;
                                            ?>
                                            <?php foreach ($penagihan as $row) : ?>
                                                <tr>
                                                    <td><?= $row['kode'] ?></td>
                                                    <td>&nbsp;&nbsp;<?= $row['name'] ?></td>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) :
                                                        $nilai = $row['bulan'][$i] ?? 0;
                                                        $penagihan_total_bulan[$i] += $nilai;
                                                    ?>
                                                        <td class="text-end"><?= $nilai ? number_format($nilai, 0, ',', '.') : '-' ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                                                </tr>
                                                <?php $penagihan_total += $row['jumlah']; ?>
                                            <?php endforeach; ?>
                                            <!-- subtotal penagihan -->
                                            <tr class="table-warning fw-bold">
                                                <td></td>
                                                <td>&nbsp;&nbsp;Jumlah Jasa Penagihan</td>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($penagihan_total_bulan[$i], 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($penagihan_total, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <!-- Grand Total -->
                                        <?php if (!empty($subsidi) || !empty($penagihan)) : ?>
                                            <?php
                                            $grand_bulan = [];
                                            for ($i = 1; $i <= 12; $i++) {
                                                $grand_bulan[$i] = ($subsidi_total_bulan[$i] ?? 0) + ($penagihan_total_bulan[$i] ?? 0);
                                            }
                                            $grand_total = ($subsidi_total ?? 0) + ($penagihan_total ?? 0);
                                            ?>
                                            <tr class="table-success fw-bold">
                                                <td></td>
                                                <td>&nbsp;&nbsp;Jumlah Pendapatan Usaha Lain</td>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($grand_bulan[$i], 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                            </tr>
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