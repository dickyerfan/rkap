<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <?php
                $tahun_mulai = date('Y') - 3;
                $tahun_selesai = date('Y') + 3;
                if ((int)$tahun > $tahun_selesai) $tahun_selesai = (int)$tahun;
                if ((int)$tahun < $tahun_mulai) $tahun_mulai = (int)$tahun;
                ?>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/neraca/neraca_lajur') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/neraca_lajur') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                            <?php if ($this->session->userdata("level") == 'Admin') : ?>
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Master Akun</button></a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5>NERACA LAJUR RKAP - TAHUN <?= $tahun ?></h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size:0.75rem;">
                            <thead>
                                <tr class="text-center table-secondary">
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Uraian</th>
                                    <th colspan="2">Neraca Th <?= $tahun - 2 ?></th>
                                    <th colspan="2">Proyeksi Des <?= $tahun - 1 ?> (GROWTH)</th>
                                    <th colspan="2">Jurnal RKAP</th>
                                    <th colspan="2">Neraca RKAP</th>
                                </tr>
                                <tr class="text-center table-secondary">
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                $displayCodes = [];
                                foreach ($this->Model_posisi_keuangan->getGrupKodes("lajur") as $grupCodes) {
                                    $displayCodes = array_merge($displayCodes, $grupCodes);
                                }
                                $totals = array_fill(0, 8, 0);
                                foreach ($displayCodes as $kode) :
                                    if (!isset($lajur[$kode])) continue;
                                    $row = $lajur[$kode];
                                    $isAsset = in_array($row["grup"], ["aktiva_lancar", "aktiva_pajak", "aktiva_tetap", "aktiva_lain"], true);
                                    $isDebit = function ($value) use ($isAsset) {
                                        return $isAsset ? $value >= 0 : $value < 0;
                                    };
                                    if (array_key_exists("neraca_2025_debit", $row)) {
                                        $neraca25_d = $row["neraca_2025_debit"];
                                        $neraca25_k = $row["neraca_2025_kredit"];
                                        $proy_d = $row["proyeksi_des_debit"];
                                        $proy_k = $row["proyeksi_des_kredit"];
                                        $rkap_d = $row["neraca_rkap_debit"];
                                        $rkap_k = $row["neraca_rkap_kredit"];
                                    } else {
                                        $neraca25_d = $isDebit($row["neraca_2025"]) ? $row["neraca_2025"] : 0;
                                        $neraca25_k = $isDebit($row["neraca_2025"]) ? 0 : $row["neraca_2025"];
                                        $proy_d = $isDebit($row["proyeksi_des"]) ? $row["proyeksi_des"] : 0;
                                        $proy_k = $isDebit($row["proyeksi_des"]) ? 0 : $row["proyeksi_des"];
                                        $rkap_d = $isDebit($row["neraca_rkap"]) ? $row["neraca_rkap"] : 0;
                                        $rkap_k = $isDebit($row["neraca_rkap"]) ? 0 : $row["neraca_rkap"];
                                    }
                                    $totals[0] += $neraca25_d;
                                    $totals[1] += $neraca25_k;
                                    $totals[2] += $proy_d;
                                    $totals[3] += $proy_k;
                                    $totals[4] += $row["j_debit"];
                                    $totals[5] += $row["j_kredit"];
                                    $totals[6] += $rkap_d;
                                    $totals[7] += $rkap_k;
                                    $grup_class = ["aktiva_lancar" => "table-light", "aktiva_pajak" => "table-light", "aktiva_tetap" => "table-light", "aktiva_lain" => "table-light", "liabilitas_pendek" => "table-info", "liabilitas_panjang" => "table-info", "ekuitas" => "table-success"];
                                    $cls = $grup_class[$row["grup"]] ?? "";
                                ?>
                                    <tr class="<?= $cls ?>">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $kode ?></td>
                                        <td><?= $row["uraian"] ?></td>
                                        <td class="text-end"><?= $neraca25_d != 0 ? number_format($neraca25_d, 0, ",", ".") : "" ?></td>
                                        <td class="text-end"><?= $neraca25_k != 0 ? number_format($neraca25_k, 0, ",", ".") : "" ?></td>
                                        <td class="text-end"><?= $proy_d != 0 ? number_format($proy_d, 0, ",", ".") : "" ?></td>
                                        <td class="text-end"><?= $proy_k != 0 ? number_format($proy_k, 0, ",", ".") : "" ?></td>
                                        <td class="text-end"><?= $row["j_debit"] != 0 ? number_format($row["j_debit"], 0, ",", ".") : "" ?></td>
                                        <td class="text-end"><?= $row["j_kredit"] != 0 ? number_format($row["j_kredit"], 0, ",", ".") : "" ?></td>
                                        <td class="text-end fw-bold"><?= $rkap_d != 0 ? number_format($rkap_d, 0, ",", ".") : "" ?></td>
                                        <td class="text-end fw-bold"><?= $rkap_k != 0 ? number_format($rkap_k, 0, ",", ".") : "" ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-secondary fw-bold">
                                    <td colspan="3" class="text-end">TOTAL</td>
                                    <?php foreach ($totals as $total) : ?>
                                        <td class="text-end"><?= $total != 0 ? number_format($total, 0, ",", ".") : "0" ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>