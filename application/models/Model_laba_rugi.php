<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_laba_rugi extends CI_Model
{

    public function getTotalsByCodes($tahun, $upk, $codes)
    {
        $result = [];

        foreach ($codes as $code) {
            $this->db->select("
                '$code' as kode,
                MONTH(r.bulan) as bulan,
                SUM(r.pagu) as total
            ");
            $this->db->from('rkap_rekap r');
            $this->db->join('no_per n', 'r.no_per_id = n.kode', 'left');
            $this->db->where('YEAR(r.bulan)', $tahun);
            $this->db->like('n.kode', $code, 'after'); // semua child dari kode

            // filter UPK
            if ($upk !== 'all') {
                if ($upk === 'pusat') {
                    $this->db->where_in('r.cabang_id', ['23', '24', '25', '26', '27', '28']);
                } else {
                    $this->db->where('r.cabang_id', $upk);
                }
            }

            $this->db->group_by(['bulan']);
            $query = $this->db->get()->result();

            // siapkan array bulan 1-12 default 0
            $bulanArr = array_fill(1, 12, 0);
            $totalSum = 0;

            foreach ($query as $row) {
                $bulanArr[(int)$row->bulan] = (float)$row->total;
                $totalSum += (float)$row->total;
            }

            $result[$code] = [
                'bulan' => $bulanArr,
                'total' => $totalSum
            ];
        }

        return $result;
    }

    public function getTotalsByCodesAmdk($tahun, $codes)
    {
        $result = [];

        foreach ($codes as $code) {
            $this->db->select("
                '$code' as kode,
                MONTH(r.bulan) as bulan,
                SUM(r.pagu) as total
            ");
            $this->db->from('rkap_rekap r');
            $this->db->join('no_per n', 'r.no_per_id = n.kode', 'left');
            $this->db->where('YEAR(r.bulan)', $tahun);
            $this->db->where('r.cabang_id', 13);
            $this->db->like('n.kode', $code, 'after'); // semua child dari kode


            $this->db->group_by(['bulan']);
            $query = $this->db->get()->result();

            // siapkan array bulan 1-12 default 0
            $bulanArr = array_fill(1, 12, 0);
            $totalSum = 0;

            foreach ($query as $row) {
                $bulanArr[(int)$row->bulan] = (float)$row->total;
                $totalSum += (float)$row->total;
            }

            $result[$code] = [
                'bulan' => $bulanArr,
                'total' => $totalSum
            ];
        }

        return $result;
    }

    public function getTotals($tahun, $codes)
    {
        $this->db->select("
        LEFT(n.kode, LENGTH(n.kode)) AS kode,
        SUM(r.pagu) AS total
    ");
        $this->db->from('rkap_rekap r');
        $this->db->join('no_per n', 'r.no_per_id = n.kode', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Build LIKE multi kode
        $this->db->group_start();
        foreach ($codes as $code) {
            $this->db->or_like('n.kode', $code, 'after');
        }
        $this->db->group_end();

        $this->db->group_by('n.kode');

        $rows = $this->db->get()->result();

        // mapping hasil
        $result = [];
        foreach ($codes as $c) {
            $result[$c] = ['total' => 0];
        }

        foreach ($rows as $r) {
            // Cocokkan kode yang sesuai prefix
            foreach ($codes as $c) {
                if (strpos($r->kode, $c) === 0) {
                    $result[$c]['total'] += (float)$r->total;
                }
            }
        }

        return $result;
    }
}
