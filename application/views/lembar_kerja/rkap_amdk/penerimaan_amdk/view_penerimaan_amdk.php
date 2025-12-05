<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk') ?>" method="get">
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

                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/tampil_tahun_lalu') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button">Sisa Piutang Tahun Lalu</button> </a>
                        </div>

                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-1">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate Ke Arus Kas
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
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle" rowspan="2">URAIAN</th>
                                            <th class="text-center" colspan="2">TAGIHAN</th>
                                            <th class="text-center" colspan="13">PENERIMAAN (Rp)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Buah</th>
                                            <th class="text-center">Rupiah</th>
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

                                    <?php
                                    // Array untuk grand total di footer
                                    $footer_total_tagihan_buah = 0;
                                    $footer_total_tagihan_rp = 0;
                                    $footer_total_penerimaan = array_fill(1, 13, 0); // 1-12 bulan, 13 total
                                    ?>

                                    <tbody>
                                        <?php if (empty($penerimaan)) : ?>
                                            <tr>
                                                <td colspan="16" class="text-center">Data tidak ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php foreach ($penerimaan as $produk) : ?>

                                            <?php
                                            $rows = $produk['rows'];
                                            $total_produk = $rows['total_produk'];
                                            $th_lalu = $rows['th_lalu'];
                                            $bulanan = $rows['bulanan'];

                                            // Akumulasi untuk footer
                                            $footer_total_tagihan_buah += $total_produk['tagihan_buah'];
                                            $footer_total_tagihan_rp += $total_produk['tagihan_rp'];
                                            for ($i = 1; $i <= 13; $i++) {
                                                $footer_total_penerimaan[$i] += $total_produk['penerimaan'][$i];
                                            }
                                            ?>

                                            <tr class="fw-bold bg-light">
                                                <td><?= $total_produk['uraian']; ?></td>
                                                <td class="text-end"><?= number_format($total_produk['tagihan_buah'], 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($total_produk['tagihan_rp'], 0, ',', '.'); ?></td>
                                                <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                    <td class="text-end"><?= number_format($total_produk['penerimaan'][$i], 0, ',', '.'); ?></td>
                                                <?php endfor; ?>
                                            </tr>

                                            <tr>
                                                <td class="ps-4"><?= $th_lalu['uraian']; ?></td>
                                                <td class="text-end"><?= ($th_lalu['tagihan_buah'] == 0) ? '' : number_format($th_lalu['tagihan_buah'], 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= ($th_lalu['tagihan_rp'] == 0) ? '' : number_format($th_lalu['tagihan_rp'], 0, ',', '.'); ?></td>
                                                <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                    <td class="text-end">
                                                        <?= ($th_lalu['penerimaan'][$i] == 0) ? '' : number_format($th_lalu['penerimaan'][$i], 0, ',', '.'); ?>
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>

                                            <?php foreach ($bulanan as $nama_baris => $data_baris) : ?>
                                                <tr>
                                                    <td class="ps-4"><?= $data_baris['uraian']; ?></td>
                                                    <td class="text-end"><?= ($data_baris['tagihan_buah'] == 0) ? '' : number_format($data_baris['tagihan_buah'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= ($data_baris['tagihan_rp'] == 0) ? '' : number_format($data_baris['tagihan_rp'], 0, ',', '.'); ?></td>
                                                    <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                        <td class="text-end">
                                                            <?= ($data_baris['penerimaan'][$i] == 0) ? '' : number_format($data_baris['penerimaan'][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endforeach; ?>

                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="fw-bold bg-secondary text-white">
                                            <td>JUMLAH TOTAL</td>
                                            <td class="text-end"><?= number_format($footer_total_tagihan_buah, 0, ',', '.') ?></td>
                                            <td class="text-end"><?= number_format($footer_total_tagihan_rp, 0, ',', '.') ?></td>
                                            <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                <td class="text-end"><?= number_format($footer_total_penerimaan[$i], 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <h6 class="text-center"><?= $title2 . ' ' .  $tahun; ?></h6>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center align-middle" rowspan="2">URAIAN</th>
                                            <th class="text-center" colspan="2">TAGIHAN</th>
                                            <th class="text-center" colspan="13">PENERIMAAN (Rp)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Buah</th>
                                            <th class="text-center">Rupiah</th>
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

                                    <?php
                                    // Array untuk grand total di footer
                                    $footer_total_tagihan_buah = 0;
                                    $footer_total_tagihan_rp = 0;
                                    $footer_total_penerimaan = array_fill(1, 13, 0); // 1-12 bulan, 13 total
                                    ?>

                                    <tbody>
                                        <?php if (empty($non_air)) : ?>
                                            <tr>
                                                <td colspan="16" class="text-center">Data tidak ditemukan.</td>
                                            </tr>
                                        <?php endif; ?>

                                        <?php foreach ($non_air as $produk) : ?>

                                            <?php
                                            $rows = $produk['rows'];
                                            $total_produk = $rows['total_produk'];
                                            $th_lalu = $rows['th_lalu'];
                                            $bulanan = $rows['bulanan'];

                                            // Akumulasi untuk footer
                                            $footer_total_tagihan_buah += $total_produk['tagihan_buah'];
                                            $footer_total_tagihan_rp += $total_produk['tagihan_rp'];
                                            for ($i = 1; $i <= 13; $i++) {
                                                $footer_total_penerimaan[$i] += $total_produk['penerimaan'][$i];
                                            }
                                            ?>

                                            <tr class="fw-bold bg-light">
                                                <td><?= $total_produk['uraian']; ?></td>
                                                <td class="text-end"><?= number_format($total_produk['tagihan_buah'], 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($total_produk['tagihan_rp'], 0, ',', '.'); ?></td>
                                                <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                    <td class="text-end"><?= number_format($total_produk['penerimaan'][$i], 0, ',', '.'); ?></td>
                                                <?php endfor; ?>
                                            </tr>

                                            <tr>
                                                <td class="ps-4"><?= $th_lalu['uraian']; ?></td>
                                                <td class="text-end"><?= ($th_lalu['tagihan_buah'] == 0) ? '' : number_format($th_lalu['tagihan_buah'], 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= ($th_lalu['tagihan_rp'] == 0) ? '' : number_format($th_lalu['tagihan_rp'], 0, ',', '.'); ?></td>
                                                <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                    <td class="text-end">
                                                        <?= ($th_lalu['penerimaan'][$i] == 0) ? '' : number_format($th_lalu['penerimaan'][$i], 0, ',', '.'); ?>
                                                    </td>
                                                <?php endfor; ?>
                                            </tr>

                                            <?php foreach ($bulanan as $nama_baris => $data_baris) : ?>
                                                <tr>
                                                    <td class="ps-4"><?= $data_baris['uraian']; ?></td>
                                                    <td class="text-end"><?= ($data_baris['tagihan_buah'] == 0) ? '' : number_format($data_baris['tagihan_buah'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= ($data_baris['tagihan_rp'] == 0) ? '' : number_format($data_baris['tagihan_rp'], 0, ',', '.'); ?></td>
                                                    <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                        <td class="text-end">
                                                            <?= ($data_baris['penerimaan'][$i] == 0) ? '' : number_format($data_baris['penerimaan'][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endforeach; ?>

                                        <?php endforeach; ?>
                                    </tbody>

                                    <tfoot>
                                        <tr class="fw-bold bg-secondary text-white">
                                            <td>JUMLAH TOTAL</td>
                                            <td class="text-end"><?= number_format($footer_total_tagihan_buah, 0, ',', '.') ?></td>
                                            <td class="text-end"><?= number_format($footer_total_tagihan_rp, 0, ',', '.') ?></td>
                                            <?php for ($i = 1; $i <= 13; $i++) : ?>
                                                <td class="text-end"><?= number_format($footer_total_penerimaan[$i], 0, ',', '.') ?></td>
                                            <?php endfor; ?>
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
                Pastikan semua data <b>Penerimaan AMDK</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN ARUS KAS AMDK</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/penerimaan_amdk/generate') ?>";
                }
            });
        });
    </script>