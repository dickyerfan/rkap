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
                        <span class="title">Dashboard RKAP AMDK — Perbandingan <?= $tahun_ini ?> / <?= $tahun_depan ?></span>
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
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Ringkasan Laba Rugi AMDK</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="text-center table-dark align-middle" style="height: 50px;">
                                        <tr>
                                            <th style="width: 35%;">Uraian</th>
                                            <th style="width: 20%;">Tahun <?= $tahun_ini ?> (Rp)</th>
                                            <th style="width: 20%;">Tahun <?= $tahun_depan ?> (Rp)</th>
                                            <th style="width: 25%;">Selisih (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" align-middle">
                                        <tr style="height: 60px;">
                                            <td class="fw-bold">Pendapatan Usaha</td>
                                            <td class="text-end fw-bold"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                                            <td class="text-end fw-bold"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                                            <td class="text-end fw-bold <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'text-success' : 'text-danger' ?>">
                                                <?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <tr style="height: 60px;">
                                            <td class="fw-bold">Beban Usaha</td>
                                            <td class="text-end fw-bold"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                                            <td class="text-end fw-bold"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                                            <td class="text-end fw-bold"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr style="height: 60px;">
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

                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Grafik Laba Rugi AMDK</h5>
                            <div class="chart-bar">
                                <canvas id="myChartLabaRugi" width="100%" height="50"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">Grafik Produksi AMDK (RKAP)</h5>
                            <div class="chart-bar">
                                <canvas id="myChartProduksi" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <h5 class="fw-bold">Evaluasi AMDK</h5>
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
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
                                        <?php
                                        $evaluasi_list = [];
                                        foreach ($evaluasi_amdk_ini as $e) {
                                            $evaluasi_list[] = ['jenis' => $e->jenis_uraian, 'uraian' => $e->uraian_evaluasi, 'satuan' => $e->satuan, 'rkap' => $e->rkap, 'realisasi' => $e->realisasi];
                                        }
                                        ?>
                                        <?php if (empty($evaluasi_list)) : ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Belum ada data</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($evaluasi_list as $e) :
                                                $selisih = ($e['rkap'] ?? 0) - ($e['realisasi'] ?? 0);
                                            ?>
                                                <tr>
                                                    <td><?= $e['jenis'] ?></td>
                                                    <td><?= $e['uraian'] ?></td>
                                                    <td class="text-center"><?= $e['satuan'] ?></td>
                                                    <td class="text-end"><?= $e['rkap'] ? number_format($e['rkap'], 0, ',', '.') : '-' ?></td>
                                                    <td class="text-end"><?= $e['realisasi'] ? number_format($e['realisasi'], 0, ',', '.') : '-' ?></td>
                                                    <td class="text-end <?= $selisih >= 0 ? 'text-success' : 'text-danger' ?>"><?= number_format($selisih, 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
                    labels: ['Pendapatan Usaha', 'Beban Usaha', 'Laba Usaha', 'Laba Bersih'],
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

            var ctxProduksi = document.getElementById('myChartProduksi');
            var produksiLabels = [];
            var produksiIni = [];
            var produksiDepan = [];
            <?php foreach ($produk_totals as $prod) : ?>
                produksiLabels.push('<?= str_replace("'", "\\'", $prod['nama']) ?>');
                produksiIni.push(<?= $prod['ini'] ?? 0 ?>);
                produksiDepan.push(<?= $prod['depan'] ?? 0 ?>);
            <?php endforeach; ?>

            var myChartProduksi = new Chart(ctxProduksi, {
                type: 'bar',
                data: {
                    labels: produksiLabels,
                    datasets: [{
                        label: '<?= $tahun_ini ?>',
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        data: produksiIni
                    }, {
                        label: '<?= $tahun_depan ?>',
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        data: produksiDepan
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
        };
    </script>