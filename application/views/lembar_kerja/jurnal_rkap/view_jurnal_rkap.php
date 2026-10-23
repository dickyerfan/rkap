<?php if ($this->session->userdata('level') != 'Admin') redirect('auth');
$bulanIndo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$tsTanggal = strtotime($header->tanggal ?? '');
$tanggalTampil = $tsTanggal ? ((int)date('j', $tsTanggal)) . ' ' . $bulanIndo[(int)date('n', $tsTanggal)] . ' ' . date('Y', $tsTanggal) : (string)($header->tanggal ?? '');
$valJurnal = function ($v) {
    $n = (float)$v;
    if ($n == 0) return '';
    return number_format($n, $n == floor($n) ? 0 : 2, ',', '.');
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
</style>
<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="p-2"><?= $this->session->flashdata('info'); ?></div>
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light flex-nowrap" style="display: flex; align-items: center; flex-wrap: nowrap; white-space: nowrap;">
                        <a class="fw-bold text-dark pe-2" style="text-decoration:none;">Pilih Tahun</a>
                        <form action="<?= base_url('lembar_kerja/jurnal_rkap') ?>" method="get" class="d-flex align-items-center">
                            <select name="tahun_rkap" class="form-select" style="width: 120px;">
                                <?php for ($i = date('Y') - 3; $i <= date('Y') + 3; $i++) : ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                        </form>
                        <div class="navbar-nav ms-2" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/jurnal_rkap') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Reset</button></a>
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/jurnal_rkap/v2') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Jurnal Versi 2 (Subtotal per Kelompok)</button></a>
                        </div>
                        <div class="navbar-nav ms-auto" style="display: flex; align-items: center; flex-direction: row;">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/neraca') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button" type="button">Laporan Posisi Keuangan</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col text-center">
                            <h5>JURNAL RKAP TAHUN <?= $tahun ?></h5>
                        </div>
                    </div>
                    <form method="post" action="<?= base_url('lembar_kerja/jurnal_rkap/simpan') ?>" id="jurnal-form">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
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
                            <div class="fw-bold">Detail Jurnal</div>
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
                                    <?php foreach ($lines as $i => $line) : ?>
                                        <tr>
                                            <td class="text-center row-number"><?= $i + 1 ?></td>
                                            <td><input type="text" name="lines[<?= $i ?>][kelompok]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->kelompok ?? '') ?>"></td>
                                            <td><input type="text" name="lines[<?= $i ?>][uraian]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->uraian ?? '') ?>"></td>
                                            <td><input type="text" name="lines[<?= $i ?>][kode_akun]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->kode_akun ?? '') ?>"></td>
                                            <td><input type="text" name="lines[<?= $i ?>][posisi_kode]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->posisi_kode ?? '') ?>"></td>
                                            <td><input type="text" inputmode="decimal" name="lines[<?= $i ?>][debit]" class="form-control form-control-sm journal-debit journal-num" value="<?= $valJurnal($line->debit ?? 0) ?>"></td>
                                            <td><input type="text" inputmode="decimal" name="lines[<?= $i ?>][kredit]" class="form-control form-control-sm journal-kredit journal-num" value="<?= $valJurnal($line->kredit ?? 0) ?>"></td>
                                            <td><input type="text" name="lines[<?= $i ?>][keterangan]" class="form-control form-control-sm" value="<?= htmlspecialchars($line->keterangan ?? '') ?>"></td>
                                            <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-line">Hapus</button></td>
                                        </tr>
                                    <?php endforeach; ?>
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
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary">Simpan Jurnal RKAP</button>
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

        function refreshRowNumbers() {
            document.querySelectorAll('#journal-body tr').forEach((row, index) => {
                row.querySelector('.row-number').textContent = index + 1;
            });
        }

        function parseJurnalNum(value) {
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

        function formatJurnalNum(value) {
            const n = parseJurnalNum(value);
            if (n === 0) return '';
            return n.toLocaleString('id-ID', {
                minimumFractionDigits: Number.isInteger(n) ? 0 : 2,
                maximumFractionDigits: 2
            });
        }

        function calculateTotals() {
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

        addLine.addEventListener('click', () => {
            const row = document.createElement('tr');
            row.innerHTML = '<td class="text-center row-number"></td><td><input type="text" name="lines[' + lineIndex + '][kelompok]" class="form-control form-control-sm" value="JU"></td><td><input type="text" name="lines[' + lineIndex + '][uraian]" class="form-control form-control-sm"></td><td><input type="text" name="lines[' + lineIndex + '][kode_akun]" class="form-control form-control-sm"></td><td><input type="text" name="lines[' + lineIndex + '][posisi_kode]" class="form-control form-control-sm"></td><td><input type="text" inputmode="decimal" name="lines[' + lineIndex + '][debit]" class="form-control form-control-sm journal-debit journal-num"></td><td><input type="text" inputmode="decimal" name="lines[' + lineIndex + '][kredit]" class="form-control form-control-sm journal-kredit journal-num"></td><td><input type="text" name="lines[' + lineIndex + '][keterangan]" class="form-control form-control-sm"></td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-line">Hapus</button></td>';
            journalBody.appendChild(row);
            lineIndex++;
            refreshRowNumbers();
            calculateTotals();
        });

        journalBody.addEventListener('click', (event) => {
            if (!event.target.classList.contains('remove-line')) return;
            const btn = event.target;
            const hapusBaris = () => {
                btn.closest('tr').remove();
                refreshRowNumbers();
                calculateTotals();
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
        journalBody.addEventListener('input', calculateTotals);
        journalBody.addEventListener('focusout', (event) => {
            if (event.target.classList.contains('journal-num')) {
                event.target.value = formatJurnalNum(event.target.value);
                calculateTotals();
            }
        });
        calculateTotals();
    </script>