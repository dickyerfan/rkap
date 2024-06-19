<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>App | <?= $title ?></title>

    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body style="background-color: #E8FBFC;">

    <div class="container py-2">
        <div class="row bg-white justify-content-center p-5 shadow rounded">
            <div class="col-md-6 ">
                <h2 class="display-5 fs-1 text-primary text-center">Belum Punya Akun <br> Silakan Registrasi</h2>
                <img src="<?= base_url('assets/photo/default.jpg') ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <img src="<?= base_url('assets/img/pdam_biru.png') ?>" alt="" style="width:25% ;">
                        <h1 class="display-6 text-primary mt-4">FORM <?= strtoupper($title); ?></h1>

                        <?= $this->session->flashdata('info'); ?>
                        <?= $this->session->unset_userdata('info'); ?>
                    </div>
                    <div class="card-footer">
                        <form class="user" method="post" action="<?= base_url('auth/registrasi') ?>">
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" name="nama_pengguna" id="nama_pengguna" placeholder="Masukan Nama pengguna" value="<?= set_value('nama_pengguna'); ?>">
                                <?= form_error('nama_pengguna', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Masukan Nama Lengkap" value="<?= set_value('nama_lengkap'); ?>">
                                <?= form_error('nama_lengkap', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <div class="form-group mt-2">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukan Alamat email" value="<?= set_value('email'); ?>">
                                <?= form_error('email', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <div class="form-group mt-2">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <?= form_error('password', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <!-- <div class="form-group">
                        <select name="level" id="level" class="form-control">
                            <option value="Admin">Admin</option>
                            <option value="Pengguna" selected>Pengguna</option>
                        </select>
                        </div> -->
                            <div class="d-grid mt-3">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                        <hr>
                        <div class="text-center small">
                            Sudah punya akun!, <a href="<?= base_url('auth') ?>" style="text-decoration:none;">Silakan Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>/js/scripts.js"></script>
    <script src="<?= base_url() ?>/js/Chart.min.js" crossorigin="anonymous"></script>
</body>

</html>