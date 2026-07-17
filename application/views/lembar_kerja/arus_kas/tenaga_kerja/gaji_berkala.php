<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark"><?= strtoupper($title) ?></span>
                    <a href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/update_gaji_berkala') ?>" method="post">
                                <input type="hidden" name="id_pegawai" value="<?= $pegawai['id'] ?>">
                                <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                <input type="hidden" name="bagian" value="<?= $tk['bagian'] ?>">

                                <div class="mb-3">
                                    <label class="form-label">Nama Pegawai</label>
                                    <input type="text" class="form-control" value="<?= $pegawai['nama'] ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jabatan Saat Ini</label>
                                    <input type="text" class="form-control" value="<?= $pegawai['jabatan'] ?>" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="bulan_berkala" class="form-label">Bulan Kenaikan Berkala</label>
                                    <select name="bulan_berkala" id="bulan_berkala" class="form-select" required>
                                        <option value="">--Pilih Bulan--</option>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="gaji_pokok_baru" class="form-label">Gaji Pokok Baru (setelah berkala)</label>
                                    <input type="number" name="gaji_pokok_baru" id="gaji_pokok_baru" class="form-control" placeholder="Masukkan gaji pokok baru" required>
                                </div>

                                <button type="submit" class="neumorphic-button w-100">
                                    <i class="fa-solid fa-check"></i> Terapkan Gaji Berkala
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>