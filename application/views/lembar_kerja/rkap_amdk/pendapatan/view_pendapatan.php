<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Harga</button> </a>
                                </div>
                                <div class="navbar-nav ms-2">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Laba Rugi
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
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">URAIAN</th>
                                            <th class="text-center">%</th>
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
                                        <?php
                                        $total_per_bulan = array_fill(1, 12, 0);
                                        foreach ($produksi as $produk) :
                                        ?>
                                            <tr class="fw-bold bg-light">
                                                <td><?= $produk['nama_produk'] ?>
                                                </td>
                                                <td></td>
                                                <?php
                                                $subtotal = 0;
                                                for ($i = 1; $i <= 12; $i++) :
                                                    $val = $produk['produksi'][$i];
                                                    $subtotal += $val;
                                                    $total_per_bulan[$i] += $val;
                                                ?>
                                                    <td class="text-end"><?= number_format($val, 0, ',', '.') ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end fw-bold"><?= number_format($subtotal, 0, ',', '.') ?></td>
                                            </tr>

                                            <?php foreach ($produk['tarif'] as $kategori => $data_tarif) : ?>
                                                <tr>
                                                    <!-- <td>- <?= 'Pendapatan ' . $produk['nama_produk'] . ' ' . $kategori   ?></td> -->
                                                    <td>- <?= $produk['nama_produk'] . ' ' . $kategori   ?></td>
                                                    <td class="text-center"><?= number_format($data_tarif['persen'], 0, ',', '.') ?></td>
                                                    <?php
                                                    for ($i = 1; $i <= 12; $i++) :
                                                        $val = $data_tarif['produksi'][$i];
                                                    ?>
                                                        <td class="text-end"><?= number_format($val, 0, ',', '.') ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end"><?= number_format($data_tarif['subtotal'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        <?php endforeach; ?>

                                        <!-- Baris total bawah -->
                                        <tr class="fw-bold bg-secondary text-white">
                                            <td>JUMLAH TOTAL</td>
                                            <td></td>
                                            <?php
                                            $grand_total = 0;
                                            for ($i = 1; $i <= 12; $i++) :
                                                $grand_total += $total_per_bulan[$i];
                                            ?>
                                                <td class="text-end"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card-header bg-light text-dark fw-bold">
                                KELOMPOK HARGA
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">URAIAN</th>
                                            <!-- <th class="text-center">Satuan</th> -->
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
                                        <?php foreach ($pendapatan['harga'] as $produk) : ?>
                                            <tr class="fw-bold">
                                                <td><?= strtoupper($produk['nama_produk']); ?></td>
                                                <!-- <td class="text-center">-</td> -->
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <td class="text-end"><?= number_format($produk['harga']); ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end fw-bold"><?= number_format($produk['harga'] * 12); ?></td>
                                            </tr>

                                            <?php foreach ($produk['tarif'] as $tarif => $row) : ?>
                                                <tr>
                                                    <td class="ps-4">- <?= ucfirst($tarif); ?></td>
                                                    <!-- <td class="text-center"><?= $row['persen']; ?>%</td> -->
                                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                        <td class="text-end"><?= number_format($row['harga']); ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end fw-bold"><?= number_format($row['harga'] * 12); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card-header bg-light text-dark fw-bold">
                                PENDAPATAN OPERASIONAL AMDK (Rp)
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead>
                                        <tr>
                                            <th class="text-center">URAIAN</th>
                                            <th class="text-center">%</th>
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
                                        <?php foreach ($pendapatan['pendapatan'] as $produk) : ?>
                                            <tr class="fw-bold">
                                                <td><?= strtoupper($produk['nama_produk']); ?></td>
                                                <td class="text-center">-</td>
                                                <?php
                                                $total = 0;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo '<td class="text-end">' . number_format($produk['pendapatan'][$i]) . '</td>';
                                                    $total += $produk['pendapatan'][$i];
                                                }
                                                ?>
                                                <td class="text-end fw-bold"><?= number_format($total); ?></td>
                                            </tr>

                                            <?php foreach ($produk['tarif'] as $tarif => $row) : ?>
                                                <tr>
                                                    <td class="ps-4">- <?= ucfirst($tarif); ?></td>
                                                    <td class="text-center"><?= number_format($row['persen'], 0); ?></td>
                                                    <?php
                                                    $subtotal = 0;
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        echo '<td class="text-end">' . number_format($row['pendapatan'][$i]) . '</td>';
                                                        $subtotal += $row['pendapatan'][$i];
                                                    }
                                                    ?>
                                                    <td class="text-end fw-bold"><?= number_format($subtotal); ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                        <?php endforeach; ?>
                                    </tbody>
                                    <!-- Total per bulan di bagian paling bawah -->
                                    <?php
                                    $total_per_bulan = array_fill(1, 12, 0);
                                    $grand_total = 0;

                                    foreach ($pendapatan['pendapatan'] as $produk) {
                                        foreach ($produk['tarif'] as $tarif) {
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_per_bulan[$i] += $tarif['pendapatan'][$i];
                                            }
                                        }
                                    }

                                    $grand_total = array_sum($total_per_bulan);
                                    ?>
                                    <tfoot>
                                        <tr class="fw-bold bg-secondary text-white">
                                            <td>JUMLAH TOTAL</td>
                                            <td></td>
                                            <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                <td class="text-end"><?= number_format($total_per_bulan[$i], 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end"><?= number_format($grand_total, 0, ',', '.') ?></td>
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
                Pastikan semua data <b>Pendapatan AMDK</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN LABA RUGI AMDK</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/pendapatan_ops/generate') ?>";
                }
            });
        });
    </script>