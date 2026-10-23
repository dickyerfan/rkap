<?php
$fields = ["neraca_2025", "proyeksi_des", "neraca_rkap"];
$years = [$tahun - 2, $tahun - 1, $tahun];
$raw = function ($kode, $f) use ($lajur) {
    return isset($lajur[$kode]) ? (float)($lajur[$kode][$f] ?? 0) : 0;
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
$liabVal = function ($kode, $f) use ($raw) {
    return abs($raw($kode, $f));
};
$ekVal = function ($kode, $f) use ($raw, $penyesuaian_tampil) {
    $v = $raw($kode, $f);
    return ($kode === "70.06" && $f === "neraca_rkap") ? $v - $penyesuaian_tampil : $v;
};
$fmt = function ($v) {
    return number_format($v, 0, ",", ".");
};
$fmtGrowth = function ($cur, $base) {
    if (!is_numeric($base) || $base == 0) return "-";
    $v = ($cur / $base - 1) * 100;
    return ($v > 0 ? "+" : "") . number_format($v, 2, ",", ".") . "%";
};
$semuaNol = function (array $nilai) {
    foreach ($nilai as $v) if (abs((float)$v) >= 0.5) return false;
    return true;
};
$total = [];
foreach ($fields as $f) {
    $al = 0;
    foreach ($aktiva_lancar as $k) $al += $raw($k, $f);
    $ap = 0;
    foreach ($aktiva_pajak as $k) $ap += $raw($k, $f);
    $at = 0;
    foreach ($aktiva_tetap as $k) $at += $raw($k, $f);
    $aln = 0;
    foreach ($aktiva_lain as $k) $aln += $raw($k, $f);
    $lp = 0;
    foreach ($liab_pendek as $k) $lp += $liabVal($k, $f);
    $ljp = 0;
    foreach ($liab_panjang as $k) $ljp += $liabVal($k, $f);
    $ek = 0;
    foreach ($ekuitas as $k) $ek += $ekVal($k, $f);
    $total[$f] = [
        "al" => $al,
        "ap" => $ap,
        "at" => $at,
        "aln" => $aln,
        "lp" => $lp,
        "ljp" => $ljp,
        "ek" => $ek,
        "A" => $al + $ap + $at + $aln,
        "LE" => $lp + $ljp + $ek,
    ];
}

$aktiva_rows = [];
$aktiva_rows[] = ["ASET LANCAR", [], "header"];
foreach ($aktiva_lancar as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $raw($k, $f);
    if ($semuaNol($v)) continue;
    $aktiva_rows[] = [$lajur[$k]["uraian"] ?? "", $v, 1];
    if ($k === "13.06") {
        $vb = [];
        foreach ($fields as $f) $vb[] = $raw("13", $f) + $raw("13.06", $f);
        $aktiva_rows[] = ["Piutang Usaha Bersih", $vb, "subtotal"];
    }
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["al"];
$aktiva_rows[] = ["Jumlah Aset Lancar", $v, "subtotal"];
$aktiva_rows[] = ["ASET PAJAK TANGGUHAN", [], "header"];
foreach ($aktiva_pajak as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $raw($k, $f);
    if ($semuaNol($v)) continue;
    $aktiva_rows[] = [$labelAktivaPajak[$k] ?? ($lajur[$k]["uraian"] ?? ""), $v, 1];
}
if (count($aktiva_pajak) > 1) {
    $v = [];
    foreach ($fields as $f) $v[] = $total[$f]["ap"];
    $aktiva_rows[] = ["Jumlah Aset Pajak Tangguhan", $v, "subtotal"];
}
$aktiva_rows[] = ["ASET TETAP", [], "header"];
foreach ($aktiva_tetap as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $raw($k, $f);
    if ($semuaNol($v)) continue;
    $aktiva_rows[] = [$labelAktivaTetap[$k] ?? ($lajur[$k]["uraian"] ?? ""), $v, 1];
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["at"];
$aktiva_rows[] = ["Nilai Buku", $v, "subtotal"];
$aktiva_rows[] = ["ASET LAIN-LAIN", [], "header"];
foreach ($aktiva_lain as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $raw($k, $f);
    if ($semuaNol($v)) continue;
    $aktiva_rows[] = [$lajur[$k]["uraian"] ?? "", $v, 1];
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["aln"];
$aktiva_rows[] = ["Jumlah Aset Lain-lain", $v, "subtotal"];
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["A"];
$aktiva_rows[] = ["TOTAL ASET", $v, "total"];

$pasiva_rows = [];
$pasiva_rows[] = ["KEWAJIBAN LANCAR", [], "header"];
foreach ($liab_pendek as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $liabVal($k, $f);
    if ($semuaNol($v)) continue;
    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", $v, 1];
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["lp"];
$pasiva_rows[] = ["Jumlah Kewajiban lancar", $v, "subtotal"];
$pasiva_rows[] = ["KEWAJIBAN JK PANJANG", [], "header"];
foreach ($liab_panjang as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $liabVal($k, $f);
    if ($semuaNol($v)) continue;
    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", $v, 1];
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["ljp"];
$pasiva_rows[] = ["Jumlah Kewajiban Jangka panjang", $v, "subtotal"];
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["lp"] + $total[$f]["ljp"];
$pasiva_rows[] = ["Jumlah Kewajiban", $v, "subtotal"];
$pasiva_rows[] = ["MODAL DAN CADANGAN", [], "header"];
foreach ($ekuitas as $k) {
    $v = [];
    foreach ($fields as $f) $v[] = $ekVal($k, $f);
    if ($semuaNol($v)) continue;
    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", $v, 1];
}
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["ek"];
$pasiva_rows[] = ["Jumlah Modal dan Cadangan", $v, "subtotal"];
$v = [];
foreach ($fields as $f) $v[] = $total[$f]["LE"];
$pasiva_rows[] = ["TOTAL MODAL & KEWAJIBAN", $v, "total"];

$theadHtml = function () use ($years) {
    echo '<thead>';
    echo '<tr>';
    echo '<th style="width: 34%;">URAIAN</th>';
    echo '<th style="width: 14%;">' . $years[0] . '<br>Realisasi</th>';
    echo '<th style="width: 14%;">' . $years[1] . '<br>Prognosis</th>';
    echo '<th style="width: 14%;">' . $years[2] . '<br>RKAP</th>';
    echo '<th style="width: 12%;">%<br>' . $years[1] . '/' . $years[0] . '</th>';
    echo '<th style="width: 12%;">%<br>' . $years[2] . '/' . $years[1] . '</th>';
    echo '</tr>';
    echo '</thead>';
};
$renderRows = function ($rows) use ($fmt, $fmtGrowth) {
    foreach ($rows as $r) {
        $type = $r[2];
        if ($type === "header") {
            echo '<tr><td class="section" colspan="6">' . $r[0] . '</td></tr>';
            continue;
        }
        if ($r[0] === "") {
            echo '<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            continue;
        }
        $bold = ($type === "subtotal" || $type === "total");
        $labelCls = $bold ? ($type === "total" ? ' class="total"' : ' class="subtotal"') : '';
        $valCls = $bold ? ($type === "total" ? ' class="num-bold total"' : ' class="num-bold subtotal"') : ' class="num"';
        echo '<tr>';
        echo '<td' . $labelCls . '>' . $r[0] . '</td>';
        $vals = (array)$r[1];
        foreach ($vals as $vv) {
            echo '<td' . $valCls . '>' . (is_numeric($vv) ? $fmt($vv) : '') . '</td>';
        }
        if (count($vals) >= 3) {
            echo '<td' . $valCls . '>' . $fmtGrowth($vals[1], $vals[0]) . '</td>';
            echo '<td' . $valCls . '>' . $fmtGrowth($vals[2], $vals[1]) . '</td>';
        } else {
            echo '<td></td><td></td>';
        }
        echo '</tr>';
    }
};
?>
<!DOCTYPE html>
<html lang="id">

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
        }

        .subtitle {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 4px 0 10px 0;
        }

        .section-label {
            font-size: 9pt;
            font-weight: bold;
            margin: 6px 0 4px 0;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: middle;
            font-size: 8pt;
        }

        table.data-table th {
            text-align: center;
            font-weight: bold;
            background-color: #e9ecef;
        }

        table.data-table td.num {
            text-align: right;
        }

        table.data-table td.num-bold {
            text-align: right;
            font-weight: bold;
        }

        .section {
            font-weight: bold;
        }

        td.subtotal,
        .subtotal td {
            font-weight: bold;
        }

        td.subtotal.num-bold {
            border-top: 1px solid #6c757d;
        }

        td.total,
        .total td {
            font-weight: bold;
            background-color: #e9ecef;
        }

        .page-break {
            page-break-after: always;
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
        <p class="title"><?= $title ?></p>
        <p class="subtitle">Realisasi <?= $years[0] ?> | Prognosis <?= $years[1] ?> | Proyeksi RKAP <?= $years[2] ?></p>
        <p class="section-label">ASET</p>
        <table class="data-table">
            <?php $theadHtml(); ?>
            <tbody>
                <?php $renderRows($aktiva_rows); ?>
            </tbody>
        </table>
        <div class="page-break"></div>
        <p class="title"><?= $title ?></p>
        <p class="subtitle">Realisasi <?= $years[0] ?> | Prognosis <?= $years[1] ?> | Proyeksi RKAP <?= $years[2] ?></p>
        <p class="section-label">KEWAJIBAN &amp; EKUITAS</p>
        <table class="data-table">
            <?php $theadHtml(); ?>
            <tbody>
                <?php $renderRows($pasiva_rows); ?>
            </tbody>
        </table>
    </main>
</body>

</html>
