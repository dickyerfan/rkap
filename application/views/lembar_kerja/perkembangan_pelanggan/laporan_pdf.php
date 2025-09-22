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
        <div class="container-fluid px-2 mt-2">
            <div class="card-body">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-6 text-center">
                        <p><?= $title . ' ' .  $tahun + 1 ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
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
                                <?php
                                $no = 1;

                                // buat map dari data yang ada supaya cepat lookup
                                $map = [];
                                if (!empty($data_pelanggan)) {
                                    foreach ($data_pelanggan as $r) {
                                        $k = isset($r['nama_kd']) ? trim($r['nama_kd']) : '';
                                        $j = isset($r['nama_jp']) ? trim($r['nama_jp']) : '';
                                        $m = isset($r['bulan']) ? (int)$r['bulan'] : 0;
                                        $val = isset($r['jumlah']) ? (int)$r['jumlah'] : 0;
                                        if ($k !== '' && $j !== '' && $m >= 1 && $m <= 12) {
                                            $map[$k][$j][$m] = $val;
                                        }
                                    }
                                }

                                $kategori_list = isset($kategori_list) ? $kategori_list : [];
                                $jenis_list = isset($jenis_list) ? $jenis_list : [];

                                foreach ($kategori_list as $kategori) {
                                    echo "<tr><td colspan='14' class='fw-bold bg-light '>" . strtoupper(htmlspecialchars($kategori)) . "</td></tr>";

                                    // inisialisasi total per bulan untuk kategori ini
                                    $totalKategori = array_fill(1, 12, 0);
                                    $grandTotalKategori = 0;

                                    foreach ($jenis_list as $jenis) {
                                        echo "<tr>";
                                        echo "<td class='text-start'> - " . htmlspecialchars($jenis) . "</td>";

                                        $jumlah = 0;
                                        for ($b = 1; $b <= 12; $b++) {
                                            $nilai = isset($map[$kategori][$jenis][$b]) ? (int)$map[$kategori][$jenis][$b] : 0;
                                            echo "<td class='text-end'  style='padding-right:4px;'>" . number_format($nilai, 0, ',', '.') . "</td>";

                                            if ($kategori === 'Sambungan Awal' || $kategori === 'Sambungan Akhir') {
                                                $jumlah = $nilai; // overwrite
                                                $totalKategori[$b] += $nilai; // tetap masuk ke total kategori
                                            } else {
                                                $jumlah += $nilai;
                                                $totalKategori[$b] += $nilai;
                                            }
                                        }

                                        echo "<td class='fw-bold text-end'  style='padding-right:4px;'>" . number_format($jumlah, 0, ',', '.') . "</td>";
                                        echo "</tr>";

                                        // tambah ke grand total kategori
                                        $grandTotalKategori += $jumlah;
                                    }

                                    // tampilkan baris total kategori
                                    echo "<tr class='fw-bold bg-light'>";
                                    echo "<td  class='text-start'>TOTAL " . strtoupper(htmlspecialchars($kategori)) . "</td>";
                                    for ($b = 1; $b <= 12; $b++) {
                                        echo "<td class='text-end'  style='padding-right:4px;'>" . number_format($totalKategori[$b], 0, ',', '.') . "</td>";
                                    }
                                    echo "<td class='text-end'  style='padding-right:4px;'>" . number_format($grandTotalKategori, 0, ',', '.') . "</td>";
                                    echo "</tr>";
                                }
                                ?>
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