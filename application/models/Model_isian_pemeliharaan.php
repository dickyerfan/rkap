<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_isian_pemeliharaan extends CI_Model
{

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('usulan_pemeliharaan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getIsianPemeliharaan($id_usulanPemeliharaan)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_pemeliharaan', ['id_usulanPemeliharaan' => $id_usulanPemeliharaan])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'biaya' => (int) $this->input->post('biaya', true)
            // 'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanPemeliharaan', $this->input->post('id_usulanPemeliharaan'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_pemeliharaan', $data);
    }
}
