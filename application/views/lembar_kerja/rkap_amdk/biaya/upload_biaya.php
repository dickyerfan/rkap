<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/biaya') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" action="" class="mb-3">
                                <div class="form-group mb-3">
                                    <label>Kode Perkiraan</label>
                                    <select id="no_per_id" name="no_per_id[]" class="form-select select2" multiple required>
                                        <option value="">-- Pilih Kode Perkiraan --</option>
                                        <?php foreach ($no_per_id as $kode) : ?>
                                            <option value="<?= $kode->kode ?>"><?= $kode->kode ?> <?= $kode->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Uraian</label>
                                    <input type="text" name="uraian[]" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Pilih Bulan (boleh lebih dari satu)</label><br>
                                    <?php
                                    $nama_bulan = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($nama_bulan as $num => $nama) : ?>
                                        <label style="margin-right:10px;">
                                            <input type="checkbox" name="bulan[]" value="<?= $num ?>"> <?= $nama ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <label style="margin-top:5px;">
                                        <input type="checkbox" id="semua_bulan"> <strong>Pilih Semua Bulan</strong>
                                    </label>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nilai (Rp)</label>
                                    <input type="number" name="pagu[]" class="form-control" required>
                                </div>

                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('semua_bulan').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="bulan[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>