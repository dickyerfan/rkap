<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_na') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/rkap_amdk/pendapatan_na/save') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tahun (readonly, auto tahun berjalan) -->
                                <input type="hidden" name="tahun" value="<?= date('Y') + 1 ?>">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tahun : </label>
                                    <input type="text" class="form-control" value="<?= date('Y') + 1 ?>" readonly>
                                </div>
                                <!-- Bulan (aktif hanya untuk subsidi) -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Bulan : </label>
                                    <select id="bulan" name="bulan" class="form-select">
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <!-- Pagu -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Nilai Anggaran :</label>
                                    <input type="number" name="pagu" class="form-control" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Jenis -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Jenis :</label>
                                    <select id="jenis" name="jenis" class="form-select" onchange="toggleJenis(this.value)">
                                        <option value="pendapatan_galon">Pendapatan Galon</option>
                                        <option value="pendapatan_lainnya">Pendapatan Lainnya</option>
                                    </select>
                                </div>

                                <!-- No Per Galon -->
                                <div class="form-group mb-3" id="no_per_galon">
                                    <label class="form-label">Kode Perkiraan Galon :</label>
                                    <select id="kodeGalon" class="form-select">
                                        <?php foreach ($no_per_galon as $row) : ?>
                                            <option value="<?= $row->kode ?>"><?= $row->kode ?> - <?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- No Per Pendapatan Lainnya -->
                                <div class="form-group mb-3 d-none" id="no_per_lainnya">
                                    <label class="form-label">Kode Perkiraan Pendapatan Lainnya :</label>
                                    <select id="kodeLainnya" class="form-select">
                                        <?php foreach ($no_per_lainnya as $row) : ?>
                                            <option value="<?= $row->kode ?>"><?= $row->kode ?> - <?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Hidden input yang dipakai untuk submit -->
                                <input type="hidden" name="kode" id="kodeInput">
                            </div>
                            <div class="mt-4 text-center">
                                <button type="submit" class="neumorphic-button">💾 Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // set default saat halaman pertama kali dibuka
        document.addEventListener('DOMContentLoaded', function() {
            toggleJenis('pendapatan_galon');
        });

        function toggleJenis(jenis) {
            const bulanField = document.getElementById('bulan');
            const kodeInput = document.getElementById('kodeInput');
            const kodeGalon = document.getElementById('kodeGalon');
            const kodeLainnya = document.getElementById('kodeLainnya');

            if (jenis === 'pendapatan_galon') {
                document.getElementById('no_per_galon').classList.remove('d-none');
                document.getElementById('no_per_lainnya').classList.add('d-none');
                bulanField.disabled = true;

                kodeInput.value = kodeGalon.value;

                // update saat select subsidi berubah
                kodeGalon.onchange = function() {
                    kodeInput.value = this.value;
                };

            } else {
                document.getElementById('no_per_galon').classList.add('d-none');
                document.getElementById('no_per_lainnya').classList.remove('d-none');
                bulanField.disabled = true;

                kodeInput.value = kodeLainnya.value;

                // update saat select penagihan berubah
                kodeLainnya.onchange = function() {
                    kodeInput.value = this.value;
                };
            }
        }
    </script>