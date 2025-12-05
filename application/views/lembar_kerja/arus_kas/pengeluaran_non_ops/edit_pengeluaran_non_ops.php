<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/pengeluaran_non_ops?upk=' . $this->session->userdata('upk') . '&tahun_rkap=' . $this->session->userdata('tahun_rkap')) ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label>Kode Perkiraan</label>
                            <input type="text" class="form-control" value="<?= $no_per->kode . ' - ' . $no_per->name ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Uraian</label>
                            <input type="text" name="uraian" class="form-control" value="<?= $uraian ?>">
                        </div>

                        <table class="table table-sm table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Nilai (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nama_bulan = [
                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                ];
                                foreach ($nama_bulan as $num => $nama) :
                                    $nilai = isset($nilai_map[$num]) ? $nilai_map[$num] : 0;
                                ?>
                                    <tr>
                                        <td><?= $nama ?></td>
                                        <td><input type="number" class="form-control text-end" name="nilai[<?= $num ?>]" value="<?= $nilai ?>"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="neumorphic-button">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>