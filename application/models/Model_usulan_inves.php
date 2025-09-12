<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_usulan_inves extends CI_Model
{
    // public function getFiltered($bagian_upk = null, $tahun_rkap = null)
    // {
    //     $this->db->from('usulan_investasi');
    //     if (!empty($bagian_upk)) {
    //         $this->db->where('bagian_upk', $bagian_upk);
    //     }
    //     if ($tahun_rkap) {
    //         $this->db->where('tahun_rkap', $tahun_rkap);
    //     } else {
    //         $this->db->where('tahun_rkap', date('Y'));
    //     }
    //     return $this->db->get()->result();
    // }

    public function getFiltered($bagian_upk = null, $tahun_rkap = null)
    {
        $this->db->select('*');
        $this->db->from('usulan_investasi'); // ganti dengan nama tabel kamu

        if ($bagian_upk && $bagian_upk != 'SEMUA') {
            $this->db->where('bagian_upk', $bagian_upk);
        }

        if ($tahun_rkap) {
            $this->db->where('tahun_rkap', $tahun_rkap);
        }
        $this->db->order_by('bagian_upk', 'ASC'); // Urutkan berdasarkan bagian_upk secara ascending

        return $this->db->get()->result();
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('usulan_investasi');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('usulan_investasi');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNamaUpk($dataUpk, $dataTahun)
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_investasi');
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

    public function getUsulanInves($id_usulanInvestasi)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_investasi', ['id_usulanInvestasi' => $id_usulanInvestasi])
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
        $this->db->where('id_usulanInvestasi', $this->input->post('id_usulanInvestasi'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_investasi', $data);
    }

    public function updateFoto($data)
    {
        $this->db->where('id_usulanInvestasi', $data['id_usulanInvestasi']);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->set('foto_ket', $data['foto_ket']);
        $this->db->update('usulan_investasi');
    }

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('usulan_investasi');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
