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

        main {
            font-size: 0.8rem;
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
            font-size: 0.8rem;
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
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun ?></p>
                        <p>BAGIAN <?= strtoupper($namaUpk);  ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Sub Bagian</th>
                                    <th>Permasalahan</th>
                                    <th>Penyebab</th>
                                    <th>Tindak Lanjut</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($tampil as $row) :
                                    $id = $row->id_permasalahan;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->sub_bagian ?></td>
                                        <td><?= $row->permasalahan ?></td>
                                        <td><?= $row->penyebab ?></td>
                                        <td><?= $row->tindak_lanjut ?></td>
                                        <!-- <td class="text-center">
                                                <a href="<?= base_url('rkap/permasalahan/edit_permasalahan/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                                <a href="<?= base_url('rkap/permasalahan/detail_permasalahan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('rkap/permasalahan/hapus_permasalahan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                                            </td> -->
                                    </tr>
                                <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>