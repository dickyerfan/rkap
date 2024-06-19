<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_laporan extends CI_Model
{
    public function getAll()
    {
        if (isset($_POST['add_post'])) {
            $bulan = $this->input->post('bulan', true);
            $tahun = $this->input->post('tahun', true);
            if ($bulan < 10) {
                $bulan = str_split($bulan)[1];
            }
            return $this->db->query("SELECT * FROM keuangan WHERE month(tanggal)=$bulan AND year(tanggal)= $tahun  ORDER BY tanggal ASC")->result();
        } else {
            $bulan = date('m');
            $tahun = date('Y');
            return $this->db->query("SELECT * FROM keuangan WHERE month(tanggal)=$bulan AND year(tanggal)= $tahun  ORDER BY tanggal ASC")->result();
        }
    }
    public function getGet()
    {
        if (isset($_GET['add_post'])) {
            $bulan = $this->input->get('bulan', true);
            $tahun = $this->input->get('tahun', true);
            if ($bulan < 10) {
                $bulan = str_split($bulan)[1];
            }
            return $this->db->query("SELECT * FROM keuangan WHERE month(tanggal)=$bulan AND year(tanggal)= $tahun  ORDER BY tanggal ASC")->result();
        } else {
            $bulan = date('m');
            $tahun = date('Y');
            return $this->db->query("SELECT * FROM keuangan WHERE month(tanggal)=$bulan AND year(tanggal)= $tahun  ORDER BY tanggal ASC")->result();
        }
    }
}
