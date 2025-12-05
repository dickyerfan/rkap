<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/beban_trandis?upk=' . $this->session->userdata('upk') . '&tahun_rkap=' . $this->session->userdata('tahun_rkap')) ?>">
                        <button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post">
                                <table class="table table-bordered table-sm" style="font-size:0.85rem;">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Nilai (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $bulan_label = [
                                            'jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret', 'apr' => 'April',
                                            'mei' => 'Mei', 'jun' => 'Juni', 'jul' => 'Juli', 'agu' => 'Agustus',
                                            'sep' => 'September', 'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'
                                        ];
                                        foreach ($bulan_label as $key => $nama) : ?>
                                            <tr>
                                                <td><?= $nama; ?></td>
                                                <!-- <td><input type="text" name="<?= $key; ?>" value="<?= number_format($nilai_bulan[$key], 2, ',', '.'); ?>" class="form-control text-end"></td> -->
                                                <td>
                                                    <input type="number" name="<?= $key; ?>" value="<?= number_format((float)$nilai_bulan[$key], 1, '.', ''); ?>" step="0.1" class="form-control text-end">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                    <a href="<?= base_url('lembar_kerja/lr/beban_trandis?upk=' . $this->session->userdata('upk') . '&tahun_rkap=' . $tahun); ?>" class="btn btn-secondary btn-sm">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>