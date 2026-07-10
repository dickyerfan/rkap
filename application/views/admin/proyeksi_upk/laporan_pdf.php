<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RKAP</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 0.85rem; }
        header p { margin: 0; }
        hr { height: 1px; background-color: black !important; }
        .tableUtama, .tableUtama thead, .tableUtama tr, .tableUtama th, .tableUtama td {
            border: 1px solid black;
            font-size: 0.85rem;
        }
        .tableUtama th, .tableUtama td { padding: 3px 6px; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
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
            $bulan = [
                1  => 'Jan', 2  => 'Feb', 3  => 'Mar', 4  => 'Apr',
                5  => 'Mei', 6  => 'Jun', 7  => 'Jul', 8  => 'Agu',
                9  => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
            $nama_upk = (!empty($tampil)) ? $tampil[0]->nama_upk : $this->session->userdata('upk_bagian');
            ?>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center mb-2">
                        <p class="fw-bold"><?= $title ?></p>
                        <p class="fw-bold">UPK <?= strtoupper($nama_upk) ?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered tableUtama" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Indikator</th>
                                    <?php foreach ($bulan as $b) : ?>
                                        <th><?= $b ?></th>
                                    <?php endforeach; ?>
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
                                ?>
                                <?php foreach ($indikator_list as $key => $label) : ?>
                                    <?php
                                    $total = 0;
                                    $jumlah_bulan = 0;
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $label ?></td>
                                        <?php foreach ($bulan as $i => $b) : ?>
                                            <?php
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
                                                <?php if ($key === 'efi_tagih') : ?>
                                                    <?= number_format($nilai, 2, ',', '.') ?>
                                                <?php else : ?>
                                                    <?= number_format($nilai) ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                        <td class="text-end fw-bold">
                                            <?php if ($key === 'efi_tagih') : ?>
                                                <?= number_format(($jumlah_bulan > 0) ? $total / $jumlah_bulan : 0, 2, ',', '.') ?>
                                            <?php else : ?>
                                                <?= number_format($total) ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
