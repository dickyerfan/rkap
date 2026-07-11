<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Target Kinerja UPK</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.75rem;
        }

        header p {
            margin: 0;
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
            font-size: 0.72rem;
        }

        .tableUtama th,
        .tableUtama td {
            padding: 2px 4px;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
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
        <div class="container-fluid">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <td width="8%">
                            <img src="<?= base_url('assets/img/tirta.png'); ?>" alt="Logo" width="40">
                        </td>
                        <td>
                            <p>Rencana Kerja &amp; Anggaran</p>
                            <p>Perumdam Ijen Tirta Bondowoso</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </header>
    <main>
        <div class="container-fluid">
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

            <div class="text-center mb-2">
                <p class="fw-bold"><?= $title ?></p>
                <p class="fw-bold"><?= strtoupper($judul_upk) ?></p>
            </div>

            <!-- Tabel A -->
            <p class="fw-bold mb-1">A. Target Pelanggan</p>
            <table class="table table-sm table-bordered tableUtama" width="100%">
                <thead>
                    <tr class="text-center">
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
                            <td class="text-center"><?= $no++ ?></td>
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
                                <td class="text-end">
                                    <?= ($key === 'efi_tagih') ? number_format($nilai, 2, ',', '.') : number_format($nilai) ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="text-end fw-bold">
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

            <!-- Tabel B -->
            <p class="fw-bold mb-1 mt-3">B. Target Pendapatan</p>
            <table class="table table-sm table-bordered tableUtama" width="100%">
                <thead>
                    <tr class="text-center">
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
                    $avg_rek    = $total_rek / 12;
                    $pola_total = ($avg_rek > 0) ? $total_pakai / $avg_rek : 0;
                    ?>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Jumlah Rekening</td>
                        <?php foreach ($bulan_list as $i => $b) : ?>
                            <td class="text-end"><?= number_format($rekening_map[$i] ?? 0) ?></td>
                        <?php endforeach; ?>
                        <td class="text-end fw-bold"><?= number_format($total_rek) ?></td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Pendapatan (Rp)</td>
                        <?php foreach ($bulan_list as $i => $b) : ?>
                            <td class="text-end"><?= number_format($pendapatan_map[$i] ?? 0, 0, ',', '.') ?></td>
                        <?php endforeach; ?>
                        <td class="text-end fw-bold"><?= number_format($total_pend, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Pemakaian (m&sup3;)</td>
                        <?php foreach ($bulan_list as $i => $b) : ?>
                            <td class="text-end"><?= number_format($pemakaian_map[$i] ?? 0, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                        <td class="text-end fw-bold"><?= number_format($total_pakai, 2, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td>Pola Konsumsi (m&sup3;/rek)</td>
                        <?php foreach ($bulan_list as $i => $b) :
                            $rek   = $rekening_map[$i]  ?? 0;
                            $pakai = $pemakaian_map[$i] ?? 0;
                            $pola  = ($rek > 0) ? $pakai / $rek : 0;
                        ?>
                            <td class="text-end"><?= number_format($pola, 2, ',', '.') ?></td>
                        <?php endforeach; ?>
                        <td class="text-end fw-bold"><?= number_format($pola_total, 2, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Tanda Tangan -->
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

        </div>
    </main>
</body>

</html>