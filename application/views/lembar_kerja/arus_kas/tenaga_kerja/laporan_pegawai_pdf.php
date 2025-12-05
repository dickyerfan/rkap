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
            font-size: 0.7rem;
            height: 20px;
            vertical-align: middle;
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
                            <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                            <p>PDAM Kabupaten Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card-body">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p class="fw-bold mb-2 fs-6"><?= $title; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Bagian</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Dapenma</th>
                                    <th class="text-center">J. Kelamin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($pegawai as $p) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-start"><?= $p->nama; ?></td>
                                        <td class="text-start"><?= $p->bagian; ?></td>
                                        <td class="text-start"><?= $p->jabatan; ?></td>
                                        <td class="text-start"><?= $p->kategori; ?></td>
                                        <td class="text-start"><?= $p->status_pegawai; ?></td>
                                        <td class="text-center">
                                            <?= $p->dapenma == 1 ? 'Aktif' : 'Belum'; ?>
                                        </td>
                                        <td class="text-center"><?= $p->jenkel; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>