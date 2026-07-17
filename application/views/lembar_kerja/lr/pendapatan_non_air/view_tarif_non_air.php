<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/tarif_non_air') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun) ? (int)$tahun : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/tarif_non_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-auto">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/tarif_non_air/duplicate_next_year?tahun_asal=' . ($tahun - 1)) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" onclick="return confirm('Yakin ingin menduplikasi data tahun <?= $tahun - 1 ?> ke <?= $tahun ?> ?')"> Duplicate <?= $tahun - 1 ?> → <?= $tahun ?></button> </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_non_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5>Data Tarif Pendapatan Non Air Tahun <?= $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Jenis Pendapatan</th>
                                            <th class="text-center">Parameter</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $ket = [
                                            'tarif_promo' => 'Tarif Sambungan Baru (Bulan Promo)',
                                            'tarif_normal' => 'Tarif Sambungan Baru (Bulan Normal)',
                                            'bulan_promo' => 'Bulan Promo (pisah koma)',
                                            'biaya_pendaftaran' => 'Biaya Pendaftaran per Sambungan',
                                            'persen_balik_nama' => 'Persentase Pelanggan Balik Nama',
                                            'nilai_balik_nama' => 'Biaya Balik Nama per Pelanggan',
                                            'biaya_psk' => 'Biaya Penyambungan Kembali per Pelanggan',
                                            'persen_telat' => 'Persentase Pelanggan Telat Bayar',
                                            'denda_per_pelanggan' => 'Denda per Pelanggan Telat',
                                        ];
                                        $warna_param = [
                                            'tarif_promo' => 'table-warning',
                                            'tarif_normal' => 'table-warning',
                                            'bulan_promo' => 'table-warning',
                                            'biaya_pendaftaran' => 'table-info',
                                            'persen_balik_nama' => 'table-success',
                                            'nilai_balik_nama' => 'table-success',
                                            'biaya_psk' => 'table-primary',
                                            'persen_telat' => 'table-danger',
                                            'denda_per_pelanggan' => 'table-danger',
                                        ];
                                        $fmt = [
                                            'tarif_promo' => 'rp',
                                            'tarif_normal' => 'rp',
                                            'bulan_promo' => 'text',
                                            'biaya_pendaftaran' => 'rp',
                                            'persen_balik_nama' => 'pct',
                                            'nilai_balik_nama' => 'rp',
                                            'biaya_psk' => 'rp',
                                            'persen_telat' => 'pct',
                                            'denda_per_pelanggan' => 'rp',
                                        ];
                                        ?>
                                        <?php if (!empty($tarif_grouped)) : ?>
                                            <?php foreach ($tarif_grouped as $jenis => $params) : ?>
                                                <?php $rowspan = count($params); ?>
                                                <?php $first = true; ?>
                                                <?php foreach ($params as $p) : ?>
                                                    <tr class="<?= isset($warna_param[$p->parameter]) ? $warna_param[$p->parameter] : '' ?>">
                                                        <td class="text-center"><?= $no++ ?></td>
                                                        <?php if ($first) : ?>
                                                            <td rowspan="<?= $rowspan ?>" class="align-middle fw-bold"><?= htmlspecialchars($jenis) ?></td>
                                                            <?php $first = false; ?>
                                                        <?php endif; ?>
                                                        <td><?= htmlspecialchars($p->parameter) ?></td>
                                                        <td><?= isset($ket[$p->parameter]) ? $ket[$p->parameter] : '' ?></td>
                                                        <td class="text-end fw-bold">
                                                            <?php if (isset($fmt[$p->parameter])) : ?>
                                                                <?php if ($fmt[$p->parameter] == 'rp') : ?>
                                                                    <?= 'Rp ' . number_format($p->nilai, 0, ',', '.') ?>
                                                                <?php elseif ($fmt[$p->parameter] == 'pct') : ?>
                                                                    <?= number_format($p->nilai * 100, 1, ',', '.') . '%' ?>
                                                                <?php else : ?>
                                                                    <?= htmlspecialchars($p->nilai) ?>
                                                                <?php endif; ?>
                                                            <?php else : ?>
                                                                <?= number_format($p->nilai, 2, ',', '.') ?>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                                <?php
                                                                $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                                $level = $this->session->userdata('level');
                                                                if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                                    <a href="<?= site_url('lembar_kerja/lr/tarif_non_air/edit/' . $p->id) ?>">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada data tarif.</td>
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