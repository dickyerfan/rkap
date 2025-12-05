<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk') ?>" method="get">
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
                                <select name="tahun_rkap" class="form-select" style="width: 120px; margin-left:10px;">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav ms-2">
                                    <button class="neumorphic-button" data-bs-toggle="modal" data-bs-target="#modalInput">
                                        <i class="fas fa-plus"></i> Input Saldo Awal
                                    </button>
                                </div>
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
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example3">
                                    <thead>
                                        <tr class="text-center">
                                            <th>URAIAN</th>
                                            <th>Jan</th>
                                            <th>Feb</th>
                                            <th>Mar</th>
                                            <th>Apr</th>
                                            <th>Mei</th>
                                            <th>Jun</th>
                                            <th>Jul</th>
                                            <th>Ags</th>
                                            <th>Sep</th>
                                            <th>Okt</th>
                                            <th>Nov</th>
                                            <th>Des</th>
                                            <th>JUMLAH</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- PENERIMAAN -->
                                        <tr>
                                            <td class="fw-bold">PENERIMAAN</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Penerimaan dari Pendapatan Air</td>
                                            <?php
                                            $total = 0;
                                            // pastikan array ber-index 1..12
                                            $arr = isset($penerimaan_air) ? $penerimaan_air : array_fill(1, 12, 0);
                                            $arr2 = isset($penerimaan_non_air) ? $penerimaan_non_air : array_fill(1, 12, 0);
                                            $arr3 = isset($penerimaan_lain_lain) ? $penerimaan_lain_lain : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $v2 = isset($arr2[$m]) ? $arr2[$m] : 0;
                                                $v3 = isset($arr3[$m]) ? $arr3[$m] : 0;
                                                $v4 = $v - $v2 - $v3;
                                                $total += $v4;
                                            ?>
                                                <td class="text-end"><?= number_format($v4, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        <tr>
                                            <td>- Penerimaan dari Pendapatan Non Air</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($penerimaan_non_air) ? $penerimaan_non_air : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Penerimaan dari Pendapatan Lain-lain</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($penerimaan_lain_lain) ? $penerimaan_lain_lain : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Penerimaan Aktiva Lancar lainnya</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($penerimaan_aktiva_lainnya) ? $penerimaan_aktiva_lainnya : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">JUMLAH PENERIMAAN</td>
                                            <?php
                                            $totalPenerimaan = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($penerimaan_air[$m]) ? $penerimaan_air[$m] : 0;
                                                $v2 = isset($penerimaan_non_air[$m]) ? $penerimaan_non_air[$m] : 0;
                                                $v3 = isset($penerimaan_aktiva_lainnya[$m]) ? $penerimaan_aktiva_lainnya[$m] : 0;
                                                $v4 = isset($penerimaan_lain_lain[$m]) ? $penerimaan_lain_lain[$m] : 0;

                                                $subPenerimaan = ($v1 - $v2 - $v3) + $v2 + $v3 + $v4;
                                                $totalPenerimaan[$m] = $subPenerimaan; // simpan ke array
                                                $grand_total += $subPenerimaan;

                                                echo '<td class="text-end fw-bold">' . number_format($subPenerimaan, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <!-- PENGELUARAN -->
                                        <tr>
                                            <td class="fw-bold">PENGELUARAN</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pegawai</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pegawai) ? $beban_pegawai : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban B B M</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_bbm) ? $beban_bbm : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Kantor</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_kantor) ? $beban_kantor : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pemeliharaan</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pemeliharaan) ? $beban_pemeliharaan : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pemakaian Barang AMDK</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pemakaian_barang_amdk) ? $beban_pemakaian_barang_amdk : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Rupa-rupa</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_rupa_rupa) ? $beban_rupa_rupa : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pemeriksaan SNI</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pemeriksaan_sni) ? $beban_pemeriksaan_sni : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Uji Kualitas Air</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_uji_kualitas_air) ? $beban_uji_kualitas_air : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban AMDK Lainnya</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_amdk_lainnya) ? $beban_amdk_lainnya : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">JUMLAH PENGELUARAN</td>
                                            <?php
                                            $totalBebanUsaha = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($beban_pegawai[$m]) ? $beban_pegawai[$m] : 0;
                                                $v2 = isset($beban_bbm[$m]) ? $beban_bbm[$m] : 0;
                                                $v3 = isset($beban_kantor[$m]) ? $beban_kantor[$m] : 0;
                                                $v4 = isset($beban_pemeliharaan[$m]) ? $beban_pemeliharaan[$m] : 0;
                                                $v5 = isset($beban_pemakaian_barang_amdk[$m]) ? $beban_pemakaian_barang_amdk[$m] : 0;
                                                $v6 = isset($beban_rupa_rupa[$m]) ? $beban_rupa_rupa[$m] : 0;
                                                $v7 = isset($beban_pemeriksaan_sni[$m]) ? $beban_pemeriksaan_sni[$m] : 0;
                                                $v8 = isset($beban_uji_kualitas_air[$m]) ? $beban_uji_kualitas_air[$m] : 0;
                                                $v9 = isset($beban_amdk_lainnya[$m]) ? $beban_amdk_lainnya[$m] : 0;

                                                $subBeban = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8 + $v9;
                                                $totalBebanUsaha[$m] = $subBeban; // simpan ke array
                                                $grand_total += $subBeban;

                                                echo '<td class="text-end fw-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">ARUS KAS DARI AKTIVITAS INVESTASI</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Penambahan Aset Tetap</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($penambahan_aset_tetap) ? $penambahan_aset_tetap : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Arus Kas Bersih digunakan Investasi</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($investasi) ? $investasi : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">ARUS KAS DARI AKTIVITAS PENDANAAN</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Pembayaran Jasa Produksi dan Tantiem</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($jasa_produksi) ? $jasa_produksi : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">ARUS KAS BERSIH UNTUK AKTIVITAS PENDANAAN</td>
                                            <?php
                                            $totalInvestasi = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($penambahan_aset_tetap[$m]) ? $penambahan_aset_tetap[$m] : 0;
                                                $v2 = isset($investasi[$m]) ? $investasi[$m] : 0;
                                                $v3 = isset($jasa_produksi[$m]) ? $jasa_produksi[$m] : 0;

                                                $sublrsp = $v1 + $v2 + $v3;
                                                $totalInvestasi[$m] = $sublrsp; // simpan ke array
                                                $grand_total += $sublrsp;

                                                echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">KENAIKAN /BERKURANG BERSIH KAS & SETARA KAS</td>
                                            <?php
                                            $total_kotor = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalPenerimaan[$m]) ? $totalPenerimaan[$m] : 0;
                                                $v2 = isset($totalBebanUsaha[$m]) ? $totalBebanUsaha[$m] : 0;
                                                $v3 = isset($totalInvestasi[$m]) ? $totalInvestasi[$m] : 0;

                                                $sublrsp = $v1 - $v2 - $v3;
                                                $total_kotor[$m] = $sublrsp; // simpan ke array
                                                $grand_total += $sublrsp;

                                                echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>
                                        <?php
                                        // inisialisasi
                                        $saldo_awal = array_fill(1, 12, 0);
                                        $saldo_akhir = array_fill(1, 12, 0);

                                        // set saldo awal Januari dari DB
                                        $saldo_awal[1] = isset($saldo_awal_tahun) ? (float)$saldo_awal_tahun : 0;

                                        // hitung berurutan: untuk m = 1..12 => saldo_akhir[m] = saldo_awal[m] + total_kotor[m]
                                        // lalu saldo_awal[m+1] = saldo_akhir[m] (kecuali m=12)
                                        for ($m = 1; $m <= 12; $m++) {
                                            $tk = isset($total_kotor[$m]) ? (float)$total_kotor[$m] : 0;
                                            $saldo_akhir[$m] = $saldo_awal[$m] + $tk;

                                            if ($m < 12) {
                                                // untuk bulan berikutnya
                                                $saldo_awal[$m + 1] = $saldo_akhir[$m];
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <td class="fw-bold">SALDO KAS SETARA KAS AWAL TAHUN</td>
                                            <?php
                                            for ($m = 1; $m <= 12; $m++) {
                                                echo '<td class="text-end fw-bold">' . number_format($saldo_awal[$m], 0, ',', '.') . '</td>';
                                            }
                                            // Jumlah di sebelah kanan menampilkan saldo awal tahun (saldo_awal[1])
                                            echo '<td class="text-end fw-bold">' . number_format($saldo_awal[1], 0, ',', '.') . '</td>';
                                            ?>
                                        </tr>

                                        <!-- Tampilkan: SALDO KAS SETARA KAS AKHIR TAHUN -->
                                        <tr>
                                            <td class="fw-bold">SALDO KAS SETARA KAS AKHIR TAHUN</td>
                                            <?php
                                            for ($m = 1; $m <= 12; $m++) {
                                                echo '<td class="text-end fw-bold">' . number_format($saldo_akhir[$m], 0, ',', '.') . '</td>';
                                            }
                                            // Jumlah di kanan: saldo akhir Desember
                                            echo '<td class="text-end fw-bold">' . number_format($saldo_akhir[12], 0, ',', '.') . '</td>';
                                            ?>
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

    <!-- Modal Input RKAP -->
    <div class="modal fade" id="modalInput" tabindex="-1" aria-labelledby="modalInputLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="<?= base_url('lembar_kerja/rkap_amdk/arus_kas_amdk/simpan_saldo') ?>">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalInputLabel">Input Saldo Awal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="form-control" value="<?= $tahun ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Saldo Awal (Rp)</label>
                            <input type="number" name="pagu" class="form-control" placeholder="Masukkan nilai Saldo Awal" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="neumorphic-button" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="neumorphic-button">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>