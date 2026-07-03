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
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="fw-bold">Ringkasan Laba Rugi AMDK</h5>
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
                            <h5 class="fw-bold">Produksi AMDK (Total/tahun)</h5>
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
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead class="text-center table-dark">
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Uraian</th>
                                            <th>Sat</th>
                                            <th>RKAP <?= $tahun_ini ?></th>
                                            <th>RKAP <?= $tahun_depan ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $evaluasi_list = [];
                                        foreach ($evaluasi_amdk_ini as $e) {
                                            $key = $e->jenis_uraian . '|' . $e->uraian_evaluasi;
                                            $evaluasi_list[$key] = ['jenis' => $e->jenis_uraian, 'uraian' => $e->uraian_evaluasi, 'satuan' => $e->satuan, 'rkap_ini' => $e->rkap, 'rkap_depan' => 0];
                                        }
                                        foreach ($evaluasi_amdk_depan as $e) {
                                            $key = $e->jenis_uraian . '|' . $e->uraian_evaluasi;
                                            if (isset($evaluasi_list[$key])) {
                                                $evaluasi_list[$key]['rkap_depan'] = $e->rkap;
                                            } else {
                                                $evaluasi_list[$key] = ['jenis' => $e->jenis_uraian, 'uraian' => $e->uraian_evaluasi, 'satuan' => $e->satuan, 'rkap_ini' => 0, 'rkap_depan' => $e->rkap];
                                            }
                                        }
                                        ?>
                                        <?php if (empty($evaluasi_list)) : ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Belum ada data</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($evaluasi_list as $e) : ?>
                                                <tr>
                                                    <td><?= $e['jenis'] ?></td>
                                                    <td><?= $e['uraian'] ?></td>
                                                    <td class="text-center"><?= $e['satuan'] ?></td>
                                                    <td class="text-end"><?= $e['rkap_ini'] ? number_format($e['rkap_ini'], 0, ',', '.') : '-' ?></td>
                                                    <td class="text-end"><?= $e['rkap_depan'] ? number_format($e['rkap_depan'], 0, ',', '.') : '-' ?></td>
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