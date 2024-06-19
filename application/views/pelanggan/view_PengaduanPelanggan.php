<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('../assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
            <h2>Info Pelanggan</h2>
            <ol>
                <li><a href="<?= base_url('publik') ?>">Beranda</a></li>
                <li><?= $title ?></li>
            </ol>

        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="pengaduan" class="pengaduan">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="p-2">
                <?= $this->session->flashdata('info'); ?>
                <?= $this->session->unset_userdata('info'); ?>


            </div>
            <div class="row">
                <div class="col">
                    <h2 class="text-center mb-4">Form <?= $title ?></h2>
                    <div class="card bg-light shadow text-dark">
                        <div class="card-body">
                            <form action="<?= base_url('pelanggan/pengaduanPelanggan') ?>" method="POST" enctype="multipart/form-data">
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">No Pelanggan :</label>
                                            <input type="text" name="no_pel" class="form-control" value="<?= set_value('no_pel'); ?>">
                                            <?= form_error('no_pel', '<div class="text-danger">', '</div>'); ?>

                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Nama Pelanggan :</label>
                                            <input type="text" name="nama_pel" class="form-control" value="<?= set_value('nama_pel'); ?>">
                                            <?= form_error('nama_pel', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Alamat :</label>
                                            <textarea name="alamat" id="" rows="4" class="form-control"><?= set_value('alamat'); ?></textarea>
                                            <?= form_error('alamat', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">No Telepon/WA :</label>
                                            <input type="text" name="no_tel" class="form-control" value="<?= set_value('no_tel'); ?>">
                                            <?= form_error('no_tel', '<div class="text-danger">', '</div>'); ?>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Jenis Pengaduan :</label>
                                            <select name="jenis_aduan" id="" class="form-select">
                                                <option value="">Pilih...</option>
                                                <option value="Air Mati">Air Mati</option>
                                                <option value="Air Keruh">Air Keruh</option>
                                                <option value="Kebocoran">Kebocoran</option>
                                                <option value="Water Meter">Water Meter</option>
                                                <option value="Pemakaian">Pemakaian</option>
                                                <option value="Lain-lain">Lain-lain</option>
                                            </select>
                                            <?= form_error('jenis_aduan', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Wilayah Pelayanan :</label>
                                            <select name="wil_layanan" id="" class="form-select">
                                                <option value="">Pilih...</option>
                                                <option value="Bondowoso">Bondowoso</option>
                                                <option value="Sukosari 1">Sukosari 1</option>
                                                <option value="Maesan">Maesan</option>
                                                <option value="Tegalampel">Tegalampel</option>
                                                <option value="Tapen">Tapen</option>
                                                <option value="Prajekan">Prajekan</option>
                                                <option value="Tlogosari">Tlogosari</option>
                                                <option value="Wringin">Wringin</option>
                                                <option value="Curahdami">Curahdami</option>
                                                <option value="Tamanan">Tamanan</option>
                                                <option value="Tenggarang">Tenggarang</option>
                                                <option value="Tamankrocok">Tamankrocok</option>
                                                <option value="Wonosari">Wonosari</option>
                                                <option value="Klabang">Klabang</option>
                                                <option value="Sukosari 2">Sukosari 2</option>
                                            </select>
                                            <?= form_error('wil_layanan', '<div class="text-danger">', '</div>'); ?>
                                        </div>

                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Isi Pengaduan :</label>
                                            <textarea name="isi_aduan" id="" rows="4" class="form-control"><?= set_value('isi_aduan'); ?></textarea>
                                            <?= form_error('isi_aduan', '<div class="text-danger">', '</div>'); ?>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Foto Pengaduan :</label>
                                            <input type="file" name="foto_aduan" class="form-control">
                                            <?= form_error('foto_aduan', '<div class="text-danger">', '</div>'); ?>
                                            <span style="font-size: 0.7rem; color:red;">jika ada foto lokasi bisa dilampirkan <br> file maksimal 1 mb & hanya bisa file jpg,jpeg,png dan pdf</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-8">
                                        <div class="d-grid gap-2">
                                            <button type="submit" name="add_post" id="tombol_pilih" class="neumorphic-button">Kirim Pengaduan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End Info Item -->
            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->