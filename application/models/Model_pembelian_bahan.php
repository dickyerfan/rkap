<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pembelian_bahan extends CI_Model
{

    // public function getRekapPembelianBahan($tahun)
    // {
    //     $this->db->select('b.id_barang, b.no_per_id, b.nama_barang, b.pembagi, b.satuan, beli.bulan, beli.volume, beli.harga, beli.nilai');
    //     $this->db->from('rkap_barang AS b');
    //     $this->db->join('rkap_barang_beli AS beli', 'b.id_barang = beli.id_barang AND YEAR(beli.bulan) = ' . $tahun, 'left');
    //     $this->db->where('b.tahun', $tahun);
    //     $this->db->order_by('b.id_barang', 'ASC');

    //     $query = $this->db->get()->result();

    //     // Susun data per barang dan per bulan
    //     $data = [];
    //     foreach ($query as $row) {
    //         $id = $row->id_barang;

    //         if (!isset($data[$id])) {
    //             $data[$id] = [
    //                 'id_barang'   => $row->id_barang,
    //                 'no_per_id'   => $row->no_per_id,
    //                 'nama_barang' => $row->nama_barang,
    //                 'volume'      => $row->volume, // ambil dari bulan pertama
    //                 'harga'       => $row->harga,  // ambil dari bulan pertama
    //                 'satuan'      => $row->satuan,
    //                 'bulanData'   => array_fill(1, 12, 0), // default semua 0
    //                 'jumlah'      => 0
    //             ];
    //         }

    //         $month = (int)date('m', strtotime($row->bulan));
    //         $data[$id]['bulanData'][$month] = $row->nilai;
    //         $data[$id]['jumlah'] += $row->nilai;
    //     }

    //     return array_values($data); // agar index numerik
    // }

    public function getRekapPembelianBahanOtomatis($tahun)
    {
        // 1) Ambil total SR baru dari rkap_pelanggan
        $this->db->select_sum('jumlah');
        $this->db->where('id_kd', 2); // kode SR baru
        $this->db->where('tahun', $tahun);
        $sr = $this->db->get('rkap_pelanggan')->row();
        $total_sr = $sr->jumlah ?? 0;

        // 2) Ambil semua barang RKAP tahun tertentu
        $this->db->where('tahun', $tahun);
        $barang = $this->db->get('rkap_barang')->result();

        $data = [];
        foreach ($barang as $b) {
            $bulanData = [];
            $jumlah = 0;

            // Volume barang = total SR baru * pembagi
            $volume = $total_sr * $b->pembagi;

            // Harga barang dari kolom rkap_barang (pastikan ada kolom 'harga')
            $harga = $b->harga ?? 0;

            // Hitung nilai per bulan = (volume * harga) / 12
            for ($m = 1; $m <= 12; $m++) {
                $nilai = ($volume * $harga) / 12;
                $bulanData[$m] = $nilai;
                $jumlah += $nilai;
            }

            $data[] = [
                'id_barang'   => $b->id_barang,
                'no_per_id'   => $b->no_per_id,
                'nama_barang' => $b->nama_barang,
                'volume'      => $volume,
                'harga'       => $harga,
                'satuan'      => $b->satuan,
                'bulanData'   => $bulanData,
                'jumlah'      => $jumlah
            ];
        }

        return $data;
    }

    public function getAll($tahun = null)
    {
        if ($tahun) {
            $this->db->where('tahun', $tahun);
        }
        $this->db->order_by('id_barang', 'ASC');
        return $this->db->get('rkap_barang')->result();
    }

    public function insert($data)
    {
        return $this->db->insert('rkap_barang', $data);
    }
    public function insert_barang($data)
    {
        return $this->db->insert('rkap_barang_beli', $data);
    }
}
