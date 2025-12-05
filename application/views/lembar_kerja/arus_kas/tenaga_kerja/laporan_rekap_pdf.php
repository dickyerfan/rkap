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
                        <p class="fw-bold mb-3 fs-6"><?= $title . ' ' .  $tahun; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <table class="table table-sm table-bordered tableUtama">
                            <thead class="table-secondary align-middle">
                                <tr>
                                    <th class="text-center" rowspan="2">URAIAN</th>
                                    <th class="text-center" colspan="12">BULAN</th>
                                    <th class="text-center" rowspan="2">JUMLAH</th>
                                </tr>
                                <tr>
                                    <th class="text-center">JAN</th>
                                    <th class="text-center">FEB</th>
                                    <th class="text-center">MAR</th>
                                    <th class="text-center">APR</th>
                                    <th class="text-center">MEI</th>
                                    <th class="text-center">JUN</th>
                                    <th class="text-center">JUL</th>
                                    <th class="text-center">AGS</th>
                                    <th class="text-center">SEP</th>
                                    <th class="text-center">OKT</th>
                                    <th class="text-center">NOV</th>
                                    <th class="text-center">DES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_tahunan = 0;
                                $kategori_grup = '';
                                $subtotal = array_fill_keys(['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'total'], 0);
                                $grandtotal = $subtotal;

                                foreach ($rekap as $r) :
                                    // Jika kategori berubah, cetak subtotal
                                    if ($kategori_grup != '' && $kategori_grup != $r->kategori) :
                                        echo "<tr class='table-warning fw-bold'>
                                                <td  class='text-end'>Subtotal {$kategori_grup}</td>";
                                        foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                                            echo "<td class='text-end'>" . number_format($subtotal[$b], 0, ',', '.') . "</td>";
                                        echo "<td class='text-end'>" . number_format($subtotal['total'], 0, ',', '.') . "</td></tr>";

                                        $subtotal = array_fill_keys(array_keys($subtotal), 0);
                                    endif;

                                    // Jika kategori baru
                                    if ($kategori_grup != $r->kategori) :
                                        echo "<tr class='table-info fw-bold'><td colspan='14'>{$r->kategori}</td></tr>";
                                        $kategori_grup = $r->kategori;
                                    endif;
                                    $bagian = strtoupper($r->bagian);
                                    // Baris data
                                    echo "<tr>
                                                    <td> $bagian</td>
                                                    <td class='text-end pe-1'>" . number_format($r->jan, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->feb, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->mar, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->apr, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->mei, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->jun, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->jul, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->agu, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->sep, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->okt, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->nov, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1'>" . number_format($r->des, 0, ',', '.') . "</td>
                                                    <td class='text-end pe-1 fw-bold'>" . number_format($r->total_tahun, 0, ',', '.') . "</td>
                                                </tr>";

                                    // Tambah subtotal
                                    foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                                        $subtotal[$b] += $r->$b;
                                    $subtotal['total'] += $r->total_tahun;

                                    foreach ($subtotal as $b => $v) $grandtotal[$b] += $r->$b ?? 0;
                                    $grandtotal['total'] += $r->total_tahun;
                                endforeach;

                                // Subtotal terakhir
                                if ($kategori_grup != '') :
                                    echo "<tr class='table-warning fw-bold'>
                                                    <td  class='text-end pe-1'>Subtotal {$kategori_grup}</td>";
                                    foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                                        echo "<td class='text-end pe-1'>" . number_format($subtotal[$b], 0, ',', '.') . "</td>";
                                    echo "<td class='text-end pe-1'>" . number_format($subtotal['total'], 0, ',', '.') . "</td></tr>";
                                endif;

                                // Total keseluruhan
                                echo "<tr class='table-danger fw-bolder'>
                                                <td  class='text-end pe-1'>TOTAL BIAYA PEGAWAI</td>";
                                foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $b)
                                    echo "<td class='text-end pe-1'>" . number_format($grandtotal[$b], 0, ',', '.') . "</td>";
                                echo "<td class='text-end pe-1'>" . number_format($grandtotal['total'], 0, ',', '.') . "</td></tr>";
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