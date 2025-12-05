<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> <i class="fas fa-reply"></i> Kembali</button> </a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/input') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-plus"></i> Input Data</button> </a>
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
                                <table class="table table-sm table-bordered" style="font-size: 0.85rem;" id="example3">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Kode Perkiraan</th>
                                            <th>Nama Barang</th>
                                            <th>Pembagi</th>
                                            <th>Satuan</th>
                                            <th>Tahun</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($barang)) : ?>
                                            <?php $no = 1;
                                            foreach ($barang as $b) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($b->no_per_id); ?></td>
                                                    <td><?= htmlspecialchars($b->nama_barang); ?></td>
                                                    <td class="text-right"><?= number_format($b->pembagi, 3, ',', '.'); ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($b->satuan); ?></td>
                                                    <td class="text-center"><?= $b->tahun; ?></td>
                                                    <td class="text-center">
                                                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                            <?php
                                                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                            $level = $this->session->userdata('level');
                                                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                                <a href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/edit/' . $b->id_barang); ?>" title="Edit Data"><i class="fas fa-edit"></i></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada data barang untuk tahun ini.</td>
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