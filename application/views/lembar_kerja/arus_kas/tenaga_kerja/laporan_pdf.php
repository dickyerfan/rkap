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
                        <p class="fw-bold mb-2 fs-6"><?= $title . ' ' .  $tahun; ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <table class="table table-sm table-bordered tableUtama">
                            <thead>
                                <tr>
                                    <th class="text-center">Uraian</th>
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
                                $current_bagian = '';
                                $subtotal_bagian = array_fill(1, 12, 0);
                                $grand_total = array_fill(1, 12, 0);
                                $grand_total_tahunan = 0;

                                foreach ($naker as $t) :
                                    // Jika bagian berubah
                                    if ($t->bagian != $current_bagian) {
                                        if ($current_bagian != '') {
                                            echo "<tr class='table-warning fw-bold'>";
                                            echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                            $subtotal_tahun = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                                $subtotal_tahun += $subtotal_bagian[$i];
                                            }
                                            echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td>";
                                            echo "</tr>";

                                            // Tambahkan ke total keseluruhan
                                            for ($i = 1; $i <= 12; $i++) {
                                                $grand_total[$i] += $subtotal_bagian[$i];
                                            }
                                            $grand_total_tahunan += $subtotal_tahun;

                                            $subtotal_bagian = array_fill(1, 12, 0);
                                        }

                                        // Header bagian baru
                                        echo "<tr class='table-secondary'><td colspan='14'><b>" . strtoupper($t->bagian) . "</b></td></tr>";
                                        $current_bagian = $t->bagian;
                                    }

                                    // Header nama pegawai
                                    echo "<tr><td colspan='14'><b>{$t->nama}</b> - <b>{$t->jabatan}</b>";
                                    echo "</td></tr>";

                                    // Data tunjangan lengkap per pegawai
                                    $items = [
                                        'Gaji Pokok' => [
                                            $t->jan_gaji, $t->feb_gaji, $t->mar_gaji, $t->apr_gaji, $t->mei_gaji, $t->jun_gaji,
                                            $t->jul_gaji, $t->agu_gaji, $t->sep_gaji, $t->okt_gaji, $t->nov_gaji, $t->des_gaji
                                        ],
                                        'Tunjangan Istri' => [
                                            $t->jan_istri, $t->feb_istri, $t->mar_istri, $t->apr_istri, $t->mei_istri, $t->jun_istri,
                                            $t->jul_istri, $t->agu_istri, $t->sep_istri, $t->okt_istri, $t->nov_istri, $t->des_istri
                                        ],
                                        'Tunjangan Anak' => [
                                            $t->jan_anak, $t->feb_anak, $t->mar_anak, $t->apr_anak, $t->mei_anak, $t->jun_anak,
                                            $t->jul_anak, $t->agu_anak, $t->sep_anak, $t->okt_anak, $t->nov_anak, $t->des_anak
                                        ],
                                        'Tunjangan Jabatan' => [
                                            $t->jan_jabatan, $t->feb_jabatan, $t->mar_jabatan, $t->apr_jabatan, $t->mei_jabatan, $t->jun_jabatan,
                                            $t->jul_jabatan, $t->agu_jabatan, $t->sep_jabatan, $t->okt_jabatan, $t->nov_jabatan, $t->des_jabatan
                                        ],
                                        'Tunjangan Transport' => [
                                            $t->jan_transport, $t->feb_transport, $t->mar_transport, $t->apr_transport, $t->mei_transport, $t->jun_transport,
                                            $t->jul_transport, $t->agu_transport, $t->sep_transport, $t->okt_transport, $t->nov_transport, $t->des_transport
                                        ],
                                        'Tunjangan Pangan' => [
                                            $t->jan_pangan, $t->feb_pangan, $t->mar_pangan, $t->apr_pangan, $t->mei_pangan, $t->jun_pangan,
                                            $t->jul_pangan, $t->agu_pangan, $t->sep_pangan, $t->okt_pangan, $t->nov_pangan, $t->des_pangan
                                        ],
                                        'Uang Makan' => [
                                            $t->jan_makan, $t->feb_makan, $t->mar_makan, $t->apr_makan, $t->mei_makan, $t->jun_makan,
                                            $t->jul_makan, $t->agu_makan, $t->sep_makan, $t->okt_makan, $t->nov_makan, $t->des_makan
                                        ],
                                        'Tunjangan Perumahan' => [
                                            $t->jan_perumahan, $t->feb_perumahan, $t->mar_perumahan, $t->apr_perumahan, $t->mei_perumahan, $t->jun_perumahan,
                                            $t->jul_perumahan, $t->agu_perumahan, $t->sep_perumahan, $t->okt_perumahan, $t->nov_perumahan, $t->des_perumahan
                                        ],
                                        'BPJS Kesehatan' => [
                                            $t->jan_bpjs_kes, $t->feb_bpjs_kes, $t->mar_bpjs_kes, $t->apr_bpjs_kes, $t->mei_bpjs_kes, $t->jun_bpjs_kes,
                                            $t->jul_bpjs_kes, $t->agu_bpjs_kes, $t->sep_bpjs_kes, $t->okt_bpjs_kes, $t->nov_bpjs_kes, $t->des_bpjs_kes
                                        ],
                                        'BPJS TK' => [
                                            $t->jan_bpjs_tk, $t->feb_bpjs_tk, $t->mar_bpjs_tk, $t->apr_bpjs_tk, $t->mei_bpjs_tk, $t->jun_bpjs_tk,
                                            $t->jul_bpjs_tk, $t->agu_bpjs_tk, $t->sep_bpjs_tk, $t->okt_bpjs_tk, $t->nov_bpjs_tk, $t->des_bpjs_tk
                                        ],
                                        'Dapenmapamsi' => [
                                            $t->jan_dapen, $t->feb_dapen, $t->mar_dapen, $t->apr_dapen, $t->mei_dapen, $t->jun_dapen,
                                            $t->jul_dapen, $t->agu_dapen, $t->sep_dapen, $t->okt_dapen, $t->nov_dapen, $t->des_dapen
                                        ],
                                    ];

                                    // Tampilkan setiap item
                                    foreach ($items as $label => $values) {
                                        echo "<tr><td>{$label}</td>";
                                        $total_tahun = 0;
                                        for ($i = 0; $i < 12; $i++) {
                                            $val = (float)$values[$i];
                                            echo "<td class='text-end'>" . number_format($val, 0, ',', '.') . "</td>";
                                            $subtotal_bagian[$i + 1] += $val;
                                            $total_tahun += $val;
                                        }
                                        echo "<td class='text-end fw-bold'>" . number_format($total_tahun, 0, ',', '.') . "</td></tr>";
                                    }

                                    // Total Gaji Pegawai
                                    echo "<tr class='table-light fw-bold'>";
                                    echo "<td>Jumlah</td>";
                                    $total_tahun_pegawai = 0;
                                    for ($i = 1; $i <= 12; $i++) {
                                        $field = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'][$i - 1] . '_t_gaji';
                                        $val = (float)$t->$field;
                                        echo "<td class='text-end'>" . number_format($val, 0, ',', '.') . "</td>";
                                        $subtotal_bagian[$i] += $val;
                                        $total_tahun_pegawai += $val;
                                    }
                                    echo "<td class='text-end fw-bold'>" . number_format($total_tahun_pegawai, 0, ',', '.') . "</td></tr>";

                                endforeach;

                                // Subtotal bagian terakhir
                                if ($current_bagian != '') {
                                    echo "<tr class='table-warning fw-bold'>";
                                    echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                                    $subtotal_tahun = 0;
                                    for ($i = 1; $i <= 12; $i++) {
                                        echo "<td class='text-end'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                        $subtotal_tahun += $subtotal_bagian[$i];
                                    }
                                    echo "<td class='text-end'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td></tr>";
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