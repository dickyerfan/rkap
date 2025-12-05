<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_produksi_amdk extends CI_Model
{
    public function getDataProduksi($tahun)
    {
        $sql = "
        SELECT 
            p.id_produk,
            p.nama_produk,
            prod.bulan,
            prod.jumlah_produksi,
            pr.id_tarif,
            t.tarif,
            pr.persen
        FROM rkap_amdk_produksi prod
        JOIN rkap_amdk_produk p ON p.id_produk = prod.id_produk
        JOIN rkap_amdk_persentase pr ON pr.id_produk = p.id_produk AND pr.tahun_rkap = prod.tahun_rkap
        JOIN rkap_amdk_tarif t ON t.id_tarif = pr.id_tarif AND t.tahun_rkap = prod.tahun_rkap
        WHERE prod.tahun_rkap = ?
        ORDER BY p.id_produk, FIELD(prod.bulan,1,2,3,4,5,6,7,8,9,10,11,12), t.id_tarif
    ";
        $query = $this->db->query($sql, [$tahun]);
        $data = $query->result_array();

        // Format data menjadi array per produk agar mudah ditampilkan di view
        $result = [];
        foreach ($data as $row) {
            $id_produk = $row['id_produk'];
            $nama_produk = $row['nama_produk'];

            if (!isset($result[$id_produk])) {
                $result[$id_produk] = [
                    'id_produk' => $id_produk,
                    'nama_produk' => $nama_produk,
                    'produksi' => array_fill(1, 12, 0),
                    'subtotal' => 0,
                    'tarif' => []
                ];
            }

            // Simpan total produksi per bulan (baris utama)
            $result[$id_produk]['produksi'][$row['bulan']] = $row['jumlah_produksi'];
            $result[$id_produk]['subtotal'] += $row['jumlah_produksi'];

            // Hitung per kategori tarif
            $kategori = $row['tarif'];
            $jumlah_kategori = $row['jumlah_produksi'] * ($row['persen'] / 100);

            if (!isset($result[$id_produk]['tarif'][$kategori])) {
                $result[$id_produk]['tarif'][$kategori] = [
                    'persen' => $row['persen'],
                    // 'harga' => $row['harga'],
                    'produksi' => array_fill(1, 12, 0),
                    'subtotal' => 0,
                    'pendapatan' => array_fill(1, 12, 0),
                    'total_pendapatan' => 0
                ];
            }

            $result[$id_produk]['tarif'][$kategori]['produksi'][$row['bulan']] = $jumlah_kategori;
            $result[$id_produk]['tarif'][$kategori]['subtotal'] += $jumlah_kategori;
        }

        return $result;
    }

    public function insertProduksi($id_produk, $tahun, $jumlah)
    {
        // Cek apakah sudah ada data untuk produk & tahun ini
        $cek = $this->db->get_where('rkap_amdk_produksi', [
            'id_produk' => $id_produk,
            'tahun_rkap' => $tahun
        ])->num_rows();

        if ($cek > 0) {
            return false; // Data sudah ada
        }

        $data = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data[] = [
                'id_produk' => $id_produk,
                'tahun_rkap' => $tahun,
                'bulan' => $bulan,
                'jumlah_produksi' => $jumlah,
                'ptgs_upload' => $this->session->userdata('nama_lengkap')
            ];
        }

        return $this->db->insert_batch('rkap_amdk_produksi', $data);
    }

    public function getProduksiByProdukTahun($id_produk, $tahun)
    {
        return $this->db->where('id_produk', $id_produk)
            ->where('tahun_rkap', $tahun)
            ->order_by('bulan', 'ASC')
            ->get('rkap_amdk_produksi')
            ->result_array();
    }

    public function updateProduksi($id_produk, $tahun, $jumlah, $ptgs_update = null)
    {
        foreach ($jumlah as $bulan => $nilai) {
            $this->db->where('id_produk', $id_produk)
                ->where('tahun_rkap', $tahun)
                ->where('bulan', $bulan)
                ->update('rkap_amdk_produksi', ['jumlah_produksi' => $nilai, 'ptgs_update' => $ptgs_update]);
        }
    }
}
