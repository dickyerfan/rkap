<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_air') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
                                $upk = isset($upk) ? $upk : '';
                                $tahun_sekarang = date('Y') + 1;
                                $tahun_rkap = isset($tahun_rkap) ? (int)$tahun_rkap : $tahun_sekarang;

                                $tahun_mulai = $tahun_sekarang - 10;
                                $tahun_selesai = $tahun_sekarang;

                                if ($tahun_rkap > $tahun_sekarang) {
                                    $tahun_selesai = $tahun_rkap;
                                }
                                ?>
                                <select name="upk" class="form-select select2" style="width: 150px;">
                                    <option value="">KONSOLIDASI</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) : ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun_rkap ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>

                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Penerimaan Tahun Lalu</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php if (!empty($upk)) : ?>
                                <form method="post" action="<?= site_url('lembar_kerja/arus_kas/penerimaan_air/generate_rekap'); ?>">
                                    <input type="hidden" name="upk" value="<?= $upk; ?>">
                                    <input type="hidden" name="tahun" value="<?= $tahun; ?>">
                                    <button type="submit" class="neumorphic-button">
                                        <i class="fa fa-database"></i> Generate Data
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <?php
                                // helper fungsi untuk format rupiah
                                function rupiah($nilai)
                                {
                                    return $nilai != 0 ? number_format($nilai, 0, ',', '.') : '-';
                                }

                                // Label bulan Indonesia
                                $bulan_ind = [
                                    1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'
                                ];
                                ?>
                                <table class="table table-bordered table-sm" style="font-size:0.75rem;">
                                    <thead class="text-center align-middle bg-light">
                                        <tr>
                                            <th rowspan="2" style="width:180px;">URAIAN</th>
                                            <th colspan="2">TAGIHAN</th>
                                            <th colspan="12">PENERIMAAN (Rp)</th>
                                            <th rowspan="2" style="width:120px;">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <th style="width:60px;">Lbr</th>
                                            <th style="width:100px;">Rp</th>
                                            <?php foreach ($bulan_ind as $b) : ?>
                                                <th><?= $b ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $grand_total = array_fill(1, 12, 0.0);
                                        $grand_total_sum = 0.0;

                                        foreach ($per_jenis as $jenis_block) :
                                            $nama_jenis = $this->db->get_where('rkap_jenis_plgn', ['id_jp' => $jenis_block['id_jp']])->row('nama_jp');
                                        ?>
                                            <tr class="table-primary fw-bold">
                                                <td colspan="16"><?= strtoupper($nama_jenis) ?></td>
                                            </tr>

                                            <?php foreach ($jenis_block['rows'] as $row) : ?>
                                                <tr>
                                                    <td><?= $row['label'] ?></td>
                                                    <td class="text-end"><?= $row['lembar'] ? number_format($row['lembar']) : '-' ?></td>
                                                    <td class="text-end"><?= $row['tagihan'] ? rupiah($row['tagihan']) : '-' ?></td>

                                                    <?php foreach ($bulan_ind as $i => $b) : ?>
                                                        <td class="text-end">
                                                            <?= $row['penerimaan'][$i] != 0 ? rupiah($row['penerimaan'][$i]) : '-' ?>
                                                        </td>
                                                    <?php endforeach; ?>

                                                    <td class="text-end fw-bold"><?= $row['total'] != 0 ? rupiah($row['total']) : '-' ?></td>
                                                </tr>
                                            <?php endforeach; ?>

                                            <!-- JUMLAH per jenis pelanggan -->
                                            <!-- <tr class="fw-bold text-end table-secondary">
                                                <td class="text-start">Jumlah <?= strtoupper($nama_jenis) ?></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <?php for ($b = 1; $b <= 12; $b++) : ?>
                                                    <td><?= rupiah($jenis_block['subtotal'][$b]) ?></td>
                                                <?php endfor; ?>
                                                <td><?= rupiah($jenis_block['subtotal_total']) ?></td>
                                            </tr> -->

                                            <?php
                                            // tambahkan ke total keseluruhan
                                            for ($b = 1; $b <= 12; $b++) {
                                                $grand_total[$b] += $jenis_block['subtotal'][$b];
                                            }
                                            $grand_total_sum += $jenis_block['subtotal_total'];
                                            ?>

                                        <?php endforeach; ?>

                                        <!-- TOTAL SELURUH JENIS -->
                                        <tr class="fw-bold text-end table-info">
                                            <td class="text-start">TOTAL SEMUA JENIS PELANGGAN</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <?php for ($b = 1; $b <= 12; $b++) : ?>
                                                <td><?= rupiah($grand_total[$b]) ?></td>
                                            <?php endfor; ?>
                                            <td><?= rupiah($grand_total_sum) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>