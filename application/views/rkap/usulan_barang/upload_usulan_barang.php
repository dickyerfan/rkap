<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= isset($back_url) ? $back_url : base_url('rkap/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun Pembuatan RKAP :</label>
                                    <input type="number" class="form-control" id="tahun_rkap" value="<?= date('Y') ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_id">Kategori :</label>
                                    <select name="kategori_id" id="kategori_id" class="form-select">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori_barang as $kategori) : ?>
                                            <option value="<?= (int) $kategori->id ?>" <?= set_select('kategori_id', $kategori->id) ?>>
                                                <?= html_escape($kategori->nama_kategori) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kategori_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="master_barang_id">Nama Barang :</label>
                                    <select name="master_barang_id" id="master_barang_id" class="form-select" disabled>
                                        <option value="">Pilih kategori terlebih dahulu</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('master_barang_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan_barang">Satuan :</label>
                                    <input type="text" class="form-control" id="satuan_barang" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= html_escape(set_value('no_perkiraan')) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan') ?></small>
                                </div> -->
                                <div class="form-group">
                                    <label for="volume">Volume :</label>
                                    <input type="number" min="1" step="1" class="form-control" id="volume" name="volume" value="<?= html_escape(set_value('volume')) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan:</label>
                                    <input type="text" class="form-control" id="ket" name="ket" value="<?= html_escape(set_value('ket')) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('ket') ?></small>
                                </div>
                                <div class="text-center">
                                    <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const masterBarang = <?= json_encode($master_barang, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
            const kategoriSelect = document.getElementById('kategori_id');
            const barangSelect = document.getElementById('master_barang_id');
            const satuanInput = document.getElementById('satuan_barang');
            const barangTerpilih = <?= json_encode(set_value('master_barang_id')) ?>;

            function tampilkanBarang() {
                const kategoriId = kategoriSelect.value;
                const barangKategori = masterBarang.filter(function(barang) {
                    return String(barang.kategori_id) === String(kategoriId);
                });

                barangSelect.innerHTML = '';
                satuanInput.value = '';

                if (!kategoriId) {
                    barangSelect.add(new Option('Pilih kategori terlebih dahulu', ''));
                    barangSelect.disabled = true;
                    return;
                }

                barangSelect.add(new Option(barangKategori.length ? 'Pilih Nama Barang' : 'Belum ada master barang pada kategori ini', ''));
                barangKategori.forEach(function(barang) {
                    const option = new Option(barang.nama_barang, barang.id);
                    option.dataset.satuan = barang.satuan;
                    option.selected = String(barang.id) === String(barangTerpilih);
                    barangSelect.add(option);
                });
                barangSelect.disabled = barangKategori.length === 0;
                tampilkanSatuan();
            }

            function tampilkanSatuan() {
                const option = barangSelect.options[barangSelect.selectedIndex];
                satuanInput.value = option && option.dataset.satuan ? option.dataset.satuan : '';
            }

            kategoriSelect.addEventListener('change', tampilkanBarang);
            barangSelect.addEventListener('change', tampilkanSatuan);
            tampilkanBarang();
        });
    </script>
