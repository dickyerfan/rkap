<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('admin/usulan_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('admin/usulan_barang/update') ?>" method="POST">
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
                                            <option value="<?= (int) $kategori->id ?>" data-no-per="<?= html_escape($kategori->no_per_kode ?? '') ?>" data-nama-akun="<?= html_escape($kategori->no_per_nama ?? '') ?>" <?= (string) $kategoriDipilih === (string) $kategori->id ? 'selected' : '' ?>>
                                                <?= html_escape($kategori->nama_kategori) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kategori_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="master_barang_id">Nama Perkiraan :</label>
                                    <select name="master_barang_id" id="master_barang_id" class="form-select">
                                        <option value="">Pilih Nama Perkiraan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('master_barang_id') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="no_perkiraan">No Perkiraan :</label>
                                    <input type="text" class="form-control" id="no_perkiraan" name="no_perkiraan" value="<?= html_escape(set_value('no_perkiraan', $usulan_barang->no_perkiraan)) ?>">
                                    <small class="form-text text-muted" id="no_perkiraan "></small>
                                </div>
                                <div class="form-group">
                                    <label for="volume">Volume :</label>
                                    <input type="number" min="1" step="1" class="form-control" id="volume" name="volume" value="<?= html_escape(set_value('volume', $usulan_barang->volume)) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('volume') ?></small>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="satuan_barang">Satuan :</label>
                                    <input type="text" class="form-control" id="satuan_barang" readonly>
                                </div> -->
                                <div class="form-group">
                                    <label for="harga_satuan">Harga Satuan :</label>
                                    <input type="number" min="1" step="1" class="form-control" id="harga_satuan" name="harga_satuan" value="<?= html_escape(set_value('harga_satuan', $usulan_barang->harga_satuan)) ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga_satuan') ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="total_biaya">Biaya :</label>
                                    <input type="number" min="1" step="1" class="form-control" id="biaya" name="biaya" value="<?= html_escape(set_value('biaya', $usulan_barang->biaya)) ?>" readonly>
                                    <!-- <small class="form-text text-muted">Biaya dihitung otomatis dari harga satuan dikali volume.</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="ket">Keterangan :</label>
                                    <textarea name="ket" id="ket" rows="3" class="form-control"><?= html_escape(set_value('ket', $usulan_barang->ket)) ?></textarea>
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
            const volumeInput = document.getElementById('volume');
            const satuanInput = document.getElementById('satuan_barang');
            const hargaInput = document.getElementById('harga_satuan');
            const biayaInput = document.getElementById('total_biaya');
            const noPerInput = document.getElementById('no_perkiraan');
            const namaAkun = document.getElementById('nama_akun');
            const barangTerpilih = <?= json_encode(set_value('master_barang_id', $master_barang_id)) ?>;
            const noPerTerpilih = <?= json_encode(set_value('no_perkiraan', $usulan_barang->no_perkiraan)) ?>;
            const noPerList = <?= json_encode($no_per_list, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

            function formatRupiah(nilai) {
                return new Intl.NumberFormat('id-ID').format(Number(nilai) || 0);
            }

            function hitungBiaya() {
                const option = barangSelect.options[barangSelect.selectedIndex];
                const harga = Number(hargaInput.value) || 0;
                const volume = Number(volumeInput.value) || 0;
                satuanInput.value = option && option.dataset.satuan ? option.dataset.satuan : '';
                biayaInput.value = harga ? formatRupiah(harga * volume) : '';
            }

            function gunakanHargaMaster() {
                const option = barangSelect.options[barangSelect.selectedIndex];
                hargaInput.value = option && option.dataset.harga ? Number(option.dataset.harga) : 0;
                hitungBiaya();
            }

            function tampilkanNoPer() {
                const option = kategoriSelect.options[kategoriSelect.selectedIndex];
                const kodeAkunKategori = option && option.dataset.noPer ? option.dataset.noPer : '';

                noPerInput.innerHTML = '';
                noPerInput.add(new Option('Pilih No Perkiraan', ''));

                if (kodeAkunKategori) {
                    const filteredNoPer = noPerList.filter(function(noPer) {
                        return noPer.kode.startsWith(kodeAkunKategori.substring(0, 3));
                    });
                    filteredNoPer.forEach(function(noPer) {
                        const option = new Option(noPer.kode + ' - ' + noPer.name, noPer.kode);
                        option.selected = String(noPer.kode) === String(noPerTerpilih);
                        noPerInput.add(option);
                    });
                }

                namaAkun.textContent = option && option.dataset.namaAkun ? option.dataset.namaAkun : 'Kode akun kategori belum ditemukan di tabel no_per';
                noPerInput.disabled = !kodeAkunKategori;
            }

            function tampilkanBarang() {
                const kategoriId = kategoriSelect.value;
                const barangKategori = masterBarang.filter(function(barang) {
                    return String(barang.kategori_id) === String(kategoriId);
                });

                barangSelect.innerHTML = '';
                barangSelect.add(new Option(barangKategori.length ? 'Pilih Nama Perkiraan' : 'Belum ada master barang pada kategori ini', ''));
                barangKategori.forEach(function(barang) {
                    const option = new Option(barang.nama_barang, barang.id);
                    option.dataset.satuan = barang.satuan;
                    option.dataset.harga = barang.harga_satuan;
                    option.selected = String(barang.id) === String(barangTerpilih);
                    barangSelect.add(option);
                });
                barangSelect.disabled = !kategoriId || barangKategori.length === 0;
                tampilkanNoPer();
                hitungBiaya();
            }

            kategoriSelect.addEventListener('change', tampilkanBarang);
            barangSelect.addEventListener('change', gunakanHargaMaster);
            volumeInput.addEventListener('input', hitungBiaya);
            hargaInput.addEventListener('input', hitungBiaya);
            tampilkanBarang();
        });
    </script>