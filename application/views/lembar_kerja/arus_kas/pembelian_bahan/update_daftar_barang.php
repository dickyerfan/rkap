<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form method="post" action="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/update'); ?>">
                                <input type="hidden" name="id_barang" value="<?= $barang->id_barang; ?>">

                                <div class="form-group">
                                    <label>Kode Perkiraan</label>
                                    <!-- <input type="text" name="no_per_id" class="form-control" value="<?= htmlspecialchars($barang->no_per_id); ?>" required> -->
                                    <select name="no_per_id" class="form-select" required>
                                        <?php foreach ($no_per_id as $kode) : ?>
                                            <option value="<?= $kode->kode ?>" <?= $kode->kode == $barang->no_per_id ? 'selected' : '' ?>>
                                                <?= $kode->kode ?> - <?= htmlspecialchars($kode->name); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($barang->nama_barang); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Harga Satuan</label>
                                    <input type="number" step="100" name="harga" class="form-control" value="<?= $barang->harga; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Pembagi</label>
                                    <input type="number" step="0.001" name="pembagi" class="form-control" value="<?= $barang->pembagi; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Satuan</label>
                                    <!-- <input type="text" name="satuan" class="form-control" value="<?= htmlspecialchars($barang->satuan); ?>" required> -->
                                    <select name="satuan" class="form-select" required>
                                        <option value="buah" <?= $barang->satuan == 'buah' ? 'selected' : '' ?>>buah</option>
                                        <option value="mtr" <?= $barang->satuan == 'mtr' ? 'selected' : '' ?>>Meter</option>
                                        <option value="SR" <?= $barang->satuan == 'SR' ? 'selected' : '' ?>>SR</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun" class="form-control" value="<?= $barang->tahun; ?>" disabled>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="neumorphic-button">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>