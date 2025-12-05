<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_arus_kas extends CI_Model
{

    public function getTotalsByCodes($tahun, $upk, $codes)
    {
        // Siapkan filter dasar
        $this->db->select("
        n.kode AS kode_utama,
        LEFT(n.kode, 8) AS kode_parent,
        MONTH(r.bulan) AS bulan,
        SUM(r.pagu) AS total
    ");
        $this->db->from('rkap_arus_kas r');
        $this->db->join('no_per n', 'r.no_per_id = n.kode', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter UPK
        if ($upk !== 'all') {
            if ($upk === 'pusat') {
                $this->db->where_in('r.cabang_id', ['23', '24', '25', '26', '27', '28']);
            } else {
                $this->db->where('r.cabang_id', $upk);
            }
        }

        // Ambil hanya kode yang dimulai dengan daftar $codes (misalnya 98.01.01 dst)
        $like_clauses = [];
        foreach ($codes as $code) {
            $like_clauses[] = "n.kode LIKE " . $this->db->escape($code . '%');
        }
        $this->db->where('(' . implode(' OR ', $like_clauses) . ')');

        $this->db->group_by(['kode_parent', 'bulan']);
        $query = $this->db->get()->result();

        // Siapkan array hasil akhir
        $result = [];
        foreach ($codes as $code) {
            $result[$code] = [
                'bulan' => array_fill(1, 12, 0),
                'total' => 0
            ];
        }

        // Olah hasil query
        foreach ($query as $row) {
            foreach ($codes as $code) {
                if (strpos($row->kode_utama, $code) === 0) {
                    $bulan = (int)$row->bulan;
                    $result[$code]['bulan'][$bulan] += (float)$row->total;
                    $result[$code]['total'] += (float)$row->total;
                }
            }
        }

        return $result;
    }

    public function getTotalsByCodesAmdk($tahun, $codes)
    {
        // Siapkan filter dasar
        $this->db->select("
        n.kode AS kode_utama,
        LEFT(n.kode, 8) AS kode_parent,
        MONTH(r.bulan) AS bulan,
        SUM(r.pagu) AS total
    ");
        $this->db->from('rkap_amdk_arus_kas r');
        $this->db->join('no_per n', 'r.no_per_id = n.kode', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Ambil hanya kode yang dimulai dengan daftar $codes (misalnya 98.01.01 dst)
        $like_clauses = [];
        foreach ($codes as $code) {
            $like_clauses[] = "n.kode LIKE " . $this->db->escape($code . '%');
        }
        $this->db->where('(' . implode(' OR ', $like_clauses) . ')');

        $this->db->group_by(['kode_parent', 'bulan']);
        $query = $this->db->get()->result();

        // Siapkan array hasil akhir
        $result = [];
        foreach ($codes as $code) {
            $result[$code] = [
                'bulan' => array_fill(1, 12, 0),
                'total' => 0
            ];
        }

        // Olah hasil query
        foreach ($query as $row) {
            foreach ($codes as $code) {
                if (strpos($row->kode_utama, $code) === 0) {
                    $bulan = (int)$row->bulan;
                    $result[$code]['bulan'][$bulan] += (float)$row->total;
                    $result[$code]['total'] += (float)$row->total;
                }
            }
        }

        return $result;
    }

    // public function getTotalsByFormat($tahun, $format)
    // {
    //     $result = [];

    //     // Ambil list kode tepat (exact match)
    //     $listKode = [];
    //     foreach ($format as $f) {
    //         if (isset($f['kode']) && $f['kode'] !== '') {
    //             $listKode[] = $f['kode'];
    //         }
    //     }

    //     if (empty($listKode)) return [];

    //     $this->db->select("
    //     r.no_per_id AS kode,
    //     MONTH(r.bulan) AS bulan,
    //     SUM(r.pagu) AS total
    // ");
    //     $this->db->from('rkap_amdk_arus_kas r');
    //     $this->db->where_in('r.no_per_id', $listKode); // EXACT MATCH !
    //     $this->db->where('YEAR(r.bulan)', $tahun);
    //     $this->db->group_by(['kode', 'bulan']);

    //     $rows = $this->db->get()->result();

    //     foreach ($listKode as $k) {
    //         $result[$k] = [
    //             'bulan' => array_fill(1, 12, 0),
    //             'total' => 0
    //         ];
    //     }

    //     foreach ($rows as $r) {
    //         $kode = $r->kode;
    //         $bulan = (int)$r->bulan;
    //         $val   = (float)$r->total;

    //         $result[$kode]['bulan'][$bulan] += $val;
    //         $result[$kode]['total'] += $val;
    //     }

    //     return $result;
    // }
}
