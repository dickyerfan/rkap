<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a>
                        <form action="<?= base_url('admin/potensi_sr') ?>" method="post">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="bondowoso">Bondowoso</option>
                                    <option value="sukosari1">Sukosari 1</option>
                                    <option value="maesan">Maesan</option>
                                    <option value="tegalampel">Tegalampel</option>
                                    <option value="tapen">Tapen</option>
                                    <option value="prajekan">Prajekan</option>
                                    <option value="tlogosari">Tlogosari</option>
                                    <option value="wringin">Wringin</option>
                                    <option value="curahdami">Curahdami</option>
                                    <option value="tamanan">Tamanan</option>
                                    <option value="tenggarang">Tenggarang</option>
                                    <option value="tamankrocok">Tamankrocok</option>
                                    <option value="wonosari">Wonosari</option>
                                    <option value="klabang">Klabang</option>
                                    <option value="sukosari2">Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="#" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title) ?></h5>
                            <h5>UPK <?= strtoupper($namaUpk);  ?></h5>
                            <h6 class="text-uppercase">Data Riil <?= $tahun; ?></h6>
                        </div>
                    </div>
                    <?php
                    foreach ($tampil as $row) :
                        $produksi_air = $row->kap_pro * $row->jam_op * 108;
                        $pelanggan_aktif = $row->plg_aktif;
                        $pola_kon = $row->pola_kon;
                        $kap_manf = $pelanggan_aktif * $pola_kon;
                        $kebocoran_air_persen = $row->tk_bocor;
                        $kebocoran_air = $produksi_air * $kebocoran_air_persen / 100;

                        $air_pelanggan = $produksi_air - $kebocoran_air;
                        $kebutuhan_air = $row->pola_kon * ($row->plg_aktif + $row->tambah_sr);
                        $sisa_air = $air_pelanggan - $kebutuhan_air;
                        $potensi = $sisa_air / $row->pola_kon;
                    ?>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Kapasitas Produksi</td>
                                            <td>:</td>
                                            <td><?= number_format($row->kap_pro, 2, ',', '.'); ?></td>
                                            <td>liter/detik</td>
                                        </tr>
                                        <!-- <tr>
                                            <td>Kapasitas yang Dimanfaatkan</td>
                                            <td>:</td>
                                            <td><?= number_format($row->kap_manf, 2, ',', '.'); ?></td>
                                            <td>liter/detik</td>
                                        </tr> -->
                                        <tr>
                                            <td>Jam Operasional</td>
                                            <td>:</td>
                                            <td><?= number_format($row->jam_op, 1, ',', '.'); ?></td>
                                            <td>jam/hari</td>
                                        </tr>
                                        <tr>
                                            <td>Tingkat Kebocoran</td>
                                            <td>:</td>
                                            <td><?= number_format($row->tk_bocor, 2, ',', '.'); ?></td>
                                            <td>% (Persentase)</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Pelanggan Aktif (DRD Juli <?= $row->tahun_rkap ?>)</td>
                                            <td>:</td>
                                            <td><?= number_format($row->plg_aktif, 0, ',', '.'); ?></td>
                                            <td>SR (Sambungan Rumah)</td>
                                        </tr>
                                        <tr>
                                            <td>Tambahan SR s/d akhir tahun <?= $row->tahun_rkap ?></td>
                                            <td>:</td>
                                            <td><?= number_format($row->tambah_sr, 0, ',', '.'); ?></td>
                                            <td>asumsi</td>
                                        </tr>
                                        <tr>
                                            <td>Pola Konsumsi rata2 (s/d Juli <?= $row->tahun_rkap ?>)</td>
                                            <td>:</td>
                                            <td><?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                            <td>M3 (Meter Kubik)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h6 class="text-center">Perhitungan Estimasi Tahun <?= $row->tahun_rkap + 1 ?></h6>
                        <div class="row justify-content-center p-3">
                            <div class="col-lg-9">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Produksi air 1 bulan</td>
                                            <td><?= number_format($row->kap_pro, 2, ',', '.'); ?> x <?= number_format($row->jam_op, 1, ',', '.'); ?> x 30 x 3.600 / 1.000</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($produksi_air, 2, ',', '.');  ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Kebocoran air (....%)</td>
                                            <td><?= number_format($row->tk_bocor, 2, ',', '.')  ?> %</td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($kebocoran_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Air yang didistribusikan ke pelanggan</td>
                                            <td><?= number_format($produksi_air, 2, ',', '.') ?> - <?= number_format($kebocoran_air, 2, ',', '.') ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($air_pelanggan, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Kebutuhan air</td>
                                            <td><?= number_format($row->plg_aktif + $row->tambah_sr, 0, ',', '.') ?> x <?= number_format($row->pola_kon, 2, ',', '.') ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($kebutuhan_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Sisa Air</td>
                                            <td><?= number_format($air_pelanggan, 2, ',', '.') ?> - <?= number_format($kebutuhan_air, 2, ',', '.') ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($sisa_air, 2, ',', '.'); ?></td>
                                            <td>M3</td>
                                        </tr>
                                        <tr>
                                            <td>Potensi penambahan pelanggan tahun <?= $row->tahun_rkap + 1 ?></td>
                                            <td><?= number_format($sisa_air, 2, ',', '.')  ?> / <?= number_format($row->pola_kon, 2, ',', '.'); ?></td>
                                            <td>:</td>
                                            <td class="text-end"><?= number_format($potensi, 0, ',', '.')  ?></td>
                                            <td>SR</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            <?php endforeach; ?>

            <div class="card-body">
                <div class="row justify-content-center px-3">
                    <div class="col-lg-9">
                        <h6>Keterangan :</h6>
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>1. Kemampuan Penambahan SR baru <?= $totalSr ?> SR</td>
                                </tr>
                                <tr>
                                    <td>2. Pemetaan Lokasi : (Dijelaskan apabila dibutuhkan tambahan jaringan)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center px-3">
                    <div class="col-lg-9 ps-5">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach ($keterangan as $row) : ?>
                                    <tr>
                                        <td><?= $row->nama_wil ?></td>
                                        <td>:</td>
                                        <td><?= $row->jumlah_sr ?></td>
                                        <td>SR</td>
                                        <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_ket_potensi/' . $row->id_ket_potensi) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row justify-content-center p-3">
                    <div class="col-lg-9">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <tr>
                                    <td>3. Perlu adanya penambahan air baku :</td>
                                </tr>
                            </tbody>
                        </table>
                        <?php if (empty($airBaku)) : ?>
                            <p class="text-danger">Belum ada Penambahan air baku yang diinputkan.</p>
                        <?php else : ?>
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <?php foreach ($airBaku as $row) : ?>
                                        <tr>
                                            <td width="90%" class="ps-4">
                                                <li><?= $row->uraian ?></li>
                                            </td>
                                            <!-- <td><a href="<?= base_url('rkap/potensi_sr/edit_air_baku/' . $row->id_tambah_air_baku) ?>"><span class="neumorphic-button text-dark"><i class="fas fa-edit"></i> Edit</span></a></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="<?= base_url('admin/potensi_sr/export_pdf') ?>" method="post" target="_blank">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="bondowoso">Bondowoso</option>
                                    <option value="sukosari1">Sukosari 1</option>
                                    <option value="maesan">Maesan</option>
                                    <option value="tegalampel">Tegalampel</option>
                                    <option value="tapen">Tapen</option>
                                    <option value="prajekan">Prajekan</option>
                                    <option value="tlogosari">Tlogosari</option>
                                    <option value="wringin">Wringin</option>
                                    <option value="curahdami">Curahdami</option>
                                    <option value="tamanan">Tamanan</option>
                                    <option value="tenggarang">Tenggarang</option>
                                    <option value="tamankrocok">Tamankrocok</option>
                                    <option value="wonosari">Wonosari</option>
                                    <option value="klabang">Klabang</option>
                                    <option value="sukosari2">Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button" data-bs-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>