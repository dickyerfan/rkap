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
                        <form action="<?= base_url('lembar_kerja/neraca/input_jurnal') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_jurnal') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?> - Tahun <?= $tahun ?></h5>
                        </div>
                    </div>
                    <p class="text-muted" style="font-size:0.8rem;">Pos yang bertanda <span class="badge bg-info">Otomatis</span> diambil dari database rkap_rekap. Pos lain bisa diisi manual.</p>
                    <form method="post" action="<?= base_url("lembar_kerja/neraca/simpan_jurnal") ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" style="font-size:0.75rem;">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Uraian</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $autoKodes = ["31" => "31_debit", "31.1" => "31.1_kredit", "13.06" => "13.06_kredit", "50.05" => "50.05_kredit", "50.01" => "50.01_kredit"];
                                    $autoLabel = ["31" => "Investasi Aktiva Tetap (dari rkap_rekap)", "31.1" => "Penyusutan (dari rkap_rekap 91.09+98.02.90)", "13.06" => "Penyisihan Piutang (dari rkap_rekap 96.07)", "50.05" => "Utang Pajak (dari rkap_rekap 97)", "50.01" => "Utang Usaha (dari rkap_rekap 50.01)"];
                                    $no = 1;
                                    $jurnalSkip = $this->Model_posisi_keuangan->jurnalSkipCodes();
                                    foreach ($posList as $pos) :
                                        $kode = $pos["kode"];
                                        if (in_array($kode, $jurnalSkip, true)) continue;
                                        $rowIndex = $no;
                                        $isAuto = isset($autoKodes[$kode]);
                                        $j = isset($jurnal[$kode]) ? $jurnal[$kode] : ["debit" => 0, "kredit" => 0];
                                        if ($isAuto) {
                                            $rKey = $autoKodes[$kode];
                                            $isDebit = strpos($rKey, "_debit") !== false;
                                            $autoVal = $jRekap[$rKey] ?? 0;
                                            $debitVal = $isDebit ? $autoVal : 0;
                                            $kreditVal = $isDebit ? 0 : $autoVal;
                                        } else {
                                            $debitVal = $j["debit"];
                                            $kreditVal = $j["kredit"];
                                        }
                                    ?>
                                        <tr <?= $isAuto ? "class=table-light" : ""; ?>>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $kode ?></td>
                                            <td><?= $pos["uraian"] ?> <?= $isAuto ? "<span class=badge bg-info>Otomatis</span>" : ""; ?></td>
                                            <input type="hidden" name="jurnal[<?= $rowIndex ?>][kode]" value="<?= htmlspecialchars($kode) ?>">
                                            <input type="hidden" name="jurnal[<?= $rowIndex ?>][uraian]" value="<?= htmlspecialchars($pos["uraian"]) ?>">
                                            <?php if ($isAuto) : ?>
                                                <td class="text-end"><?= number_format($debitVal, 0, ",", ".") ?><input type="hidden" name="jurnal[<?= $rowIndex ?>][debit]" value="<?= $debitVal ?>"></td>
                                                <td class="text-end"><?= number_format($kreditVal, 0, ",", ".") ?><input type="hidden" name="jurnal[<?= $rowIndex ?>][kredit]" value="<?= $kreditVal ?>"></td>
                                                <td style="font-size:0.7rem;color:#888;"><?= $autoLabel[$kode] ?></td>
                                            <?php else : ?>
                                                <td><input type="text" inputmode="decimal" name="jurnal[<?= $rowIndex ?>][debit]" value="<?= $debitVal ?>" class="form-control form-control-sm text-end p-1"></td>
                                                <td><input type="text" inputmode="decimal" name="jurnal[<?= $rowIndex ?>][kredit]" value="<?= $kreditVal ?>" class="form-control form-control-sm text-end p-1"></td>
                                                <td></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Simpan Jurnal Penyesuaian</button>
                    </form>
                </div>
            </div>
        </div>

    </main>
</div>
