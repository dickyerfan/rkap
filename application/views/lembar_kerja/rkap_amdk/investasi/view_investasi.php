<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk') ?>" method="get">
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
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <!-- <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate ke Arus Kas</button> </a> -->
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Arus Kas
                                    </button>
                                </div>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Investasi</button> </a>
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
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Uraian</th>
                                            <th>Lokasi</th>
                                            <th>Vol</th>
                                            <th>Sat</th>
                                            <th>Nilai</th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Agu</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Des</th>
                                            <th>Jml</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // 1. Inisialisasi Grand Total
                                        $grand_total = [
                                            'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                            'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                        ];
                                        ?>

                                        <?php foreach ($biaya as $parent) : ?>
                                            <tr class="bg-light fw-bold">
                                                <td><?= $parent['kode']; ?></td>
                                                <td><?= $parent['uraian']; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <?php if (!empty($parent['children'])) : ?>
                                                <?php foreach ($parent['children'] as $c) : ?>
                                                    <tr>
                                                        <td><?= $c['kode']; ?></td>
                                                        <td><?= $c['uraian']; ?></td>
                                                        <td><?= $c['upk']; ?></td>
                                                        <td class="text-center"><?= $c['vol']; ?></td>
                                                        <td class="text-center"><?= $c['sat']; ?></td>
                                                        <td class="text-end"><?= number_format($c['pagu'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['jan'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['feb'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['mar'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['apr'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['mei'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['jun'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['jul'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['agu'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['sep'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['okt'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['nov'], 0, ',', '.'); ?></td>
                                                        <td class="text-end"><?= number_format($c['des'], 0, ',', '.'); ?></td>
                                                        <td class="text-end fw-bold"><?= number_format($c['total_tahun'], 0, ',', '.'); ?></td>
                                                        <td class="text-center">
                                                            <!-- <a href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/edit/' . $c['cabang_id'] . '/' . $c['kode'] . '/' . urlencode($c['uraian'])) ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a> -->
                                                            <a href="<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/edit/' . $c['cabang_id'] . '/' . $c['kode'] . '/' . base64_encode($c['uraian'])) ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                        </td>

                                                    </tr>
                                                <?php endforeach; ?>

                                                <?php
                                                $sub = [
                                                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                                    'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                                ];
                                                foreach ($parent['children'] as $c) {
                                                    foreach ($sub as $k => $_) {
                                                        if (isset($c[$k])) {
                                                            $sub[$k] += $c[$k];
                                                        }
                                                    }
                                                }

                                                // 2. Tambahkan Subtotal ke Grand Total
                                                foreach ($grand_total as $k => $_) {
                                                    if (isset($sub[$k])) {
                                                        $grand_total[$k] += $sub[$k];
                                                    }
                                                }
                                                ?>
                                                <tr class="fw-bold" style="background-color: #f0f0f0;">
                                                    <td colspan="6">Subtotal <?= $parent['uraian']; ?></td>
                                                    <td class="text-end"><?= number_format($sub['jan'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['feb'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['mar'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['apr'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['mei'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['jun'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['jul'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['agu'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['sep'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['okt'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['nov'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['des'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($sub['jumlah'], 0, ',', '.'); ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot class="fw-bold" style="background-color: #e9ecef; border-top: 2px solid #6c757d;">
                                        <tr>
                                            <td colspan="6">TOTAL</td>
                                            <td class="text-end"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
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
                Pastikan semua data <b>Daftar Investasi</b> sudah <b>final</b> sebelum melakukan generate.
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
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/investasi_amdk/generate') ?>";
                }
            });
        });
    </script>