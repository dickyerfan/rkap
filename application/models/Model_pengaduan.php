<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pengaduan extends CI_Model
{
    public function getPengaduan()
    {
        return $this->db->get('pengaduan')->result();
    }
}
