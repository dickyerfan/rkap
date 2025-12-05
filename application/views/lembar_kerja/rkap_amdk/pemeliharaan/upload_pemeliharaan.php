<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post">
                                <div class=" form-group mb-3">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun" value="<?= date('Y') + 1 ?>" class="form-control" readonly>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Jenis</label>
                                    <select id="jenis" name="jenis" class="form-control" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="Mesin Produksi">Mesin Produksi</option>
                                        <option value="Ruang Produksi">Ruang Produksi</option>
                                    </select>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Kategori</label>
                                    <select id="kategori" name="kategori" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                    </select>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Nama Item</label>
                                    <input type="text" name="uraian" class="form-control" required>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Satuan</label>
                                    <input type="text" name="satuan" class="form-control" required>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Volume</label>
                                    <input type="number" name="volume" class="form-control" required>
                                </div>
                                <div class=" form-group mb-3">
                                    <label>Harga Satuan (Rp)</label>
                                    <input type="number" name="harga" class="form-control" required>
                                </div>
                                <button type="submit" class="neumorphic-button mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jenisSelect = document.getElementById('jenis');
            const kategoriSelect = document.getElementById('kategori');

            const kategoriOptions = {
                "Mesin Produksi": ["Galon", "Gelas", "Kompresor", "Laboratorium", "Mesin Lainnya"],
                "Ruang Produksi": ["Galon", "Gelas", "Botol", "Water Treatment", "Ruang Lainnya"]
            };

            jenisSelect.addEventListener('change', function() {
                const selectedJenis = this.value;
                kategoriSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';

                if (kategoriOptions[selectedJenis]) {
                    kategoriOptions[selectedJenis].forEach(function(kat) {
                        const option = document.createElement('option');
                        option.value = kat;
                        option.textContent = kat;
                        kategoriSelect.appendChild(option);
                    });
                }
            });
        });
    </script>