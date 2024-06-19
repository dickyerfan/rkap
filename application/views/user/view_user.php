<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid  mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('user/user'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                        <thead>
                            <tr class="bg-secondary text-center">
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($user as $row) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $row->nama_pengguna ?></td>
                                    <td><?= $row->nama_lengkap ?></td>
                                    <td><?= $row->email ?></td>
                                    <td><?= $row->level ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url(); ?>user/user/edit/<?= $row->id; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                        <a href="<?= base_url(); ?>user/user/hapus/<?= $row->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </main>