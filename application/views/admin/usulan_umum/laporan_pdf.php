<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP | <?= $title; ?></title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.7rem;
        }

        header p,
        .text-center p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        hr {
            height: 1px;
            background-color: black !important;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.7rem;
            padding: 3px 3px;
        }
    </style>

</head>

<body>
    <header>
        <div class="container-fluid">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td width="10%">
                            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid">
            <div class="card-body">
                <div class="row justify-content-center mb-1">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun + 1 ?></p>
                        <p>KATEGORI <?= strtoupper($kategori);  ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">No</th>
                                    <th rowspan="2" class="align-middle">Bagian/UPK</th>
                                    <th colspan="2">Perkiraan</th>
                                    <th colspan="5" class="align-middle">URAIAN TENTANG USULAN</th>
                                    <!-- <th rowspan="2" class="align-middle">Keterangan</th> -->
                                    <!-- <th rowspan="2" class="align-middle">Action</th> -->
                                </tr>
                                <tr class="text-center">
                                    <th>No Per</th>
                                    <th>Nama</th>
                                    <th>Latar Belakang</th>
                                    <th>Solusi/Usulan</th>
                                    <th>Volume</th>
                                    <th>Harga</th>
                                    <th>Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($tampil as $row) :
                                    $id = $row->id_usulanUmum;
                                    $harga = $row->biaya;
                                    $satuan = $row->volume;
                                    $jumlah = $harga * $satuan;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->bagian_upk ?></td>
                                        <td><?= $row->no_perkiraan ?></td>
                                        <td><?= $row->nama_perkiraan ?></td>
                                        <td><?= $row->latar_belakang ?></td>
                                        <td><?= $row->solusi ?></td>
                                        <td style="text-align: center;"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                        <td style="text-align: right;"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                        <td style="text-align: right;"><?= number_format($jumlah, 0, ',', '.') ?></td>
                                        <!-- <td><?= $row->ket ?></td> -->
                                        <!-- <td class="text-center">
                                                <a href="<?= base_url('admin/usulan_barang/edit_usulan_barang/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('admin/usulan_barang/detail_usulan_barang/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('admin/usulan_barang/hapus_usulan_barang/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-end">Total</th>
                                    <th class="text-end"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                                    <th class="text-end"><?= number_format(array_sum(array_map(function ($item) {
                                                                return $item->biaya * $item->volume;
                                                            }, $tampil)), 0, ',', '.') ?></th>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>