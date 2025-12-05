<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/lr/laba_rugi') ?>" method="get">
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
                                <select name="upk" id="upk" class="form-control mr-2">
                                    <option value="">Konsolidasi</option>
                                    <option value="01" <?= ($this->input->get('upk') == '01') ? 'selected' : '' ?>>Bondowoso</option>
                                    <option value="02" <?= ($this->input->get('upk') == '02') ? 'selected' : '' ?>>Sukosari 1</option>
                                    <option value="03" <?= ($this->input->get('upk') == '03') ? 'selected' : '' ?>>Maesan</option>
                                    <option value="04" <?= ($this->input->get('upk') == '04') ? 'selected' : '' ?>>Tegalampel</option>
                                    <option value="05" <?= ($this->input->get('upk') == '05') ? 'selected' : '' ?>>Tapen</option>
                                    <option value="06" <?= ($this->input->get('upk') == '06') ? 'selected' : '' ?>>Prajekan</option>
                                    <option value="07" <?= ($this->input->get('upk') == '07') ? 'selected' : '' ?>>Tlogosari</option>
                                    <option value="08" <?= ($this->input->get('upk') == '08') ? 'selected' : '' ?>>Wringin</option>
                                    <option value="09" <?= ($this->input->get('upk') == '09') ? 'selected' : '' ?>>Curahdami</option>
                                    <option value="11" <?= ($this->input->get('upk') == '11') ? 'selected' : '' ?>>Tamanan</option>
                                    <option value="12" <?= ($this->input->get('upk') == '12') ? 'selected' : '' ?>>Tenggarang</option>
                                    <option value="13" <?= ($this->input->get('upk') == '13') ? 'selected' : '' ?>>AMDK</option>
                                    <option value="14" <?= ($this->input->get('upk') == '14') ? 'selected' : '' ?>>Tamankrocok</option>
                                    <option value="15" <?= ($this->input->get('upk') == '15') ? 'selected' : '' ?>>Wonosari</option>
                                    <option value="16" <?= ($this->input->get('upk') == '16') ? 'selected' : '' ?>>Klabang</option>
                                    <option value="22" <?= ($this->input->get('upk') == '22') ? 'selected' : '' ?>>Sukosari 2</option>
                                </select>
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/laba_rugi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/lr/laba_rugi/export_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/lr/laba_rugi/pajak') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Perhitungan Pajak</button> </a>
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
                                            <td>- Beban Sumber Air</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_sumber_air) ? $beban_sumber_air : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Pengolahan Air</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_pengolahan) ? $beban_pengolahan : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Transmisi dan Distribusi</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_transmisi) ? $beban_transmisi : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban (HPP) Sambungan Baru</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_sambungan) ? $beban_sambungan : array_fill(1, 12, 0);
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
                                                $v1 = isset($beban_sumber_air[$m]) ? $beban_sumber_air[$m] : 0;
                                                $v2 = isset($beban_pengolahan[$m]) ? $beban_pengolahan[$m] : 0;
                                                $v3 = isset($beban_transmisi[$m]) ? $beban_transmisi[$m] : 0;
                                                $v4 = isset($beban_sambungan[$m]) ? $beban_sambungan[$m] : 0;

                                                $subBeban = $v1 + $v2 + $v3 + $v4;
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


                                        <!-- BEBAN UMUM DAN ADMINISTRASI -->
                                        <tr>
                                            <td class="fw-bold">BEBAN UMUM DAN ADMINISTRASI</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Umum dan Administrasi</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_umum) ? $beban_umum : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">TOTAL BEBAN UMUM DAN ADMINISTRASI</td>
                                            <?php
                                            $totalBebanUmum = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($beban_umum[$m]) ? $beban_umum[$m] : 0;

                                                $subBebanUmum = $v1;
                                                $totalBebanUmum[$m] = $subBebanUmum; // simpan ke array
                                                $grand_total += $subBebanUmum;

                                                echo '<td class="text-end fw-bold">' . number_format($subBebanUmum, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">LABA / (RUGI) OPERASIONAL</td>
                                            <?php
                                            $totalLro = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalLabaRugi[$m]) ? $totalLabaRugi[$m] : 0;
                                                $v2 = isset($totalBebanUmum[$m]) ? $totalBebanUmum[$m] : 0;

                                                $labaRugiKotor = $v1 - $v2;
                                                $totalLro[$m] = $labaRugiKotor; // simpan ke array
                                                $grand_total += $labaRugiKotor;

                                                echo '<td class="text-end fw-bold">' . number_format($labaRugiKotor, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <!-- PENDAPATAN (BEBAN) NON OPERASIONAL -->
                                        <tr>
                                            <td class="fw-bold">PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Pendapatan Non Operasional</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($pendapatan_non_operasional) ? $pendapatan_non_operasional : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Beban Non Operasional</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($beban_non_operasional) ? $beban_non_operasional : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">JUMLAH PENDAPATAN (BEBAN) NON OPERASIONAL</td>
                                            <?php
                                            $totalPbno = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($pendapatan_non_operasional[$m]) ? $pendapatan_non_operasional[$m] : 0;
                                                $v2 = isset($beban_non_operasional[$m]) ? $beban_non_operasional[$m] : 0;

                                                $subPbno = $v1 - $v2;
                                                $totalPbno[$m] = $subPbno; // simpan ke array
                                                $grand_total += $subPbno;

                                                echo '<td class="text-end fw-bold">' . number_format($subPbno, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">LABA / (RUGI) SEBELUM PAJAK</td>
                                            <?php
                                            $totalLsp = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalLro[$m]) ? $totalLro[$m] : 0;
                                                $v2 = isset($totalPbno[$m]) ? $totalPbno[$m] : 0;

                                                $subLsp = $v1 + $v2;
                                                $totalLsp[$m] = $subLsp; // simpan ke array
                                                $grand_total += $subLsp;

                                                echo '<td class="text-end fw-bold">' . number_format($subLsp, 0, ',', '.') . '</td>';
                                            }
                                            ?>
                                            <td class="text-end fw-bold"><?= number_format($grand_total, 0, ',', '.') ?></td>
                                        </tr>

                                        <!-- LUAR BIASA -->
                                        <tr>
                                            <td class="fw-bold">KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                                            <td colspan="13 "></td>
                                        </tr>
                                        <tr>
                                            <td>- Keuntungan Luar Biasa</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($keuntungan_luar_biasa) ? $keuntungan_luar_biasa : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td>- Kerugian Luar Biasa</td>
                                            <?php
                                            $total = 0;
                                            $arr = isset($kerugian_luar_biasa) ? $kerugian_luar_biasa : array_fill(1, 12, 0);
                                            for ($m = 1; $m <= 12; $m++) :
                                                $v = isset($arr[$m]) ? $arr[$m] : 0;
                                                $total += $v;
                                            ?>
                                                <td class="text-end"><?= number_format($v, 0, ',', '.') ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold"><?= number_format($total, 0, ',', '.') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">JUMLAH KEUNTUNGAN/(KERUGIAN) LUAR BIASA</td>
                                            <?php
                                            $totalKlb = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($keuntungan_luar_biasa[$m]) ? $keuntungan_luar_biasa[$m] : 0;
                                                $v2 = isset($kerugian_luar_biasa[$m]) ? $kerugian_luar_biasa[$m] : 0;

                                                $subKlb = $v1 - $v2;
                                                $totalKlb[$m] = $subKlb; // simpan ke array
                                                $grand_total += $subKlb;

                                                echo '<td class="text-end fw-bold">' . number_format($subKlb, 0, ',', '.') . '</td>';
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
                                            $totalLrsp = array_fill(1, 12, 0);
                                            $grand_total = 0;

                                            for ($m = 1; $m <= 12; $m++) {
                                                $v1 = isset($totalLsp[$m]) ? $totalLsp[$m] : 0;
                                                $v2 = isset($totalKlb[$m]) ? $totalKlb[$m] : 0;
                                                $v3 = isset($pajak_25[$m]) ? $pajak_25[$m] : 0;
                                                $v4 = isset($pajak_kini[$m]) ? $pajak_kini[$m] : 0;
                                                $v5 = isset($pajak_tangguh[$m]) ? $pajak_tangguh[$m] : 0;

                                                $sublrsp = $v1 + $v2 - $v3 - $v4 - $v5;
                                                $totalLrsp[$m] = $sublrsp; // simpan ke array
                                                $grand_total += $sublrsp;

                                                echo '<td class="text-end fw-bold">' . number_format($sublrsp, 0, ',', '.') . '</td>';
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