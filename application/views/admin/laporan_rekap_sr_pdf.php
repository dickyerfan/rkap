<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 40pt 20pt 40pt 50pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 8pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 9pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 8pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table td.left { text-align: left; }
        table.data-table tfoot td { font-weight: bold; background-color: #f8f9fa; border-top: 2px solid #6c757d; }
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
        <p class="title"><?= $title . ' ' .  $tahun + 1; ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama UPK</th>
                    <th>Total Potensi SR</th>
                    <th>Asumsi SR <?= $tahun; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_sr = 0;
                $total_asumsi = 0;
                foreach ($rekap_sr as $row) :
                    $total_sr += $row->total_sr;
                    $total_asumsi += $row->asumsi_sr;
                ?>
                    <tr>
                        <td class="center"><?= $no++; ?></td>
                        <td class="left"><?= htmlspecialchars(strtoupper($row->bagian_upk)); ?></td>
                        <td class="center"><?= number_format($row->total_sr, 0, ',', '.'); ?></td>
                        <td class="center"><?= number_format($row->asumsi_sr, 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">Total</th>
                    <th><?= number_format($total_sr, 0, ',', '.'); ?></th>
                    <th><?= number_format($total_asumsi, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>
