<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <div class="navbar-nav ms-auto">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/produksi_air/input_efisiensi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-plus"></i> Tambah</button></a>
                            </div>
                        <?php endif; ?>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/produksi_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.8rem;" id="example3">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">TAHUN</th>
                                        <th class="text-center">EFISIENSI (%)</th>
                                        <th class="text-center">KETERANGAN</th>
                                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                            <th class="text-center">ACTION</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($efisiensi)) : ?>
                                        <?php $no = 1;
                                        foreach ($efisiensi as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-center"><?= $row['tahun'] ?></td>
                                                <td class="text-center"><?= number_format($row['efisiensi'], 2, ',', '.') ?> %</td>
                                                <td><?= $row['keterangan'] ?></td>
                                                <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('lembar_kerja/lr/produksi_air/edit_efisiensi/' . $row['id_efisiensi']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        <a href="<?= base_url('lembar_kerja/lr/produksi_air/delete_efisiensi/' . $row['id_efisiensi']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data efisiensi tahun <?= $row['tahun'] ?>?')"><i class="fas fa-trash"></i> Hapus</a>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
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