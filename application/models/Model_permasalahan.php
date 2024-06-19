<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_permasalahan extends CI_Model
{

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('permasalahan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('permasalahan');
        $this->db->where('tahun_rkap', $dataTahun);
        $this->db->where('bagian_upk', $dataUpk);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNamaUpk($dataUpk, $dataTahun)
    {
        $this->db->select('bagian_upk');
        $this->db->from('permasalahan');
        $this->db->where('tahun_rkap', $dataTahun);
        $this->db->where('bagian_upk', $dataUpk);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpload($tableName)
    {
        $this->db->select('status');
        $this->db->from($tableName);
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdate($tableName)
    {
        $this->db->select('status_update');
        $this->db->from($tableName);
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getPermasalahan($id_permasalahan)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('permasalahan', ['id_permasalahan' => $id_permasalahan])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'sub_bagian' => $this->input->post('sub_bagian', true),
            'permasalahan' => $this->input->post('permasalahan', true),
            'penyebab' => $this->input->post('penyebab', true),
            'tindak_lanjut' => $this->input->post('tindak_lanjut', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_permasalahan', $this->input->post('id_permasalahan'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('permasalahan', $data);
    }

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('permasalahan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
