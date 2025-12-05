<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_bahan_baku extends CI_Model
{
    public function get_bahan_baku($tahun)
    {
        $this->db->select('
        p.id_produk,
        p.nama_produk,
        b.id_bahan,
        b.nama_bahan,
        b.volume,
        b.harga_satuan,
        b.total_tahun,
        COALESCE(SUM(pr.jumlah_produksi), 0) AS jumlah_produksi
    ');
        $this->db->from('rkap_amdk_bahan b');
        $this->db->join('rkap_amdk_produk p', 'p.id_produk = b.id_produk');
        $this->db->join('rkap_amdk_produksi pr', 'pr.id_produk = p.id_produk AND pr.tahun_rkap = b.tahun_rkap', 'left');
        $this->db->where('b.tahun_rkap', $tahun);
        $this->db->group_by('b.id_bahan');
        $this->db->order_by('p.nama_produk, b.id_bahan', 'ASC');
        return $this->db->get()->result_array();
    }

    public function insert_or_update_bahan($data)
    {
        // cek apakah sudah ada data bahan untuk produk & tahun ini
        $this->db->where('id_produk', $data['id_produk']);
        $this->db->where('nama_bahan', $data['nama_bahan']);
        $this->db->where('tahun_rkap', $data['tahun_rkap']);
        $cek = $this->db->get('rkap_amdk_bahan')->row();

        if ($cek) {
            // update
            $this->db->where('id_bahan', $cek->id_bahan);
            return $this->db->update('rkap_amdk_bahan', $data);
        } else {
            // insert baru
            return $this->db->insert('rkap_amdk_bahan', $data);
        }
    }
    public function insert_or_update_perlengkapan($data)
    {
        // cek apakah sudah ada data bahan untuk produk & tahun ini
        $this->db->where('id_produk', $data['id_produk']);
        $this->db->where('nama_bahan', $data['nama_bahan']);
        $this->db->where('tahun_rkap', $data['tahun_rkap']);
        $cek = $this->db->get('rkap_amdk_bahan')->row();

        if ($cek) {
            // update
            $this->db->where('id_bahan', $cek->id_bahan);
            return $this->db->update('rkap_amdk_bahan', $data);
        } else {
            // insert baru
            return $this->db->insert('rkap_amdk_bahan', $data);
        }
    }
}
