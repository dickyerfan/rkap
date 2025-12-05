<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/beban_pengolahan') ?>" method="get">
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
                                <select name="upk" id="upk" class="form-control mr-2">
                                    <option value="">Konsolidasi</option>
                                    <option value="01" <?= ($this->input->get('upk') == '01') ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="02" <?= ($this->input->get('upk') == '02') ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="03" <?= ($this->input->get('upk') == '03') ? 'selected' : '' ?>>Maesan</option>
                                    <option value="04" <?= ($this->input->get('upk') == '04') ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="05" <?= ($this->input->get('upk') == '05') ? 'selected' : '' ?>>Tapen</option>
                                    <option value="06" <?= ($this->input->get('upk') == '06') ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="07" <?= ($this->input->get('upk') == '07') ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="08" <?= ($this->input->get('upk') == '08') ? 'selected' : '' ?>>Wringin</option>
                                    <option value="09" <?= ($this->input->get('upk') == '09') ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="11" <?= ($this->input->get('upk') == '11') ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="12" <?= ($this->input->get('upk') == '12') ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="13" <?= ($this->input->get('upk') == '13') ? 'selected' : '' ?>>AMDK</option>
                                    <option value="14" <?= ($this->input->get('upk') == '14') ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="15" <?= ($this->input->get('upk') == '15') ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="16" <?= ($this->input->get('upk') == '16') ? 'selected' : '' ?>>Klabang</option>
                                    <option value="22" <?= ($this->input->get('upk') == '22') ? 'selected' : '' ?>>Sukosari 2</option>
                                    <option value="23" <?= ($this->input->get('upk') == '23') ? 'selected' : '' ?>>Umum</option>
                                    <option value="24" <?= ($this->input->get('upk') == '24') ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="25" <?= ($this->input->get('upk') == '25') ? 'selected' : '' ?>>Langganan</option>
                                    <option value="26" <?= ($this->input->get('upk') == '26') ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="27" <?= ($this->input->get('upk') == '27') ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="28" <?= ($this->input->get('upk') == '28') ? 'selected' : '' ?>>S P I</option>

                                </select>
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_pengolahan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/beban_pengolahan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <!-- <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_pengolahan/generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate Laba Rugi</button> </a>
                            </div> -->
                                <div class="navbar-nav">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Laba Rugi
                                    </button>
                                </div>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_pengolahan/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Biaya</button> </a>
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
                                            <th colspan="2">PERKIRAAN</th>
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                            <th rowspan="2">ACTION</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // ambil variabel upk dari controller
                                        $upk = isset($upk) ? $upk : 'all';

                                        // 1. Inisialisasi Grand Total
                                        $grand_total = [
                                            'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                            'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                        ];
                                        ?>
                                        <?php foreach ($biaya as $parent) : ?>
                                            <?php if ($upk != 'all' && $upk != '') : ?>
                                                <!-- TAMPILKAN CHILDREN JIKA UPK DIPILIH -->
                                                <?php if (!empty($parent['children'])) : ?>
                                                    <?php foreach ($parent['children'] as $c) : ?>
                                                        <tr>
                                                            <td><?= $c['kode']; ?></td>
                                                            <td><?= $c['uraian']; ?></td>
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
                                                                <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                                    <?php
                                                                    $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                                    $level = $this->session->userdata('level');
                                                                    if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                                        <a href="<?= base_url('lembar_kerja/lr/beban_pengolahan/edit/' . urlencode(base64_encode($c['unique_key']))) ?>"><i class="fas fa-edit"></i></a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php
                                            // hitung subtotal tetap jalan di dua kondisi (karena dipakai juga untuk grand total)
                                            $sub = [
                                                'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                                'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                            ];

                                            if (!empty($parent['children'])) {
                                                foreach ($parent['children'] as $c) {
                                                    foreach ($sub as $k => $_) {
                                                        if (isset($c[$k])) {
                                                            $sub[$k] += $c[$k];
                                                        }
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

                                            <!-- SUBTOTAL (selalu tampil) -->
                                            <tr class="fw-bold">
                                                <td><?= $parent['kode']; ?></td>
                                                <td><?= $parent['uraian']; ?></td>
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

                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="fw-bold" style="background-color: #e9ecef; border-top: 2px solid #6c757d;">
                                        <tr>
                                            <td colspan="2">JUMLAH BIAYA PENGOLAHAN</td>
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
                Pastikan semua data <b>Biaya Pengolahan</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN LABA RUGI</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/lr/beban_pengolahan/generate') ?>";
                }
            });
        });
    </script>