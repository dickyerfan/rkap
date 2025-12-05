<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('user/admin'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna :</label>
                                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Masukan nama pengguna" value="<?= set_value('nama_pengguna'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_pengguna'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap :</label>
                                    <!-- <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukan nama lengkap" value="<?= set_value('nama_lengkap'); ?>"> -->
                                    <select name="nama_lengkap" id="nama_lengkap" class="form-select select2">
                                        <option value="">Pilih Nama Kepala Bagian/UPK</option>
                                        <?php foreach ($data_karyawan as $row) : ?>
                                            <option value="<?= $row->nama ?>">
                                                <?= $row->nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_lengkap'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="upk_bagian">Bagian / UPK :</label>
                                    <input type="text" class="form-control" id="upk_bagian" name="upk_bagian" placeholder="Masukan upk_bagian" value="<?= set_value('upk_bagian'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('upk_bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password :</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password" value="<?= set_value('password'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('password'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Pilih:</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="Admin">Admin</option>
                                        <option value="Pengguna" selected>Pengguna</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipe">Pilih:</label>
                                    <select name="tipe" id="tipe" class="form-control select2">
                                        <option value="">Pilih tipe</option>
                                        <option value="admin">admin</option>
                                        <option value="upk">upk</option>
                                        <option value="bagian">bagian</option>
                                        <!-- <option value="korektor">korektor</option> -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>