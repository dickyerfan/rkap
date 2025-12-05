<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('lembar_kerja/lr/produksi_air/data_sumber') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="post" action="" class="mb-3">
                                <div class="form-group mb-3">
                                    <label>U P K</label>
                                    <select id="id_upk" name="id_upk" class="form-control" required>
                                        <option value="">-- Pilih U P K --</option>
                                        <?php foreach ($list_upk as $upk) : ?>
                                            <option value="<?= $upk->id_upk ?>"><?= $upk->nama_upk ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nama Sumber</label>
                                    <input type="text" name="uraian" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Tahun</label>
                                    <input type="number" name="tahun" value="<?= date('Y') + 1; ?>" class="form-control" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nilai (Rp)</label>
                                    <input type="number" name="nilai" class="form-control" required>
                                </div>

                                <button type="submit" class="neumorphic-button">Simpan</button>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>