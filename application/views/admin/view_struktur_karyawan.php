<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <ul class="nav nav-tabs" id="karyawanTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button" role="tab">Karyawan Aktif</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="purna-tab" data-bs-toggle="tab" data-bs-target="#purna" type="button" role="tab">Karyawan Purna</button>
                            </li>
                        </ul>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="fas fa-plus"></i> Tambah Karyawan
                        </button>
                    </div>
                    <div class="tab-content" id="karyawanTabContent">
                        <div class="tab-pane fade show active" id="aktif" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="tabelAktif">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Bagian</th>
                                            <th>Sub Bagian</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($karyawan_aktif as $k) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $k->nik ?></td>
                                                <td><?= $k->nama ?></td>
                                                <td><?= $k->nama_jabatan ?></td>
                                                <td><?= $k->nama_bagian ?></td>
                                                <td><?= $k->nama_subag ?></td>
                                                <td><?= $k->status_pegawai ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="<?= $k->id ?>" data-id_bagian="<?= $k->id_bagian ?>" data-id_subag="<?= $k->id_subag ?>" data-id_jabatan="<?= $k->id_jabatan ?>" data-nama="<?= htmlspecialchars($k->nama, ENT_QUOTES) ?>" data-nik="<?= $k->nik ?>" data-alamat="<?= htmlspecialchars($k->alamat, ENT_QUOTES) ?>" data-agama="<?= $k->agama ?>" data-status_pegawai="<?= htmlspecialchars($k->status_pegawai, ENT_QUOTES) ?>" data-no_hp="<?= $k->no_hp ?>" data-jenkel="<?= $k->jenkel ?>" data-tmp_lahir="<?= htmlspecialchars($k->tmp_lahir, ENT_QUOTES) ?>" data-tgl_lahir="<?= $k->tgl_lahir ?>" data-tgl_masuk="<?= $k->tgl_masuk ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <a href="<?= base_url('admin/pengaturan/strukturNonaktifkan/' . $k->id) ?>" class="btn btn-secondary btn-sm btn-nonaktifkan">
                                                        <i class="fas fa-user-slash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="purna" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="tabelPurna">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Bagian</th>
                                            <th>Sub Bagian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($karyawan_purna as $k) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $k->nik ?></td>
                                                <td><?= $k->nama ?></td>
                                                <td><?= $k->nama_jabatan ?></td>
                                                <td><?= $k->nama_bagian ?></td>
                                                <td><?= $k->nama_subag ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/pengaturan/strukturAktifkan/' . $k->id) ?>" class="btn btn-success btn-sm btn-aktifkan">
                                                        <i class="fas fa-user-check"></i> Aktifkan
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('admin/pengaturan/strukturTambah') ?>" method="post">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Karyawan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tmp_lahir" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Agama</label>
                                <select name="agama" class="form-select form-select-sm">
                                    <option value="">-- Pilih --</option>
                                    <option>Islam</option>
                                    <option>Kristen</option>
                                    <option>Katolik</option>
                                    <option>Hindu</option>
                                    <option>Budha</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Status Pegawai</label>
                                <select name="status_pegawai" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option>Karyawan Tetap</option>
                                    <option>Karyawan Kontrak</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Jabatan</label>
                                <select name="id_jabatan" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    <?php foreach ($jabatan as $j) : ?>
                                        <option value="<?= $j->id_jabatan ?>"><?= $j->nama_jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Bagian</label>
                                <select name="id_bagian" class="form-select form-select-sm bagian-select" required>
                                    <option value="">-- Pilih Bagian --</option>
                                    <?php foreach ($bagian as $b) : ?>
                                        <option value="<?= $b->id_bagian ?>"><?= $b->nama_bagian ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Sub Bagian / UPK</label>
                                <select name="id_subag" class="form-select form-select-sm subag-select" required>
                                    <option value="">-- Pilih Bagian Terlebih Dahulu --</option>
                                    <?php foreach ($subag as $s) : ?>
                                        <option value="<?= $s->id_subag ?>"><?= $s->nama_subag ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="<?= base_url('admin/pengaturan/strukturEdit') ?>" method="post">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">Edit Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" id="edit_nik" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" id="edit_nama" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" id="edit_jenkel" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tmp_lahir" id="edit_tmp_lahir" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Agama</label>
                                <select name="agama" id="edit_agama" class="form-select form-select-sm">
                                    <option value="">-- Pilih --</option>
                                    <option>Islam</option>
                                    <option>Kristen</option>
                                    <option>Katolik</option>
                                    <option>Hindu</option>
                                    <option>Budha</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">No HP</label>
                                <input type="text" name="no_hp" id="edit_no_hp" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="edit_alamat" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Status Pegawai</label>
                                <select name="status_pegawai" id="edit_status_pegawai" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    <option>Karyawan Tetap</option>
                                    <option>Karyawan Kontrak</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tgl_masuk" id="edit_tgl_masuk" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Jabatan</label>
                                <select name="id_jabatan" id="edit_id_jabatan" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    <?php foreach ($jabatan as $j) : ?>
                                        <option value="<?= $j->id_jabatan ?>"><?= $j->nama_jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Bagian</label>
                                <select name="id_bagian" id="edit_id_bagian" class="form-select form-select-sm bagian-select-edit" required>
                                    <option value="">-- Pilih Bagian --</option>
                                    <?php foreach ($bagian as $b) : ?>
                                        <option value="<?= $b->id_bagian ?>"><?= $b->nama_bagian ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Sub Bagian / UPK</label>
                                <select name="id_subag" id="edit_id_subag" class="form-select form-select-sm subag-select-edit" required>
                                    <option value="">-- Pilih Bagian Terlebih Dahulu --</option>
                                    <?php foreach ($subag as $s) : ?>
                                        <option value="<?= $s->id_subag ?>"><?= $s->nama_subag ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function initStrukturPage() {
            if (typeof jQuery === 'undefined') {
                setTimeout(initStrukturPage, 50);
                return;
            }
            $(document).ready(function() {
                if (!$.fn.DataTable.isDataTable('#tabelAktif')) {
                    $('#tabelAktif').DataTable({
                        pageLength: 15,
                        lengthMenu: [
                            [10, 15, 50, 100, -1],
                            [10, 15, 50, 100, "Semua"]
                        ]
                    });
                }
                if (!$.fn.DataTable.isDataTable('#tabelPurna')) {
                    $('#tabelPurna').DataTable({
                        pageLength: 15,
                        lengthMenu: [
                            [10, 15, 50, 100, -1],
                            [10, 15, 50, 100, "Semua"]
                        ]
                    });
                }
            });

            $(document).on('click', '.btn-nonaktifkan', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                Swal.fire({
                    title: 'Nonaktifkan Karyawan?',
                    text: 'Karyawan akan dipindahkan ke daftar Purna',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Nonaktifkan'
                }).then(function(result) {
                    if (result.isConfirmed) document.location.href = href;
                });
            });

            $(document).on('click', '.btn-aktifkan', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                Swal.fire({
                    title: 'Aktifkan Karyawan?',
                    text: 'Karyawan akan dikembalikan ke daftar Aktif',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Aktifkan'
                }).then(function(result) {
                    if (result.isConfirmed) document.location.href = href;
                });
            });

            $('#modalEdit').on('show.bs.modal', function(event) {
                var btn = $(event.relatedTarget);
                $('#edit_id').val(btn.data('id'));
                $('#edit_nik').val(btn.data('nik'));
                $('#edit_nama').val(btn.data('nama'));
                $('#edit_alamat').val(btn.data('alamat'));
                $('#edit_no_hp').val(btn.data('no_hp'));
                $('#edit_tmp_lahir').val(btn.data('tmp_lahir'));
                $('#edit_tgl_lahir').val(btn.data('tgl_lahir'));
                $('#edit_tgl_masuk').val(btn.data('tgl_masuk'));
                $('#edit_jenkel').val(btn.data('jenkel'));
                $('#edit_agama').val(btn.data('agama'));
                $('#edit_status_pegawai').val(btn.data('status_pegawai'));
                $('#edit_id_jabatan').val(btn.data('id_jabatan'));
                $('#edit_id_bagian').val(btn.data('id_bagian'));
                $('#edit_id_subag').empty().append('<option value="">-- Pilih Sub Bagian --</option>');
                <?php foreach ($subag as $s) : ?>
                    $('#edit_id_subag').append($('<option value="<?= $s->id_subag ?>"><?= $s->nama_subag ?></option>'));
                <?php endforeach; ?>
                $('#edit_id_subag').val(btn.data('id_subag'));
            });

            $(document).on('change', '.bagian-select', function() {
                filterSubag($('.subag-select'));
            });

            $(document).on('change', '.bagian-select-edit', function() {
                filterSubag($('.subag-select-edit'));
            });

            function filterSubag($select) {
                $select.empty().append('<option value="">-- Pilih Sub Bagian --</option>');
                <?php foreach ($subag as $s) : ?>
                    $select.append($('<option value="<?= $s->id_subag ?>"><?= $s->nama_subag ?></option>'));
                <?php endforeach; ?>
            }
        }
        initStrukturPage();
    </script>