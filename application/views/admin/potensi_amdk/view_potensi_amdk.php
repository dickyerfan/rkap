<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold neumorphic-button" target="_blank" href="<?= base_url('admin/potensi_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><i class="fa-solid fa-file-pdf"></i> Export PDF</a>
                        </div>
                        <!-- <div class="nav-item dropdown ms-auto">
                            <a class="nav-link dropdown-toggle fw-bold neumorphic-button" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem; color:black;">Input Data</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= base_url('admin/potensi_amdk/upload') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Input Pendapatan</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('admin/potensi_amdk/upload_biaya') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-upload "></i> Input Biaya</a></li>
                            </ul>
                        </div> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  date('Y') + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <table class="table table-sm table-bordered" id="example3" style="font-size: 1rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4 fw-bold">Pendapatan</td>
                                        <td class="text-end pe-4"></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Pendapatan Air</td>
                                        <td class="text-end pe-4"><?= number_format($total_pend_air, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Pendapatan Non Air</td>
                                        <td class="text-end pe-4"><?= number_format($total_pendNon_air, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Jumlah Pendapatan</td>
                                        <td class="text-end pe-4"><?= number_format($total_pend_air + $total_pendNon_air, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Biaya</td>
                                        <td class="text-end pe-4"></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Pegawai</td>
                                        <td class="text-end pe-4"><?= number_format($total_by_peg, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Biaya Operasional</td>
                                        <td class="text-end pe-4"><?= number_format($total_by_ops, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4 fw-bold">Jumlah Biaya</td>
                                        <td class="text-end pe-4"><?= number_format($total_by_peg + $total_by_ops, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th class=" fw-bold ps-4">LABA / RUGI</th>
                                        <th class="text-end pe-4"><?= number_format($laba_rugi, 0, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title1 . ' ' .  date('Y') + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example5" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Uraian</th>
                                        <th class="text-center">Tarif</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Total</th>
                                        <!-- <th class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $grandTotal = 0; // untuk menampung total semua
                                    $grandJumlah = 0; // untuk menampung jumlah semua
                                    foreach ($produksi as $row) :
                                        $id = $row->id_potensi_amdk;
                                        $total = $row->harga * $row->jumlah;
                                        $grandTotal += $total; // akumulasi total
                                        $grandJumlah += $row->jumlah; // akumulasi jumlah
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td class="ps-4"><?= $row->uraian; ?></td>
                                            <td class="ps-4"><?= $row->tarif; ?></td>
                                            <td class="text-end pe-3"><?= number_format($row->harga, 0, ',', '.'); ?></td>
                                            <td class="text-end pe-3"><?= number_format($row->jumlah, 0, ',', '.'); ?></td>
                                            <td class="text-end pe-3"><?= number_format($total, 0, ',', '.'); ?></td>
                                            <!-- <td class="text-center">
                                                <a href="<?= base_url('rkap/potensi_amdk/edit_potensi_amdk/') ?><?= $id ?>">
                                                    <i class="fas fa-edit text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Edit Data"></i>
                                                </a>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end pe-3 fw-bold">Total</th>
                                        <th class="text-end pe-3 fw-bold"><?= number_format($grandJumlah, 0, ',', '.'); ?></th>
                                        <th class="text-end pe-3 fw-bold"><?= number_format($grandTotal, 0, ',', '.'); ?></th>
                                        <!-- <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title2 . ' ' .  date('Y') + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example6" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tipe Biaya</th>
                                        <th class="text-center">Nama Biaya</th>
                                        <th class="text-center">Rincian Biaya</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Jumlah</th>
                                        <!-- <th class="text-center">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $grandJumlah = 0; // untuk menampung jumlah semua
                                    foreach ($biaya as $row) :
                                        $id = $row->id_biaya_amdk;
                                        $grandJumlah += $row->jumlah; // akumulasi jumlah
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++; ?></td>
                                            <td class="ps-4"><?= $row->tipe_biaya; ?></td>
                                            <td class="text-start"><?= $row->nama_biaya; ?></td>
                                            <td class="text-start"><?= $row->rincian_biaya; ?></td>
                                            <td class="text-start"><?= $row->keterangan; ?></td>
                                            <td class="text-end pe-3"><?= number_format($row->jumlah, 0, ',', '.'); ?></td>
                                            <!-- <td class="text-center">
                                                <a href="<?= base_url('rkap/potensi_amdk/edit_biaya_amdk/') ?><?= $id ?>">
                                                    <i class="fas fa-edit text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Klik Untuk Edit Data"></i>
                                                </a>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end pe-3 fw-bold">Total</th>
                                        <th class="text-end pe-3 fw-bold"><?= number_format($grandJumlah, 0, ',', '.'); ?></th>
                                        <!-- <th></th> -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>