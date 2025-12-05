<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/update') ?>" method="post">
                                    <input type="hidden" name="id_tk" value="<?= $pegawai['id_tk'] ?>">

                                    <div class="form-group mb-2">
                                        <label>Nama Pegawai</label>
                                        <input type="text" class="form-control" value="<?= $pegawai['nama'] ?>" readonly>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Gaji Pokok</label>
                                        <input type="number" name="gaji_pokok" class="form-control" value="<?= $pegawai['gaji_pokok'] ?>" required>
                                    </div>

                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Jumlah Istri / Suami</label>
                                            <input type="number" name="j_istri" class="form-control" value="<?= $pegawai['j_istri'] ?>">
                                        </div>
                                        <div class="col">
                                            <label>Jumlah Anak</label>
                                            <input type="number" name="j_anak" class="form-control" value="<?= $pegawai['j_anak'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <div class="col">
                                            <label>Tunjangan Perumahan</label>
                                            <input type="number" name="t_perumahan" class="form-control" value="<?= $pegawai['t_perumahan'] ?>">
                                        </div>
                                        <div class="col">
                                            <label>Tunjangan Jabatan</label>
                                            <input type="number" name="t_jabatan" class="form-control" value="<?= $pegawai['t_jabatan'] ?>">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group mb-2">
                                        <label>BPJS Tenaga Kerja</label>
                                        <input type="number" name="bpjs_tk" class="form-control" value="<?= $pegawai['bpjs_tk'] ?>">
                                    </div> -->

                                    <button type="submit" class="neumorphic-button">Simpan & Hitung Otomatis</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>