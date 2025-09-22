<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <!-- <form action="<?= base_url('lembar_kerja/pelanggan') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($_GET['upk']) ? $_GET['upk'] : '';
                                $tahun_rkap = isset($_GET['tahun_rkap']) ? $_GET['tahun_rkap'] : date('Y');
                                ?>
                                <select name="upk" class="form-select select2" style="width: 170px;">
                                    <option value="">KONSOLIDASI</option>
                                    <option value="1" <?= $upk == '1' ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="2" <?= $upk == '2' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="3" <?= $upk == '3' ? 'selected' : '' ?>>Maesan</option>
                                    <option value="4" <?= $upk == '4' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="5" <?= $upk == '5' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="6" <?= $upk == '6' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="7" <?= $upk == '7' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="8" <?= $upk == '8' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="9" <?= $upk == '9' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="10" <?= $upk == '10' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="11" <?= $upk == '11' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="12" <?= $upk == '12' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="13" <?= $upk == '13' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="14" <?= $upk == '14' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="15" <?= $upk == '15' ? 'selected' : '' ?>>Sukosari 2</option>
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
                        </form> -->
                        <form action="<?= base_url('lembar_kerja/pelanggan') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/pelanggan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/pelanggan/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/pelanggan/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Data</button> </a>
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
    </main>