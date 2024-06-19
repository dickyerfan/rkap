<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_isian_inves extends CI_Model
{

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('usulan_investasi');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getIsianInves($id_usulanInves)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_investasi', ['id_usulanInvestasi' => $id_usulanInves])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'biaya' => (int) $this->input->post('biaya', true)
            // 'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanInvestasi', $this->input->post('id_usulanInvestasi'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_investasi', $data);
    }
}
