<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_evaluasi_program extends CI_Model
{

    // public function getData()
    // {
    //     $this->db->select('*');
    //     $this->db->from('evaluasi_program');
    //     $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
    //     $this->db->where('tahun_rkap', date('Y'));
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getFilteredEvaluasi($bagian_upk = null, $tahun_rkap = null)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_program'); // ganti dengan nama tabel kamu

        if ($bagian_upk && $bagian_upk != 'SEMUA') {
            $this->db->where('bagian_upk', $bagian_upk);
        }

        if ($tahun_rkap) {
            $this->db->where('tahun_rkap', $tahun_rkap);
        }
        $this->db->order_by('bagian_upk', 'ASC');
        return $this->db->get()->result();
    }
    public function getFilteredUsulan($bagian_upk = null, $tahun_rkap = null)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_usulan'); // ganti dengan nama tabel kamu

        if ($bagian_upk && $bagian_upk != 'SEMUA') {
            $this->db->where('bagian_upk', $bagian_upk);
        }

        if ($tahun_rkap) {
            $this->db->where('tahun_rkap', $tahun_rkap);
        }
        $this->db->order_by('bagian_upk', 'ASC');
        return $this->db->get()->result();
    }


    // public function getData_usulan()
    // {
    //     $this->db->select('*');
    //     $this->db->from('evaluasi_usulan');
    //     $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
    //     $this->db->where('tahun_rkap', date('Y'));
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function getData_admin($bagian, $dataTahun)
    // {
    //     $this->db->select('*');
    //     $this->db->from('evaluasi_program');
    //     $this->db->where('bagian_upk', $bagian);
    //     $this->db->where('tahun_rkap', $dataTahun);
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getData_usulan_admin($bagian, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_usulan');
        $this->db->where('bagian_upk', $bagian);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_program');
        $this->db->where('tahun_rkap', $dataTahun);
        $this->db->where('bagian_upk', $dataUpk);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNamaUpk($dataUpk, $dataTahun)
    {
        $this->db->select('bagian_upk');
        $this->db->from('evaluasi_program');
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

    public function getEvaluasi_program($id_evaluasi_program)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('evaluasi_program', ['id_evaluasi_program' => $id_evaluasi_program])
            ->row();
    }
    public function getEvaluasi_usulan($id_usulan)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('evaluasi_usulan', ['id_usulan' => $id_usulan])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'evaluasi' => $this->input->post('evaluasi', true),
            'tindak_lanjut' => $this->input->post('tindak_lanjut', true),
            'keterangan' => $this->input->post('keterangan', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_evaluasi_program', $this->input->post('id_evaluasi_program'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('evaluasi_program', $data);
    }
    public function updateData_usulan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'usulan' => $this->input->post('usulan', true),
            'solusi' => $this->input->post('solusi', true),
            'keterangan' => $this->input->post('keterangan', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_usulan', $this->input->post('id_usulan'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('evaluasi_usulan', $data);
    }

    public function updateFoto($data)
    {
        $this->db->where('id_usulanBarang', $data['id_usulanBarang']);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->set('foto_ket', $data['foto_ket']);
        $this->db->update('evaluasi_program');
    }

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_program');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
