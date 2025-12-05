<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <!-- <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a> -->
                        <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <!-- Pilih UPK -->
                                <select name="upk" class="form-select select2" style="width: 130px;">
                                    <option value="">Konsolidasi</option>
                                    <option value="umum" <?= $upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="keuangan" <?= $upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="langganan" <?= $upk == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                    <option value="pemeliharaan" <?= $upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="perencanaan" <?= $upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="spi" <?= $upk == 'spi' ? 'selected' : '' ?>>Spi</option>
                                    <option value="amdk" <?= $upk == 'amdk' ? 'selected' : '' ?>>Amdk</option>
                                    <option value="sukosari1" <?= $upk == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="maesan" <?= $upk == 'maesan' ? 'selected' : '' ?>> Maesan</option>
                                    <option value="tegalampel" <?= $upk == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="tapen" <?= $upk == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="prajekan" <?= $upk == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="tlogosari" <?= $upk == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="wringin" <?= $upk == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="curahdami" <?= $upk == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="tamanan" <?= $upk == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="tenggarang" <?= $upk == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="tamankrocok" <?= $upk == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="klabang" <?= $upk == 'klabang' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="wonosari" <?= $upk == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="sukosari2" <?= $upk == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $tahun_mulai = date('Y') - 10;
                                    $tahun_selesai = date('Y') + 1;
                                    for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) :
                                    ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan" class="neumorphic-button" style="margin-left:5px;">
                            </div>
                        </form>

                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/kenaikan_gaji') ?>" method="post">
                            <div style="display: flex; align-items: center;">
                                <!-- <label for="bulan_naik" style="font-size: 0.8rem;" class="form-label mb-0">Bln naik</label> -->
                                <option value="">Bln Naik</option>
                                <select name="bulan_naik" id="bulan_naik" class="form-select">
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {

                                        echo "<option value='$i'>" . date('F', mktime(0, 0, 0, $i, 1)) . "</option>";
                                    }
                                    ?>
                                </select>
                                <!-- <label for="persentase_naik" style="font-size: 0.8rem;">% Naik</label> -->
                                <input type="number" name="persentase_naik" id="persentase_naik" placeholder="% Naik" class="form-control" step="1" required style="width: 100px;">
                                <input type="submit" value="Terapkan" class="neumorphic-button" style="margin-left:5px;">
                            </div>
                        </form>


                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/pegawai') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Daftar Pegawai</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <div class="navbar-nav">
                                <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/generate_tahunan?tahun_rkap=' . $tahun); ?>" class="nav-link fw-bold" onclick="return confirm('Yakin ingin generate otomatis data tenaga kerja tahun <?= $tahun; ?>?')">
                                    <button class="neumorphic-button"> Hitung Seluruh Gaji </button>
                                </a>
                            </div>
                            <?php if (!empty($upk)) : ?>
                                <form method="post" action="<?= site_url('lembar_kerja/arus_kas/tenaga_kerja/generate_rekap'); ?>">
                                    <input type="hidden" name="upk" value="<?= $upk; ?>">
                                    <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                    <button type="submit" class="neumorphic-button">
                                        <i class="fa fa-database"></i> Generate ke Cetet
                                    </button>
                                </form>
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
                                            <th class="text-center">Uraian</th>
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
                                        $current_bagian = '';
                                        $subtotal_bagian = array_fill(1, 12, 0);
                                        $grand_total = array_fill(1, 12, 0);
                                        $grand_total_tahunan = 0;

                                        foreach ($naker as $t) :
                                            // Jika bagian berubah
                                            if ($t->bagian != $current_bagian) {
                                                // Tampilkan subtotal bagian sebelumnya (kecuali pertama kali)
                                                if ($current_bagian != '') {
                                                    echo "<tr class='table-warning fw-bold'>";
                                                    echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                                    $subtotal_tahun = 0;
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                                        $subtotal_tahun += $subtotal_bagian[$i];
                                                    }
                                                    echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td>";
                                                    echo "</tr>";

                                                    // Tambahkan ke total keseluruhan
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        $grand_total[$i] += $subtotal_bagian[$i];
                                                    }
                                                    $grand_total_tahunan += $subtotal_tahun;

                                                    // Reset subtotal untuk bagian berikutnya
                                                    $subtotal_bagian = array_fill(1, 12, 0);
                                                }

                                                // Header bagian baru
                                                echo "<tr class='table-secondary'><td colspan='14'><b>" . strtoupper($t->bagian) . "</b></td></tr>";
                                                $current_bagian = $t->bagian;
                                            }

                                            // Rincian pegawai
                                            echo "<tr>
                                                <td colspan='14'>
                                                    <b>{$t->nama}</b> - <b>{$t->jabatan}</b>";

                                            if ($this->session->userdata('tipe') == 'admin') {
                                                echo "
                                                <a href='" . base_url('lembar_kerja/arus_kas/tenaga_kerja/edit/' . $t->id_tk) . "' 
                                                class='btn btn-dark btn-sm float-end' style='text-decoration: none;'>
                                                    <i class='fa fa-edit'></i> Input Data Gaji
                                                </a>";
                                            }

                                            echo "  </td>
                                            </tr>";

                                            $items = [
                                                'Gaji Pokok' => $t->gaji_pokok,
                                                'Tunjangan Istri' => $t->t_istri,
                                                'Tunjangan Anak' => $t->t_anak,
                                                'Tunjangan Jabatan' => $t->t_jabatan,
                                                'Tunjangan Transport' => $t->t_transport,
                                                'Tunjangan Pangan' => $t->t_pangan,
                                                'Uang Makan' => $t->uang_makan,
                                                'Tunjangan Perumahan' => $t->t_perumahan,
                                                'BPJS Kesehatan' => $t->bpjs_kesehatan,
                                                'BPJS TK' => $t->bpjs_tk,
                                                'Dapenmapamsi' => $t->dapenmapamsi,
                                            ];

                                            $total_gaji = 0;
                                            foreach ($items as $label => $nilai) {
                                                echo "<tr><td>{$label}</td>";
                                                for ($i = 1; $i <= 12; $i++) {
                                                    echo "<td class='text-end'>" . number_format($nilai, 0, ',', '.') . "</td>";
                                                }
                                                $total_tahun = $nilai * 12;
                                                echo "<td class='text-end fw-bold'>" . number_format($total_tahun, 0, ',', '.') . "</td></tr>";

                                                // Tambah ke subtotal bagian
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $subtotal_bagian[$i] += $nilai;
                                                }
                                                $total_gaji += $total_tahun;
                                            }

                                            // Total pegawai
                                            echo "<tr class='table-light fw-bold'>";
                                            echo "<td class='text-start'>Jumlah</td>";
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<td class='text-end'>" . number_format($t->total_gaji, 0, ',', '.') . "</td>";
                                            }
                                            echo "<td class='text-end fw-bold'>" . number_format($t->total_gaji * 12, 0, ',', '.') . "</td></tr>";

                                        endforeach;

                                        // Subtotal bagian terakhir
                                        if ($current_bagian != '') {
                                            echo "<tr class='table-warning fw-bold'>";
                                            echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                            $subtotal_tahun = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                                $subtotal_tahun += $subtotal_bagian[$i];
                                            }
                                            echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td>";
                                            echo "</tr>";

                                            // Tambah ke total keseluruhan
                                            for ($i = 1; $i <= 12; $i++) {
                                                $grand_total[$i] += $subtotal_bagian[$i];
                                            }
                                            $grand_total_tahunan += $subtotal_tahun;
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