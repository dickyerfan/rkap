<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="" class="mb-3">
                        <div class="form-group mb-3">
                            <label>Produk</label>
                            <select id="id_produk" name="id_produk" class="form-control" required>
                                <option value="">-- Pilih Produk --</option>
                                <?php foreach ($daftar_bahan as $produk => $bahan_list) : ?>
                                    <option value="<?= $produk ?>"><?= $produk ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Nama Bahan Baku</label>
                            <select id="nama_bahan" name="nama_bahan" class="form-control" required>
                                <option value="">-- Pilih Nama Bahan --</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Volume (per produksi)</label>
                            <input type="number" name="volume" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Harga Satuan (Rp)</label>
                            <input type="number" name="harga_satuan" class="form-control" required>
                        </div>

                        <button type="submit" class="neumorphic-button">Simpan</button>
                    </form>

                </div>
            </div>
        </div>
    </main>

    <script>
        const daftarBahan = <?= json_encode($daftar_bahan); ?>;

        const produkSelect = document.getElementById('id_produk');
        const bahanSelect = document.getElementById('nama_bahan');

        produkSelect.addEventListener('change', function() {
            const selectedProduk = this.value;
            bahanSelect.innerHTML = '<option value="">-- Pilih Nama Bahan --</option>';
            if (selectedProduk && daftarBahan[selectedProduk]) {
                daftarBahan[selectedProduk].forEach(function(bahan) {
                    const option = document.createElement('option');
                    option.value = bahan;
                    option.textContent = bahan;
                    bahanSelect.appendChild(option);
                });
            }
        });
    </script>