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
                    <?php foreach ($tahun as $row) :
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
                <div style="text-align:center;">
                    <p class="title"><?= $title . ' ' .  date('Y') ?></p>
                    <p class="title"><?= strtoupper($this->session->userdata('nama_pengguna'));  ?></p>
                </div>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th rowspan="2">Uraian</th>
                                    <th rowspan="2">Satuan</th>
                                    <th colspan="2">S/D Juni <?= date('Y') ?></th>
                                    <th colspan="2">Naik/Turun</th>
                                </tr>
                                <tr>

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


                                ?>
                                    <tr>
                                        <td style="padding-left:16px;"><?= $row->uraian_evaluasi ?></td>
                                        <td class="center"><?= $row->satuan ?></td>
                                        <td class="num"><?= number_format($row->rkap, 0, ',', '.')  ?></td>
                                        <td class="num"><?= number_format($row->realisasi, 0, ',', '.')  ?></td>
                                        <td class="num"><?= $naikTurun ?></td>
                                        <td class="num"><?= number_format($persen, 2, ',', '.') ?></td>

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
                                    <td style="padding-left:16px;">Pola Konsumsi</td>
                                    <td class="center">M3</td>
                                    <td class="num"><?= number_format($polaKonsumsiRkap, 1, ',', '.');  ?></td>
                                    <td class="num"><?= number_format($polaKonsumsiReal, 1, ',', '.');  ?></td>
                                    <td class="num"><?= number_format($naikTurunPola, 1, ',', '.');  ?></td>
                                    <td class="num"><?= number_format($persenPola, 2, ',', '.');  ?></td>
                                </tr>
                                <tr>
                                    <!-- <td>7</td> -->
                                    <td style="padding-left:16px;">Tarif rata-rata</td>
                                    <td class="center">Rp</td>
                                    <td class="num"><?= number_format($tarifRataRkap, 2, ',', '.'); ?></td>
                                    <td class="num"><?= number_format($tarifRataReal, 2, ',', '.'); ?></td>
                                    <td class="num"><?= number_format($naikTurunRata, 2, ',', '.'); ?></td>
                                    <td class="num"><?= number_format($persenRata, 2, ',', '.') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <div>
                        <p>Penjelasan pendapatan tahun <?= date('Y') ?> tidak mencapai target adalah :</p>
                        <?php if (empty($target)) : ?>
                            <p style="color:#dc3545;">Belum ada Penjelasan yang diinputkan.</p>
                        <?php else : ?>
                            <ul>
                                <?php foreach ($target as $row) : ?>
                                    <li style="padding-left:8px;"><?= $row->uraian_target; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p>Usulan program dalam rangka peningkatan pendapatan tahun <?= date('Y') + 1 ?></p>
                        <p>Bidang Teknik</p>
                        <?php if (empty($usulanTeknik)) : ?>
                            <p style="color:#dc3545;">Belum ada usulan Teknik yang diinputkan.</p>
                        <?php else : ?>
                            <ul>
                                <?php foreach ($usulanTeknik as $row) : ?>
                                    <li style="padding-left:8px;"><?= $row->usulan_teknik ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <p>Bidang Administrasi</p>
                        <?php if (empty($usulanAdmin)) : ?>
                            <p style="color:#dc3545;">Belum ada usulan administrasi yang diinputkan.</p>
                        <?php else : ?>
                                    <ul>
                                        <?php foreach ($usulanAdmin as $row) : ?>
                                            <li style="padding-left:8px;"><?= $row->usulan_admin ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                        <?php endif; ?>

                    </div>
    </main>

</body>

</html>