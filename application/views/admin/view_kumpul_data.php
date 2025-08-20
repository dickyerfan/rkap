<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="#" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?> PER TANGGAL : <?= date('d-m-Y') ?></a>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <h6>U P K</h6>
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama UPK</th>
                                        <th>Potensi SR</th>
                                        <th>Evaluasi UPK</th>
                                        <th>Usulan Investasi</th>
                                        <th>Usulan Barang</th>
                                        <th>Usulan Pemeliharaan</th>
                                        <!-- <th>Evaluasi AMDK</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($namaUpk as $row) :
                                        $SrMatched = false;
                                        $evaluasiMatched = false;
                                        $evaAmdkMatched = false;
                                        $barangMatched = false;
                                        $investasiMatched = false;
                                        $pemeliharaanMatched = false;

                                        foreach ($potensiSr as $sr) {
                                            if ($sr->bagian_upk == $row->upk_bagian) {
                                                $SrMatched = true;
                                                break;
                                            }
                                        }
                                        foreach ($evaluasiUpk as $evaluasi) {
                                            if ($evaluasi->bagian_upk == $row->upk_bagian) {
                                                $evaluasiMatched = true;
                                                break;
                                            }
                                        }
                                        foreach ($usulanBarang as $barang) {
                                            if ($barang->bagian_upk == $row->upk_bagian) {
                                                $barangMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($usulanInvestasi as $investasi) {
                                            if ($investasi->bagian_upk == $row->upk_bagian) {
                                                $investasiMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($usulanPemeliharaan as $pemeliharaan) {
                                            if ($pemeliharaan->bagian_upk == $row->upk_bagian) {
                                                $pemeliharaanMatched = true;
                                                break;
                                            }
                                        }
                                        foreach ($evaluasiAmdk as $evaAmdk) {
                                            if ($evaAmdk->bagian_upk == $row->upk_bagian) {
                                                $evaAmdkMatched = true;
                                                break;
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="fw-bold"><?= strtoupper($row->upk_bagian); ?></td>
                                            <td class="text-center fw-bold <?= $SrMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $SrMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $evaluasiMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $evaluasiMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $investasiMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $investasiMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $barangMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $barangMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $pemeliharaanMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $pemeliharaanMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <!-- <td class="text-center fw-bold <?= $evaAmdkMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $evaAmdkMatched ? 'Sudah' : '-'; ?></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center px-3">
                        <h6>B A G I A N</h6>
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Bagian</th>
                                        <th>Usulan Investasi</th>
                                        <th>Usulan Barang</th>
                                        <th>Usulan Pemeliharaan</th>
                                        <th>Permasalahan</th>
                                        <th>Evaluasi & Usulan</th>
                                        <th>Evaluasi AMDK</th>
                                        <th>Potensi AMDK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($namaBagian as $row) :
                                        $barangMatched = false;
                                        $investasiMatched = false;
                                        $pemeliharaanMatched = false;
                                        $masalahMatched = false;
                                        $evaluasiProgramMatched = false;
                                        $evaluasiAmdkMatched = false;
                                        $potensiAmdkMatched = false;
                                        foreach ($usulanBarang as $barang) {
                                            if ($barang->bagian_upk == $row->upk_bagian) {
                                                $barangMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($usulanInvestasi as $investasi) {
                                            if ($investasi->bagian_upk == $row->upk_bagian) {
                                                $investasiMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($usulanPemeliharaan as $pemeliharaan) {
                                            if ($pemeliharaan->bagian_upk == $row->upk_bagian) {
                                                $pemeliharaanMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($permasalahan as $masalah) {
                                            if ($masalah->bagian_upk == $row->upk_bagian) {
                                                $masalahMatched = true;
                                                break;
                                            }
                                        }

                                        foreach ($evaluasiProgram as $evapro) {
                                            if ($evapro->bagian_upk == $row->upk_bagian) {
                                                $evaluasiProgramMatched = true;
                                                break;
                                            }
                                        }
                                        foreach ($evaluasiAmdk as $evaamdk) {
                                            if ($evaamdk->bagian_upk == $row->upk_bagian) {
                                                $evaluasiAmdkMatched = true;
                                                break;
                                            }
                                        }
                                        foreach ($potensiAmdk as $potamdk) {
                                            if ($potamdk->bagian_upk == $row->upk_bagian) {
                                                $potensiAmdkMatched = true;
                                                break;
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="fw-bold"><?= strtoupper($row->upk_bagian); ?></td>
                                            <td class="text-center fw-bold <?= $investasiMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $investasiMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $barangMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $barangMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $pemeliharaanMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $pemeliharaanMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $masalahMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $masalahMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $evaluasiProgramMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $evaluasiProgramMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $evaluasiAmdkMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $evaluasiAmdkMatched ? 'Sudah' : 'Belum'; ?></td>
                                            <td class="text-center fw-bold <?= $potensiAmdkMatched ? 'sudah-class' : ''; ?>" style="color:red;"><?= $potensiAmdkMatched ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>