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
?>
<?php if ($this->session->userdata('level') != 'Admin') redirect('auth'); ?>
<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="p-2"><?= $this->session->flashdata('info'); ?></div>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/neraca/komparasi') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = date('Y') - 3; $i <= date('Y') + 3; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/komparasi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/neraca/export_pdf_komparasi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan <?= $tahun ?></button></a>
                            <?php if ($this->session->userdata("level") == 'Admin') : ?>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/neraca_lajur?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Neraca Lajur</button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_growth?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Input Neraca Awal</button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Master Akun</button></a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?></h5>
                            <div class="fw-bold mb-3" style="font-size:1.2rem;">Realisasi <?= $years[0] ?> | Prognosis <?= $years[1] ?> | Proyeksi RKAP <?= $years[2] ?></div>
                        </div>
                    </div>
                    <?php $this->load->view('lembar_kerja/neraca/partial/indikator_balance', ["indikatorFields" => array_combine($fields, $years)]); ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size:0.66rem;">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th style="width:16%;">URAIAN</th>
                                    <th style="width:8%;"><?= $years[0] ?><br><span style="font-weight:normal;font-size:0.58rem;">Realisasi</span></th>
                                    <th style="width:8%;"><?= $years[1] ?><br><span style="font-weight:normal;font-size:0.58rem;">Prognosis</span></th>
                                    <th style="width:8%;"><?= $years[2] ?><br><span style="font-weight:normal;font-size:0.58rem;">RKAP</span></th>
                                    <th style="width:5%;">%<br><span style="font-weight:normal;font-size:0.58rem;"><?= $years[1] ?>/<?= $years[0] ?></span></th>
                                    <th style="width:5%;">%<br><span style="font-weight:normal;font-size:0.58rem;"><?= $years[2] ?>/<?= $years[1] ?></span></th>
                                    <th style="width:16%;">URAIAN</th>
                                    <th style="width:8%;"><?= $years[0] ?><br><span style="font-weight:normal;font-size:0.58rem;">Realisasi</span></th>
                                    <th style="width:8%;"><?= $years[1] ?><br><span style="font-weight:normal;font-size:0.58rem;">Prognosis</span></th>
                                    <th style="width:8%;"><?= $years[2] ?><br><span style="font-weight:normal;font-size:0.58rem;">RKAP</span></th>
                                    <th style="width:5%;">%<br><span style="font-weight:normal;font-size:0.58rem;"><?= $years[1] ?>/<?= $years[0] ?></span></th>
                                    <th style="width:5%;">%<br><span style="font-weight:normal;font-size:0.58rem;"><?= $years[2] ?>/<?= $years[1] ?></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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

                                $maxRows = max(count($aktiva_rows), count($pasiva_rows));
                                $renderCells = function ($r) use ($fmt, $fmtGrowth) {
                                    $type = $r[2];
                                    if ($type === "header") {
                                        echo '<td class="fw-bold" colspan=6>' . $r[0] . '</td>';
                                        return;
                                    }
                                    if ($r[0] === "") {
                                        echo '<td></td><td></td><td></td><td></td><td></td><td></td>';
                                        return;
                                    }
                                    $bold = ($type === "subtotal" || $type === "total");
                                    $tdCls = $bold ? ' class="fw-bold"' : '';
                                    $valCls = $bold ? ($type === "total" ? ' class="text-end fw-bold table-light"' : ' class="text-end fw-bold border-top"') : ' class="text-end"';
                                    echo '<td' . $tdCls . (($type === "total") ? ' style="background:#e9ecef"' : '') . '>' . (($type === "total") ? '<b>' . $r[0] . '</b>' : $r[0]) . '</td>';
                                    $vals = (array)$r[1];
                                    foreach ($vals as $vv) {
                                        echo '<td' . $valCls . '>' . (is_numeric($vv) ? $fmt($vv) : '') . '</td>';
                                    }
                                    if (count($vals) >= 3) {
                                        echo '<td class="text-end' . ($type === "total" ? ' fw-bold' : '') . '"' . ($type === "total" ? ' style="background:#e9ecef"' : '') . '>' . $fmtGrowth($vals[1], $vals[0]) . '</td>';
                                        echo '<td class="text-end' . ($type === "total" ? ' fw-bold' : '') . '"' . ($type === "total" ? ' style="background:#e9ecef"' : '') . '>' . $fmtGrowth($vals[2], $vals[1]) . '</td>';
                                    } else {
                                        echo '<td></td><td></td>';
                                    }
                                };
                                for ($i = 0; $i < $maxRows; $i++) {
                                    $ar = $aktiva_rows[$i] ?? ["", [], ""];
                                    $pr = $pasiva_rows[$i] ?? ["", [], ""];
                                    echo '<tr>';
                                    $renderCells($ar);
                                    $renderCells($pr);
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>