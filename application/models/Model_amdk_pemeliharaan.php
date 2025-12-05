<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_amdk_pemeliharaan extends CI_Model
{
    public function get_pemeliharaan($tahun)
    {
        $this->db->where('tahun_rkap', $tahun);
        $this->db->order_by('jenis', 'ASC');
        $this->db->order_by('kategori', 'ASC');
        $this->db->order_by('uraian', 'ASC');
        $query = $this->db->get('rkap_amdk_pemeliharaan');

        $result = $query->result_array();

        // Kelompokkan data ke dalam array bersarang
        $grouped = [];
        foreach ($result as $row) {
            $jenis = $row['jenis'];
            $kategori = $row['kategori'];

            if (!isset($grouped[$jenis])) {
                $grouped[$jenis] = [];
            }
            if (!isset($grouped[$jenis][$kategori])) {
                $grouped[$jenis][$kategori] = [];
            }
            $grouped[$jenis][$kategori][] = $row;
        }

        return $grouped;
    }


    public function insert_or_update($data)
    {
        // cek apakah sudah ada data bahan untuk produk & tahun ini
        // $this->db->where('id', $data['id']);
        $this->db->where('jenis', $data['jenis']);
        $this->db->where('kategori', $data['kategori']);
        $this->db->where('uraian', $data['uraian']);
        $this->db->where('tahun_rkap', $data['tahun_rkap']);
        $cek = $this->db->get('rkap_amdk_pemeliharaan')->row();

        if ($cek) {
            // update
            $this->db->where('id', $cek->id);
            return $this->db->update('rkap_amdk_pemeliharaan', $data);
        } else {
            // insert baru
            return $this->db->insert('rkap_amdk_pemeliharaan', $data);
        }
    }
}
