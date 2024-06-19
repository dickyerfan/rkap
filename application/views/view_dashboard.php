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
                    <!-- <h4 class="card-title"><?= strtoupper($title) ?></h4> -->
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Website PDAM Bondowoso</span>
                    </marquee>
                </div>

                <div class="card-body text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="mb-4" style="width: 12rem;">
                                <div class="card-body text-center fw-bold boxBiru" data-bs-toggle="modal" data-bs-target="#direktur">DIREKTUR</div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="mb-4" style="width: 12rem;">
                                <div class="card-body text-center fw-bold boxMerah" data-bs-toggle="modal" data-bs-target="#spi">S P I</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mb-3 text-uppercase">
                            <h5 class="font-weight-bold">Bagian</h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxHijau" data-bs-toggle="modal" data-bs-target="#langgan">
                                    Langganan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxHijau" data-bs-toggle="modal" data-bs-target="#umum">
                                    U m u m
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxHijau" data-bs-toggle="modal" data-bs-target="#keu">
                                    Keuangan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxHijau" data-bs-toggle="modal" data-bs-target="#renc">
                                    Perencanaan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxHijau" data-bs-toggle="modal" data-bs-target="#peml">
                                    Pemeliharaan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center mt-4 mb-3 text-uppercase">
                            <h5 class="font-weight-bold">U P K / Unit Pelayanan Kecamatan</h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <!-- <div class="col-md-2">
							<div class="card shadow bg-warning border-0 mb-4">
								<div class="card-body text-center fw-bold bg-light cardEffect border-start border-warning border-5 rounded" data-bs-toggle="modal" data-bs-target="#bondowoso">
									Bondowoso
								</div>
							</div>
						</div> -->
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#bondowoso">
                                    Bondowoso
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#suko1">
                                    Sukosari 1
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#maesan">
                                    Maesan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tegalampel">
                                    Tegalampel
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tapen">
                                    Tapen
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#prajekan">
                                    Prajekan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tlogosari">
                                    Tlogosari
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#wringin">
                                    Wringin
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#curahdami">
                                    Curahdami
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tamanan">
                                    Tamanan
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tenggarang">
                                    Tenggarang
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#tamankrocok">
                                    Tamankrocok
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#wonosari">
                                    Wonosari
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#suko2">
                                    Sukosari 2
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-4">
                                <div class="card-body text-center fw-bold boxKuning" data-bs-toggle="modal" data-bs-target="#amdk">
                                    A M D K
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>


    <!-- Modal direktur -->
    <div class="modal fade" id="direktur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title" id="direktur">Direktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <?php $direktur = isset($direktur->nama)  ? $direktur->nama : ''  ?>
                                <td class="fw-bold"><?= strtoupper($direktur)  ?></td>
                            </tr>
                            <!-- <tr>
								<td>No HP</td>
								<td> : </td>
								<?php $direkturHp = isset($direktur->no_hp)  ? $direktur->no_hp : ''  ?>
								<td><?= $direkturHp ?></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td> : </td>
								<?php $direkturAlamat = isset($direktur->alamat)  ? $direktur->alamat : ''  ?>
								<td><?= $direkturAlamat ?></td>
							</tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal spi -->
    <div class="modal fade" id="spi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-light">
                    <h5 class="modal-title" id="spi">S P I / Satuan Pengawas Intern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Ketua</td>
                                <td> : </td>
                                <?php $spi = isset($spi->nama)  ? $spi->nama : ''  ?>
                                <td><?= $spi ?></td>
                            </tr>
                            <?php foreach ($a_spi as $row) : ?>
                                <tr>
                                    <td>Anggota S P I</td>
                                    <td> : </td>
                                    <?php $a_spi = isset($a_spi->nama)  ? $a_spi->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal langganan -->
    <div class="modal fade" id="langgan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="langgan">Pengaduan Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kabag</td>
                                <td> : </td>
                                <?php $lang = isset($lang->nama)  ? $lang->nama : ''  ?>
                                <td><?= $lang ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kasubag Langganan</td>
                                <td> : </td>
                                <?php $k_lang = isset($k_lang->nama)  ? $k_lang->nama : ''  ?>
                                <td><?= $k_lang ?></td>
                            </tr>
                            <?php foreach ($s_lang as $row) : ?>
                                <tr>
                                    <td>Staf Langganan</td>
                                    <td> : </td>
                                    <?php $s_lang = isset($s_lang->nama)  ? $s_lang->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Penagihan</td>
                                <td> : </td>
                                <?php $k_tagih = isset($k_tagih->nama)  ? $k_tagih->nama : ''  ?>
                                <td><?= $k_tagih ?></td>
                            </tr>
                            <?php foreach ($s_tagih as $row) : ?>
                                <tr>
                                    <td>Staf Penagihan</td>
                                    <td> : </td>
                                    <?php $s_tagih = isset($s_tagih->nama)  ? $s_tagih->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Umum -->
    <div class="modal fade" id="umum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="umum">Umum & Administrasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kabag</td>
                                <td> : </td>
                                <?php $umum = isset($umum->nama)  ? $umum->nama : ''  ?>
                                <td><?= $umum ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kasubag Umum</td>
                                <td> : </td>
                                <?php $k_umum = isset($k_umum->nama)  ? $k_umum->nama : ''  ?>
                                <td><?= $k_umum ?></td>
                            </tr>
                            <?php foreach ($s_umum as $row) : ?>
                                <tr>
                                    <td>Staf Umum</td>
                                    <td> : </td>
                                    <?php $s_umum = isset($s_umum->nama)  ? $s_umum->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($s_umumSec as $row) : ?>
                                <tr>
                                    <td>Staf Umum (Security)</td>
                                    <td> : </td>
                                    <?php $s_umumSec = isset($s_umumSec->nama)  ? $s_umumSec->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Administrasi</td>
                                <td> : </td>
                                <?php $k_admin = isset($k_admin->nama)  ? $k_admin->nama : ''  ?>
                                <td><?= $k_admin ?></td>
                            </tr>
                            <?php foreach ($s_admin as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $s_admin = isset($s_admin->nama)  ? $s_admin->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Personalia</td>
                                <td> : </td>
                                <?php $k_person = isset($k_person->nama)  ? $k_person->nama : ''  ?>
                                <td><?= $k_person ?></td>
                            </tr>
                            <?php foreach ($s_person as $row) : ?>
                                <tr>
                                    <td>Staf Personalia</td>
                                    <td> : </td>
                                    <?php $s_person = isset($s_person->nama)  ? $s_person->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Keuangan -->
    <div class="modal fade" id="keu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="keu">Keuangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kabag</td>
                                <td> : </td>
                                <?php $keu = isset($keu->nama)  ? $keu->nama : ''  ?>
                                <td><?= $keu ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kasubag Pembukuan</td>
                                <td> : </td>
                                <?php $k_buku = isset($k_buku->nama)  ? $k_buku->nama : ''  ?>
                                <td><?= $k_buku ?></td>
                            </tr>
                            <?php foreach ($s_buku as $row) : ?>
                                <tr>
                                    <td>Staf Pembukuan</td>
                                    <td> : </td>
                                    <?php $s_buku = isset($s_buku->nama)  ? $s_buku->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Kas</td>
                                <td> : </td>
                                <?php $k_kas = isset($k_kas->nama)  ? $k_kas->nama : ''  ?>
                                <td><?= $k_kas ?></td>
                            </tr>
                            <?php foreach ($s_kas as $row) : ?>
                                <tr>
                                    <td>Staf Kas</td>
                                    <td> : </td>
                                    <?php $s_kas = isset($s_kas->nama)  ? $s_kas->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Rekening</td>
                                <td> : </td>
                                <?php $k_rek = isset($k_rek->nama)  ? $k_rek->nama : ''  ?>
                                <td><?= $k_rek ?></td>
                            </tr>
                            <?php foreach ($s_rek as $row) : ?>
                                <tr>
                                    <td>Staf Rekening</td>
                                    <td> : </td>
                                    <?php $s_rek = isset($s_rek->nama)  ? $s_rek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal perencanaan -->
    <div class="modal fade" id="renc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="renc">Perencanaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kabag</td>
                                <td> : </td>
                                <?php $renc = isset($renc->nama)  ? $renc->nama : ''  ?>
                                <td><?= $renc ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kasubag Perencanaan</td>
                                <td> : </td>
                                <?php $k_renc = isset($k_renc->nama)  ? $k_renc->nama : ''  ?>
                                <td><?= $k_renc ?></td>
                            </tr>
                            <?php foreach ($s_renc as $row) : ?>
                                <tr>
                                    <td>Staf Perencanaan</td>
                                    <td> : </td>
                                    <?php $s_renc = isset($s_renc->nama)  ? $s_renc->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Pengawasan</td>
                                <td> : </td>
                                <?php $k_awas = isset($k_awas->nama)  ? $k_awas->nama : ''  ?>
                                <td><?= $k_awas ?></td>
                            </tr>
                            <?php foreach ($s_awas as $row) : ?>
                                <tr>
                                    <td>Staf Pengawasan</td>
                                    <td> : </td>
                                    <?php $s_awas = isset($s_awas->nama)  ? $s_awas->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pemeliharaan -->
    <div class="modal fade" id="peml" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-light">
                    <h5 class="modal-title" id="peml">Pemeliharaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Kabag</td>
                                <td> : </td>
                                <?php $peml = isset($peml->nama)  ? $peml->nama : ''  ?>
                                <td><?= $peml ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Kasubag Pemeliharaan</td>
                                <td> : </td>
                                <?php $k_peml = isset($k_peml->nama)  ? $k_peml->nama : ''  ?>
                                <td><?= $k_peml ?></td>
                            </tr>
                            <?php foreach ($s_peml_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pemeliharaan</td>
                                    <td> : </td>
                                    <?php $s_peml_adm = isset($s_peml_adm->nama)  ? $s_peml_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($s_peml_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik Pemeliharaan</td>
                                    <td> : </td>
                                    <?php $s_peml_tek = isset($s_peml_tek->nama)  ? $s_peml_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kasubag Peralatan</td>
                                <td> : </td>
                                <?php $k_alat = isset($k_alat->nama)  ? $k_alat->nama : ''  ?>
                                <td><?= $k_alat ?></td>
                            </tr>
                            <?php foreach ($s_alat_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Peralatan</td>
                                    <td> : </td>
                                    <?php $s_alat_adm = isset($s_alat_adm->nama)  ? $s_alat_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($s_alat_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik Peralatan</td>
                                    <td> : </td>
                                    <?php $s_alat_tek = isset($s_alat_tek->nama)  ? $s_alat_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Suko 1 -->
    <div class="modal fade" id="suko1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="suko1">UPK SUKOSARI 1</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $suko1 = isset($suko1->nama)  ? $suko1->nama : ''  ?>
                                <td><?= $suko1 ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $suko1_p_adm = isset($suko1_p_adm->nama)  ? $suko1_p_adm->nama : ''  ?>
                                <td><?= $suko1_p_adm ?></td>
                            </tr>
                            <?php foreach ($suko1_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $suko1_s_adm = isset($suko1_s_adm->nama)  ? $suko1_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($suko1_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $suko1_s_admPm = isset($suko1_s_admPm->nama)  ? $suko1_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $suko1_p_tek = isset($suko1_p_tek->nama)  ? $suko1_p_tek->nama : ''  ?>
                                <td><?= $suko1_p_tek ?></td>
                            </tr>
                            <?php foreach ($suko1_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $suko1_s_tek = isset($suko1_s_tek->nama)  ? $suko1_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Bondowoso -->
    <div class="modal fade" id="bondowoso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="bondowoso">UPK BONDOWOSO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $bond = isset($bond->nama)  ? $bond->nama : ''  ?>
                                <td><?= $bond ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $bond_p_adm = isset($bond_p_adm->nama)  ? $bond_p_adm->nama : ''  ?>
                                <td><?= $bond_p_adm ?></td>
                            </tr>
                            <?php foreach ($bond_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $bond_s_adm = isset($bond_s_adm->nama)  ? $bond_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($bond_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $bond_s_admPm = isset($bond_s_admPm->nama)  ? $bond_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $bond_p_tek = isset($bond_p_tek->nama)  ? $bond_p_tek->nama : ''  ?>
                                <td><?= $bond_p_tek ?></td>
                            </tr>
                            <?php foreach ($bond_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $bond_s_tek = isset($bond_s_tek->nama)  ? $bond_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Pelayanan Pelanggan</td>
                                <td> : </td>
                                <?php $bond_p_lang = isset($bond_p_lang->nama)  ? $bond_p_lang->nama : ''  ?>
                                <td><?= $bond_p_lang ?></td>
                            </tr>
                            <?php foreach ($bond_s_lang as $row) : ?>
                                <tr>
                                    <td>Staf Pelayanan Pelanggan</td>
                                    <td> : </td>
                                    <?php $bond_s_lang = isset($bond_s_lang->nama)  ? $bond_s_lang->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Maesan -->
    <div class="modal fade" id="maesan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="maesan">UPK MAESAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $maesan = isset($maesan->nama)  ? $maesan->nama : ''  ?>
                                <td><?= $maesan ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $maesan_p_adm = isset($maesan_p_adm->nama)  ? $maesan_p_adm->nama : ''  ?>
                                <td><?= $maesan_p_adm ?></td>
                            </tr>
                            <?php foreach ($maesan_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $maesan_s_adm = isset($maesan_s_adm->nama)  ? $maesan_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($maesan_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $maesan_s_admPm = isset($maesan_s_admPm->nama)  ? $maesan_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $maesan_p_tek = isset($maesan_p_tek->nama)  ? $maesan_p_tek->nama : ''  ?>
                                <td><?= $maesan_p_tek ?></td>
                            </tr>
                            <?php foreach ($maesan_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $maesan_s_tek = isset($maesan_s_tek->nama)  ? $maesan_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tegalampel -->
    <div class="modal fade" id="tegalampel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tegalampel">UPK TEGALAMPEL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tegalampel = isset($tegalampel->nama)  ? $tegalampel->nama : ''  ?>
                                <td><?= $tegalampel ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tegalampel_p_adm = isset($tegalampel_p_adm->nama)  ? $tegalampel_p_adm->nama : ''  ?>
                                <td><?= $tegalampel_p_adm ?></td>
                            </tr>
                            <?php foreach ($tegalampel_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tegalampel_s_adm = isset($tegalampel_s_adm->nama)  ? $tegalampel_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tegalampel_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tegalampel_s_admPm = isset($tegalampel_s_admPm->nama)  ? $tegalampel_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tegalampel_p_tek = isset($tegalampel_p_tek->nama)  ? $tegalampel_p_tek->nama : ''  ?>
                                <td><?= $tegalampel_p_tek ?></td>
                            </tr>
                            <?php foreach ($tegalampel_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tegalampel_s_tek = isset($tegalampel_s_tek->nama)  ? $tegalampel_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tapen -->
    <div class="modal fade" id="tapen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tapen">UPK TAPEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tapen = isset($tapen->nama)  ? $tapen->nama : ''  ?>
                                <td><?= $tapen ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tapen_p_adm = isset($tapen_p_adm->nama)  ? $tapen_p_adm->nama : ''  ?>
                                <td><?= $tapen_p_adm ?></td>
                            </tr>
                            <?php foreach ($tapen_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tapen_s_adm = isset($tapen_s_adm->nama)  ? $tapen_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tapen_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tapen_s_admPm = isset($tapen_s_admPm->nama)  ? $tapen_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tapen_p_tek = isset($tapen_p_tek->nama)  ? $tapen_p_tek->nama : ''  ?>
                                <td><?= $tapen_p_tek ?></td>
                            </tr>
                            <?php foreach ($tapen_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tapen_s_tek = isset($tapen_s_tek->nama)  ? $tapen_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Prajekan-->
    <div class="modal fade" id="prajekan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="prajekan">UPK PRAJEKAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $prajekan = isset($prajekan->nama)  ? $prajekan->nama : ''  ?>
                                <td><?= $prajekan ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $prajekan_p_adm = isset($prajekan_p_adm->nama)  ? $prajekan_p_adm->nama : ''  ?>
                                <td><?= $prajekan_p_adm ?></td>
                            </tr>
                            <?php foreach ($prajekan_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $prajekan_s_adm = isset($prajekan_s_adm->nama)  ? $prajekan_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($prajekan_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $prajekan_s_admPm = isset($prajekan_s_admPm->nama)  ? $prajekan_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $prajekan_p_tek = isset($prajekan_p_tek->nama)  ? $prajekan_p_tek->nama : ''  ?>
                                <td><?= $prajekan_p_tek ?></td>
                            </tr>
                            <?php foreach ($prajekan_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $prajekan_s_tek = isset($prajekan_s_tek->nama)  ? $prajekan_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tlogosari-->
    <div class="modal fade" id="tlogosari" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tlogosari">UPK TLOGOSARI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tlogosari = isset($tlogosari->nama)  ? $tlogosari->nama : ''  ?>
                                <td><?= $tlogosari ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tlogosari_p_adm = isset($tlogosari_p_adm->nama)  ? $tlogosari_p_adm->nama : ''  ?>
                                <td><?= $tlogosari_p_adm ?></td>
                            </tr>
                            <?php foreach ($tlogosari_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tlogosari_s_adm = isset($tlogosari_s_adm->nama)  ? $tlogosari_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tlogosari_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tlogosari_s_admPm = isset($tlogosari_s_admPm->nama)  ? $tlogosari_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tlogosari_p_tek = isset($tlogosari_p_tek->nama)  ? $tlogosari_p_tek->nama : ''  ?>
                                <td><?= $tlogosari_p_tek ?></td>
                            </tr>
                            <?php foreach ($tlogosari_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tlogosari_s_tek = isset($tlogosari_s_tek->nama)  ? $tlogosari_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Wringin-->
    <div class="modal fade" id="wringin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="wringin">UPK WRINGIN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $wringin = isset($wringin->nama)  ? $wringin->nama : ''  ?>
                                <td><?= $wringin ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $wringin_p_adm = isset($wringin_p_adm->nama)  ? $wringin_p_adm->nama : ''  ?>
                                <td><?= $wringin_p_adm ?></td>
                            </tr>
                            <?php foreach ($wringin_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $wringin_s_adm = isset($wringin_s_adm->nama)  ? $wringin_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($wringin_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $wringin_s_admPm = isset($wringin_s_admPm->nama)  ? $wringin_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $wringin_p_tek = isset($wringin_p_tek->nama)  ? $wringin_p_tek->nama : ''  ?>
                                <td><?= $wringin_p_tek ?></td>
                            </tr>
                            <?php foreach ($wringin_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $wringin_s_tek = isset($wringin_s_tek->nama)  ? $wringin_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Curahdami-->
    <div class="modal fade" id="curahdami" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="curahdami">UPK CURAHDAMI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $curahdami = isset($curahdami->nama)  ? $curahdami->nama : ''  ?>
                                <td><?= $curahdami ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $curahdami_p_adm = isset($curahdami_p_adm->nama)  ? $curahdami_p_adm->nama : ''  ?>
                                <td><?= $curahdami_p_adm ?></td>
                            </tr>
                            <?php foreach ($curahdami_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $curahdami_s_adm = isset($curahdami_s_adm->nama)  ? $curahdami_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($curahdami_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $curahdami_s_admPm = isset($curahdami_s_admPm->nama)  ? $curahdami_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $curahdami_p_tek = isset($curahdami_p_tek->nama)  ? $curahdami_p_tek->nama : ''  ?>
                                <td><?= $curahdami_p_tek ?></td>
                            </tr>
                            <?php foreach ($curahdami_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $curahdami_s_tek = isset($curahdami_s_tek->nama)  ? $curahdami_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tamanan-->
    <div class="modal fade" id="tamanan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tamanan">UPK TAMANAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tamanan = isset($tamanan->nama)  ? $tamanan->nama : ''  ?>
                                <td><?= $tamanan ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tamanan_p_adm = isset($tamanan_p_adm->nama)  ? $tamanan_p_adm->nama : ''  ?>
                                <td><?= $tamanan_p_adm ?></td>
                            </tr>
                            <?php foreach ($tamanan_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tamanan_s_adm = isset($tamanan_s_adm->nama)  ? $tamanan_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tamanan_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tamanan_s_admPm = isset($tamanan_s_admPm->nama)  ? $tamanan_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tamanan_p_tek = isset($tamanan_p_tek->nama)  ? $tamanan_p_tek->nama : ''  ?>
                                <td><?= $tamanan_p_tek ?></td>
                            </tr>
                            <?php foreach ($tamanan_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tamanan_s_tek = isset($tamanan_s_tek->nama)  ? $tamanan_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tenggarang-->
    <div class="modal fade" id="tenggarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tenggarang">UPK TENGGARANG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tenggarang = isset($tenggarang->nama)  ? $tenggarang->nama : ''  ?>
                                <td><?= $tenggarang ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tenggarang_p_adm = isset($tenggarang_p_adm->nama)  ? $tenggarang_p_adm->nama : ''  ?>
                                <td><?= $tenggarang_p_adm ?></td>
                            </tr>
                            <?php foreach ($tenggarang_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tenggarang_s_adm = isset($tenggarang_s_adm->nama)  ? $tenggarang_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tenggarang_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tenggarang_s_admPm = isset($tenggarang_s_admPm->nama)  ? $tenggarang_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tenggarang_p_tek = isset($tenggarang_p_tek->nama)  ? $tenggarang_p_tek->nama : ''  ?>
                                <td><?= $tenggarang_p_tek ?></td>
                            </tr>
                            <?php foreach ($tenggarang_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tenggarang_s_tek = isset($tenggarang_s_tek->nama)  ? $tenggarang_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tamankrocok-->
    <div class="modal fade" id="tamankrocok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tamankrocok">UPK TAMANKROCOK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $tamankrocok = isset($tamankrocok->nama)  ? $tamankrocok->nama : ''  ?>
                                <td><?= $tamankrocok ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $tamankrocok_p_adm = isset($tamankrocok_p_adm->nama)  ? $tamankrocok_p_adm->nama : ''  ?>
                                <td><?= $tamankrocok_p_adm ?></td>
                            </tr>
                            <?php foreach ($tamankrocok_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $tamankrocok_s_adm = isset($tamankrocok_s_adm->nama)  ? $tamankrocok_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($tamankrocok_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $tamankrocok_s_admPm = isset($tamankrocok_s_admPm->nama)  ? $tamankrocok_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $tamankrocok_p_tek = isset($tamankrocok_p_tek->nama)  ? $tamankrocok_p_tek->nama : ''  ?>
                                <td><?= $tamankrocok_p_tek ?></td>
                            </tr>
                            <?php foreach ($tamankrocok_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $tamankrocok_s_tek = isset($tamankrocok_s_tek->nama)  ? $tamankrocok_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal wonosari-->
    <div class="modal fade" id="wonosari" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="wonosari">UPK WONOSARI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $wonosari = isset($wonosari->nama)  ? $wonosari->nama : ''  ?>
                                <td><?= $wonosari ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $wonosari_p_adm = isset($wonosari_p_adm->nama)  ? $wonosari_p_adm->nama : ''  ?>
                                <td><?= $wonosari_p_adm ?></td>
                            </tr>
                            <?php foreach ($wonosari_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $wonosari_s_adm = isset($wonosari_s_adm->nama)  ? $wonosari_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($wonosari_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $wonosari_s_admPm = isset($wonosari_s_admPm->nama)  ? $wonosari_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $wonosari_p_tek = isset($wonosari_p_tek->nama)  ? $wonosari_p_tek->nama : ''  ?>
                                <td><?= $wonosari_p_tek ?></td>
                            </tr>
                            <?php foreach ($wonosari_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $wonosari_s_tek = isset($wonosari_s_tek->nama)  ? $wonosari_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sukosari 2-->
    <div class="modal fade" id="suko2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="suko2">UPK SUKOSARI 2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">KA UPK</td>
                                <td> : </td>
                                <?php $suko2 = isset($suko2->nama)  ? $suko2->nama : ''  ?>
                                <td><?= $suko2 ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Pelaksana Administrasi</td>
                                <td> : </td>
                                <?php $suko2_p_adm = isset($suko2_p_adm->nama)  ? $suko2_p_adm->nama : ''  ?>
                                <td><?= $suko2_p_adm ?></td>
                            </tr>
                            <?php foreach ($suko2_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $suko2_s_adm = isset($suko2_s_adm->nama)  ? $suko2_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <?php foreach ($suko2_s_admPm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi Pembaca Meter</td>
                                    <td> : </td>
                                    <?php $suko2_s_admPm = isset($suko2_s_admPm->nama)  ? $suko2_s_admPm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Pelaksana Teknik</td>
                                <td> : </td>
                                <?php $suko2_p_tek = isset($suko2_p_tek->nama)  ? $suko2_p_tek->nama : ''  ?>
                                <td><?= $suko2_p_tek ?></td>
                            </tr>
                            <?php foreach ($suko2_s_tek as $row) : ?>
                                <tr>
                                    <td>Staf Teknik</td>
                                    <td> : </td>
                                    <?php $suko2_s_tek = isset($suko2_s_tek->nama)  ? $suko2_s_tek->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal amdk-->
    <div class="modal fade" id="amdk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="amdk">Unit A M D K</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="fw-bold">Manager</td>
                                <td> : </td>
                                <?php $amdk = isset($amdk->nama)  ? $amdk->nama : ''  ?>
                                <td><?= $amdk ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Quality Control</td>
                                <td> : </td>
                                <?php $amdk_qc = isset($amdk_qc->nama)  ? $amdk_qc->nama : ''  ?>
                                <td><?= $amdk_qc ?></td>
                            </tr>
                            <?php foreach ($amdk_s_qc as $row) : ?>
                                <tr>
                                    <td>Staf Quality Control</td>
                                    <td> : </td>
                                    <?php $amdk_s_qc = isset($amdk_s_qc->nama)  ? $amdk_s_qc->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kabag Produksi</td>
                                <td> : </td>
                                <?php $amdk_pro = isset($amdk_pro->nama)  ? $amdk_pro->nama : ''  ?>
                                <td><?= $amdk_pro ?></td>
                            </tr>
                            <?php foreach ($amdk_s_pro as $row) : ?>
                                <tr>
                                    <td>Staf Produksi</td>
                                    <td> : </td>
                                    <?php $amdk_s_pro = isset($amdk_s_pro->nama)  ? $amdk_s_pro->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kabag Administrasi dan Keu</td>
                                <td> : </td>
                                <?php $amdk_adm = isset($amdk_adm->nama)  ? $amdk_adm->nama : ''  ?>
                                <td><?= $amdk_adm ?></td>
                            </tr>
                            <?php foreach ($amdk_s_adm as $row) : ?>
                                <tr>
                                    <td>Staf Administrasi</td>
                                    <td> : </td>
                                    <?php $amdk_s_adm = isset($amdk_s_adm->nama)  ? $amdk_s_adm->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                            <tr>
                                <td class="fw-bold">Kabag Pemasaran</td>
                                <td> : </td>
                                <?php $amdk_pasar = isset($amdk_pasar->nama)  ? $amdk_pasar->nama : ''  ?>
                                <td><?= $amdk_pasar ?></td>
                            </tr>
                            <?php foreach ($amdk_s_pasar as $row) : ?>
                                <tr>
                                    <td>Staf Pemasaran</td>
                                    <td> : </td>
                                    <?php $amdk_s_pasar = isset($amdk_s_pasar->nama)  ? $amdk_s_pasar->nama : ''  ?>
                                    <td><?= $row->nama ?></td>
                                </tr>
                            <?php endforeach;  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>