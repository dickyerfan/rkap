<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('admin/rekap_sr/rekap_rkap') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <select name="tahun" class="form-select" style="width: 100px;">
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
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('admin/rekap_sr/export_pdf_rkap') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('admin/rekap_sr') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Kembali</button> </a>
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
                            <h5><?= $title . ' ' .  $tahun + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <table class="table table-sm table-bordered" id="example3" style="font-size: 1rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 fw-bold">Pendapatan</td>
                                        <td></td>
                                        <td class="text-end pe-4"></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Pendapatan Air</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($pendapatan_air_total, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Pendapatan Non Air</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($pendapatan_non_air, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Pendapatan AMDK</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($total_pend_amdk, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Jumlah Pendapatan</td>
                                        <td></td>
                                        <td class="text-end pe-4 fw-bold"><?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Biaya</td>
                                        <td></td>
                                        <td class="text-end pe-4"></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Usulan Barang</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($biayaUsulanBarang, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Usulan Investasi</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($biayaUsulanInvestasi, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Usulan Pemeliharaan</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($biayaUsulanPemeliharaan, 0, ',', '.'); ?></td>
                                    <tr>
                                        <td class="ps-4">Biaya Usulan Pegawai & Umum</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($biayaUsulanUmum, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Usulan AMDK</td>
                                        <td></td>
                                        <td class="text-end pe-4"><?= number_format($total_biaya_amdk, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Jumlah Biaya</td>
                                        <td></td>
                                        <td class="text-end pe-4 fw-bold"><?= number_format($total_biaya, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th class=" fw-bold ps-4">LABA / RUGI</th>
                                        <td></td>
                                        <th class="text-end pe-4"><?= number_format($laba_rugi, 0, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>