<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('admin/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a> -->
                    <a href="<?= base_url('admin/usulan_barang/tambah_kategori_barang') ?>"><button class="float-end neumorphic-button me-2"><i class="fas fa-plus"></i> Tambah Kategori</button></a>
                    <a href="<?= base_url('admin/usulan_barang/master_barang') ?>"><button class="float-end neumorphic-button me-2"><i class="fas fa-box"></i> Master Barang</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Kategori</th>
                                    <th>Kode Akun</th>
                                    <th>Keterangan</th>
                                    <th style="width: 90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kategori_barang)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($kategori_barang as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->nama_kategori ?></td>
                                            <td class="text-center"><?= $row->kode_akun ?></td>
                                            <td><?= $row->keterangan ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/usulan_barang/edit_kategori_barang/') . $row->id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('admin/usulan_barang/hapus_kategori_barang/') . $row->id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data kategori barang</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>