<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <?= $this->session->flashdata('info'); ?>
            <div class="card border-0">
                <div class="card-header shadow text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <h5 class="mb-0">Detail Usulan Barang</h5>
                </div>
                <div class="card-body">
                    <?php if ($usulan_barang) : ?>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Tahun RKAP</th>
                                        <td><?= htmlspecialchars($usulan_barang->tahun_rkap); ?></td>
                                    </tr>
                                    <tr>
                                        <th>No Perkiraan</th>
                                        <td><?= htmlspecialchars($usulan_barang->no_perkiraan); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nama Perkiraan</th>
                                        <td><?= htmlspecialchars($usulan_barang->nama_perkiraan); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Latar Belakang</th>
                                        <td><?= htmlspecialchars($usulan_barang->latar_belakang); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Solusi</th>
                                        <td><?= htmlspecialchars($usulan_barang->solusi); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Volume</th>
                                        <td><?= htmlspecialchars($usulan_barang->volume); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Satuan</th>
                                        <td><?= htmlspecialchars($usulan_barang->satuan); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Biaya</th>
                                        <td><?= htmlspecialchars(number_format($usulan_barang->biaya, 0, ',', '.')); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td><?= htmlspecialchars($usulan_barang->ket); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bagian UPK</th>
                                        <td><?= htmlspecialchars($usulan_barang->bagian_upk); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Upload</th>
                                        <td><?= htmlspecialchars($usulan_barang->tgl_upload); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <th>File Pendukung:</th>
                                    </tr>
                                    <tr>

                                        <td>
                                            <?php if (!empty($usulan_barang->foto_ket)) : ?>
                                                <?php
                                                $file_ext = strtolower(pathinfo($usulan_barang->foto_ket, PATHINFO_EXTENSION));
                                                $file_url = base_url('uploads/' . $usulan_barang->foto_ket);
                                                if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) :
                                                ?>
                                                    <img src="<?= $file_url; ?>" alt="Foto Keterangan" style="max-width:600px;max-height:750px;">
                                                <?php elseif ($file_ext === 'pdf') : ?>
                                                    <embed src="<?= $file_url; ?>" type="application/pdf" width="400px" height="400px" />
                                                <?php else : ?>
                                                    <span><?= $usulan_barang->foto_ket; ?></span>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                Tidak ada file
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <a href="<?= base_url('admin/usulan_barang'); ?>" class="btn btn-secondary mt-2">Kembali</a>
                    <?php else : ?>
                        <div class="alert alert-danger">Data tidak ditemukan.</div>
                        <a href="<?= base_url('admin/usulan_barang'); ?>" class="btn btn-secondary mt-2">Kembali</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>