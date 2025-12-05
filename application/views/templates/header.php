<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="<?= base_url() ?>assets/img/logo.png" rel="icon">
    <title>RKAP | <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/latar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/style_dashboard.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- select2 bootstrap5 -->
    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/select2-bootstrap-5-theme.min.css" />

    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/datepicker.css') ?>">

    <style>
        /* .body {
			background-image: url(img/background.jpg) !important;
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		} */
        @font-face {
            font-family: 'Pristina';
            src: url("<?= base_url('assets/fonts/PRISTINA.TTF') ?>");
        }

        @font-face {
            font-family: 'Scada';
            src: url("<?= base_url('assets/fonts/Scada-Regular.ttf') ?>");
        }

        @font-face {
            font-family: 'Sego';
            src: url("<?= base_url('assets/fonts/Segoeprb.ttf') ?>");
        }

        @font-face {
            font-family: 'Tempus';
            src: url("<?= base_url('assets/fonts/TEMPSITC.TTF') ?>");
        }

        @font-face {
            font-family: 'Papirus';
            src: url("<?= base_url('assets/fonts/PAPYRUS.TTF') ?>");
        }

        @font-face {
            font-family: 'One';
            src: url("<?= base_url('assets/fonts/75749_.ttf') ?>");
        }

        @font-face {
            font-family: 'Arial';
            src: url("<?= base_url('assets/fonts/ARIALN.TTF') ?>");
        }

        .title {
            font-family: 'Scada';
        }

        .hilang {
            display: none;
        }

        #btn-up {
            position: fixed;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            bottom: 20px;
            right: 20px;
            cursor: pointer;
            font-size: 15px;
            background: rgba(192, 192, 192, 0.5);
            color: #000;
            border: none;
            outline: none;
            padding: 5px 10px;
        }

        #btn-up:hover {
            opacity: 0.5;
        }

        #btn-up:active {
            opacity: 0.9;
        }

        .fa-chevron-circle-up {
            font-size: 30px;
            line-height: 40px;
            color: #01daec;
        }

        .judul {
            display: none;
        }

        @media print {

            .logo {
                display: none;
            }

            .font {
                font-size: 0.7rem;
            }

            .arial {
                font-family: 'Arial';
                font-size: 0.8rem;
            }

            .judul {
                display: block;
            }
        }

        .sudah-class {
            color: black !important;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <div id="global-loader" class="loader-wrapper">
        <div class="loader-content">
            <img src="<?= base_url('assets/img/logo.png') ?>" class="loader-logo" alt="Logo PDAM">
            <div class="drop"></div>
            <br>
            <br>
            <h5 class="loader-text">Sedang memproses data...<br>Mohon tunggu sebentar</h5>
        </div>
    </div>

    <style>
        /* ========== PDAM LOADER CSS ========== */

        .loader-wrapper {
            position: fixed;
            z-index: 999999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(240, 248, 255, 0.9);
            /* biru lembut */
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .loader-content {
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        .loader-logo {
            width: 90px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        /* Animasi tetesan air */
        .drop {
            width: 18px;
            height: 18px;
            background: #00aaff;
            border-radius: 50%;
            margin: 0 auto;
            position: relative;
            animation: drop 1s infinite ease-in-out;
        }

        @keyframes drop {
            0% {
                transform: translateY(0);
                opacity: 1;
            }

            50% {
                transform: translateY(25px);
                opacity: 0.5;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Teks loading */
        .loader-text {
            font-family: 'Arial';
            font-weight: bold;
            margin-top: 15px;
            font-size: 0.95rem;
            color: #005f99;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>