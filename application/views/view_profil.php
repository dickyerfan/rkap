<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid mt-2">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow my-5 border-0">
                        <div class="card-header bg-success ">
                            <h2 class="text-white text-center text-uppercase fw-bold"><?= $title; ?></h2>
                        </div>
                        <div class="card-body">
                            <!-- <img src="..." class="card-img-top"> -->
                            <h5 class="card-title">Nama : <?= $this->session->userdata('nama_lengkap'); ?></h5>
                            <h5 class="card-title">Email : <?= $this->session->userdata('email'); ?></h5>
                            <h5 class="card-title">Status : <?= ucfirst($this->session->userdata('level')); ?></h5>
                            <p class="card-text">Keterangan :</p>
                            <!-- <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus officiis maiores dolorum minima. Aliquam nostrum culpa vel, et architecto soluta, ipsum delectus incidunt a exercitationem ipsam beatae inventore! Provident, aut?</p> -->
                        </div>
                        <div class="card-footer">
                            <a href="<?=($this->session->userdata('level')=='Pengguna')? base_url('pengguna'): base_url('dashboard') ?>" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>