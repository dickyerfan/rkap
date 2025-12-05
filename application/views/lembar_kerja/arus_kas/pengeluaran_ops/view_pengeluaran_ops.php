<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <button id="btnGenerate" class="neumorphic-button me-2" style="font-size: 0.8rem; color:black;">
                                        Generate ke Arus Kas
                                    </button>
                                    <button id="btnGenerate2" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate HPP ke Arus Kas
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
                            <h5>Biaya Sumber</h5>
                            <div class="table-responsive">
                                <?php
                                $map_bulan = [
                                    1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                    5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                    9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                                ];

                                // kelompokkan berdasarkan parent kode
                                $grouped = [];
                                foreach ($sumber as $r) {
                                    // ambil parent prefix 3 segmen, misalnya "98.02.04"
                                    $parts = explode('.', $r['kode']);
                                    $parent = implode('.', array_slice($parts, 0, 3));
                                    $grouped[$parent]['children'][] = $r;

                                    // total per parent
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                            $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                        }
                                        $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                                    }
                                    $grouped[$parent]['subtotal']['total_tahun'] =
                                        ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                                }
                                ?>
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <!-- <th rowspan="2">U R A I A N</th> -->
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
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
                                        $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                        $total_semua = 0;

                                        foreach ($grouped as $parent => $data_parent) :
                                            // ambil nama parent
                                            $parent_name = $this->db
                                                ->select('name')
                                                ->where('kode', $parent)
                                                ->get('no_per')
                                                ->row('name') ?? ' ' . $parent;
                                        ?>
                                            <!-- Subtotal per parent -->
                                            <tr class="fw-bold bg-light">
                                                <td><?= $parent ?></td>
                                                <td><?= strtoupper($parent_name) ?></td>
                                                <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                                <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                    <td class="text-end">
                                                        <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-end">
                                                    <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php
                                            foreach ($map_bulan as $b => $nama_bulan) {
                                                $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                            }
                                            $total_semua += $data_parent['subtotal']['total_tahun'];
                                        endforeach;
                                        ?>

                                        <!-- TOTAL AKHIR -->
                                        <tr class="fw-bold table-primary">
                                            <td colspan="2" class="text-start">TOTAL BIAYA SUMBER</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>Biaya Pengolahan</h5>
                            <div class="table-responsive">
                                <?php
                                $map_bulan = [
                                    1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                    5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                    9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                                ];

                                // kelompokkan berdasarkan parent kode
                                $grouped = [];
                                foreach ($pengolahan as $r) {
                                    // ambil parent prefix 3 segmen, misalnya "98.02.04"
                                    $parts = explode('.', $r['kode']);
                                    $parent = implode('.', array_slice($parts, 0, 3));
                                    $grouped[$parent]['children'][] = $r;

                                    // total per parent
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                            $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                        }
                                        $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                                    }
                                    $grouped[$parent]['subtotal']['total_tahun'] =
                                        ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                                }
                                ?>
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <!-- <th rowspan="2">U R A I A N</th> -->
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
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
                                        $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                        $total_semua = 0;

                                        foreach ($grouped as $parent => $data_parent) :
                                            // ambil nama parent
                                            $parent_name = $this->db
                                                ->select('name')
                                                ->where('kode', $parent)
                                                ->get('no_per')
                                                ->row('name') ?? ' ' . $parent;
                                        ?>
                                            <!-- Subtotal per parent -->
                                            <tr class="fw-bold bg-light">
                                                <td><?= $parent ?></td>
                                                <td><?= strtoupper($parent_name) ?></td>
                                                <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                                <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                    <td class="text-end">
                                                        <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-end">
                                                    <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php
                                            foreach ($map_bulan as $b => $nama_bulan) {
                                                $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                            }
                                            $total_semua += $data_parent['subtotal']['total_tahun'];
                                        endforeach;
                                        ?>

                                        <!-- TOTAL AKHIR -->
                                        <tr class="fw-bold table-primary">
                                            <td colspan="2" class="text-start">TOTAL BIAYA PENGOLAHAN</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>Biaya Transmisi & Distribusi</h5>
                            <div class="table-responsive">
                                <?php
                                $map_bulan = [
                                    1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                    5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                    9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                                ];

                                // kelompokkan berdasarkan parent kode
                                $grouped = [];
                                foreach ($trandis as $r) {
                                    // ambil parent prefix 3 segmen, misalnya "98.02.04"
                                    $parts = explode('.', $r['kode']);
                                    $parent = implode('.', array_slice($parts, 0, 3));
                                    $grouped[$parent]['children'][] = $r;

                                    // total per parent
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                            $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                        }
                                        $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                                    }
                                    $grouped[$parent]['subtotal']['total_tahun'] =
                                        ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                                }
                                ?>
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <!-- <th rowspan="2">U R A I A N</th> -->
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
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
                                        $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                        $total_semua = 0;

                                        foreach ($grouped as $parent => $data_parent) :
                                            // ambil nama parent
                                            $parent_name = $this->db
                                                ->select('name')
                                                ->where('kode', $parent)
                                                ->get('no_per')
                                                ->row('name') ?? ' ' . $parent;
                                        ?>
                                            <!-- Subtotal per parent -->
                                            <tr class="fw-bold bg-light">
                                                <td><?= $parent ?></td>
                                                <td><?= strtoupper($parent_name) ?></td>
                                                <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                                <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                    <td class="text-end">
                                                        <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-end">
                                                    <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php
                                            foreach ($map_bulan as $b => $nama_bulan) {
                                                $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                            }
                                            $total_semua += $data_parent['subtotal']['total_tahun'];
                                        endforeach;
                                        ?>

                                        <!-- TOTAL AKHIR -->
                                        <tr class="fw-bold table-primary">
                                            <td colspan="2" class="text-start">TOTAL BIAYA TRANSMISI & DISTRIBUSI</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>Biaya Umum & Administrasi</h5>
                            <div class="table-responsive">
                                <?php
                                $map_bulan = [
                                    1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                    5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                    9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                                ];

                                // kelompokkan berdasarkan parent kode
                                $grouped = [];
                                foreach ($umum as $r) {
                                    // ambil parent prefix 3 segmen, misalnya "98.02.04"
                                    $parts = explode('.', $r['kode']);
                                    $parent = implode('.', array_slice($parts, 0, 3));
                                    $grouped[$parent]['children'][] = $r;

                                    // total per parent
                                    foreach ($map_bulan as $b => $nama_bulan) {
                                        if (!isset($grouped[$parent]['subtotal'][$nama_bulan])) {
                                            $grouped[$parent]['subtotal'][$nama_bulan] = 0;
                                        }
                                        $grouped[$parent]['subtotal'][$nama_bulan] += $r[$nama_bulan];
                                    }
                                    $grouped[$parent]['subtotal']['total_tahun'] =
                                        ($grouped[$parent]['subtotal']['total_tahun'] ?? 0) + $r['total_tahun'];
                                }
                                ?>
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <!-- <th rowspan="2">U R A I A N</th> -->
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
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
                                        $total_bulan = array_fill_keys(array_keys($map_bulan), 0);
                                        $total_semua = 0;

                                        foreach ($grouped as $parent => $data_parent) :
                                            // ambil nama parent
                                            $parent_name = $this->db
                                                ->select('name')
                                                ->where('kode', $parent)
                                                ->get('no_per')
                                                ->row('name') ?? ' ' . $parent;
                                        ?>
                                            <!-- Subtotal per parent -->
                                            <tr class="fw-bold bg-light">
                                                <td><?= $parent ?></td>
                                                <td><?= strtoupper($parent_name) ?></td>
                                                <!-- <td class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td> -->
                                                <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                    <td class="text-end">
                                                        <?= number_format($data_parent['subtotal'][$nama_bulan], 0, ',', '.') ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-end">
                                                    <?= number_format($data_parent['subtotal']['total_tahun'], 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php
                                            foreach ($map_bulan as $b => $nama_bulan) {
                                                $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                            }
                                            $total_semua += $data_parent['subtotal']['total_tahun'];
                                        endforeach;
                                        ?>

                                        <!-- TOTAL AKHIR -->
                                        <tr class="fw-bold table-primary">
                                            <td colspan="2" class="text-start">TOTAL BIAYA UMUM & ADMINISTRASI</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>Beban HPP Sambungan Baru</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example4">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2" rowspan="2">PERKIRAAN</th>
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <!-- <th>KODE</th> -->
                                            <!-- <th colspan="2">NAMA</th> -->
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
                                        // ambil variabel upk dari controller
                                        $upk = isset($upk) ? $upk : 'all';

                                        // 1. Inisialisasi Grand Total
                                        $grand_total = [
                                            'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                            'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                        ];
                                        ?>
                                        <?php foreach ($hpp as $parent) : ?>
                                            <?php if ($upk != 'all' && $upk != '') : ?>
                                                <!-- TAMPILKAN CHILDREN JIKA UPK DIPILIH -->
                                                <?php if (!empty($parent['children'])) : ?>
                                                    <?php foreach ($parent['children'] as $c) : ?>
                                                        <tr>
                                                            <!-- <td><?= $c['kode']; ?></td> -->
                                                            <td><?= $c['uraian']; ?></td>
                                                            <td class="text-end"><?= number_format($c['jan'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['feb'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['mar'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['apr'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['mei'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['jun'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['jul'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['agu'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['sep'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['okt'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['nov'], 0, ',', '.'); ?></td>
                                                            <td class="text-end"><?= number_format($c['des'], 0, ',', '.'); ?></td>
                                                            <td class="text-end fw-bold"><?= number_format($c['total_tahun'], 0, ',', '.'); ?></td>
                                                            <td class="text-center">
                                                                <!-- <a href="<?= base_url('lembar_kerja/lr/beban_trandis/edit/' . urlencode(base64_encode($c['unique_key']))) ?>"><i class="fas fa-edit"></i></a> -->
                                                                <a href="<?= base_url('lembar_kerja/lr/beban_trandis/edit_hpp/' . urlencode(base64_encode($c['kode'] . '||' . $c['uraian']))) ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php
                                            // hitung subtotal tetap jalan di dua kondisi (karena dipakai juga untuk grand total)
                                            $sub = [
                                                'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                                'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                            ];

                                            if (!empty($parent['children'])) {
                                                foreach ($parent['children'] as $c) {
                                                    foreach ($sub as $k => $_) {
                                                        if (isset($c[$k])) {
                                                            $sub[$k] += $c[$k];
                                                        }
                                                    }
                                                }
                                            }
                                            if (isset($c['total_tahun'])) {
                                                $sub['jumlah'] += $c['total_tahun'];
                                            }

                                            // 2. Tambahkan Subtotal ke Grand Total
                                            foreach ($grand_total as $k => $_) {
                                                if (isset($sub[$k])) {
                                                    $grand_total[$k] += $sub[$k];
                                                }
                                            }
                                            ?>

                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="fw-bold table-primary">
                                        <tr>
                                            <td colspan="2">JUMLAH BEBAN HPP SAMBUNGAN BARU</td>
                                            <td class="text-end"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
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
                Pastikan semua data <b>Pengeluaran Operasional</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN ARUS KAS</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops/generate') ?>";
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
                Pastikan semua data <b>Biaya HPP Sambungan Baru</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN ARUS KAS</b>.
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
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/pengeluaran_ops/generate_hpp') ?>";
                }
            });
        });
    </script>