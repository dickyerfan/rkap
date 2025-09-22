<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/produksi_air') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_rkap = isset($tahun_rkap) ? $tahun_rkap : date('Y');
                                ?>
                                <select name="upk" class="form-select select2" style="width: 170px;">
                                    <option value="">KONSOLIDASI</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    $tahun_rkap = (int)$tahun_rkap;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == $tahun_rkap ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/produksi_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/produksi_air/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/produksi_air/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Data</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun + 1; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
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
                                <!-- <tbody>
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
                                </tbody> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>