<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/tampil_tahun_lalu') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;
                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/tampil_tahun_lalu') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-reply"></i> Kembali</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/input_tahun_lalu') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-plus"></i> Input Tahun Lalu</button> </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <!-- <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php if (!empty($upk)) : ?>
                                <form method="post" action="<?= site_url('lembar_kerja/rkap_amdk/penerimaan_amdk/tampil_tahun_lalu/generate_rekap'); ?>">
                                    <input type="hidden" name="upk" value="<?= $upk; ?>">
                                    <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                    <button type="submit" class="neumorphic-button">
                                        <i class="fa fa-database"></i> Generate Data
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun - 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:1rem;">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Tahun</th>
                                            <th>Produk Lalu</th>
                                            <th>Rupiah Lalu</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($hasil as $r) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $r->nama_produk ?></td>
                                                <td class="text-center"><?= $r->tahun ?></td>
                                                <td class="text-end"><?= number_format($r->produk_lalu, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($r->rupiah_lalu, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                    $level = $this->session->userdata('level');
                                                    if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                        <a href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/edit_tahun_lalu/' . $r->id) ?>"><i class="fas fa-edit"></i> </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>