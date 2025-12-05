<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/produksi_air/data_sumber') ?>" method="get">
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
                                <select name="upk" class="form-select select2" style="width: 150px;">
                                    <option value="">KONSOLIDASI</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/produksi_air/data_sumber') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/produksi_air/data_sumber/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/produksi_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> <i class="fas fa-arrow-left"></i> Kembali</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/produksi_air/input') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> <i class="fas fa-plus"></i> Input Data</button> </a>
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
                            <table class="table table-sm table-bordered" style="font-size: 1rem;" id="example3">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">U P K</th>
                                        <th class="text-center">URAIAN</th>
                                        <th class="text-center">RUPIAH</th>
                                        <th class="text-center"> ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($sumber)) : ?>
                                        <?php
                                        $no = 1;
                                        foreach ($sumber as $row) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['nama_upk'] ? $row['nama_upk'] : 'KONSOLIDASI'; ?></td>
                                                <td><?= $row['uraian']; ?></td>
                                                <td class="text-end"><?= number_format($row['nilai'], 0, ',', '.'); ?></td>
                                                <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                    <?php
                                                    $nama_pengguna  = $this->session->userdata('nama_pengguna');
                                                    $level = $this->session->userdata('level');
                                                    if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('lembar_kerja/lr/produksi_air/edit_sumber/' . $row['id_sb']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                                        </td>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    <?php endif; ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>