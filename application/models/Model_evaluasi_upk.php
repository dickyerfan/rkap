<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_evaluasi_upk extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getPlgBaru()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getPlgBaruUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAirTerjual()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Air terjual');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getAirTerjualUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('uraian_evaluasi', 'Air terjual');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPendapatanAir()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Pendapatan air');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getPendapatanAirUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('uraian_evaluasi', 'Pendapatan air');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLembarAir()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Jumlah Lbr Yg Direkeningkan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getLembarAirUpk()
    {
        if (isset($dataTahun) && isset($dataUpk)) {
            $this->db->select('*');
            $this->db->from('evaluasi_upk');
            $this->db->where('bagian_upk', $dataUpk);
            $this->db->where('uraian_evaluasi', 'Jumlah Lbr Yg Direkeningkan');
            $this->db->where('tahun_rkap', $dataTahun);
            $query = $this->db->get();
            return $query->result();
        } else {
            $dataTahun = 2000;
            $dataUpk = $this->input->get('bagian_upk');
            $this->db->select('*');
            $this->db->from('evaluasi_upk');
            $this->db->where('bagian_upk', $dataUpk);
            $this->db->where('uraian_evaluasi', 'Jumlah Lbr Yg Direkeningkan');
            $this->db->where('tahun_rkap', $dataTahun);
            $query = $this->db->get();
            return $query->result();
        }
    }


    public function upload_plgBaru()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_evaluasi' => 'Penambahan Pelanggan Baru',
            'satuan' => 'SR',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_upk', $data);
    }

    public function upload_plgAktif()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_evaluasi' => 'Jumlah pelanggan aktif',
            'satuan' => 'SR',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_upk', $data);
    }

    public function upload_jmlRek()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_evaluasi' => 'Jumlah Lbr Yg Direkeningkan',
            'satuan' => 'Lbr',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_upk', $data);
    }

    public function upload_airTerjual()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_evaluasi' => 'Air terjual',
            'satuan' => 'M3',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_upk', $data);
    }

    public function upload_pendapatanAir()
    {
        $data = [
            'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_evaluasi' => 'Pendapatan air',
            'satuan' => 'Rp',
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'bagian_upk' => $this->session->userdata('upk_bagian')
        ];
        $this->db->insert('evaluasi_upk', $data);
    }

    public function getIdEvaluasiUpk($id_evaluasi_upk)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('evaluasi_upk', ['id_evaluasi_upk' => $id_evaluasi_upk])
            ->row();
    }

    public function update_evaluasi_upk()
    {
        $data = [
            'rkap' => (int) $this->input->post('rkap', true),
            'realisasi' => (int) $this->input->post('realisasi', true),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_evaluasi_upk', $this->input->post('id_evaluasi_upk'));
        $this->db->where('status_update', 1);
        $this->db->update('evaluasi_upk', $data);
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
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function getTargetUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('target_pencapaian');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdTarget($id_target)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('target_pencapaian', ['id_target' => $id_target])
            ->row();
    }

    public function updateTargetSr()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'uraian_target' => $this->input->post('uraian_target', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_target', $this->input->post('id_target'));
        $this->db->where('status_update', 1);
        $this->db->update('target_pencapaian', $data);
    }
    // akhir fungsi target pencapaian


    //  Awal get status Upload
    public function getStatusUpload($tableName)
    {
        $this->db->select('status');
        $this->db->from($tableName);
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUploadPlgbaru()
    {
        $this->db->select('status');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Penambahan Pelanggan Baru');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUploadPlgAktif()
    {
        $this->db->select('status');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Jumlah Pelanggan Aktif');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUploadJumRek()
    {
        $this->db->select('status');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Jumlah Lbr Yg Direkeningkan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUploadAirTerjual()
    {
        $this->db->select('status');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Air terjual');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUploadPendapatanAir()
    {
        $this->db->select('status');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Pendapatan Air');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    //  Akhir get status Upload

    //  Awal get status Update
    public function getStatusUpdate($tableName)
    {
        $this->db->select('status_update');
        $this->db->from($tableName);
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdatePlgBaru()
    {
        $this->db->select('status_update');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Penambahan Pelanggan Baru');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdatePlgAktif()
    {
        $this->db->select('status_update');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Jumlah Pelanggan Aktif');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdateJumRek()
    {
        $this->db->select('status_update');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Jumlah Lbr Yg Direkeningkan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdateAirTerjual()
    {
        $this->db->select('status_update');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Air terjual');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }
    public function getStatusUpdatePendapatanAir()
    {
        $this->db->select('status_update');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('uraian_evaluasi', 'Pendapatan Air');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }
    //  Akhir get status Update

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
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsulanAdminUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('usulan_admin');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdUsulanAdmin($id_usulanAdmin)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_admin', ['id_usulanAdmin' => $id_usulanAdmin])
            ->row();
    }

    public function updateUsulanAdmin()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'usulan_admin' => $this->input->post('usulan_admin', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanAdmin', $this->input->post('id_usulanAdmin'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
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
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsulanTeknikUpk()
    {
        $dataTahun = $this->input->post('tahun_rkap');
        $dataUpk = $this->input->post('bagian_upk');
        $this->db->select('*');
        $this->db->from('usulan_teknik');
        $this->db->where('bagian_upk', $dataUpk);
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getIdUsulanTeknik($id_usulanTeknik)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_teknik', ['id_usulanTeknik' => $id_usulanTeknik])
            ->row();
    }

    public function updateUsulanTeknik()
    {
        $data = [
            // 'tahun_rkap' => (int) $this->input->post('tahun_rkap', true),
            'usulan_teknik' => $this->input->post('usulan_teknik', true),
            'bagian_upk' => $this->session->userdata('upk_bagian'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanTeknik', $this->input->post('id_usulanTeknik'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_teknik', $data);
    }
    // akhir usulan teknik

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('evaluasi_upk');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
}
