<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_luar_usaha extends CI_Model
{
    public function getPendapatanLuarUsaha($tahun)
    {
        $tahun = intval($tahun);

        $this->db->select('n.kode, n.name, r.pagu, r.bulan');
        $this->db->from('no_per n');
        // join menggunakan kode (karena r.no_per_id menyimpan kode seperti '88.01.02.01')
        $this->db->join(
            "rkap_rekap r",
            "r.no_per_id = n.kode AND YEAR(r.bulan) = " . $this->db->escape($tahun),
            'left'
        );
        $this->db->like('n.kode', '88.', 'after');
        $this->db->order_by('n.kode', 'ASC');

        $q = $this->db->get();

        $items = [];
        $order = [];

        foreach ($q->result() as $row) {
            $kode = $row->kode;
            if (!isset($items[$kode])) {
                $items[$kode] = [
                    'kode'  => $kode,
                    'name'  => $row->name,
                    'bulan' => array_fill(1, 12, 0),
                    'total' => 0
                ];
                $order[] = $kode; // preserve order from query
            }

            if (!empty($row->bulan)) {
                $m = (int) date('n', strtotime($row->bulan));
                $val = (float) $row->pagu;
                $items[$kode]['bulan'][$m] += $val;
                $items[$kode]['total'] += $val;
            }
        }

        return ['items' => $items, 'order' => $order];
    }

    public function save_rekap($kode, $tahun, $cabang_id, $data_bulanan)
    {
        foreach ($data_bulanan as $bulan => $nilai) {
            if ($nilai === '' || $nilai === null) {
                continue; // lewati jika kosong
            }

            $tgl_bulan = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';

            // cek apakah data sudah ada
            $cek = $this->db->get_where('rkap_rekap', [
                'no_per_id' => $kode,
                'bulan'     => $tgl_bulan
            ])->row();

            if ($cek) {
                // update
                $this->db->where('id', $cek->id);
                $this->db->update('rkap_rekap', [
                    'pagu'      => $nilai,
                    'cabang_id' => $cabang_id
                ]);
            } else {
                // insert
                $this->db->insert('rkap_rekap', [
                    'no_per_id' => $kode,
                    'bulan'     => $tgl_bulan,
                    'pagu'      => $nilai,
                    'cabang_id' => $cabang_id
                ]);
            }
        }
    }
}
