<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih UPK & Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/target_upk') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <select name="id_upk" class="form-select select2">
                                    <option value="">Semua UPK</option>
                                    <?php foreach ($upk as $u) : ?>
                                        <option value="<?= $u->id_upk ?>" <?= ($id_upk == $u->id_upk) ? 'selected' : ''; ?>>
                                            <?= $u->nama_upk ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width:100px; margin-left:10px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i <= $mulai + 10; $i++) :
                                    ?>
                                        <option value="<?= $i ?>" <?= ($tahun_rkap == $i) ? 'selected' : ''; ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/target_upk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= site_url('lembar_kerja/lr/target_upk/export_pdf') . '?tahun_rkap=' . $tahun_rkap . '&id_upk=' . $id_upk; ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                </div>
                <?php
                $bulan_list = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];

                $rekening_map  = [];
                foreach ($rekening as $r)  $rekening_map[(int)$r->bulan]  = $r->jumlah_rekening;
                $pemakaian_map = [];
                foreach ($pemakaian as $r) $pemakaian_map[(int)$r->bulan] = $r->pemakaian;
                $pendapatan_map = [];
                foreach ($pendapatan as $r) $pendapatan_map[(int)$r->bulan] = $r->pendapatan;
                ?>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title; ?></h5>
                            <h5><?= $judul_upk ?></h5>
                        </div>
                    </div>

                    <!-- Tabel 1: Target Pelanggan -->
                    <div class="row justify-content-center mt-2">
                        <div class="col-lg-12">
                            <p class="fw-bold mb-1">A. Target Pelanggan</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <?php foreach ($bulan_list as $b) : ?><th><?= $b ?></th><?php endforeach; ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $indikator_list = [
                                            'sr_baru'     => 'SR Baru',
                                            'penutupan'   => 'Penutupan',
                                            'pencabutan'  => 'Pencabutan',
                                            'pembukaan'   => 'Pembukaan',
                                            'tera_meter'  => 'Tera Meter',
                                            'ganti_meter' => 'Ganti Meter',
                                            'efi_tagih'   => 'Efisiensi Penagihan'
                                        ];
                                        $no = 1;
                                        foreach ($indikator_list as $key => $label) :
                                            $total = 0;
                                            $jumlah_bulan = 0;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $label ?></td>
                                                <?php foreach ($bulan_list as $i => $b) :
                                                    $nilai = 0;
                                                    foreach ($tampil as $row) {
                                                        if ($row->bulan == $i) {
                                                            $nilai = $row->$key;
                                                            break;
                                                        }
                                                    }
                                                    $total += $nilai;
                                                    if ($nilai != 0) $jumlah_bulan++;
                                                ?>
                                                    <td class="text-end">
                                                        <?= ($key == 'efi_tagih') ? number_format($nilai, 2, ',', '.') : number_format($nilai) ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td class="text-end fw-bold">
                                                    <?php if ($key == 'efi_tagih') :
                                                        echo number_format(($jumlah_bulan > 0) ? $total / $jumlah_bulan : 0, 2, ',', '.');
                                                    else :
                                                        echo number_format($total);
                                                    endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel 2: Target Kinerja Tambahan -->
                    <div class="row justify-content-center mt-3">
                        <div class="col-lg-12">
                            <p class="fw-bold mb-1">B. Target Pendapatan</p>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <?php foreach ($bulan_list as $b) : ?><th><?= $b ?></th><?php endforeach; ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_rek = 0;
                                        $total_pend = 0;
                                        $total_pakai = 0;
                                        foreach ($bulan_list as $i => $b) {
                                            $total_rek   += $rekening_map[$i]  ?? 0;
                                            $total_pend  += $pendapatan_map[$i] ?? 0;
                                            $total_pakai += $pemakaian_map[$i] ?? 0;
                                        }
                                        $avg_rek = $total_rek / 12;
                                        $pola_total = ($avg_rek > 0) ? $total_pakai / $avg_rek : 0;
                                        ?>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Jumlah Rekening</td>
                                            <?php foreach ($bulan_list as $i => $b) : ?>
                                                <td class="text-end"><?= number_format($rekening_map[$i] ?? 0) ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end fw-bold"><?= number_format($total_rek) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Pendapatan (Rp)</td>
                                            <?php foreach ($bulan_list as $i => $b) : ?>
                                                <td class="text-end"><?= number_format($pendapatan_map[$i] ?? 0, 0, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end fw-bold"><?= number_format($total_pend, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>Pemakaian (m³)</td>
                                            <?php foreach ($bulan_list as $i => $b) : ?>
                                                <td class="text-end"><?= number_format($pemakaian_map[$i] ?? 0, 2, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end fw-bold"><?= number_format($total_pakai, 2, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Pola Konsumsi (m³/rek)</td>
                                            <?php foreach ($bulan_list as $i => $b) :
                                                $rek   = $rekening_map[$i] ?? 0;
                                                $pakai = $pemakaian_map[$i] ?? 0;
                                                $pola  = ($rek > 0) ? $pakai / $rek : 0;
                                            ?>
                                                <td class="text-end"><?= number_format($pola, 2, ',', '.') ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-end fw-bold"><?= number_format($pola_total, 2, ',', '.') ?></td>
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