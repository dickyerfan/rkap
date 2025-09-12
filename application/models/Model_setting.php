<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_setting extends CI_Model
{
    // public function cekLock($tahun)
    // {
    //     $this->db->where('tahun', $tahun);
    //     $row = $this->db->get('setting_rkap')->row();
    //     return $row ? (bool)$row->is_locked : false;
    // }

    public function cekLock($tahun)
    {
        // cek apakah tahun sudah ada di tabel
        $this->db->where('tahun', $tahun);
        $row = $this->db->get('setting_rkap')->row();

        if ($row) {
            return (bool)$row->is_locked;
        } else {
            // kalau tahun belum ada, otomatis insert baris baru
            $data = [
                'tahun' => $tahun,
                'is_locked' => 0 // default tidak terkunci
            ];
            $this->db->insert('setting_rkap', $data);
            return false; // default belum terkunci
        }
    }


    public function setLock($tahun, $status)
    {
        $this->db->where('tahun', $tahun);
        if ($this->db->count_all_results('setting_rkap') > 0) {
            $this->db->where('tahun', $tahun);
            $this->db->update('setting_rkap', ['is_locked' => $status]);
        } else {
            $this->db->insert('setting_rkap', ['tahun' => $tahun, 'is_locked' => $status]);
        }
    }
}
