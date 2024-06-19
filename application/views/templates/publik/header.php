<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PDAM Bondowoso</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= base_url() ?>assets/img/logo.png" rel="icon">
    <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= base_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= base_url() ?>assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: UpConstruction - v1.3.0
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="<?= base_url('publik') ?>" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/logo.png" alt="">
                <h6 style="padding-top: 6px; color: aliceblue;">Perusahaan Daerah Air Minum <br>Kabupaten Bondowoso</h6>
            </a>

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="<?= base_url('publik') ?>" class="active">Beranda</a></li>
                    <li class="dropdown"><a href="#"><span>Profil</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="<?= base_url('publik'); ?>#sejarah">Sejarah</a></li>
                            <li><a href="<?= base_url('publik'); ?>#visimisi">Visi Misi</a></li>
                            <li><a href="<?= base_url('publik'); ?>#dakum">Dasar Hukum</a></li>
                            <li><a href="<?= base_url('publik'); ?>#struktur">Struktur Organisasi</a></li>
                            <li><a href="<?= base_url('publik'); ?>#tupoksi">Tugas Pokok & Fungsi</a></li>
                            <li><a href="<?= base_url('publik'); ?>#penghargaan">Penghargaan</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Info Layanan</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="<?= base_url('layanan/infoPelayanan') ?>">Informasi Pelayanan</a></li>
                            <li><a href="<?= base_url('layanan'); ?>">Cakupan Layanan</a></li>
                            <li><a href="<?= base_url('layanan/sumberAirBaku'); ?>">Sumber Air Baku</a></li>
                            <li><a href="<?= base_url('layanan/kapasitasProduksi') ?>">Kapasitas Produksi</a></li>
                            <li><a href="<?= base_url('layanan/informasiTeknis') ?>">Informasi Teknis</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Info Pelanggan</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                        <ul>
                            <li><a href="<?= base_url('pelanggan') ?>">Tarif Air Minum</a></li>
                            <li><a href="<?= base_url('pelanggan/biayaPasangBaru') ?>">Layanan Pasang baru</a></li>
                            <li><a href="<?= base_url('pelanggan/tangkiAir') ?>">Layanan Tangki Air</a></li>
                            <li><a href="<?= base_url('pelanggan/gantiNama') ?>">Layanan Ganti Nama</a></li>
                            <li><a href="<?= base_url('pelanggan/denda') ?>">Denda / Pelanggaran</a></li>
                            <li><a href="<?= base_url('pelanggan/pengaduanPelanggan') ?>">Pengaduan Pelanggan</a></li>
                        </ul>
                    </li>
                    <li><a href="<?= base_url('kontak') ?>">Kontak</a></li>
                    <li><a href="<?= base_url('ijenWater') ?>">Ijen Water</a></li>
                    <li><a href="<?= base_url('auth') ?>">Login</a></li>
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->