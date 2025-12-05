<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/laba_rugi/pajak') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/laba_rugi/pajak') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/laba_rugi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-arrow-left"></i> Kembali</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate Pajak Ke Laba Rugi
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
                            <h5><?= $title . ' ' .  $tahun - 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size:1rem;">
                                    <tr>
                                        <th colspan="2">Laba / (Rugi) Komersial</th>
                                        <td class="text-end fw-bold"><?= number_format($laba_komersial, 0, ',', '.'); ?></td>
                                    </tr>

                                    <tr class="bg-light">
                                        <th colspan="3">Koreksi Fiskal Positif</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Beban Representasi</td>
                                        <td class="text-end"><?= number_format($beban_representasi, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Beban Penyisihan Piutang</td>
                                        <td class="text-end"><?= number_format($beban_penyisihan_piutang, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> Beban rapat dan tamu</td>
                                        <td class="text-end"><?= number_format($beban_rapat_dan_tamu, 0, ',', '.'); ?></td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="2">Koreksi PPN Masukan AMDK</td>
                                        <td class="text-end"><?= number_format($koreksi_ppn_masukan_amdk, 0, ',', '.'); ?></td>
                                    </tr> -->
                                    <tr>
                                        <th colspan="2">Total Koreksi Fiskal Positif</th>
                                        <th class="text-end"><?= number_format($koreksi_fiskal_positif, 0, ',', '.'); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th class="text-end font-weight-bold"><?= number_format($laba_komersial + $koreksi_fiskal_positif, 0, ',', '.'); ?></th>
                                    </tr>

                                    <tr class="bg-light">
                                        <th colspan="3">Koreksi Fiskal Negatif</th>
                                    </tr>

                                    <tr>
                                        <td colspan="2"> Pendapatan Bunga</td>
                                        <td class="text-end"><?= number_format($pendapatan_bunga, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Total Koreksi Fiskal Negatif</th>
                                        <th class="text-end"><?= number_format($koreksi_fiskal_negatif, 0, ',', '.'); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Laba / Rugi Setelah Koreksi Fiskal</th>
                                        <th class="text-end "><?= number_format($laba_fiskal, 0, ',', '.'); ?></th>
                                    </tr>

                                    <tr class="bg-light">
                                        <th colspan="3">Dasar Perhitungan Pajak</th>
                                    </tr>
                                    <tr>
                                        <td>Tarif Pajak</td>
                                        <td><?= number_format($nilai_tetap, 0, ',', '.'); ?> x <?= number_format($laba_fiskal, 0, ',', '.'); ?> / <?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
                                        <td class="text-end"><?= number_format($bagian1, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr class="bg-light">
                                        <th colspan="3">Perhitungan Pajak</th>
                                    </tr>
                                    <tr>
                                        <td>1. Tarif 50% × 25%</td>
                                        <td>25% x 25% × <?= number_format($bagian1, 0, ',', '.'); ?></td>
                                        <td class="text-end"><?= number_format($pajak_bagian1, 0, ',', '.'); ?></td>
                                    </tr>

                                    <tr>
                                        <td>2. Tarif 25%</td>
                                        <td>12% x (<?= number_format($laba_fiskal, 0, ',', '.'); ?> - <?= number_format($bagian1, 0, ',', '.'); ?>)</td>
                                        <td class="text-end"><?= number_format($pajak_bagian2, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Pajak Penghasilan Badan Terutang</td>
                                        <td class="text-end"><?= number_format($pajak_terutang, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr class="table-success">
                                        <th colspan="2">Pajak Penghasilan Badan Terutang (dibulatkan)</th>
                                        <td class="text-end fw-bold"><?= number_format($pajak_bulat, 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr class="table-warning">
                                        <th colspan="2">Pajak Penghasilan Badan per Bulan</th>
                                        <td class="text-end fw-bold"><?= number_format($pajak_per_bulan, 0, ',', '.'); ?></td>
                                    </tr>
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
                Pastikan semua data <b>Pajak kini</b> sudah <b>final</b> sebelum melakukan generate.
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
                    window.location.href = "<?= base_url('lembar_kerja/lr/laba_rugi/generate_pajak') ?>";
                }
            });
        });
    </script>