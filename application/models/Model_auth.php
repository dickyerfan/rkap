<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_auth extends CI_Model
{

    public function registrasi()
    {
        $data = [
            'nama_pengguna' => $this->input->post('nama_pengguna', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'upk_bagian' => $this->input->post('upk_bagian', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'level' => $this->input->post('level', true),
        ];

        return $this->db->insert('user', $data);
    }
}
