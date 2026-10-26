<?php if ($this->session->userdata("level") != "Admin") redirect("auth"); ?>
<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="p-2"><?= $this->session->flashdata('info'); ?></div>
                <?php
                $tahun_mulai = date('Y') - 3;
                $tahun_selesai = date('Y') + 3;
                if ((int)$tahun > $tahun_selesai) $tahun_selesai = (int)$tahun;
                if ((int)$tahun < $tahun_mulai) $tahun_mulai = (int)$tahun;
                ?>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/neraca/input_growth') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_growth') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Master Akun</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?> - Tahun <?= $tahun ?></h5>
                        </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:0.75rem;">Kolom <strong>Proyeksi Des <?= $tahun - 1 ?></strong> dihitung otomatis (CAGR Des <?= $tahun - 2 ?> s/d Jun <?= $tahun - 1 ?>) sehingga tidak dapat diubah. Rincian rekening <strong>Kas dan Bank</strong> dapat dibuka lewat tombol di bawah; baris <strong>Uang Tunai</strong> diisi otomatis sebagai penyeimbang agar ASET = LE.</p>
                    <form method="post" action="<?= base_url("lembar_kerja/neraca/simpan_growth") ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <button type="button" class="btn btn-sm btn-outline-secondary mb-2" id="btnKas" onclick="toggleKas()">Rincian Kas &amp; Bank</button>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" style="font-size:0.75rem;">
                                <thead>
                                    <tr class="text-center table-secondary">
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Uraian</th>
                                        <th>Des <?= $tahun - 2 ?></th>
                                        <th>Jan <?= $tahun - 1 ?></th>
                                        <th>Feb <?= $tahun - 1 ?></th>
                                        <th>Mar <?= $tahun - 1 ?></th>
                                        <th>Apr <?= $tahun - 1 ?></th>
                                        <th>Mei <?= $tahun - 1 ?></th>
                                        <th>Jun <?= $tahun - 1 ?></th>
                                        <th class="table-warning">Proyeksi Des <?= $tahun - 1 ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $monthCols = ["des_n2", "jan_n1", "feb_n1", "mar_n1", "apr_n1", "mei_n1", "jun_n1"];
                                    $emptyGrowth = ["des_n2" => 0, "jan_n1" => 0, "feb_n1" => 0, "mar_n1" => 0, "apr_n1" => 0, "mei_n1" => 0, "jun_n1" => 0, "proyeksi_manual" => null];
                                    $fmtNum = function ($value) {
                                        $v = (float)$value;
                                        $dec = (round($v, 2) == round($v)) ? 0 : 2;
                                        return number_format($v, $dec, ",", ".");
                                    };
                                    $proyMap = $this->Model_posisi_keuangan->hitungProyeksi($growth);
                                    $aggregateMap = $this->Model_posisi_keuangan->aggregateMap();
                                    $parentCodes = $this->Model_posisi_keuangan->parentCodes();
                                    $hiddenKas = $this->Model_posisi_keuangan->kasHiddenCodes();

                                    $hasChildData = function ($parent) use ($aggregateMap, $growth) {
                                        if (!isset($aggregateMap[$parent])) return false;
                                        foreach ($aggregateMap[$parent] as $child) {
                                            if (!isset($growth[$child])) continue;
                                            foreach (["des_n2", "jan_n1", "feb_n1", "mar_n1", "apr_n1", "mei_n1", "jun_n1"] as $col) {
                                                if (($growth[$child][$col] ?? 0) != 0) return true;
                                            }
                                            if (($growth[$child]["proyeksi_manual"] ?? null) !== null) return true;
                                        }
                                        return false;
                                    };

                                    $rowsData = [];
                                    foreach ($posList as $pos) :
                                        $kode = $pos["kode"];
                                        $rowIndex = $no;
                                        $g = isset($growth[$kode]) ? $growth[$kode] : $emptyGrowth;
                                        $months = [];
                                        foreach ($monthCols as $col) {
                                            $months[$col] = (float)(isset($proyMap["months"][$kode][$col]) ? $proyMap["months"][$kode][$col] : ($g[$col] ?? 0));
                                        }
                                        $proy = (float)(isset($proyMap["proy"][$kode]) ? $proyMap["proy"][$kode] : 0);
                                        $proyVal = number_format(round($proy), 0, ",", ".");
                                        if ($proyVal === "" || $proyVal === "-") $proyVal = "0";
                                        $isParent = in_array($kode, $parentCodes, true);
                                        $rowsData[] = [
                                            "rowIndex" => $rowIndex,
                                            "kode" => $kode,
                                            "uraian" => $pos["uraian"],
                                            "grup" => $pos["grup"],
                                            "months" => $months,
                                            "monthsRaw" => array_combine($monthCols, array_map(function ($col) use ($g) {
                                                return (float)($g[$col] ?? 0);
                                            }, $monthCols)),
                                            "proy" => $proy,
                                            "proyVal" => $proyVal,
                                            "parent" => $isParent,
                                            "readonly" => $isParent && $hasChildData($kode),
                                            "hidden" => in_array($kode, $hiddenKas, true),
                                            "level" => (strpos($kode, "11.") === 0) ? substr_count($kode, ".") : 0,
                                        ];
                                        $no++;
                                    endforeach;

                                    $byCode = [];
                                    foreach ($rowsData as $rd) $byCode[$rd["kode"]] = $rd;
                                    $effValues = null;
                                    $effValues = function ($kode) use (&$effValues, $byCode, $aggregateMap, $monthCols) {
                                        if (!isset($byCode[$kode])) return null;
                                        if (isset($aggregateMap[$kode])) {
                                            $acc = ["months" => array_fill_keys($monthCols, 0.0), "proy" => 0.0];
                                            $hasChild = false;
                                            foreach ($aggregateMap[$kode] as $ck) {
                                                $cv = $effValues($ck);
                                                if ($cv === null) continue;
                                                $nonZero = ($cv["proy"] != 0);
                                                foreach ($cv["months"] as $mv) {
                                                    if ($mv != 0) $nonZero = true;
                                                }
                                                if (!$nonZero) continue;
                                                $hasChild = true;
                                                foreach ($monthCols as $mcol) $acc["months"][$mcol] += $cv["months"][$mcol];
                                                $acc["proy"] += $cv["proy"];
                                            }
                                            if ($hasChild) return $acc;
                                        }
                                        return ["months" => $byCode[$kode]["months"], "proy" => $byCode[$kode]["proy"]];
                                    };

                                    $skipCodes = [];
                                    foreach ($aggregateMap as $children) $skipCodes = array_merge($skipCodes, $children);
                                    $totals = [
                                        "A" => ["label" => "JUMLAH AKTIVA", "months" => array_fill_keys($monthCols, 0.0), "proy" => 0.0],
                                        "LE" => ["label" => "JUMLAH LIABILITAS DAN EKUITAS", "months" => array_fill_keys($monthCols, 0.0), "proy" => 0.0],
                                    ];
                                    foreach ($rowsData as $rd) {
                                        if (in_array($rd["kode"], $skipCodes, true)) continue;
                                        $v = $effValues($rd["kode"]);
                                        if ($v === null) continue;
                                        $key = (strpos($rd["grup"], "aktiva") === 0) ? "A" : "LE";
                                        foreach ($monthCols as $mcol) {
                                            $totals[$key]["months"][$mcol] += $v["months"][$mcol];
                                        }
                                        $totals[$key]["proy"] += $v["proy"];
                                    }

                                    $renderRow = function ($rd) use ($monthCols, $fmtNum) {
                                        $i = $rd["rowIndex"];
                                        $pad = $rd["level"] > 0 ? str_repeat("&nbsp;&nbsp;&nbsp;", $rd["level"]) : "";
                                        $rowClass = trim(($rd["parent"] ? "table-light fw-bold" : "") . ($rd["hidden"] ? " kas-detail d-none" : ""));
                                        echo "<tr" . ($rowClass !== "" ? ' class="' . $rowClass . '"' : "") . ">";
                                        echo '<td class="text-center">' . $i . '</td>';
                                        echo '<td>' . htmlspecialchars($rd["kode"]) . '</td>';
                                        echo '<td>' . $pad . htmlspecialchars($rd["uraian"]) . '</td>';
                                        echo '<input type="hidden" name="neraca[' . $i . '][kode]" value="' . htmlspecialchars($rd["kode"]) . '">';
                                        echo '<input type="hidden" name="neraca[' . $i . '][uraian]" value="' . htmlspecialchars($rd["uraian"]) . '">';
                                        echo '<input type="hidden" name="neraca[' . $i . '][proyeksi_asli]" value="' . $rd["proyVal"] . '">';
                                        if ($rd["readonly"]) {
                                            echo '<input type="hidden" name="neraca[' . $i . '][proyeksi]" value="' . $rd["proyVal"] . '">';
                                            foreach ($monthCols as $col) {
                                                echo '<input type="hidden" name="neraca[' . $i . '][' . $col . ']" value="' . $fmtNum($rd["monthsRaw"][$col]) . '">';
                                            }
                                            foreach ($monthCols as $col) {
                                                echo '<td class="text-end">' . $fmtNum($rd["months"][$col]) . '</td>';
                                            }
                                            echo '<td class="text-end table-warning">' . $rd["proyVal"] . '</td>';
                                        } else {
                                            foreach ($monthCols as $col) {
                                                echo '<td><input type="text" inputmode="decimal" name="neraca[' . $i . '][' . $col . ']" value="' . $fmtNum($rd["months"][$col]) . '" class="form-control form-control-sm text-end p-1" style="min-width:110px;"></td>';
                                            }
                                            echo '<td><input type="text" inputmode="decimal" name="neraca[' . $i . '][proyeksi]" value="' . $rd["proyVal"] . '" class="form-control form-control-sm text-end p-1 table-warning fw-bold" style="min-width:110px;"></td>';
                                        }
                                        echo "</tr>";
                                    };
                                    $sectionHeader = function ($label) {
                                        echo '<tr class="table-secondary fw-bold"><td colspan="11" class="text-center">' . $label . '</td></tr>';
                                    };
                                    $totalRow = function ($t) use ($monthCols) {
                                        echo '<tr class="fw-bold table-light">';
                                        echo '<td colspan="3" class="text-center">' . $t["label"] . '</td>';
                                        foreach ($monthCols as $mcol) {
                                            echo '<td class="text-end">' . number_format($t["months"][$mcol], 0, ",", ".") . '</td>';
                                        }
                                        echo '<td class="text-end table-warning">' . number_format($t["proy"], 0, ",", ".") . '</td>';
                                        echo '</tr>';
                                    };

                                    ?>
                                    <?php $sectionHeader("ASET"); ?>
                                    <?php foreach ($rowsData as $rd) {
                                        if (strpos($rd["grup"], "aktiva") === 0) $renderRow($rd);
                                    } ?>
                                    <?php $totalRow($totals["A"]); ?>
                                    <?php $sectionHeader("MODAL &amp; KEWAJIBAN"); ?>
                                    <?php foreach ($rowsData as $rd) {
                                        if (strpos($rd["grup"], "aktiva") !== 0) $renderRow($rd);
                                    } ?>
                                    <?php $totalRow($totals["LE"]); ?>

                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Simpan Data Neraca Awal</button>
                    </form>
                    <script>
                        function toggleKas() {
                            var rows = document.querySelectorAll('tr.kas-detail');
                            if (!rows.length) return;
                            var show = rows[0].classList.contains('d-none');
                            rows.forEach(function(r) {
                                r.classList.toggle('d-none', !show);
                            });
                            document.getElementById('btnKas').innerHTML = show ? 'Sembunyikan Rincian Kas &amp; Bank' : 'Rincian Kas &amp; Bank';
                        }
                    </script>
                </div>
            </div>
        </div>

    </main>