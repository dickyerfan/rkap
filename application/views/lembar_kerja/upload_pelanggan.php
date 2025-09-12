<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <h5><?= $title; ?></h5>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/pelanggan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Kembali</button> </a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label>UPK</label>
                                <select name="id_upk" class="form-control">
                                    <?php foreach ($upk_list as $upk) : ?>
                                        <option value="<?= $upk['id_upk']; ?>"><?= $upk['nama_upk']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Jenis Pelanggan</label>
                                <select name="id_jp" class="form-control">
                                    <?php foreach ($jenis_list as $jp) : ?>
                                        <option value="<?= $jp['id_jp']; ?>"><?= $jp['nama_jp']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Tahun Pembuatan RKAP</label>
                                <input type="number" name="tahun" class="form-control" value="<?= date('Y'); ?>">
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2" class="text-center align-middle">Bulan</th>
                                    <?php foreach ($kategori_list as $k) : ?>
                                        <th class="text-center"><?= $k['nama_kd']; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($bulan = 1; $bulan <= 12; $bulan++) : ?>
                                    <tr>
                                        <td class="fw-bold text-center"><?= date('F', mktime(0, 0, 0, $bulan, 1)); ?></td>
                                        <?php foreach ($kategori_list as $k) : ?>
                                            <td>
                                                <input type="number" name="data[<?= $bulan; ?>][<?= $k['id_kd']; ?>]" class="form-control form-control-sm" value="0">
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary mt-2">Simpan Data</button>
                    </form>
                </div>
            </div>
        </div>
    </main>