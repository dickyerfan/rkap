<div id="layoutSidenav_content" style="background: linear-gradient(
    45deg,
    rgba(55, 223, 197, 0.9),
    rgba(254, 255, 53, 0.9) 100%
    )">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <div class="row title">
                        <div class="col-9">
                            <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                        </div>
                        <div class="col-3">
                            <a href="<?= base_url('transaksi/tambah'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Input Transaksi</button></a>
                            <button id="belum" class="btn btn-warning btn-sm"><i class="fas fa-calendar-alt"></i> Pilih Waktu</button>
                        </div>
                    </div>
                    <!-- <a href="#form" data-bs-toggle="modal" class="btn btn-primary btn-sm float-end" onclick="submit('tambah')"><i class="fas fa-plus"></i> Input Transaksi</a> -->
                </div>
                <div class="container mt-1">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-1" id="tanya" style="display: none;">
                        <div class="col-md-4">
                            <div class="card bg-light shadow text-center text-dark">
                                <div class="card-body">
                                    <!-- <h3>Pilih Bulan & Tahun</h3> -->
                                    <form action="<?= base_url() ?>transaksi" method="GET">
                                        <div class="form-group">
                                            <?php $bulan = date('m'); ?>
                                            <select name="bulan" class="form-select mb-1" required>
                                                <!-- <option value="<?php echo $bulan = date('m'); ?>">Bulan</option> -->
                                                <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
                                                <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
                                                <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
                                                <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
                                                <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
                                                <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
                                                <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
                                                <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
                                                <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
                                                <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
                                                <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>November</option>
                                                <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
                                            </select>
                                            <select name="tahun" class="form-select mb-1">
                                                <?php
                                                $mulai = date('Y') - 2;
                                                for ($i = $mulai; $i < $mulai + 11; $i++) {
                                                    $sel = $i == date('Y') ? ' selected="selected"' : '';
                                                    echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" name="add_post" id="tombol_pilih" class="btn btn-block btn-primary">Pilih</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm title" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class=" text-center">No</th>
                                    <th class=" text-center">Action</th>
                                    <th class=" text-center">Tanggal</th>
                                    <th class=" text-center">Uraian</th>
                                    <th class=" text-center">Jumlah (Rp)</th>
                                    <th class=" text-center">Jenis Transaksi</th>
                                    <th class=" text-center">Jenis Donasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($transaksi as $row) :
                                ?>
                                    <?php
                                    $tgls = strtotime($row->tanggal);
                                    $day = date('d', $tgls);
                                    $bln = date('m', $tgls);
                                    $tahun = date('Y', $tgls);

                                    switch ($bln) {
                                        case '01':
                                            $bln = "Januari";
                                            break;
                                        case '02':
                                            $bln = "Februari";
                                            break;
                                        case '03':
                                            $bln = "Maret";
                                            break;
                                        case '04':
                                            $bln = "April";
                                            break;
                                        case '05':
                                            $bln = "Mei";
                                            break;
                                        case '06':
                                            $bln = "Juni";
                                            break;
                                        case '07':
                                            $bln = "Juli";
                                            break;
                                        case '08':
                                            $bln = "Agustus";
                                            break;
                                        case '09':
                                            $bln = "September";
                                            break;
                                        case '10':
                                            $bln = "Oktober";
                                            break;
                                        case '11':
                                            $bln = "November";
                                            break;
                                        case '12':
                                            $bln = "Desember";
                                            break;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><small><?= $no++ ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>transaksi/edit/<?= $row->id; ?>"><span class="btn btn-primary btn-sm"><i class=" fas fa-fw fa-edit"></i></span></a>
                                            <a href="<?= site_url('transaksi/hapus/' . $row->id); ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i></a>
                                            <!-- <a href="#" data-toggle="modal" data-target="#hapusModal"><span class="btn btn-danger"><i class="fas fa-fw fa-trash"></i> </span></a> -->
                                        </td>
                                        <td class="text-center"><?= $day . ' ' . $bln . ' ' . $tahun ?></td>
                                        <td><?= $row->uraian ?></td>
                                        <td class="text-end"><?= number_format($row->rupiah, 0, ',', '.') ?>,-</td>
                                        <td class="text-center"><?= $row->jenis_transaksi ?></td>
                                        <td class="text-center"><?= $row->jenis_donasi ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- <div class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form">Transaksi</h5>
                </div>
                <div class="modal-body">
                    <p id="pesan" style="color: red;"></p>
                    <table class="table table-borderless">
                        <tr>
                            <td>Tanggal</td>
                            <td class="text-center"> :</td>
                            <td class="text-center"></td>
                            <td>
                                <input type="hidden" name="id" value="" />
                                <input type="text" id="datepicker" name="tanggal" placeholder="Tanggal" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td>Uraian</td>
                            <td class="text-center"> :</td>
                            <td class="text-center"></td>
                            <td><input type="text" name="uraian" placeholder="Uraian" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Jumlah</td>
                            <td class="text-center"> :</td>
                            <td class="text-center"></td>
                            <td><input type="text" name="rupiah" placeholder="Jumlah Transaksi" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>Jenis Transaksi</td>
                            <td class="text-center"> :</td>
                            <td class="text-center"></td>
                            <td>
                                <select name="jenis_transaksi" id="jenis_transaksi" class="form-select">
                                    <option value="">Pilih Transaksi</option>
                                    <option value="penerimaan">penerimaan</option>
                                    <option value="pengeluaran">pengeluaran</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Donasi</td>
                            <td class="text-center"> :</td>
                            <td class="text-center"></td>
                            <td>
                                <select name="jenis_donasi" id="jenis_donasi" class="form-select">
                                    <option value="">Pilih Donasi</option>
                                    <option value="umum">umum</option>
                                    <option value="operasional">operasional</option>
                                    <option value="ramadhan">ramadhan</option>
                                </select>
                            </td>
                        </tr>
                        <td>Kode Saldo</td>
                        <td class="text-center"> :</td>
                        <td class="text-center"></td>
                        <td><input type="text" name="kode_saldo" placeholder="Untuk saldo awal di isi 1" class="form-control"></td>
                        </tr>
                        <tr class="text-center">
                            <td colspan="4">
                                <button type="button" id="btn-tambah" onclick="tambahdata()" class="btn btn-primary">Tambah</button>
                                <button type="button" id="btn-ubah" onclick="ubahdata()" class="btn btn-primary">Ubah</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Batal</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> -->