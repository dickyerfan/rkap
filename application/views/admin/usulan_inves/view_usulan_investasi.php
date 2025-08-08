<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a>
                        <form action="<?= base_url('admin/usulan_inves') ?>" method="post">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select select2" style="width: 150px; " aria-label="Default select example">
                                    <!-- <option value="langganan" <?= isset($seleksi) && $seleksi->bagian_upk == 'langganan' ? 'selected' : '' ?>>Langganan</option> -->
                                    <option value="umum" <?= isset($seleksi) && $seleksi->bagian_upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <!-- <option value="keuangan" <?= isset($seleksi) && $seleksi->bagian_upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option> -->
                                    <option value="perencanaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="pemeliharaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <!-- <option value="spi" <?= isset($seleksi) && $seleksi->bagian_upk == 'spi' ? 'selected' : '' ?>>SPI</option> -->
                                    <option value="amdk" <?= isset($seleksi) && $seleksi->bagian_upk == 'amdk' ? 'selected' : '' ?>>A M D K</option>
                                    <option value="bondowoso" <?= isset($seleksi) && $seleksi->bagian_upk == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="sukosari1" <?= isset($seleksi) && $seleksi->bagian_upk == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="maesan" <?= isset($seleksi) && $seleksi->bagian_upk == 'maesan' ? 'selected' : '' ?>>Maesan</option>
                                    <option value="tegalampel" <?= isset($seleksi) && $seleksi->bagian_upk == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="tapen" <?= isset($seleksi) && $seleksi->bagian_upk == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="prajekan" <?= isset($seleksi) && $seleksi->bagian_upk == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="tlogosari" <?= isset($seleksi) && $seleksi->bagian_upk == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="wringin" <?= isset($seleksi) && $seleksi->bagian_upk == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="curahdami" <?= isset($seleksi) && $seleksi->bagian_upk == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="tamanan" <?= isset($seleksi) && $seleksi->bagian_upk == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="tenggarang" <?= isset($seleksi) && $seleksi->bagian_upk == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="tamankrocok" <?= isset($seleksi) && $seleksi->bagian_upk == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="wonosari" <?= isset($seleksi) && $seleksi->bagian_upk == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="klabang" <?= isset($seleksi) && $seleksi->bagian_upk == 'klabang' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="sukosari2" <?= isset($seleksi) && $seleksi->bagian_upk == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
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
                            <h5><?= $title . ' ' .  $tahun + 1 ?></h5>
                            <h5>BAGIAN/UPK <?= strtoupper($namaUpk);  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2" class="align-middle">No</th>
                                        <th colspan="2">Perkiraan</th>
                                        <th colspan="5" class="align-middle">URAIAN TENTANG USULAN</th>
                                        <th rowspan="2" class="align-middle">Keterangan</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>No Per</th>
                                        <th>Nama</th>
                                        <th>Latar Belakang</th>
                                        <th>Solusi/Usulan</th>
                                        <th>Volume</th>
                                        <th>Harga</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanInvestasi;
                                        $harga = $row->biaya;
                                        $satuan = $row->volume;
                                        $jumlah = $harga * $satuan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td><?= $row->latar_belakang ?></td>
                                            <td><?= $row->solusi ?></td>
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-center"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <td class="text-center"><?= number_format($jumlah, 0, ',', '.') ?></td>
                                            <td><?= $row->ket ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/usulan_inves/edit_usulan_investasi/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('admin/usulan_inves/detail_usulan_investasi/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('admin/usulan_inves/hapus_usulan_investasi/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                            </table>
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
                        <form action="<?= base_url('admin/usulan_inves/export_pdf') ?>" method="post" target="_blank">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select select2" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <!-- <option value="langganan" <?= isset($seleksi) && $seleksi->bagian_upk == 'langganan' ? 'selected' : '' ?>>Langganan</option> -->
                                    <option value="umum" <?= isset($seleksi) && $seleksi->bagian_upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <!-- <option value="keuangan" <?= isset($seleksi) && $seleksi->bagian_upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option> -->
                                    <option value="perencanaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="pemeliharaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <!-- <option value="spi" <?= isset($seleksi) && $seleksi->bagian_upk == 'spi' ? 'selected' : '' ?>>SPI</option> -->
                                    <option value="amdk" <?= isset($seleksi) && $seleksi->bagian_upk == 'amdk' ? 'selected' : '' ?>>A M D K</option>
                                    <option value="bondowoso" <?= isset($seleksi) && $seleksi->bagian_upk == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="sukosari1" <?= isset($seleksi) && $seleksi->bagian_upk == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="maesan" <?= isset($seleksi) && $seleksi->bagian_upk == 'maesan' ? 'selected' : '' ?>>Maesan</option>
                                    <option value="tegalampel" <?= isset($seleksi) && $seleksi->bagian_upk == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="tapen" <?= isset($seleksi) && $seleksi->bagian_upk == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="prajekan" <?= isset($seleksi) && $seleksi->bagian_upk == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="tlogosari" <?= isset($seleksi) && $seleksi->bagian_upk == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="wringin" <?= isset($seleksi) && $seleksi->bagian_upk == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="curahdami" <?= isset($seleksi) && $seleksi->bagian_upk == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="tamanan" <?= isset($seleksi) && $seleksi->bagian_upk == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="tenggarang" <?= isset($seleksi) && $seleksi->bagian_upk == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="tamankrocok" <?= isset($seleksi) && $seleksi->bagian_upk == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="wonosari" <?= isset($seleksi) && $seleksi->bagian_upk == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="klabang" <?= isset($seleksi) && $seleksi->bagian_upk == 'klabang' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="sukosari2" <?= isset($seleksi) && $seleksi->bagian_upk == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>
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