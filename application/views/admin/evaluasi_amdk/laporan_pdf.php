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
        <p class="title"><?= $title . ' ' .  date('Y') ?></p>
        <p class="title">UNIT <?= strtoupper($this->session->userdata('upk_bagian'));  ?></p>

        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">Uraian</th>
                    <th rowspan="2">Satuan</th>
                    <th colspan="2">S/D Juli <?= date('Y') ?></th>
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
                <tr>
                    <td style="padding-left:12px;">Jumlah Tenaga Kerja</td>
                    <td colspan="5"></td>
                </tr>
                <?php foreach ($tenaga_kerja as $row) :
                    $realisasi = $row->realisasi;
                    $rkap = $row->rkap;
                    $id = $row->id_evaluasi_amdk;
                    $naikTurun = $realisasi - $rkap;
                    $persen = $rkap != 0 ? ($naikTurun / $rkap) * 100 : 0;
                ?>
                    <tr>
                        <td style="padding-left:16px;">
                            <li><?= $row->uraian_evaluasi; ?></li>
                        </td>
                        <td class="center"><?= $row->satuan; ?></td>
                        <td class="center"><?= $row->rkap; ?></td>
                        <td class="center"><?= $row->realisasi; ?></td>
                        <td class="center"><?= $naikTurun; ?></td>
                        <td class="center"><?= $persen; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="padding-left:12px;">Nilai Produksi Usaha</td>
                    <td colspan="5"></td>
                </tr>
                <?php foreach ($produksi_usaha as $row) :
                    $realisasi = $row->realisasi;
                    $rkap = $row->rkap;
                    $id = $row->id_evaluasi_amdk;
                    $naikTurun = $realisasi - $rkap;
                    $persen = $rkap != 0 ? ($naikTurun / $rkap) * 100 : 0;
                ?>
                    <tr>
                        <td style="padding-left:16px;">
                            <li><?= $row->uraian_evaluasi; ?></li>
                        </td>
                        <td class="center"><?= $row->satuan; ?></td>
                        <td class="num"><?= $row->rkap; ?></td>
                        <td class="num"><?= $row->realisasi; ?></td>
                        <td class="num"><?= $naikTurun; ?></td>
                        <td class="center"><?= $persen; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td style="padding-left:12px;">Pendapatan Usaha</td>
                    <td colspan="5"></td>
                </tr>
                <?php foreach ($pendapatan_usaha as $row) :
                    $realisasi = $row->realisasi;
                    $rkap = $row->rkap;
                    $id = $row->id_evaluasi_amdk;
                    $naikTurun = $realisasi - $rkap;
                    $persen = $rkap != 0 ? ($naikTurun / $rkap) * 100 : 0;
                ?>
                    <tr>
                        <td style="padding-left:16px;">
                            <li><?= $row->uraian_evaluasi; ?></li>
                        </td>
                        <td class="center"><?= $row->satuan; ?></td>
                        <td class="num"><?= number_format($row->rkap, 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($row->realisasi, 0, ',', '.'); ?></td>
                        <td class="num"><?= number_format($naikTurun, 0, ',', '.'); ?></td>
                        <td class="center"><?= number_format($persen, 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Penjelasan pendapatan tahun <?= date('Y') ?> tidak mencapai target adalah :</p>
        <?php if (empty($target)) : ?>
            <p style="color:#dc3545;">Belum ada Penjelasan yang diinputkan.</p>
        <?php else : ?>
            <table>
                <tbody>
                    <?php foreach ($target as $row) : ?>
                        <tr>
                            <td width="92%" style="padding-left:16px;">
                                <li><?= $row->uraian_target; ?></li>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <p>Usulan program dalam rangka peningkatan pendapatan tahun <?= date('Y') + 1 ?></p>
        <p>Bidang Teknik</p>
        <?php if (empty($usulanTeknik)) : ?>
            <p style="color:#dc3545;">Belum ada usulan Teknik yang diinputkan.</p>
        <?php else : ?>
            <table>
                <tbody>
                    <?php foreach ($usulanTeknik as $row) : ?>
                        <tr>
                            <td width="92%" style="padding-left:16px;">
                                <li><?= $row->usulan_teknik; ?></li>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <p>Bidang Administrasi</p>
        <?php if (empty($usulanAdmin)) : ?>
            <p style="color:#dc3545;">Belum ada usulan administrasi yang diinputkan.</p>
        <?php else : ?>
            <table>
                <tbody>
                    <?php foreach ($usulanAdmin as $row) : ?>
                        <tr>
                            <td width="92%" style="padding-left:16px;">
                                <li><?= $row->usulan_admin; ?></li>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>