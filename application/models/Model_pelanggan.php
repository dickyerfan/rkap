<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pelanggan extends CI_Model
{
    public function getDataPelanggan($tahun, $upk = null)
    {
        $this->db->select('jp.nama_jp, kd.nama_kd, rp.bulan, rp.jumlah');
        $this->db->from('rkap_pelanggan rp');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = rp.id_jp');
        $this->db->join('rkap_kategori_data kd', 'kd.id_kd = rp.id_kd');
        $this->db->join('rkap_nama_upk upk', 'upk.id_upk = rp.id_upk');
        $this->db->where('rp.tahun', $tahun);
        if ($upk) {
            $this->db->where('upk.nama_upk', $upk);
        }
        $this->db->order_by('kd.id_kd, jp.id_jp, rp.bulan');
        return $this->db->get()->result_array();
    }

    public function insert_rkap($data)
    {
        // cek apakah sudah ada datanya
        $cek = $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $data['id_upk'],
            'id_jp'  => $data['id_jp'],
            'id_kd'  => $data['id_kd'],
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan']
        ])->row();

        if ($cek) {
            // update jika sudah ada
            $this->db->where('id_rkap', $cek->id_rkap);
            $this->db->update('rkap_pelanggan', $data);
        } else {
            // insert baru
            $this->db->insert('rkap_pelanggan', $data);
        }
    }

    public function get_kategori()
    {
        return $this->db->order_by('id_kd', 'asc')
            ->where('nama_kd !=', 'Sambungan akhir')
            ->get('rkap_kategori_data')
            ->result_array();
    }

    public function get_jenis_pelanggan()
    {
        return $this->db->order_by('id_jp', 'asc')
            ->get('rkap_jenis_plgn')
            ->result_array();
    }

    public function get_upk()
    {
        return $this->db->order_by('id_upk', 'asc')
            ->get('rkap_nama_upk')
            ->result_array();
    }

    public function get_sambungan_akhir($id_upk, $id_jp, $tahun, $bulan)
    {
        return $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $id_upk,
            'id_jp' => $id_jp,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'id_kd' => 6
        ])->row();
    }

    public function insert_or_update($data)
    {
        $exist = $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $data['id_upk'],
            'id_jp'  => $data['id_jp'],
            'id_kd'  => $data['id_kd'],
            'tahun'  => $data['tahun'],
            'bulan'  => $data['bulan']
        ])->row();

        if ($exist) {
            $this->db->where('id_rkap', $exist->id_rkap);
            $this->db->update('rkap_pelanggan', $data);
        } else {
            $this->db->insert('rkap_pelanggan', $data);
        }
    }
}
