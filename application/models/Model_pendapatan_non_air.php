<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pendapatan_non_air extends CI_Model
{
    public function getJumlahByKd($id_upk, $tahun, $bulan, $id_kd)
    {
        $this->db->select_sum('jumlah');
        $this->db->from('rkap_pelanggan');
        $this->db->where([
            'id_upk' => $id_upk,
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'id_kd'  => $id_kd
        ]);
        $query = $this->db->get()->row();
        return $query ? (int) $query->jumlah : 0;
    }

    // Simpan atau update pendapatan non air
    // public function savePendapatan($id_upk, $tahun, $bulan, $jenis_pendapatan, $jumlah, $nilai)
    // {
    //     $kode_perkiraan = $this->getNoPerId($id_upk, $jenis_pendapatan);

    //     $data = [
    //         'id_upk'           => $id_upk,
    //         'tahun'            => $tahun,
    //         'bulan'            => $bulan,
    //         'jenis_pendapatan' => $jenis_pendapatan,
    //         'jumlah'           => $jumlah,
    //         'nilai'            => $nilai,
    //         'no_per_id'        => $kode_perkiraan
    //     ];
    //     // cek apakah data sudah ada
    //     $this->db->where('id_upk', $id_upk);
    //     $this->db->where('tahun', $tahun);
    //     $this->db->where('bulan', $bulan);
    //     $this->db->where('jenis_pendapatan', $jenis_pendapatan);

    //     $cek = $this->db->get('rkap_pendapatan_na')->row();

    //     if ($cek) {
    //         // update
    //         $this->db->where('id', $cek->id);
    //         $this->db->update('rkap_pendapatan_na', $data);
    //     } else {
    //         // insert
    //         $this->db->insert('rkap_pendapatan_na', $data);
    //     }
    // }

    public function savePendapatan($id_upk, $tahun, $bulan, $jenis_pendapatan, $jumlah, $nilai)
    {
        $kode_perkiraan = $this->getNoPerId($id_upk, $jenis_pendapatan);

        // Data untuk rkap_pendapatan_na
        $data = [
            'id_upk'           => $id_upk,
            'tahun'            => $tahun,
            'bulan'            => $bulan,
            'jenis_pendapatan' => $jenis_pendapatan,
            'jumlah'           => $jumlah,
            'nilai'            => $nilai,
            'no_per_id'        => $kode_perkiraan
        ];

        // cek apakah data sudah ada di rkap_pendapatan_na
        $this->db->where([
            'id_upk' => $id_upk,
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'jenis_pendapatan' => $jenis_pendapatan
        ]);
        $cek = $this->db->get('rkap_pendapatan_na')->row();

        if ($cek) {
            $this->db->where('id', $cek->id);
            $this->db->update('rkap_pendapatan_na', $data);
        } else {
            $this->db->insert('rkap_pendapatan_na', $data);
        }

        // ======================
        // Insert / Update ke rkap_rekap
        // ======================
        // ambil cabang_id dari tabel rkap_nama_upk
        $upk = $this->db->select('kode')
            ->from('rkap_nama_upk')
            ->where('id_upk', $id_upk)
            ->get()
            ->row();

        $cabang_id = $upk ? $upk->kode : null;

        $data_rekap = [
            'id_upk'    => $id_upk,
            'cabang_id' => $cabang_id,
            'no_per_id' => $kode_perkiraan,
            'bulan'     => date('Y-m-d', strtotime("$tahun-$bulan-01")),
            'pagu'      => $nilai
        ];

        // cek apakah sudah ada di rkap_rekap
        $this->db->where([
            'id_upk'    => $id_upk,
            'no_per_id' => $kode_perkiraan,
            'bulan'     => date('Y-m-d', strtotime("$tahun-$bulan-01"))
        ]);
        $cek_rekap = $this->db->get('rkap_rekap')->row();

        if ($cek_rekap) {
            $this->db->where('id', $cek_rekap->id);
            $this->db->update('rkap_rekap', $data_rekap);
        } else {
            $this->db->insert('rkap_rekap', $data_rekap);
        }
    }

    public function getPendapatanByUpk($id_upk = null, $tahun = null)
    {
        if ($id_upk) {
            $this->db->where('id_upk', $id_upk);
            if ($tahun) {
                $this->db->where('tahun', $tahun);   // ← Tambahkan ini
            }
        } else { // Jika id_upk NULL (mode konsolidasi)
            if ($tahun) {
                $this->db->where('tahun', $tahun);
            }
        }

        return $this->db->get('rkap_pendapatan_na')->result();
    }


    public function getNoPerId($id_upk, $jenis_pendapatan)
    {
        // mapping urutan UPK ke suffix kode
        $map_upk = [
            1 => '01', // Bondowoso
            2 => '02', // Sukosari 1
            3 => '03', // Maesan
            4 => '04', // Tegalampel
            5 => '05', // Tapen
            6 => '06', // Prajekan
            7 => '07', // Tlogosari
            8 => '08', // Wringin
            9 => '09', // Curahdami
            10 => '10', // Tamanan
            11 => '11', // Tenggarang
            12 => '12', // Tamankrocok
            13 => '13', // Wonosari
            14 => '14', // Klabang
            15 => '15', // Sukosari 2
        ];

        $map_pendapatan = [
            'Pendapatan Sambungan Baru'      => '81.02.01',
            'Pendapatan Pendaftaran'         => '81.02.02',
            'Pendapatan Balik Nama'          => '81.02.03',
            'Pendapatan Penyambungan Kembali' => '81.02.04',
            'Pendapatan Denda'               => '81.02.05',
            'Pendapatan Ganti Meter Rusak'   => '81.02.06',
            'Pendapatan Penggatian Pipa Persil' => '81.02.07',
            'Pendapatan Non Air Lainnya'     => '81.02.09'
        ];

        if (!isset($map_upk[$id_upk]) || !isset($map_pendapatan[$jenis_pendapatan])) {
            return null;
        }

        $kode = $map_pendapatan[$jenis_pendapatan] . '.' . $map_upk[$id_upk];

        return $kode;
    }
}
