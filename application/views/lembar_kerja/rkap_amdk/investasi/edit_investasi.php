<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <?php
                            // Data pertama di array $data_edit mewakili nilai umum, 
                            // karena kita menganggap Kode Perkiraan, Uraian, Satuan, dan Harga Satuan
                            // adalah sama untuk semua data bulanan dalam satu grup edit.
                            $first_data = $data_edit[0];

                            // Ambil nilai awal untuk form
                            $cabang_id_awal = $first_data['cabang_id'];
                            $no_per_id_awal = $first_data['no_per_id'];
                            $uraian_awal    = $first_data['uraian'];
                            $satuan_awal    = $first_data['sat'];
                            $harga_awal     = $first_data['pagu'];

                            // Konversi data array dari Model menjadi array asosiatif bulan => data
                            $data_per_bulan = [];
                            foreach ($data_edit as $row) {
                                $month = (int)date('n', strtotime($row['bulan']));
                                $data_per_bulan[$month] = $row;
                            }

                            // Variabel $nama_bulan sudah dikirim dari Controller
                            ?>
                            <form method="post" action="">

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Kode Perkiraan</label>
                                        <select name="no_per_id" class="form-select select2" required>
                                            <option value="">-- Pilih Kode Perkiraan --</option>
                                            <?php if (isset($no_per_id)) : ?>
                                                <?php foreach ($no_per_id as $kode) : ?>
                                                    <option value="<?= $kode->kode ?>" <?= ($no_per_id_awal == $kode->kode) ? 'selected' : '' ?>>
                                                        <?= $kode->kode ?> <?= $kode->name ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Uraian</label>
                                        <input type="text" name="uraian" class="form-control" value="<?= htmlspecialchars($uraian_awal) ?>" required>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <label>Bagian / UPK</label>
                                        <select name="cabang_id_utama" class="form-select" required>
                                            <option value="">-- Pilih Bagian / UPK --</option>
                                            <?php foreach ($mapping_upk as $kode_upk => $nama_upk) : ?>
                                                <option value="<?= $kode_upk ?>" <?= ($cabang_id_awal == $kode_upk) ? 'selected' : '' ?>>
                                                    <?= $nama_upk ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <label>Satuan</label>
                                        <select name="sat" class="form-select" required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <?php foreach ($satuan_list as $sat) : ?>
                                                <option value="<?= $sat ?>" <?= ($satuan_awal == $sat) ? 'selected' : '' ?>>
                                                    <?= ucfirst($sat) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>
                                            nilai (Rp)</label>
                                        <input type="text" name="pagu" class="form-control" value="<?= number_format($harga_awal, 0, ',', '.') ?>" onkeyup="formatRupiah(this)" required>
                                    </div>
                                </div>

                                <hr>

                                <h4>Detail Bulanan</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>ID Data</th>
                                                <th>Volume (vol)</th>
                                                <th>Pagu (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // $nama_bulan harus tersedia dari Controller
                                            for ($i = 1; $i <= 12; $i++) :
                                                $data_bulan = $data_per_bulan[$i] ?? null;
                                                $id_inves = $data_bulan['id_inves'] ?? '';
                                                $vol = $data_bulan['vol'] ?? 0;
                                                $pagu = $data_bulan['pagu'] ?? 0;
                                            ?>
                                                <tr>
                                                    <td><?= $nama_bulan[$i] ?></td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" readonly value="<?= $id_inves ?>" name="id_inves[]">
                                                        <input type="hidden" name="original_pagu[]" value="<?= $pagu ?>">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control form-control-sm vol-input" value="<?= $vol ?>" name="vol[]" onchange="hitungPagu(this)">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm pagu-display" readonly value="<?= number_format($pagu, 0, ',', '.') ?>">
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <button type="submit" class="neumorphic-button"><i class="fas fa-save"></i> Simpan Perubahan</button>
                            </form>

                            <script>
                                // FUNGSI FORMAT RUPIAH
                                function formatRupiah(input) {
                                    let value = input.value;
                                    // 1. Hapus semua karakter selain angka, koma, dan titik
                                    value = value.replace(/[^0-9]/g, '');

                                    // 2. Format ribuan dengan titik
                                    let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                                    input.value = formatted;

                                    // PENTING: Setelah format, panggil ulang perhitungan pagu untuk semua baris
                                    let volInputs = document.querySelectorAll('.vol-input');
                                    volInputs.forEach(input => {
                                        hitungPagu(input);
                                    });
                                }

                                // FUNGSI UNTUK MENGHITUNG PAGU BULANAN
                                function hitungPagu(volInput) {
                                    let row = volInput.closest('tr');
                                    let vol = parseFloat(volInput.value) || 0;

                                    // Ambil harga dari input Harga Satuan (global)
                                    let hargaInputGlobal = document.querySelector('input[name="harga"]');
                                    let hargaString = hargaInputGlobal.value.replace(/\./g, '').replace(/,/g, '.'); // Bersihkan format Rupiah
                                    let harga = parseFloat(hargaString) || 0;

                                    // Hitung Pagu
                                    let pagu = vol * harga;

                                    // Tampilkan Pagu (di kolom terakhir)
                                    let paguDisplay = row.querySelector('.pagu-display');

                                    // Format pagu untuk tampilan (tanpa .00 jika integer)
                                    paguDisplay.value = pagu.toLocaleString('id-ID', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    });
                                }

                                // Panggil hitungPagu saat harga satuan global berubah (saat keyup)
                                document.querySelector('input[name="harga"]').addEventListener('keyup', function() {
                                    let volInputs = document.querySelectorAll('.vol-input');
                                    volInputs.forEach(input => {
                                        hitungPagu(input);
                                    });
                                });

                                // Panggil hitungPagu saat form dimuat pertama kali
                                document.addEventListener('DOMContentLoaded', function() {
                                    let volInputs = document.querySelectorAll('.vol-input');
                                    volInputs.forEach(input => {
                                        hitungPagu(input);
                                    });
                                });

                                // Inisialisasi Select2 (jika menggunakan library Select2)
                                if (typeof $('.select2').select2 === 'function') {
                                    $('.select2').select2({
                                        theme: 'bootstrap-5'
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>