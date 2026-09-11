<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RKAP</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 8pt; margin: 20pt 20pt 30pt 80pt; }
        header table { width: 100%; border-collapse: collapse; border: none; }
        header td { border: none; padding: 2px; vertical-align: middle; }
        header p { margin: 0; font-size: 10pt; }
        hr { border: none; border-top: 1px solid #000; margin: 4px 0; }
        .title { text-align: center; font-size: 9pt; font-weight: bold; margin: 6px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 2px 4px; vertical-align: middle; font-size: 6.5pt; }
        table.data-table th { text-align: center; font-weight: bold; }
        table.data-table td.num { text-align: right; }
        table.data-table td.num-bold { text-align: right; font-weight: bold; }
        table.data-table td.center { text-align: center; }
        table.data-table tfoot td { font-weight: bold; background-color: #e9ecef; border-top: 2px solid #6c757d; }
    </style>

</head>

<body>
    <header>
        <table>
            <tr>
                <td width="40">
                    <?php
                    $logo_path = FCPATH . 'assets/img/tirta.png';
                    if (file_exists($logo_path)) :
                        $logo_data = base64_encode(file_get_contents($logo_path));
                        $logo_mime = mime_content_type($logo_path);
                    ?>
                        <img src="data:<?= $logo_mime; ?>;base64,<?= $logo_data; ?>" alt="Logo" width="40">
                    <?php endif; ?>
                </td>
                <td>
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun; ?></p>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Uraian</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Apr</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Agu</th>
                    <th>Sep</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Des</th>
                    <th>JUMLAH</th>
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
                            echo "<tr style='background-color:#fff3cd;font-weight:bold;'>";
                            echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                            $subtotal_tahun = 0;
                            for ($i = 1; $i <= 12; $i++) {
                                echo "<td class='num'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                                $subtotal_tahun += $subtotal_bagian[$i];
                            }
                            echo "<td class='num'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td>";
                            echo "</tr>";

                            // Tambahkan ke total keseluruhan
                            for ($i = 1; $i <= 12; $i++) {
                                $grand_total[$i] += $subtotal_bagian[$i];
                            }
                            $grand_total_tahunan += $subtotal_tahun;

                            $subtotal_bagian = array_fill(1, 12, 0);
                        }

                        // Header bagian baru
                        echo "<tr style='background-color:#e9ecef;font-weight:bold;'><td colspan='14'>" . strtoupper($t->bagian) . "</td></tr>";
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
                            echo "<td class='num'>" . number_format($val, 0, ',', '.') . "</td>";
                            $subtotal_bagian[$i + 1] += $val;
                            $total_tahun += $val;
                        }
                        echo "<td class='num-bold'>" . number_format($total_tahun, 0, ',', '.') . "</td></tr>";
                    }

                    // Total Gaji Pegawai
                    echo "<tr style='background-color:#f8f9fa;font-weight:bold;'>";
                    echo "<td>Jumlah</td>";
                    $total_tahun_pegawai = 0;
                    for ($i = 1; $i <= 12; $i++) {
                        $field = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'][$i - 1] . '_t_gaji';
                        $val = (float)$t->$field;
                        echo "<td class='num'>" . number_format($val, 0, ',', '.') . "</td>";
                        $total_tahun_pegawai += $val;
                    }
                    echo "<td class='num-bold'>" . number_format($total_tahun_pegawai, 0, ',', '.') . "</td></tr>";

                endforeach;

                // Subtotal bagian terakhir
                if ($current_bagian != '') {
                    echo "<tr style='background-color:#fff3cd;font-weight:bold;'>";
                    echo "<td>Total Gaji " . strtoupper($current_bagian) . "</td>";
                    $subtotal_tahun = 0;
                    for ($i = 1; $i <= 12; $i++) {
                        echo "<td class='num'>" . number_format($subtotal_bagian[$i], 0, ',', '.') . "</td>";
                        $subtotal_tahun += $subtotal_bagian[$i];
                    }
                    echo "<td class='num'>" . number_format($subtotal_tahun, 0, ',', '.') . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>
