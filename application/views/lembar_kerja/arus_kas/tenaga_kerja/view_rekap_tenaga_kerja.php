<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <form action="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/rekap') ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <select name="tahun" class="form-select" style="width: 100px; margin-left:10px;">
                                    <?php
                                    $tahun_mulai = date('Y') - 10;
                                    $tahun_selesai = date('Y') + 1;
                                    for ($i = $tahun_mulai; $i <= $tahun_selesai; $i++) :
                                    ?>
                                        <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <input type="submit" value="Tampilkan" class="neumorphic-button" style="margin-left:5px;">
                            </div>
                        </form>
                        <div class="navbar-nav">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/rekap') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Reset</button> </a>
                        </div>

                        <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" target="_blank" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja/export_rekap_pdf') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button> </a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a class="nav-link fw-bold" href="<?= base_url('lembar_kerja/arus_kas/tenaga_kerja') ?>" style="font-size: 0.8rem; color:black;">
                                <button class="neumorphic-button"><i class="fa-solid fa-arrow-left"></i> Kembali</button>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 text-center">
                            <h5><?= $title . ' ' .  $tahun; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;" id="example4">
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
            </div>
        </div>
    </main>