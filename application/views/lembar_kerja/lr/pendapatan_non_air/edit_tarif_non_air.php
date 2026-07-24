<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $row->tahun) ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('lembar_kerja/lr/tarif_non_air/update') ?>">
                        <input type="hidden" name="id" value="<?= $row->id ?>">

                        <div class="mb-3">
                            <label class="form-label">Jenis Pendapatan</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($row->jenis_pendapatan) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Parameter</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($row->parameter) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="text" class="form-control" value="<?= $row->tahun ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai</label>
                            <?php if ($row->parameter == 'bulan_promo') : ?>
                                <input type="text" name="nilai" class="form-control" value="<?= htmlspecialchars($row->nilai) ?>" required>
                                <small class="text-muted">Isi nomor bulan pisah koma, contoh: 1,8</small>
                            <?php else : ?>
                                <input type="number" step="any" name="nilai" class="form-control" value="<?= number_format($row->nilai, 2, '.', '') ?>" required>
                            <?php endif; ?>
                            <div class="invalid-feedback">Nilai tidak boleh kosong.</div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= site_url('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $row->tahun) ?>" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
