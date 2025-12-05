<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_non_air') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="upk" class="form-select select2">
                                    <option value="">Konsolidasi</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 90px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap  ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_non_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_non_air/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate Arus Kas
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <?php
                            // daftar uraian
                            $pendapatan_non_air = [
                                'Penerimaan Non Air' => [
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
                            <div class="table-responsive">
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
                                            <tr class="fw-bold table-secondary">
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
                                            <tr class="fw-bold table-secondary">
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
        </div>
    </main>

    <script>
        document.getElementById('btnGenerate').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin Generate Data?',
                html: `
            <p style="font-size:18px; margin-top:10px;">
                Pastikan semua data <b>Penerimaan Non Air</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN ARUS KAS</b>.
            </p>
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Generate Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke controller generate
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/penerimaan_non_air/generate') ?>";
                }
            });
        });
    </script>