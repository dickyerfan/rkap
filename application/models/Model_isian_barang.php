<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_isian_barang extends CI_Model
{

    public function getFiltered($upk_bagian = null, $tahun = null, $kategori = null)
    {
        $this->db->from('usulan_barang');
        if ($upk_bagian) {
            $this->db->where('bagian_upk', $upk_bagian);
        }
        if ($tahun) {
            $this->db->where('tahun_rkap', $tahun);
        } else {
            $this->db->where('tahun_rkap', date('Y'));
        }
        if ($kategori) {
            $this->db->where('kategori', $kategori);
        }
        return $this->db->get()->result();
    }

    public function getListUpkBagian()
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_barang');
        $this->db->group_by('bagian_upk');
        $query = $this->db->get();
        $result = $query->result();
        $list = [];
        foreach ($result as $row) {
            $list[] = $row->bagian_upk;
        }
        return $list;
    }

    public function getData()
    {
        $this->db->select('*');
        $this->db->from('usulan_barang');
        // $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $query = $this->db->get();
        return $query->result();
    }

    public function getIsianBarang($id_usulanBarang)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_barang', ['id_usulanBarang' => $id_usulanBarang])
            ->row();
    }

    public function updateData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'biaya' => (int) $this->input->post('biaya', true),
            'volume' => (int) $this->input->post('volume', true),
            'satuan' => $this->input->post('satuan', true),
            'kategori' => $this->input->post('kategori', true),
            // 'tgl_update' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_usulanBarang', $this->input->post('id_usulanBarang'));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_barang', $data);
    }
}
