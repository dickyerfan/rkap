<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <?php
                                    $tahun_asal   = $tahun - 1;
                                    $tahun_tujuan = $tahun;
                                    ?>
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/data_pendukung/duplicate_next_year_pola?tahun_asal=' . $tahun_asal) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" onclick="return confirm('Yakin ingin menduplikasi data tahun <?= $tahun_asal ?> ke <?= $tahun_tujuan ?> ?')"> Duplicate Pola Konsumsi <?= $tahun_asal ?> → <?= $tahun_tujuan ?></button> </a>
                                </div>
                                <div class="navbar-nav">
                                    <?php
                                    $tahun_asal   = $tahun - 1;
                                    $tahun_tujuan = $tahun;
                                    ?>
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/data_pendukung/duplicate_next_year_tarif?tahun_asal=' . $tahun_asal) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" onclick="return confirm('Yakin ingin menduplikasi data tahun <?= $tahun_asal ?> ke <?= $tahun_tujuan ?> ?')"> Duplicate Tarif Rata-rata <?= $tahun_asal ?> → <?= $tahun_tujuan ?></button> </a>
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
                            <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">UPK</th>
                                        <th class="text-center">Jenis Pelanggan</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Pola Konsumsi </th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pola_konsumsi)) : ?>
                                        <?php $no = 1;
                                        foreach ($pola_konsumsi as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row->nama_upk) ?></td>
                                                <td><?= htmlspecialchars($row->nama_jp) ?></td>
                                                <td class="text-center"><?= $row->tahun ?></td>
                                                <td class="text-end"><?= number_format($row->konsumsi_rata, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                        <?php
                                                        $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                        $level = $this->session->userdata('level');
                                                        if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                            <a href="<?= site_url('lembar_kerja/lr/data_pendukung/edit_pola/' . $row->id) ?>" class="">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Belum ada data pola konsumsi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title2 . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">UPK</th>
                                            <th class="text-center">Jenis Pelanggan</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="text-center">Tarif Rata-rata </th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($tarif_rata)) : ?>
                                            <?php $no = 1;
                                            foreach ($tarif_rata as $row) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($row->nama_upk) ?></td>
                                                    <td><?= htmlspecialchars($row->nama_jp) ?></td>
                                                    <td class="text-center"><?= $row->tahun ?></td>
                                                    <td class="text-end"><?= number_format($row->tarif_rata, 0, ',', '.') ?></td>
                                                    <td class="text-center">
                                                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                            <?php
                                                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                            $level = $this->session->userdata('level');
                                                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                                <a href="<?= site_url('lembar_kerja/lr/data_pendukung/edit_tarif/' . $row->id) ?>" class="">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Belum ada data pola konsumsi.</td>
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