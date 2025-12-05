<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/beban_trandis?upk=' . $this->session->userdata('upk') . '&tahun_rkap=' . $this->session->userdata('tahun_rkap')) ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <?php
                            $first_data = $data_edit[0];

                            $cabang_id_awal = $first_data['cabang_id'];
                            $no_per_id_awal = $first_data['no_per_id'];
                            $uraian_awal    = $first_data['uraian'];
                            $pagu           = isset($first_data['pagu']) ? $first_data['pagu'] : 0;

                            $data_per_bulan = [];
                            foreach ($data_edit as $row) {
                                $month = (int)date('n', strtotime($row['bulan']));
                                $data_per_bulan[$month] = $row;
                            }
                            ?>
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-md-5">
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
                                    <div class="col-md-3">
                                        <label>Uraian</label>
                                        <input type="text" name="uraian" class="form-control" value="<?= htmlspecialchars($uraian_awal) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Bagian / UPK</label>
                                        <select name="cabang_id_utama" class="form-select" required>
                                            <option value="">-- Pilih Bagian / UPK --</option>
                                            <?php foreach ($mapping_upk as $kode_upk => $nama_upk) : ?>
                                                <option value="<?= $kode_upk ?>" <?= ($cabang_id_awal == $kode_upk) ? 'selected' : '' ?>>
                                                    <?= $nama_upk ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Pagu per Bulan (Rp)</label>
                                        <input type="text" name="pagu" id="pagu_global" class="form-control rupiah" value="<?= number_format($first_data['pagu'] ?? 0, 0, ',', '.') ?>" required>
                                    </div>
                                </div>

                                <hr>
                                <h4>Detail Bulanan</h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-striped">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" width="15%">Bulan</th>
                                                <th class="text-center" width="20%">ID Data</th>
                                                <th class="text-center" width="25%">Pagu per Bulan (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 1; $i <= 12; $i++) :
                                                $data_bulan = $data_per_bulan[$i] ?? null;
                                                $id_by = $data_bulan['id_by'] ?? ($data_bulan['id_by'] ?? '');
                                                $pagu_bulan = $data_bulan['pagu'] ?? 0;
                                            ?>
                                                <tr>
                                                    <td><?= $nama_bulan[$i] ?></td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm" readonly value="<?= $id_by ?>" name="id_by[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm pagu-bulanan" name="pagu_bulanan[]" value="<?= number_format($pagu_bulan, 0, ',', '.') ?>">
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <button type="submit" class="neumorphic-button">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>

                        <script>
                            // ==== FORMAT DAN KONVERSI RUPIAH ====
                            function formatRupiah(value) {
                                value = value.replace(/[^,\d]/g, '');
                                const parts = value.split(',');
                                let integer = parts[0];
                                const remainder = integer.length % 3;
                                let rupiah = integer.substr(0, remainder);
                                const thousands = integer.substr(remainder).match(/\d{3}/gi);
                                if (thousands) {
                                    const separator = remainder ? '.' : '';
                                    rupiah += separator + thousands.join('.');
                                }
                                return parts[1] !== undefined ? rupiah + ',' + parts[1] : rupiah;
                            }

                            function unformatRupiah(value) {
                                return parseInt(value.replace(/\./g, '').replace(/[^0-9]/g, '')) || 0;
                            }

                            // ==== EVENT SAAT PAGU GLOBAL DIEDIT ====
                            const inputPagu = document.getElementById('pagu_global');
                            inputPagu.addEventListener('input', function() {
                                // format tampilan
                                this.value = formatRupiah(this.value);

                                // ambil nilai numerik
                                const newVal = unformatRupiah(this.value);

                                // update semua pagu bulanan ke nilai baru
                                document.querySelectorAll('.pagu-bulanan').forEach(el => {
                                    el.value = formatRupiah(newVal.toString());
                                });
                            });

                            // ==== EVENT UNTUK MASING-MASING PAGU BULANAN ====
                            document.querySelectorAll('.pagu-bulanan').forEach(el => {
                                el.addEventListener('input', function() {
                                    this.value = formatRupiah(this.value);
                                });
                            });

                            // ==== HAPUS TITIK SEBELUM SUBMIT ====
                            document.querySelector('form').addEventListener('submit', function() {
                                document.querySelectorAll('input[name="pagu"], input[name="pagu_bulanan[]"]').forEach(el => {
                                    el.value = unformatRupiah(el.value);
                                });
                            });

                            // ==== INISIALISASI SELECT2 ====
                            if (typeof $('.select2') !== 'undefined' && typeof $('.select2').select2 === 'function') {
                                $('.select2').select2({
                                    theme: 'bootstrap-5'
                                });
                            }

                            document.querySelectorAll('.rupiah').forEach(function(input) {
                                input.addEventListener('input', function(e) {
                                    let value = e.target.value.replace(/[^0-9]/g, '');
                                    e.target.value = new Intl.NumberFormat('id-ID').format(value);
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </main>