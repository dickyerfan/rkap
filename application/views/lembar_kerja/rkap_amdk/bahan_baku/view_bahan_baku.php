<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <!-- <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku/generate_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate ke Biaya AMDK</button> </a>
                            </div> -->
                                <div class="navbar-nav">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate Ke biaya AMDK
                                    </button>
                                </div>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Bahan Baku</button> </a>
                                </div>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/bahan_baku/tambah_perlengkapan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Perlengkapan</button> </a>
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
                                            <th rowspan="2" class="text-center align-middle">NO</th>
                                            <th rowspan="2" class="text-center  align-middle">Uraian</th>
                                            <th rowspan="2" class="text-center  align-middle">Prod</th>
                                            <th rowspan="2" class="text-center  align-middle">Volume</th>
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
                                        $no = 1;
                                        $produk_sekarang = null;
                                        $grand_total_per_bulan = array_fill(1, 12, 0);
                                        $grand_total_tahun = 0;
                                        $subtotal_per_produk = array_fill(1, 12, 0);
                                        $total_tahun_produk = 0;
                                        ?>

                                        <?php foreach ($bahan_baku as $bahan) : ?>
                                            <?php
                                            $nilai_per_bulan = $bahan['total_tahun'] / 12;
                                            $subtotal = $bahan['total_tahun'];
                                            $jumlah_produksi = $bahan['jumlah_produksi'];

                                            // Jika produk berubah, tampilkan header baru
                                            if ($produk_sekarang !== $bahan['nama_produk']) :
                                                // Jika bukan produk pertama, tampilkan total produk sebelumnya
                                                if ($produk_sekarang !== null) : ?>
                                                    <tr style="font-weight:bold;background:#f9f9f9;">
                                                        <td colspan="5" class="text-start">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                            <td class="text-end"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                                                        <?php endfor; ?>
                                                        <td class="text-end"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                                                    </tr>
                                                <?php endif;

                                                // Reset subtotal untuk produk baru
                                                $subtotal_per_produk = array_fill(1, 12, 0);
                                                $total_tahun_produk = 0;
                                                $no = 1;
                                                $produk_sekarang = $bahan['nama_produk'];
                                                ?>
                                                <!-- JUDUL PRODUK -->
                                                <tr>
                                                    <td colspan="2" class="text-center fw-bold">BAHAN BAKU <?= strtoupper($produk_sekarang); ?></td>
                                                    <td colspan="16"></td>
                                                </tr>
                                            <?php endif; ?>

                                            <!-- Baris bahan -->
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-left"><?= $bahan['nama_bahan']; ?></td>
                                                <td class="text-end"><?= number_format($jumlah_produksi, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($bahan['volume'], 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($bahan['harga_satuan'], 0, ',', '.'); ?></td>

                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($nilai_per_bulan, 0, ',', '.'); ?></td>
                                                    <?php
                                                    $subtotal_per_produk[$i] += $nilai_per_bulan;
                                                    $grand_total_per_bulan[$i] += $nilai_per_bulan;
                                                    ?>
                                                <?php endfor; ?>

                                                <td class="text-end"><?= number_format($subtotal, 0, ',', '.'); ?></td>
                                            </tr>

                                            <?php
                                            $total_tahun_produk += $subtotal;
                                            $grand_total_tahun += $subtotal;
                                            ?>
                                        <?php endforeach; ?>

                                        <!-- TOTAL PRODUK TERAKHIR -->
                                        <?php if ($produk_sekarang !== null) : ?>
                                            <tr class="fw-bold">
                                                <td colspan="5" class="text-start">Jumlah Bahan Baku <?= strtoupper($produk_sekarang); ?></td>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($subtotal_per_produk[$i], 0, ',', '.'); ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= number_format($total_tahun_produk, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endif; ?>

                                        <!-- TOTAL KESELURUHAN -->
                                        <tr style="font-weight:bold;background:#e3e3e3;">
                                            <td colspan="5" class="text-start">JUMLAH</td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td class="text-end"><?= number_format($grand_total_per_bulan[$i], 0, ',', '.'); ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end"><?= number_format($grand_total_tahun, 0, ',', '.'); ?></td>
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
                Pastikan semua data <b>Pembelian Bahan Baku</b> sudah <b>final</b> sebelum melakukan generate.
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
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/bahan_baku/generate') ?>";
                }
            });
        });
    </script>