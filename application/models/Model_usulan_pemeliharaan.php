<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_usulan_pemeliharaan extends CI_Model
{

    public function getFiltered($bagian_upk = null, $tahun_rkap = null)
    {
        $this->db->select('*');
        $this->db->from('usulan_pemeliharaan');
        if ($bagian_upk && $bagian_upk != 'SEMUA') {
            $this->db->where('bagian_upk', $bagian_upk);
        }
        if ($tahun_rkap) {
            $this->db->where('tahun_rkap', $tahun_rkap);
        }
        $this->db->order_by('bagian_upk', 'ASC');
        return $this->db->get()->result();
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('usulan_pemeliharaan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('usulan_pemeliharaan');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNamaUpk($dataUpk, $dataTahun)
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_pemeliharaan');
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

    public function getUsulanPemeliharaan($id_usulanPemeliharaan)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_pemeliharaan', ['id_usulanPemeliharaan' => $id_usulanPemeliharaan])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'no_perkiraan' => $this->input->post('no_perkiraan', true),
            'nama_perkiraan' => $this->input->post('nama_perkiraan', true),
            'latar_belakang' => $this->input->post('latar_belakang', true),
            'solusi' => $this->input->post('solusi', true),
            'volume' => (int) $this->input->post('volume', true),
            'satuan' => $this->input->post('satuan', true),
            'biaya' => (int) $this->input->post('biaya', true),
            'ket' => $this->input->post('ket', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_usulanPemeliharaan', $this->input->post('id_usulanPemeliharaan'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_pemeliharaan', $data);
    }

    public function updateFoto($data)
    {
        $this->db->where('id_usulanPemeliharaan', $data['id_usulanPemeliharaan']);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->set('foto_ket', $data['foto_ket']);
        $this->db->update('usulan_pemeliharaan');
    }

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('usulan_pemeliharaan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
