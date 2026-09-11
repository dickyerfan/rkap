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
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= strtoupper($title) ?></p>
        <p class="title">UPK <?= strtoupper($namaUpk);  ?></p>
        <p class="title" style="text-transform:uppercase;">Data Riil <?= $tahun; ?></p>

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
            <table>
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
                    <tr style="font-weight:bold;">
                        <td>Air Yang Belum Dimanfaatkan/NRW</td>
                        <td>:</td>
                        <td><?= number_format($row->tk_bocor, 2, ',', '.'); ?></td>
                        <td>% (Persentase)</td>
                    </tr>
                    <tr>
                        <td>Jumlah Pelanggan Aktif (DRD Juni <?= $row->tahun_rkap ?>)</td>
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
                        <td>Pola Konsumsi rata2 (s/d Juni <?= $row->tahun_rkap ?>)</td>
                        <td>:</td>
                        <td><?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                        <td>M3 (Meter Kubik)</td>
                    </tr>
                </tbody>
            </table>
            <p class="title" style="text-transform:uppercase;">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></p>
            <table>
                <tbody>
                    <tr>
                        <td>Produksi air 1 tahun</td>
                        <td><?= number_format($row->kap_pro, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</td>
                        <td>:</td>
                        <td class="num"><?= number_format($produksi_air, 2, ',', '.');  ?></td>
                        <td>M3</td>
                    </tr>
                    <tr style="font-weight:bold;">
                        <td>Air Yang Belum Dimanfaatkan/NRW (....%)</td>
                        <td><?= number_format($row->tk_bocor, 2, ',', '.')  ?> %</td>
                        <td>:</td>
                        <td class="num"><?= number_format($kebocoran_air, 2, ',', '.'); ?></td>
                        <td>M3</td>
                    </tr>
                    <tr>
                        <td>Air yang didistribusikan ke pelanggan</td>
                        <td><?= number_format($produksi_air, 2, ',', '.') ?> - <?= number_format($kebocoran_air, 2, ',', '.') ?></td>
                        <td>:</td>
                        <td class="num"><?= number_format($air_pelanggan, 2, ',', '.'); ?></td>
                        <td>M3</td>
                    </tr>
                    <!-- <tr>
                        <td>Kebutuhan air</td>
                        <td><?= number_format($row->plg_aktif + $row->tambah_sr, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 2, ',', '.') ?></td>
                        <td>:</td>
                        <td class="text-end"><?= number_format($kebutuhan_air, 2, ',', '.'); ?></td>
                        <td>M3</td>
                    </tr> -->
                    <!-- <tr>
                        <td>Sisa Air</td>
                        <td><?= number_format($air_pelanggan, 2, ',', '.') ?> - <?= number_format($kebutuhan_air, 2, ',', '.') ?></td>
                        <td>:</td>
                        <td class="text-end"><?= number_format($sisa_air, 2, ',', '.'); ?></td>
                        <td>M3</td>
                    </tr>
                    <tr>
                        <td>Potensi penambahan pelanggan tahun <?= $row->tahun_rkap + 1 ?></td>
                        <td><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                        <td>:</td>
                        <td class="text-end"><?= number_format($potensi, 0, ',', '.')  ?></td>
                        <td>SR</td>
                    </tr> -->
                </tbody>
            </table>
            <p class="title" style="text-transform:uppercase;">Simulasi Potensi SR Jika NRW Dikurangi</p>
            <table class="data-table">
                <thead style="background-color:#f8f9fa;">
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
                            <td class="center"><?= $i ?>%</td>
                            <td class="center"><?= number_format($kebocoran_baru, 2, ',', '.') ?></td>
                            <td class="center"><?= number_format($sisa_air_baru, 0, ',', '.') ?></td>
                            <td class="center" style="font-weight:bold;"><?= number_format($potensi_sr_baru, 0, ',', '.') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endforeach; ?>

        <p>Keterangan :</p>
        <table>
            <tbody>
                <tr>
                    <td>1. Kemampuan Penambahan SR baru <?= $totalSr ?> SR</td>
                </tr>
                <tr>
                    <td>2. Pemetaan Lokasi : (Dijelaskan apabila dibutuhkan tambahan jaringan)</td>
                </tr>
            </tbody>
        </table>
        <table>
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

        <table>
            <tbody>
                <tr>
                    <td>3. Perlu adanya penambahan air baku :</td>
                </tr>
            </tbody>
        </table>
        <?php if (empty($airBaku)) : ?>
            <p style="color:#dc3545;">Belum ada Penambahan air baku yang diinputkan.</p>
        <?php else : ?>
            <table>
                <tbody>
                    <?php foreach ($airBaku as $row) : ?>
                        <tr>
                            <td width="90%" style="padding-left:16px;">
                                <li><?= $row->uraian ?></li>
                            </td>
                            <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_air_baku/' . $row->id_tambah_air_baku) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div style="margin: 20px 0;">
            <a style="font-weight:bold;color:#000;padding-right:8px;text-decoration:none;">Pilih Wilayah & Tahun</a>
            <form action="<?= base_url('admin/potensi_sr/export_pdf') ?>" method="post" target="_blank">
                <div style="display: flex; align-items: center;">
                    <select name="bagian_upk" style="width: 150px; margin-right: 10px;">
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
                    <select name="tahun_rkap" style="width: 100px;">
                        <?php
                        $mulai = date('Y') - 2;
                        for ($i = $mulai; $i < $mulai + 11; $i++) {
                            $sel = $i == date('Y') ? ' selected="selected"' : '';
                            echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                        }
                        ?>
                    </select>
                    <input type="submit" value="Tampilkan Data" style="margin-left: 10px;">
                </div>
            </form>
        </div>
    </main>
</body>

</html>