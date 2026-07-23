<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RKAP - Dashboard</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 0.65rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 2px 4px; text-align: center; }
        th { background-color: #ddd; font-weight: bold; }
        .label { text-align: left; min-width: 100px; }
        .num { text-align: right; }
        .bold { font-weight: bold; }
        .section-title { font-weight: bold; background-color: #e8e8e8; text-align: left; padding-left: 6px; }
        .success { color: #006600; }
        .danger { color: #cc0000; }
        .bg-primary { background-color: #b8d4f0; }
        .bg-danger { background-color: #f0b8b8; }
        .bg-warning { background-color: #f0e6b8; }
        .bg-success { background-color: #b8f0b8; }
        .bg-info { background-color: #b8d4f0; }
        hr { height: 1px; background-color: #000; }
        .header table { border: none; font-size: 0.75rem; }
        .header td { border: none; }
        .page-break { page-break-before: always; }
        h4 { margin: 10px 0 6px; font-size: 0.75rem; }
        h3 { margin: 12px 0 6px; font-size: 0.85rem; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td width="50">
                    <img src="<?= base_url('assets/img/tirta.png') ?>" width="40">
                </td>
                <td>
                    <p>Rencana Kerja & Anggaran Tahun <?= $tahun_ini ?> / <?= $tahun_depan ?></p>
                    <p>Perumdam Ijen Tirta Bondowoso</p>
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <?php if (!empty($is_total)) : ?>
        <!-- ============ KONSOLIDASI ============ -->
        <h3>Laba Rugi RKAP Konsolidasi</h3>
        <table>
            <thead>
                <tr>
                    <th class="label">Uraian</th>
                    <th width="22%">Tahun <?= $tahun_ini ?> (Rp)</th>
                    <th width="22%">Tahun <?= $tahun_depan ?> (Rp)</th>
                    <th width="18%">Selisih (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="section-title"><td colspan="4">PENDAPATAN USAHA</td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Air</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.01']['total'] ?? 0) - ($pendapatan_ini['81.01']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Non Air</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.02']['total'] ?? 0) - ($pendapatan_ini['81.02']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Usaha Lainnya</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.03']['total'] ?? 0) - ($pendapatan_ini['81.03']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-primary bold"><td>Total Pendapatan Usaha</td>
                    <td class="num"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                    <td class="num <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'success' : 'danger' ?>"><?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?></td></tr>

                <tr class="section-title"><td colspan="4">BEBAN USAHA</td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Sumber Air</td>
                    <td class="num"><?= number_format($beban_ini['91']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['91']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['91']['total'] ?? 0) - ($beban_ini['91']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Pengolahan Air</td>
                    <td class="num"><?= number_format($beban_ini['92']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['92']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['92']['total'] ?? 0) - ($beban_ini['92']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Transmisi & Distribusi</td>
                    <td class="num"><?= number_format($beban_ini['93']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['93']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['93']['total'] ?? 0) - ($beban_ini['93']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban (HPP) Sambungan Baru</td>
                    <td class="num"><?= number_format($beban_ini['95']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['95']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['95']['total'] ?? 0) - ($beban_ini['95']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-danger bold"><td>Total Beban Usaha</td>
                    <td class="num"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td></tr>

                <tr class="bg-warning bold"><td>Laba / (Rugi) Kotor</td>
                    <td class="num"><?= number_format($laba_kotor_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_kotor_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_kotor_depan - $laba_kotor_ini, 0, ',', '.') ?></td></tr>

                <tr class="section-title"><td colspan="4">BEBAN UMUM DAN ADMINISTRASI</td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Umum & Administrasi</td>
                    <td class="num"><?= number_format($total_beban_umum_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_umum_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_umum_depan - $total_beban_umum_ini, 0, ',', '.') ?></td></tr>

                <tr class="bg-warning bold"><td>Laba / (Rugi) Operasional</td>
                    <td class="num"><?= number_format($laba_operasional_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_operasional_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_operasional_depan - $laba_operasional_ini, 0, ',', '.') ?></td></tr>

                <tr class="section-title"><td colspan="4">PENDAPATAN (BEBAN) NON OPERASIONAL</td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Non Operasional</td>
                    <td class="num"><?= number_format($non_usaha_ini['88']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($non_usaha_depan['88']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_ini['88']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Non Operasional</td>
                    <td class="num"><?= number_format($non_usaha_ini['98']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($non_usaha_depan['98']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($non_usaha_depan['98']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-info bold"><td>Jumlah Non Operasional</td>
                    <td class="num"><?= number_format(($non_usaha_ini['88']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0), 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_depan['98']['total'] ?? 0), 0, ',', '.') ?></td>
                    <td class="num"><?= number_format((($non_usaha_depan['88']['total'] ?? 0) - ($non_usaha_depan['98']['total'] ?? 0)) - (($non_usaha_ini['88']['total'] ?? 0) - ($non_usaha_ini['98']['total'] ?? 0)), 0, ',', '.') ?></td></tr>

                <tr class="bg-warning bold"><td>Laba Sebelum Pajak</td>
                    <td class="num"><?= number_format($laba_sebelum_pajak_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_sebelum_pajak_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_sebelum_pajak_depan - $laba_sebelum_pajak_ini, 0, ',', '.') ?></td></tr>

                <tr class="section-title"><td colspan="4">KEUNTUNGAN / (KERUGIAN) LUAR BIASA</td></tr>
                <tr><td class="label" style="padding-left:12px">Keuntungan Luar Biasa</td>
                    <td class="num"><?= number_format($luar_biasa_ini['89.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($luar_biasa_depan['89.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($luar_biasa_depan['89.01.01']['total'] ?? 0) - ($luar_biasa_ini['89.01.01']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Kerugian Luar Biasa</td>
                    <td class="num"><?= number_format($luar_biasa_ini['99.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($luar_biasa_depan['99.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($luar_biasa_depan['99.01.01']['total'] ?? 0) - ($luar_biasa_ini['99.01.01']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-info bold"><td>Jumlah Luar Biasa</td>
                    <td class="num"><?= number_format($total_luar_biasa_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_luar_biasa_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_luar_biasa_depan - $total_luar_biasa_ini, 0, ',', '.') ?></td></tr>

                <tr class="section-title"><td colspan="4">PAJAK PENGHASILAN</td></tr>
                <tr><td class="label" style="padding-left:12px">Taksiran Pajak (Pasal 25)</td>
                    <td class="num"><?= number_format($pajak_ini['97.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pajak_depan['97.01.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pajak_depan['97.01.01']['total'] ?? 0) - ($pajak_ini['97.01.01']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pajak Kini</td>
                    <td class="num"><?= number_format($pajak_ini['97.01.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pajak_depan['97.01.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pajak_depan['97.01.02']['total'] ?? 0) - ($pajak_ini['97.01.02']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Pajak Ditangguhkan</td>
                    <td class="num"><?= number_format($pajak_ini['97.01.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pajak_depan['97.01.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pajak_depan['97.01.03']['total'] ?? 0) - ($pajak_ini['97.01.03']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-info bold"><td>Total Pajak Penghasilan</td>
                    <td class="num"><?= number_format($total_pajak_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_pajak_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_pajak_depan - $total_pajak_ini, 0, ',', '.') ?></td></tr>

                <tr class="bg-success bold"><td>LABA / (RUGI) SETELAH PAJAK</td>
                    <td class="num"><?= number_format($laba_bersih_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_bersih_depan, 0, ',', '.') ?></td>
                    <td class="num <?= ($laba_bersih_depan - $laba_bersih_ini) >= 0 ? 'success' : 'danger' ?>"><?= number_format($laba_bersih_depan - $laba_bersih_ini, 0, ',', '.') ?></td></tr>
            </tbody>
        </table>

    <?php else : ?>
        <!-- ============ UPK ============ -->
        <h3>Ringkasan Laba Rugi <?= strtoupper($nama_upk) ?></h3>
        <table>
            <thead>
                <tr>
                    <th class="label">Uraian</th>
                    <th width="22%">Tahun <?= $tahun_ini ?> (Rp)</th>
                    <th width="22%">Tahun <?= $tahun_depan ?> (Rp)</th>
                    <th width="18%">Selisih (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-primary bold"><td>Pendapatan Usaha</td>
                    <td class="num"><?= number_format($total_pendapatan_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_pendapatan_depan, 0, ',', '.') ?></td>
                    <td class="num <?= ($total_pendapatan_depan - $total_pendapatan_ini) >= 0 ? 'success' : 'danger' ?>"><?= number_format($total_pendapatan_depan - $total_pendapatan_ini, 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Penjualan Air</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.01']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.01']['total'] ?? 0) - ($pendapatan_ini['81.01']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Non Air</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.02']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.02']['total'] ?? 0) - ($pendapatan_ini['81.02']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Pendapatan Aktiva</td>
                    <td class="num"><?= number_format($pendapatan_ini['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($pendapatan_depan['81.03']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($pendapatan_depan['81.03']['total'] ?? 0) - ($pendapatan_ini['81.03']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-danger bold"><td>Beban Usaha</td>
                    <td class="num"><?= number_format($total_beban_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_depan - $total_beban_ini, 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Sumber</td>
                    <td class="num"><?= number_format($beban_ini['91']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['91']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['91']['total'] ?? 0) - ($beban_ini['91']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Pengolahan</td>
                    <td class="num"><?= number_format($beban_ini['92']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['92']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['92']['total'] ?? 0) - ($beban_ini['92']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Transmisi Distribusi</td>
                    <td class="num"><?= number_format($beban_ini['93']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['93']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['93']['total'] ?? 0) - ($beban_ini['93']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban HPP Sambungan Baru</td>
                    <td class="num"><?= number_format($beban_ini['95']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($beban_depan['95']['total'] ?? 0, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format(($beban_depan['95']['total'] ?? 0) - ($beban_ini['95']['total'] ?? 0), 0, ',', '.') ?></td></tr>
                <tr class="bg-warning bold"><td>Laba Usaha</td>
                    <td class="num"><?= number_format($laba_usaha_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_usaha_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_usaha_depan - $laba_usaha_ini, 0, ',', '.') ?></td></tr>
                <tr><td class="label" style="padding-left:12px">Beban Umum</td>
                    <td class="num"><?= number_format($total_beban_umum_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_umum_depan, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($total_beban_umum_depan - $total_beban_umum_ini, 0, ',', '.') ?></td></tr>
                <tr class="bg-success bold"><td>Laba Sebelum Pajak</td>
                    <td class="num"><?= number_format($laba_bersih_ini, 0, ',', '.') ?></td>
                    <td class="num"><?= number_format($laba_bersih_depan, 0, ',', '.') ?></td>
                    <td class="num <?= ($laba_bersih_depan - $laba_bersih_ini) >= 0 ? 'success' : 'danger' ?>"><?= number_format($laba_bersih_depan - $laba_bersih_ini, 0, ',', '.') ?></td></tr>
            </tbody>
        </table>

        <div class="page-break"></div>
        <h3>Potensi SR <?= strtoupper($nama_upk) ?></h3>
        <table>
            <thead>
                <tr>
                    <th class="label">Indikator</th>
                    <th width="22%"><?= $tahun_ini - 1 ?></th>
                    <th width="22%"><?= $tahun_depan - 1 ?></th>
                    <th width="18%">Selisih</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Pelanggan Aktif (SR)</td>
                    <td class="num"><?= isset($potensi_sr_ini->plg_aktif) ? number_format($potensi_sr_ini->plg_aktif, 0, ',', '.') : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->plg_aktif) ? number_format($potensi_sr_depan->plg_aktif, 0, ',', '.') : '-' ?></td>
                    <td class="num <?= $selisih_plg_aktif >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_plg_aktif, 0, ',', '.') ?></td></tr>
                <tr><td>Tambahan SR</td>
                    <td class="num"><?= isset($potensi_sr_ini->tambah_sr) ? number_format($potensi_sr_ini->tambah_sr, 0, ',', '.') : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->tambah_sr) ? number_format($potensi_sr_depan->tambah_sr, 0, ',', '.') : '-' ?></td>
                    <td class="num <?= $selisih_tambah_sr >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_tambah_sr, 0, ',', '.') ?></td></tr>
                <tr><td>Kapasitas Produksi (lt/dtk)</td>
                    <td class="num"><?= isset($potensi_sr_ini->kap_pro) ? number_format($potensi_sr_ini->kap_pro, 2) : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->kap_pro) ? number_format($potensi_sr_depan->kap_pro, 2) : '-' ?></td>
                    <td class="num <?= $selisih_kap_pro >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_kap_pro, 2, ',', '.') ?></td></tr>
                <tr><td>Kapasitas Manfaat (lt/dtk)</td>
                    <td class="num"><?= isset($potensi_sr_ini->kap_manf) ? number_format($potensi_sr_ini->kap_manf, 2) : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->kap_manf) ? number_format($potensi_sr_depan->kap_manf, 2) : '-' ?></td>
                    <td class="num <?= $selisih_kap_manf >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_kap_manf, 2, ',', '.') ?></td></tr>
                <tr><td>Tingkat Kebocoran (%)</td>
                    <td class="num"><?= isset($potensi_sr_ini->tk_bocor) ? number_format($potensi_sr_ini->tk_bocor, 2) : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->tk_bocor) ? number_format($potensi_sr_depan->tk_bocor, 2) : '-' ?></td>
                    <td class="num <?= $selisih_tk_bocor >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_tk_bocor, 2, ',', '.') ?></td></tr>
                <tr><td>Pola Konsumsi (m³/SR/bln)</td>
                    <td class="num"><?= isset($potensi_sr_ini->pola_kon) ? number_format($potensi_sr_ini->pola_kon, 2) : '-' ?></td>
                    <td class="num"><?= isset($potensi_sr_depan->pola_kon) ? number_format($potensi_sr_depan->pola_kon, 2) : '-' ?></td>
                    <td class="num <?= $selisih_pola_kon >= 0 ? 'success' : 'danger' ?>"><?= number_format($selisih_pola_kon, 2, ',', '.') ?></td></tr>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="page-break"></div>

    <!-- ============ PERBANDINGAN TARGET PELANGGAN ============ -->
    <h4>Perbandingan Target Pelanggan (RKAP) <?= $tahun_lalu ?> vs <?= $tahun_sekarang ?></h4>
    <table>
        <thead>
            <tr>
                <th class="label">Uraian</th>
                <th width="30">Thn</th>
                <?php for ($m = 1; $m <= 12; $m++) : ?>
                    <th width="38"><?= date("M", mktime(0, 0, 0, $m, 1)) ?></th>
                <?php endfor; ?>
                <th width="45">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $kd_map = [
                'sr_baru' => ['label' => 'SR Baru', 'kd' => 2],
                'penutupan' => ['label' => 'Penutupan', 'kd' => 3],
                'pembukaan' => ['label' => 'Pembukaan', 'kd' => 4],
                'pencabutan' => ['label' => 'Pencabutan', 'kd' => 5],
                'tera_meter' => ['label' => 'Tera Meter', 'kd' => 'tm'],
                'ganti_meter' => ['label' => 'Ganti Meter', 'kd' => 'gm'],
                'efi_tagih' => ['label' => 'Efisiensi Tagih (%)', 'kd' => 'et'],
            ];
            foreach ($kd_map as $fld => $info):
                $total_lalu = 0;
                $total_sekarang = 0;
                for ($m = 1; $m <= 12; $m++) {
                    if (in_array($info['kd'], [2, 3, 4, 5])) {
                        $v_lalu = $pelanggan_lalu[$m][$info['kd']] ?? 0;
                        $v_sekarang = $pelanggan_sekarang[$m][$info['kd']] ?? 0;
                    } else {
                        $col = ($info['kd'] == 'tm') ? 'tera_meter' : (($info['kd'] == 'gm') ? 'ganti_meter' : 'efi_tagih');
                        $v_lalu = isset($extra_lalu[$m]) ? (float)($extra_lalu[$m]->$col ?? 0) : 0;
                        $v_sekarang = isset($extra_sekarang[$m]) ? (float)($extra_sekarang[$m]->$col ?? 0) : 0;
                    }
                    $total_lalu += $v_lalu;
                    $total_sekarang += $v_sekarang;
                    ${'row_' . $fld . '_lalu'}[$m] = $v_lalu;
                    ${'row_' . $fld . '_sekarang'}[$m] = $v_sekarang;
                }
                if ($fld == 'efi_tagih') {
                    $total_lalu = $total_lalu / 12;
                    $total_sekarang = $total_sekarang / 12;
                }
            ?>
                <tr class="section-title">
                    <td colspan="15"><?= $info['label'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold"><?= $tahun_lalu ?></td>
                    <?php for ($m = 1; $m <= 12; $m++) : $val = ${'row_' . $fld . '_lalu'}[$m]; ?>
                        <td class="num"><?= $fld == 'efi_tagih' ? number_format($val, 2, ',', '.') . '%' : number_format($val, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold"><?= $fld == 'efi_tagih' ? number_format($total_lalu, 2, ',', '.') . '%' : number_format($total_lalu, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold"><?= $tahun_sekarang ?></td>
                    <?php for ($m = 1; $m <= 12; $m++) : $val = ${'row_' . $fld . '_sekarang'}[$m]; ?>
                        <td class="num"><?= $fld == 'efi_tagih' ? number_format($val, 2, ',', '.') . '%' : number_format($val, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold"><?= $fld == 'efi_tagih' ? number_format($total_sekarang, 2, ',', '.') . '%' : number_format($total_sekarang, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Selisih</td>
                    <?php for ($m = 1; $m <= 12; $m++) :
                        $sel = ${'row_' . $fld . '_sekarang'}[$m] - ${'row_' . $fld . '_lalu'}[$m];
                    ?>
                        <td class="num <?= $sel >= 0 ? 'success' : 'danger' ?>"><?= $fld == 'efi_tagih' ? number_format($sel, 2, ',', '.') . '%' : number_format($sel, 0, ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold <?= ($total_sekarang - $total_lalu) >= 0 ? 'success' : 'danger' ?>"><?= $fld == 'efi_tagih' ? number_format($total_sekarang - $total_lalu, 2, ',', '.') . '%' : number_format($total_sekarang - $total_lalu, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ============ PERBANDINGAN TARGET PENDAPATAN ============ -->
    <h4>Perbandingan Target Pendapatan (RKAP) <?= $tahun_lalu ?> vs <?= $tahun_sekarang ?></h4>
    <table>
        <thead>
            <tr>
                <th class="label">Uraian</th>
                <th width="30">Thn</th>
                <?php for ($m = 1; $m <= 12; $m++) : ?>
                    <th width="38"><?= date("M", mktime(0, 0, 0, $m, 1)) ?></th>
                <?php endfor; ?>
                <th width="45">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pend_fields = [
                'jml_rekening' => 'Jumlah Rekening',
                'pemakaian' => 'Pemakaian (m³)',
                'pendapatan' => 'Pendapatan (Rp)',
                'pola_konsumsi' => 'Pola Konsumsi (m³/rek)',
            ];
            foreach ($pend_fields as $fld => $label):
                if ($fld == 'pola_konsumsi') {
                    $total_lalu = 0;
                    $total_sekarang = 0;
                    for ($m = 1; $m <= 12; $m++) {
                        $jml_lalu = $jml_rekening_lalu[$m] ?? 0;
                        $jml_sekarang = $jml_rekening_sekarang[$m] ?? 0;
                        $pakai_lalu = $pemakaian_lalu[$m] ?? 0;
                        $pakai_sekarang = $pemakaian_sekarang[$m] ?? 0;
                        ${'row_lalu'}[$m] = $jml_lalu > 0 ? round($pakai_lalu / $jml_lalu, 2) : 0;
                        ${'row_sekarang'}[$m] = $jml_sekarang > 0 ? round($pakai_sekarang / $jml_sekarang, 2) : 0;
                        $total_lalu += ${'row_lalu'}[$m];
                        $total_sekarang += ${'row_sekarang'}[$m];
                    }
                } else {
                    $arr_lalu = ${$fld . '_lalu'};
                    $arr_sekarang = ${$fld . '_sekarang'};
                    $total_lalu = array_sum($arr_lalu);
                    $total_sekarang = array_sum($arr_sekarang);
                    for ($m = 1; $m <= 12; $m++) {
                        ${'row_lalu'}[$m] = $arr_lalu[$m] ?? 0;
                        ${'row_sekarang'}[$m] = $arr_sekarang[$m] ?? 0;
                    }
                }
            ?>
                <tr class="section-title">
                    <td colspan="15"><?= $label ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold"><?= $tahun_lalu ?></td>
                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                        <td class="num"><?= $fld == 'pendapatan' ? number_format(${'row_lalu'}[$m], 0, ',', '.') : number_format(${'row_lalu'}[$m], ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold"><?= $fld == 'pendapatan' ? number_format($total_lalu, 0, ',', '.') : number_format($total_lalu, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="bold"><?= $tahun_sekarang ?></td>
                    <?php for ($m = 1; $m <= 12; $m++) : ?>
                        <td class="num"><?= $fld == 'pendapatan' ? number_format(${'row_sekarang'}[$m], 0, ',', '.') : number_format(${'row_sekarang'}[$m], ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold"><?= $fld == 'pendapatan' ? number_format($total_sekarang, 0, ',', '.') : number_format($total_sekarang, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Selisih</td>
                    <?php for ($m = 1; $m <= 12; $m++) :
                        $sel = ${'row_sekarang'}[$m] - ${'row_lalu'}[$m];
                    ?>
                        <td class="num <?= $sel >= 0 ? 'success' : 'danger' ?>"><?= $fld == 'pendapatan' ? number_format($sel, 0, ',', '.') : number_format($sel, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                    <?php endfor; ?>
                    <td class="num bold <?= ($total_sekarang - $total_lalu) >= 0 ? 'success' : 'danger' ?>"><?= $fld == 'pendapatan' ? number_format($total_sekarang - $total_lalu, 0, ',', '.') : number_format($total_sekarang - $total_lalu, ($fld == 'pola_konsumsi' ? 2 : 0), ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
