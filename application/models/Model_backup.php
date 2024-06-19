<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_backup extends CI_Model
{
    public function droptabel()
    {
        $cek = $this->db->query("SHOW TABLES");
        if ($cek->num_rows() > 0) {
            $query = $this->db->query("DROP TABLE jadwal_kajian,kitab, mesjid, user, ustadz, waktu ");
            return $query;
        } else {
            return true;
        }
    }
}
