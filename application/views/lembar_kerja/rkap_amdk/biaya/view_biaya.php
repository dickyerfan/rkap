<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/biaya') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/biaya') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/biaya/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <!-- <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/biaya/generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate ke Laba Rugi</button> </a>
                            </div> -->
                            <div class="navbar-nav">
                                <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                    Generate ke Arus Kas
                                </button>
                            </div>
                            <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/biaya/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Biaya</button> </a>
                            </div>
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
                                <?php
                                $map_bulan = [
                                    1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
                                    5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
                                    9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
                                ];

                                // kelompokkan berdasarkan parent kode
                                $grouped = [];
                                foreach ($biaya as $r) {
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

                                // ambil nama parent dari tabel no_per jika perlu, sementara kita ambil prefix
                                ?>
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <th rowspan="2">U R A I A N</th>
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
                                                ->row('name') ?? 'Kelompok ' . $parent;
                                        ?>
                                            <!-- Header parent -->
                                            <tr class="fw-bold table-secondary">
                                                <td><?= $parent ?></td>
                                                <td colspan="15"><?= strtoupper($parent_name) ?></td>
                                            </tr>

                                            <!-- Children -->
                                            <?php foreach ($data_parent['children'] as $child) : ?>
                                                <tr>
                                                    <td><?= $child['kode'] ?></td>
                                                    <td><?= $child['name'] ?></td>
                                                    <td><?= $child['uraian'] ?></td>
                                                    <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                        <td class="text-end"><?= number_format($child[$nama_bulan], 0, ',', '.') ?></td>
                                                    <?php endforeach; ?>
                                                    <td class="text-end fw-bold"><?= number_format($child['total_tahun'], 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                            <!-- Subtotal per parent -->
                                            <tr class="fw-bold bg-light">
                                                <td colspan="3" class="text-start">JUMLAH <?= strtoupper($parent_name) ?></td>
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
                                            // akumulasi total seluruh AMDK
                                            foreach ($map_bulan as $b => $nama_bulan) {
                                                $total_bulan[$b] += $data_parent['subtotal'][$nama_bulan];
                                            }
                                            $total_semua += $data_parent['subtotal']['total_tahun'];
                                        endforeach;
                                        ?>

                                        <!-- TOTAL AKHIR -->
                                        <tr class="fw-bold table-primary">
                                            <td colspan="3" class="text-start">TOTAL BIAYA AMDK</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                        </tr>
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
                Pastikan semua data <b>Biaya AMDK</b> sudah <b>final</b> sebelum melakukan generate.
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
                    // Redirect ke controller generate
                    window.location.href = "<?= base_url('lembar_kerja/rkap_amdk/biaya/generate') ?>";
                }
            });
        });
    </script>