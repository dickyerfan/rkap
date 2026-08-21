<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;"><?= strtoupper($title) . ' ' . $tahun; ?></a>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/beban_sumber?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;">
                                <button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' . $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead class="text-center align-middle">
                                        <tr>
                                            <th colspan="2">PERKIRAAN</th>
                                            <th>UPK</th>
                                            <th colspan="12">B U L A N</th>
                                            <th rowspan="2">JUMLAH</th>
                                            <th rowspan="2">ACTION</th>
                                        </tr>
                                        <tr>
                                            <th>KODE</th>
                                            <th>NAMA</th>
                                            <th>BAGIAN</th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Agu</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Des</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $grand_total = [
                                            'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0, 'jul' => 0,
                                            'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0, 'jumlah' => 0
                                        ];
                                        ?>
                                        <?php if (!empty($detail)) : ?>
                                            <?php foreach ($detail as $row) : ?>
                                                <tr>
                                                    <td><?= $row['kode']; ?></td>
                                                    <td><?= $row['uraian']; ?></td>
                                                    <td><?= $row['upk']; ?></td>
                                                    <td class="text-end"><?= number_format($row['jan'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['feb'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['mar'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['apr'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['mei'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['jun'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['jul'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['agu'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['sep'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['okt'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['nov'], 0, ',', '.'); ?></td>
                                                    <td class="text-end"><?= number_format($row['des'], 0, ',', '.'); ?></td>
                                                    <td class="text-end fw-bold"><?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                                                    <td class="text-center">
                                                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                                                            <?php
                                                            $nama_pengguna = $this->session->userdata('nama_pengguna');
                                                            $level = $this->session->userdata('level');
                                                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                                                <a href="<?= base_url('lembar_kerja/lr/beban_sumber/edit/' . urlencode(base64_encode($row['unique_key']))) ?>" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $grand_total['jan'] += $row['jan'];
                                                $grand_total['feb'] += $row['feb'];
                                                $grand_total['mar'] += $row['mar'];
                                                $grand_total['apr'] += $row['apr'];
                                                $grand_total['mei'] += $row['mei'];
                                                $grand_total['jun'] += $row['jun'];
                                                $grand_total['jul'] += $row['jul'];
                                                $grand_total['agu'] += $row['agu'];
                                                $grand_total['sep'] += $row['sep'];
                                                $grand_total['okt'] += $row['okt'];
                                                $grand_total['nov'] += $row['nov'];
                                                $grand_total['des'] += $row['des'];
                                                $grand_total['jumlah'] += $row['jumlah'];
                                                ?>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="16" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot class="fw-bold" style="background-color: #e9ecef; border-top: 2px solid #6c757d;">
                                        <tr>
                                            <td colspan="3">JUMLAH <?= strtoupper($nama_akun); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jan'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['feb'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mar'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['apr'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['mei'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jun'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jul'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['agu'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['sep'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['okt'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['nov'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['des'], 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($grand_total['jumlah'], 0, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
