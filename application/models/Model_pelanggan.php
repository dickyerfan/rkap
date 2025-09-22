<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pelanggan extends CI_Model
{
    // public function getDataPelanggan($tahun, $upk = null)
    // {
    //     $this->db->select('jp.nama_jp, kd.nama_kd, rp.bulan, rp.jumlah');
    //     $this->db->from('rkap_pelanggan rp');
    //     $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = rp.id_jp');
    //     $this->db->join('rkap_kategori_data kd', 'kd.id_kd = rp.id_kd');
    //     $this->db->join('rkap_nama_upk upk', 'upk.id_upk = rp.id_upk');
    //     $this->db->where('rp.tahun', $tahun);
    //     if ($upk) {
    //         $this->db->where('upk.nama_upk', $upk);
    //     }
    //     $this->db->order_by('kd.id_kd, jp.id_jp, rp.bulan');
    //     return $this->db->get()->result_array();
    // }

    public function getDataPelanggan($tahun, $upk = null)
    {
        $this->db->select('jp.nama_jp, kd.nama_kd, rp.bulan');

        if ($upk) {
            // detail per UPK
            $this->db->select('rp.jumlah, upk.nama_upk');
        } else {
            // konsolidasi semua UPK
            $this->db->select('SUM(rp.jumlah) as jumlah');
        }

        $this->db->from('rkap_pelanggan rp');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = rp.id_jp');
        $this->db->join('rkap_kategori_data kd', 'kd.id_kd = rp.id_kd');
        $this->db->join('rkap_nama_upk upk', 'upk.id_upk = rp.id_upk');
        $this->db->where('rp.tahun', $tahun);

        if ($upk) {
            $this->db->where('rp.id_upk', $upk);
        }

        $this->db->group_by('jp.nama_jp, kd.nama_kd, rp.bulan');
        $this->db->order_by('kd.id_kd, jp.id_jp, rp.bulan');

        return $this->db->get()->result_array();
    }


    public function save_or_update($row)
    {
        $cek = $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $row['id_upk'],
            'id_jp'  => $row['id_jp'],
            'id_kd'  => $row['id_kd'],
            'tahun'  => $row['tahun'],
            'bulan'  => $row['bulan']
        ])->row_array();

        if ($cek) {
            $this->db->where('id_rkap', $cek['id_rkap'])->update('rkap_pelanggan', $row);
        } else {
            $this->db->insert('rkap_pelanggan', $row);
        }
    }

    // Ambil jumlah berdasarkan kategori
    public function get_jumlah($id_upk, $id_jp, $id_kd, $tahun, $bulan)
    {
        $row = $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'id_kd'  => $id_kd,
            'tahun'  => $tahun,
            'bulan'  => $bulan
        ])->row_array();

        return $row ? $row['jumlah'] : 0;
    }
}
