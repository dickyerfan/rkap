<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/pendapatan_luar_usaha/tambah') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Input/Update Data</button> </a>
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
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <?php
                                    $groups = $groups ?? [];
                                    $group_order = $group_order ?? [];
                                    $grand_totals = $grand_totals ?? array_fill(1, 12, 0);
                                    $grand_sum = $grand_sum ?? 0;

                                    $bulan_list = [
                                        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                                        7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                                    ];
                                    ?>
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:100px;">NO</th>
                                            <th>URAIAN</th>
                                            <?php foreach ($bulan_list as $b) : ?>
                                                <th class="text-center"><?= $b ?></th>
                                            <?php endforeach; ?>
                                            <th class="text-center">JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($group_order)) : ?>
                                            <tr>
                                                <td colspan="<?= count($bulan_list) + 2 ?>" class="text-center">Tidak ada akun 88.x</td>
                                            </tr>
                                        <?php else : ?>

                                            <?php foreach ($group_order as $grp) :
                                                $g = $groups[$grp];
                                                // header (88.01.00) row
                                            ?>
                                                <?php if (!empty($g['header'])) : ?>
                                                    <tr class="fw-bold">
                                                        <td><?= $g['header']['kode'] ?></td>
                                                        <td><?= $g['header']['name'] ?></td>
                                                        <?php for ($m = 1; $m <= 12; $m++) :
                                                            $val = $g['header']['bulan'][$m] ?? 0;
                                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                        ?>
                                                            <td class="text-end"><?= $show ?></td>
                                                        <?php endfor; ?>
                                                        <td class="text-end"><?= ($g['header']['total'] == 0) ? '-' : number_format($g['header']['total'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php else : ?>
                                                    <tr class="fw-bold">
                                                        <td><?= $g['group_parent_code'] ?></td>
                                                        <td><?= $g['group_label'] ?></td>
                                                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                            <td class="text-end">-</td>
                                                        <?php endfor; ?>
                                                        <td class="text-end">-</td>
                                                    </tr>
                                                <?php endif; ?>

                                                <!-- parents (level-3): tampilkan SUBTOTAL parent di baris parent (di atas anak-anak) -->
                                                <?php foreach ($g['parents'] as $parent) : ?>
                                                    <tr class="table-secondary fw-bold">
                                                        <td><?= $parent['kode'] ?></td>
                                                        <td><?= $parent['name'] ?></td>
                                                        <?php for ($m = 1; $m <= 12; $m++) :
                                                            $val = $parent['bulan'][$m] ?? 0;
                                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                        ?>
                                                            <td class="text-end"><?= $show ?></td>
                                                        <?php endfor; ?>
                                                        <td class="text-end"><?= ($parent['total'] == 0) ? '-' : number_format($parent['total'], 0, ',', '.') ?></td>
                                                    </tr>

                                                    <!-- children (level-4) : tampilkan hanya untuk grup selain 88.02 -->
                                                    <?php if ($grp !== '88.02') : ?>
                                                        <?php foreach ($parent['children'] as $child) : ?>
                                                            <tr>
                                                                <td><?= $child['kode'] ?></td>
                                                                <td><?= $child['name'] ?></td>
                                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                                    $val = $child['bulan'][$m] ?? 0;
                                                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                                ?>
                                                                    <td class="text-end"><?= $show ?></td>
                                                                <?php endfor; ?>
                                                                <td class="text-end"><?= ($child['total'] == 0) ? '-' : number_format($child['total'], 0, ',', '.') ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>

                                                <!-- leftovers (items in group not belonging to a parent3) -->
                                                <?php foreach ($g['leftovers'] as $ld) : ?>
                                                    <tr>
                                                        <td><?= $ld['kode'] ?></td>
                                                        <td><?= $ld['name'] ?></td>
                                                        <?php for ($m = 1; $m <= 12; $m++) :
                                                            $val = $ld['bulan'][$m] ?? 0;
                                                            $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                        ?>
                                                            <td class="text-end"><?= $show ?></td>
                                                        <?php endfor; ?>
                                                        <td class="text-end"><?= ($ld['total'] == 0) ? '-' : number_format($ld['total'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <!-- subtotal group -->
                                                <tr class="table-info fw-bold">
                                                    <td></td>
                                                    <td><?= ($grp === '88.01') ? 'Jumlah Pendapatan Lain2' : (($grp === '88.02') ? 'Jumlah Pendapatan AMDK' : 'Jumlah ' . $grp) ?></td>
                                                    <?php for ($m = 1; $m <= 12; $m++) :
                                                        $val = $g['totals'][$m] ?? 0;
                                                        $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                    ?>
                                                        <td class="text-end"><?= $show ?></td>
                                                    <?php endfor; ?>
                                                    <td class="text-end"><?= ($g['total_sum'] == 0) ? '-' : number_format($g['total_sum'], 0, ',', '.') ?></td>
                                                </tr>

                                            <?php endforeach; ?>

                                            <!-- GRAND TOTAL -->
                                            <tr class="table-dark text-white fw-bold">
                                                <td></td>
                                                <td>Jumlah total pendapatan diluar usaha</td>
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $val = $grand_totals[$m] ?? 0;
                                                    $show = ($val == 0) ? '-' : number_format($val, 0, ',', '.');
                                                ?>
                                                    <td class="text-end"><?= $show ?></td>
                                                <?php endfor; ?>
                                                <td class="text-end"><?= ($grand_sum == 0) ? '-' : number_format($grand_sum, 0, ',', '.') ?></td>
                                            </tr>

                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>