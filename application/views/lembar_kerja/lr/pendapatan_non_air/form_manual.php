<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_non_air?upk=' . $upk . '&tahun=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <?php
                            $nama_upk = '';
                            foreach ($list_upk as $u) {
                                if ($u->id_upk == $upk) {
                                    $nama_upk = strtoupper($u->nama_upk);
                                    break;
                                }
                            }
                            ?>
                            <h5 class="text-center">INPUT MANUAL - UPK <?= $nama_upk ?> TAHUN <?= $tahun ?></h5>
                            <p class="text-center text-muted">Isi nilai pendapatan untuk masing-masing bulan (Kosongkan jika tidak ada)</p>

                            <form id="formManual" method="post" action="<?= site_url('lembar_kerja/lr/pendapatan_non_air/save_manual') ?>">
                                <input type="hidden" name="id_upk" value="<?= $upk ?>">
                                <input type="hidden" name="tahun" value="<?= $tahun ?>">

                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" style="font-size: 0.8rem;" id="table-manual">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Jenis Pendapatan</th>
                                                <th class="text-center">Jan</th>
                                                <th class="text-center">Feb</th>
                                                <th class="text-center">Mar</th>
                                                <th class="text-center">Apr</th>
                                                <th class="text-center">Mei</th>
                                                <th class="text-center">Jun</th>
                                                <th class="text-center">Jul</th>
                                                <th class="text-center">Agu</th>
                                                <th class="text-center">Sep</th>
                                                <th class="text-center">Okt</th>
                                                <th class="text-center">Nov</th>
                                                <th class="text-center">Des</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $manual_jenis = [
                                                'Pendapatan_Ganti_Meter_Rusak' => 'Pendapatan Ganti Meter Rusak',
                                                'Pendapatan_Penggatian_Pipa_Persil' => 'Pendapatan Penggatian Pipa Persil',
                                                'Pendapatan_Non_Air_Lainnya' => 'Pendapatan Non Air Lainnya',
                                            ];
                                            foreach ($manual_jenis as $safe_jenis => $label) :
                                            ?>
                                                <tr>
                                                    <td class="fw-bold"><?= $label ?></td>
                                                    <?php for ($b = 1; $b <= 12; $b++) :
                                                        $val = isset($existing[$label][$b]) ? $existing[$label][$b]->nilai : 0;
                                                    ?>
                                                        <td>
                                                            <input type="text" name="nilai[<?= $safe_jenis ?>][<?= $b ?>]" class="form-control form-control-sm text-end input-rupiah" value="<?= $val > 0 ? number_format($val, 0, ',', '.') : '' ?>" style="min-width: 80px;">
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="neumorphic-button">Simpan Data</button>
                                    <!-- <a href="<?= base_url('lembar_kerja/lr/pendapatan_non_air?upk=' . $upk . '&tahun=' . $tahun) ?>"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a> -->
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        // Strip rupiah formatting before submit - target formManual specifically
        document.getElementById('formManual').addEventListener('submit', function() {
            document.querySelectorAll('.input-rupiah').forEach(function(el) {
                el.value = el.value.replace(/[^0-9]/g, '');
            });
        });

        // Format rupiah on input
        document.querySelectorAll('.input-rupiah').forEach(function(el) {
            el.addEventListener('keyup', function(e) {
                let val = this.value.replace(/[^0-9]/g, '');
                if (val) {
                    this.value = new Intl.NumberFormat('id-ID').format(val);
                } else {
                    this.value = '';
                }
            });
        });
    </script>