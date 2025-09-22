<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_data_pendukung extends CI_Model
{
    // Insert Data
    public function insert_tarif_rata($data)
    {
        return $this->db->insert('rkap_tarif_rata', $data);
    }

    public function insert_pola_konsumsi($data)
    {
        return $this->db->insert('rkap_pola_konsumsi', $data);
    }

    public function insert_jasa_tambahan($data)
    {
        return $this->db->insert('rkap_jasa_tambahan', $data);
    }

    // Cek apakah data sudah ada (untuk validasi unik per UPK, jenis pelanggan, tahun)
    public function check_tarif_rata_exists($id_upk, $id_jp, $tahun)
    {
        return $this->db->get_where('rkap_tarif_rata', [
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'tahun'  => $tahun
        ])->row();
    }

    public function check_pola_konsumsi_exists($id_upk, $id_jp, $tahun)
    {
        return $this->db->get_where('rkap_pola_konsumsi', [
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'tahun'  => $tahun
        ])->row();
    }

    public function check_jasa_tambahan_exists($id_upk, $id_jp, $tahun)
    {
        return $this->db->get_where('rkap_jasa_tambahan', [
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'tahun'  => $tahun
        ])->row();
    }

    public function get_tarif_rata()
    {
        $this->db->select('tr.*, upk.nama_upk, jp.nama_jp');
        $this->db->from('rkap_tarif_rata tr');
        $this->db->join('rkap_nama_upk upk', 'upk.id_upk = tr.id_upk');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = tr.id_jp');
        $this->db->order_by('id,tahun DESC, upk.nama_upk, jp.nama_jp');
        return $this->db->get()->result();
    }

    public function get_pola_konsumsi()
    {
        $this->db->select('pk.*, upk.nama_upk, jp.nama_jp');
        $this->db->from('rkap_pola_konsumsi pk');
        $this->db->join('rkap_nama_upk upk', 'upk.id_upk = pk.id_upk');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = pk.id_jp');
        $this->db->order_by('id, tahun DESC, upk.nama_upk, jp.nama_jp');
        return $this->db->get()->result();
    }

    public function get_jasa_tambahan()
    {
        $this->db->select('jt.*, upk.nama_upk, jp.nama_jp');
        $this->db->from('rkap_jasa_tambahan jt');
        $this->db->join('rkap_nama_upk upk', 'upk.id_upk = jt.id_upk');
        $this->db->join('rkap_jenis_plgn jp', 'jp.id_jp = jt.id_jp');
        $this->db->order_by('id, tahun DESC, upk.nama_upk, jp.nama_jp');
        return $this->db->get()->result();
    }
}
