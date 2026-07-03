<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_barang/master_barang?tahun=' . $tahun) ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= $action ?>" method="POST">
                        <?php if (!empty($barang)) : ?>
                            <input type="hidden" name="id" value="<?= $barang->id ?>">
                        <?php endif; ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun :</label>
                                    <input type="number" min="2000" max="2100" class="form-control" id="tahun" name="tahun" value="<?= set_value('tahun', !empty($barang) ? $barang->tahun : $tahun) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tahun'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_id">Kategori :</label>
                                    <select name="kategori_id" id="kategori_id" class="form-select">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori_barang as $kategori) : ?>
                                            <option value="<?= $kategori->id ?>" <?= set_value('kategori_id', !empty($barang) ? $barang->kategori_id : '') == $kategori->id ? 'selected' : '' ?>>
                                                <?= $kategori->nama_kategori ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kategori_id'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang :</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= set_value('nama_barang', !empty($barang) ? $barang->nama_barang : '') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="harga_satuan">Harga Satuan :</label>
                                    <input type="number" step="0.01" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= set_value('harga_satuan', !empty($barang) ? $barang->harga_satuan : 0) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga_satuan'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan :</label>
                                    <select class="form-select" id="satuan" name="satuan">
                                        <?php
                                        $satuan_list = [
                                            'Unit',
                                            'Buah',
                                            'Pak',
                                            'Rim',
                                            'Box',
                                            'Lusin',
                                            'Set',
                                            'Roll',
                                            'Meter',
                                            'Kg',
                                            'Liter',
                                            'Ruangan',
                                            'Pasang',
                                            'Botol',
                                            'Ls',
                                            'M2',
                                            'Orang',
                                            'Bulan',
                                            'Tahun'
                                        ];

                                        $selected = set_value(
                                            'satuan',
                                            !empty($barang) ? $barang->satuan : 'unit'
                                        );
                                        foreach ($satuan_list as $satuan) :
                                        ?>
                                            <option value="<?= $satuan ?>" <?= ($selected == $satuan) ? 'selected' : '' ?>><?= $satuan ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
                                </div>
                                <div class="text-center">
                                    <button class="neumorphic-button mt-2" type="submit"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>