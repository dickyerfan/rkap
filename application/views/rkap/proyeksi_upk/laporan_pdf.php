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
                    <p>Rencana Kerja & Anggaran </p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <?php
        $bulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        ?>
        <p class="title"><?= $title ?></p>
        <p class="title">UPK <?= strtoupper($this->session->userdata('nama_pengguna'));  ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Indikator</th>
                    <?php foreach ($bulan as $b) : ?>
                        <th><?= $b ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $indikator_list = [
                    'sr_baru' => 'SR Baru',
                    'penutupan' => 'Penutupan',
                    'pencabutan' => 'Pencabutan',
                    'pembukaan' => 'Pembukaan',
                    'tera_meter' => 'Tera Meter',
                    'ganti_meter' => 'Ganti Meter',
                    'efi_tagih' => 'Efisiensi Penagihan'
                ];
                $no = 1;
                ?>
                <?php foreach ($indikator_list as $key => $label) : ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><?= $label ?></td>
                        <?php foreach ($bulan as $i => $b) : ?>
                            <?php
                            $nilai = 0;
                            foreach ($tampil as $row) {
                                if ($row->bulan == $i) {
                                    $nilai = $row->$key;
                                    break;
                                }
                            }
                            ?>
                            <td class="center">
                                <?php if ($key === 'efi_tagih') : ?>
                                    <?= number_format($nilai, 2, ',', '.') ?>
                                <?php else : ?>
                                    <?= number_format($nilai) ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>
