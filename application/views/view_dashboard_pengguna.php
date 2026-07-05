<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <?= $this->session->flashdata('info'); ?>
            <?= $this->session->unset_userdata('info'); ?>
            <div class="card border-0">
                <!-- <div class="card-header shadow text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Dashboard RKAP <?= strtoupper($nama_upk) ?> — Perbandingan <?= $tahun_ini ?> / <?= $tahun_depan ?></span>
                    </marquee>
                </div> -->
                <div class="card-header shadow text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Halaman RKAP PDAM Bondowoso</span>
                    </marquee>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Ringkasan Laba Rugi</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="text-center table-dark">
                                        <tr>
                                            <th style="width: 35%;">Uraian</th>
                                            <th style="width: 20%;">Tahun <?= $tahun_ini ?> (Rp)</th>
                                            <th style="width: 20%;">Tahun <?= $tahun_depan ?> (Rp)</th>
                                            <th style="width: 25%;">Selisih (Rp)</th>
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
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
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
                            <div class="chart-bar">
                                <canvas id="myChartPotensiSR" width="100%" height="50"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">Grafik Laba Rugi</h5>
                            <div class="chart-bar">
                                <canvas id="myChartLabaRugi" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.onload = function() {
            var ctxLabaRugi = document.getElementById('myChartLabaRugi');
            var myChartLabaRugi = new Chart(ctxLabaRugi, {
                type: 'bar',
                data: {
                    labels: ['Pendapatan Usaha', 'Beban Usaha', 'Laba Usaha', 'Laba Sebelum Pajak'],
                    datasets: [{
                        label: 'Tahun <?= $tahun_ini ?>',
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        data: [<?= $total_pendapatan_ini ?>, <?= $total_beban_ini ?>, <?= $laba_usaha_ini ?>, <?= $laba_bersih_ini ?>]
                    }, {
                        label: 'Tahun <?= $tahun_depan ?>',
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        data: [<?= $total_pendapatan_depan ?>, <?= $total_beban_depan ?>, <?= $laba_usaha_depan ?>, <?= $laba_bersih_depan ?>]
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                callback: function(value) {
                                    return value.toLocaleString('id-ID');
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel.toLocaleString('id-ID');
                            }
                        }
                    },
                    legend: {
                        display: true
                    }
                }
            });

            var ctxPotensi = document.getElementById('myChartPotensiSR');
            var myChartPotensi = new Chart(ctxPotensi, {
                type: 'line',
                data: {
                    labels: ['Pelanggan Aktif', 'Tambahan SR', 'Kap. Produksi', 'Kap. Manfaat', 'Tk. Kebocoran', 'Pola Konsumsi'],
                    datasets: [{
                        label: '<?= $tahun_ini - 1 ?>',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                        pointRadius: 5,
                        lineTension: 0.2,
                        data: [
                            <?= isset($potensi_sr_ini->plg_aktif) ? $potensi_sr_ini->plg_aktif : 0 ?>,
                            <?= isset($potensi_sr_ini->tambah_sr) ? $potensi_sr_ini->tambah_sr : 0 ?>,
                            <?= isset($potensi_sr_ini->kap_pro) ? $potensi_sr_ini->kap_pro : 0 ?>,
                            <?= isset($potensi_sr_ini->kap_manf) ? $potensi_sr_ini->kap_manf : 0 ?>,
                            <?= isset($potensi_sr_ini->tk_bocor) ? $potensi_sr_ini->tk_bocor : 0 ?>,
                            <?= isset($potensi_sr_ini->pola_kon) ? $potensi_sr_ini->pola_kon : 0 ?>
                        ]
                    }, {
                        label: '<?= $tahun_depan - 1 ?>',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                        pointRadius: 5,
                        lineTension: 0.2,
                        data: [
                            <?= isset($potensi_sr_depan->plg_aktif) ? $potensi_sr_depan->plg_aktif : 0 ?>,
                            <?= isset($potensi_sr_depan->tambah_sr) ? $potensi_sr_depan->tambah_sr : 0 ?>,
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