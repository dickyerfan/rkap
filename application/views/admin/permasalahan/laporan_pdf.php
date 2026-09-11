<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun + 1; ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <p class="title"><?= $title . ' ' .  $tahun ?></p>
        <p class="title">BAGIAN <?= strtoupper($namaUpk);  ?></p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bagian UPK</th>
                    <th>Sub Bagian</th>
                    <th>Permasalahan</th>
                    <th>Penyebab</th>
                    <th>Tindak Lanjut</th>
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tampil as $row) :
                    $id = $row->id_permasalahan;
                ?>
                    <tr>
                        <td class="center"><?= $no++ ?></td>
                        <td><?= strtoupper($row->bagian_upk) ?></td>
                        <td><?= $row->sub_bagian ?></td>
                        <td><?= $row->permasalahan ?></td>
                        <td><?= $row->penyebab ?></td>
                        <td><?= $row->tindak_lanjut ?></td>
                        <!-- <td class="center">
                                <a href="<?= base_url('rkap/permasalahan/edit_permasalahan/') ?><?= $id ?>"><i class="fas fa-edit text-success"></i></a>
                                <a href="<?= base_url('rkap/permasalahan/detail_permasalahan/') ?><?= $id ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                <a href="<?= base_url('rkap/permasalahan/hapus_permasalahan/') ?><?= $id ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a>
                            </td> -->
                    </tr>
                <?php endforeach; ?>

        </table>
    </main>
</body>

</html>
