<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_potensi_sr extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('potensi_sr');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('potensi_sr');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getKeterangan()
    {
        $this->db->select('*');
        $this->db->from('ket_potensi_sr');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getKeteranganUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('ket_potensi_sr');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAirBaku()
    {
        $this->db->select('*');
        $this->db->from('tambah_air_baku');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getAirBakuUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('tambah_air_baku');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalSR()
    {
        $this->db->where('bagian_upk',  $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->select_sum('jumlah_sr')->get('ket_potensi_sr');
        return $query->row()->jumlah_sr;
    }
    public function getTotalSRUpk($dataUpk)
    {
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->select_sum('jumlah_sr')->get('ket_potensi_sr');
        return $query->row()->jumlah_sr;
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

    // Awal Potensi SR
    public function uploadData()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'kap_pro' => (float) $this->input->post('kap_pro', true),
            'kap_manf' => (float) $this->input->post('kap_manf', true),
            'jam_op' => (float) $this->input->post('jam_op', true),
            'tk_bocor' => (float) $this->input->post('tk_bocor', true),
            'plg_aktif' => (int) $this->input->post('plg_aktif', true),
            'tambah_sr' => (int) $this->input->post('tambah_sr', true),
            'pola_kon' => (float) $this->input->post('pola_kon', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('potensi_sr', $data);
    }

    // public function uploadData()
    // {
    //     $data = [
    //         'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
    //         'kap_pro' => (float) $this->input->post('kap_pro', true),
    //         'kap_manf' => (float) $this->input->post('kap_manf', true),
    //         'jam_op' => (float) $this->input->post('jam_op', true),
    //         'tk_bocor' => (float) $this->input->post('tk_bocor', true),
    //         'plg_aktif' => (int) $this->input->post('plg_aktif', true),
    //         'tambah_sr' => (int) $this->input->post('tambah_sr', true),
    //         'pola_kon' => (float) $this->input->post('pola_kon', true),
    //         'bagian_upk' => $this->session->userdata('upk_bagian')
    //     ];
    //     $this->db->insert('potensi_sr', $data);
    // }

    // public function uploadData_ket($data)
    // {
    //     $this->db->insert('ket_potensi_sr', $data);
    // }

    public function editPotensiSr()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'kap_pro' => (float) $this->input->post('kap_pro', true),
            'kap_manf' => (float) $this->input->post('kap_manf', true),
            'jam_op' => (float) $this->input->post('jam_op', true),
            'tk_bocor' => (float) $this->input->post('tk_bocor', true),
            'plg_aktif' => (int) $this->input->post('plg_aktif', true),
            'tambah_sr' => (int) $this->input->post('tambah_sr', true),
            'pola_kon' => (float) $this->input->post('pola_kon', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];

        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('potensi_sr', $data);
    }

    // public function getUpkBagian($upk_bagian)
    // {
    //     return $this->db->get_where('potensi_sr', ['bagian_upk' => $upk_bagian])->row();
    // }

    public function getUpkBagian($upk_bagian)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('potensi_sr', ['bagian_upk' => $upk_bagian])
            ->row();
    }


    public function updateData()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'kap_pro' => (float) $this->input->post('kap_pro', true),
            'kap_manf' => (float) $this->input->post('kap_manf', true),
            'jam_op' => (float) $this->input->post('jam_op', true),
            'tk_bocor' => (float) $this->input->post('tk_bocor', true),
            'plg_aktif' => (int) $this->input->post('plg_aktif', true),
            'tambah_sr' => (int) $this->input->post('tambah_sr', true),
            'pola_kon' => (float) $this->input->post('pola_kon', true),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('bagian_upk', $this->input->post('bagian_upk'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('potensi_sr', $data);
    }
    // Akhir Potensi SR

    // Awal Air Baku
    public function uploadData_tbh_airbaku()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian' => $this->input->post('uraian', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('tambah_air_baku', $data);
    }

    public function getIdAirBaku($id_tambah_air_baku)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('tambah_air_baku', ['id_tambah_air_baku' => $id_tambah_air_baku])
            ->row();
    }

    public function update_air_baku()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian' => $this->input->post('uraian', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_tambah_air_baku', $this->input->post('id_tambah_air_baku'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('tambah_air_baku', $data);
    }
    // Akhir Air Baku

    // Awal Keterangan Potensi SR
    public function uploadData_ket()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'nama_wil' => $this->input->post('nama_wil', true),
            'jumlah_sr' => (int) $this->input->post('jumlah_sr', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('ket_potensi_sr', $data);
    }

    public function getIdKetPotensi($id_ket_potensi)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('ket_potensi_sr', ['id_ket_potensi' => $id_ket_potensi])
            ->row();
    }

    public function update_ket_potensi()
    {
        $data = [
            'nama_wil' => $this->input->post('nama_wil', true),
            'jumlah_sr' => (int) $this->input->post('jumlah_sr', true),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_ket_potensi', $this->input->post('id_ket_potensi'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('ket_potensi_sr', $data);
    }

    // Akhir Keterangan Potensi SR
}
