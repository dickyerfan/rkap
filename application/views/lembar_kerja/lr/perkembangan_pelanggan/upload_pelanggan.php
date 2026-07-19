<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/pelanggan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('lembar_kerja/lr/pelanggan/insert_data') ?>" method="post">
                        <?php $thn = $selected_tahun ?: date('Y') + 1; ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label>Nama UPK</label>
                                    <select name="id_upk" id="id_upk_sel" class="form-select" required>
                                        <option value="">-- Pilih UPK --</option>
                                        <?php foreach ($upk_list as $u) : ?>
                                            <option value="<?= $u->id_upk ?>" <?= $selected_id_upk == $u->id_upk ? 'selected' : '' ?>><?= $u->nama_upk ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Jenis Pelanggan</label>
                                    <select name="id_jp" id="id_jp_sel" class="form-select" required>
                                        <option value="">-- Pilih Jenis Pelanggan --</option>
                                        <?php foreach ($jenis_list as $j) : ?>
                                            <option value="<?= $j->id_jp ?>" <?= $selected_id_jp == $j->id_jp ? 'selected' : '' ?>><?= $j->nama_jp ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="tahun" value="<?= $thn ?>">
                                <div class="form-group mb-2">
                                    <label>Tahun RKAP</label>
                                    <input type="text" class="form-control" value="<?= $thn ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center" style="white-space:nowrap">
                                <thead>
                                    <tr>
                                        <th style="min-width:160px;text-align:left">Kategori</th>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <th style="min-width:80px"><?= date("M", mktime(0, 0, 0, $i, 1)) ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:left">Sambungan Awal</td>
                                        <td><input type="number" name="s_awal_1" id="s_awal_1" class="form-control form-control-sm s_awal" value="<?= isset($existing[1][1]) ? $existing[1][1] : 0 ?>"></td>
                                        <?php for ($i = 2; $i <= 12; $i++) : $val = isset($existing[$i][1]) ? $existing[$i][1] : 0; ?>
                                            <td><input type="number" name="s_awal_<?= $i ?>" id="s_awal_<?= $i ?>" class="form-control form-control-sm s_awal" value="<?= $val ?>" readonly></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left">Sambungan Baru</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : $val = isset($existing[$i][2]) ? $existing[$i][2] : 0; ?>
                                            <td><input type="number" name="s_baru[<?= $i ?>]" class="form-control form-control-sm s_baru" value="<?= $val ?>"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left">Penutupan</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : $val = isset($existing[$i][3]) ? $existing[$i][3] : 0; ?>
                                            <td><input type="number" name="penutupan[<?= $i ?>]" class="form-control form-control-sm penutupan" value="<?= $val ?>"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left">Pembukaan</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : $val = isset($existing[$i][4]) ? $existing[$i][4] : 0; ?>
                                            <td><input type="number" name="pembukaan[<?= $i ?>]" class="form-control form-control-sm pembukaan" value="<?= $val ?>"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left">Pencabutan</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : $val = isset($existing[$i][5]) ? $existing[$i][5] : 0; ?>
                                            <td><input type="number" name="pencabutan[<?= $i ?>]" class="form-control form-control-sm pencabutan" value="<?= $val ?>"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left">Sambungan Akhir</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : $val = isset($existing[$i][6]) ? $existing[$i][6] : 0; ?>
                                            <td><input type="number" name="s_akhir_<?= $i ?>" id="s_akhir_<?= $i ?>" class="form-control form-control-sm s_akhir" value="<?= $val ?>" readonly></td>
                                        <?php endfor; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>


    <script>
        function hitung(bln) {
            var s_awal = parseInt(document.getElementById('s_awal_' + bln).value) || 0;
            var s_baru = parseInt(document.getElementsByName('s_baru[' + bln + ']')[0].value) || 0;
            var tutup = parseInt(document.getElementsByName('penutupan[' + bln + ']')[0].value) || 0;
            var buka = parseInt(document.getElementsByName('pembukaan[' + bln + ']')[0].value) || 0;
            var cabut = parseInt(document.getElementsByName('pencabutan[' + bln + ']')[0].value) || 0;

            var s_akhir = s_awal + s_baru - tutup + buka - cabut;
            document.getElementById('s_akhir_' + bln).value = s_akhir;

            if (bln < 12) {
                document.getElementById('s_awal_' + (bln + 1)).value = s_akhir;
            }
        }

        document.querySelectorAll('.s_baru, .penutupan, .pembukaan, .pencabutan, .s_awal').forEach(function(el) {
            el.addEventListener('input', function() {
                var bulan = 1;
                if (this.name && this.name.match(/\[(\d+)\]/)) {
                    bulan = parseInt(this.name.match(/\[(\d+)\]/)[1]);
                } else if (this.id && this.id.match(/s_awal_(\d+)/)) {
                    bulan = parseInt(this.id.match(/s_awal_(\d+)/)[1]);
                }
                hitung(bulan);
                for (var b = bulan + 1; b <= 12; b++) {
                    hitung(b);
                }
            });
        });

        for (var b = 1; b <= 12; b++) {
            hitung(b);
        }

        document.getElementById('id_upk_sel').addEventListener('change', reloadIfReady);
        document.getElementById('id_jp_sel').addEventListener('change', reloadIfReady);

        function reloadIfReady() {
            var upk = document.getElementById('id_upk_sel').value;
            var jp  = document.getElementById('id_jp_sel').value;
            var thn = '<?= $thn ?>';
            if (upk && jp && thn) {
                var url = '<?= site_url('lembar_kerja/lr/pelanggan/tambah') ?>?id_upk=' + upk + '&id_jp=' + jp + '&tahun=' + thn;
                window.location.href = url;
            }
        }
    </script>