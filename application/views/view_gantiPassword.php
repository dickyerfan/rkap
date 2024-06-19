<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow mb-2">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?=($this->session->userdata('level')=='Pengguna')? base_url('pengguna'): base_url('dashboard') ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <?= $this->session->flashdata('info'); ?>
                <?= $this->session->unset_userdata('info'); ?>

                <div class="card-body">
                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passLama">Password Lama:</label>
                                    <input type="password" class="form-control" id="passLama" name="passLama" value="<?= set_value('passLama'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('passLama'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="passbaru">Password Baru:</label>
                                    <input type="password" class="form-control" id="passbaru" name="passBaru" value="<?= set_value('passbaru'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('passBaru'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="passConf">Password Konfirmasi:</label>
                                    <input type="password" class="form-control" id="passConf" name="passConf" value="<?= set_value('passConf'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('passConf'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-1" name="tambah" type="submit"><i class="fas fa-key"></i> Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </main>