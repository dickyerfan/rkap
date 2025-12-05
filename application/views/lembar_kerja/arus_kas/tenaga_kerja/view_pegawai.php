<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/pegawai') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <!-- Pilih UPK -->
                                <select name="upk" class="form-select select2" style="width: 150px;">
                                    <option value="">Konsolidasi</option>
                                    <option value="umum" <?= $upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="keuangan" <?= $upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="langganan" <?= $upk == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                    <option value="pemeliharaan" <?= $upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="perencanaan" <?= $upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="spi" <?= $upk == 'spi' ? 'selected' : '' ?>>Spi</option>
                                    <option value="amdk" <?= $upk == 'amdk' ? 'selected' : '' ?>>Amdk</option>
                                    <option value="bondowoso" <?= $upk == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="sukosari1" <?= $upk == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="maesan" <?= $upk == 'maesan' ? 'selected' : '' ?>> Maesan</option>
                                    <option value="tegalampel" <?= $upk == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="tapen" <?= $upk == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="prajekan" <?= $upk == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="tlogosari" <?= $upk == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="wringin" <?= $upk == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="curahdami" <?= $upk == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="tamanan" <?= $upk == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="tenggarang" <?= $upk == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="tamankrocok" <?= $upk == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="klabang" <?= $upk == 'klabang' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="wonosari" <?= $upk == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="sukosari2" <?= $upk == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>

                                </select>
                                <!-- 
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $tahun_mulai = date('Y') - 10;
                                    $tahun_selesai = date('Y') + 1;
                                    for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) :
                                    ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select> -->

                                <input type="submit" value="Tampilkan Data" class="neumorphic-button" style="margin-left:10px;">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/pegawai') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/export_pegawai_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('nama_pengguna') == 'Personalia' || $this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/tambah_pegawai') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-plus"></i> Input Pegawai Baru</button> </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button> </a>
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
                            <h5><?= $title; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Bagian</th>
                                            <th class="text-center">Jabatan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Dapenma</th>
                                            <th class="text-center">J. Kelamin</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($pegawai as $p) : ?>
                                            <tr>
                                                <td class="text-center"><?= $i++; ?></td>
                                                <td class="text-start"><?= $p->nama; ?></td>
                                                <td class="text-start"><?= $p->bagian; ?></td>
                                                <td class="text-start"><?= $p->jabatan; ?></td>
                                                <td class="text-start"><?= $p->kategori; ?></td>
                                                <td class="text-start"><?= $p->status_pegawai; ?></td>
                                                <td class="text-center">
                                                    <?= $p->dapenma == 1 ? 'Aktif' : 'Belum'; ?>
                                                </td>
                                                <td class="text-center"><?= $p->jenkel; ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                    $level = $this->session->userdata('level');
                                                    if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                        <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/edit_pegawai/' . $p->id) ?>"><i class="fa fa-edit"></i></a>
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