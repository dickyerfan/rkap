<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_user extends CI_Model
{
    public function getAll()
    {
        // $this->db->where('level', 'Admin');
        return $this->db->get('user')->result();
    }
    public function getAllUser()
    {
        $this->db->where('level', 'Pengguna');
        return $this->db->get('user')->result();
    }

    public function getKaryawan()
    {
        $this->db->select('nama, nik');
        $this->db->from('karyawan');
        $this->db->where('aktif', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData()
    {
        $data = [
            'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'upk_bagian' => $this->input->post('upk_bagian', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'level' => $this->input->post('level', true),
            'tipe' => $this->input->post('tipe', true),
        ];
        $this->db->insert('user', $data);
    }

    public function hapusData($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function getIdAdmin($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row();
    }

    public function updateData()
    {

        $data = [
            // 'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'upk_bagian' => $this->input->post('upk_bagian', true),
            'level' => $this->input->post('level', true),
            'tipe' => $this->input->post('tipe', true),
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user', $data);
    }
}
