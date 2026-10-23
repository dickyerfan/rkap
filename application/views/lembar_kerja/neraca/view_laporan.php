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
$fmt = function ($v) {
    return number_format($v, 0, ",", ".");
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
$notif_aktiva = $total_aktiva;
$notif_pasiva = $total_pasiva;
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
                        <form action="<?= base_url('lembar_kerja/neraca') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = date('Y') - 3; $i <= date('Y') + 3; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/neraca/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                            <?php if ($this->session->userdata("level") == 'Admin') : ?>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/komparasi?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Komparasi <?= $tahun - 2 ?>/<?= $tahun - 1 ?>/<?= $tahun ?></button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/neraca_lajur?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Neraca Lajur</button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_growth?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Input Neraca Awal</button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/jurnal_rkap?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Jurnal RKAP <?= $tahun ?></button></a>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Master Akun</button></a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?>TAHUN <?= $tahun ?></h5>
                        </div>
                    </div>
                    <?php $this->load->view('lembar_kerja/neraca/partial/indikator_balance'); ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size:0.75rem;">
                            <thead class="table-secondary text-center">
                                <tr>
                                    <th style="width:40%;">URAIAN</th>
                                    <th style="width:10%;">PROYEKSI <?= $tahun ?> (Rp)</th>
                                    <th style="width:40%;">URAIAN</th>
                                    <th style="width:10%;">PROYEKSI <?= $tahun ?> (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $aktiva_rows = [];
                                $aktiva_rows[] = ["ASET LANCAR", "", "header"];
                                foreach ($aktiva_lancar as $k) {
                                    $nilai = (float)($lajur[$k]["neraca_rkap"] ?? 0);
                                    if ($isNol($nilai)) continue;
                                    $aktiva_rows[] = [$lajur[$k]["uraian"] ?? "", $nilai, 1];
                                    if ($k === "13.06") {
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
                                foreach ($aktiva_lain as $k) {
                                    $nilai = (float)($lajur[$k]["neraca_rkap"] ?? 0);
                                    if ($isNol($nilai)) continue;
                                    $aktiva_rows[] = [$lajur[$k]["uraian"] ?? "", $nilai, 1];
                                }
                                $aktiva_rows[] = ["Jumlah Aset Lain-lain", $jml_aln, "subtotal"];
                                $aktiva_rows[] = ["TOTAL ASET", $total_aktiva, "total"];

                                $pasiva_rows = [];
                                $pasiva_rows[] = ["KEWAJIBAN LANCAR", "", "header"];
                                foreach ($liab_pendek as $k) {
                                    if ($isNol($liabVal($k))) continue;
                                    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", $liabVal($k), 1];
                                }
                                $pasiva_rows[] = ["Jumlah Kewajiban lancar", $jml_lp, "subtotal"];
                                $pasiva_rows[] = ["KEWAJIBAN JK PANJANG", "", "header"];
                                foreach ($liab_panjang as $k) {
                                    if ($isNol($liabVal($k))) continue;
                                    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", $liabVal($k), 1];
                                }
                                $pasiva_rows[] = ["Jumlah Kewajiban Jangka panjang", $jml_ljp, "subtotal"];
                                $pasiva_rows[] = ["Jumlah Kewajiban", $jml_lp + $jml_ljp, "subtotal"];
                                $pasiva_rows[] = ["MODAL DAN CADANGAN", "", "header"];
                                foreach ($ekuitas as $k) {
                                    $nilai = $ekVal($k);
                                    if ($isNol($nilai)) continue;
                                    $pasiva_rows[] = [$lajur[$k]["uraian"] ?? "", (float)$nilai, 1];
                                }
                                $pasiva_rows[] = ["Jumlah Modal dan Cadangan", $jml_ek, "subtotal"];
                                $pasiva_rows[] = ["TOTAL MODAL & KEWAJIBAN", $total_pasiva, "total"];

                                $maxRows = max(count($aktiva_rows), count($pasiva_rows));
                                for ($i = 0; $i < $maxRows; $i++) {
                                    $ar = $aktiva_rows[$i] ?? ["", -1, ""];
                                    $pr = $pasiva_rows[$i] ?? ["", -1, ""];
                                    $at = $ar[2];
                                    $pt = $pr[2];
                                    echo "<tr>";
                                    if ($at === "header") {
                                        echo "<td class=fw-bold colspan=2>" . $ar[0] . "</td>";
                                    } elseif ($at === "subtotal") {
                                        echo "<td class=fw-bold>" . $ar[0] . "</td><td class=\"text-end fw-bold border-top\">" . (is_numeric($ar[1]) ? $fmt($ar[1]) : "") . "</td>";
                                    } elseif ($at === "total") {
                                        echo "<td class=\"fw-bold table-light\">" . $ar[0] . "</td><td class=\"text-end fw-bold table-light\">" . (is_numeric($ar[1]) ? $fmt($ar[1]) : "") . "</td>";
                                    } elseif ($ar[0] !== "") {
                                        echo "<td>- " . $ar[0] . "</td><td class=text-end>" . (is_numeric($ar[1]) && $ar[1] != -1 ? $fmt($ar[1]) : "") . "</td>";
                                    } else {
                                        echo "<td></td><td></td>";
                                    }
                                    if ($pt === "header") {
                                        echo "<td class=fw-bold colspan=2>" . $pr[0] . "</td>";
                                    } elseif ($pt === "subtotal") {
                                        echo "<td class=fw-bold>" . $pr[0] . "</td><td class=\"text-end fw-bold border-top\">" . (is_numeric($pr[1]) ? $fmt($pr[1]) : "") . "</td>";
                                    } elseif ($pt === "total") {
                                        echo "<td class=\"fw-bold table-light\">" . $pr[0] . "</td><td class=\"text-end fw-bold table-light\">" . (is_numeric($pr[1]) ? $fmt($pr[1]) : "") . "</td>";
                                    } elseif ($pr[0] !== "") {
                                        echo "<td>- " . $pr[0] . "</td><td class=text-end>" . (is_numeric($pr[1]) && $pr[1] != -1 ? $fmt($pr[1]) : "") . "</td>";
                                    } else {
                                        echo "<td></td><td></td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>