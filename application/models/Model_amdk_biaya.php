<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_amdk_biaya extends CI_Model
{

    public function get_biaya($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.uraian,
        SUM(CASE WHEN MONTH(r.bulan) = 1 THEN r.pagu ELSE 0 END) AS jan,
        SUM(CASE WHEN MONTH(r.bulan) = 2 THEN r.pagu ELSE 0 END) AS feb,
        SUM(CASE WHEN MONTH(r.bulan) = 3 THEN r.pagu ELSE 0 END) AS mar,
        SUM(CASE WHEN MONTH(r.bulan) = 4 THEN r.pagu ELSE 0 END) AS apr,
        SUM(CASE WHEN MONTH(r.bulan) = 5 THEN r.pagu ELSE 0 END) AS mei,
        SUM(CASE WHEN MONTH(r.bulan) = 6 THEN r.pagu ELSE 0 END) AS jun,
        SUM(CASE WHEN MONTH(r.bulan) = 7 THEN r.pagu ELSE 0 END) AS jul,
        SUM(CASE WHEN MONTH(r.bulan) = 8 THEN r.pagu ELSE 0 END) AS agu,
        SUM(CASE WHEN MONTH(r.bulan) = 9 THEN r.pagu ELSE 0 END) AS sep,
        SUM(CASE WHEN MONTH(r.bulan) = 10 THEN r.pagu ELSE 0 END) AS okt,
        SUM(CASE WHEN MONTH(r.bulan) = 11 THEN r.pagu ELSE 0 END) AS nov,
        SUM(CASE WHEN MONTH(r.bulan) = 12 THEN r.pagu ELSE 0 END) AS des,
        SUM(r.pagu) AS total_tahun
    ");
        $this->db->from('rkap_amdk_biaya r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);
        $this->db->where('r.cabang_id', 13);
        $this->db->like('n.kode', '98.02', 'after');
        $this->db->group_by('r.no_per_id');
        $this->db->group_by('r.uraian');
        $this->db->order_by('n.kode', 'ASC');
        return $this->db->get()->result_array();
    }

    // public function insert_or_update($data)
    // {
    //     foreach ($data as $row) {
    //         $this->db->where('cabang_id', $row['cabang_id']);
    //         $this->db->where('no_per_id', $row['no_per_id']);
    //         $this->db->where('uraian', $row['uraian']);
    //         $this->db->where('bulan', $row['bulan']);
    //         $cek = $this->db->get('rkap_amdk_biaya')->row();

    //         if ($cek) {
    //             $this->db->where('cabang_id', $cek->cabang_id);
    //             $this->db->where('no_per_id', $cek->no_per_id);
    //             $this->db->where('uraian', $cek->uraian);
    //             $this->db->where('bulan', $cek->bulan);
    //             $this->db->update('rkap_amdk_biaya', $row);
    //         } else {
    //             $this->db->insert('rkap_amdk_biaya', $row);
    //         }
    //     }
    // }

    public function insert_or_update($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_amdk_biaya')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_amdk_biaya', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_amdk_biaya', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }
}
