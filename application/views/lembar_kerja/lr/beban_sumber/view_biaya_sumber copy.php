<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/beban_sumber') ?>" method="get">
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
                                <select name="upk" id="upk" class="form-control mr-2">
                                    <option value="">Konsolidasi</option>
                                    <option value="01" <?= ($this->input->get('upk') == '01') ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="02" <?= ($this->input->get('upk') == '02') ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="03" <?= ($this->input->get('upk') == '03') ? 'selected' : '' ?>>Maesan</option>
                                    <option value="04" <?= ($this->input->get('upk') == '04') ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="05" <?= ($this->input->get('upk') == '05') ? 'selected' : '' ?>>Tapen</option>
                                    <option value="06" <?= ($this->input->get('upk') == '06') ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="07" <?= ($this->input->get('upk') == '07') ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="08" <?= ($this->input->get('upk') == '08') ? 'selected' : '' ?>>Wringin</option>
                                    <option value="09" <?= ($this->input->get('upk') == '09') ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="11" <?= ($this->input->get('upk') == '11') ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="12" <?= ($this->input->get('upk') == '12') ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="13" <?= ($this->input->get('upk') == '13') ? 'selected' : '' ?>>AMDK</option>
                                    <option value="14" <?= ($this->input->get('upk') == '14') ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="15" <?= ($this->input->get('upk') == '15') ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="16" <?= ($this->input->get('upk') == '16') ? 'selected' : '' ?>>Klabang</option>
                                    <option value="22" <?= ($this->input->get('upk') == '22') ? 'selected' : '' ?>>Sukosari 2</option>
                                    <option value="23" <?= ($this->input->get('upk') == '23') ? 'selected' : '' ?>>Umum</option>
                                    <option value="24" <?= ($this->input->get('upk') == '24') ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="25" <?= ($this->input->get('upk') == '25') ? 'selected' : '' ?>>Langganan</option>
                                    <option value="26" <?= ($this->input->get('upk') == '26') ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="27" <?= ($this->input->get('upk') == '27') ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="28" <?= ($this->input->get('upk') == '28') ? 'selected' : '' ?>>S P I</option>

                                </select>
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_sumber') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/beban_sumber/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_sumber/generate') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Generate ke Cetet</button> </a>
                            </div>
                            <div class="navbar-nav">
                                <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_sumber/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input Biaya</button> </a>
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
                                            <th rowspan="2">ACTION</th>
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
                                                <td colspan="16"><?= strtoupper($parent_name) ?></td>
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
                                                    <td class="text-center">
                                                        <!-- <a href="<?= base_url('lembar_kerja/lr/beban_sumber/edit/' . $child['no_per_id']) ?>?upk=<?= $child['cabang_id'] ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a> -->
                                                        <?php
                                                        $tahun_rkap = isset($tahun) ? (int)$tahun : (int)date('Y') + 1;
                                                        $tahun_boleh_edit = (int)date('Y') + 1;
                                                        $tipe_user = $this->session->userdata('tipe');
                                                        $status_update = isset($child['status_update']) ? (int)$child['status_update'] : 0;

                                                        // Hanya Admin, hanya tahun RKAP aktif (tahun depan), dan hanya jika status_update = 0
                                                        if ($tipe_user === 'admin' && $tahun_rkap === $tahun_boleh_edit && $status_update === 0) : ?>
                                                            <a href="<?= base_url('lembar_kerja/lr/beban_sumber/edit/' . $child['no_per_id']) ?>?upk=<?= $child['cabang_id'] ?>">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
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
                                                <td></td>
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
                                            <td colspan="3" class="text-start">TOTAL BIAYA</td>
                                            <?php foreach ($map_bulan as $b => $nama_bulan) : ?>
                                                <td class="text-end"><?= number_format($total_bulan[$b], 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end"><?= number_format($total_semua, 0, ',', '.') ?></td>
                                            <td></td>
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