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

        header p,
        .text-center p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        .card-body p {
            margin: 0;
        }

        .judul {
            margin-bottom: 15px;
        }

        .estimasi {
            margin-bottom: 15px !important;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .keterangan {
            margin-bottom: 10px !important;
            font-size: 1rem;
            text-transform: uppercase;
        }

        hr {
            height: 2px;
            color: black !important;
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
                            <?php foreach ($tampil as $row) :
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
        <div class="container-fluid">
            <?php
            foreach ($tampil as $row) :
                $produksi_air = $row->kap_manf * $row->jam_op * 108;
                $kebocoran_air = $produksi_air * $row->tk_bocor / 100;
                $air_pelanggan = $produksi_air - $kebocoran_air;
                $kebutuhan_air = $row->pola_kon * ($row->plg_aktif + $row->tambah_sr);
                $sisa_air = $air_pelanggan - $kebutuhan_air;
                $potensi = $sisa_air / $row->pola_kon;

            ?>
                <div class="card-body">
                    <div class="row justify-content-center judul">
                        <div class="col-lg-6 text-center mb-2">
                            <p><?= strtoupper($title) ?></p>
                            <p>UPK <?= strtoupper($row->bagian_upk);  ?></p>
                            <p class="text-uppercase">Data Riil <?= $row->tahun_rkap ?></p>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Kapasitas Produksi</td>
                                        <td>:</td>
                                        <td><?= number_format($row->kap_pro, 2, ',', '.'); ?></td>
                                        <td>liter/detik</td>
                                    </tr>
                                    <tr>
                                        <td>Kapasitas yang Dimanfaatkan</td>
                                        <td>:</td>
                                        <td><?= number_format($row->kap_manf, 2, ',', '.'); ?></td>
                                        <td>liter/detik</td>
                                    </tr>
                                    <tr>
                                        <td>Jam Operasional</td>
                                        <td>:</td>
                                        <td><?= number_format($row->jam_op, 1, ',', '.'); ?></td>
                                        <td>jam/hari</td>
                                    </tr>
                                    <tr>
                                        <td>Tingkat Kebocoran</td>
                                        <td>:</td>
                                        <td><?= number_format($row->tk_bocor, 0, ',', '.'); ?></td>
                                        <td>% (Persentase)</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Pelanggan Aktif (DRD Juli <?= $row->tahun_rkap ?>)</td>
                                        <td>:</td>
                                        <td><?= number_format($row->plg_aktif, 0, ',', '.'); ?></td>
                                        <td>SR (Sambungan Rumah)</td>
                                    </tr>
                                    <tr>
                                        <td>Tambahan SR s/d akhir tahun <?= $row->tahun_rkap ?></td>
                                        <td>:</td>
                                        <td><?= number_format($row->tambah_sr, 0, ',', '.'); ?></td>
                                        <td>asumsi</td>
                                    </tr>
                                    <tr>
                                        <td>Pola Konsumsi rata2 (s/d Juli <?= $row->tahun_rkap ?>)</td>
                                        <td>:</td>
                                        <td><?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                        <td>M3 (Meter Kubik)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p class="text-center estimasi">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></p>
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Produksi air 1 tahun</td>
                                        <td><?= number_format($row->kap_manf, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($produksi_air, 2, ',', '.');  ?></td>
                                        <td>M3</td>
                                    </tr>
                                    <tr>
                                        <td>Kebocoran air (....%)</td>
                                        <td><?= number_format($row->tk_bocor, 0, ',', '.')  ?> %</td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($kebocoran_air, 2, ',', '.'); ?></td>
                                        <td>M3</td>
                                    </tr>
                                    <tr>
                                        <td>Air yang didistribusikan ke pelanggan</td>
                                        <td>-</td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($air_pelanggan, 2, ',', '.'); ?></td>
                                        <td>M3</td>
                                    </tr>
                                    <tr>
                                        <td>Kebutuhan air</td>
                                        <td><?= number_format($row->plg_aktif + $row->tambah_sr, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 2, ',', '.') ?></td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($kebutuhan_air, 2, ',', '.'); ?></td>
                                        <td>M3</td>
                                    </tr>
                                    <tr>
                                        <td>Sisa Air</td>
                                        <td>-</td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($sisa_air, 2, ',', '.'); ?></td>
                                        <td>M3</td>
                                    </tr>
                                    <tr>
                                        <td>Potensi penambahan pelanggan tahun 2024</td>
                                        <td><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                        <td>:</td>
                                        <td class="text-end"><?= number_format($potensi, 0, ',', '.')  ?></td>
                                        <td>SR</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <p class="keterangan">Keterangan :</p>
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>1. Kemampuan Penambahan SR baru <?= $totalSr ?> SR</td>
                                </tr>
                                <tr>
                                    <td>2. Pemetaan Lokasi : (Dijelaskan apabila dibutuhkan tambahan jaringan)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center px-3">
                    <div class="col-lg-9 ps-5">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach ($keterangan as $row) : ?>
                                    <tr>
                                        <td><?= $row->nama_wil ?></td>
                                        <td>:</td>
                                        <td><?= $row->jumlah_sr ?></td>
                                        <td>SR</td>
                                        <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_ket_potensi/' . $row->id_ket_potensi) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>3. Perlu adanya penambahan air baku :</td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if (empty($airBaku)) : ?>
                            <p class="text-danger">Belum ada Penambahan air baku yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($airBaku as $row) : ?>
                                        <tr>
                                            <td width="90%" class="ps-4">
                                                <li><?= $row->uraian ?></li>
                                            </td>
                                            <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_air_baku/' . $row->id_tambah_air_baku) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
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