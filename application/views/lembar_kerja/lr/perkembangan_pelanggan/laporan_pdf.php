<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RKAP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            margin: 20pt 20pt 30pt 80pt;
        }

        header table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        header td {
            border: none;
            padding: 2px;
            vertical-align: middle;
        }

        header p {
            margin: 0;
            font-size: 10pt;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        .title {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 6px 0;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
            font-size: 6.5pt;
        }

        table.data-table th {
            text-align: center;
            font-weight: bold;
        }

        table.data-table td.num {
            text-align: right;
        }

        table.data-table td.num-bold {
            text-align: right;
            font-weight: bold;
        }

        table.data-table td.center {
            text-align: center;
        }

        table.data-table tfoot td {
            font-weight: bold;
            background-color: #e9ecef;
            border-top: 2px solid #6c757d;
        }

        .bg-light { background-color: #f8f9fa; }
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
        <p class="title"><?= $title . ' ' . $tahun ?></p>
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
                <?php
                $no = 1;

                $map = [];
                if (!empty($data_pelanggan)) {
                    foreach ($data_pelanggan as $r) {
                        $k = isset($r['nama_kd']) ? trim($r['nama_kd']) : '';
                        $j = isset($r['nama_jp']) ? trim($r['nama_jp']) : '';
                        $m = isset($r['bulan']) ? (int)$r['bulan'] : 0;
                        $val = isset($r['jumlah']) ? (int)$r['jumlah'] : 0;
                        if ($k !== '' && $j !== '' && $m >= 1 && $m <= 12) {
                            $map[$k][$j][$m] = $val;
                        }
                    }
                }

                $kategori_list = isset($kategori_list) ? $kategori_list : [];
                $jenis_list = isset($jenis_list) ? $jenis_list : [];

                foreach ($kategori_list as $kategori) {
                    echo "<tr><td colspan='14' style='font-weight:bold;background-color:#f8f9fa;'>" . strtoupper(htmlspecialchars($kategori)) . "</td></tr>";

                    $totalKategori = array_fill(1, 12, 0);
                    $grandTotalKategori = 0;

                    foreach ($jenis_list as $jenis) {
                        echo "<tr>";
                        echo "<td style='text-align:left;'> - " . htmlspecialchars($jenis) . "</td>";

                        $jumlah = 0;
                        for ($b = 1; $b <= 12; $b++) {
                            $nilai = isset($map[$kategori][$jenis][$b]) ? (int)$map[$kategori][$jenis][$b] : 0;
                            echo "<td class='num'>" . number_format($nilai, 0, ',', '.') . "</td>";

                            if ($kategori === 'Sambungan Awal' || $kategori === 'Sambungan Akhir') {
                                $jumlah = $nilai;
                                $totalKategori[$b] += $nilai;
                            } else {
                                $jumlah += $nilai;
                                $totalKategori[$b] += $nilai;
                            }
                        }

                        echo "<td class='num-bold'>" . number_format($jumlah, 0, ',', '.') . "</td>";
                        echo "</tr>";

                        $grandTotalKategori += $jumlah;
                    }

                    echo "<tr style='font-weight:bold;background-color:#f8f9fa;'>";
                    echo "<td style='text-align:left;'>TOTAL " . strtoupper(htmlspecialchars($kategori)) . "</td>";
                    for ($b = 1; $b <= 12; $b++) {
                        echo "<td class='num'>" . number_format($totalKategori[$b], 0, ',', '.') . "</td>";
                    }
                    echo "<td class='num'>" . number_format($grandTotalKategori, 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>
