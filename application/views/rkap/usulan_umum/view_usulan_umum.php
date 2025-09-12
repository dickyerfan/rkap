<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) . ' ' .  date('Y') ?></a> -->
                    <!-- <a href="<?= base_url('rkap/usulan_umum/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->
                    <nav class="navbar navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Wilayah & Tahun</a>
                        <form action="<?= base_url('rkap/usulan_umum') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $bagian_upk = isset($_GET['bagian_upk']) ? $_GET['bagian_upk'] : '';
                                $tahun_rkap = isset($_GET['tahun_rkap']) ? $_GET['tahun_rkap'] : date('Y');
                                $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
                                ?>
                                <select name="bagian_upk" class="form-select select2" style="width: 170px; " aria-label="Default select example">
                                    <option value="">Pilih Bagian/UPK</option>
                                    <option value="pusat" <?= $bagian_upk == 'pusat' ? 'selected' : '' ?>>Pusat</option>
                                    <option value="bondowoso" <?= $bagian_upk == 'bondowoso' ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="sukosari1" <?= $bagian_upk == 'sukosari1' ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="maesan" <?= $bagian_upk == 'maesan' ? 'selected' : '' ?>>Maesan</option>
                                    <option value="tegalampel" <?= $bagian_upk == 'tegalampel' ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="tapen" <?= $bagian_upk == 'tapen' ? 'selected' : '' ?>>Tapen</option>
                                    <option value="prajekan" <?= $bagian_upk == 'prajekan' ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="tlogosari" <?= $bagian_upk == 'tlogosari' ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="wringin" <?= $bagian_upk == 'wringin' ? 'selected' : '' ?>>Wringin</option>
                                    <option value="curahdami" <?= $bagian_upk == 'curahdami' ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="tamanan" <?= $bagian_upk == 'tamanan' ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="tenggarang" <?= $bagian_upk == 'tenggarang' ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="tamankrocok" <?= $bagian_upk == 'tamankrocok' ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="wonosari" <?= $bagian_upk == 'wonosari' ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="klabang" <?= $bagian_upk == 'klabang' ? 'selected' : '' ?>>Klabang</option>
                                    <option value="sukosari2" <?= $bagian_upk == 'sukosari2' ? 'selected' : '' ?>>Sukosari 2</option>
                                    <option value="langganan" <?= $bagian_upk == 'langganan' ? 'selected' : '' ?>>Langganan</option>
                                    <option value="umum" <?= $bagian_upk == 'umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="keuangan" <?= $bagian_upk == 'keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                    <option value="perencanaan" <?= $bagian_upk == 'perencanaan' ? 'selected' : '' ?>>Perencanaan</option>
                                    <option value="pemeliharaan" <?= $bagian_upk == 'pemeliharaan' ? 'selected' : '' ?>>Pemeliharaan</option>
                                    <option value="spi" <?= $bagian_upk == 'spi' ? 'selected' : '' ?>>SPI</option>
                                    <option value="amdk" <?= $bagian_upk == 'amdk' ? 'selected' : '' ?>>A M D K</option>
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
                                <select name="kategori" class="form-select" style="width: 150px; margin-left:10px;">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Umum" <?= $kategori == 'Umum' ? 'selected' : '' ?>>Umum</option>
                                    <option value="Personalia" <?= $kategori == 'Personalia' ? 'selected' : '' ?>>Personalia</option>
                                    <option value="Administrasi" <?= $kategori == 'Administrasi' ? 'selected' : '' ?>>Administrasi</option>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('rkap/usulan_umum') ?>" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"> Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('rkap/usulan_umum/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('rkap/usulan_umum/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a>
                        </div>

                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  date('Y') + 1 ?></h5>
                            <h5><?= strtoupper($this->session->userdata('nama_pengguna'));  ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id='example'>
                                <thead>
                                    <tr class="text-center">
                                        <th rowspan="2" class="align-middle">No</th>
                                        <th colspan="2">Perkiraan</th>
                                        <th colspan="7" class="align-middle">URAIAN TENTANG USULAN</th>
                                        <th rowspan="2" class="align-middle">Keterangan</th>
                                        <th rowspan="2" class="align-middle">Action</th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>No Per</th>
                                        <th>Nama</th>
                                        <th>UPK</th>
                                        <th>Kategori</th>
                                        <th>Latar Belakang</th>
                                        <th>Solusi/Usulan</th>
                                        <th>Volume</th>
                                        <th>Harga</th>
                                        <th>Biaya</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanUmum;
                                        $harga = $row->biaya;
                                        $satuan = $row->volume;
                                        $jumlah = $harga * $satuan;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td><?= $row->bagian_upk ?></td>
                                            <td class="text-center"><?= $row->kategori ?></td>
                                            <td><?= $row->latar_belakang ?></td>
                                            <td><?= $row->solusi ?></td>
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <td class="text-end"><?= number_format($jumlah, 0, ',', '.') ?></td>
                                            <td><?= $row->ket ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/usulan_umum/edit_usulan_umum/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <!-- <a href="<?= base_url('rkap/usulan_umum/detail_usulan_umum/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <a href="<?= base_url('rkap/usulan_umum/hapus_usulan_umum/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="8" class="text-end">Total</th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                        <th class="text-end"><?= number_format(array_sum(array_map(function ($item) {
                                                                    return $item->biaya * $item->volume;
                                                                }, $tampil)), 0, ',', '.') ?></th>
                                        <th colspan="2"></th>
                                    </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>