<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a>
                        <form action="<?= base_url('admin/evaluasi_program') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <select name="bagian" class="form-select" style="width: 150px; margin-right: 10px;" aria-label="Default select example">
                                    <option value="">Pilih Bagian</option>
                                    <option value="spi">S P I</option>
                                    <option value="langganan">Langganan</option>
                                    <option value="umum">Umum</option>
                                    <option value="keuangan">Keuangan</option>
                                    <option value="pemeliharaan">Pemeliharaan</option>
                                    <option value="perencanaan">Perencanaan</option>
                                    <option value="amdk">A M D K</option>
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
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('admin/evaluasi_program') ?>" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"> Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= site_url('admin/evaluasi_program/export_pdf'); ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                            <h5><?= $title . ' ' .  date('Y') ?></h5>
                            <h5>BAGIAN <?= strtoupper($bagian);  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Bagian</th>
                                        <th class="text-center">Evaluasi RKAP Tahun <?= date('Y') ?> </th>
                                        <th class="text-center">Tindak Lanjut</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_evaluasi_program;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row->bagian_upk); ?></td>
                                            <td><?= htmlspecialchars($row->evaluasi); ?></td>
                                            <td><?= htmlspecialchars($row->tindak_lanjut); ?></td>
                                            <td><?= htmlspecialchars($row->keterangan); ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/evaluasi_program/edit_evaluasi_program/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <!-- <a href="<?= base_url('admin/evaluasi_program/detail_evaluasi_program/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <!-- <a href="<?= base_url('admin/evaluasi_program/hapus_evaluasi_program/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title2 . ' ' .  (date('Y') + 1) ?></h5>
                            <h5>BAGIAN <?= strtoupper($bagian);  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example2">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Bagian</th>
                                        <th class="text-center">Usulan Program RKAP <?= date('Y') + 1 ?> </th>
                                        <th class="text-center">Solusi</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($usulan as $row) :
                                        $id = $row->id_usulan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row->bagian_upk); ?></td>
                                            <td><?= htmlspecialchars($row->usulan); ?></td>
                                            <td><?= htmlspecialchars($row->solusi); ?></td>
                                            <td><?= htmlspecialchars($row->keterangan); ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/evaluasi_program/edit_usulan_program/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <!-- <a href="<?= base_url('admin/evaluasi_program/detail_evaluasi_program/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <!-- <a href="<?= base_url('admin/evaluasi_program/hapus_evaluasi_program/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>