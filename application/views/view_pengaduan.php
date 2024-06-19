<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('kajian/kitab/tambah'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Tambah Nama Kitab</button></a> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="font-size: 0.7rem;">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class=" text-center">No</th>
                                    <th class=" text-center">tgl Aduan</th>
                                    <th class=" text-center">No Pelanggan</th>
                                    <th class=" text-center">Nama Pelanggan</th>
                                    <th class=" text-center">Alamat Pelanggan</th>
                                    <th class=" text-center">No Tel / WA</th>
                                    <th class=" text-center">Jenis Aduan</th>
                                    <th class=" text-center">Wilayah Aduan</th>
                                    <th class=" text-center">Isi Aduan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pengaduan as $row) :
                                ?>
                                    <?php
                                    $tgls = strtotime($row->tgl_aduan);
                                    $day = date('d', $tgls);
                                    $bln = date('m', $tgls);
                                    $tahun = date('Y', $tgls);
                                    $waktu = date('H:i:s', $tgls);
                                    ?>
                                    <tr>
                                        <td class="text-center"><small><?= $no++ ?></small></td>
                                        <td><?= $day . '-' . $bln . '-' . $tahun . ' ' . $waktu ?></td>
                                        <td><?= $row->no_pel ?></td>
                                        <td><?= $row->nama_pel ?></td>
                                        <td><?= $row->alamat ?></td>
                                        <td><?= $row->no_tel ?></td>
                                        <td><?= $row->jenis_aduan ?></td>
                                        <td><?= $row->wil_layanan ?></td>
                                        <td><?= $row->isi_aduan ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>