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
        <p class="title"><?= $title . ' ' .  $tahun; ?></p>
        <table class="data-table">
            <thead style="background-color:#e9ecef;">
                <tr>
                    <th rowspan="2">URAIAN</th>
                    <th colspan="12">BULAN</th>
                    <th rowspan="2">JUMLAH</th>
                </tr>
                <tr>
                    <th>JAN</th>
                    <th>FEB</th>
                    <th>MAR</th>
                    <th>APR</th>
                    <th>MEI</th>
                    <th>JUN</th>
                    <th>JUL</th>
                    <th>AGS</th>
                    <th>SEP</th>
                    <th>OKT</th>
                    <th>NOV</th>
                    <th>DES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_tahunan = 0;
                $kategori_grup = '';
                $subtotal = array_fill_keys(['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'total'], 0);
                $grandtotal = $subtotal;

                foreach ($rekap as $r) :
                    // Jika kategori berubah, cetak subtotal
                    if ($kategori_grup != '' && $kategori_grup != $r->kategori) :
                        echo "<tr style='font-weight:bold;background-color:#fff3cd;'>
                                <td>Subtotal {$kategori_grup}</td>";
                        foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                            echo "<td class='num'>" . number_format($subtotal[$b], 0, ',', '.') . "</td>";
                        echo "<td class='num'>" . number_format($subtotal['total'], 0, ',', '.') . "</td></tr>";

                        $subtotal = array_fill_keys(array_keys($subtotal), 0);
                    endif;

                    // Jika kategori baru
                    if ($kategori_grup != $r->kategori) :
                        echo "<tr style='font-weight:bold;background-color:#cff4fc;'><td colspan='14'>{$r->kategori}</td></tr>";
                        $kategori_grup = $r->kategori;
                    endif;
                    $bagian = strtoupper($r->bagian);
                    // Baris data
                    echo "<tr>
                                                    <td> $bagian</td>
                                                    <td class='num'>" . number_format($r->jan, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->feb, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->mar, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->apr, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->mei, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->jun, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->jul, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->agu, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->sep, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->okt, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->nov, 0, ',', '.') . "</td>
                                                    <td class='num'>" . number_format($r->des, 0, ',', '.') . "</td>
                                                    <td class='num-bold'>" . number_format($r->total_tahun, 0, ',', '.') . "</td>
                                                </tr>";

                    // Tambah subtotal
                    foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                        $subtotal[$b] += $r->$b;
                    $subtotal['total'] += $r->total_tahun;

                    foreach ($subtotal as $b => $v) $grandtotal[$b] += $r->$b ?? 0;
                    $grandtotal['total'] += $r->total_tahun;
                endforeach;

                // Subtotal terakhir
                if ($kategori_grup != '') :
                    echo "<tr style='font-weight:bold;background-color:#fff3cd;'>
                                                    <td>Subtotal {$kategori_grup}</td>";
                    foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                        echo "<td class='num'>" . number_format($subtotal[$b], 0, ',', '.') . "</td>";
                    echo "<td class='num'>" . number_format($subtotal['total'], 0, ',', '.') . "</td></tr>";
                endif;

                // Total keseluruhan
                echo "<tr style='font-weight:bold;background-color:#f8d7da;'>
                                                <td>TOTAL BIAYA PEGAWAI</td>";
                foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                    echo "<td class='num'>" . number_format($grandtotal[$b], 0, ',', '.') . "</td>";
                echo "<td class='num'>" . number_format($grandtotal['total'], 0, ',', '.') . "</td></tr>";
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>
