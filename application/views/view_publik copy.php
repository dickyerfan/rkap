<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" style="margin-top: 55px;">
    <div class="carousel-inner">
        <div class="carousel-item active" data-interval="10000">
            <img src="<?= base_url() ?>assets/img/coverbaru.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item" data-interval="10000">
            <img src="<?= base_url() ?>assets/img/donaturtetap.jpg" class="d-block w-100" alt="...">
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(
    45deg,
    rgba(55, 223, 197, 0.9),
    rgba(254, 255, 53, 0.9) 100%
    )">
    <div class="container-fluid" id="kajian">
        <!-- <h5 class="text-dark title fw-bold text-uppercase mt-2">Jadwal Kajian Bondowoso</h5> -->
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            <h5 class="text-dark title fw-bold text-uppercase mt-2">Jadwal Kajian Bondowoso</h5>
        </marquee>
    </div>
</nav>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid g-0 border-0">
            <div class="card">
                <div class="card-header shadow text-light float-end" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6 text-end mt-2">
                            <h5 class="card-title title btn btn-outline-light" id="jam">
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="background: linear-gradient(
                                            90deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.9) 100%
                                            )">
                    <?php
                    $numOfCols = 3;
                    $rowCount = 0;
                    $bootstrapColWidth = 12 / $numOfCols;
                    ?>
                    <div class="row justify-content-center">
                        <?php foreach ($mesjid as $row) : ?>
                            <?php
                            $modal = $row->nama_mesjid;
                            $modal = preg_replace("/[^a-zA-Z]/", "", $modal);
                            $modal = substr($modal, 6, 12);
                            ?>
                            <div class="col-xl-<?= $bootstrapColWidth; ?> mb-4">
                                <div class="card border-0 shadow-lg testimonial-card mt-2 mb-3" style="height:100% ;">
                                    <div class="card-up aqua-gradient">
                                        <img src="<?= base_url('/assets/photo/') ?><?= $row->foto_mesjid ?>" height="150" class="card-img-top">
                                    </div>
                                    <div class="card-body text-dark text-center" style="background: linear-gradient(
                                            45deg,
                                            rgba(184,200,252, 0.5),
                                            rgba(255,255,255, 0.9) 100%
                                            )">
                                        <h5 class="card-title font-weight-bold text-uppercase"> <?= $row->nama_mesjid ?></h5>
                                        <h6 class="card-title"><?= $row->alamat_mesjid ?></h6>
                                        <a href="<?= $row->lokasi_mesjid ?>" target="_blank" style="text-decoration: none;"><i class="fa-solid fa-location-dot"></i> Peta Lokasi</a>
                                        <hr>
                                        <a href="<?= base_url('publik/detail/') ?><?= $row->id_mesjid ?>/<?= $row->nama_mesjid ?>" class="btn btn-primary border-0" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">Daftar Kajian</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            $rowCount++;
                            if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                        endforeach; ?>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-6 mb-1">
                            <div class="card border-0" style="height:100% ;">
                                <div class="card-header" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
                                    <h4 class="card-title text-light font-weight-bold title ps-3">Informasi :</h4>
                                </div>
                                <div class="card-body text-dark" style="background: linear-gradient(
                                            45deg,
                                            rgba(184,200,252, 0.5),
                                            rgba(255,255,255, 0.9) 100%
                                            )">
                                    <h5 class="card-title font-weight-bold title ps-3">Jadwal kajian diatas sewaktu-waktu bisa berubah atau di tiadakan jika Ustadz ada udzur atau kepentingan. <br> <small> untuk mendapatkan info terupdate seputar Kajian Ilmiah di Bondowoso bisa mengikuti group Whatsapp BM, link tautan ada di bagian bawah</small></h5>
                                    <!-- <h5 class="card-title font-weight-bold title ps-3"><i class="far fa-envelope"></i> : kajianbondowoso495@gmail.com</h5> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-1">
                            <div class="card border-0" style="height:100% ;">
                                <div class="card-header ps-4" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
                                    <h4 class="card-title text-light font-weight-bold title ps-3">Catatan :</h4>
                                </div>
                                <div class="card-body text-dark" style="background: linear-gradient(
                                            45deg,
                                            rgba(184,200,252, 0.5),
                                            rgba(255,255,255, 0.9) 100%
                                            )">
                                    <h5 class="card-title font-weight-bold title ps-4">“Barangsiapa menempuh jalan menuntut ilmu, maka Allah akan memudahkan jalannya untuk menuju surga”<br> <small><i> (HR. At Tirmidzi no. 2682, Abu Daud no. 3641, dishahihkan Al Albani dalam Shahih Abu Daud).</i></small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="container-fluid" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
        <h3 class="text-center fw-bold text-success">KEGIATAN TERBARU</h3>
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="10000">
                            <a href="<?= base_url('donasi/detail/ramadhan/2022') ?>"><img src="<?= base_url() ?>assets/img/ifthar22.jpeg" class="d-block w-100" alt="..."></a>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <a href="<?= base_url('donasi/detail/ramadhan/2021') ?>"><img src="<?= base_url() ?>assets/img/tebar_ifthar.jpeg" class="d-block w-100" alt="..."></a>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <a href="<?= base_url('donasi/detail/operasional/2022') ?>"><img src="<?= base_url() ?>assets/img/operasi.png" class="d-block w-100" alt="..."></a>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
        <h2 class="text-center fw-bold text-success">D O N A S I</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div id="carouselExampleInterval1" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item" data-interval="2000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/operasi.png');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(0, 50, 0, 0.6); height: 20rem ">
                                    <div class="text-center">
                                        <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm">
                                    </div>
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Donasi</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Operasional 2021</h5>
                                        <a href="<?= base_url('donasi/detail/operasional/2021') ?>" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item active" data-interval="10000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/operasi.png');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(50, 0, 0, 0.6); height: 20rem ">
                                    <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm" style="margin-left: 80px;">
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Donasi</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Operasional 2022</h5>
                                        <a href="<?= base_url('donasi/detail/operasional/2022') ?>" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <div class="card border-0 bg-image" style="
                                background-image: url('<?= base_url() ?>assets/img/operasi.png');
                                background-size:cover;
                                background-position: center;
                                background-repeat: no-repeat; height: 20rem;
                                    ">
                                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6); height: 20rem ">
                                    <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm" style="margin-left: 80px;">
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Donasi</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Operasional 2023</h5>
                                        <a href="#" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval1" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval1" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <br>
            </div>
            <div class="col-md-4">
                <div id="carouselExampleInterval2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item" data-interval="2000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/tebar_ifthar.jpeg');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(0, 50, 0, 0.6); height: 20rem ">
                                    <div class="text-center">
                                        <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm">
                                    </div>
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Ifthar</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Ramadhan 2021</h5>
                                        <a href="<?= base_url('donasi/detail/ramadhan/2021') ?>" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item active" data-interval="10000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/ifthar22.jpeg');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(50, 0, 0, 0.6); height: 20rem ">
                                    <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm" style="margin-left: 80px;">
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Ifthar</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Ramadhan 2022</h5>
                                        <a href="<?= base_url('donasi/detail/ramadhan/2022') ?>" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <div class="card border-0 bg-image" style="
                                background-image: url('<?= base_url() ?>assets/img/ifthar22(5).jpeg');
                                background-size:cover;
                                background-position: center;
                                background-repeat: no-repeat; height: 20rem;
                                    ">
                                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6); height: 20rem ">
                                    <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm" style="margin-left: 80px;">
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Ifthar</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Ramadhan 2023</h5>
                                        <a href="#!" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval2" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval2" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <br>
            </div>
            <div class="col-md-4">
                <div id="carouselExampleInterval3" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-interval="10000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/palestine.png');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(0, 50, 0, 0.6); height: 20rem ">
                                    <div class="text-center">
                                        <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm">
                                    </div>
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Donasi</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Kemanusiaan 2022</h5>
                                        <a href="#!" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" data-interval="2000">
                            <div class="card border-0 bg-image" style="
                                    background-image: url('<?= base_url() ?>assets/img/banjir_bumbu.png');
                                    background-size:cover;
                                    background-position: center;
                                    background-repeat: no-repeat; height: 20rem;
                                        ">
                                <div class="mask" style="background-color: rgba(50, 0, 0, 0.6); height: 20rem ">
                                    <img src="<?= base_url() ?>assets/img/bm.png" height="120" class="p-3" alt="logobm" style="margin-left: 80px;">
                                    <div class="card-body text-center text-light">
                                        <h3 class="card-title text-center font-weight-bold text-uppercase ">Donasi</h3>
                                        <h5 class="card-title text-center font-weight-bold text-uppercase">Bencana 2022</h5>
                                        <a href="#!" class="btn btn-outline-light">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval3" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval3" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <br>
    </div>
    <header>
        <div class="p-3 text-center bg-image" style="
                background-image: url('<?= base_url() ?>assets/img/quran2.jpg');
                background-size:cover;
                background-position: center;
                background-repeat: no-repeat;
                /* height: 500px; */
            ">
            <div class="mask title" style="background-color: rgba(0, 0, 0, 0.6); ">
                <div class="d-flex me-5 ms-5 align-items-center">
                    <div class="text-white text-start">
                        <h3 class="mt-3">DONASI DAKWAH DAN KEMANUSIAAN</h3>
                        <p class="mb-3">
                            “Perumpamaan orang-orang yang menafkahkan hartanya di jalan Allah adalah serupa dengan
                            benih
                            yang menumbuhkan tujuh bulir, pada tiap-tiap bulir terdapat seratus biji. Dan Allah
                            melipatgandakan (ganjaran) bagi siapa saja yang Dia kehendaki. Dan Allah maha luas
                            (karunia-Nya) lagi maha mengetahui.”<br> (QS. Al-Baqarah [2]: 261)<br>
                            Berdasarkan dalil tersebut maka BONDOWOSO MENGAJI membantu kaum Muslimin dengan menerima
                            Donasi rutin tetap, Donasi dakwah, sedekah dan Infak dari kaum Muslimin melalui :<br>
                            No Rekening :<br> Bank Syariah Indonesia : 555-5100-053<br>
                            a.n. Bondowoso Mengaji<br>
                            Kode Bank 451<br>
                            Konfirmasi no WA : 0816591527

                        </p>

                    </div>
                </div>
            </div>
            <a class="btn btn-outline-light btn-lg mt-1" href="#" role="button">Selengkapnya</a>
        </div>
    </header>
    <main>
        <div class="container-fluid bg-transparent p-2" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
            <div class="card border-0" style="background: linear-gradient(
                                            45deg,
                                            rgba(55, 223, 197, 0.9),
                                            rgba(254, 255, 53, 0.7) 100%
                                            )">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-7">
                            <div class="bg-image hover-overlay ripple text-center">
                                <img src="<?= base_url() ?>assets/img/donasi3.png" class="img-fluid" />
                            </div>
                        </div>
                        <div class="col-sm-5 p-4">
                            <div class="card shadow text-dark title border-0" style="background: linear-gradient(
                                                    45deg,
                                                    rgba(55, 223, 197, 0.9),
                                                    rgba(254, 255, 53, 0.7) 100%
                                                    )">
                                <div class="card-body text-center">
                                    <h5>Dimohon untuk konfirmasi<br>dengan sertakan bukti transfer<br>melalui nomer WA :
                                    </h5>
                                </div>
                                <hr>
                                <ul class="list-group list-group-flush text-center">
                                    <li class="list-group-item bg-transparent fw-bold "><a href="https://wa.me/62816591527?text=Bismillah...%20Saya%20mau%20konfirmasi%20Donasi" target="_blank" style="text-decoration:none; color:black;"><img src="<?= base_url() ?>assets/img/WA.png" width="30">
                                            0816591527</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- <footer class="py-2 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; DIE Art'S Production 2022</div>
                </div>
            </div>
        </footer> -->
</div>