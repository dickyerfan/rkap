<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="border rounded p-2 mb-2" style="font-size:0.78rem; background:#f8f9fa;">
                        Nilai diisi dalam <b>PERSEN (0-100)</b>, total tiap pasangan harus 100%.
                        <b>Tagihan P1</b> = % tagihan bulan B diterima bulan B+1; <b>P2</b> = diterima bulan B+2.
                        <b>Th Lalu P1</b> = % piutang Th Lalu diterima di Januari; <b>P2</b> = di Februari.
                        Hanya tahun yang sudah ditambahkan yang ditampilkan.<br> Untuk tahun berikutnya, klik <b>Tambah Tahun</b>.
                        Tahun yang <b>LEBIH LAMA dari tahun anggaran aktif (<?= $tahun_aktif ?>)</b> otomatis terkunci; tahun yang di-<i>kunci manual</i> (ikon gembok) juga <b>TIDAK bisa diedit/dihapus</b> dan nilainya dilewati saat Simpan.
                        <br>Pengaturan berlaku untuk tahun <?= $tahun_awal_efisiensi ?> ke atas dan TIDAK mempengaruhi tahun <?= $tahun_awal_efisiensi - 1 ?> ke bawah.
                    </div>

                    <div class="row mb-2">
                        <div class="col-auto">
                            <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/tambah_tahun_distribusi') ?>" method="post" class="d-flex align-items-center" style="gap:8px;">
                                <label class="mb-0 fw-bold" style="font-size:0.85rem;">Tambah Tahun:</label>
                                <input type="number" name="tahun" class="form-control" style="width:110px;" value="<?= date('Y') + 1 ?>" min="2027" step="1">
                                <button type="submit" class="neumorphic-button"><i class="fas fa-plus"></i> Tambah Tahun</button>
                            </form>
                        </div>
                    </div>

                    <?php if (empty($tahun_list)) : ?>
                        <div class="alert alert-warning py-1 px-2" style="font-size:0.85rem;">
                            Belum ada tahun yang diatur. Klik <b>Tambah Tahun</b> untuk memulai.
                        </div>
                    <?php else : ?>
                        <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/simpan_distribusi_all') ?>" method="post">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center align-middle" style="font-size:0.8rem;">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tahun</th>
                                            <th colspan="2">Tagihan (diterima bulan)</th>
                                            <th colspan="2">Th Lalu / Piutang (diterima bulan)</th>
                                            <th>Aksi</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th>P1 (%) <br><span class="fw-normal" style="font-size:0.7rem;">bulan B+1</span></th>
                                            <th>P2 (%) <br><span class="fw-normal" style="font-size:0.7rem;">bulan B+2</span></th>
                                            <th>P1 (%) <br><span class="fw-normal" style="font-size:0.7rem;">Januari</span></th>
                                            <th>P2 (%) <br><span class="fw-normal" style="font-size:0.7rem;">Februari</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($tahun_list as $thn) :
                                            $d = $data_tahun[$thn];
                                            $kode_lama = ($thn < $tahun_awal_efisiensi);
                                            $auto_locked = (!$kode_lama && $thn < $tahun_aktif);
                                            $manual_locked = !empty($terkunci[$thn]);
                                            $is_locked = $manual_locked || $auto_locked;
                                            $locked_attr = $is_locked ? ' readonly' : '';
                                            $locked_cls = $is_locked ? ' bg-light text-muted' : '';
                                        ?>
                                            <tr>
                                                <td class="fw-bold">
                                                    <?= $thn ?>
                                                    <?php if ($auto_locked) : ?><i class="fas fa-lock text-danger ms-1" title="Terkunci OTOMATIS (tahun <?= $thn ?> lebih lama dari tahun anggaran aktif <?= $tahun_aktif ?>)"></i><?php endif; ?>
                                                    <?php if ($manual_locked) : ?><i class="fas fa-lock text-warning ms-1" title="Terkunci manual"></i><?php endif; ?>
                                                    <?php if ($kode_lama) : ?>
                                                        <br><span class="badge bg-secondary" style="font-size:0.65rem;" title="Tahun ini memakai kode lama dan TIDAK terpengaruh pengaturan ini. Hapus saja bila tidak diperlukan.">&lt;<?= $tahun_awal_efisiensi ?> (kode lama)</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><input type="number" name="rows[<?= $thn ?>][dist_tagihan_p1]" value="<?= round((float)$d['dist_tagihan']['p1'] * 100) ?>" min="0" max="100" step="1" class="form-control form-control-sm text-center<?= $locked_cls ?>" <?= $locked_attr ?>></td>
                                                <td><input type="number" name="rows[<?= $thn ?>][dist_tagihan_p2]" value="<?= round((float)$d['dist_tagihan']['p2'] * 100) ?>" min="0" max="100" step="1" class="form-control form-control-sm text-center<?= $locked_cls ?>" <?= $locked_attr ?>></td>
                                                <td><input type="number" name="rows[<?= $thn ?>][dist_thl_p1]" value="<?= round((float)$d['dist_thl']['p1'] * 100) ?>" min="0" max="100" step="1" class="form-control form-control-sm text-center<?= $locked_cls ?>" <?= $locked_attr ?>></td>
                                                <td><input type="number" name="rows[<?= $thn ?>][dist_thl_p2]" value="<?= round((float)$d['dist_thl']['p2'] * 100) ?>" min="0" max="100" step="1" class="form-control form-control-sm text-center<?= $locked_cls ?>" <?= $locked_attr ?>></td>
                                                <td class="text-center">
                                                    <?php if ($auto_locked) : ?>
                                                        <span class="text-muted" title="Terkunci otomatis (tahun <?= $thn ?> &lt; tahun anggaran aktif <?= $tahun_aktif ?>). Tidak bisa diedit/dihapus."><i class="fas fa-lock"></i> otomatis</span>
                                                    <?php elseif ($manual_locked) : ?>
                                                        <a href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/buka_tahun_distribusi/' . $thn) ?>" title="Buka kunci tahun <?= $thn ?>" class="text-success"><i class="fas fa-unlock"></i></a>
                                                    <?php else : ?>
                                                        <a href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/kunci_tahun_distribusi/' . $thn) ?>" title="Kunci tahun <?= $thn ?> (tidak bisa diedit/dihapus)" class="text-secondary"><i class="fas fa-lock"></i></a>
                                                        <a href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/hapus_tahun_distribusi/' . $thn) ?>" onclick="return confirm('Hapus pengaturan tahun <?= $thn ?>? Tahun tersebut akan kembali memakai nilai default.');" class="text-danger ms-1"><i class="fas fa-trash"></i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="neumorphic-button" onclick="return confirm('Yakin ingin menyimpan pengaturan semua tahun?');"><i class="fas fa-save"></i> Simpan Tahun</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>