<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('admin/rekap_sr') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <select name="tahun" class="form-select" style="width: 100px;">
                                    <?php
                                    $mulai = date('Y') - 2;
                                    for ($i = $mulai; $i < $mulai + 11; $i++) {
                                        $sel = $i == date('Y') ? ' selected="selected"' : '';
                                        echo '<option value="' . $i . '"' . $sel . '>' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <!-- <a class="nav-link fw-bold" href="#" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a> -->
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('admin/rekap_sr/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                </div>

                <div class="card-body">
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-6 text-center">
                            <h5><?= $title . ' ' .  $tahun + 1; ?></h5>
                        </div>
                    </div>

                    <table class="table table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama UPK</th>
                                <th>Total Potensi SR</th>
                                <th>Asumsi SR <?= $tahun; ?></th>
                            </tr>
                        </thead>
                        <!-- <tbody>
                            <?php
                            $no = 1;
                            foreach ($rekap_sr as $row) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-left"><?= htmlspecialchars(strtoupper($row->bagian_upk)); ?></td>
                                    <td class="text-center"><?= number_format($row->total_sr, 0, ',', '.'); ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th colspan="2">Total</th>
                                <th><?= number_format(array_sum(array_column($rekap_sr, 'total_sr')), 0, ',', '.'); ?></th>
                                <th></th>
                            </tr>
                        </tfoot> -->
                        <tbody>
                            <?php
                            $no = 1;
                            $total_sr = 0;
                            $total_asumsi = 0;
                            foreach ($rekap_sr as $row) :
                                $total_sr += $row->total_sr;
                                $total_asumsi += $row->asumsi_sr;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-left"><?= htmlspecialchars(strtoupper($row->bagian_upk)); ?></td>
                                    <td class="text-center"><?= number_format($row->total_sr, 0, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($row->asumsi_sr, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <th colspan="2">Total</th>
                                <th><?= number_format($total_sr, 0, ',', '.'); ?></th>
                                <th><?= number_format($total_asumsi, 0, ',', '.'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>