<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
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
                            <?php foreach ($tahun as $row) :
                            ?>
                                <p>Rencana Kerja & Anggaran Tahun <?= $row->tahun_rkap + 1; ?></p>
                                <p>PDAM Kabupaten Bondowoso</p>
                            <?php endforeach; ?>
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
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center mb-2">
                        <p><?= $title . ' ' .  date('Y') + 1 ?></p>
                        <p><?= strtoupper($this->session->userdata('nama_pengguna'));  ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama" style="font-size: 0.7rem;">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">No</th>
                                    <th colspan="2">Perkiraan</th>
                                    <th colspan="5" class="align-middle">URAIAN TENTANG USULAN</th>
                                    <th rowspan="2" class="align-middle">Keterangan</th>
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
                                    $id = $row->id_usulanInvestasi;
                                    $harga = $row->biaya;
                                    $satuan = $row->volume;
                                    $jumlah = $harga * $satuan;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->no_perkiraan ?></td>
                                        <td><?= $row->nama_perkiraan ?></td>
                                        <td><?= $row->latar_belakang ?></td>
                                        <td><?= $row->solusi ?></td>
                                        <td class="text-center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                                        <td class="text-center"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                                        <td class="text-center"><?= number_format($jumlah, 0, ',', '.') ?></td>
                                        <td><?= $row->ket ?></td>
                                    </tr>
                                <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>