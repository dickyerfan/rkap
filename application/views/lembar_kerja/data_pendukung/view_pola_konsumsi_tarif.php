<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/data_pendukung/pola_konsumsi_tarif') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_rkap = isset($tahun_rkap) ? $tahun_rkap : date('Y');
                                ?>
                                <!-- <select name="upk" class="form-select select2" style="width: 170px;">
                                    <option value="">KONSOLIDASI</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select> -->
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    $tahun_rkap = (int)$tahun_rkap;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == $tahun_rkap ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/data_pendukung/pola_konsumsi_tarif') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/data_pendukung/tambah_pola') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> <i class="fa-solid fa-plus"></i> Input Pola Konsumsi</button> </a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/data_pendukung/tambah_tarif') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> <i class="fa-solid fa-plus"></i> Input Tarif Rata-rata</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">UPK</th>
                                        <th class="text-center">Jenis Pelanggan</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Pola Konsumsi </th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pola_konsumsi)) : ?>
                                        <?php $no = 1;
                                        foreach ($pola_konsumsi as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row->nama_upk) ?></td>
                                                <td><?= htmlspecialchars($row->nama_jp) ?></td>
                                                <td class="text-center"><?= $row->tahun ?></td>
                                                <td class="text-end"><?= number_format($row->konsumsi_rata, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('lembar_kerja/data_pendukung/edit_pola_konsumsi/' . $row->id) ?>" class="">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Belum ada data pola konsumsi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title2; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example2">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">UPK</th>
                                        <th class="text-center">Jenis Pelanggan</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Tarif Rata-rata </th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($tarif_rata)) : ?>
                                        <?php $no = 1;
                                        foreach ($tarif_rata as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row->nama_upk) ?></td>
                                                <td><?= htmlspecialchars($row->nama_jp) ?></td>
                                                <td class="text-center"><?= $row->tahun ?></td>
                                                <td class="text-end"><?= number_format($row->tarif_rata, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('lembar_kerja/data_pendukung/edit_tarif_rata/' . $row->id) ?>" class="">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Belum ada data pola konsumsi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>