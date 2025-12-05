<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_status extends CI_Model
{
    public function get_status_periode($tahun, $bulan = null)
    {
        $this->db->where('tahun', $tahun);
        if ($bulan !== null) {
            $this->db->where('bulan', $bulan);
        }
        $query = $this->db->get('rkap_status_periode');

        if ($query->num_rows() > 0) {
            return $query->row()->status_periode;
        } else {
            // Jika belum ada data periode, otomatis buat baru dengan status default
            $this->db->insert('rkap_status_periode', [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'status_periode' => 'dibuka_pengguna'
            ]);
            return 'dibuka_pengguna';
        }
    }

    // Ubah status periode (hanya admin yang bisa)
    // public function update_status_periode($tahun, $status, $bulan = null)
    // {
    //     $data = [
    //         'status_periode' => $status,
    //         'updated_by' => $this->session->userdata('nama_lengkap'),
    //     ];

    //     $this->db->where('tahun', $tahun);
    //     if ($bulan !== null) {
    //         $this->db->where('bulan', $bulan);
    //     }

    //     if ($this->db->get('rkap_status_periode')->num_rows() > 0) {
    //         $this->db->update('rkap_status_periode', $data);
    //     } else {
    //         $data['tahun'] = $tahun;
    //         $data['bulan'] = $bulan;
    //         $this->db->insert('rkap_status_periode', $data);
    //     }
    // }

    public function update_status_periode($tahun, $status)
    {
        $data = [
            'tahun' => $tahun,
            'status_periode' => $status,
            'updated_by' => $this->session->userdata('nama_lengkap'),
        ];

        if ($this->db->get('rkap_status_periode')->num_rows() > 0) {
            $this->db->update('rkap_status_periode', $data);
        } else {
            // $data['tahun'] = $tahun;
            $this->db->insert('rkap_status_periode', $data);
        }
    }

    // Ambil semua data status untuk ditampilkan di admin panel
    public function get_all()
    {
        return $this->db->order_by('tahun', 'DESC')->get('rkap_status_periode')->result_array();
    }
}
