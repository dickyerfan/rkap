<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.8rem;
        }

        header p,
        .text-center p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        hr {
            height: 1px;
            background-color: black !important;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.8rem;
        }
    </style>

</head>

<body>
    <header>
        <div class="container-fluid">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td width="10%">
                            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid">
            <div class="card-body">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun; ?></p>
                        <p>UPK <?= strtoupper($namaUpk);  ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr class="text-center">
                                    <!-- <th>No</th> -->
                                    <th rowspan="2" class="align-middle">Uraian</th>
                                    <th rowspan="2" class="align-middle">Satuan</th>
                                    <th colspan="2">S/D Juli <?= $tahun; ?></th>
                                    <th colspan="2">Naik/Turun</th>
                                    <!-- <th rowspan="2" class="align-middle">Action</th> -->
                                </tr>
                                <tr class="text-center">
                                    <!-- <th>No</th> -->
                                    <th>RKAP</th>
                                    <th>Realisasi</th>
                                    <th>Satuan</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($plgBaru as $row) :
                                    $realisasi = $row->realisasi;
                                    $rkap = $row->rkap;
                                    $id = $row->id_evaluasi_upk;
                                    $naikTurun = $realisasi - $rkap;
                                    $persen = ($naikTurun / $rkap) * 100;
                                    // $persentase = abs($persen);

                                ?>
                                    <tr>
                                        <!-- <td><?= $no++ ?></td> -->
                                        <td class="ps-4"><?= $row->uraian_evaluasi ?></td>
                                        <td class="text-center"><?= $row->satuan ?></td>
                                        <td class="text-end pe-4"><?= number_format($row->rkap, 0, ',', '.')  ?></td>
                                        <td class="text-end pe-4"><?= number_format($row->realisasi, 0, ',', '.')  ?></td>
                                        <td class="text-end pe-4"><?= $naikTurun ?></td>
                                        <td class="text-center"><?= number_format($persen, 2, ',', '.') ?></td>
                                        <!-- <td class="text-center"><a href="<?= base_url('rkap/evaluasi_upk/edit_evaluasi_upk/') ?><?= $id ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                    </tr>
                                <?php endforeach; ?>
                                <?php
                                $airTerjualRkap = 0;  // Nilai default
                                $airTerjualRealisasi = 0;  // Nilai default
                                if (isset($airTerjual)) {
                                    foreach ($airTerjual as $row) {
                                        $airTerjualRkap = $row->rkap;
                                        $airTerjualRealisasi = $row->realisasi;
                                    }
                                }
                                $pendapatanAirRkap = 0; // Nilai default
                                $pendapatanAirRealisasi = 0; // Nilai default
                                if (isset($pendapatanAir)) {
                                    foreach ($pendapatanAir as $row) {
                                        $pendapatanAirRkap = $row->rkap;
                                        $pendapatanAirRealisasi = $row->realisasi;
                                    }
                                }

                                $lembarAirRkap = 0;  // Nilai default
                                $lembarAirRealisasi = 0;  // Nilai default
                                if (isset($lembarAir)) {
                                    foreach ($lembarAir as $row) {
                                        $lembarAirRkap = $row->rkap;
                                        $lembarAirRealisasi = $row->realisasi;
                                    }
                                }

                                $polaKonsumsiRkap = ($lembarAirRkap != 0) ? $airTerjualRkap / $lembarAirRkap : 0;
                                $tarifRataRkap = ($airTerjualRkap != 0) ? $pendapatanAirRkap / $airTerjualRkap : 0;

                                $polaKonsumsiReal = ($lembarAirRealisasi != 0) ? $airTerjualRealisasi / $lembarAirRealisasi : 0;
                                $tarifRataReal = ($airTerjualRealisasi != 0) ? $pendapatanAirRealisasi / $airTerjualRealisasi : 0;

                                $naikTurunPola = $polaKonsumsiReal - $polaKonsumsiRkap;
                                $persenPola = ($polaKonsumsiRkap != 0) ? ($naikTurunPola / $polaKonsumsiRkap) * 100 : 0;


                                $naikTurunRata = $tarifRataReal - $tarifRataRkap;
                                $persenRata = ($tarifRataRkap != 0) ? ($naikTurunRata / $tarifRataRkap) * 100 : 0;
                                ?>
                                <tr>
                                    <!-- <td>6</td> -->
                                    <td class="ps-4">Pola Konsumsi</td>
                                    <td class="text-center">M3</td>
                                    <td class="text-end pe-4"><?= number_format($polaKonsumsiRkap, 1, ',', '.');  ?></td>
                                    <td class="text-end pe-4"><?= number_format($polaKonsumsiReal, 1, ',', '.');  ?></td>
                                    <td class="text-end pe-4"><?= number_format($naikTurunPola, 1, ',', '.');  ?></td>
                                    <td class="text-center"><?= number_format($persenPola, 2, ',', '.');  ?></td>
                                </tr>
                                <tr>
                                    <!-- <td>7</td> -->
                                    <td class="ps-4">Tarif rata-rata</td>
                                    <td class="text-center">Rp</td>
                                    <td class="text-end pe-4"><?= number_format($tarifRataRkap, 2, ',', '.'); ?></td>
                                    <td class="text-end pe-4"><?= number_format($tarifRataReal, 2, ',', '.'); ?></td>
                                    <td class="text-end pe-4"><?= number_format($naikTurunRata, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($persenRata, 2, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Penjelasan pendapatan tahun <?= $tahun; ?> tidak mencapai target adalah :</p>
                        <?php if (empty($target)) : ?>
                            <p class="text-danger">Belum ada Penjelasan yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($target as $row) : ?>
                                        <tr>
                                            <td width="90%" class="ps-4">
                                                <li class="ps-2"><?= $row->uraian_target; ?></li>
                                            </td>
                                            <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_target_sr/' . $row->id_target) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Usulan program dalam rangka peningkatan pendapatan tahun <?= $tahun + 1 ?></p>
                        <p>Bidang Teknik :</p>
                        <?php if (empty($usulanTeknik)) : ?>
                            <p class="text-danger">Belum ada usulan Teknik yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($usulanTeknik as $row) : ?>
                                        <tr>
                                            <td width="90%" class="ps-4">
                                                <li class="ps-2"><?= $row->usulan_teknik ?></li>
                                            </td>
                                            <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_teknik/' . $row->id_usulanTeknik) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <p>Bidang Administrasi :</p>
                        <?php if (empty($usulanAdmin)) : ?>
                            <p class="text-danger">Belum ada usulan administrasi yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($usulanAdmin as $row) : ?>
                                        <tr>
                                            <td width="90%" class="ps-4">
                                                <li class="ps-2"><?= $row->usulan_admin ?></li>
                                            </td>
                                            <!-- <td><a href="<?= base_url('rkap/evaluasi_upk/edit_usulan_admin/' . $row->id_usulanAdmin) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>