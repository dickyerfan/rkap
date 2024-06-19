<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BM | <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/latar.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/select2/bootstrap.min.css" />
    <script src="<?= base_url(); ?>assets/js/jquery.js"></script>

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

        .judul {
            display: none;
        }

        @media print {

            .logo {
                display: none;
            }

            .font {
                font-size: 0.6rem;
                font-family: 'Arial';
            }
        }
    </style>
</head>

<body style="background: linear-gradient(
                                        45deg,
                                        rgba(55, 223, 197, 0.9),
                                        rgba(254, 255, 53, 0.9) 100%
                                        );">
    <?php
    if (isset($_GET['add_post'])) {
        $bln = $this->input->get('bulan', true);
        $tahun = $this->input->get('tahun', true);
    } else {
        $bln = date('m');
        $tahun = date('Y');
    }
    switch ($bln) {
        case '01':
            $bln = "Januari";
            break;
        case '02':
            $bln = "Februari";
            break;
        case '03':
            $bln = "Maret";
            break;
        case '04':
            $bln = "April";
            break;
        case '05':
            $bln = "Mei";
            break;
        case '06':
            $bln = "Juni";
            break;
        case '07':
            $bln = "Juli";
            break;
        case '08':
            $bln = "Agustus";
            break;
        case '09':
            $bln = "September";
            break;
        case '10':
            $bln = "Oktober";
            break;
        case '11':
            $bln = "Nofember";
            break;
        case '12':
            $bln = "Desember";
            break;
    }
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <button class="btn btn-warning btn-sm logo" id="pilih"><i class="fas fa-calendar-alt"></i> Pilih Waktu</button>
                <a href="<?= $url_cetak; ?>" target="_blank" class="btn btn-danger btn-sm logo"><i class="fas fa-file-alt"></i> Export PDF</a>
                <a href="<?= base_url('laporan') ?>" class="btn btn-primary btn-sm logo"><i class="fas fa-reply"></i> Kembali</a>
            </div>
        </div>
        <div class="row justify-content-end mb-1 mt-2" id="tanya" style="display:none ;">
            <div class="col-sm-4">
                <div class="card bg-light shadow text-center text-dark">
                    <div class="card-body">
                        <h3>Pilih Bulan & Tahun</h3>
                        <form action="<?= base_url() ?>laporan/pdf" method="GET">
                            <div class="form-group">
                                <?php $bulan = date('m'); ?>
                                <select name="bulan" class="form-select mb-1" required>
                                    <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
                                    <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
                                    <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
                                    <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
                                    <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
                                    <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
                                    <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
                                    <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                                    <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
                                    <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
                                    <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>Nofember</option>
                                    <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
                                </select>
                                <select name="tahun" class="form-select mb-1">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="add_post" id="tombol_pilih" class="btn btn-block btn-primary">Pilih</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive pb-2 pe-5 ps-5 pt-2">
            <img src="<?= base_url('assets/img/bm.png') ?>" alt="" class="float-start" style="width:100px; margin-left:50px;">
            <h5 class="text-center font title" style="margin-right:150px ;">LAPORAN KEUANGAN BONDOWOSO MENGAJI</h5>
            <h5 class="text-center font title" style="margin-right:150px ;">Bulan <?= $bln . '  ' . $tahun ?></h5>
            <table class="table table-bordered border-dark table-sm title" width="100%" cellspacing="0">
                <thead>
                    <tr class="font" style="background-color:white ;">
                        <th class=" text-center">No</th>
                        <th class=" text-center">Tanggal</th>
                        <th class=" text-center">Uraian</th>
                        <th class=" text-center">Penerimaan</th>
                        <th class=" text-center">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $no = 1;
                    foreach ($transaksi as $row) :
                    ?>
                        <?php
                        $tgls = strtotime($row->tanggal);
                        $day = date('d', $tgls);
                        $bln = date('m', $tgls);
                        $tahun = date('Y', $tgls);

                        switch ($bln) {
                            case '01':
                                $bln = "Januari";
                                break;
                            case '02':
                                $bln = "Februari";
                                break;
                            case '03':
                                $bln = "Maret";
                                break;
                            case '04':
                                $bln = "April";
                                break;
                            case '05':
                                $bln = "Mei";
                                break;
                            case '06':
                                $bln = "Juni";
                                break;
                            case '07':
                                $bln = "Juli";
                                break;
                            case '08':
                                $bln = "Agustus";
                                break;
                            case '09':
                                $bln = "September";
                                break;
                            case '10':
                                $bln = "Oktober";
                                break;
                            case '11':
                                $bln = "Nofember";
                                break;
                            case '12':
                                $bln = "Desember";
                                break;
                        }
                        ?>
                        <tr class="font" style="background-color:white ;">
                            <td class="text-center"><small><?= $no++ ?></small></td>
                            <td class="text-center"><?= $day . ' ' . $bln . ' ' . $tahun ?></td>
                            <td><?= $row->uraian ?></td>
                            <td class="text-end"><?= $row->jenis_transaksi == 'penerimaan' ? number_format($row->rupiah, '0', ',', '.') . ',-' : ' ' ?></td>
                            <td class="text-end"><?= $row->jenis_transaksi == 'pengeluaran' ? number_format($row->rupiah, '0', ',', '.') . ',-' : ' ' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font" style="background-color:white ;">
                        <th colspan="3" class="text-center">Total</th>
                        <th class="text-end"><?= number_format($totalMasuk, 0, ',', '.') ?>,-</th>
                        <th class="text-end"><?= number_format($totalKeluar, 0, ',', '.') ?>,-</th>
                    </tr>
                    <tr class="font" style="background-color:white ;">
                        <th colspan="3" class="text-center">Saldo Akhir</th>
                        <th colspan="2" class="text-end"><?= number_format($saldo, 0, ',', '.') ?>,-</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script>
        const pilih = document.getElementById('pilih');
        const tanya = document.getElementById('tanya');
        const tombolPilih = document.getElementById('tombol_pilih');
        const cetak = document.getElementById('cetak');

        pilih.addEventListener('click', function() {
            if (tanya.style.display == "none") {
                tanya.style.display = "block";
            }
        });
        tombolPilih.addEventListener('click', function() {
            if (tanya.style.display == "block") {
                tanya.style.display = "none";
            }
        });

        cetak.addEventListener('click', function() {
            window.print();
        })
    </script>
</body>

</html>