<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
            <h2>Info Layanan</h2>
            <ol>
                <li><a href="<?= base_url('publik') ?>">Beranda</a></li>
                <li><?= $title ?></li>
            </ol>

        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="cakupanLayanan" class="visiMisi">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row justify-content-around gy-4">
                <h3>Cakupan Layanan PDAM Bondowoso</h3>
                <?php
                $upkCount = count($upks);
                $halfUpkCount = ceil($upkCount / 2);
                $columnIndex = 0;
                ?>
                <div class="col-lg-6">
                    <?php foreach ($upks as $index => $upk) : ?>
                        <?php if ($columnIndex === $halfUpkCount) : ?>
                </div>
                <div class="col-lg-6">
                <?php endif; ?>
                <div class="icon-box d-flex position-relative" data-aos="fade-up" data-aos-delay="<?= ($index % $halfUpkCount) * 100 ?>">
                    <i class="bi bi-globe-asia-australia flex-shrink-0"></i>
                    <div>
                        <h4><a href="#!" class="stretched-link"><?= $upk['name'] ?></a></h4>
                    </div>
                </div><!-- End Icon Box -->
                <?php $columnIndex++; ?>
            <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->






    <!-- Modal Bondowoso -->
    <div class="modal fade" id="bwsMap" tabindex="-1" aria-labelledby="bwsLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bwsLabel">Cakupan Layanan UPK Bondowoso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url('assets/img/cakupanLayanan/bws.jpeg') ?>" alt="bondowoso" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sukosari 1 -->
    <div class="modal fade" id="suko1Map" tabindex="-1" aria-labelledby="suko1Label" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suko1Label">Cakupan Layanan UPK Sukosari 1</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?= base_url('assets/img/cakupanLayanan/suko1.jpeg') ?>" alt="sukosari1" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->