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
                <td><p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p><p>Perumdam Ijen Tirta Bondowoso</p></td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun; ?></p>
        <?php
        $map_bulan = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        // kelompokkan berdasarkan parent kode
        $grouped = [];
        foreach ($biaya as $r) {
            // ambil parent prefix 3 segmen, misalnya "98.02.04"
            $parts = explode('.', $r['kode']);
            $parent = implode('.', array_slice($parts, 0, 3));
            $grouped[$parent]['children'][] = $r;

            // total per parent
            foreach ($map_bulan as $b => $nama_bulan) {
                if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                    $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                }
                $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
            }
            $grouped[$parent]['subtotal']['total_tahun'] =
                ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
        }

        // ambil nama parent dari tabel no_per jika perlu, sementara kita ambil prefix
        ?>
        <table class="data-table">
            <thead class="center">
                <tr>
                    <th colspan="2">PERKIRAAN</th>
                    <th rowspan="2">U R A I A N</th>
                    <th colspan="12">B U L A N</th>
                    <th rowspan="2">JUMLAH</th>
                </tr>
                <tr>
                    <th>KODE</th>
                    <th>NAMA</th>
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
                </tr>
            </thead>
            <tbody>
                <?php
                $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                $total_semua = 0;

                foreach ($grouped as $parent => $data_parent) :
                    // ambil nama parent
                    $parent_name = $this->db
                        ->select('name')
                        ->where('kode', $parent)
                        ->get('no_per')
                        ->row('name') ?? 'Kelompok ' . $parent;
                ?>
                    <!-- Header parent -->
                    <tr style="background-color:#e9ecef;font-weight:bold;">
                        <td><?= $parent ?></td>
                        <td colspan="15"><?= strtoupper($parent_name) ?></td>
                    </tr>

                    <!-- Children -->
                    <?php foreach ($data_parent['children'] as $child) : ?>
                        <tr>
                            <td><?= $child['kode'] ?></td>
                            <td><?= $child['name'] ?></td>
                            <td><?= $child['uraian'] ?></td>
                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                <td class="num"><?= number_format($child[$nama_bulan], 0, ',', '.') ?></td>
                            <?php endforeach; ?>
                            <td class="num" style="font-weight:bold;"><?= number_format($child['total_tahun'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>

                    <!-- Subtotal per parent -->
                    <tr style="background-color:#f8f9fa;font-weight:bold;">
                        <td colspan="3" style="text-align:left;">JUMLAH <?= strtoupper($parent_name) ?></td>
                        <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                            <td class="num">
                                <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num">
                            <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php
                    // akumulasi total seluruh AMDK
                    foreach ($map_bulan as $b => $nama_bulan) {
                        $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                    }
                    $total_semua += $data_parent['subtotal']['total_tahun'];
                endforeach;
                ?>

                <!-- TOTAL AKHIR -->
                <tr style="background-color:#cce5ff;font-weight:bold;">
                    <td colspan="3" style="text-align:left;">TOTAL BIAYA AMDK</td>
                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                        <td class="num"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num"><?= number_format($total_semua, 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>