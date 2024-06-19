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

                <div class="card-body" style="height: 80vh;">
                    <div class="row justify-content-center mb-4">
                        <div class="col-auto">
                            <div class="boxBiru" style="width: 15rem;">
                                <h6>Kepala Unit</h6>
                                <h6 class="fw-bold" style="font-size: 0.8rem;"><?= strtoupper($kaupk->nama); ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 20rem;">
                                <h6>Pelaksana Administrasi :</h6>
                                <h6><?= isset($p_adm) ? $p_adm->nama : '-'; ?></h6>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 20rem;">
                                <h6>Pelaksana Teknik :</h6>
                                <h6><?= isset($p_tek) ? $p_tek->nama : '-'; ?></h6>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxHijau" style="width: 20rem;">
                                <h6>Pelaksana Pel. Langganan :</h6>
                                <h6><?= isset($p_lang) ? $p_lang->nama : '-'; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 20rem;">
                                <h6>Staf Administrasi :</h6>
                                <?php foreach ($s_adm as $row) : ?>
                                    <?php $s_adm = isset($s_adm->nama)  ? $s_adm->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                                <?php foreach ($s_admpm as $row) : ?>
                                    <?php $s_admpm = isset($s_admpm->nama)  ? $s_admpm->nama : ''  ?>
                                    <h6><?= $row->nama  ?> (PM)</h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 20rem;">
                                <h6>Staf Teknik :</h6>
                                <?php foreach ($s_tek as $row) : ?>
                                    <?php $s_tek = isset($s_tek->nama)  ? $s_tek->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="boxKuning" style="width: 20rem;">
                                <h6>Staf Pel Langganan :</h6>
                                <?php foreach ($s_langUpk as $row) : ?>
                                    <?php $s_langUpk = isset($s_langUpk->nama)  ? $s_langUpk->nama : ''  ?>
                                    <h6><?= $row->nama  ?></h6>
                                <?php endforeach;  ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>