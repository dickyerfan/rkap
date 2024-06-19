<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('user/admin/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah User</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Nama Pengguna</th>
                                    <th>Nama Lengkap</th>
                                    <th>UPK/Bagian</th>
                                    <th>Level</th>
                                    <th>Status</th>
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
                                        <td><?= $row->upk_bagian ?></td>
                                        <td class="text-center"><?= $row->level ?></td>
                                        <td class="text-center"><?= $row->status == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                                        <td class="text-center">
                                            <?php if ($row->nama_pengguna !== 'administrator') : ?>
                                                <a href="<?= base_url(); ?>user/admin/edit/<?= $row->id; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                                <a href="<?= base_url(); ?>user/admin/hapus/<?= $row->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>