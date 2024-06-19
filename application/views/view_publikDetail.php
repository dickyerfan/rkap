<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kajian | <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- select2 bootstrap5 -->
    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/select2-bootstrap-5-theme.min.css" />

    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
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

        .kitab {
            font-family: 'Pristina';
        }

        .ustadz {
            font-family: 'Tempus';
        }

        .ket_ustadz {
            font-family: 'Arial';
        }

        .hilang {
            display: none;
        }

        .title {
            font-family: 'Scada';
        }

        @media screen and (max-width: 472px) {
            .title {
                /* color: red !important; */
                font-size: 12px !important;
            }

            #btn-up {
                display: block !important;
            }
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
            display: none;
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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand title"><?= strtoupper($title) ?></a>
            <form class="d-flex">
                <a href="<?= base_url() ?>#kajian" class="btn btn-outline-light btn-sm float-end">Kembali</a>
            </form>
        </div>
    </nav>
    <div class="card mt-5">
        <div class="card-footer">
            <div class="row">
                <div class="col">
                    <h5 class="card-title title mt-3"><?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        $bulan = date('m');
                                                        $bulanList = array(
                                                            '01' => 'Januari',
                                                            '02' => 'Februari',
                                                            '03' => 'Maret',
                                                            '04' => 'April',
                                                            '05' => 'Mei',
                                                            '06' => 'Juni',
                                                            '07' => 'Juli',
                                                            '08' => 'Agustus',
                                                            '09' => 'September',
                                                            '10' => 'Oktober',
                                                            '11' => 'November',
                                                            '12' => 'Desember'
                                                        );
                                                        $tanggal = date('d') . ' ' . $bulanList[$bulan] . ' ' . date('Y');
                                                        $hari = date('D');
                                                        $hari = date('D', strtotime($hari));
                                                        $dayList = array(
                                                            'Sun' => 'Ahad',
                                                            'Mon' => 'Senin',
                                                            'Tue' => 'Selasa',
                                                            'Wed' => 'Rabu',
                                                            'Thu' => 'Kamis',
                                                            'Fri' => 'Jum\'at',
                                                            'Sat' => 'Sabtu'
                                                        );
                                                        echo $dayList[$hari]  . '  ' . $tanggal
                                                        ?>
                    </h5>
                </div>
                <div class="col text-end">
                    <h5 class="title btn btn-outline-dark mt-2" id="jam"></h5>
                </div>
            </div>

        </div>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-2 mt-1">
                <!-- <div class="card"> -->
                <div class="card-body">
                    <?php
                    $numOfCols = 3;
                    $rowCount = 0;
                    $bootstrapColWidth = 12 / $numOfCols;
                    ?>
                    <div class="row">
                        <?php foreach ($kajian as $row) : ?>
                            <div class="col-xl-<?= $bootstrapColWidth; ?>" style="margin-bottom: 100px;">
                                <div class="card text-center shadow">
                                    <div class="card-header bg-primary text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(29, 236, 197, 0.7),
                                            rgba(91, 14, 214, 0.9) 100%
                                            )">
                                        <?php
                                        $hari = $row->hari_kajian;
                                        switch ($hari) {
                                            case '1':
                                                $hari = "Ahad";
                                                break;
                                            case '2':
                                                $hari = "Senin";
                                                break;
                                            case '3':
                                                $hari = "Selasa";
                                                break;
                                            case '4':
                                                $hari = "Rabu";
                                                break;
                                            case '5':
                                                $hari = "Kamis";
                                                break;
                                            case '6':
                                                $hari = "Jum'at";
                                                break;
                                            case '7':
                                                $hari = "Sabtu";
                                                break;
                                        }
                                        ?>
                                        <b><?= strtoupper($hari); ?></b>
                                    </div>
                                </div>
                                <div class="card shadow h-100">
                                    <div class="card p-1 text-light position-relative h-100">
                                        <img src="<?= base_url('assets/photo/') ?><?= $row->foto_mesjid; ?>" class="card-img h-100" alt="...">
                                        <div class="mask position-absolute top-0 end-0 bottom-0 start-0" style="background: linear-gradient(
                                            45deg,
                                            rgba(69,63,251, 0.9),
                                            rgba(70,252,186, 0.9) 100%
                                            )"></div>
                                    </div>
                                    <div class="card-img-overlay text-light">
                                        <h3 class="card-title kitab"><i class="fas fa-book-open fa-fw"></i> <?= $row->nama_kitab ?></h3>
                                        <h5 class="card-text ms-4 kitab"><i><?= $row->ket_kitab == null ? '<br>' : $row->ket_kitab ?></i></h5>
                                        <hr>
                                        <h6 class="card-title ustadz"><i class="fas fa-user fa-fw"></i> Ust. <b><?= $row->nama_ustadz ?> حَفِظَهُ اللهُ</b></h6>
                                        <p class="ket_ustadz"><i class="fas fa-id-card fa-fw"></i> <small> <?= $row->ket_ustadz == null ? '<br>' : $row->ket_ustadz ?></small></p>
                                        <hr>
                                        <b><i class="fas fa-clock fa-fw"></i> <?= $row->nama_waktu ?></b><br>
                                        <b><i class="fas fa-calendar-alt fa-fw"></i> <?= $row->waktu_kajian ?> </b>
                                    </div>
                                </div>
                                <div class="card text-center shadow">
                                    <div class="card-footer bg-primary text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(29, 236, 197, 0.7),
                                            rgba(91, 14, 214, 0.9) 100%
                                            )">
                                        <b><?= $row->keterangan; ?></b>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $rowCount++;
                            if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                        endforeach; ?>
                    </div>
                </div>
                <!-- <div class="card-footer"></div> -->
                <!-- </div> -->
            </div>
        </main>
    </div>
    <button id="btn-up"><i class="fas fa-chevron-circle-up"></i></button>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Yakin Mau Logout.?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" jika anda yakin mau keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sweetalert2 -->
    <script src="<?php echo base_url('assets/'); ?>sweetalert2.all.min.js"></script>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/js/scripts.js"></script>
    <script src="<?= base_url() ?>assets/js/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/demo/chart-area-demo.js"></script>
    <script src="<?= base_url() ?>assets/demo/chart-bar-demo.js"></script>
    <script src="<?= base_url() ?>assets/js/datatables-simple-demo.js"></script>

    <!-- datatable bootstrap5 -->
    <script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery-3.5.1.js"></script>
    <script src="<?= base_url(); ?>assets/datatables/bootstrap5/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/datatables/bootstrap5/dataTables.bootstrap5.min.js"></script>
    <!-- select2 js -->
    <script src="<?= base_url() ?>assets/select2/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <script>
        $('.select2').select2({
            theme: 'bootstrap-5'
        });
    </script>

    <script>
        $('.btn-danger').on('click', function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            Swal.fire({
                title: 'Yakin mau Di Hapus?',
                text: 'Jika yakin tekan Hapus',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = href;
                }
            })
        })
    </script>

    <script>
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ' : ' + m + ' : ' + s + ' WIB';

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
    <script>
        $("#btn-up").click(function() {
            $("html,body").animate({
                scrollTop: 0
            }, 500);
        });
    </script>

</body>

</html>