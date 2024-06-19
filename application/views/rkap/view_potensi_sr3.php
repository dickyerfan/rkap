<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/Potensi_sr/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <?php
                foreach ($tampil as $row) :
                    $produksi_air = $row->kap_manf * $row->jam_op * 108;
                    $kebocoran_air = $produksi_air * 0.3;
                    $air_pelanggan = $produksi_air - $kebocoran_air;
                    $kebutuhan_air = $row->pola_kon * ($row->plg_aktif + $row->tambah_sr);
                    $sisa_air = $air_pelanggan - $kebutuhan_air;
                    $potensi = $sisa_air / $row->pola_kon;

                ?>
                    <div class="card">
                        <div class="row justify-content-center p-2">
                            <div class="col-lg-6 text-center">
                                <h5>UPK <?= strtoupper($row->bagian_upk);  ?></h5>
                                <h6>Data Riil <?= $row->tahun_rkap ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row justify-content-center p-3">
                            <div class="col-lg-3">
                                <h6>Kapasitas Produksi</h6>
                                <h6>Kapasitas yang Dimanfaatkan</h6>
                                <h6>Jam Operasional</h6>
                                <h6>Tingkat Kebocoran</h6>
                                <h6>Jumlah Pelanggan Aktif(DRD Juli 2023)</h6>
                                <h6>Tambahan SR s/d akhir tahun 2023</h6>
                                <h6>Pola Konsumsi rata2(s/d Juli 2023)</h6>
                            </div>
                            <div class="col-lg-1 text-center">
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-1 text-center">
                                <h6><?= number_format($row->kap_pro, 2, ',', '.'); ?></h6>
                                <h6><?= number_format($row->kap_manf, 2, ',', '.'); ?></h6>
                                <h6><?= number_format($row->jam_op, 1, ',', '.'); ?></h6>
                                <h6><?= number_format($row->tk_bocor, 0, ',', '.'); ?></h6>
                                <h6><?= number_format($row->plg_aktif, 0, ',', '.'); ?></h6>
                                <h6><?= number_format($row->tambah_sr, 0, ',', '.'); ?></h6>
                                <h6><?= number_format($row->pola_kon, 1, ',', '.'); ?></h6>
                            </div>
                            <div class="col-lg-3">
                                <h6>liter/detik</h6>
                                <h6>liter/detik</h6>
                                <h6>jam/hari</h6>
                                <h6>% (Persentase)</h6>
                                <h6>SR (Sambungan Rumah)</h6>
                                <h6>asumsi</h6>
                                <h6>M3 (Meter Kubik)</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row justify-content-center p-3">
                            <h6 class="text-center">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></h6>
                            <div class="col-lg-4">
                                <h6>Produksi air 1 tahun</h6>
                                <h6>Kebocoran air (....%)</h6>
                                <h6>Air yang didistribusikan ke pelanggan</h6>
                                <h6>Kebutuhan air</h6>
                                <h6>Sisa Air</h6>
                                <h6>Potensi penambahan pelanggan tahun 2024</h6>
                            </div>

                            <div class="col-lg-3 text-center">
                                <h6><?= number_format($row->kap_manf, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</h6>
                                <h6>30 %</h6>
                                <h6>-</h6>
                                <h6><?= number_format($row->plg_aktif + $row->tambah_sr, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 1, ',', '.') ?></h6>
                                <h6>-</h6>
                                <h6><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 1, ',', '.'); ?></h6>
                            </div>
                            <div class="col-lg-1 text-center">
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                                <h6>:</h6>
                            </div>
                            <div class="col-lg-1 text-end">
                                <h6><?= number_format($produksi_air, 2, ',', '.');  ?></h6>
                                <h6><?= number_format($kebocoran_air, 2, ',', '.'); ?></h6>
                                <h6><?= number_format($air_pelanggan, 2, ',', '.'); ?></h6>
                                <h6><?= number_format($kebutuhan_air, 2, ',', '.');
                                    ?></h6>
                                <h6><?= number_format($sisa_air, 2, ',', '.');
                                    ?></h6>
                                <h6><?= number_format($potensi, 0, ',', '.')  ?></h6>
                            </div>
                            <div class="col-lg-1">
                                <h6>M3</h6>
                                <h6>M3</h6>
                                <h6>M3</h6>
                                <h6>M3</h6>
                                <h6>M3</h6>
                                <h6>SR</h6>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>