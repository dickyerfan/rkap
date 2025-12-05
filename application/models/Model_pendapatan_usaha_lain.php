<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_usaha_lain extends CI_Model
{

    public function getRekapPendapatanUsahaLainnya($tahun, $kode_prefix)
    {
        $this->db->select("
            no_per.kode, 
            no_per.name, 
            MONTH(rkap_rekap.bulan) as bulan, 
            SUM(rkap_rekap.pagu) as total
        ");
        $this->db->from('rkap_rekap');
        $this->db->join('no_per', 'no_per.kode = rkap_rekap.no_per_id');
        $this->db->where('YEAR(rkap_rekap.bulan)', $tahun);
        $this->db->like('rkap_rekap.no_per_id', $kode_prefix, 'after');
        $this->db->group_by(['no_per.kode', 'no_per.name', 'MONTH(rkap_rekap.bulan)']);
        $this->db->order_by('no_per.kode', 'ASC');
        $query = $this->db->get()->result();

        // Susun ulang jadi array per kode (kolom Jan-Des + jumlah)
        $result = [];
        foreach ($query as $row) {
            if (!isset($result[$row->kode])) {
                $result[$row->kode] = [
                    'kode'  => $row->kode,
                    'name'  => $row->name,
                    'bulan' => array_fill(1, 12, 0),
                    'jumlah' => 0
                ];
            }
            $result[$row->kode]['bulan'][(int)$row->bulan] = (float)$row->total;
            $result[$row->kode]['jumlah'] += (float)$row->total;
        }

        return $result;
    }


    public function saveSubsidi($tahun, $bulan, $kode, $pagu)
    {

        $data = [
            'id_upk'    => null,
            'cabang_id' => 24, // fixed utk subsidi
            'no_per_id' => $kode,
            'bulan'     => $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01',
            'pagu'      => $pagu
        ];

        $this->db->where('bulan', $data['bulan']);
        $this->db->where('no_per_id', $kode);
        $cek = $this->db->get('rkap_rekap')->row();

        if ($cek) {
            $this->db->where('id', $cek->id)->update('rkap_rekap', $data);
        } else {
            $this->db->insert('rkap_rekap', $data);
        }

        return true;
    }

    public function savePenagihan($tahun, $kode, $pagu)
    {

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data = [
                'id_upk'    => null,
                'cabang_id' => 23, // fixed utk penagihan
                'no_per_id' => $kode,
                'bulan'     => $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01',
                'pagu'      => $pagu
            ];

            $this->db->where('YEAR(bulan)', $tahun);
            $this->db->where('MONTH(bulan)', $bulan);
            $this->db->where('no_per_id', $kode);
            $cek = $this->db->get('rkap_rekap')->row();

            if ($cek) {
                $this->db->where('id', $cek->id)->update('rkap_rekap', $data);
            } else {
                $this->db->insert('rkap_rekap', $data);
            }
        }

        return true;
    }
}
