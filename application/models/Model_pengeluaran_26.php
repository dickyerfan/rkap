<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pengeluaran_26 extends CI_Model
{
    // pengeluaraan operasional
    public function get_pengeluaran_ops_sumber($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.cabang_id,
        r.id,
        r.no_per_id,

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
        $this->db->from('rkap_rekap_2026 r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter beberapa kode
        $this->db->group_start()
            ->like('n.kode', '91.01.01', 'after')
            ->or_like('n.kode', '91.01.11', 'after')
            ->or_like('n.kode', '91.01.12', 'after')
            ->or_like('n.kode', '91.01.13', 'after')
            ->or_like('n.kode', '91.01.14', 'after')
            ->or_like('n.kode', '91.01.21', 'after')
            ->or_like('n.kode', '91.01.22', 'after')
            ->or_like('n.kode', '91.01.23', 'after')
            ->or_like('n.kode', '91.01.31', 'after')
            ->or_like('n.kode', '91.01.32', 'after')
            ->or_like('n.kode', '91.01.41', 'after')
            ->or_like('n.kode', '91.01.42', 'after')
            ->or_like('n.kode', '91.02.10', 'after')
            ->or_like('n.kode', '91.02.20', 'after')
            ->or_like('n.kode', '91.02.30', 'after')
            ->or_like('n.kode', '91.02.90', 'after')
            ->or_like('n.kode', '91.03.10', 'after')
            ->or_like('n.kode', '91.03.20', 'after')
            ->or_like('n.kode', '91.03.30', 'after')
            ->or_like('n.kode', '91.03.40', 'after')
            ->or_like('n.kode', '91.03.50', 'after')
            ->or_like('n.kode', '91.03.60', 'after')
            ->or_like('n.kode', '91.03.70', 'after')
            ->or_like('n.kode', '91.03.80', 'after')
            ->or_like('n.kode', '91.03.90', 'after')
            ->or_like('n.kode', '91.04.10', 'after')
            ->group_end();

        $this->db->group_by('r.no_per_id');
        $this->db->group_by('n.name');
        $this->db->order_by('n.kode', 'ASC');

        return $this->db->get()->result_array();
    }
    public function get_pengeluaran_ops_pengolahan($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.cabang_id,
        r.id,
        r.no_per_id,

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
        $this->db->from('rkap_rekap_2026 r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter beberapa kode
        $this->db->group_start()
            ->like('n.kode', '92.01.11', 'after')
            ->or_like('n.kode', '92.01.12', 'after')
            ->or_like('n.kode', '92.01.13', 'after')
            ->or_like('n.kode', '92.01.14', 'after')
            ->or_like('n.kode', '92.01.21', 'after')
            ->or_like('n.kode', '92.01.22', 'after')
            ->or_like('n.kode', '92.01.23', 'after')
            ->or_like('n.kode', '92.01.31', 'after')
            ->or_like('n.kode', '92.01.32', 'after')
            ->or_like('n.kode', '92.01.41', 'after')
            ->or_like('n.kode', '92.01.42', 'after')
            ->or_like('n.kode', '92.02.10', 'after')
            ->or_like('n.kode', '92.02.20', 'after')
            ->or_like('n.kode', '92.02.30', 'after')
            ->or_like('n.kode', '92.02.40', 'after')
            ->or_like('n.kode', '92.02.90', 'after')
            ->or_like('n.kode', '92.03.10', 'after')
            ->or_like('n.kode', '92.03.20', 'after')
            ->or_like('n.kode', '92.03.30', 'after')
            ->or_like('n.kode', '92.03.90', 'after')
            ->group_end();

        $this->db->group_by('r.no_per_id');
        $this->db->group_by('n.name');
        $this->db->order_by('n.kode', 'ASC');

        return $this->db->get()->result_array();
    }
    public function get_pengeluaran_ops_trandis($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.cabang_id,
        r.id,
        r.no_per_id,

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
        $this->db->from('rkap_rekap_2026 r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter beberapa kode
        $this->db->group_start()
            ->like('n.kode', '93.01.11', 'after')
            ->or_like('n.kode', '93.01.12', 'after')
            ->or_like('n.kode', '93.01.13', 'after')
            ->or_like('n.kode', '93.01.14', 'after')
            ->or_like('n.kode', '93.01.21', 'after')
            ->or_like('n.kode', '93.01.22', 'after')
            ->or_like('n.kode', '93.01.23', 'after')
            ->or_like('n.kode', '93.01.30', 'after')
            ->or_like('n.kode', '93.01.31', 'after')
            ->or_like('n.kode', '93.01.32', 'after')
            ->or_like('n.kode', '93.01.41', 'after')
            ->or_like('n.kode', '93.01.42', 'after')
            ->or_like('n.kode', '93.02.10', 'after')
            ->or_like('n.kode', '93.02.20', 'after')
            ->or_like('n.kode', '93.02.30', 'after')
            ->or_like('n.kode', '93.02.40', 'after')
            ->or_like('n.kode', '93.02.90', 'after')
            ->or_like('n.kode', '93.03.10', 'after')
            ->or_like('n.kode', '93.03.20', 'after')
            ->or_like('n.kode', '93.03.30', 'after')
            ->or_like('n.kode', '93.03.40', 'after')
            ->or_like('n.kode', '93.03.50', 'after')
            ->or_like('n.kode', '93.03.60', 'after')
            ->or_like('n.kode', '93.03.70', 'after')
            ->or_like('n.kode', '93.03.90', 'after')
            ->group_end();

        $this->db->group_by('r.no_per_id');
        $this->db->group_by('n.name');
        $this->db->order_by('n.kode', 'ASC');

        return $this->db->get()->result_array();
    }
    public function get_pengeluaran_ops_umum($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.cabang_id,
        r.id,
        r.no_per_id,

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
        $this->db->from('rkap_rekap_2026 r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter beberapa kode
        $this->db->group_start()
            ->like('n.kode', '96.01.01', 'after')
            ->or_like('n.kode', '96.01.02', 'after')
            ->or_like('n.kode', '96.01.03', 'after')
            ->or_like('n.kode', '96.01.04', 'after')
            ->or_like('n.kode', '96.01.05', 'after')
            ->or_like('n.kode', '96.01.06', 'after')
            ->or_like('n.kode', '96.01.07', 'after')
            ->or_like('n.kode', '96.01.08', 'after')
            ->or_like('n.kode', '96.01.09', 'after')
            ->or_like('n.kode', '96.01.10', 'after')
            ->or_like('n.kode', '96.02.01', 'after')
            ->or_like('n.kode', '96.02.02', 'after')
            ->or_like('n.kode', '96.02.03', 'after')
            ->or_like('n.kode', '96.02.04', 'after')
            ->or_like('n.kode', '96.02.05', 'after')
            ->or_like('n.kode', '96.02.06', 'after')
            ->or_like('n.kode', '96.02.07', 'after')
            ->or_like('n.kode', '96.02.08', 'after')
            ->or_like('n.kode', '96.02.09', 'after')
            ->or_like('n.kode', '96.02.10', 'after')
            ->or_like('n.kode', '96.03.01', 'after')
            ->or_like('n.kode', '96.03.02', 'after')
            ->or_like('n.kode', '96.03.03', 'after')
            ->or_like('n.kode', '96.03.04', 'after')
            ->or_like('n.kode', '96.03.05', 'after')
            ->or_like('n.kode', '96.03.06', 'after')
            ->or_like('n.kode', '96.03.07', 'after')
            ->or_like('n.kode', '96.03.09', 'after')
            ->or_like('n.kode', '96.04.01', 'after')
            ->or_like('n.kode', '96.04.02', 'after')
            ->or_like('n.kode', '96.04.03', 'after')
            ->or_like('n.kode', '96.04.04', 'after')
            ->or_like('n.kode', '96.04.09', 'after')
            ->or_like('n.kode', '96.05.01', 'after')
            ->or_like('n.kode', '96.05.02', 'after')
            ->or_like('n.kode', '96.05.03', 'after')
            ->or_like('n.kode', '96.05.09', 'after')
            ->or_like('n.kode', '96.06.01', 'after')
            ->or_like('n.kode', '96.06.02', 'after')
            ->or_like('n.kode', '96.06.03', 'after')
            ->or_like('n.kode', '96.06.04', 'after')
            ->or_like('n.kode', '96.06.05', 'after')
            ->or_like('n.kode', '96.06.06', 'after')
            ->or_like('n.kode', '96.06.07', 'after')
            ->or_like('n.kode', '96.08.01', 'after')
            ->or_like('n.kode', '96.08.02', 'after')
            ->or_like('n.kode', '96.08.03', 'after')
            ->or_like('n.kode', '96.08.04', 'after')
            ->or_like('n.kode', '96.08.05', 'after')
            ->or_like('n.kode', '96.08.06', 'after')
            ->or_like('n.kode', '96.08.07', 'after')
            ->or_like('n.kode', '96.08.08', 'after')
            ->or_like('n.kode', '96.08.09', 'after')
            ->or_like('n.kode', '96.08.04', 'after')
            ->or_like('n.kode', '96.08.10', 'after')
            ->or_like('n.kode', '96.08.11', 'after')
            ->or_like('n.kode', '96.08.12', 'after')
            ->or_like('n.kode', '96.08.13', 'after')
            ->or_like('n.kode', '96.08.14', 'after')
            ->group_end();




        $this->db->group_by('r.no_per_id');
        $this->db->group_by('n.name');
        $this->db->order_by('n.kode', 'ASC');

        return $this->db->get()->result_array();
    }

    // pengeluaran non ops
    public function get_pengeluaran_no($tahun)
    {
        $this->db->select("
        n.kode,
        n.name,
        r.cabang_id,
        r.id,
        r.no_per_id,

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
        $this->db->from('rkap_rekap_2026 r');
        $this->db->join('no_per n', 'n.kode = r.no_per_id', 'left');
        $this->db->where('YEAR(r.bulan)', $tahun);

        // Filter beberapa kode
        $this->db->group_start()
            ->like('n.kode', '98.01.01', 'after')
            ->or_like('n.kode', '98.02.01', 'after')
            ->or_like('n.kode', '98.02.02', 'after')
            ->or_like('n.kode', '98.02.03', 'after')
            ->or_like('n.kode', '98.02.04', 'after')
            ->or_like('n.kode', '98.02.05', 'after')
            ->or_like('n.kode', '98.02.07', 'after')
            ->or_like('n.kode', '98.02.08', 'after')
            ->or_like('n.kode', '98.02.09', 'after')
            ->or_like('n.kode', '98.02.12', 'after')
            ->or_like('n.kode', '98.02.13', 'after')
            ->or_like('n.kode', '98.02.14', 'after')
            ->or_like('n.kode', '50.05.03', 'after')
            ->or_like('n.kode', '50.05.04', 'after')
            ->or_like('n.kode', '50.01', 'after')
            ->or_like('n.kode', '62.03.03', 'after')
            ->group_end();

        $this->db->group_by('r.no_per_id');
        $this->db->group_by('n.name');
        $this->db->order_by('n.kode', 'ASC');

        return $this->db->get()->result_array();
    }


    public function insert_or_update($data)
    {
        $insert_count = 0;
        $update_count = 0;

        foreach ($data as $row) {
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            // $this->db->where('uraian', $row['uraian']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_rekap_2026')->row();

            if ($cek) {
                // Tambahkan nama petugas update
                // $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

                // Update data yang sudah ada
                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                // $this->db->where('uraian', $cek->uraian);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_rekap_2026', $row);

                $update_count++;
            } else {
                // Insert data baru
                $this->db->insert('rkap_rekap_2026', $row);
                $insert_count++;
            }
        }

        // Kembalikan jumlah hasil untuk ditampilkan di controller
        return [
            'inserted' => $insert_count,
            'updated'  => $update_count
        ];
    }
    // public function insert_or_update($data)
    // {
    //     $insert_count = 0;
    //     $update_count = 0;

    //     foreach ($data as $row) {
    //         $this->db->where('cabang_id', $row['cabang_id']);
    //         $this->db->where('no_per_id', $row['no_per_id']);
    //         $this->db->where('uraian', $row['uraian']);
    //         $this->db->where('bulan', $row['bulan']);
    //         $cek = $this->db->get('rkap_biaya')->row();

    //         if ($cek) {
    //             // Tambahkan nama petugas update
    //             $row['ptgs_update'] = $this->session->userdata('nama_lengkap');

    //             // Update data yang sudah ada
    //             $this->db->where('cabang_id', $cek->cabang_id);
    //             $this->db->where('no_per_id', $cek->no_per_id);
    //             $this->db->where('uraian', $cek->uraian);
    //             $this->db->where('bulan', $cek->bulan);
    //             $this->db->update('rkap_biaya', $row);

    //             $update_count++;
    //         } else {
    //             // Insert data baru
    //             $this->db->insert('rkap_biaya', $row);
    //             $insert_count++;
    //         }
    //     }

    //     // Kembalikan jumlah hasil untuk ditampilkan di controller
    //     return [
    //         'inserted' => $insert_count,
    //         'updated'  => $update_count
    //     ];
    // }
}
