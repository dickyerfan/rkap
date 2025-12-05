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
                        <p><?= $title . ' ' .  $tahun ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <?php
                        // daftar uraian
                        $pendapatan_non_air = [
                            'Pendapatan Non Air' => [
                                'Pendapatan Sambungan Baru' => ' - Pendapatan Sambungan Baru',
                                'Pendapatan Pendaftaran' => ' - Pendapatan Pendaftaran',
                                'Pendapatan Balik Nama' => ' - Pendapatan Balik Nama',
                                'Pendapatan Penyambungan Kembali' => ' - Pendapatan Penyamb Kembali',
                                'Pendapatan Denda' => ' - Pendapatan Denda',
                                'Pendapatan Ganti Meter Rusak' => ' - Pendapatan Ganti Meter Rusak',
                                'Pendapatan Penggatian Pipa Persil' => ' - Pendapatan Penggantian pipa persil',
                                'Pendapatan Non Air Lainnya' => ' - Pendapatan Non Air lainnya',
                            ]
                        ];

                        ?>
                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">URAIAN</th>
                                    <th class="text-center">Jan</th>
                                    <th class="text-center">Feb</th>
                                    <th class="text-center">Mar</th>
                                    <th class="text-center">Apr</th>
                                    <th class="text-center">Mei</th>
                                    <th class="text-center">Jun</th>
                                    <th class="text-center">Jul</th>
                                    <th class="text-center">Agu</th>
                                    <th class="text-center">Sep</th>
                                    <th class="text-center">Okt</th>
                                    <th class="text-center">Nov</th>
                                    <th class="text-center">Des</th>
                                    <th class="text-center">JUMLAH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendapatan_non_air as $judul => $items) : ?>
                                    <tr class="fw-bold table-secondary">
                                        <td><?= $judul; ?></td>
                                        <td colspan="13"></td>
                                    </tr>
                                    <?php foreach ($items as $jenis => $label) : ?>
                                        <tr>
                                            <td><?= $label; ?></td>
                                            <?php
                                            $total_row = 0;
                                            for ($i = 1; $i <= 12; $i++) :
                                                $nilai = isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                                                $total_row += $nilai;
                                            ?>
                                                <td class="text-end pe-1"><?= number_format($nilai, 0, ',', '.'); ?></td>
                                            <?php endfor; ?>
                                            <td class="text-end fw-bold pe-1"><?= number_format($total_row, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <!-- Jumlah per kelompok -->
                                    <tr class="fw-bold table-secondary">
                                        <td>Jumlah <?= $judul; ?></td>
                                        <?php
                                        $total_per_bulan = [];
                                        $grand_total = 0;
                                        for ($i = 1; $i <= 12; $i++) {
                                            $sum = 0;
                                            foreach ($items as $jenis => $label) {
                                                $sum += isset($pendapatan[$jenis][$i]) ? $pendapatan[$jenis][$i] : 0;
                                            }
                                            $total_per_bulan[$i] = $sum;
                                            $grand_total += $sum;
                                            echo '<td class="text-end pe-1">' . number_format($sum, 0, ',', '.') . '</td>';
                                        }
                                        ?>
                                        <td class="text-end fw-bold pe-1"><?= number_format($grand_total, 0, ',', '.'); ?></td>
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