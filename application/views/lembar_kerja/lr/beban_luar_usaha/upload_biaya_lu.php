<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/beban_luar_usaha') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <form method="post" action="" class="mb-1">
                                <div class="row border p-2 mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label>Kode Perkiraan</label>
                                            <select name="no_per_id[]" class="form-select select2" required>
                                                <option value="">-- Pilih Kode Perkiraan --</option>
                                                <?php foreach ($no_per_id as $kode) : ?>
                                                    <option value="<?= $kode->kode ?>"><?= $kode->kode ?> <?= $kode->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label>Uraian</label>
                                            <input type="text" name="uraian[]" class="form-control" required>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label>Bagian / UPK</label>
                                            <select name="cabang_id[]" class="form-select" required>
                                                <option value="">-- Pilih Bagian / UPK --</option>
                                                <?php foreach ($mapping_upk as $kode_upk => $nama_upk) : ?>
                                                    <option value="<?= $kode_upk ?>"><?= $nama_upk ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div> -->
                                </div>
                                <hr>
                                <div class="form-group mb-1">
                                    <label>Pilih Bulan (Berlaku untuk semua baris)</label><br>
                                    <?php
                                    $nama_bulan = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($nama_bulan as $num => $nama) : ?>
                                        <label style="margin-right:10px;">
                                            <input type="checkbox" name="bulan[]" value="<?= $num ?>" class="cek-bulan"> <?= $nama ?>
                                        </label>
                                    <?php endforeach; ?>
                                    <br>
                                    <label style="margin-top:5px;">
                                        <input type="checkbox" id="semua_bulan"> <strong>Pilih Semua Bulan</strong>
                                    </label>
                                </div>
                                <div class="form-group mb-1">
                                    <label>Nilai (Rp) </label>
                                    <input type="text" name="pagu[]" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                            <script>
                                document.getElementById('semua_bulan').addEventListener('change', function(e) {
                                    let cekBulan = document.querySelectorAll('.cek-bulan');
                                    for (let i = 0; i < cekBulan.length; i++) {
                                        cekBulan[i].checked = e.target.checked;
                                    }
                                });
                                document.querySelectorAll('input[name="pagu[]"]').forEach(function(el) {
                                    el.addEventListener('input', function(e) {
                                        let val = e.target.value.replace(/\D/g, '');
                                        e.target.value = val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    });
                                });
                            </script>
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