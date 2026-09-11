<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKAP | <?= $title; ?></title>

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
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun + 1 ?></p>
        <p class="title"><?= strtoupper($namaUpk);  ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Bagian/UPK</th>
                    <th colspan="2">Perkiraan</th>
                    <th colspan="3">URAIAN TENTANG USULAN</th>
                    <!-- <th rowspan="2">Keterangan</th> -->
                    <!-- <th rowspan="2">Action</th> -->
                </tr>
                <tr>
                    <th>No Per</th>
                    <th>Nama</th>
                    <!-- <th>Latar Belakang</th>
                    <th>Solusi/Usulan</th> -->
                    <th>Volume</th>
                    <th>Harga</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tampil as $row) :
                    $id = $row->id_usulanUmum;
                    $harga = $row->biaya;
                    $satuan = $row->volume;
                    $jumlah = $harga * $satuan;
                ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><?= $row->bagian_upk ?></td>
                        <td><?= $row->no_perkiraan ?></td>
                        <td><?= $row->nama_perkiraan ?></td>
                        <!-- <td><?= $row->latar_belakang ?></td>
                        <td><?= $row->solusi ?></td> -->
                        <td class="center"><?= number_format($row->volume, 0, ',', '.') ?> <?= $row->satuan ?></td>
                        <td class="num"><?= number_format($row->biaya, 0, ',', '.') ?></td>
                        <td class="num"><?= number_format($jumlah, 0, ',', '.') ?></td>
                        <!-- <td><?= $row->ket ?></td> -->
                        <!-- <td class="center">
                                <a href="<?= base_url('admin/usulan_barang/edit_usulan_barang/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                <a href="<?= base_url('admin/usulan_barang/detail_usulan_barang/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                <a href="<?= base_url('admin/usulan_barang/hapus_usulan_barang/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                            </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="num-bold">Total</th>
                    <th class="num-bold"><?= number_format(array_sum(array_column($tampil, 'biaya')), 0, ',', '.') ?></th>
                    <th class="num-bold"><?= number_format(array_sum(array_map(function ($item) {
                                                return $item->biaya * $item->volume;
                                            }, $tampil)), 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>

</html>
