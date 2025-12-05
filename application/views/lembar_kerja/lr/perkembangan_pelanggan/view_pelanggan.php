<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/pelanggan') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pelanggan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/pelanggan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <!-- <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pelanggan/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Data</button> </a>
                        </div> -->
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun_rkap)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pelanggan/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Data</button> </a>
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
                            <h5><?= $title . ' ' .  $tahun_rkap; ?></h5>
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
                                        $no = 1;

                                        // buat map dari data yang ada supaya cepat lookup
                                        $map = [];
                                        if (!empty($data_pelanggan)) {
                                            foreach ($data_pelanggan as $r) {
                                                $k = isset($r['nama_kd']) ? trim($r['nama_kd']) : '';
                                                $j = isset($r['nama_jp']) ? trim($r['nama_jp']) : '';
                                                $m = isset($r['bulan']) ? (int)$r['bulan'] : 0;
                                                $val = isset($r['jumlah']) ? (int)$r['jumlah'] : 0;
                                                if ($k !== '' && $j !== '' && $m >= 1 && $m <= 12) {
                                                    $map[$k][$j][$m] = $val;
                                                }
                                            }
                                        }

                                        $kategori_list = isset($kategori_list) ? $kategori_list : [];
                                        $jenis_list = isset($jenis_list) ? $jenis_list : [];

                                        foreach ($kategori_list as $kategori) {
                                            echo "<tr><td colspan='14' class='fw-bold bg-light '>" . strtoupper(htmlspecialchars($kategori)) . "</td></tr>";

                                            // inisialisasi total per bulan untuk kategori ini
                                            $totalKategori = array_fill(1, 12, 0);
                                            $grandTotalKategori = 0;

                                            foreach ($jenis_list as $jenis) {
                                                echo "<tr>";
                                                echo "<td class='text-start'> - " . htmlspecialchars($jenis) . "</td>";

                                                $jumlah = 0;
                                                for ($b = 1; $b <= 12; $b++) {
                                                    $nilai = isset($map[$kategori][$jenis][$b]) ? (int)$map[$kategori][$jenis][$b] : 0;
                                                    echo "<td class='text-end pe-2'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                                    if ($kategori === 'Sambungan Awal' || $kategori === 'Sambungan Akhir') {
                                                        $jumlah = $nilai; // overwrite
                                                        $totalKategori[$b] += $nilai; // tetap masuk ke total kategori
                                                    } else {
                                                        $jumlah += $nilai;
                                                        $totalKategori[$b] += $nilai;
                                                    }
                                                }

                                                echo "<td class='fw-bold text-end pe-2'>" . number_format($jumlah, 0, ',', '.') . "</td>";
                                                echo "</tr>";

                                                // tambah ke grand total kategori
                                                $grandTotalKategori += $jumlah;
                                            }

                                            // tampilkan baris total kategori
                                            echo "<tr class='fw-bold bg-light'>";
                                            echo "<td class='text-center'>TOTAL " . strtoupper(htmlspecialchars($kategori)) . "</td>";
                                            for ($b = 1; $b <= 12; $b++) {
                                                echo "<td class='text-end pe-2' >" . number_format($totalKategori[$b], 0, ',', '.') . "</td>";
                                            }
                                            echo "<td class='text-end pe-2' >" . number_format($grandTotalKategori, 0, ',', '.') . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>