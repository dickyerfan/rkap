<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <?= $this->session->flashdata('info'); ?>
            <div class="card border-0">
                <div class="card-header shadow text-light" style="background: linear-gradient(45deg, rgba(0,0,0,0.9), rgba(0,0,0,0.7) 100%);">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <!-- <span class="title fw-bold">DASHBOARD RKAP</span> -->
                        <a href="<?= base_url('admin/dashboard_upk') ?>"><button class="btn btn-sm btn-secondary">Reset</button></a>
                        <form method="GET" action="<?= base_url('admin/dashboard_upk') ?>" class="d-flex align-items-center gap-2">
                            <select name="id_upk" class="form-select form-select-sm select2" style="width:250px;" onchange="this.form.submit()">
                                <option value="">-- Pilih UPK / AMDK --</option>
                                <?php foreach ($upk_list as $u) : ?>
                                    <option value="<?= $u->id_upk ?>" <?= ($selected_upk == $u->id_upk) ? 'selected' : '' ?>><?= strtoupper($u->nama_upk) ?></option>
                                <?php endforeach; ?>
                                <option value="amdk" <?= ($selected_upk === 'amdk') ? 'selected' : '' ?>>AMDK</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <?php if (!empty($is_total)) : ?>
                        <!-- ============ TOTAL / KONSOLIDASI ============ -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold">Laba Rugi RKAP Konsolidasi</h5>
                                    <a href="<?= base_url('admin/dashboard_upk/export_pdf?id_upk=' . $selected_upk) ?>" target="_blank" class="btn btn-sm btn-primary mb-2"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th style="width:40%;">Uraian</th>
                                                <th style="width:15%;">Tahun <?= $tahun_ini ?> (Rp)</th>
                                                <th style="width:15%;">Tahun <?= $tahun_depan ?> (Rp)</th>
                                                <th style="width:15%;">Selisih (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- PENDAPATAN USAHA -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">PENDAPATAN USAHA</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Air</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.01']['total'] ?? 0) - ($pendapatan_ini['81.01']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Non Air</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.02']['total'] ?? 0) - ($pendapatan_ini['81.02']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Usaha Lainnya</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.03']['total'] ?? 0) - ($pendapatan_ini['81.03']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-primary fw-bold">
                                                <td>Total Pendapatan Usaha</td>
                                                <td class="text-end"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                                                <td class="text-end <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- BEBAN USAHA -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">BEBAN USAHA</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Sumber Air</td>
                                                <td class="text-end"><?= number_format($beban_ini['91']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['91']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['91']['total'] ?? 0) - ($beban_ini['91']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Pengolahan Air</td>
                                                <td class="text-end"><?= number_format($beban_ini['92']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['92']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['92']['total'] ?? 0) - ($beban_ini['92']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Transmisi & Distribusi</td>
                                                <td class="text-end"><?= number_format($beban_ini['93']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['93']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['93']['total'] ?? 0) - ($beban_ini['93']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban (HPP) Sambungan Baru</td>
                                                <td class="text-end"><?= number_format($beban_ini['95']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['95']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['95']['total'] ?? 0) - ($beban_ini['95']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-danger fw-bold">
                                                <td>Total Beban Usaha</td>
                                                <td class="text-end"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- LABA KOTOR -->
                                            <tr class="table-warning fw-bold">
                                                <td>Laba / (Rugi) Kotor</td>
                                                <td class="text-end"><?= number_format($laba_kotor_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_kotor_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_kotor_depan - $laba_kotor_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- BEBAN UMUM -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">BEBAN UMUM DAN ADMINISTRASI</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Umum & Administrasi</td>
                                                <td class="text-end"><?= number_format($total_beban_umum_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_umum_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_umum_depan - $total_beban_umum_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- LABA OPERASIONAL -->
                                            <tr class="table-warning fw-bold">
                                                <td>Laba / (Rugi) Operasional</td>
                                                <td class="text-end"><?= number_format($laba_operasional_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_operasional_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_operasional_depan - $laba_operasional_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- NON OPERASIONAL -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Non Operasional</td>
                                                <td class="text-end"><?= number_format($non_usaha_ini['88']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($non_usaha_depan['88']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_ini['88']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Non Operasional</td>
                                                <td class="text-end"><?= number_format($non_usaha_ini['98']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($non_usaha_depan['98']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($non_usaha_depan['98']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-info fw-bold">
                                                <td>Jumlah Non Operasional</td>
                                                <td class="text-end"><?= number_format(($non_usaha_ini['88']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0), 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_depan['98']['total'] ?? 0), 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format((($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_depan['98']['total'] ?? 0)) - (($non_usaha_ini['88']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0)), 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- LABA SEBELUM PAJAK -->
                                            <tr class="table-warning fw-bold">
                                                <td>Laba Sebelum Pajak</td>
                                                <td class="text-end"><?= number_format($laba_sebelum_pajak_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_sebelum_pajak_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_sebelum_pajak_depan - $laba_sebelum_pajak_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- LUAR BIASA -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">KEUNTUNGAN / (KERUGIAN) LUAR BIASA</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Keuntungan Luar Biasa</td>
                                                <td class="text-end"><?= number_format($luar_biasa_ini['89.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($luar_biasa_depan['89.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($luar_biasa_depan['89.01.01']['total'] ?? 0) - ($luar_biasa_ini['89.01.01']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Kerugian Luar Biasa</td>
                                                <td class="text-end"><?= number_format($luar_biasa_ini['99.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($luar_biasa_depan['99.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($luar_biasa_depan['99.01.01']['total'] ?? 0) - ($luar_biasa_ini['99.01.01']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-info fw-bold">
                                                <td>Jumlah Luar Biasa</td>
                                                <td class="text-end"><?= number_format($total_luar_biasa_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_luar_biasa_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_luar_biasa_depan - $total_luar_biasa_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- PAJAK -->
                                            <tr class="table-light fw-bold">
                                                <td colspan="4">PAJAK PENGHASILAN</td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Taksiran Pajak (Pasal 25)</td>
                                                <td class="text-end"><?= number_format($pajak_ini['97.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pajak_depan['97.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pajak_depan['97.01.01']['total'] ?? 0) - ($pajak_ini['97.01.01']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pajak Kini</td>
                                                <td class="text-end"><?= number_format($pajak_ini['97.01.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pajak_depan['97.01.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pajak_depan['97.01.02']['total'] ?? 0) - ($pajak_ini['97.01.02']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Pajak Ditangguhkan</td>
                                                <td class="text-end"><?= number_format($pajak_ini['97.01.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pajak_depan['97.01.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pajak_depan['97.01.03']['total'] ?? 0) - ($pajak_ini['97.01.03']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-info fw-bold">
                                                <td>Total Pajak Penghasilan</td>
                                                <td class="text-end"><?= number_format($total_pajak_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_pajak_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_pajak_depan - $total_pajak_ini, 0, ',', '.') ?></td>
                                            </tr>

                                            <!-- LABA BERSIH -->
                                            <tr class="table-success fw-bold">
                                                <td>LABA / (RUGI) SETELAH PAJAK</td>
                                                <td class="text-end"><?= number_format($laba_bersih_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($laba_bersih_depan, 0, ',', '.') ?></td>
                                                <td class="text-end <?= ($laba_bersih_depan - $laba_bersih_ini) >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($laba_bersih_depan - $laba_bersih_ini, 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold">Grafik Laba Rugi Konsolidasi</h5>
                                <canvas id="myChartLabaRugi" height="40"></canvas>
                            </div>
                        </div>

                        <script>
                            window.onload = function() {
                                new Chart(document.getElementById('myChartLabaRugi'), {
                                    type: 'bar',
                                    data: {
                                        labels: ['Pendapatan Usaha', 'Beban Usaha', 'Laba Kotor', 'Beban Umum', 'Laba Operasional', 'Non Operasional', 'Laba Sebelum Pajak', 'Luar Biasa', 'Pajak', 'Laba Bersih'],
                                        datasets: [{
                                            label: '<?= $tahun_ini ?>',
                                            backgroundColor: 'rgba(0,123,255,0.7)',
                                            data: [<?= $total_pendapatan_ini ?>, <?= $total_beban_ini ?>, <?= $laba_kotor_ini ?>, <?= $total_beban_umum_ini ?>, <?= $laba_operasional_ini ?>, <?= ($non_usaha_ini['88']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0) ?>, <?= $laba_sebelum_pajak_ini ?>, <?= $total_luar_biasa_ini ?>, <?= $total_pajak_ini ?>, <?= $laba_bersih_ini ?>]
                                        }, {
                                            label: '<?= $tahun_depan ?>',
                                            backgroundColor: 'rgba(40,167,69,0.7)',
                                            data: [<?= $total_pendapatan_depan ?>, <?= $total_beban_depan ?>, <?= $laba_kotor_depan ?>, <?= $total_beban_umum_depan ?>, <?= $laba_operasional_depan ?>, <?= ($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_depan['98']['total'] ?? 0) ?>, <?= $laba_sebelum_pajak_depan ?>, <?= $total_luar_biasa_depan ?>, <?= $total_pajak_depan ?>, <?= $laba_bersih_depan ?>]
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                });
                            };
                        </script>

                    <?php elseif ($is_amdk) : ?>
                        <!-- ============ AMDK ============ -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold">Ringkasan Laba Rugi AMDK</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th style="width:35%;">Uraian</th>
                                                <th style="width:20%;">Tahun <?= $tahun_ini ?> (Rp)</th>
                                                <th style="width:20%;">Tahun <?= $tahun_depan ?> (Rp)</th>
                                                <th style="width:25%;">Selisih (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-primary">
                                                <td class="fw-bold">Pendapatan Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td class="fw-bold">Beban Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td class="fw-bold">Laba Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_depan - $laba_usaha_ini, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td class="fw-bold">Laba Bersih</td>
                                                <td class="text-end fw-bold"><?= number_format($laba_bersih_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_bersih_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold <?= ($laba_bersih_depan - $laba_bersih_ini) >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format($laba_bersih_depan - $laba_bersih_ini, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Produksi AMDK (RKAP)</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th>Produk</th>
                                                <th><?= $tahun_ini ?></th>
                                                <th><?= $tahun_depan ?></th>
                                                <th>Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $produk_totals = [];
                                            foreach ($produksi_amdk_ini as $p) {
                                                $key = $p->nama_produk;
                                                $produk_totals[$key]['nama'] = $p->nama_produk;
                                                $produk_totals[$key]['ini'] = ($produk_totals[$key]['ini'] ?? 0) + $p->jumlah_produksi;
                                            }
                                            foreach ($produksi_amdk_depan as $p) {
                                                $key = $p->nama_produk;
                                                $produk_totals[$key]['nama'] = $p->nama_produk;
                                                $produk_totals[$key]['depan'] = ($produk_totals[$key]['depan'] ?? 0) + $p->jumlah_produksi;
                                            }
                                            ?>
                                            <?php if (empty($produk_totals)) : ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Belum ada data produksi</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($produk_totals as $prod) :
                                                    $ini = $prod['ini'] ?? 0;
                                                    $depan = $prod['depan'] ?? 0;
                                                    $selisih = $depan - $ini;
                                                ?>
                                                    <tr>
                                                        <td><?= $prod['nama'] ?></td>
                                                        <td class="text-end"><?= number_format($ini, 0, ',', '.') ?></td>
                                                        <td class="text-end"><?= number_format($depan, 0, ',', '.') ?></td>
                                                        <td class="text-end <?= $selisih >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih, 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold">Evaluasi AMDK</h5>
                                <div class="table-responsive" style="max-height:300px; overflow-y:auto;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th>Jenis</th>
                                                <th>Uraian</th>
                                                <th>Sat</th>
                                                <th>RKAP</th>
                                                <th>Realisasi</th>
                                                <th>Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($evaluasi_amdk_ini)) : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Belum ada data</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($evaluasi_amdk_ini as $e) :
                                                    $selisih = ($e->rkap ?? 0) - ($e->realisasi ?? 0);
                                                ?>
                                                    <tr>
                                                        <td><?= $e->jenis_uraian ?></td>
                                                        <td><?= $e->uraian_evaluasi ?></td>
                                                        <td class="text-center"><?= $e->satuan ?></td>
                                                        <td class="text-end"><?= $e->rkap ? number_format($e->rkap, 0, ',', '.') : '-' ?></td>
                                                        <td class="text-end"><?= $e->realisasi ? number_format($e->realisasi, 0, ',', '.') : '-' ?></td>
                                                        <td class="text-end <?= $selisih >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih, 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Grafik Laba Rugi AMDK</h5>
                                <canvas id="myChartLabaRugi" height="50"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Grafik Produksi AMDK</h5>
                                <canvas id="myChartProduksi" height="50"></canvas>
                            </div>
                        </div>

                        <script>
                            window.onload = function() {
                                new Chart(document.getElementById('myChartLabaRugi'), {
                                    type: 'bar',
                                    data: {
                                        labels: ['Pendapatan Usaha', 'Beban Usaha', 'Laba Usaha', 'Laba Bersih'],
                                        datasets: [{
                                            label: '<?= $tahun_ini ?>',
                                            backgroundColor: 'rgba(0,123,255,0.7)',
                                            data: [<?= $total_pendapatan_ini ?>, <?= $total_beban_ini ?>, <?= $laba_usaha_ini ?>, <?= $laba_bersih_ini ?>]
                                        }, {
                                            label: '<?= $tahun_depan ?>',
                                            backgroundColor: 'rgba(40,167,69,0.7)',
                                            data: [<?= $total_pendapatan_depan ?>, <?= $total_beban_depan ?>, <?= $laba_usaha_depan ?>, <?= $laba_bersih_depan ?>]
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                });

                                var pLabels = [],
                                    pDataIni = [],
                                    pDataDepan = [];
                                <?php foreach ($produk_totals as $prod) : ?>
                                    pLabels.push('<?= str_replace("'", "\\'", $prod['nama']) ?>');
                                    pDataIni.push(<?= $prod['ini'] ?? 0 ?>);
                                    pDataDepan.push(<?= $prod['depan'] ?? 0 ?>);
                                <?php endforeach; ?>
                                new Chart(document.getElementById('myChartProduksi'), {
                                    type: 'bar',
                                    data: {
                                        labels: pLabels,
                                        datasets: [{
                                            label: '<?= $tahun_ini ?>',
                                            backgroundColor: 'rgba(0,123,255,0.7)',
                                            data: pDataIni
                                        }, {
                                            label: '<?= $tahun_depan ?>',
                                            backgroundColor: 'rgba(40,167,69,0.7)',
                                            data: pDataDepan
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                });
                            };
                        </script>

                    <?php else : ?>
                        <!-- ============ UPK ============ -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold">Ringkasan Laba Rugi <?= strtoupper($nama_upk) ?></h5>
                                    <a href="<?= base_url('admin/dashboard_upk/export_pdf?id_upk=' . $selected_upk) ?>" target="_blank" class="btn btn-sm btn-primary mb-2"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th style="width:35%;">Uraian</th>
                                                <th style="width:20%;">Tahun <?= $tahun_ini ?> (Rp)</th>
                                                <th style="width:20%;">Tahun <?= $tahun_depan ?> (Rp)</th>
                                                <th style="width:25%;">Selisih (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-primary">
                                                <td class="fw-bold">Pendapatan Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Penjualan Air</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.01']['total'] ?? 0) - ($pendapatan_ini['81.01']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Non Air</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.02']['total'] ?? 0) - ($pendapatan_ini['81.02']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Pendapatan Aktiva</td>
                                                <td class="text-end"><?= number_format($pendapatan_ini['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($pendapatan_depan['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($pendapatan_depan['81.03']['total'] ?? 0) - ($pendapatan_ini['81.03']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-danger">
                                                <td class="fw-bold">Beban Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Sumber</td>
                                                <td class="text-end"><?= number_format($beban_ini['91']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['91']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['91']['total'] ?? 0) - ($beban_ini['91']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Pengolahan</td>
                                                <td class="text-end"><?= number_format($beban_ini['92']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['92']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['92']['total'] ?? 0) - ($beban_ini['92']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Transmisi Distribusi</td>
                                                <td class="text-end"><?= number_format($beban_ini['93']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['93']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['93']['total'] ?? 0) - ($beban_ini['93']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban HPP Sambungan Baru</td>
                                                <td class="text-end"><?= number_format($beban_ini['95']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($beban_depan['95']['total'] ?? 0, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format(($beban_depan['95']['total'] ?? 0) - ($beban_ini['95']['total'] ?? 0), 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td class="fw-bold">Laba Usaha</td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_usaha_depan - $laba_usaha_ini, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="ps-4">Beban Umum</td>
                                                <td class="text-end"><?= number_format($total_beban_umum_ini, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_umum_depan, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($total_beban_umum_depan - $total_beban_umum_ini, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td class="fw-bold">Laba Sebelum Pajak</td>
                                                <td class="text-end fw-bold"><?= number_format($laba_bersih_ini, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold"><?= number_format($laba_bersih_depan, 0, ',', '.') ?></td>
                                                <td class="text-end fw-bold <?= ($laba_bersih_depan - $laba_bersih_ini) >= 0 ? 'text-success' : 'text-danger' ?>">
                                                    <?= number_format($laba_bersih_depan - $laba_bersih_ini, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Potensi SR</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th>Indikator</th>
                                                <th><?= $tahun_ini - 1 ?></th>
                                                <th><?= $tahun_depan - 1 ?></th>
                                                <th>Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Pelanggan Aktif (SR)</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->plg_aktif) ? number_format($potensi_sr_ini->plg_aktif, 0, ',', '.') : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->plg_aktif) ? number_format($potensi_sr_depan->plg_aktif, 0, ',', '.') : '-' ?></td>
                                                <td class="text-end <?= $selisih_plg_aktif >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_plg_aktif, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tambahan SR</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->tambah_sr) ? number_format($potensi_sr_ini->tambah_sr, 0, ',', '.') : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->tambah_sr) ? number_format($potensi_sr_depan->tambah_sr, 0, ',', '.') : '-' ?></td>
                                                <td class="text-end <?= $selisih_tambah_sr >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_tambah_sr, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kapasitas Produksi (lt/dtk)</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->kap_pro) ? number_format($potensi_sr_ini->kap_pro, 2) : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->kap_pro) ? number_format($potensi_sr_depan->kap_pro, 2) : '-' ?></td>
                                                <td class="text-end <?= $selisih_kap_pro >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_kap_pro, 2, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kapasitas Manfaat (lt/dtk)</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->kap_manf) ? number_format($potensi_sr_ini->kap_manf, 2) : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->kap_manf) ? number_format($potensi_sr_depan->kap_manf, 2) : '-' ?></td>
                                                <td class="text-end <?= $selisih_kap_manf >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_kap_manf, 2, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tingkat Kebocoran (%)</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->tk_bocor) ? number_format($potensi_sr_ini->tk_bocor, 2) : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->tk_bocor) ? number_format($potensi_sr_depan->tk_bocor, 2) : '-' ?></td>
                                                <td class="text-end <?= $selisih_tk_bocor >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_tk_bocor, 2, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pola Konsumsi (m³/SR/bln)</td>
                                                <td class="text-end"><?= isset($potensi_sr_ini->pola_kon) ? number_format($potensi_sr_ini->pola_kon, 2) : '-' ?></td>
                                                <td class="text-end"><?= isset($potensi_sr_depan->pola_kon) ? number_format($potensi_sr_depan->pola_kon, 2) : '-' ?></td>
                                                <td class="text-end <?= $selisih_pola_kon >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih_pola_kon, 2, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold">Evaluasi UPK</h5>
                                <div class="table-responsive" style="max-height:300px; overflow-y:auto;">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th>Uraian</th>
                                                <th>Sat</th>
                                                <th>RKAP</th>
                                                <th>Realisasi</th>
                                                <th>Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($evaluasi_upk_ini)) : ?>
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($evaluasi_upk_ini as $e) :
                                                    $selisih = $e->rkap - $e->realisasi;
                                                ?>
                                                    <tr>
                                                        <td><?= $e->uraian_evaluasi ?></td>
                                                        <td class="text-center"><?= $e->satuan ?></td>
                                                        <td class="text-end"><?= number_format($e->rkap, 0, ',', '.') ?></td>
                                                        <td class="text-end"><?= number_format($e->realisasi, 0, ',', '.') ?></td>
                                                        <td class="text-end <?= $selisih >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih, 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Grafik Potensi SR</h5>
                                <canvas id="myChartPotensi" height="70"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold">Grafik Laba Rugi</h5>
                                <canvas id="myChartLabaRugi" height="70"></canvas>
                            </div>
                        </div>

                        <script>
                            window.onload = function() {
                                new Chart(document.getElementById('myChartLabaRugi'), {
                                    type: 'bar',
                                    data: {
                                        labels: ['Pendapatan Usaha', 'Beban Usaha', 'Laba Usaha', 'Laba Sebelum Pajak'],
                                        datasets: [{
                                            label: '<?= $tahun_ini - 1 ?>',
                                            backgroundColor: 'rgba(0,123,255,0.7)',
                                            data: [<?= $total_pendapatan_ini ?>, <?= $total_beban_ini ?>, <?= $laba_usaha_ini ?>, <?= $laba_bersih_ini ?>]
                                        }, {
                                            label: '<?= $tahun_depan - 1 ?>',
                                            backgroundColor: 'rgba(40,167,69,0.7)',
                                            data: [<?= $total_pendapatan_depan ?>, <?= $total_beban_depan ?>, <?= $laba_usaha_depan ?>, <?= $laba_bersih_depan ?>]
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                });

                                new Chart(document.getElementById('myChartPotensi'), {
                                    type: 'bar',
                                    data: {
                                        labels: ['Pelanggan Aktif', 'Tambahan SR', 'Kap. Produksi', 'Kap. Manfaat', 'Tk. Kebocoran', 'Pola Konsumsi'],
                                        datasets: [{
                                            label: '<?= $tahun_ini - 1 ?>',
                                            backgroundColor: 'rgba(0,123,255,0.7)',
                                            yAxisID: 'y-left',
                                            data: [
                                                <?= isset($potensi_sr_ini->plg_aktif) ? $potensi_sr_ini->plg_aktif : 0 ?>,
                                                <?= isset($potensi_sr_ini->tambah_sr) ? $potensi_sr_ini->tambah_sr : 0 ?>,
                                                null, null, null, null
                                            ]
                                        }, {
                                            label: '<?= $tahun_depan - 1 ?>',
                                            backgroundColor: 'rgba(40,167,69,0.7)',
                                            yAxisID: 'y-left',
                                            data: [
                                                <?= isset($potensi_sr_depan->plg_aktif) ? $potensi_sr_depan->plg_aktif : 0 ?>,
                                                <?= isset($potensi_sr_depan->tambah_sr) ? $potensi_sr_depan->tambah_sr : 0 ?>,
                                                null, null, null, null
                                            ]
                                        }, {
                                            label: '<?= $tahun_ini - 1 ?> (detail)',
                                            backgroundColor: 'rgba(0,123,255,0.4)',
                                            yAxisID: 'y-right',
                                            data: [
                                                null, null,
                                                <?= isset($potensi_sr_ini->kap_pro) ? $potensi_sr_ini->kap_pro : 0 ?>,
                                                <?= isset($potensi_sr_ini->kap_manf) ? $potensi_sr_ini->kap_manf : 0 ?>,
                                                <?= isset($potensi_sr_ini->tk_bocor) ? $potensi_sr_ini->tk_bocor : 0 ?>,
                                                <?= isset($potensi_sr_ini->pola_kon) ? $potensi_sr_ini->pola_kon : 0 ?>
                                            ]
                                        }, {
                                            label: '<?= $tahun_depan - 1 ?> (detail)',
                                            backgroundColor: 'rgba(40,167,69,0.4)',
                                            yAxisID: 'y-right',
                                            data: [
                                                null, null,
                                                <?= isset($potensi_sr_depan->kap_pro) ? $potensi_sr_depan->kap_pro : 0 ?>,
                                                <?= isset($potensi_sr_depan->kap_manf) ? $potensi_sr_depan->kap_manf : 0 ?>,
                                                <?= isset($potensi_sr_depan->tk_bocor) ? $potensi_sr_depan->tk_bocor : 0 ?>,
                                                <?= isset($potensi_sr_depan->pola_kon) ? $potensi_sr_depan->pola_kon : 0 ?>
                                            ]
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                id: 'y-left',
                                                position: 'left',
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }, {
                                                id: 'y-right',
                                                position: 'right',
                                                ticks: {
                                                    beginAtZero: true
                                                },
                                                gridLines: {
                                                    drawOnChartArea: false
                                                }
                                            }]
                                        },
                                        legend: {
                                            display: true
                                        }
                                    }
                                });
                            };
                        </script>

                    <?php endif; ?>

                    <?php if (empty($is_amdk)) : ?>
                        <!-- ============ PERBANDINGAN TARGET UPK ============ -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold">Perbandingan Target Pelanggan (RKAP) <?= $tahun_lalu ?> vs <?= $tahun_sekarang ?></h5>
                                    <!-- <a href="<?= base_url('admin/dashboard_upk/export_pdf?id_upk=' . $selected_upk) ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa-solid fa-file-pdf"></i> Export PDF</a> -->
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm" style="font-size:0.8rem">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th style="min-width:120px">Uraian</th>
                                                <th style="min-width:50px">Thn</th>
                                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                    <th><?= date("M", mktime(0, 0, 0, $m, 1)) ?></th>
                                                <?php endfor; ?>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $kd_map = [
                                                'sr_baru' => ['label' => 'SR Baru', 'kd' => 2],
                                                'penutupan' => ['label' => 'Penutupan', 'kd' => 3],
                                                'pembukaan' => ['label' => 'Pembukaan', 'kd' => 4],
                                                'pencabutan' => ['label' => 'Pencabutan', 'kd' => 5],
                                                'tera_meter' => ['label' => 'Tera Meter', 'kd' => 'tm'],
                                                'ganti_meter' => ['label' => 'Ganti Meter', 'kd' => 'gm'],
                                                'efi_tagih' => ['label' => 'Efisiensi Tagih (%)', 'kd' => 'et'],
                                            ];
                                            foreach ($kd_map as $fld => $info) :
                                                $total_lalu = 0;
                                                $total_sekarang = 0;
                                                for ($m = 1; $m <= 12; $m++) {
                                                    if (in_array($info['kd'], [2, 3, 4, 5])) {
                                                        $v_lalu = $pelanggan_lalu[$m][$info['kd']] ?? 0;
                                                        $v_sekarang = $pelanggan_sekarang[$m][$info['kd']] ?? 0;
                                                    } else {
                                                        $col = ($info['kd'] == 'tm') ? 'tera_meter' : (($info['kd'] == 'gm') ? 'ganti_meter' : 'efi_tagih');
                                                        $v_lalu = isset($extra_lalu[$m]) ? (float)($extra_lalu[$m]->$col ?? 0) : 0;
                                                        $v_sekarang = isset($extra_sekarang[$m]) ? (float)($extra_sekarang[$m]->$col ?? 0) : 0;
                                                    }
                                                    $total_lalu += $v_lalu;
                                                    $total_sekarang += $v_sekarang;
                                                    ${'row_' . $fld . '_lalu'}[$m] = $v_lalu;
                                                    ${'row_' . $fld . '_sekarang'}[$m] = $v_sekarang;
                                                }
                                                if ($fld == 'efi_tagih') {
                                                    $total_lalu = $total_lalu / 12;
                                                    $total_sekarang = $total_sekarang / 12;
                                                }
                                            ?>
                                                <tr class="table-secondary fw-bold">
                                                    <td colspan="15"><?= $info['label'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $tahun_lalu ?></td>
                                                    <?php for ($m = 1; $m <= 12; $m++) : $val = ${'row_' . $fld . '_lalu'}[$m]; ?>
                                                        <td class="text-end"><?= $fld == 'efi_tagih' ? number_format($val, 2, ',', '.') . '%' : number_format($val, 0, ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold"><?= $fld == 'efi_tagih' ? number_format($total_lalu, 2, ',', '.') . '%' : number_format($total_lalu, 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $tahun_sekarang ?></td>
                                                    <?php for ($m = 1; $m <= 12; $m++) : $val = ${'row_' . $fld . '_sekarang'}[$m]; ?>
                                                        <td class="text-end"><?= $fld == 'efi_tagih' ? number_format($val, 2, ',', '.') . '%' : number_format($val, 0, ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold"><?= $fld == 'efi_tagih' ? number_format($total_sekarang, 2, ',', '.') . '%' : number_format($total_sekarang, 0, ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Selisih</td>
                                                    <?php for ($m = 1; $m <= 12; $m++) :
                                                        $sel = ${'row_' . $fld . '_sekarang'}[$m] - ${'row_' . $fld . '_lalu'}[$m];
                                                    ?>
                                                        <td class="text-end <?= $sel >= 0 ? 'text-success' : 'text-danger' ?>"><?= $fld == 'efi_tagih' ? number_format($sel, 2, ',', '.') . '%' : number_format($sel, 0, ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold <?= ($total_sekarang - $total_lalu) >= 0 ? 'text-success' : 'text-danger' ?>"><?= $fld == 'efi_tagih' ? number_format($total_sekarang - $total_lalu, 2, ',', '.') . '%' : number_format($total_sekarang - $total_lalu, 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="fw-bold">Perbandingan Target Pendapatan (RKAP) <?= $tahun_lalu ?> vs <?= $tahun_sekarang ?></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm" style="font-size:0.8rem">
                                        <thead class="text-center table-dark">
                                            <tr>
                                                <th style="min-width:120px">Uraian</th>
                                                <th style="min-width:50px">Thn</th>
                                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                    <th><?= date("M", mktime(0, 0, 0, $m, 1)) ?></th>
                                                <?php endfor; ?>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pend_fields = [
                                                'jml_rekening' => 'Jumlah Rekening',
                                                'pemakaian' => 'Pemakaian (m³)',
                                                'pendapatan' => 'Pendapatan (Rp)',
                                                'pola_konsumsi' => 'Pola Konsumsi (m³/rek)',
                                            ];
                                            foreach ($pend_fields as $fld => $label) :
                                                if ($fld == 'pola_konsumsi') {
                                                    $total_lalu = 0;
                                                    $total_sekarang = 0;
                                                    for ($m = 1; $m <= 12; $m++) {
                                                        $jml_lalu = $jml_rekening_lalu[$m] ?? 0;
                                                        $jml_sekarang = $jml_rekening_sekarang[$m] ?? 0;
                                                        $pakai_lalu = $pemakaian_lalu[$m] ?? 0;
                                                        $pakai_sekarang = $pemakaian_sekarang[$m] ?? 0;
                                                        ${'row_lalu'}[$m] = $jml_lalu > 0 ? round($pakai_lalu / $jml_lalu, 2) : 0;
                                                        ${'row_sekarang'}[$m] = $jml_sekarang > 0 ? round($pakai_sekarang / $jml_sekarang, 2) : 0;
                                                        $total_lalu += ${'row_lalu'}[$m];
                                                        $total_sekarang += ${'row_sekarang'}[$m];
                                                    }
                                                } else {
                                                    $arr_lalu = ${$fld . '_lalu'};
                                                    $arr_sekarang = ${$fld . '_sekarang'};
                                                    $total_lalu = array_sum($arr_lalu);
                                                    $total_sekarang = array_sum($arr_sekarang);
                                                    for ($m = 1; $m <= 12; $m++) {
                                                        ${'row_lalu'}[$m] = $arr_lalu[$m] ?? 0;
                                                        ${'row_sekarang'}[$m] = $arr_sekarang[$m] ?? 0;
                                                    }
                                                }
                                            ?>
                                                <tr class="table-secondary fw-bold">
                                                    <td colspan="15"><?= $label ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $tahun_lalu ?></td>
                                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                        <td class="text-end"><?= $fld == 'pendapatan' ? number_format(${'row_lalu'}[$m], 0, ',', '.') : number_format(${'row_lalu'}[$m], ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold"><?= $fld == 'pendapatan' ? number_format($total_lalu, 0, ',', '.') : number_format($total_lalu, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $tahun_sekarang ?></td>
                                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                        <td class="text-end"><?= $fld == 'pendapatan' ? number_format(${'row_sekarang'}[$m], 0, ',', '.') : number_format(${'row_sekarang'}[$m], ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold"><?= $fld == 'pendapatan' ? number_format($total_sekarang, 0, ',', '.') : number_format($total_sekarang, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Selisih</td>
                                                    <?php for ($m = 1; $m <= 12; $m++) :
                                                        $sel = ${'row_sekarang'}[$m] - ${'row_lalu'}[$m];
                                                    ?>
                                                        <td class="text-end <?= $sel >= 0 ? 'text-success' : 'text-danger' ?>"><?= $fld == 'pendapatan' ? number_format($sel, 0, ',', '.') : number_format($sel, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold <?= ($total_sekarang - $total_lalu) >= 0 ? 'text-success' : 'text-danger' ?>"><?= $fld == 'pendapatan' ? number_format($total_sekarang - $total_lalu, 0, ',', '.') : number_format($total_sekarang - $total_lalu, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>