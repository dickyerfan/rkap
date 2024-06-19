<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>App | <?= $title ?></title>

    <!-- Favicons -->
    <link href="<?= base_url() ?>assets/img/logo.png" rel="icon">

    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        @font-face {
            font-family: 'Scada';
            src: url("<?= base_url('assets/fonts/Scada-Regular.ttf') ?>");
        }

        @font-face {
            font-family: 'Arial';
            src: url("<?= base_url('assets/fonts/ARIALN.TTF') ?>");
        }

        .title {
            font-family: 'Scada';
        }

        @media screen and (max-width: 472px) {
            .title {
                margin-top: 10px !important;
            }
        }

        @media (max-width: 767px) {
            .gambar {
                display: none !important;
            }
        }
    </style>
</head>

<body style="background-color:#E8FBFC ;">
    <div class="container py-5">
        <div class="row bg-white justify-content-center p-5 shadow rounded">
            <div class="col-lg-6">
                <h2 class="display-1 fs-2 text-primary text-center title">PDAM Bondowoso</h2>
                <p class="display-1 fs-6 text-center text-primary">Silakan login untuk masuk ke Halaman RKAP</p>
                <img src="<?= base_url('assets/img/hero-carousel/hero5.jpg') ?>" class="img-fluid  gambar" style="height: 380px;">
            </div>
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <img src="<?= base_url('assets/img/logo.png') ?>" class="card-img-top mt-2" alt="Logo Pdam" style="width:20% ;">
                        <h2 class="text-primary mt-4 display-6">Silakan <?= strtoupper($title); ?></h2>
                        <?= $this->session->flashdata('info'); ?>
                        <?= $this->session->unset_userdata('info'); ?>
                    </div>
                    <div class="card-footer">
                        <form method="post" action="<?= base_url('auth') ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" name="upk_bagian" id="upk_bagian" placeholder="Masukkan nama UPK atau Bagian" value="<?= set_value('upk_bagian'); ?>">
                                <?= form_error('upk_bagian', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <div class="form-group mt-2">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password">
                                <?= form_error('password', '<span class="text-danger small pl-2">', '</span>'); ?>
                            </div>
                            <div class="d-grid mt-3">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </div>
                        </form>
                        <hr class="mb-5">
                        <div class="text-center small mb-3">
                            <!-- Batal!, <a href="<?= base_url('publik') ?>" style="text-decoration:none;">Silakan Kembali</a> -->
                        </div>
                        <!-- Belum punya akun!, <a href="<?= base_url('auth/registrasi') ?>" style="text-decoration:none;">Silakan Register</a> | -->
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