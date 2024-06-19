<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_evaluasi_amdk extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getTenagaKerja()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('jenis_uraian', 'Tenaga Kerja');
        $query = $this->db->get();
        return $query->result();
    }

    public function getTenagaKerjaAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('jenis_uraian', 'Tenaga Kerja');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPiutangUsaha()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('jenis_uraian', 'Piutang Usaha');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPiutangUsahaAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('jenis_uraian', 'Piutang Usaha');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPendapatanUsaha()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('jenis_uraian', 'Pendapatan Usaha');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPendapatanUsahaAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('jenis_uraian', 'Pendapatan Usaha');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }


    public function upload_tenaga_kerja()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'jenis_uraian' => 'Tenaga Kerja',
            'uraian_evaluasi' => $this->input->post('uraian_evaluasi'),
            'satuan' => 'Orang',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_amdk', $data);
    }

    public function upload_piutang_usaha()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'jenis_uraian' => 'Piutang Usaha',
            'uraian_evaluasi' => $this->input->post('uraian_evaluasi'),
            'satuan' => 'Rp',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_amdk', $data);
    }

    public function upload_pendapatan_usaha()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'jenis_uraian' => 'Pendapatan Usaha',
            'uraian_evaluasi' => $this->input->post('uraian_evaluasi'),
            'satuan' => 'Rp',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_amdk', $data);
    }



    public function getIdEvaluasiAmdk($id_evaluasi_amdk)
    {
        return $this->db->get_where('evaluasi_amdk', ['id_evaluasi_amdk' => $id_evaluasi_amdk])->row();
    }

    public function update_evaluasi_amdk()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_evaluasi_amdk', $this->input->post('id_evaluasi_amdk'));
        $this->db->where('status_update', 1);
        $this->db->update('evaluasi_amdk', $data);
    }

    // awal fungsi target pencapaian
    public function upload_target()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_target' => $this->input->post('uraian_target', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('target_pencapaian', $data);
    }

    public function getTarget()
    {
        $this->db->select('*');
        $this->db->from('target_pencapaian');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getTargetAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('target_pencapaian');
        $this->db->where('bagian_upk', 'amdk');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdTarget($id_target)
    {
        return $this->db->get_where('target_pencapaian', ['id_target' => $id_target])->row();
    }

    public function updateTargetSr()
    {
        $data = [
            'uraian_target' => $this->input->post('uraian_target', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_target', $this->input->post('id_target'));
        $this->db->where('status_update', 1);
        $this->db->update('target_pencapaian', $data);
    }
    // akhir fungsi target pencapaian

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
        $query = $this->db->get();
        return $query->row();
    }

    // awal usulan admin
    public function upload_usulanAdmin()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'usulan_admin' => $this->input->post('usulan_admin', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('usulan_admin', $data);
    }

    public function getUsulanAdmin()
    {
        $this->db->select('*');
        $this->db->from('usulan_admin');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsulanAdminAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('usulan_admin');
        $this->db->where('bagian_upk', 'amdk');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdUsulanAdmin($id_usulanAdmin)
    {
        return $this->db->get_where('usulan_admin', ['id_usulanAdmin' => $id_usulanAdmin])->row();
    }

    public function updateUsulanAdmin()
    {
        $data = [
            'usulan_admin' => $this->input->post('usulan_admin', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanAdmin', $this->input->post('id_usulanAdmin'));
        $this->db->where('status_update', 1);
        $this->db->update('usulan_admin', $data);
    }
    // akhir usulan admin

    // awal usulan teknik
    public function upload_usulanTeknik()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'usulan_teknik' => $this->input->post('usulan_teknik', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('usulan_teknik', $data);
    }

    public function getUsulanTeknik()
    {
        $this->db->select('*');
        $this->db->from('usulan_teknik');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsulanTeknikAmdk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('usulan_teknik');
        $this->db->where('bagian_upk', 'amdk');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdUsulanTeknik($id_usulanTeknik)
    {
        return $this->db->get_where('usulan_teknik', ['id_usulanTeknik' => $id_usulanTeknik])->row();
    }

    public function updateUsulanTeknik()
    {
        $data = [
            'usulan_teknik' => $this->input->post('usulan_teknik', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanTeknik', $this->input->post('id_usulanTeknik'));
        $this->db->where('status_update', 1);
        $this->db->update('usulan_teknik', $data);
    }
    // akhir usulan teknik

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_amdk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
