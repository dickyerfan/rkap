<?php
$raw = function ($kode) use ($lajur) {
    return isset($lajur[$kode]) ? (float)$lajur[$kode]["neraca_rkap"] : 0;
};
$gk = $this->Model_posisi_keuangan->getGrupKodes("laporan");
$aktiva_lancar = $gk["aktiva_lancar"];
$aktiva_pajak = $gk["aktiva_pajak"];
$aktiva_tetap = $gk["aktiva_tetap"];
$aktiva_lain = $gk["aktiva_lain"];
$liab_pendek = $gk["liabilitas_pendek"];
$liab_panjang = $gk["liabilitas_panjang"];
$ekuitas = $gk["ekuitas"];
$labelAktivaPajak = ["25.01.01" => "Aset Pajak Tangguhan"];
$labelAktivaTetap = ["31" => "Nilai Perolehan", "31.1" => "Akumulasi Penyusutan"];
$liab_rkD = 0;
foreach (array_merge($liab_pendek, $liab_panjang) as $kode) {
    if (isset($lajur[$kode])) $liab_rkD += (float)($lajur[$kode]["neraca_rkap_debit"] ?? 0);
}
$penyesuaian_tampil = 2 * $liab_rkD;
$liabVal = function ($kode) use ($raw) {
    return abs($raw($kode));
};
$ekVal = function ($kode) use ($raw, $penyesuaian_tampil) {
    $v = $raw($kode);
    return $kode === "70.06" ? $v - $penyesuaian_tampil : $v;
};
$isNol = function ($v) {
    return abs((float)$v) < 0.5;
};
$jml_al = array_sum(array_map($raw, $aktiva_lancar));
$jml_ap = array_sum(array_map($raw, $aktiva_pajak));
$jml_at = array_sum(array_map($raw, $aktiva_tetap));
$jml_aln = array_sum(array_map($raw, $aktiva_lain));
$total_aktiva = $jml_al + $jml_ap + $jml_at + $jml_aln;
$jml_lp = array_sum(array_map($liabVal, $liab_pendek));
$jml_ljp = array_sum(array_map($liabVal, $liab_panjang));
$jml_ek = array_sum(array_map($ekVal, $ekuitas));
$total_pasiva = $jml_lp + $jml_ljp + $jml_ek;
?>
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
            font-size: 10pt;
            font-weight: bold;
            margin: 6px 0;
            margin-top: 20px;
            margin-bottom: 20px;
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
            font-size: 8pt;
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

        .section {
            font-weight: bold;
        }

        td.subtotal,
        .subtotal td {
            font-weight: bold;
        }

        td.subtotal.num-bold {
            border-top: 2px solid #6c757d;
        }

        td.total,
        .total td {
            font-weight: bold;
            background-color: #e9ecef;
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
                    <p>Rencana Kerja &amp; Anggaran Tahun <?= $tahun; ?></p>
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
                    <th style="width: 38%;">URAIAN</th>
                    <th style="width: 12%;">PROYEKSI <?= $tahun ?> (Rp)</th>
                    <th style="width: 38%;">URAIAN</th>
                    <th style="width: 12%;">PROYEKSI <?= $tahun ?> (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $aktiva_rows = [];
                $aktiva_rows[] = ["ASET LANCAR", "", "header"];
                foreach ($aktiva_lancar as $kode) {
                    $nilai = (float)($lajur[$kode]["neraca_rkap"] ?? 0);
                    if ($isNol($nilai)) continue;
                    $aktiva_rows[] = [$lajur[$kode]["uraian"] ?? "", $nilai, 1];
                    if ($kode === "13.06") {
                        $aktiva_rows[] = ["Piutang Usaha Bersih", $raw("13") + $raw("13.06"), "subtotal"];
                    }
                }
                $aktiva_rows[] = ["Jumlah Aset Lancar", $jml_al, "subtotal"];
                $aktiva_rows[] = ["ASET PAJAK TANGGUHAN", "", "header"];
                foreach ($aktiva_pajak as $k) {
                    if ($isNol($raw($k))) continue;
                    $aktiva_rows[] = [$labelAktivaPajak[$k] ?? ($lajur[$k]["uraian"] ?? ""), $raw($k), 1];
                }
                if (count($aktiva_pajak) > 1) $aktiva_rows[] = ["Jumlah Aset Pajak Tangguhan", $jml_ap, "subtotal"];
                $aktiva_rows[] = ["ASET TETAP", "", "header"];
                foreach ($aktiva_tetap as $k) {
                    if ($isNol($raw($k))) continue;
                    $aktiva_rows[] = [$labelAktivaTetap[$k] ?? ($lajur[$k]["uraian"] ?? ""), $raw($k), 1];
                }
                $aktiva_rows[] = ["Nilai Buku", $jml_at, "subtotal"];
                $aktiva_rows[] = ["ASET LAIN-LAIN", "", "header"];
                foreach ($aktiva_lain as $kode) {
                    $nilai = (float)($lajur[$kode]["neraca_rkap"] ?? 0);
                    if ($isNol($nilai)) continue;
                    $aktiva_rows[] = [$lajur[$kode]["uraian"] ?? "", $nilai, 1];
                }
                $aktiva_rows[] = ["Jumlah Aset Lain-lain", $jml_aln, "subtotal"];
                $aktiva_rows[] = ["TOTAL ASET", $total_aktiva, "total"];

                $pasiva_rows = [];
                $pasiva_rows[] = ["KEWAJIBAN LANCAR", "", "header"];
                foreach ($liab_pendek as $kode) {
                    if ($isNol($liabVal($kode))) continue;
                    $pasiva_rows[] = [$lajur[$kode]["uraian"] ?? "", $liabVal($kode), 1];
                }
                $pasiva_rows[] = ["Jumlah Kewajiban Lancar", $jml_lp, "subtotal"];
                $pasiva_rows[] = ["KEWAJIBAN JANGKA PANJANG", "", "header"];
                foreach ($liab_panjang as $kode) {
                    if ($isNol($liabVal($kode))) continue;
                    $pasiva_rows[] = [$lajur[$kode]["uraian"] ?? "", $liabVal($kode), 1];
                }
                $pasiva_rows[] = ["Jumlah Kewajiban Jangka Panjang", $jml_ljp, "subtotal"];
                $pasiva_rows[] = ["Jumlah Kewajiban", $jml_lp + $jml_ljp, "subtotal"];
                $pasiva_rows[] = ["MODAL DAN CADANGAN", "", "header"];
                foreach ($ekuitas as $kode) {
                    $nilai = $ekVal($kode);
                    if ($isNol($nilai)) continue;
                    $pasiva_rows[] = [$lajur[$kode]["uraian"] ?? "", (float)$nilai, 1];
                }
                $pasiva_rows[] = ["Jumlah Modal dan Cadangan", $jml_ek, "subtotal"];
                $pasiva_rows[] = ["TOTAL MODAL & KEWAJIBAN", $total_pasiva, "total"];

                $max_rows = max(count($aktiva_rows), count($pasiva_rows));
                for ($i = 0; $i < $max_rows; $i++) {
                    $aktiva = $aktiva_rows[$i] ?? ["", -1, ""];
                    $pasiva = $pasiva_rows[$i] ?? ["", -1, ""];
                    echo "<tr>";
                    foreach ([$aktiva, $pasiva] as $row) {
                        $jenis = $row[2];
                        if ($jenis === "header") {
                            echo '<td class="section" colspan="2">' . $row[0] . '</td>';
                        } elseif ($jenis === "subtotal") {
                            echo '<td class="subtotal">' . $row[0] . '</td><td class="num-bold subtotal">' . (is_numeric($row[1]) ? number_format($row[1], 0, ',', '.') : '') . '</td>';
                        } elseif ($jenis === "total") {
                            echo '<td class="total">' . $row[0] . '</td><td class="num-bold total">' . (is_numeric($row[1]) ? number_format($row[1], 0, ',', '.') : '') . '</td>';
                        } elseif ($row[0] !== "") {
                            echo '<td>- ' . $row[0] . '</td><td class="num">' . (is_numeric($row[1]) && $row[1] != -1 ? number_format($row[1], 0, ',', '.') : '') . '</td>';
                        } else {
                            echo '<td></td><td></td>';
                        }
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- <p style="text-align: right; font-size: 8pt; margin-top: 20pt;">Bondowoso, <?= date('d F Y') ?></p>
        <p style="text-align: right; font-size: 8pt;">Direktur,<br><br><br>APRIL ARIESTHA BHIRAWA, SE</p> -->
    </main>
</body>

</html>