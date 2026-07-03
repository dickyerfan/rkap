<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('rkap/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('rkap/usulan_barang/update') ?>" method="POST">
                        <input type="hidden" name="id_usulanBarang" value="<?= (int) $usulan_barang->id_usulanBarang ?>">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_rkap">Tahun Pembuatan RKAP :</label>
                                    <input type="number" class="form-control" id="tahun_rkap" value="<?= (int) $usulan_barang->tahun_rkap ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_id">Kategori :</label>
                                    <select name="kategori_id" id="kategori_id" class="form-select">
                                        <option value="">Pilih Kategori</option>
                                        <?php foreach ($kategori_barang as $kategori) : ?>
                                            <?php $kategoriDipilih = set_value('kategori_id', $usulan_barang->kategori === $kategori->nama_kategori ? $kategori->id : ''); ?>
                                            <option value="<?= (int) $kategori->id ?>" <?= (string) $kategoriDipilih === (string) $kategori->id ? 'selected' : '' ?>>
                                                <?= html_escape($kategori->nama_kategori) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kategori_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="master_barang_id">Nama Barang :</label>
                                    <select name="master_barang_id" id="master_barang_id" class="form-select">
                                        <option value="">Pilih Nama Barang</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('master_barang_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="satuan_barang">Satuan :</label>
                                    <input type="text" class="form-control" id="satuan_barang" readonly>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= html_escape(set_value('no_perkiraan', $usulan_barang->no_perkiraan)) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_perkiraan') ?></small>
                                </div> -->
                                <div class="form-group">
                                    <label for="volume">Volume :</label>
                                    <input type="number" min="1" step="1" class="form-control" id="volume" name="volume" value="<?= html_escape(set_value('volume', $usulan_barang->volume)) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume') ?></small>
                                </div>
                                <div class="text-center">
                                    <button class="neumorphic-button mt-2" type="submit"><i class="fas fa-edit"></i> Update</button>
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
            const barangTerpilih = <?= json_encode(set_value('master_barang_id', $master_barang_id)) ?>;

            function tampilkanBarang() {
                const kategoriId = kategoriSelect.value;
                const barangKategori = masterBarang.filter(function(barang) {
                    return String(barang.kategori_id) === String(kategoriId);
                });

                barangSelect.innerHTML = '';
                satuanInput.value = '';
                barangSelect.add(new Option(barangKategori.length ? 'Pilih Nama Barang' : 'Belum ada master barang pada kategori ini', ''));

                barangKategori.forEach(function(barang) {
                    const option = new Option(barang.nama_barang, barang.id);
                    option.dataset.satuan = barang.satuan;
                    option.selected = String(barang.id) === String(barangTerpilih);
                    barangSelect.add(option);
                });
                barangSelect.disabled = !kategoriId || barangKategori.length === 0;
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