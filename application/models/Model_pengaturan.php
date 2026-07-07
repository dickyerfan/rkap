<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pengaturan extends CI_Model
{

    public function getStatusUpload()
    {
        $this->db->select('status');
        $this->db->from('rkap_pengaturan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        // $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function getStatusUpdate()
    {
        $this->db->select('status_update');
        $this->db->from('rkap_pengaturan');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        // $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function matikanUploadData()
    {
        $data = [
            'status' => $this->input->post('status', true),
            'ptgs_upload' => $this->session->userdata('nama_lengkap'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ];
        $this->db->where('tipe', 'upk');
        $this->db->update('rkap_pengaturan', $data);
    }
    public function matikanUploadDataBagian()
    {
        $data = [
            'status' => $this->input->post('status', true),
            'ptgs_upload' => $this->session->userdata('nama_lengkap'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ];
        $this->db->where('tipe', 'bagian');
        $this->db->update('rkap_pengaturan', $data);
    }
    public function matikanUploadDataAmdk()
    {
        $data = [
            'status' => $this->input->post('status', true),
            'ptgs_upload' => $this->session->userdata('nama_lengkap'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ];
        $this->db->where('bagian_upk', 'amdk');
        $this->db->update('rkap_pengaturan', $data);
    }

    // public function matikanUploadData()
    // {
    //     $data = [
    //         'status' => $this->input->post('status', true),
    //     ];
    //     $this->db->update('potensi_sr', $data);
    //     $this->db->update('ket_potensi_sr', $data);
    //     $this->db->update('tambah_air_baku', $data);
    //     $this->db->update('evaluasi_upk', $data);
    //     $this->db->update('evaluasi_amdk', $data);
    //     $this->db->update('evaluasi_program', $data);
    //     $this->db->update('potensi_amdk', $data);
    //     $this->db->update('target_pencapaian', $data);
    //     $this->db->update('usulan_admin', $data);
    //     $this->db->update('usulan_teknik', $data);
    //     $this->db->update('usulan_umum', $data);
    //     $this->db->update('usulan_barang', $data);
    //     $this->db->update('usulan_investasi', $data);
    //     $this->db->update('usulan_pemeliharaan', $data);
    //     $this->db->update('permasalahan', $data);
    // }

    public function matikanUpdateData()
    {
        $data = [
            'status_update' => $this->input->post('status_update', true),
            'ptgs_update' => $this->session->userdata('nama_lengkap'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('tipe', 'upk');
        $this->db->update('rkap_pengaturan', $data);
    }
    public function matikanUpdateDataBagian()
    {
        $data = [
            'status_update' => $this->input->post('status_update', true),
            'ptgs_update' => $this->session->userdata('nama_lengkap'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('tipe', 'bagian');
        $this->db->update('rkap_pengaturan', $data);
    }
    public function matikanUpdateDataAmdk()
    {
        $data = [
            'status_update' => $this->input->post('status_update', true),
            'ptgs_update' => $this->session->userdata('nama_lengkap'),
            'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('bagian_upk', 'amdk');
        $this->db->update('rkap_pengaturan', $data);
    }

    // public function matikanUpdateData()
    // {
    //     $data = [
    //         'status_update' => $this->input->post('status_update', true),
    //     ];
    //     $this->db->update('potensi_sr', $data);
    //     $this->db->update('ket_potensi_sr', $data);
    //     $this->db->update('tambah_air_baku', $data);
    //     $this->db->update('evaluasi_upk', $data);
    //     $this->db->update('evaluasi_amdk', $data);
    //     $this->db->update('evaluasi_program', $data);
    //     $this->db->update('potensi_amdk', $data);
    //     $this->db->update('target_pencapaian', $data);
    //     $this->db->update('usulan_admin', $data);
    //     $this->db->update('usulan_barang', $data);
    //     $this->db->update('usulan_teknik', $data);
    //     $this->db->update('usulan_umum', $data);
    //     $this->db->update('usulan_investasi', $data);
    //     $this->db->update('usulan_pemeliharaan', $data);
    //     $this->db->update('permasalahan', $data);
    // }

    public function cekUpload()
    {
        $this->db->select('status');
        $this->db->from('rkap_pengaturan');
        $this->db->where('tipe', 'upk');
        $query = $this->db->get();
        return $query->row();
    }
    public function cekUploadBagian()
    {
        $this->db->select('status');
        $this->db->from('rkap_pengaturan');
        $this->db->where('tipe', 'bagian');
        $query = $this->db->get();
        return $query->row();
    }
    public function cekUploadAmdk()
    {
        $this->db->select('status');
        $this->db->from('rkap_pengaturan');
        $this->db->where('bagian_upk', 'amdk');
        $query = $this->db->get();
        return $query->row();
    }

    // public function cekUpload()
    // {
    //     $this->db->select('status');
    //     $this->db->from('potensi_sr');
    //     $this->db->where('tahun_rkap', date('Y'));
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function cekUpdate()
    {
        $this->db->select('status_update');
        $this->db->from('rkap_pengaturan');
        $this->db->where('tipe', 'upk');
        // $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }
    public function cekUpdateBagian()
    {
        $this->db->select('status_update');
        $this->db->from('rkap_pengaturan');
        $this->db->where('tipe', 'bagian');
        // $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }
    public function cekUpdateAmdk()
    {
        $this->db->select('status_update');
        $this->db->from('rkap_pengaturan');
        $this->db->where('bagian_upk', 'amdk');
        // $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    // public function cekUpdate()
    // {
    //     $this->db->select('status_update');
    //     $this->db->from('potensi_sr');
    //     $this->db->where('tahun_rkap', date('Y'));
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    public function cekStatusPenggunaUpk()
    {
        $this->db->select('status');
        $this->db->from('user');
        $this->db->where('tipe', 'upk');
        // $this->db->where_in('tipe', ['upk', 'bagian']);
        $query = $this->db->get();
        return $query->row();
    }

    public function penggunaOffUpk()
    {
        $data = [
            'status' => $this->input->post('status', true),
        ];

        $this->db->where('tipe', 'upk');
        $this->db->update('user', $data);
    }

    public function cekStatusPenggunaBagian()
    {
        $this->db->select('status');
        $this->db->from('user');
        $this->db->where('tipe', 'bagian');
        $this->db->or_where('tipe', 'korektor');
        $query = $this->db->get();
        return $query->row();
    }

    public function penggunaOffBagian()
    {
        $data = [
            'status' => $this->input->post('status', true),
        ];

        $this->db->where('tipe', 'bagian');
        $this->db->or_where('tipe', 'korektor');
        $this->db->update('user', $data);
    }

    // public function cekStatusPengisi()
    // {
    //     $this->db->select('status');
    //     $this->db->from('user');
    //     $this->db->where('level', 'Pengguna');
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    // public function pengisiOff()
    // {
    //     $data = [
    //         'status' => $this->input->post('status', true),
    //     ];

    //     $this->db->where('level', 'Pengguna');
    //     $this->db->update('user', $data);
    // }

    public function cekNamaUpk()
    {
        $this->db->select('upk_bagian');
        $this->db->from('user');
        $this->db->where('tipe', 'upk');
        $this->db->where('upk_bagian !=', 'amdk');
        $query = $this->db->get();
        return $query->result();
    }

    public function cekNamaBagian()
    {
        $this->db->select('upk_bagian');
        $this->db->from('user');
        $this->db->where('tipe', 'bagian');
        $this->db->order_by('upk_bagian', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function cekPotensiSr()
    {
        $this->db->select('bagian_upk');
        $this->db->from('potensi_sr');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekEvaluasiUpk()
    {
        $this->db->select('bagian_upk, COUNT(DISTINCT uraian_evaluasi) as jml');
        $this->db->from('evaluasi_upk');
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->group_by('bagian_upk');
        $query = $this->db->get();
        return $query->result();
    }

    public function cekProyeksiUpk()
    {
        $query = $this->db->query("
            SELECT REPLACE(LOWER(rnu.nama_upk), ' ', '') as bagian_upk
            FROM rkap_evaluasi_pelanggan rep
            JOIN rkap_nama_upk rnu ON rnu.id_upk = rep.id_upk
            WHERE rep.tahun_rkap = ?
            GROUP BY rnu.nama_upk
        ", [date('Y') + 1]);
        return $query->result();
    }
    public function cekEvaluasiAmdk()
    {
        $this->db->select('bagian_upk');
        $this->db->from('evaluasi_amdk');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekPotensiAmdk()
    {
        $this->db->select('bagian_upk');
        $this->db->from('potensi_amdk');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekUsulanBarang()
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_barang');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekUsulanUmum()
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_umum');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekUsulanInvestasi()
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_investasi');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
    public function cekUsulanPemeliharaan()
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_pemeliharaan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function cekPermasalahan()
    {
        $this->db->select('bagian_upk');
        $this->db->from('permasalahan');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function cekEvaluasiProgram()
    {
        $this->db->select('bagian_upk');
        $this->db->from('evaluasi_program');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }
}
