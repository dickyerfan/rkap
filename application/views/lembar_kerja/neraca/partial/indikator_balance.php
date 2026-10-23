<?php
$indikatorFields = isset($indikatorFields) ? $indikatorFields : (isset($fields) && isset($years) && count($fields) === count($years)
    ? array_combine($fields, $years)
    : ["neraca_rkap" => $tahun]);

$fmtInd = function ($v) {
    return number_format((float)$v, 0, ",", ".");
};
?>
<div style="margin:0 0 8px 0;">
    <?php foreach ($indikatorFields as $f => $label) :
        $r = $this->Model_posisi_keuangan->ringkasanNeracaField($lajur, $f);
        $sel = round((float)$r["aktiva"]) - round((float)$r["pasiva"]);
        $seimbang = abs($sel) < 0.5;
        if ($seimbang) {
            $bg = "#d1e7dd"; $fg = "#0f5132"; $bd = "#198754"; $txt = "SEIMBANG";
        } else {
            $bg = "#f8d7da"; $fg = "#842029"; $bd = "#dc3545"; $txt = "BELUM SEIMBANG";
        }
    ?>
        <div style="display:inline-block; vertical-align:top; margin:0 6px 6px 0; padding:4px 9px; border:1px solid <?= $bd ?>; background-color:<?= $bg ?>; color:<?= $fg ?>; font-size:0.7rem; line-height:1.35;">
            <span style="color:<?= $bd ?>; font-weight:bold;">&#9679;</span>
            <b><?= $txt ?></b> &mdash; Neraca <?= htmlspecialchars((string)$label) ?><br>
            <span style="font-weight:normal;">
                Total Aset <?= $fmtInd($r["aktiva"]) ?> |
                Kewajiban <?= $fmtInd($r["total_kewajiban"]) ?> |
                Modal <?= $fmtInd($r["modal"]) ?> |
                Selisih <b><?= $fmtInd($sel) ?></b>
            </span>
        </div>
    <?php endforeach; ?>
</div>
