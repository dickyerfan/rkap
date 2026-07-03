<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('admin/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a> -->
                    <a href="<?= base_url('admin/usulan_barang/tambah_master_barang?tahun=' . $tahun) ?>"><button class="float-end neumorphic-button me-2"><i class="fas fa-plus"></i> Tambah Barang</button></a>
                    <a href="<?= base_url('admin/usulan_barang/kategori_barang') ?>"><button class="float-end neumorphic-button me-2"><i class="fas fa-tags"></i> Kategori Barang</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row align-items-end mb-3">
                        <div class="col-md-3">
                            <form action="<?= base_url('admin/usulan_barang/master_barang') ?>" method="GET">
                                <label for="tahun">Tahun Master Barang :</label>
                                <div class="input-group">
                                    <select name="tahun" id="tahun" class="form-select">
                                        <?php
                                        $daftarTahun = [$tahun];
                                        for ($i = (int) date('Y') - 5; $i <= (int) date('Y') + 5; $i++) {
                                            $daftarTahun[] = $i;
                                        }
                                        foreach ($tahun_master as $item) {
                                            $daftarTahun[] = (int) $item->tahun;
                                        }
                                        $daftarTahun = array_unique($daftarTahun);
                                        rsort($daftarTahun);
                                        ?>
                                        <?php foreach ($daftarTahun as $itemTahun) : ?>
                                            <option value="<?= $itemTahun ?>" <?= $itemTahun == $tahun ? 'selected' : '' ?>><?= $itemTahun ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-filter"></i> Tampilkan</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-5">
                            <form action="<?= base_url('admin/usulan_barang/salin_master_barang') ?>" method="POST" onsubmit="return confirm('Salin semua barang tahun <?= $tahun - 1 ?> ke tahun <?= $tahun ?>? Data yang sudah ada tidak akan diduplikasi.');">
                                <input type="hidden" name="tahun_tujuan" value="<?= $tahun ?>">
                                <button class="btn btn-success" type="submit"><i class="fas fa-copy"></i> Salin Barang Tahun <?= $tahun - 1 ?></button>
                                <small class="d-block text-muted mt-1">Harga hasil salinan dapat diubah satu per satu untuk tahun <?= $tahun ?>.</small>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 70px;">Tahun</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Satuan</th>
                                    <th>Satuan</th>
                                    <th style="width: 90px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($master_barang)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($master_barang as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $row->tahun ?></td>
                                            <td><?= $row->nama_kategori ?></td>
                                            <td><?= $row->nama_barang ?></td>
                                            <td class="text-end"><?= number_format($row->harga_satuan, 0, ',', '.') ?></td>
                                            <td class="text-center"><?= $row->satuan ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('admin/usulan_barang/edit_master_barang/') . $row->id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('admin/usulan_barang/hapus_master_barang/') . $row->id . '?tahun=' . $tahun ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data master barang untuk tahun <?= $tahun ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
