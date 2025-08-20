<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pengaturan extends CI_Model
{
    public function matikanUploadData()
    {
        $data = [
            'status' => $this->input->post('status', true),
        ];
        $this->db->update('potensi_sr', $data);
        $this->db->update('ket_potensi_sr', $data);
        $this->db->update('tambah_air_baku', $data);
        $this->db->update('evaluasi_upk', $data);
        $this->db->update('evaluasi_amdk', $data);
        $this->db->update('potensi_amdk', $data);
        $this->db->update('target_pencapaian', $data);
        $this->db->update('usulan_admin', $data);
        $this->db->update('usulan_teknik', $data);
        $this->db->update('usulan_umum', $data);
        $this->db->update('usulan_barang', $data);
        $this->db->update('usulan_investasi', $data);
        $this->db->update('usulan_pemeliharaan', $data);
        $this->db->update('permasalahan', $data);
    }

    public function matikanUpdateData()
    {
        $data = [
            'status_update' => $this->input->post('status_update', true),
        ];
        $this->db->update('potensi_sr', $data);
        $this->db->update('ket_potensi_sr', $data);
        $this->db->update('tambah_air_baku', $data);
        $this->db->update('evaluasi_upk', $data);
        $this->db->update('evaluasi_amdk', $data);
        $this->db->update('potensi_amdk', $data);
        $this->db->update('target_pencapaian', $data);
        $this->db->update('usulan_admin', $data);
        $this->db->update('usulan_barang', $data);
        $this->db->update('usulan_teknik', $data);
        $this->db->update('usulan_umum', $data);
        $this->db->update('usulan_investasi', $data);
        $this->db->update('usulan_pemeliharaan', $data);
        $this->db->update('permasalahan', $data);
    }

    public function cekUpload()
    {
        $this->db->select('status');
        $this->db->from('potensi_sr');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function cekUpdate()
    {
        $this->db->select('status_update');
        $this->db->from('potensi_sr');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->row();
    }

    public function cekStatusPengguna()
    {
        $this->db->select('status');
        $this->db->from('user');
        $this->db->where_in('tipe', ['upk', 'bagian']);
        $query = $this->db->get();
        return $query->row();
    }

    public function penggunaOff()
    {
        $data = [
            'status' => $this->input->post('status', true),
        ];

        $this->db->where_in('tipe', ['upk', 'bagian']);
        $this->db->update('user', $data);
    }

    public function cekStatusPengisi()
    {
        $this->db->select('status');
        $this->db->from('user');
        $this->db->where('level', 'Pengguna');
        $query = $this->db->get();
        return $query->row();
    }

    public function pengisiOff()
    {
        $data = [
            'status' => $this->input->post('status', true),
        ];

        $this->db->where('level', 'Pengguna');
        $this->db->update('user', $data);
    }

    public function cekNamaUpk()
    {
        $this->db->select('upk_bagian');
        $this->db->from('user');
        $this->db->where('tipe', 'upk');
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
        $this->db->select('bagian_upk');
        $this->db->from('evaluasi_upk');
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
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

    public function cekNamaBagian()
    {
        $this->db->select('upk_bagian');
        $this->db->from('user');
        $this->db->where('tipe', 'bagian');
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
