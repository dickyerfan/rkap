<?php if ($this->session->userdata('level') != 'Admin') redirect('auth');
$bulanIndo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$tsTanggal = strtotime($header->tanggal ?? '');
$tanggalTampil = $tsTanggal ? ((int)date('j', $tsTanggal)) . ' ' . $bulanIndo[(int)date('n', $tsTanggal)] . ' ' . date('Y', $tsTanggal) : (string)($header->tanggal ?? '');
$valJurnal = function ($v) {
    $n = (float)$v;
    if ($n == 0) return '';
    return number_format($n, $n == floor($n) ? 0 : 2, ',', '.');
};
$fmtJurnal = function ($v) {
    return number_format((float)$v, 0, ',', '.');
};

$baris = [];
foreach ($lines as $line) {
    $baris[] = ['g' => trim((string)($line->kelompok ?? '')) ?: 'JU', 'line' => $line];
}
$grup = [];
$giAktif = -1;
foreach ($baris as $i => $b) {
    $g = $b['g'];
    if ($giAktif < 0 || $grup[$giAktif]['g'] !== $g) {
        $grup[] = ['g' => $g, 'idx' => [], 'debit' => 0, 'kredit' => 0];
        $giAktif = count($grup) - 1;
    }
    $grup[$giAktif]['idx'][] = $i;
    $grup[$giAktif]['debit'] += (float)$b['line']->debit;
    $grup[$giAktif]['kredit'] += (float)$b['line']->kredit;
}
$urutGrup = [];
foreach ($grup as $k => $g) foreach ($g['idx'] as $i) $urutGrup[$i] = $k;

$rekapKelompok = [];
foreach ($baris as $b) {
    $g = $b['g'];
    if (!isset($rekapKelompok[$g])) $rekapKelompok[$g] = ['n' => 0, 'debit' => 0, 'kredit' => 0];
    $rekapKelompok[$g]['n']++;
    $rekapKelompok[$g]['debit'] += (float)$b['line']->debit;
    $rekapKelompok[$g]['kredit'] += (float)$b['line']->kredit;
}

$subtotalDariBaris = function ($gi) use ($grup) {
    return ['g' => $grup[$gi]['g'], 'debit' => $grup[$gi]['debit'], 'kredit' => $grup[$gi]['kredit'], 'selisih' => $grup[$gi]['debit'] - $grup[$gi]['kredit']];
};
?>
<style>
    .journal-num {
        text-align: right;
    }

    .header-static {
        font-size: 0.85rem;
        font-weight: 600;
        min-height: 31px;
        padding: 6px 0;
        color: #212529;
    }

    #journal-body tr.subtotal-row td {
        background-color: #eef2f7;
        font-size: 0.72rem;
        padding: 3px 6px;
    }

    #journal-body tr.subtotal-row td.sub-selisih {
        white-space: nowrap;
    }

    .badge-bal {
        background-color: #198754;
        color: #fff;
    }

    .badge-unbal {
        background-color: #dc3545;
        color: #fff;
    }

    .sub-label {
        letter-spacing: 0.05em;
    }
</style>
<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="p-2"><?= $this->session->flashdata('info'); ?></div>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/jurnal_rkap/v2') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = date('Y') - 3; $i <= date('Y') + 3; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/jurnal_rkap/v2') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/jurnal_rkap') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Buka Versi Lama</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5>JURNAL RKAP TAHUN <?= $tahun ?> <span class="badge bg-secondary" style="font-size:0.6rem;vertical-align:middle;">VERSI 2</span></h5>
                        </div>
                    </div>

                    <div class="card mb-3" style="border:1px solid #d9dee5;">
                        <div class="card-header fw-bold" style="cursor:pointer; font-size:0.8rem;" data-bs-toggle="collapse" data-bs-target="#panduanJurnal" role="button" aria-expanded="false">
                            <i class="fa-solid fa-circle-question"></i> Panduan Jurnal RKAP Versi 2
                            <span class="float-end text-muted" style="font-weight:normal;">klik untuk buka/tutup</span>
                        </div>
                        <div class="collapse" id="panduanJurnal">
                            <div class="card-body" style="font-size:0.75rem;">
                                <ol class="mb-2">
                                    <li><b>Setiap kelompok wajib balance.</b> Total Debit harus sama dengan total Kredit <i>di dalam kelompok yang sama</i> — bukan hanya total keseluruhan. Subtotal muncul otomatis di bawah tiap kelompok.</li>
                                    <li><b>Satu baris hanya satu sisi.</b> Debit <b>atau</b> Kredit, tidak boleh diisi dua-duanya.</li>
                                    <li><b>Tidak boleh negatif.</b> Kurang (-) dipakai di Neraca lewat kolom Debit/Kredit yang benar, bukan tanda minus.</li>
                                    <li><b>Kode Pos Neraca boleh dikosongkan.</b> Sistem mengisinya otomatis dari Kode Rekening. Isi manual hanya bila posisi berbeda dari aturan bawaan.</li>
                                    <li><b>Uraian atau Kode Rekening wajib diisi</b> minimal salah satu, supaya baris tidak diabaikan saat disimpan.</li>
                                    <li><b>Simpan diblokir</b> bila ada baris yang salah atau kelompok belum balance. Perbaiki dulu, lalu simpan lagi.</li>
                                </ol>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0" style="font-size:0.72rem; max-width:820px;">
                                        <thead class="table-secondary text-center">
                                            <tr>
                                                <th style="width:110px;">Kelompok</th>
                                                <th style="width:80px;">Baris</th>
                                                <th style="width:170px;">Total Debit</th>
                                                <th style="width:170px;">Total Kredit</th>
                                                <th style="width:170px;">Selisih</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rekap-kelompok">
                                            <?php foreach ($rekapKelompok as $g => $r) :
                                                $sel = $r['debit'] - $r['kredit'];
                                                $ok = abs($sel) < 0.005;
                                            ?>
                                                <tr>
                                                    <td class="text-center"><b><?= htmlspecialchars($g) ?></b></td>
                                                    <td class="text-center"><?= $r['n'] ?></td>
                                                    <td class="text-end"><?= $fmtJurnal($r['debit']) ?></td>
                                                    <td class="text-end"><?= $fmtJurnal($r['kredit']) ?></td>
                                                    <td class="text-end fw-bold" style="color:<?= $ok ? '#198754' : '#dc3545' ?>;">
                                                        <?= $fmtJurnal($sel) ?> <?= $ok ? '&#10003;' : '&#10007;' ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2"><b>Yang sering salah:</b> subtotal kelompok kelihatan balance hanya karena baris kelompok lain "menutupi" selisihnya. Karena itu subtotal sekarang dihitung per kelompok, bukan hanya TOTAL di bawah.</div>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="<?= base_url('lembar_kerja/jurnal_rkap/simpan') ?>" id="jurnal-form">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <input type="hidden" name="versi" value="2">
                        <div class="row g-2 mb-2">
                            <div class="col-md-2">
                                <label class="form-label">Nomor Jurnal</label>
                                <input type="hidden" name="no_jurnal" value="<?= htmlspecialchars($header->no_jurnal) ?>">
                                <div class="header-static"><?= htmlspecialchars($header->no_jurnal) ?></div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tanggal</label>
                                <input type="hidden" name="tanggal" value="<?= htmlspecialchars($header->tanggal) ?>">
                                <div class="header-static"><?= $tanggalTampil ?></div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Uraian Jurnal</label>
                                <input type="hidden" name="uraian_header" value="<?= htmlspecialchars($header->uraian_header) ?>">
                                <div class="header-static"><?= htmlspecialchars($header->uraian_header) ?></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="fw-bold">Detail Jurnal <span id="badge-total" class="badge badge-bal">SEIMBANG</span></div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-line">Tambah Baris</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" id="journal-table" style="font-size:0.75rem; min-width: 1100px;">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th style="width:40px;">No</th>
                                        <th style="width:110px;">Kelompok</th>
                                        <th>Uraian</th>
                                        <th style="width:120px;">Kode Rekening</th>
                                        <th style="width:110px;">Kode Pos Neraca</th>
                                        <th style="width:150px;">Debit</th>
                                        <th style="width:150px;">Kredit</th>
                                        <th style="width:180px;">Keterangan</th>
                                        <th style="width:50px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="journal-body">
                                    <?php $idxBaris = 0;
                                    foreach ($baris as $i => $b) :
                                        $gi = $urutGrup[$i];
                                        $isLastOfGroup = !isset($urutGrup[$i + 1]) || $urutGrup[$i + 1] !== $gi;
                                        $line = $b['line'];
                                    ?>
                                        <tr>
                                            <td class="text-center row-number"><?= $idxBaris + 1 ?></td>
                                            <td><input type="text" name="lines[<?= $idxBaris ?>][kelompok]" class="form-control form-control-sm" value="<?= htmlspecialchars($b['g']) ?>"></td>
                                            <td><input type="text" name="lines[<?= $idxBaris ?>][uraian]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->uraian ?? '') ?>"></td>
                                            <td><input type="text" name="lines[<?= $idxBaris ?>][kode_akun]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->kode_akun ?? '') ?>"></td>
                                            <td><input type="text" name="lines[<?= $idxBaris ?>][posisi_kode]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->posisi_kode ?? '') ?>"></td>
                                            <td><input type="text" inputmode="decimal" name="lines[<?= $idxBaris ?>][debit]" class="form-control form-control-sm journal-debit journal-num" value="<?= $valJurnal($line->debit ?? 0) ?>"></td>
                                            <td><input type="text" inputmode="decimal" name="lines[<?= $idxBaris ?>][kredit]" class="form-control form-control-sm journal-kredit journal-num" value="<?= $valJurnal($line->kredit ?? 0) ?>"></td>
                                            <td><input type="text" name="lines[<?= $idxBaris ?>][keterangan]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->keterangan ?? '') ?>"></td>
                                            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-line">Hapus</button></td>
                                        </tr>
                                        <?php if ($isLastOfGroup) :
                                            $s = $subtotalDariBaris($gi);
                                            $ok = abs($s['selisih']) < 0.005;
                                        ?>
                                            <tr class="subtotal-row">
                                                <td></td>
                                                <td colspan="4" class="text-end">Subtotal Kelompok <b class="sub-label"><?= htmlspecialchars($s['g']) ?></b></td>
                                                <td class="text-end sub-debit"><?= $fmtJurnal($s['debit']) ?></td>
                                                <td class="text-end sub-kredit"><?= $fmtJurnal($s['kredit']) ?></td>
                                                <td class="text-end sub-selisih" style="color:<?= $ok ? '#198754' : '#dc3545' ?>;">
                                                    Selisih: <?= $fmtJurnal($s['selisih']) ?> <?= $ok ? '&#10003;' : '&#10007;' ?>
                                                </td>
                                                <td></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php $idxBaris++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">TOTAL</td>
                                        <td class="text-end" id="total-debit"><?= number_format($summary->debit ?? 0, 0, ',', '.') ?></td>
                                        <td class="text-end" id="total-kredit"><?= number_format($summary->kredit ?? 0, 0, ',', '.') ?></td>
                                        <td colspan="2" class="text-end" id="selisih">Selisih: <?= number_format(($summary->debit ?? 0) - ($summary->kredit ?? 0), 0, ',', '.') ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Jurnal RKAP</button>
                            <a href="<?= base_url('lembar_kerja/jurnal_rkap') ?>" class="btn btn-outline-secondary btn-sm">Buka Versi Lama</a>
                            <span class="text-muted" style="font-size:0.72rem;">Simpan akan ditahan bila ada baris salah atau kelompok belum balance.</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        let lineIndex = <?= count($lines) ?>;
        const journalBody = document.getElementById('journal-body');
        const addLine = document.getElementById('add-line');
        let grupStatus = [];

        function refreshRowNumbers() {
            let n = 0;
            document.querySelectorAll('#journal-body tr').forEach((row) => {
                if (row.classList.contains('subtotal-row')) return;
                n++;
                const cell = row.querySelector('.row-number');
                if (cell) cell.textContent = n;
            });
        }

        function parseJurnalNum(value) {
            let v = String(value ?? '').trim().replace(/\s/g, '');
            if (v === '') return 0;
            if (v.indexOf(',') !== -1) {
                v = v.replace(/\./g, '').replace(',', '.');
            } else if (/^-?\d{1,3}(\.\d{3})+$/.test(v)) {
                v = v.replace(/\./g, '');
            }
            const n = Number(v);
            return isNaN(n) ? 0 : n;
        }

        function formatJurnalNum(value) {
            const n = parseJurnalNum(value);
            if (n === 0) return '';
            return n.toLocaleString('id-ID', {
                minimumFractionDigits: Number.isInteger(n) ? 0 : 2,
                maximumFractionDigits: 2
            });
        }

        function hitungTotals() {
            let debit = 0;
            let kredit = 0;
            document.querySelectorAll('.journal-debit').forEach((input) => {
                debit += parseJurnalNum(input.value);
            });
            document.querySelectorAll('.journal-kredit').forEach((input) => {
                kredit += parseJurnalNum(input.value);
            });
            document.getElementById('total-debit').textContent = debit.toLocaleString('id-ID', {
                maximumFractionDigits: 0
            });
            document.getElementById('total-kredit').textContent = kredit.toLocaleString('id-ID', {
                maximumFractionDigits: 0
            });
            document.getElementById('selisih').textContent = 'Selisih: ' + (debit - kredit).toLocaleString('id-ID', {
                maximumFractionDigits: 0
            });
        }

        function bacaGrup() {
            const rows = Array.from(journalBody.querySelectorAll('tr')).filter((r) => !r.classList.contains('subtotal-row'));
            const groups = [];
            rows.forEach((row) => {
                const inKelompok = row.querySelector('input[name$="[kelompok]"]');
                const g = ((inKelompok && inKelompok.value) || 'JU').trim().toUpperCase() || 'JU';
                const inD = row.querySelector('.journal-debit');
                const inK = row.querySelector('.journal-kredit');
                const d = inD ? parseJurnalNum(inD.value) : 0;
                const k = inK ? parseJurnalNum(inK.value) : 0;
                if (!groups.length || groups[groups.length - 1].g !== g) {
                    groups.push({
                        g: g,
                        d: 0,
                        k: 0,
                        last: null
                    });
                }
                const grp = groups[groups.length - 1];
                grp.d += d;
                grp.k += k;
                grp.last = row;
            });
            return groups;
        }

        function refreshRekap() {
            const el = document.getElementById('rekap-kelompok');
            if (!el) return;
            const rows = Array.from(journalBody.querySelectorAll('tr')).filter((r) => !r.classList.contains('subtotal-row'));
            const m = {};
            const order = [];
            rows.forEach((row) => {
                const inG = row.querySelector('input[name$="[kelompok]"]');
                const g = ((inG && inG.value) || 'JU').trim().toUpperCase() || 'JU';
                const inU = row.querySelector('input[name$="[uraian]"]');
                const inK = row.querySelector('input[name$="[kode_akun]"]');
                const u = inU ? inU.value.trim() : '';
                const k = inK ? inK.value.trim() : '';
                if (u === '' && k === '') return;
                if (!m[g]) {
                    m[g] = {
                        n: 0,
                        d: 0,
                        k: 0
                    };
                    order.push(g);
                }
                const inD = row.querySelector('.journal-debit');
                const inC = row.querySelector('.journal-kredit');
                m[g].n++;
                m[g].d += inD ? parseJurnalNum(inD.value) : 0;
                m[g].k += inC ? parseJurnalNum(inC.value) : 0;
            });
            el.innerHTML = order.map((g) => {
                const r = m[g];
                const sel = r.d - r.k;
                const ok = Math.abs(sel) < 0.005;
                const warna = ok ? '#198754' : '#dc3545';
                const num = (v) => v.toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                });
                return '<tr>' +
                    '<td class="text-center"><b>' + g + '</b></td>' +
                    '<td class="text-center">' + r.n + '</td>' +
                    '<td class="text-end">' + num(r.d) + '</td>' +
                    '<td class="text-end">' + num(r.k) + '</td>' +
                    '<td class="text-end fw-bold" style="color:' + warna + ';">' + num(sel) + ' ' + (ok ? '&#10003;' : '&#10007;') + '</td>' +
                    '</tr>';
            }).join('');
        }

        function refreshSubtotals() {
            Array.from(journalBody.querySelectorAll('tr.subtotal-row')).forEach((r) => r.remove());
            const groups = bacaGrup();
            groups.forEach((grp) => {
                const sel = grp.d - grp.k;
                const ok = Math.abs(sel) < 0.005;
                const tr = document.createElement('tr');
                tr.className = 'subtotal-row';
                tr.innerHTML =
                    '<td></td>' +
                    '<td colspan="4" class="text-end">Subtotal Kelompok <b class="sub-label">' + grp.g + '</b></td>' +
                    '<td class="text-end sub-debit">' + grp.d.toLocaleString('id-ID', {
                        maximumFractionDigits: 0
                    }) + '</td>' +
                    '<td class="text-end sub-kredit">' + grp.k.toLocaleString('id-ID', {
                        maximumFractionDigits: 0
                    }) + '</td>' +
                    '<td class="text-end sub-selisih" style="color:' + (ok ? '#198754' : '#dc3545') + ';">Selisih: ' +
                    sel.toLocaleString('id-ID', {
                        maximumFractionDigits: 0
                    }) + ' ' + (ok ? '&#10003;' : '&#10007;') + '</td>' +
                    '<td></td>';
                if (grp.last && grp.last.parentNode) grp.last.parentNode.insertBefore(tr, grp.last.nextSibling);
            });
            grupStatus = groups;
            updateBadge();
            refreshRekap();
            hitungTotals();
            refreshRowNumbers();
            validasiBaris();
        }

        function kelompokTidakSeimbang() {
            return grupStatus.filter((g) => Math.abs(g.d - g.k) >= 0.005);
        }

        function updateBadge() {
            const badge = document.getElementById('badge-total');
            if (!badge) return;
            const bad = kelompokTidakSeimbang();
            if (bad.length === 0) {
                badge.className = 'badge badge-bal';
                badge.textContent = 'SEIMBANG';
            } else {
                badge.className = 'badge badge-unbal';
                badge.textContent = 'BELUM SEIMBANG (' + bad.length + ' kelompok)';
            }
        }

        function validasiBaris() {
            const masalah = [];
            const rows = Array.from(journalBody.querySelectorAll('tr')).filter((r) => !r.classList.contains('subtotal-row'));
            rows.forEach((row, i) => {
                const no = i + 1;
                row.classList.remove('table-danger');
                row.removeAttribute('title');
                const inU = row.querySelector('input[name$="[uraian]"]');
                const inK = row.querySelector('input[name$="[kode_akun]"]');
                const inD = row.querySelector('.journal-debit');
                const inC = row.querySelector('.journal-kredit');
                const u = inU ? inU.value.trim() : '';
                const k = inK ? inK.value.trim() : '';
                const d = inD ? parseJurnalNum(inD.value) : 0;
                const c = inC ? parseJurnalNum(inC.value) : 0;
                if (u === '' && k === '') {
                    if (d !== 0 || c !== 0) {
                        row.classList.add('table-danger');
                        row.title = 'Uraian dan Kode Rekening kosong';
                        masalah.push('Baris ' + no + ': Uraian dan Kode Rekening kosong, baris ini tidak akan tersimpan.');
                    }
                    return;
                }
                if (d < 0 || c < 0) {
                    row.classList.add('table-danger');
                    row.title = 'Nilai tidak boleh negatif';
                    masalah.push('Baris ' + no + ': Nilai Debit/Kredit tidak boleh negatif.');
                    return;
                }
                if (d > 0 && c > 0) {
                    row.classList.add('table-danger');
                    row.title = 'Debit dan Kredit tidak boleh diisi dua-duanya';
                    masalah.push('Baris ' + no + ': Debit dan Kredit tidak boleh diisi sekaligus.');
                }
            });
            return masalah;
        }

        function galatJurnal() {
            const baris = validasiBaris();
            const kelompok = kelompokTidakSeimbang();
            const daftar = [];
            baris.forEach((b) => daftar.push(b));
            kelompok.forEach((g) => daftar.push('Kelompok ' + g.g + ' tidak balance (selisih ' +
                (g.d - g.k).toLocaleString('id-ID', {
                    maximumFractionDigits: 0
                }) + ')'));
            return daftar;
        }

        addLine.addEventListener('click', () => {
            const rows = Array.from(journalBody.querySelectorAll('tr')).filter((r) => !r.classList.contains('subtotal-row'));
            const last = rows[rows.length - 1];
            const inKelompok = last ? last.querySelector('input[name$="[kelompok]"]') : null;
            const nilaiKelompok = inKelompok && inKelompok.value ? inKelompok.value : 'JU';
            const row = document.createElement('tr');
            row.innerHTML = '<td class="text-center row-number"></td><td><input type="text" name="lines[' + lineIndex + '][kelompok]" class="form-control form-control-sm" value="' + nilaiKelompok.replace(/"/g, '&quot;') + '"></td><td><input type="text" name="lines[' + lineIndex + '][uraian]" class="form-control form-control-sm"></td><td><input type="text" name="lines[' + lineIndex + '][kode_akun]" class="form-control form-control-sm"></td><td><input type="text" name="lines[' + lineIndex + '][posisi_kode]" class="form-control form-control-sm"></td><td><input type="text" inputmode="decimal" name="lines[' + lineIndex + '][debit]" class="form-control form-control-sm journal-debit journal-num"></td><td><input type="text" inputmode="decimal" name="lines[' + lineIndex + '][kredit]" class="form-control form-control-sm journal-kredit journal-num"></td><td><input type="text" name="lines[' + lineIndex + '][keterangan]" class="form-control form-control-sm"></td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-line">Hapus</button></td>';
            journalBody.appendChild(row);
            lineIndex++;
            refreshSubtotals();
        });

        journalBody.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-line')) return;
            const btn = event.target;
            const hapusBaris = () => {
                btn.closest('tr').remove();
                refreshSubtotals();
            };
            if (typeof Swal === 'undefined') {
                if (confirm('Hapus baris ini?')) hapusBaris();
                return;
            }
            Swal.fire({
                title: 'Hapus Baris Jurnal?',
                text: 'Baris akan dihapus dari tabel. Tekan "Simpan Jurnal RKAP" untuk menyimpannya.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) hapusBaris();
            });
        });

        journalBody.addEventListener('input', refreshSubtotals);
        journalBody.addEventListener('focusout', (event) => {
            if (event.target.classList.contains('journal-num')) {
                event.target.value = formatJurnalNum(event.target.value);
                refreshSubtotals();
            }
        });

        document.getElementById('jurnal-form').addEventListener('submit', (event) => {
            const daftar = galatJurnal();
            if (daftar.length === 0) return;
            event.preventDefault();
            event.stopPropagation();
            const isi = '<div style="text-align:left;font-size:0.85rem;">' +
                daftar.slice(0, 12).map((d) => '&#8226; ' + d).join('<br>') +
                (daftar.length > 12 ? '<br>... dan ' + (daftar.length - 12) + ' masalah lain.' : '') +
                '</div>';
            if (typeof Swal === 'undefined') {
                alert('Jurnal belum balance:\n' + daftar.join('\n'));
                return;
            }
            Swal.fire({
                icon: 'error',
                title: 'Jurnal belum balance',
                html: isi,
                confirmButtonColor: '#d33'
            });
        }, true);

        refreshSubtotals();
    </script>