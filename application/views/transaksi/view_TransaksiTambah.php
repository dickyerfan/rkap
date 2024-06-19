<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('transaksi'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" required value="<?= set_value('tanggal') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="text" name="uraian" id="uraian" class="form-control" placeholder="Uraian" value="<?= set_value('uraian') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('uraian'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <input type="text" name="rupiah" id="rupiah" class="form-control" placeholder="Rupiah" value="<?= set_value('rupiah') ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('rupiah'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-select select2">
                                        <option value="">Pilih Transaksi</option>
                                        <option value="penerimaan">penerimaan</option>
                                        <option value="pengeluaran">pengeluaran</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_transaksi'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <select name="jenis_donasi" id="jenis_donasi" class="form-select select2">
                                        <option value="">Pilih Donasi</option>
                                        <option value="umum">umum</option>
                                        <option value="operasional">operasional</option>
                                        <option value="ramadhan">ramadhan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_donasi'); ?></small>
                                </div>
                                <!-- <div class="form-group mb-2">
                                    <select name="kode_saldo" id="kode_saldo" class="form-select select2">
                                        <option value="">Pilih Kode Donasi</option>
                                        <option value="0" selected>0</option>
                                        <option value="1">1</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('kode_saldo'); ?></small>
                                    <small class="form-text text-danger pl-3">Untuk Saldo awal di isi angka 1</small>
                                </div> -->
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm float-left mt-1" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>