<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <?php
                    // helper format
                    function rupiah($v)
                    {
                        return $v !== null && $v != 0 ? number_format((float)$v, 0, ',', '.') : '-';
                    }
                    function fmt_int($v)
                    {
                        return $v !== null && $v != 0 ? number_format((int)$v) : '-';
                    }

                    // bulan bahasa Indonesia (index 1..12)
                    $bulan_ind = [
                        1 => 'Januari', 2 => 'Pebruari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'
                    ];

                    // buat map nama bulan english -> index (karena model membuat label date('F'))
                    $bulan_en_map = [
                        'January' => 1, 'February' => 2, 'March' => 3, 'April' => 4, 'May' => 5, 'June' => 6,
                        'July' => 7, 'August' => 8, 'September' => 9, 'October' => 10, 'November' => 11, 'December' => 12
                    ];

                    // ambil $per_jenis, $overall_totals, $overall_grand, $tahun, $upk dari controller
                    // jika tidak ada validasi, set default
                    $per_jenis = isset($per_jenis) ? $per_jenis : [];
                    $overall_totals = isset($overall_totals) ? $overall_totals : array_fill(1, 12, 0.0);
                    $overall_grand = isset($overall_grand) ? $overall_grand : 0.0;
                    $tahun = isset($tahun) ? $tahun : date('Y');
                    $upk = isset($upk) ? $upk : null;

                    // judul dinamis
                    $judul_upk = 'KONSOLIDASI';
                    if ($upk) {
                        $rowupk = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
                        if ($rowupk) $judul_upk = strtoupper($rowupk->nama_upk);
                    }

                    // --- ambil lembar per bulan dari tabel rkap_pelanggan (sum p.jumlah) ---
                    // key: lembar_map[id_jp][bulan] = jumlah
                    $lembar_map = [];
                    $this->db->select("p.id_jp, p.bulan, SUM(p.jumlah) AS lembar_sum");
                    $this->db->from("rkap_pelanggan p");
                    $this->db->where("p.tahun", $tahun);
                    $this->db->where("p.id_kd", 6);
                    if ($upk) $this->db->where("p.id_upk", $upk);
                    $this->db->group_by(["p.id_jp", "p.bulan"]);
                    $lm_rows = $this->db->get()->result_array();
                    foreach ($lm_rows as $r) {
                        $id_jp = $r['id_jp'];
                        $bulan = (int)$r['bulan'];
                        $lembar_map[$id_jp][$bulan] = (int)$r['lembar_sum'];
                    }

                    // --- sekarang aggregate per jenis (id_jp) ---
                    // per_jenis currently keyed by id_upk||id_jp; we will aggregate by id_jp if $upk empty,
                    // otherwise show only entries for that upk but still ensure single jenis tampil (id_jp unique)

                    $aggregate = []; // key id_jp => aggregated block

                    foreach ($per_jenis as $block) {
                        // block contains 'id_upk', 'id_jp', 'rows' (including Th Lalu and month rows and 'Jumlah' possibly)
                        $id_jp = $block['id_jp'];
                        if (!$id_jp) continue;

                        if (!isset($aggregate[$id_jp])) {
                            // init
                            $aggregate[$id_jp] = [
                                'id_jp' => $id_jp,
                                'nama_jp' => $this->db->get_where('rkap_jenis_plgn', ['id_jp' => $id_jp])->row()->nama_jp ?? 'LAINNYA',
                                'thl_lembar' => 0,
                                'thl_rupiah' => 0.0,
                                'penerimaan' => array_fill(1, 12, 0.0), // aggregated penerimaan per month (from th lalu + distribusi tagihan)
                                'tagihan_per_month' => array_fill(1, 12, 0.0), // total tagihan per month (sum)
                                'lembar_per_month' => array_fill(1, 12, 0), // will fill from lembar_map
                                'total_penerimaan' => 0.0
                            ];
                        }

                        // iterate rows and accumulate (skip rows with label == 'Jumlah')
                        foreach ($block['rows'] as $r) {
                            $label = $r['label'];
                            if (strtolower(trim($label)) === 'jumlah') {
                                // ignore precomputed 'Jumlah' row from model to prevent double
                                continue;
                            }

                            if (strtolower(trim($label)) === strtolower('Th Lalu') || strtolower(trim($label)) === 'th lalu') {
                                // accumulate th lalu
                                $aggregate[$id_jp]['thl_lembar'] += (int)($r['lembar'] ?? 0);
                                $aggregate[$id_jp]['thl_rupiah'] += (float)($r['tagihan'] ?? 0.0);
                                // add penerimaan distribution (r['penerimaan'] is an array 1..12)
                                if (!empty($r['penerimaan']) && is_array($r['penerimaan'])) {
                                    for ($m = 1; $m <= 12; $m++) {
                                        $aggregate[$id_jp]['penerimaan'][$m] += (float)($r['penerimaan'][$m] ?? 0.0);
                                    }
                                }
                                $aggregate[$id_jp]['total_penerimaan'] += (float)($r['total'] ?? 0.0);
                            } else {
                                // likely month row (label = English month name or Indonesian)
                                // try to map to month index
                                $idx = null;
                                $labtrim = trim($label);
                                // check english map
                                if (isset($bulan_en_map[$labtrim])) {
                                    $idx = $bulan_en_map[$labtrim];
                                } else {
                                    // check Indonesian names
                                    $lower = strtolower($labtrim);
                                    foreach ($bulan_ind as $k => $v) {
                                        if (strtolower($v) === $lower || strtolower(substr($v, 0, 3)) === $lower) {
                                            $idx = $k;
                                            break;
                                        }
                                    }
                                }
                                if ($idx === null) {
                                    // unknown label, skip
                                    continue;
                                }

                                // accumulate tagihan (for that month)
                                $aggregate[$id_jp]['tagihan_per_month'][$idx] += (float)($r['tagihan'] ?? 0.0);

                                // penerimaan array: this row has penerimaan distributed to future months
                                if (!empty($r['penerimaan']) && is_array($r['penerimaan'])) {
                                    for ($m = 1; $m <= 12; $m++) {
                                        $aggregate[$id_jp]['penerimaan'][$m] += (float)($r['penerimaan'][$m] ?? 0.0);
                                    }
                                }
                                $aggregate[$id_jp]['total_penerimaan'] += (float)($r['total'] ?? 0.0);
                            }
                        }
                    }

                    // fill lembar_per_month from lembar_map (note: lembar_map keyed by id_jp)
                    foreach ($aggregate as $id_jp => &$ag) {
                        for ($m = 1; $m <= 12; $m++) {
                            $ag['lembar_per_month'][$m] = isset($lembar_map[$id_jp][$m]) ? (int)$lembar_map[$id_jp][$m] : 0;
                        }
                    }
                    unset($ag);

                    // if not memilih upk, we have already aggregated across all per_jenis passed by controller.
                    // But in case per_jenis still had separate per UPK entries, above loop already summed them into $aggregate by id_jp

                    // prepare grand totals from aggregate
                    $grand_per_month = array_fill(1, 12, 0.0);
                    $grand_sum_total = 0.0;
                    foreach ($aggregate as $id_jp => $ag) {
                        for ($m = 1; $m <= 12; $m++) {
                            $grand_per_month[$m] += $ag['penerimaan'][$m];
                        }
                        $grand_sum_total += $ag['total_penerimaan'];
                    }
                    ?>
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
                                <select name="upk" class="form-select select2">
                                    <option value="">Konsolidasi</option>
                                    <?php foreach ($list_upk as $row) : ?>
                                        <option value="<?= $row->id_upk ?>" <?= $upk == $row->id_upk ? 'selected' : '' ?>>
                                            <?= ucfirst($row->nama_upk) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="tahun_rkap" class="form-select" style="width: 90px; margin-left:10px;">
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
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Sisa Piutang Tahun Lalu</button> </a>
                        </div>
                        <?php if ($this->session->userdata('tipe') == 'admin') : ?>
                            <?php
                            $nama_pengguna  = $this->session->userdata('nama_pengguna');
                            $level = $this->session->userdata('level');
                            if (can_input($nama_pengguna, $level, $status_periode, $tahun)) : ?>
                                <div class="navbar-nav">
                                    <?php
                                    // pastikan nilai numerik murni (tanpa format)
                                    $grand_per_month_num = [];
                                    foreach ($grand_per_month as $m => $v) {
                                        $grand_per_month_num[$m] = is_numeric($v) ? $v : floatval(str_replace(['.', ','], '', $v));
                                    }
                                    ?>

                                    <form action="<?= base_url('lembar_kerja/arus_kas/penerimaan_air/generate') ?>" method="post">
                                        <input type="hidden" name="cabang_id" value="<?= $upk ?>">
                                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                        <?php for ($m = 1; $m <= 12; $m++) : ?>
                                            <input type="hidden" name="pagu[<?= $m ?>]" value="<?= $grand_per_month_num[$m] ?>">
                                        <?php endfor; ?>
                                        <button type="submit" class="neumorphic-button" onclick="return confirm('Yakin ingin generate ulang data penerimaan air tahun ini? Data lama akan terhapus!')">
                                            <i class="fas fa-sync-alt"></i> Generate Ke Arus Kas
                                        </button>
                                    </form>
                                </div>
                                <div class="navbar-nav ms-1">
                                    <button id="btnGenerate" class="neumorphic-button" style="font-size: 0.8rem; color:black;">
                                        Generate TA ke Arus Kas
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
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <h5 class="text-center fw-bold">
                                    RENCANA PENERIMAAN TAGIHAN REKENING AIR<br>
                                    <?= $judul_upk . " - TAHUN ANGGARAN " . $tahun ?>
                                </h5>
                                <table class="table table-bordered table-sm" style="font-size:0.75rem;">
                                    <thead class="text-center bg-light align-middle">
                                        <tr>
                                            <th rowspan="2" style="width:200px">URAIAN</th>
                                            <th rowspan="2" style="width:70px">Lbr</th>
                                            <th rowspan="2" style="width:110px">Rp</th>
                                            <th colspan="12">PENERIMAAN (Rp)</th>
                                            <th rowspan="2" style="width:120px">JUMLAH</th>
                                        </tr>
                                        <tr>
                                            <?php foreach ($bulan_ind as $b) : ?>
                                                <th style="width:90px;" class="text-center"><?= $b ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($aggregate)) : ?>
                                            <tr>
                                                <td colspan="16" class="text-center">-- Tidak ada data --</td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($aggregate as $id_jp => $ag) : ?>
                                                <tr class="table-primary fw-bold">
                                                    <td colspan="16"><?= strtoupper($ag['nama_jp']) ?></td>
                                                </tr>

                                                <!-- Baris Th Lalu -->
                                                <tr>
                                                    <td>&nbsp;&nbsp;- Th Lalu</td>
                                                    <td class="text-end"><?= fmt_int($ag['thl_lembar']) ?></td>
                                                    <td class="text-end"><?= $ag['thl_rupiah'] ? rupiah($ag['thl_rupiah']) : '-' ?></td>

                                                    <?php
                                                    $rupiah_lalu = (float)$ag['thl_rupiah'];
                                                    $penerimaan_th_lalu = array_fill(1, 12, 0.0);

                                                    if ($rupiah_lalu > 0) {
                                                        $penerimaan_th_lalu[1] = round($rupiah_lalu * 0.70, 2); // Januari
                                                        $sisa = $rupiah_lalu * 0.30;
                                                        $per_bulan = round($sisa / 10, 2);
                                                        for ($m = 2; $m <= 11; $m++) {
                                                            $penerimaan_th_lalu[$m] = $per_bulan;
                                                        }
                                                        // Desember = 0
                                                    }

                                                    $total_th_lalu = array_sum($penerimaan_th_lalu);
                                                    ?>

                                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                        <td class="text-end">
                                                            <?= $penerimaan_th_lalu[$m] != 0 ? rupiah($penerimaan_th_lalu[$m]) : '-' ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end fw-bold"><?= rupiah($total_th_lalu) ?></td>
                                                </tr>

                                                <!-- Baris Januari..Desember (lembar dari rkap_pelanggan, tagihan dari aggregated tagihan_per_month) -->
                                                <?php for ($m = 1; $m <= 12; $m++) :
                                                    $label = $bulan_ind[$m];
                                                    $lembar = $ag['lembar_per_month'][$m] ?? 0;
                                                    $tagihan = $ag['tagihan_per_month'][$m] ?? 0.0;
                                                    $penerimaan_row = array_fill(1, 12, 0.0);
                                                    if ($tagihan > 0 && $m < 12) {
                                                        $p1 = round($tagihan * 0.90, 2);
                                                        $p2 = round($tagihan * 0.10, 2);
                                                        $penerimaan_row[$m + 1] += $p1;
                                                        if ($m + 2 <= 12) $penerimaan_row[$m + 2] += $p2;
                                                        $row_total = $p1 + ($m + 2 <= 12 ? $p2 : 0.0);
                                                    } else {
                                                        // m == 12 or tagihan == 0
                                                        $row_total = 0.0;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;- <?= $label ?></td>
                                                        <td class="text-end"><?= $lembar ? number_format($lembar) : '-' ?></td>
                                                        <td class="text-end"><?= $tagihan ? rupiah($tagihan) : '-' ?></td>
                                                        <?php for ($mm = 1; $mm <= 12; $mm++) : ?>
                                                            <td class="text-end">
                                                                <?= $penerimaan_row[$mm] != 0 ? rupiah($penerimaan_row[$mm]) : '-' ?>
                                                            </td>
                                                        <?php endfor; ?>
                                                        <td class="text-end"><?= $row_total != 0 ? rupiah($row_total) : '-' ?></td>
                                                    </tr>
                                                <?php endfor; ?>

                                                <!-- Baris Jumlah per jenis -->
                                                <tr class="fw-bold table-secondary text-end">
                                                    <td class="text-start">Jumlah <?= strtoupper($ag['nama_jp']) ?></td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                        <td><?= rupiah($ag['penerimaan'][$m]) ?></td>
                                                    <?php endfor; ?>
                                                    <td><?= rupiah($ag['total_penerimaan']) ?></td>
                                                </tr>

                                            <?php endforeach; ?>

                                            <!-- TOTAL SEMUA JENIS -->
                                            <tr class="fw-bold table-info text-end">
                                                <td class="text-start">TOTAL </td>
                                                <td>-</td>
                                                <td>-</td>
                                                <?php for ($m = 1; $m <= 12; $m++) : ?>
                                                    <td><?= rupiah($grand_per_month[$m]) ?></td>
                                                <?php endfor; ?>
                                                <td><?= rupiah($grand_sum_total) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($upk == '') : ?>
                                <h5>Penerimaan Air Lainnya</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example4">
                                        <thead>
                                            <tr>
                                                <th class="text-center">URAIAN</th>
                                                <th class="text-center">Jan</th>
                                                <th class="text-center">Feb</th>
                                                <th class="text-center">Mar</th>
                                                <th class="text-center">Apr</th>
                                                <th class="text-center">Mei</th>
                                                <th class="text-center">Jun</th>
                                                <th class="text-center">Jul</th>
                                                <th class="text-center">Agu</th>
                                                <th class="text-center">Sep</th>
                                                <th class="text-center">Okt</th>
                                                <th class="text-center">Nov</th>
                                                <th class="text-center">Des</th>
                                                <th class="text-center">JUMLAH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uraian_list = [
                                                'penggunaan_rata2' => 'Jumlah Penggunaan rata2',
                                                'm3_rata2' => 'Jumlah M3 rata2',
                                                'tarif_rata2' => 'Tarif rata2'
                                            ];

                                            foreach ($uraian_list as $key => $label) :
                                                if (isset($tangki_air[$key])) :
                                                    $is_nilai_penjualan = ($key == 'nilai_penjualan');
                                            ?>
                                                    <!-- <tr>
                                                    <td style="padding-left: 27px;"><?= $is_nilai_penjualan ? "<strong>{$label}</strong>" : $label; ?></td>
                                                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                        <td class="text-end pe-1">
                                                            <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key][$i], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key][$i], 0, ',', '.'); ?>
                                                        </td>
                                                    <?php endfor; ?>

                                                    <td class="text-end pe-1">
                                                        <?= $is_nilai_penjualan ? "<strong>" . number_format($tangki_air[$key]['total'], 0, ',', '.') . "</strong>" : number_format($tangki_air[$key]['total'], 0, ',', '.'); ?>
                                                    </td>
                                                </tr> -->
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr style="background:#eee;font-weight:bold;">
                                                <td>Penerimaan Air Lainnya (TA)</td>
                                                <?php
                                                $grand_total = 0;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $total_bulan = $tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i];
                                                    echo "<td class='text-end pe-1'>" . number_format($total_bulan, 0, ',', '.') . "</td>";
                                                    $grand_total += $total_bulan;
                                                }
                                                ?>
                                                <td class="text-end pe-1"><?= number_format($grand_total, 0, ',', '.'); ?></td>
                                            </tr>
                                            <tr class="table-secondary fw-bold">
                                                <td>TOTAL PENERIMAAN AIR</td>
                                                <?php
                                                $grand_total_rkap = 0;
                                                for ($i = 1; $i <= 12; $i++) {
                                                    $total_bulan_rkap = $grand_per_month[$i] + ($tangki_air['penggunaan_rata2'][$i] * $tangki_air['m3_rata2'][$i] * $tangki_air['tarif_rata2'][$i]);
                                                    echo "<td class='text-end pe-1'>" . number_format($total_bulan_rkap, 0, ',', '.') . "</td>";
                                                    $grand_total_rkap += $total_bulan_rkap;
                                                }
                                                ?>
                                                <td class="text-end pe-1"><?= number_format($grand_total_rkap, 0, ',', '.'); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('btnGenerate').addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Yakin ingin Generate Data?',
                html: `
            <p style="font-size:18px; margin-top:10px;">
                Pastikan semua data <b>Penerimaan air lainnya</b> sudah <b>final</b> sebelum melakukan generate.
                <br><br>
                Proses ini akan <b>memasukkan data</b> ke <br> <b>LAPORAN ARUS KAS</b>.
            </p>
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Generate Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3 shadow-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke controller generate
                    window.location.href = "<?= base_url('lembar_kerja/arus_kas/penerimaan_air/generate_ta') ?>";
                }
            });
        });
    </script>