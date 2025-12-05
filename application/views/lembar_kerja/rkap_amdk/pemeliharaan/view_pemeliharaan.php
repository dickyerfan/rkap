<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                // Buat range tahun dari 10 tahun lalu sampai tahun sekarang
                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                // Jika ada data tahun di depan tahun sekarang (misal user pilih tahun depan) ikut dimasukkan
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <!-- <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan/generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate ke Biaya AMDK</button> </a> -->
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Biaya AMDK
                                    </button>
                                </div>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Pemeliharaan</button> </a>
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
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center  align-middle">Uraian</th>
                                            <th rowspan="2" class="text-center  align-middle">Vol</th>
                                            <th rowspan="2" class="text-center  align-middle">Sat</th>
                                            <th rowspan="2" class="text-center  align-middle">Harga</th>
                                            <th colspan="12" class="text-center  align-middler">B U L A N</th>
                                            <th rowspan="2" class="text-center  align-middle">Jumlah</th>
                                        </tr>
                                        <tr class="text-center">
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
                                        $grand_total = 0;
                                        $grand_bulanan = array_fill(1, 12, 0);
                                        foreach ($pemeliharaan as $jenis => $kategori_list) : ?>
                                            <!-- Judul Jenis -->
                                            <tr class="bg-primary text-white fw-bold">
                                                <td colspan="17"><?= strtoupper($jenis) ?></td>
                                            </tr>

                                            <?php
                                            $total_jenis = 0;
                                            $total_jenis_bulanan = array_fill(1, 12, 0);
                                            foreach ($kategori_list as $kategori => $items) : ?>
                                                <!-- Judul Kategori -->
                                                <tr class="table-secondary fw-bold">
                                                    <td colspan="17">&nbsp;&nbsp;&nbsp;<?= strtoupper($kategori) ?></td>
                                                </tr>

                                                <?php
                                                $total_kategori = 0;
                                                $total_kategori_bulanan = array_fill(1, 12, 0);

                                                foreach ($items as $p) :
                                                    $total_kategori += $p['total_tahun'];
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        $total_kategori_bulanan[$i] += $p['per_bulan'];
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $p['uraian'] ?></td>
                                                        <td class="text-center"><?= $p['volume'] ?></td>
                                                        <td class="text-center"><?= $p['satuan'] ?></td>
                                                        <td class="text-end"><?= number_format($p['harga'], 0, ',', '.') ?></td>

                                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                            <td class="text-end"><?= number_format($p['per_bulan'], 0, ',', '.') ?></td>
                                                        <?php endfor; ?>

                                                        <td class="text-end fw-bold"><?= number_format($p['total_tahun'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <!-- Jumlah per kategori -->
                                                <tr class="fw-bold text-end bg-light">
                                                    <td colspan="4" class="text-start">Jumlah <?= $kategori ?></td>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) :
                                                        echo '<td>' . number_format($total_kategori_bulanan[$i], 0, ',', '.') . '</td>';
                                                        $total_jenis_bulanan[$i] += $total_kategori_bulanan[$i];
                                                    endfor;
                                                    ?>
                                                    <td><?= number_format($total_kategori, 0, ',', '.') ?></td>
                                                </tr>

                                                <?php $total_jenis += $total_kategori; ?>
                                            <?php endforeach; ?>

                                            <!-- Jumlah per jenis -->
                                            <tr class="fw-bold text-end bg-warning">
                                                <td colspan="4" class="text-start">Jumlah <?= $jenis ?></td>
                                                <?php
                                                for ($i = 1; $i <= 12; $i++) :
                                                    echo '<td>' . number_format($total_jenis_bulanan[$i], 0, ',', '.') . '</td>';
                                                    $grand_bulanan[$i] += $total_jenis_bulanan[$i];
                                                endfor;
                                                ?>
                                                <td><?= number_format($total_jenis, 0, ',', '.') ?></td>
                                            </tr>

                                            <?php $grand_total += $total_jenis; ?>
                                        <?php endforeach; ?>

                                        <!-- Total keseluruhan -->
                                        <tr class="fw-bold text-end bg-success text-white">
                                            <td colspan="4" class="text-start">TOTAL KESELURUHAN</td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td><?= number_format($grand_bulanan[$i], 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>
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
                Pastikan semua data <b>Pemeliharaan AMDK</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>BIAYA AMDK</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/pemeliharaan/generate') ?>";
                }
            });
        });
    </script>