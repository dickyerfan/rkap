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
                                    <option value="bondowoso" <?= $upk == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
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
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/rekap') ?>" style="font-size: 0.8rem; color:black;">
                                <button class="neumorphic-button"> Rekap</button>
                            </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/pegawai') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Daftar Pegawai</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <div class="navbar-nav me-2">
                                <?php
                                $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                $level = $this->session->userdata('level');
                                if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>

                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate ke Biaya
                                    </button>

                            </div>
                            <div class="navbar-nav">
                                <button id="btnGenerate2" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                    Generate ke Biaya AMDK
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('nama_pengguna') == 'Personalia' || $this->session->userdata('tipe') == 'admin') : ?>
                        <?php
                        $nama_pengguna  = $this->session->userdata('nama_pengguna');
                        $level = $this->session->userdata('level');
                        if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                            <div class="navbar-nav">
                                <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/generate_tahunan?tahun_rkap=' . $tahun); ?>" class="nav-link fw-bold" onclick="return confirm('Yakin ingin generate otomatis data tenaga kerja tahun <?= $tahun; ?>?')">
                                    <button class="neumorphic-button"> Download Daftar Gaji </button>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="navbar-nav">
                        <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                    </div>

                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <!-- Form Kenaikan Gaji -->
                <?php if ($this->session->userdata('nama_pengguna') == 'Personalia' || $this->session->userdata('tipe') == 'admin') : ?>
                    <?php
                    $nama_pengguna  = $this->session->userdata('nama_pengguna');
                    $level = $this->session->userdata('level');
                    if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                        <div class="container-fluid mt-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="card-title fw-bold mb-3">
                                        <i class="fa-solid fa-arrow-trend-up"></i> Form Kenaikan Gaji Pegawai
                                    </h6>
                                    <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/kenaikan_gaji') ?>" method="post" class="row g-2 align-items-center">
                                        <div class="col-auto">
                                            <label for="bulan_naik" class="col-form-label fw-bold">Bulan Naik:</label>
                                        </div>
                                        <div class="col-auto">
                                            <select name="bulan_naik" id="bulan_naik" class="form-select">
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <option value="<?= $i; ?>"><?= date('F', mktime(0, 0, 0, $i, 1)); ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label for="persentase_naik" class="col-form-label fw-bold">% Naik:</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" name="persentase_naik" id="persentase_naik" placeholder="0" class="form-control" step="1" required style="width: 100px;">
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="neumorphic-button">
                                                <i class="fa-solid fa-check"></i> Terapkan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
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
                                        $subtotal_bagian = array_fill(1, 12, 0); // Subtotal bulanan per BAGIAN
                                        $grand_total = array_fill(1, 12, 0); // Grand Total bulanan KESELURUHAN
                                        $grand_total_tahunan = 0;

                                        // Variabel untuk Total Kategori
                                        $kategori_total = [
                                            'administrasi' => [
                                                'gaji_pokok' => array_fill(1, 12, 0),
                                                'tunjangan' => array_fill(1, 12, 0),
                                                'bpjs_kes' => array_fill(1, 12, 0),
                                                'bpjs_tk' => array_fill(1, 12, 0),
                                                'dapenmapamsi' => array_fill(1, 12, 0),
                                                'total_gaji_bulanan' => array_fill(1, 12, 0),
                                            ],
                                            'teknik' => [
                                                'gaji_pokok' => array_fill(1, 12, 0),
                                                'tunjangan' => array_fill(1, 12, 0),
                                                'bpjs_kes' => array_fill(1, 12, 0),
                                                'bpjs_tk' => array_fill(1, 12, 0),
                                                'dapenmapamsi' => array_fill(1, 12, 0),
                                                'total_gaji_bulanan' => array_fill(1, 12, 0),
                                            ],
                                        ];

                                        // Pemetaan bulan ke field
                                        $bulan_fields = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'];

                                        foreach ($naker as $t) :
                                            $kategori_key = strtolower($t->kategori); // 'administrasi' atau 'teknik'
                                            if (!isset($kategori_total[$kategori_key])) continue; // Lewati jika kategori tidak dikenali

                                            // --- Logika Subtotal per Bagian (Sudah ada) ---
                                            if ($t->bagian != $current_bagian) {
                                                if ($current_bagian != '') {
                                                    echo "<tr class='table-warning fw-bold'>";
                                                    echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                                    $subtotal_tahun = 0;
                                                    for ($i = 1; $i <= 12; $i++) {
                                                        echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                                        $subtotal_tahun += $subtotal_bagian[$i];
                                                        $grand_total[$i] += $subtotal_bagian[$i]; // Tambahkan ke Grand Total
                                                    }
                                                    echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td>";
                                                    echo "</tr>";
                                                    $grand_total_tahunan += $subtotal_tahun;
                                                    $subtotal_bagian = array_fill(1, 12, 0);
                                                }
                                                echo "<tr class='table-secondary'><td colspan='14'><b>" . strtoupper($t->bagian) . "</b></td></tr>";
                                                $current_bagian = $t->bagian;
                                            }

                                            // Header nama pegawai
                                            echo "<tr><td colspan='14'><b>{$t->nama}</b> - <b>{$t->jabatan}</b> ( <b>{$t->kategori})</b>";

                                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                            $level = $this->session->userdata('level');
                                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) {
                                                echo "<a href='" . base_url('lembar_kerja/arus_kas/tenaga_kerja/edit/' . $t->id_pegawai) . "' 
                                                    class='btn btn-dark btn-sm float-end' style='text-decoration: none;'>
                                                    <i class='fa fa-edit'></i> Input Data Gaji
                                                    </a>";

                                                // echo "<a href='" . base_url('lembar_kerja/arus_kas/tenaga_kerja/hapus_setelah_pensiun/' . $t->id_pegawai) . "' 
                                                //     class='btn btn-dark btn-sm float-end me-2' style='text-decoration: none;'>
                                                //     <i class='fa fa-edit'></i> Hapus Setelah Pensiun
                                                //     </a>";
                                            }
                                            echo "</td></tr>";

                                            // Data tunjangan lengkap per pegawai
                                            $items = [
                                                'Gaji Pokok' => 'gaji',
                                                'Tunjangan Istri' => 'istri',
                                                'Tunjangan Anak' => 'anak',
                                                'Tunjangan Jabatan' => 'jabatan',
                                                'Tunjangan Transport' => 'transport',
                                                'Tunjangan Pangan' => 'pangan',
                                                'Uang Makan' => 'makan',
                                                'Tunjangan Perumahan' => 'perumahan',
                                                'BPJS Kesehatan' => 'bpjs_kes',
                                                'BPJS TK' => 'bpjs_tk',
                                                'Dapenmapamsi' => 'dapen',
                                            ];

                                            // Tampilkan setiap item
                                            foreach ($items as $label => $suffix) {
                                                echo "<tr><td>{$label}</td>";
                                                $total_tahun = 0;
                                                $is_tunjangan = in_array($label, ['Tunjangan Istri', 'Tunjangan Anak', 'Tunjangan Jabatan', 'Tunjangan Transport', 'Tunjangan Pangan', 'Uang Makan', 'Tunjangan Perumahan']);

                                                for ($i = 0; $i < 12; $i++) {
                                                    $field_name = $bulan_fields[$i] . '_' . $suffix;
                                                    $val = (float)$t->$field_name;

                                                    echo "<td class='text-end'>" . number_format($val, 0, ',', '.') . "</td>";

                                                    // Akumulasi subtotal bagian
                                                    $subtotal_bagian[$i + 1] += $val;
                                                    $total_tahun += $val;

                                                    // Akumulasi total kategori
                                                    if ($label == 'Gaji Pokok') {
                                                        $kategori_total[$kategori_key]['gaji_pokok'][$i + 1] += $val;
                                                    } elseif ($is_tunjangan) {
                                                        $kategori_total[$kategori_key]['tunjangan'][$i + 1] += $val;
                                                    } elseif ($label == 'BPJS Kesehatan') {
                                                        $kategori_total[$kategori_key]['bpjs_kes'][$i + 1] += $val;
                                                    } elseif ($label == 'BPJS TK') {
                                                        $kategori_total[$kategori_key]['bpjs_tk'][$i + 1] += $val;
                                                    } elseif ($label == 'Dapenmapamsi') {
                                                        $kategori_total[$kategori_key]['dapenmapamsi'][$i + 1] += $val;
                                                    }
                                                }
                                                echo "<td class='text-end fw-bold'>" . number_format($total_tahun, 0, ',', '.') . "</td></tr>";
                                            }

                                            // Total Gaji Pegawai
                                            echo "<tr class='table-light fw-bold'>";
                                            echo "<td>Jumlah</td>";
                                            $total_tahun_pegawai = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $field = $bulan_fields[$i - 1] . '_t_gaji';
                                                $val = (float)$t->$field;
                                                echo "<td class='text-end'>" . number_format($val, 0, ',', '.') . "</td>";
                                                $total_tahun_pegawai += $val;
                                                // Akumulasi Total Gaji Bulanan Kategori
                                                $kategori_total[$kategori_key]['total_gaji_bulanan'][$i] += $val;
                                            }
                                            echo "<td class='text-end fw-bold'>" . number_format($total_tahun_pegawai, 0, ',', '.') . "</td></tr>";

                                        endforeach;

                                        // Subtotal bagian terakhir
                                        if ($current_bagian != '') {
                                            echo "<tr class='table-warning fw-bold'>";
                                            echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                            $subtotal_tahun = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                                $subtotal_tahun += $subtotal_bagian[$i];
                                                $grand_total[$i] += $subtotal_bagian[$i]; // Tambahkan ke Grand Total
                                            }
                                            echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td></tr>";
                                            $grand_total_tahunan += $subtotal_tahun;
                                        }

                                        // ---------- Total Per Kategori dan Grand Total Keseluruhan ----------

                                        // Fungsi bantuan untuk mencetak baris total
                                        function print_total_row($label, $data_array, $is_grand_total = false, $class = 'table-info')
                                        {
                                            $class = $is_grand_total ? 'table-danger fw-bolder' : ($class . ' fw-bold');
                                            echo "<tr class='{$class}'>";
                                            echo "<td>{$label}</td>";
                                            $total_tahunan = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $val = (float)($data_array[$i] ?? 0);
                                                echo "<td class='text-end'>" . number_format($val, 0, ',', '.') . "</td>";
                                                $total_tahunan += $val;
                                            }
                                            echo "<td class='text-end'>" . number_format($total_tahunan, 0, ',', '.') . "</td></tr>";
                                        }

                                        echo "<tr><td colspan='14' class='table-light'>&nbsp;</td></tr>";

                                        // Total Kategori Administrasi
                                        echo "<tr class='table-primary'><td colspan='14'><b>TOTAL KATEGORI ADMINISTRASI</b></td></tr>";
                                        print_total_row("Total Gaji Pokok (Administrasi)", $kategori_total['administrasi']['gaji_pokok'], false, 'table-primary');
                                        print_total_row("Total Tunjangan (Administrasi)", $kategori_total['administrasi']['tunjangan'], false, 'table-primary');
                                        print_total_row("Total BPJS Kesehatan (Administrasi)", $kategori_total['administrasi']['bpjs_kes'], false, 'table-primary');
                                        print_total_row("Total BPJS TK (Administrasi)", $kategori_total['administrasi']['bpjs_tk'], false, 'table-primary');
                                        print_total_row("Total Dapenmapamsi (Administrasi)", $kategori_total['administrasi']['dapenmapamsi'], false, 'table-primary');
                                        print_total_row("TOTAL GAJI (ADMINISTRASI)", $kategori_total['administrasi']['total_gaji_bulanan'], false, 'table-info');

                                        echo "<tr><td colspan='14' class='table-light'>&nbsp;</td></tr>";

                                        // Total Kategori Teknik
                                        echo "<tr class='table-success'><td colspan='14'><b>TOTAL KATEGORI TEKNIK</b></td></tr>";
                                        print_total_row("Total Gaji Pokok (Teknik)", $kategori_total['teknik']['gaji_pokok'], false, 'table-success');
                                        print_total_row("Total Tunjangan (Teknik)", $kategori_total['teknik']['tunjangan'], false, 'table-success');
                                        print_total_row("Total BPJS Kesehatan (Teknik)", $kategori_total['teknik']['bpjs_kes'], false, 'table-success');
                                        print_total_row("Total BPJS TK (Teknik)", $kategori_total['teknik']['bpjs_tk'], false, 'table-success');
                                        print_total_row("Total Dapenmapamsi (Teknik)", $kategori_total['teknik']['dapenmapamsi'], false, 'table-success');
                                        print_total_row("TOTAL GAJI (TEKNIK)", $kategori_total['teknik']['total_gaji_bulanan'], false, 'table-info');

                                        echo "<tr><td colspan='14' class='table-light'>&nbsp;</td></tr>";

                                        // Grand Total Keseluruhan
                                        print_total_row("TOTAL KESELURUHAN", $grand_total, true);

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

    <script>
        document.getElementById('btnGenerate').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin Generate Data?',
                html: `
            <p style="font-size:18px; margin-top:10px;">
                Pastikan semua data <b>Tenaga Kerja</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>Biaya PDAM </b>
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
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/generate_biaya') ?>";
                }
            });
        });
    </script>
    <script>
        document.getElementById('btnGenerate2').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin Generate Data?',
                html: `
            <p style="font-size:18px; margin-top:10px;">
                Pastikan semua data <b>Tenaga Kerja</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>Biaya AMDK </b>
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
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/generate_biaya_amdk') ?>";
                }
            });
        });
    </script>