<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;">
                        <?= strtoupper($title) ?>
                    </a>
                    <a href="<?= base_url('admin/usulan_inves') ?>">
                        <button class="float-end neumorphic-button">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type="hidden" name="id_usulanInvestasi" value="<?= $usulan_investasi->id_usulanInvestasi ?>">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="form-group mb-2">
                                    <label>Tahun Pembuatan RKAP</label>
                                    <input type="text" class="form-control" readonly value="<?= $usulan_investasi->tahun_rkap ?>">
                                </div>
                                <div class="form-group mb-2">
                                    <label>No Perkiraan</label>
                                    <input type="text" class="form-control" readonly value="<?= $usulan_investasi->no_perkiraan ?>">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Nama Perkiraan</label>
                                    <input type="text" class="form-control" readonly value="<?= $usulan_investasi->nama_perkiraan ?>">
                                </div>
                                <div class="form-group mb-4">
                                    <label>Biaya</label>
                                    <input type="text" class="form-control" readonly value="<?= number_format($usulan_investasi->biaya, 0, ',', '.') ?>">
                                </div>
                                <div class="alert alert-info">
                                    <table class="table table-borderless table-sm mb-0">
                                        <tr>
                                            <td width="180">Bagian / UPK</td>
                                            <td>: <?= $usulan_investasi->bagian_upk ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tahun RKAP</td>
                                            <td>: <?= $usulan_investasi->tahun_rkap + 1 ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>: Generate ke <strong>Biaya di Investasi</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="fw-bold">
                                        Pilih Bulan Generate
                                    </label>
                                    <div class="row mt-2">
                                        <?php
                                        $bulan = [
                                            1 => 'Januari',
                                            2 => 'Februari',
                                            3 => 'Maret',
                                            4 => 'April',
                                            5 => 'Mei',
                                            6 => 'Juni',
                                            7 => 'Juli',
                                            8 => 'Agustus',
                                            9 => 'September',
                                            10 => 'Oktober',
                                            11 => 'November',
                                            12 => 'Desember'
                                        ];
                                        foreach ($bulan as $id => $nama) :
                                        ?>
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input cek-bulan" type="checkbox" name="bulan[]" value="<?= $id ?>">
                                                    <label class="form-check-label">
                                                        <?= $nama ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="semua_bulan">
                                    <label class="form-check-label" for="semua_bulan">
                                        <strong>Pilih Semua Bulan</strong>
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-file-import"></i>
                                        Generate RKAP
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('semua_bulan').addEventListener('change', function() {
            document.querySelectorAll('.cek-bulan').forEach(function(item) {
                item.checked = document.getElementById('semua_bulan').checked;
            });
        });
        $('form').submit(function(e) {
            if ($('.cek-bulan:checked').length == 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan pilih minimal satu bulan.'
                });
                return false;
            }
        });
    </script>