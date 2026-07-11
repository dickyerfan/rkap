<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih UPK & Tahun</a>
                        <form action="<?= base_url('admin/proyeksi_upk') ?>" method="get">
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
                            <a class="nav-link fw-bold" href="<?= base_url('admin/proyeksi_upk') ?>" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"> Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= site_url('admin/proyeksi_upk/export_pdf') . '?tahun_rkap=' . $tahun_rkap . '&id_upk=' . $id_upk; ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <?php
                $bulan = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];
                ?>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title; ?></h5>
                            <h5><?= $judul_upk ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 1rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Indikator</th>
                                        <?php foreach ($bulan as $b) : ?>
                                            <th><?= $b ?></th>
                                        <?php endforeach; ?>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $indikator_list = [
                                        'sr_baru' => 'SR Baru',
                                        'penutupan' => 'Penutupan',
                                        'pencabutan' => 'Pencabutan',
                                        'pembukaan' => 'Pembukaan',
                                        'tera_meter' => 'Tera Meter',
                                        'ganti_meter' => 'Ganti Meter',
                                        'efi_tagih' => 'Efisiensi Penagihan'
                                    ];
                                    $no = 1;
                                    ?>
                                    <?php foreach ($indikator_list as $key => $label) : ?>
                                        <?php
                                        $total = 0;
                                        $jumlah_bulan = 0;
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $label ?></td>
                                            <?php foreach ($bulan as $i => $b) : ?>
                                                <?php
                                                $nilai = 0;
                                                foreach ($tampil as $row) {
                                                    if ($row->bulan == $i) {
                                                        $nilai = $row->$key;
                                                        break;
                                                    }
                                                }
                                                $total += $nilai;
                                                if ($nilai != 0) {
                                                    $jumlah_bulan++;
                                                }
                                                ?>
                                                <td class="text-end">
                                                    <?php if ($key == 'efi_tagih') : ?>
                                                        <?= number_format($nilai, 2, ',', '.') ?>
                                                    <?php else : ?>
                                                        <?= number_format($nilai) ?>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class="text-end fw-bold">
                                                <?php
                                                if ($key == 'efi_tagih') {
                                                    $rata = ($jumlah_bulan > 0) ? $total / $jumlah_bulan : 0;
                                                    echo number_format($rata, 2, ',', '.');
                                                } else {
                                                    echo number_format($total);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>