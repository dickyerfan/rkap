<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rekap_sr extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    // public function getRekapSR()
    // {
    //     $this->db->select('bagian_upk, SUM(jumlah_sr) as total_sr');
    //     $this->db->from('ket_potensi_sr');
    //     $this->db->group_by('bagian_upk');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getRekapSR($tahun)
    {
        $this->db->select('bagian_upk, SUM(jumlah_sr) as total_sr');
        $this->db->from('ket_potensi_sr');
        $this->db->where('tahun_rkap', $tahun);
        $this->db->group_by('bagian_upk');
        $query = $this->db->get();
        return $query->result();
    }
}
