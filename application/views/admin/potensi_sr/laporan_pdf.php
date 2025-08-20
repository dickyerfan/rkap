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
                        <p><?= strtoupper($title) ?></p>
                        <p>UPK <?= strtoupper($namaUpk);  ?></p>
                        <p class="text-uppercase">Data Riil <?= $tahun; ?></p>
                    </div>
                </div>
                <?php
                foreach ($tampil as $row) : ?>
                    <?php
                    $produksi_air = $row->kap_pro * $row->jam_op * 108;
                    $pelanggan_aktif = $row->plg_aktif;
                    $pola_kon = $row->pola_kon;
                    $kap_manf = $pelanggan_aktif * $pola_kon;
                    $kebocoran_air_persen = $row->tk_bocor;
                    $kebocoran_air = $produksi_air * $kebocoran_air_persen / 100;

                    $air_pelanggan = $produksi_air - $kebocoran_air;
                    $kebutuhan_air = $row->pola_kon * ($row->plg_aktif);
                    $sisa_air = $air_pelanggan - $kebutuhan_air;
                    $potensi = $sisa_air / $row->pola_kon;
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Kapasitas Produksi</td>
                                        <td>:</td>
                                        <td><?= number_format($row->kap_pro, 2, ',', '.'); ?></td>
                                        <td>liter/detik</td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Kapasitas yang Dimanfaatkan</td>
                                        <td>:</td>
                                        <td><?= number_format($row->kap_manf, 2, ',', '.'); ?></td>
                                        <td>liter/detik</td>
                                    </tr> -->
                                    <tr>
                                        <td>Jam Operasional</td>
                                        <td>:</td>
                                        <td><?= number_format($row->jam_op, 1, ',', '.'); ?></td>
                                        <td>jam/hari</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Tingkat Kebocoran</td>
                                        <td>:</td>
                                        <td><?= number_format($row->tk_bocor, 2, ',', '.'); ?></td>
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
                    <p class="text-center text-uppercase">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></p>
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
                                    <tr class="fw-bold">
                                        <td>Kebocoran air (....%)</td>
                                        <td><?= number_format($row->tk_bocor, 2, ',', '.')  ?> %</td>
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
                    <p class="text-center text-uppercase">Simulasi Potensi SR Jika Kebocoran Dikurangi</p>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <table class="table table-sm table-bordered tableUtama">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Pengurangan Kebocoran</th>
                                        <th>Kebocoran Baru (%)</th>
                                        <th>Kebutuhan Air Baku</th>
                                        <th>Potensi SR Tambahan</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    for ($i = 1; $i <= 15; $i++) {
                                        // Hitung kebocoran baru
                                        $kebocoran_baru = $row->tk_bocor - $i;
                                        // Air pelanggan baru jika kebocoran turun
                                        $air_pelanggan_baru = $produksi_air * (1 - $kebocoran_baru / 100);
                                        // Sisa air setelah kebutuhan saat ini
                                        $sisa_air_baru = $air_pelanggan_baru - $kebutuhan_air;
                                        // Potensi SR baru
                                        $potensi_sr_baru = ($sisa_air_baru > 0) ? $sisa_air_baru / $row->pola_kon : 0;
                                    ?>
                                        <tr>
                                            <td><?= $i ?>%</td>
                                            <td><?= number_format($kebocoran_baru, 2, ',', '.') ?></td>
                                            <td><?= number_format($sisa_air_baru, 0, ',', '.') ?></td>
                                            <td class="fw-bold"><?= number_format($potensi_sr_baru, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-9">
                            <p>Keterangan :</p>
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
                    <div class="row justify-content-center">
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
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="<?= base_url('admin/potensi_sr/export_pdf') ?>" method="post" target="_blank">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="bondowoso">Bondowoso</option>
                                    <option value="sukosari1">Sukosari 1</option>
                                    <option value="maesan">Maesan</option>
                                    <option value="tegalampel">Tegalampel</option>
                                    <option value="tapen">Tapen</option>
                                    <option value="prajekan">Prajekan</option>
                                    <option value="tlogosari">Tlogosari</option>
                                    <option value="wringin">Wringin</option>
                                    <option value="curahdami">Curahdami</option>
                                    <option value="tamanan">Tamanan</option>
                                    <option value="tenggarang">Tenggarang</option>
                                    <option value="tamankrocok">Tamankrocok</option>
                                    <option value="wonosari">Wonosari</option>
                                    <option value="klabang">Klabang</option>
                                    <option value="sukosari2">Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button" data-bs-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>