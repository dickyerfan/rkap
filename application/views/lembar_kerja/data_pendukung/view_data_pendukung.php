<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/data_pendukung/tambah') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Input Data</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered table-striped" style="font-size: 0.8rem;" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">UPK</th>
                                        <th class="text-center">Jenis Pelanggan</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Jasa Administrasi (Rp)</th>
                                        <th class="text-center">Jasa Pemeliharaan (Rp)</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($jasa_tambahan)) : ?>
                                        <?php $no = 1;
                                        foreach ($jasa_tambahan as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($row->nama_upk) ?></td>
                                                <td><?= htmlspecialchars($row->nama_jp) ?></td>
                                                <td class="text-center"><?= $row->tahun ?></td>
                                                <td class="text-end"><?= number_format($row->jasa_admin, 0, ',', '.') ?></td>
                                                <td class="text-end"><?= number_format($row->jasa_pemeliharaan, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= site_url('lembar_kerja/data_pendukung/edit_jasa_tambahan/' . $row->id) ?>" class="">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <!-- <a href="<?= site_url('lembar_kerja/data_pendukung/delete_jasa_tambahan/' . $row->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">Belum ada data jasa tambahan.</td>
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