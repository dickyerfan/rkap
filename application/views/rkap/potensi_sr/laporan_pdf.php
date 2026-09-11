<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 20pt 20pt 30pt 80pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 10pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 9pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 6.5pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.num { text-align: right; }
        table.data-table td.num-bold { text-align: right; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table tfoot td { font-weight: bold; background-color: #e9ecef; border-top: 2px solid #6c757d; }

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

        .table-simulasi {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }

        .table-simulasi th,
        .table-simulasi td {
            border: 1px solid black;
            padding: 4px 8px;
            text-align: center;
        }

        .table-simulasi thead tr {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .table-simulasi td.bold {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <header>
        <table>
            <tr>
                <td width="40">
                    <?php
                    $logo_path = FCPATH . 'assets/img/tirta.png';
                    if (file_exists($logo_path)) :
                        $logo_data = base64_encode(file_get_contents($logo_path));
                        $logo_mime = mime_content_type($logo_path);
                    ?>
                        <img src="data:<?= $logo_mime; ?>;base64,<?= $logo_data; ?>" alt="Logo" width="40">
                    <?php endif; ?>
                </td>
                <td>
                    <?php foreach ($tampil as $row) :
                    ?>
                        <p>Rencana Kerja & Anggaran Tahun <?= $row->tahun_rkap + 1; ?></p>
                        <p>Perumdam Ijen Tirta Bondowoso</p>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <?php
        foreach ($tampil as $row) :
            $produksi_air = $row->kap_pro * $row->jam_op * 108;
            // $kebocoran_air = $produksi_air * $row->tk_bocor / 100;
            $pelanggan_aktif = $row->plg_aktif;
            $pola_kon = $row->pola_kon;
            $kap_manf = $pelanggan_aktif * $pola_kon;
            $kebocoran_air_persen = $row->tk_bocor;
            $kebocoran_air = $produksi_air * $kebocoran_air_persen / 100;

            $air_pelanggan = $produksi_air - $kebocoran_air;
            $kebutuhan_air = $row->pola_kon * $row->plg_aktif;
            $sisa_air = $air_pelanggan - $kebutuhan_air;
            if ($row->pola_kon != 0) {
                $potensi = $sisa_air / $row->pola_kon;
            } else {
                $potensi = 0;
            }

        ?>
            <div class="judul">
                <p class="title"><?= strtoupper($title) ?></p>
                <p class="title">UPK <?= strtoupper($row->bagian_upk);  ?></p>
                <p class="title" style="text-transform:uppercase;">Data Riil <?= $row->tahun_rkap ?></p>
            </div>

            <table style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td style="border:none; padding:2px;">Kapasitas Produksi</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->kap_pro, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">liter/detik</td>
                    </tr>
                    <!-- <tr>
                        <td style="border:none; padding:2px;">Kapasitas yang Dimanfaatkan</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->kap_manf, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">liter/detik</td>
                    </tr> -->
                    <tr>
                        <td style="border:none; padding:2px;">Jam Operasional</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->jam_op, 1, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">jam/hari</td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td style="border:none; padding:2px;">Air Yang Belum Dimanfaatkan/NRW</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->tk_bocor, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">% (Persentase)</td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px;">Jumlah Pelanggan Aktif (DRD Juli <?= $row->tahun_rkap ?>)</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->plg_aktif, 0, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">SR (Sambungan Rumah)</td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px;">Tambahan SR s/d akhir tahun <?= $row->tahun_rkap ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->tambah_sr, 0, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">asumsi</td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px;">Pola Konsumsi rata2 (s/d Juli <?= $row->tahun_rkap ?>)</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">M3 (Meter Kubik)</td>
                    </tr>
                </tbody>
            </table>
            <p class="estimasi" style="text-align:center;">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></p>
            <table style="width:100%; border-collapse:collapse;">
                <tbody>
                    <tr>
                        <td style="border:none; padding:2px;">Produksi air 1 tahun</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->kap_pro, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($produksi_air, 2, ',', '.');  ?></td>
                        <td style="border:none; padding:2px;">M3</td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td style="border:none; padding:2px;">Air Yang Belum Dimanfaatkan/NRW (....%)</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->tk_bocor, 2, ',', '.')  ?> %</td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($kebocoran_air, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">M3</td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px;">Air yang didistribusikan ke pelanggan</td>
                        <td style="border:none; padding:2px;"><?= number_format($produksi_air, 2, ',', '.') ?> - <?= number_format($kebocoran_air, 2, ',', '.') ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($air_pelanggan, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">M3</td>
                    </tr>
                    <!-- <tr>
                        <td style="border:none; padding:2px;">Kebutuhan air</td>
                        <td style="border:none; padding:2px;"><?= number_format($row->plg_aktif, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 2, ',', '.') ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($kebutuhan_air, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">M3</td>
                    </tr> -->
                    <!-- <tr>
                        <td style="border:none; padding:2px;">Sisa Air</td>
                        <td style="border:none; padding:2px;"><?= number_format($air_pelanggan, 2, ',', '.') ?> - <?= number_format($kebutuhan_air, 2, ',', '.') ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($sisa_air, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">M3</td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:2px;">Potensi penambahan pelanggan tahun 2024</td>
                        <td style="border:none; padding:2px;"><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td class="num"><?= number_format($potensi, 0, ',', '.')  ?></td>
                        <td style="border:none; padding:2px;">SR</td>
                    </tr> -->
                </tbody>
            </table>
        <?php endforeach; ?>
        <p class="title" style="margin-top:16px;">Simulasi Potensi SR Jika NRW Dikurangi</p>
        <table class="table-simulasi">
            <thead>
                <tr>
                    <th>Pemanfaatan Baru/Penurunan NRW</th>
                    <th>Sisa belum di manfaatkan (%)</th>
                    <th>Kebutuhan Air Baku</th>
                    <th>Potensi SR Tambahan</th>
                </tr>
            </thead>
            <tbody>
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
                        <td class="bold"><?= number_format($potensi_sr_baru, 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <p class="keterangan">Keterangan :</p>
        <table style="width:100%; border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="border:none; padding:2px;">1. Kemampuan Penambahan SR baru <?= $totalSr ?> SR</td>
                </tr>
                <tr>
                    <td style="border:none; padding:2px;">2. Pemetaan Lokasi : (Dijelaskan apabila dibutuhkan tambahan jaringan)</td>
                </tr>
            </tbody>
        </table>
        <table style="width:100%; border-collapse:collapse; margin-left:20px;">
            <tbody>
                <?php foreach ($keterangan as $row) : ?>
                    <tr>
                        <td style="border:none; padding:2px;"><?= $row->nama_wil ?></td>
                        <td style="border:none; padding:2px;">:</td>
                        <td style="border:none; padding:2px;"><?= $row->jumlah_sr ?></td>
                        <td style="border:none; padding:2px;">SR</td>
                        <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_ket_potensi/' . $row->id_ket_potensi) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <table style="width:100%; border-collapse:collapse;">
            <tbody>
                <tr>
                    <td style="border:none; padding:2px;">3. Perlu adanya penambahan air baku :</td>
                </tr>
            </tbody>
        </table>
        <?php if (empty($airBaku)) : ?>
            <p style="color:#dc3545;">Belum ada Penambahan air baku yang diinputkan.</p>
        <?php else : ?>
            <table style="width:100%; border-collapse:collapse;">
                <tbody>
                    <?php foreach ($airBaku as $row) : ?>
                        <tr>
                            <td width="90%" style="border:none; padding:2px; padding-left:16px;">
                                <li><?= $row->uraian ?></li>
                            </td>
                            <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_air_baku/' . $row->id_tambah_air_baku) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>

</body>

</html>
