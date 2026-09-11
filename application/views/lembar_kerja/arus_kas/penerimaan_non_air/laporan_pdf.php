<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun ?></p>
        <?php
        // daftar uraian
        $pendapatan_non_air = [
            'Penerimaan Non Air' => [
                'Pendapatan Sambungan Baru' => ' - Pendapatan Sambungan Baru',
                'Pendapatan Pendaftaran' => ' - Pendapatan Pendaftaran',
                'Pendapatan Balik Nama' => ' - Pendapatan Balik Nama',
                'Pendapatan Penyambungan Kembali' => ' - Pendapatan Penyamb Kembali',
                'Pendapatan Denda' => ' - Pendapatan Denda',
                'Pendapatan Ganti Meter Rusak' => ' - Pendapatan Ganti Meter Rusak',
                'Pendapatan Penggatian Pipa Persil' => ' - Pendapatan Penggantian pipa persil',
                'Pendapatan Non Air Lainnya' => ' - Pendapatan Non Air lainnya',
            ]
        ];

        ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>URAIAN</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendapatan_non_air as $judul => $items) : ?>
                    <tr style="font-weight:bold;background-color:#e9ecef;">
                        <td><?= $judul; ?></td>
                        <td colspan="13"></td>
                    </tr>
                    <?php foreach ($items as $jenis => $label) : ?>
                        <tr>
                            <td><?= $label; ?></td>
                            <?php
                            $total_row = 0;
                            for ($i = 1; $i <= 12; $i++) :
                                $nilai = isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                                $total_row += $nilai;
                            ?>
                                <td class="num"><?= number_format($nilai, 0, ',', '.'); ?></td>
                            <?php endfor; ?>
                            <td class="num-bold"><?= number_format($total_row, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Jumlah per kelompok -->
                    <tr style="font-weight:bold;background-color:#e9ecef;">
                        <td>Jumlah <?= $judul; ?></td>
                        <?php
                        $total_per_bulan = [];
                        $grand_total = 0;
                        for ($i = 1; $i <= 12; $i++) {
                            $sum = 0;
                            foreach ($items as $jenis => $label) {
                                $sum += isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                            }
                            $total_per_bulan[$i] = $sum;
                            $grand_total += $sum;
                            echo '<td class="num">' . number_format($sum, 0, ',', '.') . '</td>';
                        }
                        ?>
                        <td class="num-bold"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>
