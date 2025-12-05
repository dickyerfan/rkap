<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pendapatan_usaha_lain') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/lr/pendapatan_usaha_lain/save') ?>" method="post">
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
                                        <option value="subsidi">Subsidi Tarif Air</option>
                                        <option value="penagihan">Jasa Penagihan Rekening</option>
                                    </select>
                                </div>

                                <!-- No Per Subsidi -->
                                <div class="form-group mb-3" id="noPerSubsidi">
                                    <label class="form-label">Kode Perkiraan Subsidi :</label>
                                    <select id="kodeSubsidi" class="form-select">
                                        <?php foreach ($no_per_subsidi as $row) : ?>
                                            <option value="<?= $row->kode ?>"><?= $row->kode ?> - <?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- No Per Penagihan -->
                                <div class="form-group mb-3 d-none" id="noPerPenagihan">
                                    <label class="form-label">Kode Perkiraan Penagihan :</label>
                                    <select id="kodePenagihan" class="form-select">
                                        <?php foreach ($no_per_penagihan as $row) : ?>
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
            toggleJenis('subsidi');
        });

        function toggleJenis(jenis) {
            const bulanField = document.getElementById('bulan');
            const kodeInput = document.getElementById('kodeInput');
            const kodeSubsidi = document.getElementById('kodeSubsidi');
            const kodePenagihan = document.getElementById('kodePenagihan');

            if (jenis === 'subsidi') {
                document.getElementById('noPerSubsidi').classList.remove('d-none');
                document.getElementById('noPerPenagihan').classList.add('d-none');
                bulanField.disabled = false;

                kodeInput.value = kodeSubsidi.value;

                // update saat select subsidi berubah
                kodeSubsidi.onchange = function() {
                    kodeInput.value = this.value;
                };

            } else {
                document.getElementById('noPerSubsidi').classList.add('d-none');
                document.getElementById('noPerPenagihan').classList.remove('d-none');
                bulanField.disabled = true;

                kodeInput.value = kodePenagihan.value;

                // update saat select penagihan berubah
                kodePenagihan.onchange = function() {
                    kodeInput.value = this.value;
                };
            }
        }
    </script>