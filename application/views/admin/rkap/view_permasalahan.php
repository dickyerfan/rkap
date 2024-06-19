<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Bagian & Tahun</a>
                        <form action="<?= base_url('admin/permasalahan') ?>" method="post">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select select2" style="width: 150px; " aria-label="Default select example">
                                    <option value="langganan" <?= isset($seleksi) && $seleksi->bagian_upk == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                    <option value="umum" <?= isset($seleksi) && $seleksi->bagian_upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="keuangan" <?= isset($seleksi) && $seleksi->bagian_upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="perencanaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="pemeliharaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="spi" <?= isset($seleksi) && $seleksi->bagian_upk == 'spi' ? 'selected' : '' ?>>SPI</option>
                                    <option value="amdk" <?= isset($seleksi) && $seleksi->bagian_upk == 'amdk' ? 'selected' : '' ?>>A M D K</option>
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
                            <h5><?= $title . ' ' .  $tahun ?></h5>
                            <h5>BAGIAN <?= strtoupper($namaUpk);  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub Bagian</th>
                                        <th>Permasalahan</th>
                                        <th>Penyebab</th>
                                        <th>Tindak Lanjut</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_permasalahan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->sub_bagian ?></td>
                                            <td><?= $row->permasalahan ?></td>
                                            <td><?= $row->penyebab ?></td>
                                            <td><?= $row->tindak_lanjut ?></td>
                                            <!-- <td class="text-center">
                                                <a href="<?= base_url('rkap/permasalahan/edit_permasalahan/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('rkap/permasalahan/detail_permasalahan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('rkap/permasalahan/hapus_permasalahan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td> -->
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
                        <h5 class="modal-title" id="exampleModalLabel"> <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Bagian & Tahun</a></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form action="<?= base_url('admin/permasalahan/export_pdf') ?>" method="post" target="_blank">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian_upk" class="form-select select2" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="langganan" <?= isset($seleksi) && $seleksi->bagian_upk == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                    <option value="umum" <?= isset($seleksi) && $seleksi->bagian_upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="keuangan" <?= isset($seleksi) && $seleksi->bagian_upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="perencanaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="pemeliharaan" <?= isset($seleksi) && $seleksi->bagian_upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="spi" <?= isset($seleksi) && $seleksi->bagian_upk == 'spi' ? 'selected' : '' ?>>SPI</option>
                                    <option value="amdk" <?= isset($seleksi) && $seleksi->bagian_upk == 'amdk' ? 'selected' : '' ?>>A M D K</option>
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