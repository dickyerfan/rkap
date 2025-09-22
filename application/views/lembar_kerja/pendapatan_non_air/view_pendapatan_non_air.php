<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/pendapatan_non_air') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_rkap = isset($tahun_rkap) ? $tahun_rkap : date('Y');
                                ?>
                                <select name="upk" class="form-select select2" style="width: 170px;">
                                    <option value="">KONSOLIDASI</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    $tahun_rkap = (int)$tahun_rkap;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == $tahun_rkap ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/pendapatan_non_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/pendapatan_non_air/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/pendapatan_non_air/form_generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate Data</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <?php
                            // daftar uraian
                            $pendapatan_non_air = [
                                'Pendapatan Non Air' => [
                                    'Pendapatan Sambungan Baru' => ' - Pendapatan Sambungan Baru',
                                    'Pendapatan Pendaftaran' => ' - Pendapatan Pendaftaran',
                                    'Pendapatan Balik Nama' => ' - Pendapatan Balik Nama',
                                    'Pendapatan Penyambungan Kembali' => ' - Pendapatan Penyamb Kembali',
                                    'Pendapatan Denda' => ' - Pendapatan Denda',
                                    'Pendapatan Ganti Meter Rusak' => ' - Pendapatan Ganti Meter Rusak',
                                    'Pendapatan Penggatian Pipa Persil' => ' - Pendapatan Penggantian pipa persil',
                                    'Pendapatan Non Air Lainnya' => ' - Pendapatan Non Air lainnya',
                                ]
                            ];

                            ?>
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">URAIAN</th>
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
                                        <th class="text-center">JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendapatan_non_air as $judul => $items) : ?>
                                        <tr class="fw-bold">
                                            <td><?= $judul; ?></td>
                                            <td colspan="13"></td>
                                        </tr>
                                        <?php foreach ($items as $jenis => $label) : ?>
                                            <tr>
                                                <td><?= $label; ?></td>
                                                <?php
                                                $total_row = 0;
                                                for ($i = 1; $i <= 12; $i++) :
                                                    $nilai = isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                                                    $total_row += $nilai;
                                                ?>
                                                    <td class="text-end"><?= number_format($nilai, 0, ',', '.'); ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end fw-bold"><?= number_format($total_row, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <!-- Jumlah per kelompok -->
                                        <tr class="fw-bold table-light">
                                            <td>Jumlah <?= $judul; ?></td>
                                            <?php
                                            $total_per_bulan = [];
                                            $grand_total = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $sum = 0;
                                                foreach ($items as $jenis => $label) {
                                                    $sum += isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                                                }
                                                $total_per_bulan[$i] = $sum;
                                                $grand_total += $sum;
                                                echo '<td class="text-end">' . number_format($sum, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>