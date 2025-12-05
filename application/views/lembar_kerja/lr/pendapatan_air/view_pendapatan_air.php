<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>" method="get">
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
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/pendapatan_air/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/data_pendukung/') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Jasa Pemel & Admin</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Pola Kons & Tarif</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_air/tangki_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input TA</button> </a>
                                </div>
                                <?php if (!empty($upk)) : ?>
                                    <form method="post" action="<?= site_url('lembar_kerja/lr/pendapatan_air/generate_rekap'); ?>">
                                        <input type="hidden" name="upk" value="<?= $upk; ?>">
                                        <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                        <button type="submit" class="neumorphic-button">
                                            <i class="fa fa-database"></i> Generate Data
                                        </button>
                                    </form>
                                <?php endif; ?>
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
                                        <?php
                                        $uraianList = [
                                            'Pelanggan Akhir',
                                            'Pola Konsumsi',
                                            'Tarif Rata',
                                            'Penjualan Air',
                                            'Jasa Pemeliharaan',
                                            'Jasa Administrasi',
                                            'Tagihan Air'
                                        ];

                                        foreach ($uraianList as $judul) {
                                            echo "<tr><td colspan='14'><b>{$judul}</b></td></tr>";

                                            // loop per jenis pelanggan
                                            foreach ($data_pendapatan_air as $jp => $blok) {
                                                echo "<tr>";
                                                echo "<td>- {$jp}</td>";

                                                $jumlahKolom = 0;
                                                for ($bulan = 1; $bulan <= 12; $bulan++) {
                                                    $nilai = isset($blok[$judul][$bulan]) ? $blok[$judul][$bulan] : 0;
                                                    echo "<td class='text-end pe-1'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                                    if (in_array($judul, ['Pelanggan Akhir', 'Pola Konsumsi', 'Tarif Rata'])) {
                                                        if ($bulan == 12) {
                                                            $jumlahKolom = $nilai; // ambil Desember
                                                        }
                                                    } else {
                                                        $jumlahKolom += $nilai; // normal: sum
                                                    }
                                                }
                                                echo "<td class='text-end pe-1'><b>" . number_format($jumlahKolom, 0, ',', '.') . "</b></td>";
                                                echo "</tr>";
                                            }

                                            // ===== TOTAL BAWAH =====
                                            echo "<tr style='background:#eee;font-weight:bold;'>";
                                            echo "<td>Jumlah {$judul}</td>";

                                            $grand = 0;
                                            for ($bulan = 1; $bulan <= 12; $bulan++) {
                                                $totalBulan = 0;
                                                $countJenis = count($data_pendapatan_air);

                                                foreach ($data_pendapatan_air as $blok) {
                                                    $totalBulan += $blok[$judul][$bulan] ?? 0;
                                                }

                                                if (in_array($judul, ['Pola Konsumsi', 'Tarif Rata'])) {
                                                    // rata-rata per jenis pelanggan
                                                    $nilai = $countJenis > 0 ? $totalBulan / $countJenis : 0;
                                                    echo "<td class='text-end pe-1'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                                    if ($bulan == 12) {
                                                        $grand = $nilai; // ambil Desember
                                                    }
                                                } elseif ($judul == 'Pelanggan Akhir') {
                                                    echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                                    if ($bulan == 12) {
                                                        $grand = $totalBulan; // ambil Desember
                                                    }
                                                } else {
                                                    echo "<td class='text-end pe-1'>" . number_format($totalBulan, 0, ',', '.') . "</td>";
                                                    $grand += $totalBulan; // normal sum
                                                }
                                            }

                                            echo "<td class='text-end pe-1'>" . number_format($grand, 0, ',', '.') . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($upk == 1 || $upk == '') : ?>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 text-center">
                                <h5><?= $title2 . ' ' .  $tahun; ?></h5>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
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
                                            <tr>
                                                <td colspan="14"><strong>Pend Penj Air Lainnya</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="14" style="padding-left: 20px;">- Terminal Air (TA)</td>
                                            </tr>

                                            <?php
                                            // Definisikan baris dan labelnya agar mudah di-loop
                                            $uraian_list = [
                                                'penggunaan_rata2' => 'Jumlah Penggunaan rata2',
                                                'm3_rata2' => 'Jumlah M3 rata2',
                                                'tarif_rata2' => 'Tarif rata2'
                                            ];

                                            foreach ($uraian_list as $key => $label) :
                                                // Cek apakah data untuk baris ini ada
                                                if (isset($tangki_air[$key])) :
                                                    $is_nilai_penjualan = ($key == 'nilai_penjualan');
                                            ?>
                                                    <tr>
                                                        <td style="padding-left: 27px;"><?= $is_nilai_penjualan ? "<strong>{$label}</strong>" : $label; ?></td>
                                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                            <td class="text-end pe-1">
                                                                <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                                            </td>
                                                        <?php endfor; ?>

                                                        <td class="text-end pe-1">
                                                            <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key]['total'], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key]['total'], 0, ',', '.'); ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr style="background:#eee;font-weight:bold;">
                                                <td>Jumlah Pend Penj Air Lainnya</td>
                                                <?php
                                                $grand_total = 0;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $total_bulan = $tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i];
                                                    echo "<td class='text-end pe-1'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                                                    $grand_total += $total_bulan;
                                                }
                                                ?>
                                                <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>