<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun_rkap) ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="<?= base_url('lembar_kerja/rkap_amdk/produksi/update') ?>">
                                <input type="hidden" name="id_produk" value="<?= $produk->id_produk ?>">
                                <input type="hidden" name="tahun_rkap" value="<?= $tahun_rkap ?>">

                                <div class="mb-2">
                                    <input type="text" class="form-control" value="<?= $produk->nama_produk ?>" readonly>
                                </div>

                                <table class="table table-bordered table-sm" style="font-size:0.8rem;">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Bulan</th>
                                            <th>Jumlah Produksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nama_bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        foreach ($produksi as $row) : ?>
                                            <tr>
                                                <td><?= $nama_bulan[$row['bulan']] ?></td>
                                                <td>
                                                    <input type="number" class="form-control text-end" name="jumlah_produksi[<?= $row['bulan'] ?>]" value="<?= $row['jumlah_produksi'] ?>" required>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <button type="submit" class="neumorphic-button mt-2">Update Data</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>