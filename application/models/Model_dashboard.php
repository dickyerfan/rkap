<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{
    public function getAllMesjid()
    {
        return $this->db->get_where('mesjid', ['aktif' => 1])->result();
    }

    public function getDetail($id)
    {
        return $this->db->get_where('mesjid', ['id_mesjid' => $id])->row();
    }

    public function getAllDetail()
    {
        $id = $this->uri->segment(3);
        $this->db->select('*');
        $this->db->from('jadwal_kajian');
        $this->db->join('ustadz', 'ustadz.id_ustadz = jadwal_kajian.id_ustadz');
        $this->db->join('kitab', 'kitab.id_kitab = jadwal_kajian.id_kitab');
        $this->db->join('waktu', 'waktu.id_waktu = jadwal_kajian.id_waktu');
        $this->db->join('mesjid', 'mesjid.id_mesjid = jadwal_kajian.id_mesjid');
        $this->db->where('jadwal_kajian.id_mesjid', $id);
        $this->db->where('jadwal_kajian.status_aktif', 1);
        $this->db->order_by('hari_kajian', 'ASC');
        return $this->db->get()->result();
    }

    public function tambahData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            "nama" => $this->input->post('nama', true),
            "email" => $this->input->post('email', true),
            "tanggal" => date("Y-m-d H:i:s"),
            "komentar" => $this->input->post('komentar', true),
        ];

        $this->db->insert('komentar', $data);
    }

    public function getKomentar()
    {
        return $this->db->get('komentar')->result();
    }
}
