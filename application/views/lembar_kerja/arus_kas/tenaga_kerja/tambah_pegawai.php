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
                    <?php $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="table-responsive">
                                <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/tambah_pegawai') ?>" method="post">

                                    <div class="form-group mb-2">
                                        <label>Nama Pegawai</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $pegawai['nama'] ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Bagian</label>
                                        <select name="bagian" id="bagian" class="form-select select2">
                                            <option value="" selected disabled>Pilih Bagian</option>
                                            <option value="umum">Umum</option>
                                            <option value="keuangan">Keuangan</option>
                                            <option value="langganan">Langganan</option>
                                            <option value="pemeliharaan">Pemeliharaan</option>
                                            <option value="perencanaan">Perencanaan</option>
                                            <option value="spi">S P I</option>
                                            <option value="amdk"> A M D K</option>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('bagian'); ?></small>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Jabatan</label>
                                            <select name="jabatan" id="jabatan" class="form-select select2">
                                                <option value="" selected disabled>Pilih Jabatan</option>
                                                <option value="Ketua">Ketua</option>
                                                <option value="Kabag">Kabag</option>
                                                <option value="Kasubag">Kasubag</option>
                                                <option value="Pelaksana">Pelaksana</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Manajer">Manajer</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Kategori</label>
                                            <select name="kategori" id="kategori" class="form-select">
                                                <option value="" selected disabled>Pilih Kategori</option>
                                                <option value="Administrasi">Administrasi</option>
                                                <option value="Teknik">Teknik</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('kategori'); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Status Pegawai</label>
                                            <select name="status_pegawai" id="status_pegawai" class="form-select">
                                                <option value="" selected disabled>Pilih Status</option>
                                                <option value="Karyawan Tetap">Karyawan Tetap</option>
                                                <option value="Karyawan Kontrak">Karyawan Kontrak</option>
                                                <option value="Karyawan Honorer">Karyawan Honorer</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('status_pegawai'); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Jenis Kelamin</label>
                                            <select name="jenkel" id="jenkel" class="form-select">
                                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('jenkel'); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Dapenma</label>
                                            <select name="dapenma" id="dapenma" class="form-select">
                                                <option value="" selected disabled>Pilih Dapenma</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Belum</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('dapenma'); ?></small>
                                        </div>
                                    </div>
                                    <button type="submit" class="neumorphic-button">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>