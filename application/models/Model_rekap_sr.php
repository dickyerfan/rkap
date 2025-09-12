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

    public function getDataUpk($dataTahun)
    {
        $this->db->select('*');
        $this->db->from('potensi_sr');
        $this->db->where('tahun_rkap', $dataTahun);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalSRUpk()
    {
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->select_sum('jumlah_sr')->get('ket_potensi_sr');
        return $query->row()->jumlah_sr;
    }

    public function getBiayaUsulanBarang($tahun_rkap)
    {
        return $this->db->select_sum('biaya')
            ->where('tahun_rkap', $tahun_rkap)
            ->get('usulan_barang')
            ->row()
            ->biaya;
    }

    public function getBiayaUsulanPemeliharaan($tahun_rkap)
    {
        return $this->db->select_sum('biaya')
            ->where('tahun_rkap', $tahun_rkap)
            ->get('usulan_pemeliharaan')
            ->row()
            ->biaya;
    }

    public function getBiayaUsulanInvestasi($tahun_rkap)
    {
        return $this->db->select_sum('biaya')
            ->where('tahun_rkap', $tahun_rkap)
            ->get('usulan_investasi')
            ->row()
            ->biaya;
    }
    public function getBiayaUsulanUmum($tahun_rkap)
    {
        $result = $this->db->select_sum('(biaya * volume)', 'total_biaya')
            ->where('tahun_rkap', $tahun_rkap)
            ->get('usulan_umum')
            ->row();

        return $result && $result->total_biaya !== null ? $result->total_biaya : 0;
    }

    // pendapatan dan biaya amdk
    public function getPendAmdk($dataTahun)
    {
        return $this->db->where('tahun_rkap', $dataTahun)
            ->get('potensi_amdk')
            ->result();
    }


    public function getBiayaAmdk($dataTahun)
    {
        return $this->db->where('tahun_rkap', $dataTahun)
            ->get('biaya_amdk')
            ->result();
    }
}
