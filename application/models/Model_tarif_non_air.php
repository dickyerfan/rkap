<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_tarif_non_air extends CI_Model
{
    public function get_tarif($tahun)
    {
        return $this->db->get_where('rkap_tarif_non_air', ['tahun' => $tahun])->result();
    }

    public function get_tarif_by_id($id)
    {
        return $this->db->get_where('rkap_tarif_non_air', ['id' => $id])->row();
    }

    public function get_tarif_grouped($tahun)
    {
        $this->db->select('jenis_pendapatan, parameter, nilai, id');
        $this->db->from('rkap_tarif_non_air');
        $this->db->where('tahun', $tahun);
        $this->db->order_by('FIELD(jenis_pendapatan, 
            "Pendapatan Sambungan Baru",
            "Pendapatan Pendaftaran",
            "Pendapatan Balik Nama",
            "Pendapatan Penyambungan Kembali",
            "Pendapatan Denda"
        ), parameter ASC');
        $rows = $this->db->get()->result();

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row->jenis_pendapatan][] = $row;
        }
        return $grouped;
    }

    public function update_tarif($id, $nilai)
    {
        $this->db->where('id', $id);
        return $this->db->update('rkap_tarif_non_air', ['nilai' => $nilai]);
    }

    public function duplicate($tahun_asal, $tahun_tujuan)
    {
        $cek = $this->db->get_where('rkap_tarif_non_air', ['tahun' => $tahun_tujuan])->num_rows();
        if ($cek > 0) {
            return 'exist';
        }

        $data_asal = $this->db->get_where('rkap_tarif_non_air', ['tahun' => $tahun_asal])->result_array();
        if (!$data_asal) {
            return false;
        }

        foreach ($data_asal as $row) {
            unset($row['id'], $row['tgl_upload'], $row['tgl_update']);
            $row['tahun'] = $tahun_tujuan;
            $this->db->insert('rkap_tarif_non_air', $row);
        }

        return true;
    }
}
