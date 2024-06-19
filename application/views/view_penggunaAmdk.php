<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <?= $this->session->flashdata('info'); ?>
            <?= $this->session->unset_userdata('info'); ?>
            <div class="card border-0">
                <div class="card-header shadow text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Halaman RKAP PDAM Bondowoso</span>
                    </marquee>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center mb-4">
                        <div class="col-auto">
                            <div class="boxBiru" style="width: 15rem;">
                                <h6>Manajer</h6>
                                <h6 class="fw-bold" style="font-size: 0.8rem;"><?= strtoupper($kaupk->nama); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 15rem;">
                                <h6>Qua. Control</h6>
                                <h6><?= isset($amdk_qc) ? $amdk_qc->nama : '-'; ?></h6>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 15rem;">
                                <h6>Kabag Produksi</h6>
                                <h6><?= isset($amdk_pro) ? $amdk_pro->nama : '-'; ?></h6>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 15rem;">
                                <h6>Kabag Adm & Keu</h6>
                                <h6><?= isset($amdk_adm) ? $amdk_adm->nama : '-'; ?></h6>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 15rem;">
                                <h6>Kabag Pemasaran</h6>
                                <h6><?= isset($amdk_pasar) ? $amdk_pasar->nama : '-'; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 15rem;">
                                <h6>Staf Qua. Control</h6>
                                <?php foreach ($amdk_s_qc as $row) : ?>
                                    <?php $amdk_s_qc = isset($amdk_s_qc->nama)  ? $amdk_s_qc->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 15rem;">
                                <h6>Staf Produksi</h6>
                                <?php foreach ($amdk_s_pro as $row) : ?>
                                    <?php $amdk_s_pro = isset($amdk_s_pro->nama)  ? $amdk_s_pro->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 15rem;">
                                <h6>Staf Adm & Keu</h6>
                                <?php foreach ($amdk_s_adm as $row) : ?>
                                    <?php $amdk_s_adm = isset($amdk_s_adm->nama)  ? $amdk_s_adm->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 15rem;">
                                <h6>Staf Pemasaran</h6>
                                <?php foreach ($amdk_s_pasar as $row) : ?>
                                    <?php $amdk_s_pasar = isset($amdk_s_pasar->nama)  ? $amdk_s_pasar->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>