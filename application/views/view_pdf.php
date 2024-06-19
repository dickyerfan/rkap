<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        @font-face {
            font-family: 'Scada';
            src: url("<?= base_url('assets/fonts/Scada-Regular.ttf') ?>");
        }

        body {
            margin: -20pt -20pt -20pt -20pt;
            font-family: 'Arial, Helvetica, sans-serif';
        }

        .teks {
            font-size: 0.7em;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST['add_post'])) {
        $bln = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
    } else {
        $bln = date('m');
        $tahun = date('Y');
    }
    switch ($bln) {
        case '01':
            $bln = "Januari";
            break;
        case '02':
            $bln = "Februari";
            break;
        case '03':
            $bln = "Maret";
            break;
        case '04':
            $bln = "April";
            break;
        case '05':
            $bln = "Mei";
            break;
        case '06':
            $bln = "Juni";
            break;
        case '07':
            $bln = "Juli";
            break;
        case '08':
            $bln = "Agustus";
            break;
        case '09':
            $bln = "September";
            break;
        case '10':
            $bln = "Oktober";
            break;
        case '11':
            $bln = "Nofember";
            break;
        case '12':
            $bln = "Desember";
            break;
    }
    ?>
    <div class="container" style="padding:20px; background-color:aquamarine;">
        <table width="100%">
            <tr align="center">
                <td style="font-size:1.2em ;">
                    BONDOWOSO MENGAJI
                </td>
            </tr>
            <tr align="center">
                <td>
                    <?= strtoupper($title)  ?>
                </td>
            </tr>
        </table>
        <br>
        <table border="1" cellspacing="1" cellpadding="1" width="100%" class="teks">
            <thead>
                <tr align="center" style="font-weight:bold; font-size:1em; line-height:1.5; background-color:grey; color:white;">
                    <td width="10%">No</td>
                    <td width="20%">Tanggal</td>
                    <td width="40%">Uraian</td>
                    <td width="15%">Penerimaan (Rp)</td>
                    <td width="15%">Pengeluaran (Rp)</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($transaksi as $row) : ?>
                    <?php
                    $tgls = strtotime($row->tanggal);
                    $day = date('d', $tgls);
                    $bln = date('m', $tgls);
                    $tahun = date('Y', $tgls);

                    switch ($bln) {
                        case '01':
                            $bln = "Januari";
                            break;
                        case '02':
                            $bln = "Februari";
                            break;
                        case '03':
                            $bln = "Maret";
                            break;
                        case '04':
                            $bln = "April";
                            break;
                        case '05':
                            $bln = "Mei";
                            break;
                        case '06':
                            $bln = "Juni";
                            break;
                        case '07':
                            $bln = "Juli";
                            break;
                        case '08':
                            $bln = "Agustus";
                            break;
                        case '09':
                            $bln = "September";
                            break;
                        case '10':
                            $bln = "Oktober";
                            break;
                        case '11':
                            $bln = "Nofember";
                            break;
                        case '12':
                            $bln = "Desember";
                            break;
                    }
                    ?>
                    <tr style="background-color:white ;">
                        <td align="center"><?= $no++ ?></td>
                        <td align="center"><?= $day . ' ' . $bln . ' ' . $tahun ?></td>
                        <td><?= $row->uraian ?></td>
                        <!-- <td><?= $row->jenis_transaksi ?></td> -->
                        <td align="right"><?= $row->jenis_transaksi == 'penerimaan' ? number_format($row->rupiah, '0', ',', '.') . ',-' : ' ' ?></td>
                        <td align="right"><?= $row->jenis_transaksi == 'pengeluaran' ? number_format($row->rupiah, '0', ',', '.') . ',-' : ' ' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <thead>
                <tr style="background-color:white ;">
                    <th align="center" colspan="3">TOTAL</th>
                    <th align="right"><?= number_format($totalMasuk, 0, ',', '.') ?>,-</th>
                    <th align="right"><?= number_format($totalKeluar, 0, ',', '.') ?>,-</th>
                </tr>
                <tr style="background-color:white ;">
                    <th align="center" colspan="3">SALDO AKHIR</th>
                    <th align="right" colspan="2"><?= number_format($saldo, 0, ',', '.') ?>,-</th>
                </tr>
            </thead>
        </table>
        <br><br>
        <!-- <table border="0" cellspacing="0" cellpadding="1" width="100%" class="teks">
        <tr align="center">
            <td width="45%">Mengetahui</td>
            <td width="10%"></td>
            <td width="45%">Dibuat oleh</td>
        </tr>
        <tr align="center">
            <td width="45%">Ketua</td>
            <td width="10%"></td>
            <td width="45%">Bendahara</td>
        </tr>
        <br><br><br><br>
        <tr align="center">
            <td width="45%">Tri Yulianto</td>
            <td width="10%"></td>
            <td width="45%">Dicky Erfan S</td>
        </tr>
    </table> -->
    </div>
</body>

</html>