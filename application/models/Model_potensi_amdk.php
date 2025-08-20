<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_potensi_amdk extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getProduksi()
    {
        $this->db->select('*');
        $this->db->from('potensi_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getProduksiAmdk()
    {
        $this->db->select('*');
        $this->db->from('potensi_amdk');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function uploadData()
    {
        $data = [
            'tahun_rkap' => date('Y'),
            'uraian' => $this->input->post('uraian', true),
            'tarif' => $this->input->post('tarif', true),
            'harga' => (float) $this->input->post('harga', true),
            'jumlah' => (float) $this->input->post('jumlah', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('potensi_amdk', $data);
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'harga' => (float) $this->input->post('harga', true),
            'jumlah' => (float) $this->input->post('jumlah', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_potensi_amdk', $this->input->post('id_potensi_amdk'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('potensi_amdk', $data);
    }

    public function getPotensiAmdk($id_potensi_amdk)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('potensi_amdk', ['id_potensi_amdk' => $id_potensi_amdk])
            ->row();
    }

    public function getStatusUpload($tableName)
    {
        $this->db->select('status');
        $this->db->from($tableName);
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
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

    public function cekDuplikat($uraian, $tahun_rkap)
    {
        return $this->db
            ->where('TRIM(uraian) =', $uraian) // TRIM supaya spasi depan/belakang tidak bikin beda
            ->where('tahun_rkap', $tahun_rkap)
            ->get('potensi_amdk')
            ->row();
    }

    public function getBiaya()
    {
        $this->db->select('*');
        $this->db->from('biaya_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllBiayaAmdk()
    {
        $this->db->select('*');
        $this->db->from('biaya_amdk');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function cekDuplikatBiaya($nama_biaya, $tahun_rkap)
    {
        return $this->db
            ->where('TRIM(nama_biaya) =', $nama_biaya) // TRIM supaya spasi depan/belakang tidak bikin beda
            ->where('tahun_rkap', $tahun_rkap)
            ->get('biaya_amdk')
            ->row();
    }

    public function uploadDataBiaya()
    {
        $data = [
            'tahun_rkap' => date('Y'),
            'tipe_biaya' => $this->input->post('tipe_biaya', true),
            'nama_biaya' => $this->input->post('nama_biaya', true),
            'rincian_biaya' => $this->input->post('rincian_biaya', true),
            'keterangan' => $this->input->post('keterangan', true),
            'jumlah' => (float) $this->input->post('jumlah', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('biaya_amdk', $data);
    }

    public function updateDataBiaya()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'tipe_biaya' => $this->input->post('tipe_biaya', true),
            'nama_biaya' => $this->input->post('nama_biaya', true),
            'rincian_biaya' => $this->input->post('rincian_biaya', true),
            'keterangan' => $this->input->post('keterangan', true),
            'jumlah' => (float) $this->input->post('jumlah', true),
            'tgl_update' => date('Y-m-d H:i:s')

        ];
        $this->db->where('id_biaya_amdk', $this->input->post('id_biaya_amdk'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('biaya_amdk', $data);
    }

    public function getBiayaAmdk($id_biaya_amdk)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('biaya_amdk', ['id_biaya_amdk' => $id_biaya_amdk])
            ->row();
    }

    public function getPendNonAir()
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->where('uraian', 'Galon Baru/Non Air')
            ->get('potensi_amdk')
            ->result();
    }

    public function getPendAir()
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->where('uraian !=', 'Galon Baru/Non Air')
            ->get('potensi_amdk')
            ->result();
    }

    public function getBiayaPegawai()
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->where('tipe_biaya', 'Biaya Pegawai')
            ->get('biaya_amdk')
            ->result();
    }

    public function getBiayaOperasional()
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->where('tipe_biaya', 'Biaya Operasional')
            ->get('biaya_amdk')
            ->result();
    }
}
