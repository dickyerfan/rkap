<?php if ($this->session->userdata("level") != "Admin") redirect("auth");

$fmt = function ($v) {
    return number_format((float)$v, 0, ",", ".");
};

$aktivaGrups = ["aktiva_lancar", "aktiva_pajak", "aktiva_tetap", "aktiva_lain"];
$orientOf = function ($grup) use ($aktivaGrups) {
    return in_array($grup, $aktivaGrups, true) ? "debit" : "credit";
};

$posMap = [];
foreach ($posList as $p) $posMap[(string)$p["kode"]] = $p;

$rujukan = [
    "62.03" => ["baris" => 28, "kodeExcel" => "62", "uraianExcel" => "Cadangan laba", "referensi" => 1099075644, "sisi" => "Kredit"],
    "70.06" => ["baris" => 33, "kodeExcel" => "70.06", "uraianExcel" => "Cadangan Umum", "referensi" => 1000000000, "sisi" => "Kredit"],
    "70.07" => ["baris" => 34, "kodeExcel" => "70.07", "uraianExcel" => "Akumulasi Kerugian Tahun lalu", "referensi" => 2000000000, "sisi" => "Kredit"],
    "70.09" => ["baris" => 35, "kodeExcel" => "70.09", "uraianExcel" => "Laba/(Rugi) Tahun Berjalan", "referensi" => 666673667, "sisi" => "Kredit"],
];

$val = function ($kode, $sisi) use ($koreksi, $fmt) {
    if (!isset($koreksi[$kode])) return "";
    $n = (float)$koreksi[$kode][$sisi];
    return $n == 0 ? "" : $fmt($n);
};
$uraianKoreksi = function ($kode) use ($koreksi, $posMap) {
    if (isset($koreksi[$kode]["uraian"]) && $koreksi[$kode]["uraian"] !== "") return $koreksi[$kode]["uraian"];
    return $posMap[$kode]["uraian"] ?? "";
};

$autoKodes = ["31", "31.1", "13.06", "50.05", "50.01"];
$opsiLain = [];
foreach ($posList as $p) {
    if (array_key_exists((string)$p["kode"], $rujukan)) continue;
    if (in_array((string)$p["kode"], $autoKodes, true)) continue;
    $opsiLain[(string)$p["kode"]] = $p["uraian"];
}

$tahunMulai = date("Y") - 3;
$tahunSelesai = date("Y") + 3;
if ((int)$tahun > $tahunSelesai) $tahunSelesai = (int)$tahun;
if ((int)$tahun < $tahunMulai) $tahunMulai = (int)$tahun;
?>
<style>
    .koreksi-num {
        text-align: right;
    }

    .koreksi-input {
        min-width: 130px;
    }

    .status-box {
        border: 2px solid #0d6efd;
        border-radius: .5rem;
        background: #f8faff;
    }

    .status-box.seimbang {
        border-color: #198754;
        background: #f2fbf6;
    }

    .status-box.selisih {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .status-num {
        font-variant-numeric: tabular-nums;
    }

    .status-utama {
        font-size: 1.35rem;
        font-weight: 700;
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
                        <form action="<?= base_url('lembar_kerja/neraca/koreksi') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = $tahunMulai; $i <= $tahunSelesai; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/koreksi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_jurnal?tahun_rkap=' . $tahun) ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Jurnal Penyesuaian</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Master Akun</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?> TAHUN <?= $tahun ?></h5>
                        </div>
                    </div>
                    <p class="text-muted text-center" style="font-size:0.78rem;">
                        Halaman ini mengisi tabel <code>neraca_jurnal</code> (penyimbang neraca) yang dibaca oleh Laporan Posisi Keuangan, Neraca Lajur dan Komparasi.
                    </p>

                    <div class="card mb-2">
                        <div class="card-header fw-bold" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#panduanKoreksi" role="button">
                            <i class="fa-solid fa-circle-question"></i> Cara Mengisi Koreksi (sumber: file Excel)
                            <span class="text-muted float-end" style="font-size:0.7rem;font-weight:normal;">klik untuk membuka/menutup</span>
                        </div>
                        <div class="collapse show" id="panduanKoreksi">
                            <div class="card-body py-2" style="font-size:0.75rem;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fw-bold mb-1">Langkah-langkah (tiap tahun)</div>
                                        <ol class="mb-2" style="padding-left:1.1rem;">
                                            <li>Buka file Excel <b>NERACA RKAP &lt;tahun&gt;.xlsx</b>.</li>
                                            <li>Pilih sheet <b>NERACA LAJUR</b>.</li>
                                            <li>Cari kolom <b>JURNAL RKAP &lt;tahun&gt;</b> — kolom <b>I</b> untuk DEBIT dan kolom <b>J</b> untuk KREDIT.</li>
                                            <li>Baca nilai pada baris <b>62</b>, <b>70.06</b>, <b>70.07</b>, <b>70.09</b>.</li>
                                            <li>Ketik nilai tersebut pada kolom <b>Debit</b>/<b>Kredit</b> di tabel bawah. Kolom <b>Nilai <?= $tahun ?> (referensi)</b> hanya pembanding, tidak bisa diubah.</li>
                                            <li>Tekan <b>Simpan Koreksi</b>, lalu lihat kotak <b>Status</b>. Angka <b>Selisih</b> harus <b>0</b>.</li>
                                        </ol>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fw-bold mb-1">Yang sering salah</div>
                                        <ul class="mb-2" style="padding-left:1.1rem;">
                                            <li><b>70.06 Cadangan Umum — kolom DEBIT Rp1.953.025.386</b> tidak diketik di sini. Nilai itu datang otomatis dari <b>Jurnal RKAP</b> (kelompok <b>JU</b>: Jaspro, Kerugian Luar Biasa, Pembelian Aktiva Lancar Lainnya, Laba yang Belum Dibayar). Yang diketik di halaman ini hanya kolom <b>KREDIT</b>-nya.</li>
                                            <li>Baris akun di Excel disebut <b>"62 Cadangan laba"</b>, tetapi di aplikasi akunnya <b>62.03 Cadangan Dana</b>.</li>
                                            <li>Kolom <b>Nilai <?= $tahun ?> (referensi)</b> berasal dari file Excel tahun ini. Bila tahun depan nilainya berbeda, yang dipakai adalah yang Anda ketik.</li>
                                            <li>Koreksi hanya berpengaruh bila kodenya ada di <b>Master Akun</b> dan <em>aktif</em>.</li>
                                        </ul>
                                        <div class="fw-bold mb-1">Posisi Excel saat ini</div>
                                        <table class="table table-sm table-bordered mb-0" style="font-size:0.7rem;">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th>Baris</th>
                                                    <th>Kode</th>
                                                    <th>Uraian di Excel</th>
                                                    <th class="text-end">JURNAL RKAP <?= $tahun ?> (K)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($rujukan as $kode => $r) : ?>
                                                    <tr>
                                                        <td class="text-center"><?= $r["baris"] ?></td>
                                                        <td><?= $r["kodeExcel"] ?></td>
                                                        <td><?= $r["uraianExcel"] ?></td>
                                                        <td class="text-end"><?= $fmt($r["referensi"]) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="status-box mb-3 p-3" id="statusBox">
                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                            <div class="fw-bold"><i class="fa-solid fa-scale-balanced"></i> STATUS KESEIMBANGAN NERACA <?= $tahun ?></div>
                            <div class="small text-muted">dihitung ulang setiap kali Anda mengetik</div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm mb-0" style="font-size:0.8rem;">
                                    <tr>
                                        <td>Total Aset <span class="text-muted">(tanpa koreksi)</span></td>
                                        <td class="text-end status-num"><?= $fmt($ringkasTanpa["aktiva"]) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kewajiban + Modal <span class="text-muted">(tanpa koreksi)</span></td>
                                        <td class="text-end status-num"><?= $fmt($ringkasTanpa["pasiva"]) ?></td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Perlu ditutup oleh koreksi</td>
                                        <td class="text-end status-num" id="st-perlu"><?= $fmt($ringkasTanpa["selisih"]) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Koreksi yang sudah diisi</td>
                                        <td class="text-end status-num" id="st-koreksi">0</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 d-flex flex-column justify-content-center">
                                <div class="text-muted" style="font-size:0.8rem;">Selisih setelah koreksi</div>
                                <div class="status-utama status-num" id="st-selisih"><?= $fmt($ringkas["selisih"]) ?></div>
                                <div>
                                    <span class="badge fs-6" id="st-badge"><?= abs($ringkas["selisih"]) < 0.5 ? "SEIMBANG" : "SELISIH" ?></span>
                                </div>
                                <div class="small mt-2">
                                    Total Aset <b class="status-num" id="st-aset"><?= $fmt($ringkas["aktiva"]) ?></b>
                                    &nbsp;=&nbsp;
                                    Kewajiban + Modal <b class="status-num" id="st-pasiva"><?= $fmt($ringkas["pasiva"]) ?></b>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="<?= base_url("lembar_kerja/neraca/simpan_koreksi") ?>" id="koreksi-form">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">

                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                            <div class="fw-bold">1. Koreksi penyimbang utama</div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-success" id="btn-isi-referensi">
                                    <i class="fa-solid fa-file-import"></i> Isi semua dari referensi Excel
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="btn-salin-sisa">
                                    <i class="fa-solid fa-arrow-right"></i> Salin sisa ke 70.09
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" style="font-size:0.75rem; min-width: 1000px;">
                                <thead class="table-secondary text-center">
                                    <tr>
                                        <th style="width:40px;">No</th>
                                        <th style="width:80px;">Kode</th>
                                        <th style="width:190px;">Uraian</th>
                                        <th>Sumber di Excel</th>
                                        <th style="width:150px;" class="text-end">Nilai <?= $tahun ?> (referensi)</th>
                                        <th style="width:150px;">Debit</th>
                                        <th style="width:150px;">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    $idxKoreksi = 0;
                                    foreach ($rujukan as $kode => $r) :
                                        $p = $posMap[$kode] ?? null;
                                        $sisi = $orientOf($p["grup"] ?? "ekuitas");
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $kode ?></td>
                                            <td><?= $p ? $p["uraian"] : "<span class='text-danger'>tidak ada di Master Akun</span>" ?></td>
                                            <td style="font-size:0.7rem;">
                                                Sheet <b>NERACA LAJUR</b> &rarr; baris <b><?= $r["baris"] ?></b>
                                                (<code><?= $r["kodeExcel"] ?></code> <?= $r["uraianExcel"] ?>)
                                                &rarr; kolom <b>JURNAL RKAP <?= $tahun ?> - <?= $r["sisi"] ?></b>
                                            </td>
                                            <td class="text-end"><?= $fmt($r["referensi"]) ?></td>
                                            <td>
                                                <input type="hidden" name="koreksi[<?= $idxKoreksi ?>][kode]" value="<?= $kode ?>">
                                                <input type="hidden" name="koreksi[<?= $idxKoreksi ?>][uraian]" value="<?= htmlspecialchars($uraianKoreksi($kode)) ?>">
                                                <input type="hidden" class="koreksi-orient" value="<?= $sisi ?>">
                                                <input type="hidden" class="koreksi-saved" data-sisi="debit" value="<?= (float)($koreksi[$kode]["debit"] ?? 0) ?>">
                                                <input type="hidden" class="koreksi-saved" data-sisi="kredit" value="<?= (float)($koreksi[$kode]["kredit"] ?? 0) ?>">
                                                <input type="text" inputmode="decimal" name="koreksi[<?= $idxKoreksi ?>][debit]"
                                                    class="form-control form-control-sm text-end p-1 koreksi-num koreksi-input koreksi-live"
                                                    data-sisi="debit" data-kode="<?= $kode ?>" value="<?= $val($kode, "debit") ?>">
                                            </td>
                                            <td>
                                                <input type="text" inputmode="decimal" name="koreksi[<?= $idxKoreksi ?>][kredit]"
                                                    class="form-control form-control-sm text-end p-1 koreksi-num koreksi-input koreksi-live"
                                                    data-sisi="kredit" data-kode="<?= $kode ?>" value="<?= $val($kode, "kredit") ?>">
                                            </td>
                                        </tr>
                                        <?php $idxKoreksi++;
                                    endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr class="fw-bold">
                                        <td colspan="5" class="text-end">TOTAL KOREKSI YANG MEMPENGARUHI NERACA</td>
                                        <td class="text-end status-num" id="koreksi-total-debit">0</td>
                                        <td class="text-end status-num" id="koreksi-total-kredit">0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header fw-bold" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#koreksiLain" role="button">
                                <i class="fa-solid fa-plus"></i> 2. Koreksi akun lain <span class="text-muted float-end" style="font-size:0.7rem;font-weight:normal;">opsional — klik untuk membuka/menutup</span>
                            </div>
                            <div class="collapse" id="koreksiLain">
                                <div class="card-body py-2">
                                    <p class="text-muted mb-2" style="font-size:0.75rem;">
                                        Hanya perlu bila ada pos di luar empat akun di atas. Pilih akun dari Master Akun, lalu isi Debit atau Kredit.
                                        Baris yang kodenya dikosongkan akan dilewati saat menyimpan.
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-2" style="font-size:0.75rem; min-width: 900px;">
                                            <thead class="table-secondary text-center">
                                                <tr>
                                                    <th style="width:40px;">No</th>
                                                    <th style="width:280px;">Akun (Master Akun)</th>
                                                    <th style="width:150px;">Debit</th>
                                                    <th style="width:150px;">Kredit</th>
                                                    <th style="width:60px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lain-body">
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-lain">Tambah Baris</button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Koreksi</button>
                            <a href="<?= base_url('lembar_kerja/neraca?tahun_rkap=' . $tahun) ?>" class="btn btn-outline-secondary">Lihat Laporan</a>
                            <span class="small text-muted">Simpan tetap diperbolehkan walaupun belum seimbang — kotak Status di atas akan menampilkan sisa selisihnya.</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        const ORIENT = <?= json_encode(array_map(function ($p) use ($orientOf) {
                return $orientOf($p["grup"]);
            }, $posMap), JSON_UNESCAPED_UNICODE) ?>;
        const URAIAN = <?= json_encode(array_map(function ($p) {
                return $p["uraian"];
            }, $posMap), JSON_UNESCAPED_UNICODE) ?>;
        const BASE_AKTIVA = <?= json_encode((float)$ringkasTanpa["aktiva"]) ?>;
        const BASE_PASIVA = <?= json_encode((float)$ringkasTanpa["pasiva"]) ?>;
        const BASE_SELISIH = <?= json_encode((float)$ringkasTanpa["selisih"]) ?>;
        const OPSI_AKUN = <?= json_encode($opsiLain, JSON_UNESCAPED_UNICODE) ?>;

        function parseKoreksiNum(value) {
            let v = String(value ?? '').trim().replace(/\s/g, '');
            if (v === '') return 0;
            if (v.indexOf(',') !== -1) {
                v = v.replace(/\./g, '').replace(',', '.');
            } else if (/^\d{1,3}(\.\d{3})+$/.test(v)) {
                v = v.replace(/\./g, '');
            }
            const n = Number(v);
            return isNaN(n) ? 0 : n;
        }

        function formatKoreksiNum(value) {
            const n = parseKoreksiNum(value);
            if (n === 0) return '';
            return n.toLocaleString('id-ID', {
                minimumFractionDigits: Number.isInteger(n) ? 0 : 2,
                maximumFractionDigits: 2
            });
        }

        function idNum(v) {
            return Math.round(v).toLocaleString('id-ID', { maximumFractionDigits: 0 });
        }

        function rowSisi(row) {
            const h = row.querySelector('.koreksi-orient');
            if (h) return h.value;
            const select = row.querySelector('.koreksi-akun');
            if (select) return select.value ? (ORIENT[select.value] || 'debit') : null;
            return 'debit';
        }

        function savedValue(row, sisi) {
            const h = row.querySelector('.koreksi-saved[data-sisi="' + sisi + '"]');
            return h ? Number(h.value) : 0;
        }

        function hitungStatus() {
            let dAktiva = 0;
            let dPasiva = 0;
            let totalDebit = 0;
            let totalKredit = 0;

            document.querySelectorAll('#koreksi-form tbody tr').forEach((row) => {
                const inpD = row.querySelector('.koreksi-live[data-sisi="debit"]');
                const inpK = row.querySelector('.koreksi-live[data-sisi="kredit"]');
                if (!inpD || !inpK) return;
                const sisi = rowSisi(row);
                if (sisi === null) return;
                const debit = parseKoreksiNum(inpD.value);
                const kredit = parseKoreksiNum(inpK.value);
                totalDebit += debit;
                totalKredit += kredit;
                const dDebit = debit - savedValue(row, 'debit');
                const dKredit = kredit - savedValue(row, 'kredit');
                if (sisi === 'debit') {
                    dAktiva += dDebit - dKredit;
                } else {
                    dPasiva += -dDebit + dKredit;
                }
            });

            const aktiva = BASE_AKTIVA + dAktiva;
            const pasiva = BASE_PASIVA + dPasiva;
            const selisih = aktiva - pasiva;

            const elPerlu = document.getElementById('st-perlu');
            if (elPerlu) elPerlu.textContent = idNum(BASE_SELISIH);
            const elKoreksi = document.getElementById('st-koreksi');
            if (elKoreksi) elKoreksi.textContent = idNum(BASE_SELISIH - selisih);
            const elSelisih = document.getElementById('st-selisih');
            if (elSelisih) elSelisih.textContent = idNum(selisih);
            const elAset = document.getElementById('st-aset');
            if (elAset) elAset.textContent = idNum(aktiva);
            const elPasiva = document.getElementById('st-pasiva');
            if (elPasiva) elPasiva.textContent = idNum(pasiva);

            const badge = document.getElementById('st-badge');
            const box = document.getElementById('statusBox');
            const seimbang = Math.abs(selisih) < 0.5;
            if (badge) {
                badge.textContent = seimbang ? 'SEIMBANG' : 'SELISIH ' + idNum(selisih);
                badge.className = 'badge fs-6 ' + (seimbang ? 'bg-success' : 'bg-danger');
            }
            if (box) {
                box.classList.remove('seimbang', 'selisih');
                box.classList.add(seimbang ? 'seimbang' : 'selisih');
            }

            const tdD = document.getElementById('koreksi-total-debit');
            if (tdD) tdD.textContent = idNum(totalDebit);
            const tdK = document.getElementById('koreksi-total-kredit');
            if (tdK) tdK.textContent = idNum(totalKredit);
            return selisih;
        }

        function pasangHandler(badan) {
            badan.addEventListener('input', (event) => {
                if (event.target.classList.contains('koreksi-live') || event.target.classList.contains('koreksi-akun')) {
                    hitungStatus();
                }
            });
            badan.addEventListener('focusout', (event) => {
                if (event.target.classList && event.target.classList.contains('koreksi-num')) {
                    event.target.value = formatKoreksiNum(event.target.value);
                    hitungStatus();
                }
            });
        }

        pasangHandler(document);

        document.getElementById('btn-salin-sisa').addEventListener('click', () => {
            const input = document.querySelector('input[data-kode="70.09"][data-sisi="kredit"]');
            if (!input) return;
            const selisih = hitungStatus();
            const sekarang = parseKoreksiNum(input.value);
            const baru = sekarang + selisih;
            input.value = formatKoreksiNum(baru > 0 ? baru : 0);
            hitungStatus();
        });

        const RUJUKAN = <?= json_encode(array_map(function ($r) {
                return $r["referensi"];
            }, $rujukan), JSON_UNESCAPED_UNICODE) ?>;

        document.getElementById('btn-isi-referensi').addEventListener('click', () => {
            Object.keys(RUJUKAN).forEach((kode) => {
                const input = document.querySelector('input[data-kode="' + kode + '"][data-sisi="kredit"]');
                if (input) input.value = formatKoreksiNum(RUJUKAN[kode]);
            });
            hitungStatus();
        });

        const lainBody = document.getElementById('lain-body');
        let lainIndex = 0;

        function buatBarisLain() {
            const tr = document.createElement('tr');
            let opsi = '<option value="">-- pilih akun --</option>';
            Object.keys(OPSI_AKUN).forEach((kode) => {
                opsi += '<option value="' + kode + '">' + kode + ' - ' + OPSI_AKUN[kode] + '</option>';
            });
            tr.innerHTML =
                '<td class="text-center lain-no"></td>' +
                '<td><select name="koreksi_lain[' + lainIndex + '][kode]" class="form-select form-select-sm koreksi-akun">' + opsi + '</select>' +
                '<input type="hidden" name="koreksi_lain[' + lainIndex + '][uraian]" value=""></td>' +
                '<td><input type="text" inputmode="decimal" name="koreksi_lain[' + lainIndex + '][debit]" class="form-control form-control-sm text-end p-1 koreksi-num koreksi-input koreksi-live" data-sisi="debit"></td>' +
                '<td><input type="text" inputmode="decimal" name="koreksi_lain[' + lainIndex + '][kredit]" class="form-control form-control-sm text-end p-1 koreksi-num koreksi-input koreksi-live" data-sisi="kredit"></td>' +
                '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger lain-remove">Hapus</button></td>';
            lainBody.appendChild(tr);
            lainIndex++;
            nomorLain();
        }

        function nomorLain() {
            lainBody.querySelectorAll('.lain-no').forEach((td, i) => td.textContent = i + 1);
        }

        document.getElementById('add-lain').addEventListener('click', buatBarisLain);

        lainBody.addEventListener('click', (event) => {
            if (!event.target.classList.contains('lain-remove')) return;
            event.target.closest('tr').remove();
            nomorLain();
            hitungStatus();
        });

        document.getElementById('koreksi-form').addEventListener('submit', () => {
            lainBody.querySelectorAll('tr').forEach((tr) => {
                const select = tr.querySelector('.koreksi-akun');
                if (!select) return;
                const kode = select.value;
                const inpD = tr.querySelector('.koreksi-live[data-sisi="debit"]');
                const inpK = tr.querySelector('.koreksi-live[data-sisi="kredit"]');
                const hiddenUraian = tr.querySelector('input[name$="[uraian]"]');
                if (hiddenUraian) hiddenUraian.value = URAIAN[kode] || '';
                if (kode === '') {
                    inpD.disabled = true;
                    inpK.disabled = true;
                }
            });
        });

        hitungStatus();
    </script>
</div>
