<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('user/admin'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('user/admin/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id" value="<?= $user->id ?>">
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna :</label>
                                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?= $user->nama_pengguna; ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap :</label>
                                    <!-- <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user->nama_lengkap; ?>"> -->
                                    <select name="nama_lengkap" id="nama_lengkap" class="form-select select2">
                                        <!-- <option value="">Pilih Nama Kepala Bagian/UPK</option> -->
                                        <?php foreach ($data_karyawan as $row) : ?>
                                            <option value="<?= $row->nama ?>" <?= $row->nama == $user->nama_lengkap ? 'selected' : '' ?>>
                                                <?= $row->nama ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="upk_bagian">Bagian / UPK :</label>
                                    <input type="text" class="form-control" id="upk_bagian" name="upk_bagian" value="<?= $user->upk_bagian; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level :</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="Admin" <?= $user->level == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="Pengguna" <?= $user->level == 'Pengguna' ? 'selected' : '' ?>>Pengguna</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>