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
                            <?php foreach ($tahun as $row) :
                            ?>
                                <p>Rencana Kerja & Anggaran Tahun <?= $row->tahun_rkap + 1; ?></p>
                                <p>PDAM Kabupaten Bondowoso</p>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid px-2 mt-2">

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center mb-2">
                        <p><?= $title . ' ' .  date('Y') ?></p>
                        <p>UNIT <?= strtoupper($this->session->userdata('upk_bagian'));  ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">Uraian</th>
                                    <th rowspan="2" class="align-middle">Satuan</th>
                                    <th colspan="2">S/D Juli <?= date('Y') ?></th>
                                    <th colspan="2">Naik/Turun</th>
                                </tr>
                                <tr class="text-center">
                                    <th>RKAP</th>
                                    <th>Realisasi</th>
                                    <th>Satuan</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3">Jumlah Tenaga Kerja</td>
                                    <td colspan="5"></td>
                                </tr>
                                <?php foreach ($tenaga_kerja as $row) :
                                    $realisasi = $row->realisasi;
                                    $rkap = $row->rkap;
                                    $id = $row->id_evaluasi_amdk;
                                    $naikTurun = $realisasi - $rkap;
                                    $persen = ($naikTurun / $rkap) * 100;
                                ?>
                                    <tr>
                                        <td class="ps-4">
                                            <li><?= $row->uraian_evaluasi; ?></li>
                                        </td>
                                        <td class="text-center"><?= $row->satuan; ?></td>
                                        <td class="text-center"><?= $row->rkap; ?></td>
                                        <td class="text-center"><?= $row->realisasi; ?></td>
                                        <td class="text-center"><?= $naikTurun; ?></td>
                                        <td class="text-center"><?= $persen; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="ps-3">Nilai Piutang Usaha</td>
                                    <td colspan="5"></td>
                                </tr>
                                <?php foreach ($piutang_usaha as $row) :
                                    $realisasi = $row->realisasi;
                                    $rkap = $row->rkap;
                                    $id = $row->id_evaluasi_amdk;
                                    $naikTurun = $realisasi - $rkap;
                                    if ($naikTurun < 0) {
                                        $naikTurun = 0;
                                    }

                                    if ($rkap != 0) {
                                        $persen = ($naikTurun / $rkap) * 100;
                                    } else {
                                        $persen = 0; // Atau nilai default lainnya
                                    }
                                ?>
                                    <tr>
                                        <td class="ps-4">
                                            <li><?= $row->uraian_evaluasi; ?></li>
                                        </td>
                                        <td class="text-center"><?= $row->satuan; ?></td>
                                        <td class="text-end pe-2"><?= $row->rkap; ?></td>
                                        <td class="text-end pe-2"><?= $row->realisasi; ?></td>
                                        <td class="text-end pe-2"><?= $naikTurun; ?></td>
                                        <td class="text-end pe-2"><?= $persen; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="ps-3">Pendapatan Usaha</td>
                                    <td colspan="5"></td>
                                </tr>
                                <?php foreach ($pendapatan_usaha as $row) :
                                    $realisasi = $row->realisasi;
                                    $rkap = $row->rkap;
                                    $id = $row->id_evaluasi_amdk;
                                    if ($naikTurun < 0) {
                                        $naikTurun = 0;
                                    }

                                    if ($rkap != 0) {
                                        $persen = ($naikTurun / $rkap) * 100;
                                    } else {
                                        $persen = 0; // Atau nilai default lainnya
                                    }
                                ?>
                                    <tr>
                                        <td class="ps-4">
                                            <li><?= $row->uraian_evaluasi; ?></li>
                                        </td>
                                        <td class="text-center"><?= $row->satuan; ?></td>
                                        <td class="text-end pe-2"><?= number_format($row->rkap, 0, ',', '.'); ?></td>
                                        <td class="text-end pe-2"><?= number_format($row->realisasi, 0, ',', '.'); ?></td>
                                        <td class="text-end pe-2"><?= number_format($naikTurun, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= number_format($persen, 2, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <p>Penjelasan pendapatan tahun <?= date('Y') ?> tidak mencapai target adalah :</p>
                        <?php if (empty($target)) : ?>
                            <p class="text-danger">Belum ada Penjelasan yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($target as $row) : ?>
                                        <tr>
                                            <td width="92%" class="ps-4">
                                                <li><?= $row->uraian_target; ?></li>
                                            </td>
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
                        <p>Usulan program dalam rangka peningkatan pendapatan tahun <?= date('Y') + 1 ?></p>
                        <p>Bidang Teknik</p>
                        <?php if (empty($usulanTeknik)) : ?>
                            <p class="text-danger">Belum ada usulan Teknik yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($usulanTeknik as $row) : ?>
                                        <tr>
                                            <td width="92%" class="ps-4">
                                                <li><?= $row->usulan_teknik; ?></li>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <p>Bidang Administrasi</p>
                        <?php if (empty($usulanAdmin)) : ?>
                            <p class="text-danger">Belum ada usulan administrasi yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($usulanAdmin as $row) : ?>
                                        <tr>
                                            <td width="92%" class="ps-4">
                                                <li><?= $row->usulan_admin; ?></li>
                                            </td>
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