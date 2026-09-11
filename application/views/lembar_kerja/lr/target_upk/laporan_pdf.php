<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Target Kinerja UPK</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            margin: 20pt 20pt 30pt 80pt;
        }

        header table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        header td {
            border: none;
            padding: 2px;
            vertical-align: middle;
        }

        header p {
            margin: 0;
            font-size: 10pt;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        .title {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin: 6px 0;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 2px 4px;
            vertical-align: middle;
            font-size: 6.5pt;
        }

        table.data-table th {
            text-align: center;
            font-weight: bold;
        }

        table.data-table td.num {
            text-align: right;
        }

        table.data-table td.num-bold {
            text-align: right;
            font-weight: bold;
        }

        table.data-table td.center {
            text-align: center;
        }

        .ttd-wrap {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box {
            text-align: center;
            min-width: 200px;
        }

        .ttd-space {
            height: 50px;
        }
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
                    <p>Rencana Kerja &amp; Anggaran</p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <?php
        $bulan_list = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $rekening_map  = [];
        foreach ($rekening  as $r) $rekening_map[(int)$r->bulan]  = $r->jumlah_rekening;
        $pemakaian_map = [];
        foreach ($pemakaian as $r) $pemakaian_map[(int)$r->bulan] = $r->pemakaian;
        $pendapatan_map = [];
        foreach ($pendapatan as $r) $pendapatan_map[(int)$r->bulan] = $r->pendapatan;
        ?>

        <div class="title">
            <p><?= $title ?></p>
            <p><?= strtoupper($judul_upk) ?></p>
        </div>

        <p style="font-weight: bold; margin-bottom: 4px;">A. Target Pelanggan</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Indikator</th>
                    <?php foreach ($bulan_list as $b) : ?><th><?= $b ?></th><?php endforeach; ?>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $indikator_list = [
                    'sr_baru'     => 'SR Baru',
                    'penutupan'   => 'Penutupan',
                    'pencabutan'  => 'Pencabutan',
                    'pembukaan'   => 'Pembukaan',
                    'tera_meter'  => 'Tera Meter',
                    'ganti_meter' => 'Ganti Meter',
                    'efi_tagih'   => 'Efisiensi Penagihan'
                ];
                $no = 1;
                foreach ($indikator_list as $key => $label) :
                    $total = 0;
                    $jumlah_bulan = 0;
                ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><?= $label ?></td>
                        <?php foreach ($bulan_list as $i => $b) :
                            $nilai = 0;
                            foreach ($tampil as $row) {
                                if ($row->bulan == $i) {
                                    $nilai = $row->$key;
                                    break;
                                }
                            }
                            $total += $nilai;
                            if ($nilai != 0) $jumlah_bulan++;
                        ?>
                            <td class="num">
                                <?= ($key === 'efi_tagih') ? number_format($nilai, 2, ',', '.') : number_format($nilai) ?>
                            </td>
                        <?php endforeach; ?>
                        <td class="num-bold">
                            <?php if ($key === 'efi_tagih') :
                                echo number_format(($jumlah_bulan > 0) ? $total / $jumlah_bulan : 0, 2, ',', '.');
                            else :
                                echo number_format($total);
                            endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="font-weight: bold; margin-bottom: 4px; margin-top: 12px;">B. Target Pendapatan</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Indikator</th>
                    <?php foreach ($bulan_list as $b) : ?><th><?= $b ?></th><?php endforeach; ?>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_rek = 0;
                $total_pend = 0;
                $total_pakai = 0;
                foreach ($bulan_list as $i => $b) {
                    $total_rek   += $rekening_map[$i]   ?? 0;
                    $total_pend  += $pendapatan_map[$i] ?? 0;
                    $total_pakai += $pemakaian_map[$i]  ?? 0;
                }
                $pola_total = ($total_rek > 0) ? $total_pakai / $total_rek : 0;
                ?>
                <tr>
                    <td class="center">1</td>
                    <td>Jumlah Rekening</td>
                    <?php foreach ($bulan_list as $i => $b) : ?>
                        <td class="num"><?= number_format($rekening_map[$i] ?? 0) ?></td>
                    <?php endforeach; ?>
                    <td class="num-bold"><?= number_format($total_rek) ?></td>
                </tr>
                <tr>
                    <td class="center">2</td>
                    <td>Pendapatan (Rp)</td>
                    <?php foreach ($bulan_list as $i => $b) : ?>
                        <td class="num"><?= number_format($pendapatan_map[$i] ?? 0, 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num-bold"><?= number_format($total_pend, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="center">3</td>
                    <td>Pemakaian (m&sup3;)</td>
                    <?php foreach ($bulan_list as $i => $b) : ?>
                        <td class="num"><?= number_format($pemakaian_map[$i] ?? 0, 0, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num-bold"><?= number_format($total_pakai, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td class="center">4</td>
                    <td>Pola Konsumsi (m&sup3;/rek)</td>
                    <?php foreach ($bulan_list as $i => $b) :
                        $rek   = $rekening_map[$i]  ?? 0;
                        $pakai = $pemakaian_map[$i] ?? 0;
                        $pola  = ($rek > 0) ? $pakai / $rek : 0;
                    ?>
                        <td class="num"><?= number_format($pola, 2, ',', '.') ?></td>
                    <?php endforeach; ?>
                    <td class="num-bold"><?= number_format($pola_total, 2, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>

        <?php if (!empty($info_upk)) : ?>
            <div class="ttd-wrap">
                <div class="ttd-box">
                    <p>Mengetahui,</p>
                    <p>Ka UPK <?= strtoupper($info_upk->nama_upk ?? '') ?></p>
                    <div class="ttd-space"></div>
                    <p style="text-decoration:underline;"><?= $info_upk->nama_ka_upk ?? '................................' ?></p>
                </div>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>
