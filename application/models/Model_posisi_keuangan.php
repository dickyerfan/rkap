<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Model_posisi_keuangan extends CI_Model
{
    private $aktivaGrups = ["aktiva_lancar", "aktiva_pajak", "aktiva_tetap", "aktiva_lain"];
    private $jurnalAutoKodes = ["31", "31.1", "13.06", "50.05", "50.01"];
    private $posListCache = null;
    private $grupList = [
        "aktiva_lancar" => "Aktiva Lancar",
        "aktiva_pajak" => "Aktiva Pajak Tangguhan",
        "aktiva_tetap" => "Aktiva Tetap",
        "aktiva_lain" => "Aktiva Lain-lain",
        "liabilitas_pendek" => "Kewajiban Lancar",
        "liabilitas_panjang" => "Kewajiban Jangka Panjang",
        "ekuitas" => "Modal dan Cadangan",
    ];
    private $syntheticParents = [
        "14" => ["uraian" => "Piutang Lain-lain", "grup" => "aktiva_lancar", "children" => ["14.09", "14.10"]],
        "61" => ["uraian" => "Kewajiban Jangka Panjang", "grup" => "liabilitas_panjang", "children" => ["61.01", "61.02", "61.03"]],
        "62" => ["uraian" => "Cadangan Laba", "grup" => "liabilitas_panjang", "children" => ["62.01", "62.02", "62.03", "62.04", "62.05"]],
    ];
    private $foldedCodes = ["42.01", "42.02", "42.04", "42.05", "42.06"];
    private $contextUrutan = ["lajur" => ["aktiva_lain" => ["41.08", "41.01"]]];

    public function getPosList()
    {
        if ($this->posListCache !== null) return $this->posListCache;
        $rows = [];
        if ($this->db->table_exists("neraca_pos")) {
            $query = $this->db->where("aktif", 1)->order_by("urutan", "ASC")->order_by("kode", "ASC")->get("neraca_pos");
            foreach ($query->result() as $r) {
                $rows[] = [
                    "kode" => (string)$r->kode,
                    "uraian" => $r->uraian,
                    "grup" => $r->grup,
                    "sign" => (int)$r->sign,
                    "parent_kode" => ($r->parent_kode === null || $r->parent_kode === "") ? null : (string)$r->parent_kode,
                    "urutan" => (int)$r->urutan,
                    "tampil" => (int)$r->tampil,
                    "sumber" => $r->sumber,
                ];
            }
        }
        if (empty($rows)) $rows = $this->defaultPosList();
        return $this->posListCache = $rows;
    }

    public function resetPosListCache()
    {
        $this->posListCache = null;
    }

    private function defaultPosList()
    {
        return [
            ["kode" => "11", "uraian" => "Kas dan Bank", "grup" => "aktiva_lancar", "sign" => 1, "parent" => true],
            ["kode" => "11.01", "uraian" => "Uang Tunai / Dana", "grup" => "aktiva_lancar", "sign" => 1, "parent" => true],
            ["kode" => "11.01.01", "uraian" => "Uang Tunai", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.01.02", "uraian" => "Dana Kerja", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.01.03", "uraian" => "Dana Pemeliharan", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.01.04", "uraian" => "Dana Penagihan", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.01.05", "uraian" => "Dana Operasional AMDK", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.02", "uraian" => "Rekening Giro", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.03", "uraian" => "Rekening Tabungan", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "11.04", "uraian" => "Kas Kecil", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "12", "uraian" => "Deposito", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "12.01", "uraian" => "Deposito Rupiah", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "13", "uraian" => "Piutang Usaha", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "13.06", "uraian" => "Penyisihan Piutang Usaha", "grup" => "aktiva_lancar", "sign" => -1],
            ["kode" => "14.09", "uraian" => "Piutang Lain-lain", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "14.10", "uraian" => "Penyisihan Piutang Lain-lain", "grup" => "aktiva_lancar", "sign" => -1],
            ["kode" => "15", "uraian" => "Persediaan", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "16", "uraian" => "Pembayaran Dimuka", "grup" => "aktiva_lancar", "sign" => 1],
            ["kode" => "25.01.01", "uraian" => "Aktiva Pajak Tangguhan", "grup" => "aktiva_pajak", "sign" => 1],
            ["kode" => "31", "uraian" => "Nilai Perolehan Aktiva Tetap", "grup" => "aktiva_tetap", "sign" => 1],
            ["kode" => "31.1", "uraian" => "Akumulasi Penyusutan Aktiva Tetap", "grup" => "aktiva_tetap", "sign" => -1],
            ["kode" => "41.01", "uraian" => "Aktiva Dalam Penyelesaian", "grup" => "aktiva_lain", "sign" => 1],
            ["kode" => "41.08", "uraian" => "Aset DPLK - DAPENMA PAMSI", "grup" => "aktiva_lain", "sign" => 1],
            // ["kode" => "51714", "uraian" => "Pra-Aset DPLK Dapenma Pamsi", "grup" => "aktiva_lain", "sign" => 1],
            ["kode" => "42.01", "uraian" => "Beban Ditangguhkan", "grup" => "aktiva_lain", "sign" => 1],
            ["kode" => "42.02", "uraian" => "Akumulasi Amortisasi Beban Ditangguhkan", "grup" => "aktiva_lain", "sign" => -1],
            ["kode" => "42.03", "uraian" => "Trade Mark", "grup" => "aktiva_lain", "sign" => 1],
            ["kode" => "42.04", "uraian" => "Akumulasi Amortisasi Trade Mark", "grup" => "aktiva_lain", "sign" => -1],
            ["kode" => "42.05", "uraian" => "Goodwill", "grup" => "aktiva_lain", "sign" => 1],
            ["kode" => "42.06", "uraian" => "Akumulasi Amortisasi Goodwill", "grup" => "aktiva_lain", "sign" => -1],
            ["kode" => "50.01", "uraian" => "Utang Usaha", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.02", "uraian" => "Utang Non Usaha", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.03", "uraian" => "Biaya Yang Masih Harus Dibayar", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.04", "uraian" => "Pendapatan Diterima Dimuka", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.05", "uraian" => "Utang Pajak", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.06", "uraian" => "Utang Jangka Panjang Jatuh Tempo", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.07", "uraian" => "Utang Bunga", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.08", "uraian" => "Utang Iuran Pensiun", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.09", "uraian" => "Jaminan Masa Pemeliharaan", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.1", "uraian" => "Pinjaman Jangka Pendek", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.9", "uraian" => "Kewajiban Jangka Pendek Lainnya", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.80", "uraian" => "Utang Imbalan Jasa Kerja", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "50.90", "uraian" => "Utang Jangka Pendek Lainnya", "grup" => "liabilitas_pendek", "sign" => 1],
            ["kode" => "61.01", "uraian" => "Kewajiban Jangka Panjang", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "61.02", "uraian" => "Bunga Masa Tenggang", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "61.03", "uraian" => "Utang Leasing", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "62.01", "uraian" => "Pendapatan Yang Ditangguhkan", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "62.02", "uraian" => "Dana Meter", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "62.03", "uraian" => "Cadangan Dana", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "62.04", "uraian" => "Uang Jaminan", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "62.05", "uraian" => "Rupa Kewajiban Lainnya", "grup" => "liabilitas_panjang", "sign" => 1],
            ["kode" => "70.01", "uraian" => "Kekayaan Pemda Yang Dipisahkan", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.02", "uraian" => "Penyertaan Pemerintah Pusat Belum Ditetapkan Statusnya", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.03", "uraian" => "Penyertaan Pemerintah Pusat", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.04", "uraian" => "Modal Hibah", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.05", "uraian" => "Selisih Penilaian Kembali Iuran Pasca Kerja", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.06", "uraian" => "Cadangan Umum", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.07", "uraian" => "Akumulasi Kerugian Tahun Lalu", "grup" => "ekuitas", "sign" => -1],
            ["kode" => "70.08", "uraian" => "Pengukuran Kembali Imbalan Pasca Kerja", "grup" => "ekuitas", "sign" => 1],
            ["kode" => "70.09", "uraian" => "Laba/(Rugi) Tahun Berjalan", "grup" => "ekuitas", "sign" => 1],
        ];
    }

    public function defaultAggregateMap()
    {
        return [
            "11.01" => ["11.01.01", "11.01.02", "11.01.03", "11.01.04", "11.01.05"],
            "11" => ["11.01", "11.02", "11.03", "11.04"],
            "12" => ["12.01"],
            "50.90" => ["50.1", "50.9"],
        ];
    }

    public function aggregateMap()
    {
        $map = $this->defaultAggregateMap();
        foreach ($this->getPosList() as $pos) {
            $parent = $pos["parent_kode"] ?? null;
            if ($parent === null || $parent === "") continue;
            if (!isset($map[$parent])) $map[$parent] = [];
            if (!in_array($pos["kode"], $map[$parent], true)) $map[$parent][] = $pos["kode"];
        }
        foreach ($map as $parent => $children) {
            $map[$parent] = array_values(array_unique(array_map("strval", $children)));
        }
        return $map;
    }

    public function grupList()
    {
        return $this->grupList;
    }

    public function getSyntheticParents()
    {
        return $this->syntheticParents;
    }

    // Anak langsung sebuah akun turunan (14/61/62) diambil dinamis dari daftar akun,
    // supaya akun baru (mis. 61.04) ikut terlipat di Lajur dan ikut dihitung.
    private function childrenOfSynthetic($parent)
    {
        $parent = (string)$parent;
        $out = [];
        foreach ($this->getPosList() as $pos) {
            $kode = (string)$pos["kode"];
            if (strpos($kode, $parent . ".") !== 0) continue;
            if (!empty($pos["parent_kode"])) continue;
            $out[] = $kode;
        }
        return $out;
    }

    private function syntheticDefs()
    {
        $defs = [];
        foreach ($this->syntheticParents as $kode => $def) {
            $def["children"] = $this->childrenOfSynthetic($kode);
            $defs[$kode] = $def;
        }
        return $defs;
    }

    public function getFoldedCodes()
    {
        return $this->foldedCodes;
    }

    // Daftar kode per kelompok yang ditampilkan di Laporan / Komparasi / Neraca Lajur.
    // konteks "laporan" : akun turunan 14 tampil sebagai satu baris (14.09+14.10 dilipat),
    //                     kewajiban jangka panjang tampil per anak (61.01..62.05).
    // konteks "lajur"   : akun turunan 14/61/62 tampil sebagai satu baris, anaknya disembunyikan
    //                     (menyesuaikan NERACA LAJUR Excel).
    public function getGrupKodes($context = "laporan")
    {
        $showSynthetic = ($context === "lajur") ? ["14", "61", "62"] : ["14"];
        $synth = $this->syntheticDefs();
        $hideChildren = [];
        foreach ($this->aggregateMap() as $children) {
            foreach ($children as $child) $hideChildren[(string)$child] = true;
        }
        foreach ($showSynthetic as $kode) {
            foreach ($synth[$kode]["children"] as $child) $hideChildren[$child] = true;
        }
        $result = array_fill_keys(array_keys($this->grupList), []);
        $emitted = [];
        foreach ($this->getPosList() as $pos) {
            $kode = (string)$pos["kode"];
            if (isset($pos["tampil"]) && !$pos["tampil"]) continue;
            if (in_array($kode, $this->foldedCodes, true)) continue;
            if (isset($hideChildren[$kode])) {
                foreach ($showSynthetic as $sint) {
                    if (in_array($kode, $synth[$sint]["children"], true) && empty($emitted[$sint])) {
                        $emitted[$sint] = true;
                        $grup = $synth[$sint]["grup"];
                        if (isset($result[$grup])) $result[$grup][] = $sint;
                    }
                }
                continue;
            }
            $grup = $pos["grup"];
            if (!isset($result[$grup])) $result[$grup] = [];
            $result[$grup][] = $kode;
        }
        foreach ($this->contextUrutan[$context] ?? [] as $grup => $urutan) {
            if (!isset($result[$grup])) continue;
            $urut = [];
            foreach ($urutan as $kode) if (in_array($kode, $result[$grup], true)) $urut[] = $kode;
            foreach ($result[$grup] as $kode) if (!in_array($kode, $urut, true)) $urut[] = $kode;
            $result[$grup] = $urut;
        }
        return $result;
    }

    public function kasFamily()
    {
        $out = [];
        foreach ($this->getPosList() as $pos) {
            $kode = (string)$pos["kode"];
            if ($kode === "11" || strpos($kode, "11.") === 0) $out[] = $kode;
        }
        if (empty($out)) $out = ["11"];
        return $out;
    }

    public function kasDetailCodes()
    {
        $parents = $this->parentCodes();
        $out = [];
        foreach ($this->kasFamily() as $kode) {
            if ($kode === "11" || in_array($kode, $parents, true)) continue;
            $out[] = $kode;
        }
        return $out;
    }

    public function kasHiddenCodes()
    {
        return array_values(array_filter($this->kasFamily(), function ($kode) {
            return $kode !== "11";
        }));
    }

    public function jurnalSkipCodes()
    {
        return $this->kasDetailCodes();
    }

    public function parentCodes()
    {
        return array_map("strval", array_keys($this->aggregateMap()));
    }

    public function hitungProyeksi($growth)
    {
        $monthCols = ["des_n2", "jan_n1", "feb_n1", "mar_n1", "apr_n1", "mei_n1", "jun_n1"];
        $emptyGrowth = ["des_n2" => 0, "jan_n1" => 0, "feb_n1" => 0, "mar_n1" => 0, "apr_n1" => 0, "mei_n1" => 0, "jun_n1" => 0, "proyeksi_manual" => null];
        $proy = [];
        $months = [];
        $posGrup = [];
        foreach ($this->getPosList() as $pos) {
            $kode = $pos["kode"];
            $g = isset($growth[$kode]) ? $growth[$kode] : $emptyGrowth;
            $auto = $this->hitungProyeksiDes($g["des_n2"], $g["jun_n1"]);
            $proy[$kode] = (isset($g["proyeksi_manual"]) && $g["proyeksi_manual"] !== null) ? (float)$g["proyeksi_manual"] : $auto;
            $months[$kode] = [];
            foreach ($monthCols as $col) $months[$kode][$col] = (float)($g[$col] ?? 0);
            $posGrup[$kode] = $pos["grup"];
        }
        $hasData = function ($kode) use ($growth, $proy, $monthCols) {
            if (isset($growth[$kode])) {
                foreach ($monthCols as $col) {
                    if (($growth[$kode][$col] ?? 0) != 0) return true;
                }
                if (($growth[$kode]["proyeksi_manual"] ?? null) !== null) return true;
            }
            return isset($proy[$kode]) && $proy[$kode] != 0;
        };
        $usedChildren = [];
        $resolve = function () use (&$proy, &$months, &$usedChildren, $monthCols, $hasData) {
            $usedChildren = [];
            foreach ($this->aggregateMap() as $parent => $children) {
                $any = false;
                foreach ($children as $child) {
                    if ($hasData($child)) {
                        $any = true;
                        break;
                    }
                }
                if (!$any || !isset($proy[$parent])) continue;
                $totalProy = 0.0;
                $totalMonths = array_fill_keys($monthCols, 0.0);
                foreach ($children as $child) {
                    if (!isset($proy[$child])) continue;
                    $totalProy += $proy[$child];
                    foreach ($monthCols as $col) $totalMonths[$col] += $months[$child][$col];
                }
                $proy[$parent] = $totalProy;
                $months[$parent] = $totalMonths;
                $usedChildren[$parent] = $children;
            }
        };
        $resolve();

        $active = false;
        foreach ($this->kasDetailCodes() as $kode) {
            if (isset($growth[$kode])) {
                $active = true;
                break;
            }
        }
        if ($active && isset($proy["11.01.01"])) {
            $skipped = [];
            foreach ($usedChildren as $children) $skipped = array_merge($skipped, $children);
            $sumGroup = function ($grups, $excludeKas = false) use ($proy, $posGrup, $skipped) {
                $total = 0.0;
                foreach ($posGrup as $kode => $grup) {
                    if (!in_array($grup, $grups, true)) continue;
                    if (in_array((string)$kode, $skipped, true)) continue;
                    if ($excludeKas && in_array((string)$kode, $this->kasFamily(), true)) continue;
                    $total += $proy[$kode] ?? 0;
                }
                return $total;
            };
            $totalLE = $sumGroup(["liabilitas_pendek", "liabilitas_panjang", "ekuitas"]);
            $totalTidakLancar = $sumGroup(["aktiva_pajak", "aktiva_tetap", "aktiva_lain"]);
            $lancarLain = $sumGroup(["aktiva_lancar"], true);
            $kasLain = 0.0;
            foreach ($this->kasDetailCodes() as $kode) {
                if ($kode === "11.01.01") continue;
                $kasLain += $proy[$kode] ?? 0;
            }
            $manual = isset($growth["11.01.01"]) && ($growth["11.01.01"]["proyeksi_manual"] ?? null) !== null;
            $proy["11.01.01"] = $manual ? (float)$growth["11.01.01"]["proyeksi_manual"] : ($totalLE - $totalTidakLancar - $lancarLain - $kasLain);
            $resolve();
        }

        return ["proy" => $proy, "months" => $months];
    }

    public function getGrowthData($tahun)
    {
        $rows = $this->db->where("tahun", $tahun)->get("neraca_manual")->result();
        $result = [];
        foreach ($rows as $r) {
            $result[$r->kode] = [
                "uraian" => $r->uraian,
                "des_n2" => (float)$r->des_n2,
                "jan_n1" => (float)$r->jan_n1,
                "feb_n1" => (float)$r->feb_n1,
                "mar_n1" => (float)$r->mar_n1,
                "apr_n1" => (float)$r->apr_n1,
                "mei_n1" => (float)$r->mei_n1,
                "jun_n1" => (float)$r->jun_n1,
                "proyeksi_manual" => ($r->proyeksi_manual === null) ? null : (float)$r->proyeksi_manual,
            ];
        }
        return $result;
    }

    private function parseNumber($value)
    {
        $v = str_replace([" ", "\xc2\xa0"], "", (string)($value ?? ""));
        if ($v === "") return null;
        if (strpos($v, ",") !== false) {
            $v = str_replace(".", "", $v);
            $v = str_replace(",", ".", $v);
        } elseif (substr_count($v, ".") > 1 || preg_match('/^-?\d{1,3}(\.\d{3})+$/', $v)) {
            $v = str_replace(".", "", $v);
        }
        return is_numeric($v) ? (float)$v : null;
    }

    public function saveGrowthData($tahun, $data, $updated_by)
    {
        $normalize = function ($value) {
            $parsed = $this->parseNumber($value);
            return (string)($parsed === null ? 0.0 : $parsed);
        };

        foreach ($data as $key => $vals) {
            $kode = isset($vals["kode"]) && $vals["kode"] !== "" ? $vals["kode"] : $key;
            $des = $this->parseNumber($vals["des_n2"] ?? 0) ?? 0;
            $jun = $this->parseNumber($vals["jun_n1"] ?? 0) ?? 0;
            $auto = $this->hitungProyeksiDes($des, $jun);
            $existing = $this->db->where("tahun", $tahun)->where("kode", $kode)->get("neraca_manual")->row();
            $currentManual = ($existing && $existing->proyeksi_manual !== null) ? (float)$existing->proyeksi_manual : null;

            $manual = $currentManual;
            $submittedRaw = trim((string)($vals["proyeksi"] ?? ""));
            if ($submittedRaw === "") {
                $manual = null;
            } else {
                $submitted = $this->parseNumber($submittedRaw);
                if ($submitted !== null) {
                    $asli = $this->parseNumber($vals["proyeksi_asli"] ?? "");
                    $untouched = ($asli !== null && abs($submitted - $asli) < 0.5);
                    if ($untouched) {
                        $manual = $currentManual;
                    } elseif (abs(round($submitted, 0) - round($auto, 0)) < 0.5) {
                        $manual = null;
                    } else {
                        $manual = round($submitted, 4);
                    }
                }
            }
            $row = [
                "tahun" => $tahun,
                "kode" => $kode,
                "uraian" => $vals["uraian"] ?? "",
                "des_n2" => $normalize($vals["des_n2"] ?? 0),
                "jan_n1" => $normalize($vals["jan_n1"] ?? 0),
                "feb_n1" => $normalize($vals["feb_n1"] ?? 0),
                "mar_n1" => $normalize($vals["mar_n1"] ?? 0),
                "apr_n1" => $normalize($vals["apr_n1"] ?? 0),
                "mei_n1" => $normalize($vals["mei_n1"] ?? 0),
                "jun_n1" => $normalize($vals["jun_n1"] ?? 0),
                "proyeksi_manual" => $manual,
                "updated_by" => $updated_by,
            ];
            if ($existing) {
                $this->db->where("tahun", $tahun)->where("kode", $kode)->update("neraca_manual", $row);
            } else {
                $this->db->insert("neraca_manual", $row);
            }
        }
    }

    public function hitungProyeksiDes($des_n2, $jun_n1)
    {
        if ($des_n2 == 0) return $jun_n1;
        $ratio = $jun_n1 / $des_n2;
        $rate  = ($ratio <= 0) ? -0.2 : max(-0.2, min(0.2, pow($ratio, 1 / 6) - 1));
        return $jun_n1 * pow(1 + $rate, 6);
    }

    public function getJurnalManual($tahun)
    {
        $rows = $this->db->where("tahun", $tahun)->get("neraca_jurnal")->result();
        $result = [];
        foreach ($rows as $r) {
            $result[$r->kode] = ["uraian" => $r->uraian, "debit" => (float)$r->debit, "kredit" => (float)$r->kredit];
        }
        return $result;
    }

    public function saveJurnalManual($tahun, $data, $updated_by)
    {
        $normalize = function ($value) {
            $parsed = $this->parseNumber($value);
            return (string)($parsed === null ? 0.0 : $parsed);
        };

        foreach ($data as $key => $vals) {
            $kode = isset($vals["kode"]) && $vals["kode"] !== "" ? $vals["kode"] : $key;
            if (in_array((string)$kode, $this->jurnalAutoKodes, true)) continue;
            $existing = $this->db->where("tahun", $tahun)->where("kode", $kode)->get("neraca_jurnal")->row();
            $row = ["tahun" => $tahun, "kode" => $kode, "uraian" => $vals["uraian"] ?? "", "debit" => $normalize($vals["debit"] ?? 0), "kredit" => $normalize($vals["kredit"] ?? 0), "updated_by" => $updated_by];
            if ($existing) {
                $this->db->where("tahun", $tahun)->where("kode", $kode)->update("neraca_jurnal", $row);
            } else {
                $this->db->insert("neraca_jurnal", $row);
            }
        }
    }

    public function getJurnalFromRekap($tahun)
    {
        $result = [];
        $q = function ($like) use ($tahun) {
            $this->db->select_sum("pagu", "total");
            $this->db->from("rkap_rekap r");
            $this->db->join("no_per n", "r.no_per_id = n.kode", "left");
            $this->db->where("YEAR(r.bulan)", $tahun);
            $this->db->like("n.kode", $like, "after");
            $row = $this->db->get()->row();
            return $row ? (float)$row->total : 0;
        };
        $result["31_debit"]     = $q->call($this, "31.");
        $result["13.06_kredit"] = $q->call($this, "96.07");
        $result["50.05_kredit"] = $q->call($this, "97");
        $result["50.01_kredit"] = $q->call($this, "50.01");
        $this->db->select_sum("pagu", "total");
        $this->db->from("rkap_rekap r");
        $this->db->join("no_per n", "r.no_per_id = n.kode", "left");
        $this->db->where("YEAR(r.bulan)", $tahun);
        $this->db->group_start();
        $this->db->like("n.kode", "91.09", "after");
        $this->db->or_like("n.kode", "98.02.90", "after");
        $this->db->group_end();
        $row = $this->db->get()->row();
        $result["31.1_kredit"] = $row ? (float)$row->total : 0;
        return $result;
    }

    public function getLabaRugiBerjalan($tahun)
    {
        $codes = ["81.01", "81.02", "81.03", "88", "91", "92", "93", "95", "96", "98", "97.01.01", "97.01.02", "97.01.03"];
        $t = [];
        foreach ($codes as $c) {
            $this->db->select_sum("pagu", "total");
            $this->db->from("rkap_rekap r");
            $this->db->join("no_per n", "r.no_per_id = n.kode", "left");
            $this->db->where("YEAR(r.bulan)", $tahun);
            $this->db->like("n.kode", $c, "after");
            $row = $this->db->get()->row();
            $t[$c] = $row ? (float)$row->total : 0;
        }
        return ($t["81.01"] + $t["81.02"] + $t["81.03"] + $t["88"]) - ($t["91"] + $t["92"] + $t["93"] + $t["95"] + $t["96"] + $t["98"]) - ($t["97.01.01"] + $t["97.01.02"] + $t["97.01.03"]);
    }

    private function orientation($grup)
    {
        return in_array($grup, $this->aktivaGrups, true) ? "debit" : "credit";
    }

    private function displaySide($kode, $grup)
    {
        if ($kode === "13.06" || $kode === "31.1") return "credit";
        if ($kode === "70.07") return "debit";
        return $this->orientation($grup);
    }

    public function hitungNeracaLajur($tahun, $abaikanKoreksi = false)
    {
        $growth = $this->getGrowthData($tahun);
        $proyMap = $this->hitungProyeksi($growth);
        $jManual = $abaikanKoreksi ? [] : $this->getJurnalManual($tahun);
        $this->load->model("Model_jurnal_rkap");
        $jurnalDetail = $this->Model_jurnal_rkap->getTotalsByYear($tahun);
        $jRekap = empty($jurnalDetail) ? $this->getJurnalFromRekap($tahun) : [];
        $result = [];
        $emptyGrowth = ["des_n2" => 0, "jan_n1" => 0, "feb_n1" => 0, "mar_n1" => 0, "apr_n1" => 0, "mei_n1" => 0, "jun_n1" => 0, "proyeksi_manual" => null];

        foreach ($this->getPosList() as $pos) {
            $kode = $pos["kode"];
            $g = $growth[$kode] ?? $emptyGrowth;
            $proyeksi_des = isset($proyMap["proy"][$kode])
                ? (float)$proyMap["proy"][$kode]
                : ((isset($g["proyeksi_manual"]) && $g["proyeksi_manual"] !== null) ? (float)$g["proyeksi_manual"] : $this->hitungProyeksiDes($g["des_n2"], $g["jun_n1"]));
            $j_debit = 0;
            $j_kredit = 0;
            if (!empty($jurnalDetail)) {
                if (isset($jurnalDetail[$kode])) {
                    $j_debit = $jurnalDetail[$kode]["debit"];
                    $j_kredit = $jurnalDetail[$kode]["kredit"];
                }
            } else {
                if ($kode === "31") $j_debit = $jRekap["31_debit"] ?? 0;
                elseif ($kode === "31.1") $j_kredit = $jRekap["31.1_kredit"] ?? 0;
                elseif ($kode === "13.06") $j_kredit = $jRekap["13.06_kredit"] ?? 0;
                elseif ($kode === "50.05") $j_kredit = $jRekap["50.05_kredit"] ?? 0;
                elseif ($kode === "50.01") $j_kredit = $jRekap["50.01_kredit"] ?? 0;
            }
            if (isset($jManual[$kode])) {
                $j_debit += (float)$jManual[$kode]["debit"];
                $j_kredit += (float)$jManual[$kode]["kredit"];
            }
            $creditNature = $this->orientation($pos["grup"]) === "credit";
            $neraca_rkap = $creditNature
                ? $proyeksi_des - $j_debit + $j_kredit
                : $proyeksi_des + $j_debit - $j_kredit;
            $result[$kode] = [
                "uraian" => $pos["uraian"],
                "grup" => $pos["grup"],
                "sign" => $pos["sign"],
                "neraca_2025" => isset($proyMap["months"][$kode]) ? (float)$proyMap["months"][$kode]["des_n2"] : (float)$g["des_n2"],
                "proyeksi_des" => $proyeksi_des,
                "j_debit" => $j_debit,
                "j_kredit" => $j_kredit,
                "neraca_rkap" => $neraca_rkap,
                "growth" => $g,
            ];
        }

        foreach ($this->aggregateMap() as $parent => $children) {
            $hasChildValue = false;
            foreach ($children as $child) {
                if (isset($result[$child]) && ($result[$child]["neraca_2025"] != 0 || $result[$child]["proyeksi_des"] != 0 || $result[$child]["neraca_rkap"] != 0)) {
                    $hasChildValue = true;
                    break;
                }
            }
            if (!$hasChildValue || !isset($result[$parent])) continue;
            $sumField = function ($field) use ($result, $children) {
                $total = 0;
                foreach ($children as $child) {
                    if (isset($result[$child][$field])) $total += $result[$child][$field];
                }
                return $total;
            };
            foreach (["neraca_2025", "proyeksi_des"] as $field) {
                $result[$parent][$field] = $sumField($field);
            }
            $result[$parent]["j_debit"] += $sumField("j_debit");
            $result[$parent]["j_kredit"] += $sumField("j_kredit");
            $creditNature = $this->orientation($result[$parent]["grup"]) === "credit";
            $result[$parent]["neraca_rkap"] = $creditNature
                ? $result[$parent]["proyeksi_des"] - $result[$parent]["j_debit"] + $result[$parent]["j_kredit"]
                : $result[$parent]["proyeksi_des"] + $result[$parent]["j_debit"] - $result[$parent]["j_kredit"];
        }

        $splitFields = function (&$row, $field, $debit, $kredit) {
            $row[$field . "_debit"] = $debit;
            $row[$field . "_kredit"] = $kredit;
        };

        if (!isset($result["13.06"])) {
            $result["13.06"] = ["uraian" => "Penyisihan Piutang", "grup" => "aktiva_lancar", "sign" => -1, "neraca_2025" => 0, "proyeksi_des" => 0, "j_debit" => 0, "j_kredit" => 0, "neraca_rkap" => 0, "growth" => $emptyGrowth];
        } else {
            $result["13.06"]["uraian"] = "Penyisihan Piutang";
        }

        $piutangLain = $result["14.09"] ?? ["neraca_2025" => 0, "proyeksi_des" => 0, "j_debit" => 0, "j_kredit" => 0, "neraca_rkap" => 0, "growth" => $emptyGrowth];
        $penyisihanLain = $result["14.10"] ?? ["neraca_2025" => 0, "proyeksi_des" => 0, "j_debit" => 0, "j_kredit" => 0, "neraca_rkap" => 0, "growth" => $emptyGrowth];
        $result["14"] = [
            "uraian" => "Piutang Lain-lain",
            "grup" => "aktiva_lancar",
            "sign" => 1,
            "neraca_2025" => $piutangLain["neraca_2025"] + $penyisihanLain["neraca_2025"],
            "proyeksi_des" => $piutangLain["proyeksi_des"] + $penyisihanLain["proyeksi_des"],
            "j_debit" => $piutangLain["j_debit"] + $penyisihanLain["j_debit"],
            "j_kredit" => $piutangLain["j_kredit"] + $penyisihanLain["j_kredit"],
            "neraca_rkap" => $piutangLain["neraca_rkap"] + $penyisihanLain["neraca_rkap"],
            "growth" => $piutangLain["growth"] ?? $emptyGrowth,
        ];
        foreach (["neraca_2025", "proyeksi_des"] as $field) {
            $splitFields($result["14"], $field, $piutangLain[$field] ?? 0, - ($penyisihanLain[$field] ?? 0));
        }

        $intangibleCodes = ["42.01", "42.02", "42.03", "42.04", "42.05", "42.06"];
        $intangibleDebit = ["42.01", "42.03", "42.05"];
        $intangibleKredit = ["42.02", "42.04", "42.06"];
        $hasIntangible = false;
        foreach ($intangibleCodes as $code) {
            if (isset($result[$code]) && ($result[$code]["neraca_2025"] != 0 || $result[$code]["proyeksi_des"] != 0 || $result[$code]["neraca_rkap"] != 0)) {
                $hasIntangible = true;
                break;
            }
        }
        if ($hasIntangible) {
            $sumCodes = function ($codes, $field) use ($result) {
                return array_sum(array_map(function ($code) use ($result, $field) {
                    return isset($result[$code][$field]) ? $result[$code][$field] : 0;
                }, $codes));
            };
            $allIntangible = array_merge($intangibleDebit, $intangibleKredit);
            foreach (["j_debit", "j_kredit"] as $field) {
                $result["42.03"][$field] = $sumCodes($allIntangible, $field);
            }
            $n25D = $sumCodes($intangibleDebit, "neraca_2025");
            $n25K = -$sumCodes($intangibleKredit, "neraca_2025");
            $result["42.03"]["neraca_2025"] = $n25D - $n25K;
            $splitFields($result["42.03"], "neraca_2025", $n25D, $n25K);

            $pD = $sumCodes($intangibleDebit, "proyeksi_des");
            $pK = -$sumCodes($intangibleKredit, "proyeksi_des");
            $open4101 = isset($result["41.01"]) ? (float)$result["41.01"]["proyeksi_des"] : 0;
            $result["42.03"]["proyeksi_des"] = $pD;
            $splitFields($result["42.03"], "proyeksi_des", $pD, 0);
            if (isset($result["41.01"])) {
                $result["41.01"]["proyeksi_des"] = $open4101 - $pK;
                $splitFields($result["41.01"], "proyeksi_des", $open4101, $pK);
                $result["41.01"]["neraca_rkap"] = ($open4101 - $pK) + $result["41.01"]["j_debit"] - $result["41.01"]["j_kredit"];
            }
            $result["42.03"]["neraca_rkap"] = $pD + $result["42.03"]["j_debit"] - $result["42.03"]["j_kredit"];
            $result["42.03"]["uraian"] = "Aktiva Tetap Tak Berwujud";
        }

        $derivedParents = [];
        foreach (["61", "62"] as $sint) {
            $def = $this->syntheticParents[$sint];
            $derivedParents[$sint] = [
                "uraian" => $def["uraian"],
                "grup" => $def["grup"],
                "children" => $this->childrenOfSynthetic($sint),
            ];
        }
        foreach ($derivedParents as $parent => $definition) {
            $result[$parent] = [
                "uraian" => $definition["uraian"],
                "grup" => $definition["grup"],
                "sign" => 1,
                "neraca_2025" => 0,
                "proyeksi_des" => 0,
                "j_debit" => 0,
                "j_kredit" => 0,
                "neraca_rkap" => 0,
                "growth" => $emptyGrowth,
            ];
            foreach (["neraca_2025", "proyeksi_des", "j_debit", "j_kredit", "neraca_rkap"] as $field) {
                $result[$parent][$field] = array_sum(array_map(function ($child) use ($result, $field) {
                    return isset($result[$child][$field]) ? $result[$child][$field] : 0;
                }, $definition["children"]));
            }
        }

        foreach ($result as $kode => $row) {
            $orient = $this->orientation($row["grup"]);
            $side = $this->displaySide($kode, $row["grup"]);
            foreach (["neraca_2025", "proyeksi_des"] as $field) {
                if (isset($row[$field . "_debit"], $row[$field . "_kredit"])) continue;
                $net = (float)$row[$field];
                $inSide = ($side === $orient) ? $net : -$net;
                $result[$kode][$field . "_debit"] = $side === "debit" ? $inSide : 0;
                $result[$kode][$field . "_kredit"] = $side === "credit" ? $inSide : 0;
            }
            $net = (float)$row["neraca_rkap"];
            $open = (float)$row["proyeksi_des"];
            $inSide = ($side === $orient) ? $net : -$net;
            $openInSide = ($side === $orient) ? $open : -$open;
            if ($side === "debit") {
                $result[$kode]["neraca_rkap_debit"] = $inSide >= 0 ? $inSide : 0;
                $result[$kode]["neraca_rkap_kredit"] = $inSide < 0 ? -$inSide : 0;
            } elseif ($inSide < 0 && $openInSide >= 0) {
                $result[$kode]["neraca_rkap_debit"] = -$inSide;
                $result[$kode]["neraca_rkap_kredit"] = 0;
            } else {
                $result[$kode]["neraca_rkap_debit"] = 0;
                $result[$kode]["neraca_rkap_kredit"] = $inSide;
            }
        }

        return $result;
    }

    public function ringkasanNeracaField($lajur, $field = "neraca_rkap")
    {
        $gk = $this->getGrupKodes("laporan");
        $raw = function ($kode) use ($lajur, $field) {
            return isset($lajur[$kode]) ? (float)($lajur[$kode][$field] ?? 0) : 0;
        };
        $liab_rkD = 0;
        foreach (array_merge($gk["liabilitas_pendek"], $gk["liabilitas_panjang"]) as $kode) {
            if (isset($lajur[$kode])) $liab_rkD += (float)($lajur[$kode]["neraca_rkap_debit"] ?? 0);
        }
        $penyesuaian_tampil = 2 * $liab_rkD;
        $aktiva = 0;
        foreach (["aktiva_lancar", "aktiva_pajak", "aktiva_tetap", "aktiva_lain"] as $grup) {
            foreach ($gk[$grup] as $kode) $aktiva += $raw($kode);
        }
        $lp = 0;
        foreach ($gk["liabilitas_pendek"] as $kode) $lp += abs($raw($kode));
        $ljp = 0;
        foreach ($gk["liabilitas_panjang"] as $kode) $ljp += abs($raw($kode));
        $ek = 0;
        foreach ($gk["ekuitas"] as $kode) {
            $v = $raw($kode);
            if ($kode === "70.06" && $field === "neraca_rkap") $v -= $penyesuaian_tampil;
            $ek += $v;
        }
        $pasiva = $lp + $ljp + $ek;
        return [
            "aktiva" => $aktiva,
            "kewajiban_lancar" => $lp,
            "kewajiban_panjang" => $ljp,
            "total_kewajiban" => $lp + $ljp,
            "modal" => $ek,
            "pasiva" => $pasiva,
            "selisih" => $aktiva - $pasiva,
        ];
    }

    public function ringkasanNeraca($tahun, $abaikanKoreksi = false)
    {
        return $this->ringkasanNeracaField($this->hitungNeracaLajur($tahun, $abaikanKoreksi));
    }

    public function getDaftarAkun($hanyaAktif = false)
    {
        $this->db->order_by("urutan", "ASC")->order_by("kode", "ASC");
        if ($hanyaAktif) $this->db->where("aktif", 1);
        return $this->db->get("neraca_pos")->result();
    }

    public function cariAkun($kode)
    {
        return $this->db->where("kode", (string)$kode)->get("neraca_pos")->row();
    }

    public function kodeDipakai($kode)
    {
        $kode = (string)$kode;
        if ($this->db->where("kode", $kode)->count_all_results("neraca_manual") > 0) return true;
        if ($this->db->where("kode", $kode)->count_all_results("neraca_jurnal") > 0) return true;
        if ($this->db->where("posisi_kode", $kode)->count_all_results("jurnal_rkap_detail") > 0) return true;
        return false;
    }

    private function anakAktif($kode)
    {
        return $this->db->where("parent_kode", (string)$kode)->where("aktif", 1)->count_all_results("neraca_pos");
    }

    public function simpanAkun($data, $updated_by)
    {
        $mode = (($data["mode"] ?? "add") === "edit") ? "edit" : "add";
        $kode = trim((string)($data["kode"] ?? ""));
        $uraian = trim((string)($data["uraian"] ?? ""));
        $grup = (string)($data["grup"] ?? "");
        $sign = ((int)($data["sign"] ?? 1) < 0) ? -1 : 1;
        $parent = trim((string)($data["parent_kode"] ?? ""));
        $urutan = (int)($data["urutan"] ?? 0);
        $tampil = (isset($data["tampil"]) && (string)$data["tampil"] === "1") ? 1 : 0;

        if ($kode === "") return ["ok" => false, "pesan" => "Kode akun wajib diisi."];
        if (!preg_match('/^\d{1,4}(\.\d{1,4}){0,3}$/', $kode)) return ["ok" => false, "pesan" => "Format kode tidak sah. Contoh yang benar: 17, 50.10, 61.04."];
        if (in_array($kode, ["14", "61", "62"], true)) return ["ok" => false, "pesan" => "Kode " . $kode . " adalah akun turunan (hasil jumlah anak) sehingga tidak bisa dipakai."];
        if ($uraian === "") return ["ok" => false, "pesan" => "Uraian akun wajib diisi."];
        if (mb_strlen($uraian) > 120) return ["ok" => false, "pesan" => "Uraian maksimal 120 karakter."];
        if (!isset($this->grupList[$grup])) return ["ok" => false, "pesan" => "Kelompok akun tidak dikenal."];

        $aktifList = [];
        foreach ($this->getPosList() as $pos) $aktifList[(string)$pos["kode"]] = $pos;
        $existing = $this->cariAkun($kode);

        if ($mode === "add") {
            if (isset($aktifList[$kode])) return ["ok" => false, "pesan" => "Kode " . $kode . " sudah dipakai oleh akun lain."];
        } else {
            if (!$existing) return ["ok" => false, "pesan" => "Akun " . $kode . " tidak ditemukan."];
        }

        if ($parent !== "") {
            if ($parent === $kode) return ["ok" => false, "pesan" => "Akun induk tidak boleh sama dengan akunnya sendiri."];
            if (!isset($aktifList[$parent])) return ["ok" => false, "pesan" => "Akun induk " . $parent . " tidak ditemukan (atau sedang nonaktif)."];
            $parentPos = $aktifList[$parent];
            if (($parentPos["parent_kode"] ?? null) !== null) return ["ok" => false, "pesan" => "Akun induk " . $parent . " sudah punya induk lagi. Maksimal satu tingkat."];
            if (($parentPos["grup"] ?? "") !== $grup) return ["ok" => false, "pesan" => "Kelompok akun induk (" . $parentPos["grup"] . ") harus sama dengan kelompok akun (" . $grup . ")."];
        }

        $sumber = $existing ? $existing->sumber : "tambahan";
        if ($urutan <= 0) {
            $maxRow = $this->db->select_max("urutan")->get("neraca_pos")->row();
            $urutan = ($maxRow && $maxRow->urutan !== null) ? (((int)$maxRow->urutan) + 10) : 1;
        }
        $row = [
            "kode" => $kode,
            "uraian" => $uraian,
            "grup" => $grup,
            "sign" => $sign,
            "parent_kode" => ($parent === "") ? null : $parent,
            "urutan" => $urutan,
            "tampil" => $tampil,
            "aktif" => 1,
            "sumber" => $sumber,
            "updated_by" => $updated_by,
        ];
        if ($existing) {
            $this->db->where("kode", $kode)->update("neraca_pos", $row);
            $pesan = "Akun " . $kode . " berhasil diperbarui.";
        } else {
            $this->db->insert("neraca_pos", $row);
            $pesan = "Akun " . $kode . " berhasil ditambahkan.";
        }
        $this->resetPosListCache();
        return ["ok" => true, "pesan" => $pesan];
    }

    public function setAktifAkun($kode, $aktif, $updated_by)
    {
        $kode = (string)$kode;
        $existing = $this->cariAkun($kode);
        if (!$existing) return ["ok" => false, "pesan" => "Akun " . $kode . " tidak ditemukan."];
        $aktif = $aktif ? 1 : 0;
        if ($aktif === 0) {
            if ($this->kodeDipakai($kode)) {
                return ["ok" => false, "pesan" => "Akun " . $kode . " sudah punya data (Neraca Awal/Jurnal), jadi tidak bisa dinonaktifkan."];
            }
            if ($this->anakAktif($kode) > 0) {
                return ["ok" => false, "pesan" => "Akun " . $kode . " masih punya akun anak. Nonaktifkan anaknya dulu."];
            }
        }
        $this->db->where("kode", $kode)->update("neraca_pos", ["aktif" => $aktif, "updated_by" => $updated_by]);
        $this->resetPosListCache();
        return ["ok" => true, "pesan" => "Akun " . $kode . ($aktif ? " diaktifkan." : " dinonaktifkan.")];
    }
}
