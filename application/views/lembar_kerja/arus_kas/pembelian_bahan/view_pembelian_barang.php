<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <!-- <div class="navbar-nav ms-2">
                            <a href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/simpan_otomatis') ?>" onclick="return confirm('Yakin ingin menyimpan semua data otomatis?')">
                                <button class="neumorphic-button"><i class="fas fa-save"></i> Simpan Otomatis</button>
                            </a>
                        </div> -->
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Daftar Barang</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Arus Kas
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

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No Per</th>
                                            <th class="text-center">Uraian</th>
                                            <th class="text-center">Vol</th>
                                            <th class="text-center">Harga</th>
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
                                    <?php if ($tahun == 2026) : ?>
                                        <tbody>
                                            <?php
                                            $total_bulan = array_fill(1, 12, 0);
                                            $total_semua = 0;

                                            $exclude_bulan = array_fill(1, 12, 0);
                                            $exclude_total = 0;
                                            ?>

                                            <?php foreach ($barang as $b) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $b['no_per_id'] ?></td>
                                                    <td><?= $b['nama_barang'] ?></td>
                                                    <td class="text-center"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                                                    <?php for ($m = 1; $m <= 12; $m++) :
                                                        $nilai = $b['bulanData'][$m] ?? 0;
                                                        $total_bulan[$m] += $nilai;

                                                        if (in_array($b['id_barang'], [1, 2, 3])) {
                                                            $exclude_bulan[$m] += $nilai;
                                                        }
                                                    ?>
                                                        <td class="text-end">
                                                            <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end"><?= number_format($b['jumlah'], 0, ',', '.') ?></td>

                                                    <?php
                                                    $total_semua += $b['jumlah'];
                                                    if (in_array($b['id_barang'], [1, 2, 3])) {
                                                        $exclude_total += $b['jumlah'];
                                                    }
                                                    ?>
                                                </tr>
                                            <?php endforeach; ?>

                                            <tr class="fw-bold bg-light">
                                                <td colspan="4" class="text-center">JUMLAH</td>
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $final_bulan = $total_bulan[$m] - $exclude_bulan[$m];
                                                ?>
                                                    <td class="text-end"><?= number_format($final_bulan, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($total_semua - $exclude_total, 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    <?php else : ?>
                                        <tbody>
                                            <?php
                                            $total_bulan = array_fill(1, 12, 0);
                                            $total_semua = 0;
                                            ?>

                                            <?php foreach ($barang as $b) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $b['no_per_id'] ?></td>
                                                    <td><?= $b['nama_barang'] ?></td>
                                                    <td class="text-center"><?= number_format($b['volume'], 0, ',', '.') ?></td>
                                                    <td class="text-end"><?= number_format($b['harga'], 0, ',', '.') ?></td>

                                                    <?php for ($m = 1; $m <= 12; $m++) :
                                                        $nilai = $b['bulanData'][$m] ?? 0;
                                                        $total_bulan[$m] += $nilai;
                                                    ?>
                                                        <td class="text-end">
                                                            <?= $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-' ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end">
                                                        <?= number_format($b['jumlah'], 0, ',', '.') ?>
                                                    </td>
                                                </tr>

                                                <?php $total_semua += $b['jumlah']; ?>
                                            <?php endforeach; ?>

                                            <tr class="fw-bold bg-light">
                                                <td colspan="4" class="text-center">JUMLAH</td>
                                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                    <td class="text-end"><?= number_format($total_bulan[$m], 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                            </tr>
                                        </tbody>
                                    <?php endif; ?>
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
                Pastikan semua data <b>Penerimaan Aktiva lainnya</b> sudah <b>final</b> sebelum melakukan generate.
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
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/pembelian_bahan/generate') ?>";
                }
            });
        });
    </script>