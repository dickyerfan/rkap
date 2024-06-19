<div id="layoutSidenav_content" style="background: linear-gradient(
    45deg,
    rgba(55, 223, 197, 0.9),
    rgba(254, 255, 53, 0.9) 100%
    )">
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
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class=" text-center">No</th>
                                    <th class=" text-center">Nama</th>
                                    <th class=" text-center">Email</th>
                                    <th class=" text-center">Tanggal</th>
                                    <th class=" text-center">Komentar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($komentar as $row) :
                                ?>
                                <?php
                                    $tgls = strtotime($row->tanggal);
                                    $day = date('d', $tgls);
                                    $bln = date('m', $tgls);
                                    $tahun = date('Y', $tgls);
                                    $waktu = date('H:i:s', $tgls);
                                    ?>
                                    <tr>
                                        <td class="text-center"><small><?= $no++ ?></small></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->email ?></td>
                                        <td><?= $day . '-' . $bln . '-' . $tahun. ' '.$waktu ?> WIB</td>
                                        <td><?= $row->komentar ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>