<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <a class="fw-bold text-dark text-uppercase" style="text-decoration:none ;">Isian Barang </a> -->
                    <!-- <a href="<?= base_url('rkap/usulan_barang/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Upload data</button></a> -->
                    <form method="get" action="">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <select name="upk_bagian" class="form-control">
                                    <option value="">-- Pilih UPK/Bagian --</option>
                                    <?php foreach ($list_upk_bagian as $ub) : ?>
                                        <option value="<?= $ub ?>" <?= isset($_GET['upk_bagian']) && $_GET['upk_bagian'] == $ub ? 'selected' : '' ?>><?= $ub ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <?php
                                $tahun_ini = date('Y');
                                $tahun_selected = isset($_GET['tahun']) && $_GET['tahun'] !== '' ? (int)$_GET['tahun'] : (int)$tahun_ini;
                                $tahun_start = $tahun_ini - 2;
                                $tahun_end = ($tahun_selected > $tahun_ini) ? $tahun_selected : $tahun_ini;
                                ?>
                                <select name="tahun" class="form-control">
                                    <?php for ($i = $tahun_start; $i <= $tahun_end; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $tahun_selected == $i ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="kategori" class="form-control">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="ATK" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'ATK') ? 'selected' : '' ?>>ATK</option>
                                    <option value="Inventaris" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'Inventaris') ? 'selected' : '' ?>>Inventaris</option>
                                    <option value="Peralatan Teknik" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'Peralatan Teknik') ? 'selected' : '' ?>>Peralatan Teknik</option>
                                    <option value="Lainnya" <?= (isset($_GET['kategori']) && $_GET['kategori'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="neumorphic-button">Filter</button>
                                <button class="neumorphic-button"><a style="text-decoration: none; color: black;" href="<?= base_url('rkap/isian_barang') ?>">Reset</a></button>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  $tahun_selected + 1 ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table id="example" class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Upk/Bagian</th>
                                        <th class="text-center">No Per</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Latar Belakang</th>
                                        <th class="text-center">Volume</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $total_jumlah = 0;
                                    foreach ($tampil as $row) :
                                        $id = $row->id_usulanBarang;
                                        $harga = $row->biaya;
                                        $satuan = $row->volume;
                                        $jumlah = $harga * $satuan;
                                        $total_jumlah += $jumlah;
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->bagian_upk ?></td>
                                            <td class="text-end"><?= $row->no_perkiraan ?></td>
                                            <td><?= $row->nama_perkiraan ?></td>
                                            <td class="text-center"><?= $row->kategori ?></td>
                                            <td><?= $row->latar_belakang ?></td>
                                            <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                            <td class="text-end"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                            <td class="text-end"><?= number_format($jumlah, 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('rkap/isian_barang/edit_isian_barang/') ?><?= $id ?>"><span class="text-dark " style="text-decoration: none;"><i class="fas fa-edit text-success"></i> </span></a>
                                                <!-- <a href="<?= base_url('rkap/isian_barang/detail_isian_barang/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a> -->
                                                <!-- <a href="<?= base_url('rkap/isian_barang/hapus_isian_barang/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">Total</th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                        <th class="text-end"><?= number_format($total_jumlah, 0, ',', '.') ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>