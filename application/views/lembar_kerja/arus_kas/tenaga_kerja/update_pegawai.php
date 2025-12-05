<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/pegawai') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/update_pegawai') ?>" method="post">
                                    <input type="hidden" name="id" value="<?= $pegawai['id'] ?>">
                                    <div class="form-group mb-2">
                                        <label>Nama Pegawai</label>
                                        <input type="text" class="form-control" value="<?= $pegawai['nama'] ?>" readonly>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Bagian</label>
                                        <!-- <input type="text" name="bagian" class="form-control" value="<?= $pegawai['bagian'] ?>" required> -->
                                        <select name="bagian" id="bagian" class="form-select select2">
                                            <option value="umum" <?= $pegawai['bagian'] == 'umum' ? 'selected' : '' ?>>Umum</option>
                                            <option value="keuangan" <?= $pegawai['bagian'] == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                            <option value="langganan" <?= $pegawai['bagian'] == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                            <option value="pemeliharaan" <?= $pegawai['bagian'] == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                            <option value="perencanaan" <?= $pegawai['bagian'] == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                            <option value="spi" <?= $pegawai['bagian'] == 'spi' ? 'selected' : '' ?>>S P I</option>
                                            <option value="bondowoso" <?= $pegawai['bagian'] == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
                                            <option value="sukosari1" <?= $pegawai['bagian'] == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                            <option value="maesan" <?= $pegawai['bagian'] == 'maesan' ? 'selected' : '' ?>>Maesan</option>
                                            <option value="tegalampel" <?= $pegawai['bagian'] == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                            <option value="tapen" <?= $pegawai['bagian'] == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                            <option value="prajekan" <?= $pegawai['bagian'] == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                            <option value="tlogosari" <?= $pegawai['bagian'] == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                            <option value="wringin" <?= $pegawai['bagian'] == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                            <option value="curahdami" <?= $pegawai['bagian'] == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                            <option value="tamanan" <?= $pegawai['bagian'] == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                            <option value="tenggarang" <?= $pegawai['bagian'] == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                            <option value="tamankrocok" <?= $pegawai['bagian'] == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                            <option value="wonosari" <?= $pegawai['bagian'] == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                            <option value="sukosari2" <?= $pegawai['bagian'] == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>
                                            <option value="amdk" <?= $pegawai['bagian'] == 'amdk' ? 'selected' : '' ?>> A M D K</option>
                                        </select>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Jabatan</label>
                                            <!-- <input type="text" name="jabatan" class="form-control" value="<?= $pegawai['jabatan'] ?>"> -->
                                            <select name="jabatan" id="jabatan" class="form-select select2">
                                                <option value="Ketua" <?= $pegawai['jabatan'] == 'Ketua' ? 'selected' : '' ?>>Ketua</option>
                                                <option value="Kabag" <?= $pegawai['jabatan'] == 'Kabag' ? 'selected' : '' ?>>Kabag</option>
                                                <option value="Ka UPK" <?= $pegawai['jabatan'] == 'Ka UPK' ? 'selected' : '' ?>>Ka UPK</option>
                                                <option value="Kasubag" <?= $pegawai['jabatan'] == 'Kasubag' ? 'selected' : '' ?>>Kasubag</option>
                                                <option value="Pelaksana" <?= $pegawai['jabatan'] == 'Pelaksana' ? 'selected' : '' ?>>Pelaksana</option>
                                                <option value="Staff" <?= $pegawai['jabatan'] == 'Staff' ? 'selected' : '' ?>>Staff</option>
                                                <option value="Manajer" <?= $pegawai['jabatan'] == 'Manajer' ? 'selected' : '' ?>>Manajer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Kategori</label>
                                            <select name="kategori" id="kategori" class="form-select">
                                                <option value="Administrasi" <?= $pegawai['kategori'] == 'Administrasi' ? 'selected' : '' ?>>Administrasi</option>
                                                <option value="Teknik" <?= $pegawai['kategori'] == 'Teknik' ? 'selected' : '' ?>>Teknik</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Status Pegawai</label>
                                            <select name="status_pegawai" id="status_pegawai" class="form-select">
                                                <option value="Karyawan Tetap" <?= $pegawai['status_pegawai'] == 'Karyawan Tetap' ? 'selected' : '' ?>>Karyawan Tetap</option>
                                                <option value="Karyawan Kontrak" <?= $pegawai['status_pegawai'] == 'Karyawan Kontrak' ? 'selected' : '' ?>>Karyawan Kontrak</option>
                                                <option value="Karyawan Honorer" <?= $pegawai['status_pegawai'] == 'Karyawan Honorer' ? 'selected' : '' ?>>Karyawan Honorer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenkel" id="jenkel" class="form-select">
                                                <option value="Laki-laki" <?= $pegawai['jenkel'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= $pegawai['jenkel'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Dapenma</label>
                                            <select name="dapenma" id="dapenma" class="form-select">
                                                <option value="1" <?= $pegawai['dapenma'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $pegawai['dapenma'] == '0' ? 'selected' : '' ?>>Belum</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Status Aktif/Purna</label>
                                            <select name="aktif" id="aktif" class="form-select">
                                                <option value="1" <?= $pegawai['aktif'] == '1' ? 'selected' : '' ?>>Aktif</option>
                                                <option value="0" <?= $pegawai['aktif'] == '0' ? 'selected' : '' ?>>Purna</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="neumorphic-button">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>