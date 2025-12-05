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
                            <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/update_pensiun') ?>" method="post">
                                <input type="hidden" name="id_pegawai" value="<?= $pegawai['id_pegawai'] ?>">

                                <div class="mb-3">
                                    <label for="bulan_pensiun" class="form-label">Pilih Bulan Pensiun</label>
                                    <select name="bulan_pensiun" id="bulan_pensiun" class="form-select" required>
                                        <option value="">--Pilih Bulan--</option>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <button type="submit" class="neumorphic-button w-100 btn btn-danger">
                                    Hapus Data Setelah Bulan Ini
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>