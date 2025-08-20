<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rekap_sr extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    // public function getRekapSR($tahun)
    // {
    //     $this->db->select('bagian_upk, SUM(jumlah_sr) as total_sr');
    //     $this->db->from('ket_potensi_sr');
    //     $this->db->where('tahun_rkap', $tahun);
    //     $this->db->group_by('bagian_upk');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getRekapSR($tahun)
    {
        $sql = "
        SELECT
            u.upk_bagian AS bagian_upk,
            COALESCE(k.total_sr, 0)  AS total_sr,
            COALESCE(p.asumsi_sr, 0) AS asumsi_sr
        FROM user u
        LEFT JOIN (
            SELECT bagian_upk, SUM(jumlah_sr) AS total_sr
            FROM ket_potensi_sr
            WHERE tahun_rkap = ?
            GROUP BY bagian_upk
        ) k ON k.bagian_upk = u.upk_bagian
        LEFT JOIN (
            SELECT bagian_upk, SUM(tambah_sr) AS asumsi_sr
            FROM potensi_sr
            WHERE tahun_rkap = ?
            GROUP BY bagian_upk
        ) p ON p.bagian_upk = u.upk_bagian
        WHERE u.tipe = 'upk'
        ORDER BY u.id ASC
    ";
        return $this->db->query($sql, [$tahun, $tahun])->result();
    }
}
