<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Filter</a>
                        <form action="<?= base_url('lembar_kerja/rkap_amdk/laba_rugi_amdk') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <?php
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/rkap_amdk/laba_rugi_amdk') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/rkap_amdk/laba_rugi_amdk/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
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
                                        <!-- PENDAPATAN -->
                                        <tr>
                                            <td class="fw-bold">PENDAPATAN USAHA</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Pendapatan Air</td>
                                            <?php
                                            $total = 0;
                                            // pastikan array ber-index 1..12
                                            $arr = isset($pendapatan_air) ? $pendapatan_air : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        <tr>
                                            <td>- Pendapatan Non Air</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pendapatan_non_air) ? $pendapatan_non_air : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Pendapatan Usaha Lainnya</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pendapatan_usaha_lainnya) ? $pendapatan_usaha_lainnya : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">TOTAL PENDAPATAN USAHA</td>
                                            <?php
                                            $totalPendapatanUsaha = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($pendapatan_air[$m]) ? $pendapatan_air[$m] : 0;
                                                $v2 = isset($pendapatan_non_air[$m]) ? $pendapatan_non_air[$m] : 0;
                                                $v3 = isset($pendapatan_usaha_lainnya[$m]) ? $pendapatan_usaha_lainnya[$m] : 0;

                                                $subPendapatan = $v1 + $v2 + $v3;
                                                $totalPendapatanUsaha[$m] = $subPendapatan; // simpan ke array
                                                $grand_total += $subPendapatan;

                                                echo '<td class="text-end fw-bold">' . number_format($subPendapatan, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <!-- BEBAN USAHA -->
                                        <tr>
                                            <td class="fw-bold">BEBAN USAHA</td>
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
                                            <td>- Beban BBM</td>
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
                                            <td>- Beban Pemakaian</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pemakaian) ? $beban_pemakaian : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Rupa - Rupa</td>
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
                                            $arr = isset($beban_amdk_lain) ? $beban_amdk_lain : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Penyusutan</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_penyusutan) ? $beban_penyusutan : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Penghapusan Piutang</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_penghps_piutang) ? $beban_penghps_piutang : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Kerusakan</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_kerusakan) ? $beban_kerusakan : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pengurusan Surat</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pengurusan_surat) ? $beban_pengurusan_surat : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban SPPD</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_sppd) ? $beban_sppd : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">TOTAL BEBAN USAHA</td>
                                            <?php
                                            $totalBebanUsaha = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($beban_pegawai[$m]) ? $beban_pegawai[$m] : 0;
                                                $v2 = isset($beban_bbm[$m]) ? $beban_bbm[$m] : 0;
                                                $v3 = isset($beban_kantor[$m]) ? $beban_kantor[$m] : 0;
                                                $v4 = isset($beban_pemeliharaan[$m]) ? $beban_pemeliharaan[$m] : 0;
                                                $v5 = isset($beban_pemakaian[$m]) ? $beban_pemakaian[$m] : 0;
                                                $v6 = isset($beban_rupa_rupa[$m]) ? $beban_rupa_rupa[$m] : 0;
                                                $v7 = isset($beban_pemeriksaan_sni[$m]) ? $beban_pemeriksaan_sni[$m] : 0;
                                                $v8 = isset($beban_uji_kualitas_air[$m]) ? $beban_uji_kualitas_air[$m] : 0;
                                                $v9 = isset($beban_amdk_lain[$m]) ? $beban_amdk_lain[$m] : 0;
                                                $v10 = isset($beban_penyusutan[$m]) ? $beban_penyusutan[$m] : 0;
                                                $v11 = isset($beban_penghps_piutang[$m]) ? $beban_penghps_piutang[$m] : 0;
                                                $v12 = isset($beban_kerusakan[$m]) ? $beban_kerusakan[$m] : 0;
                                                $v13 = isset($beban_pengurusan_surat[$m]) ? $beban_pengurusan_surat[$m] : 0;
                                                $v14 = isset($beban_sppd[$m]) ? $beban_sppd[$m] : 0;

                                                $subBeban = $v1 + $v2 + $v3 + $v4 + $v5 + $v6 + $v7 + $v8 + $v9 + $v10 + $v11 + $v12 + $v13 + $v14;
                                                $totalBebanUsaha[$m] = $subBeban; // simpan ke array
                                                $grand_total += $subBeban;

                                                echo '<td class="text-end fw-bold">' . number_format($subBeban, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">LABA / (RUGI) KOTOR</td>
                                            <?php
                                            $totalLabaRugi = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalPendapatanUsaha[$m]) ? $totalPendapatanUsaha[$m] : 0;
                                                $v2 = isset($totalBebanUsaha[$m]) ? $totalBebanUsaha[$m] : 0;

                                                $labaRugiKotor = $v1 - $v2;
                                                $totalLabaRugi[$m] = $labaRugiKotor; // simpan ke array
                                                $grand_total += $labaRugiKotor;

                                                echo '<td class="text-end fw-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">PAJAK PENGHASILAN</td>
                                            <td colspan="13 "></td>
                                        </tr>

                                        <!-- PAJAK -->
                                        <tr>
                                            <td>- Taksiran Pajak (Pasal 25)</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pajak_25) ? $pajak_25 : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Pajak Kini</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pajak_kini) ? $pajak_kini : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pajak Ditangguhkan</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pajak_tangguh) ? $pajak_tangguh : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">LABA / (RUGI) SETELAH PAJAK</td>
                                            <?php
                                            $lrb = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalLabaRugi[$m]) ? $totalLabaRugi[$m] : 0;
                                                $v2 = isset($pajak_25[$m]) ? $pajak_25[$m] : 0;
                                                $v3 = isset($pajak_kini[$m]) ? $pajak_kini[$m] : 0;
                                                $v4 = isset($pajak_tangguh[$m]) ? $pajak_tangguh[$m] : 0;

                                                $hasil = $v1 - $v2 - $v3 - $v4;
                                                $lrb[$m] = $hasil; // simpan ke array
                                                $grand_total += $hasil;

                                                echo '<td class="text-end fw-bold">' . number_format($hasil, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
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