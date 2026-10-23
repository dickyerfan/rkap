<?php if ($this->session->userdata("level") != "Admin") redirect("auth");
$editRow = null;
foreach ($daftarAkun as $r) {
    if ($kodeEdit !== "" && $r->kode === $kodeEdit) {
        $editRow = $r;
        break;
    }
}
if ($kodeEdit !== "" && !$editRow) $editRow = null;
$perGrup = [];
foreach ($daftarAkun as $r) $perGrup[$r->grup][] = $r;
$akar = [];
foreach ($daftarAkun as $r) {
    if ($r->aktif && $r->parent_kode === null && $r->kode !== ($editRow->kode ?? "")) $akar[] = $r;
}
$noGlobal = 0;
?>
<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="p-2"><?= $this->session->flashdata('info'); ?></div>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Master Akun Neraca</a>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset Form</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/komparasi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Komparasi</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/neraca_lajur') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Neraca Lajur</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_growth') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Input Neraca Awal</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca/input_jurnal') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Input Jurnal</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5><?= $title ?></h5>
                        </div>
                    </div>
                    <p class="text-muted mb-2" style="font-size:0.75rem;">
                        Akun yang ditambahkan di sini otomatis tampil di <strong>Input Neraca Awal</strong>, <strong>Input Jurnal</strong>,
                        <strong>Neraca Lajur</strong>, <strong>Laporan Posisi Keuangan</strong> dan <strong>Komparasi</strong>.
                        Kode <strong>14, 61, 62</strong> adalah akun turunan (hasil jumlah anak) sehingga tidak bisa dibuat/diedit.
                        Kode <strong>42.01, 42.02, 42.04, 42.05, 42.06</strong> tidak ditampil di laporan karena nilainya sudah digabung ke <strong>42.03 Aktiva Tetap Tak Berwujud</strong>.
                    </p>

                    <div class="card mb-2">
                        <div class="card-header fw-bold" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#panduanAkun" role="button">
                            <i class="fa-solid fa-circle-question"></i> Cara Mengisi / Menambah Akun Baru
                            <span class="text-muted float-end" style="font-size:0.7rem;font-weight:normal;">klik untuk membuka/menutup</span>
                        </div>
                        <div class="collapse show" id="panduanAkun">
                            <div class="card-body py-2" style="font-size:0.75rem;">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="fw-bold mb-1">Langkah-langkah</div>
                                        <ol class="mb-2" style="padding-left:1.1rem;">
                                            <li>Bila form dalam mode <em>Ubah Akun</em>, klik <b>Reset Form</b> dahulu supaya kembali ke mode <b>Tambah Akun Baru</b>.</li>
                                            <li>Isi tiga isian wajib: <b>Kode Akun</b>, <b>Uraian</b>, dan <b>Kelompok</b>.</li>
                                            <li>Isi isian opsional: <b>Akun Induk</b>, <b>Arah</b>, <b>Urutan</b>, dan centang <b>Tampil di laporan</b>.</li>
                                            <li>Klik tombol <b>Tambah Akun</b>. Akun langsung tersimpan dan muncul di <b>Input Neraca Awal</b>, <b>Input Jurnal</b>, <b>Neraca Lajur</b>, <b>Laporan Posisi Keuangan</b> dan <b>Komparasi</b>.</li>
                                            <li>Mau memperbaiki? Klik <b>Ubah</b> pada baris akun di tabel (kode tidak bisa diubah), lalu <b>Simpan Perubahan</b>. Untuk menyembunyikan sementara, klik <b>Nonaktifkan</b>.</li>
                                        </ol>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="fw-bold mb-1">Keterangan setiap isian</div>
                                        <table class="table table-sm table-bordered mb-1" style="font-size:0.72rem;">
                                            <thead class="table-light">
                                                <tr><th style="width:26%;">Isian</th><th style="width:54%;">Keterangan</th><th style="width:20%;">Contoh</th></tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><b>Kode Akun</b></td>
                                                    <td>Wajib &amp; unik (tidak boleh sama dengan akun lain). Format angka bertitik, maksimal 4 bagian, tiap bagian 1&ndash;4 digit. Kode <b>14</b>, <b>61</b>, <b>62</b> dilarang karena merupakan akun turunan (hasil jumlah anaknya).</td>
                                                    <td><code>17</code>, <code>61.04</code>, <code>11.01.01</code></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Uraian</b></td>
                                                    <td>Wajib, maksimal 120 karakter. Tulis nama akun sesuai format SAK EP / Excel Neraca.</td>
                                                    <td>Aset Lancar Lainnya</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Kelompok</b></td>
                                                    <td>Wajib, menentukan bagian mana akun ini muncul di laporan (Aktiva Lancar s.d. Modal dan Cadangan). Akun induk &amp; anaknya harus satu kelompok.</td>
                                                    <td>Aktiva Lancar</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Akun Induk</b></td>
                                                    <td>Opsional. Diisi hanya bila nilai akun ini dijumlahkan ke induknya (nilai induk jadi read-only di Input Neraca Awal). Induk maksimal satu tingkat &amp; tidak boleh punya induk lagi.</td>
                                                    <td><code>11</code></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Arah</b></td>
                                                    <td><b>Debit</b> (default) atau <b>Kredit</b>. Samakan dengan arah akun sejenis yang sudah ada.</td>
                                                    <td>Debit</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Urutan</b></td>
                                                    <td>Posisi baris di laporan. Isi <b>0</b> untuk otomatis ditempatkan paling akhir, atau isi angka tetangganya agar muncul tepat setelahnya. Bila sama, diurutkan berdasarkan kode.</td>
                                                    <td>19</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Tampil di laporan</b></td>
                                                    <td>Dicentang = baris tampil. Dilepas = data tetap tersimpan, hanya barisnya disembunyikan dari semua halaman.</td>
                                                    <td>&#10003;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-muted" style="font-size:0.7rem;">
                                            Catatan: baris bernilai 0 tidak ditampilkan di Laporan &amp; Komparasi, jadi aman menambah akun lebih dulu sebelum ada datanya.
                                            Tombol <b>Nonaktifkan</b> akan ditolak bila akun sudah punya data (Neraca Awal/Jurnal) atau masih punya akun anak aktif.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-2">
                                <div class="card-header fw-bold"><?= $editRow ? 'Ubah Akun ' . $editRow->kode : 'Tambah Akun Baru' ?></div>
                                <div class="card-body">
                                    <form method="post" action="<?= base_url('lembar_kerja/neraca/simpan_akun') ?>">
                                        <input type="hidden" name="mode" value="<?= $editRow ? 'edit' : 'add' ?>">
                                        <div class="mb-2">
                                            <label class="form-label">Kode Akun</label>
                                            <input type="text" name="kode" value="<?= htmlspecialchars($editRow->kode ?? '') ?>" class="form-control form-control-sm" <?= $editRow ? 'readonly' : 'required' ?> placeholder="mis. 17 atau 50.10" maxlength="20">
                                            <?php if ($editRow) : ?>
                                                <div class="form-text">Kode tidak bisa diubah (identitas akun).</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Uraian</label>
                                            <input type="text" name="uraian" value="<?= htmlspecialchars($editRow->uraian ?? '') ?>" class="form-control form-control-sm" required maxlength="120" placeholder="mis. Aset Lancar Lainnya">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Kelompok</label>
                                            <select name="grup" class="form-select form-select-sm" required>
                                                <?php foreach ($grupList as $kodeGrup => $labelGrup) : ?>
                                                    <option value="<?= $kodeGrup ?>" <?= ($editRow->grup ?? '') === $kodeGrup ? 'selected' : '' ?>><?= $labelGrup ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Akun Induk (opsional)</label>
                                            <select name="parent_kode" class="form-select form-select-sm">
                                                <option value="">— Akun utama (tanpa induk) —</option>
                                                <?php foreach ($akar as $r) : ?>
                                                    <option value="<?= $r->kode ?>" <?= ($editRow->parent_kode ?? '') === $r->kode ? 'selected' : '' ?>><?= $r->kode ?> - <?= htmlspecialchars($r->uraian) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="form-text">Diisi bila nilai akun ini dijumlahkan ke induknya (nilai induk jadi read-only di Input Neraca Awal).</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 mb-2">
                                                <label class="form-label">Arah</label>
                                                <select name="sign" class="form-select form-select-sm">
                                                    <option value="1" <?= (int)($editRow->sign ?? 1) === 1 ? 'selected' : '' ?>>Debit</option>
                                                    <option value="-1" <?= (int)($editRow->sign ?? 1) === -1 ? 'selected' : '' ?>>Kredit</option>
                                                </select>
                                            </div>
                                            <div class="col-4 mb-2">
                                                <label class="form-label">Urutan</label>
                                                <input type="number" name="urutan" value="<?= (int)($editRow->urutan ?? 0) ?>" class="form-control form-control-sm" min="0">
                                            </div>
                                            <div class="col-4 mb-2 d-flex align-items-end">
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" name="tampil" id="tampilAkun" value="1" <?= (int)($editRow->tampil ?? 1) === 1 ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="tampilAkun">Tampil di laporan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-primary"><?= $editRow ? 'Simpan Perubahan' : 'Tambah Akun' ?></button>
                                            <a href="<?= base_url('lembar_kerja/neraca/daftar_akun') ?>" class="btn btn-sm btn-outline-secondary">Batal</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size:0.75rem;">
                                    <thead class="table-secondary text-center">
                                        <tr>
                                            <th style="width:35px;">#</th>
                                            <th style="width:70px;">Kode</th>
                                            <th>Uraian</th>
                                            <th style="width:105px;">Kelompok</th>
                                            <th style="width:65px;">Induk</th>
                                            <th style="width:45px;">Urut</th>
                                            <th style="width:45px;">Tampil</th>
                                            <th style="width:55px;">Status</th>
                                            <th style="width:125px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($grupList as $kodeGrup => $labelGrup) :
                                            if (empty($perGrup[$kodeGrup])) continue;
                                        ?>
                                            <tr class="table-light fw-bold">
                                                <td colspan="9"><?= $labelGrup ?></td>
                                            </tr>
                                            <?php foreach ($perGrup[$kodeGrup] as $r) :
                                                $noGlobal++;
                                                $lipat = in_array($r->kode, $foldedCodes, true);
                                            ?>
                                                <tr class="<?= $r->aktif ? '' : 'table-danger' ?>">
                                                    <td class="text-center"><?= $noGlobal ?></td>
                                                    <td><?= $r->kode ?></td>
                                                        <td><?= htmlspecialchars($r->uraian) ?><?= $lipat ? ' <span class="badge bg-secondary">digabung ke 42.03</span>' : '' ?></td>
                                                    <td><?= $grupList[$r->grup] ?? $r->grup ?></td>
                                                    <td class="text-center"><?= $r->parent_kode ?? '-' ?></td>
                                                    <td class="text-center"><?= (int)$r->urutan ?></td>
                                                    <td class="text-center"><?= $r->tampil ? 'Ya' : 'Tidak' ?></td>
                                                    <td class="text-center"><?= $r->aktif ? 'Aktif' : 'Nonaktif' ?></td>
                                                    <td class="text-center text-nowrap">
                                                        <a class="btn btn-sm btn-outline-primary py-0" href="<?= base_url('lembar_kerja/neraca/daftar_akun?edit=' . urlencode($r->kode)) ?>">Ubah</a>
                                                        <form method="post" action="<?= base_url('lembar_kerja/neraca/toggle_akun') ?>" class="d-inline">
                                                            <input type="hidden" name="kode" value="<?= $r->kode ?>">
                                                            <input type="hidden" name="aktif" value="<?= $r->aktif ? '0' : '1' ?>">
                                                            <button type="submit" class="btn btn-sm <?= $r->aktif ? 'btn-outline-danger' : 'btn-outline-success' ?> py-0"><?= $r->aktif ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-muted" style="font-size:0.7rem;">Total <?= count($daftarAkun) ?> akun &middot; Akun nonaktif tetap menyimpan datanya, hanya disembunyikan dari semua halaman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>