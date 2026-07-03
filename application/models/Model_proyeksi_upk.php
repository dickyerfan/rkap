<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_proyeksi_upk extends CI_Model
{

    public function getData($tahun, $id_upk)
    {
        return $this->db
            ->select('rkap_evaluasi_pelanggan.*, rkap_nama_upk.nama_upk')
            ->from('rkap_evaluasi_pelanggan')
            ->join(
                'rkap_nama_upk',
                'rkap_nama_upk.id_upk = rkap_evaluasi_pelanggan.id_upk'
            )
            ->where([
                'rkap_evaluasi_pelanggan.tahun_rkap' => $tahun,
                'rkap_evaluasi_pelanggan.id_upk' => $id_upk
            ])
            ->order_by('bulan', 'ASC')
            ->get()
            ->result();
    }

    public function getDataAll($tahun, $id_upk = null)
    {
        $this->db
            ->select("
            bulan,
            SUM(sr_baru) as sr_baru,
            SUM(penutupan) as penutupan,
            SUM(pencabutan) as pencabutan,
            SUM(pembukaan) as pembukaan,
            SUM(tera_meter) as tera_meter,
            SUM(ganti_meter) as ganti_meter,
            AVG(efi_tagih) as efi_tagih
        ")
            ->from('rkap_evaluasi_pelanggan')
            ->where('tahun_rkap', $tahun);

        if (!empty($id_upk)) {
            $this->db->where('id_upk', $id_upk);
        }

        $this->db->group_by('bulan');
        $this->db->order_by('bulan');

        return $this->db->get()->result();
    }

    public function cekData($tahun, $id_upk, $bulan)
    {
        return $this->db
            ->where([
                'tahun_rkap' => $tahun,
                'id_upk'     => $id_upk,
                'bulan'      => $bulan
            ])
            ->get('rkap_evaluasi_pelanggan')
            ->row();
    }

    public function insertData($data)
    {
        return $this->db->insert('rkap_evaluasi_pelanggan', $data);
    }

    public function updateData($id_evaluasi, $data)
    {
        return $this->db
            ->where('id_evaluasi', $id_evaluasi)
            ->update('rkap_evaluasi_pelanggan', $data);
    }
































    public function getDataUpk($dataUpk, $dataTahun)
    {
        $this->db->select('*');
        $this->db->from('usulan_barang');
        $this->db->where('tahun_rkap', $dataTahun);
        $this->db->where('bagian_upk', $dataUpk);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNamaUpk($dataUpk, $dataTahun)
    {
        $this->db->select('bagian_upk');
        $this->db->from('usulan_barang');
        $this->db->where('tahun_rkap', $dataTahun);
        $this->db->where('bagian_upk', $dataUpk);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUsulanBarang($id_usulanBarang)
    {
        return $this->db->where('tahun_rkap', date('Y'))
            ->get_where('usulan_barang', ['id_usulanBarang' => $id_usulanBarang])
            ->row();
    }

    public function getUsulanBarangAdmin($id_usulanBarang)
    {
        return $this->db
            ->select('usulan_barang.*, rkap_kategori_barang.kode_akun')
            ->from('usulan_barang')
            ->join('rkap_kategori_barang', 'rkap_kategori_barang.kode_akun = usulan_barang.no_perkiraan', 'left')
            ->where('usulan_barang.id_usulanBarang', (int) $id_usulanBarang)
            ->get()
            ->row();
    }

    // public function updateData()
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $data = [
    //         'no_perkiraan' => $this->input->post('no_perkiraan', true),
    //         'nama_perkiraan' => $this->input->post('nama_perkiraan', true),
    //         'latar_belakang' => $this->input->post('latar_belakang', true),
    //         'solusi' => $this->input->post('solusi', true),
    //         'volume' => (int) $this->input->post('volume', true),
    //         'satuan' => $this->input->post('satuan', true),
    //         'biaya' => (int) $this->input->post('biaya', true),
    //         'ket' => $this->input->post('ket', true),
    //         'kategori' => $this->input->post('kategori', true),
    //         'tgl_update' => date('Y-m-d H:i:s')

    //     ];
    //     $this->db->where('id_usulanBarang', $this->input->post('id_usulanBarang'));
    //     $this->db->where('status_update', 1);
    //     $this->db->where('tahun_rkap', date('Y'));
    //     $this->db->update('usulan_barang', $data);
    // }

    public function updateDataDariMaster($barang)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            // 'no_perkiraan' => $this->input->post('no_perkiraan', true),
            'nama_perkiraan' => $barang->nama_barang,
            'latar_belakang' => '',
            'solusi' => '',
            'volume' => (int) $this->input->post('volume', true),
            'satuan' => $barang->satuan,
            'harga_satuan' => (int) $barang->harga_satuan,
            'biaya' => (int) $barang->harga_satuan * (int) $this->input->post('volume', true),
            'ket' => '',
            'kategori' => $barang->nama_kategori,
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_usulanBarang', $this->input->post('id_usulanBarang', true));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->update('usulan_barang', $data);
    }

    public function updateDataAdminDariMaster($barang, $tahunRkap, $hargaSatuan)
    {
        $volume = (int) $this->input->post('volume', true);
        $hargaSatuan = (int) $hargaSatuan;
        $data = [
            'nama_perkiraan' => $barang->nama_barang,
            'latar_belakang' => '',
            'solusi' => '',
            'volume' => $volume,
            'satuan' => $barang->satuan,
            'harga_satuan' => $hargaSatuan,
            'biaya' => $hargaSatuan * $volume,
            'ket' => $this->input->post('ket', true),
            'kategori' => $barang->nama_kategori,
            'tgl_update' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_usulanBarang', $this->input->post('id_usulanBarang', true));
        $this->db->where('status_update', 1);
        $this->db->where('tahun_rkap', (int) $tahunRkap);
        $this->db->update('usulan_barang', $data);
    }

    public function updateFoto($data)
    {
        $this->db->where('id_usulanBarang', $data['id_usulanBarang']);
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->set('foto_ket', $data['foto_ket']);
        $this->db->update('usulan_barang');
    }

    public function getTahun()
    {
        $this->db->select('*');
        $this->db->from('usulan_barang');
        $this->db->where('bagian_upk', $this->session->userdata('upk_bagian'));
        $this->db->where('tahun_rkap', date('Y'));
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getKategoriBarang()
    {
        return $this->db
            ->select('nama_kategori')
            ->distinct()
            ->order_by('id', 'DESC')
            ->get('rkap_kategori_barang')
            ->result();
    }

    public function insert_or_update_generate_barang($data)
    {
        $insert_count = 0;
        $update_count = 0;
        foreach ($data as $row) {

            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_biaya')->row();

            if ($cek) {
                $row['ptgs_update'] = $this->session->userdata('nama_lengkap');
                $this->db->where('id_by', $cek->id_by);
                $this->db->update('rkap_biaya', $row);
                $update_count++;
            } else {

                $this->db->insert('rkap_biaya', $row);
                $insert_count++;
            }
        }

        return [
            'inserted' => $insert_count,
            'updated' => $update_count
        ];
    }

    public function getKategoriByBagian($bagian)
    {
        $this->db->select('*');
        $this->db->from('rkap_kategori_barang');

        if (strtolower($bagian) != 'pemeliharaan') {

            $this->db->group_start();
            $this->db->where('nama_kategori', 'Peralatan kantor');
            $this->db->or_where('nama_kategori', 'Barang Percetakan');
            $this->db->group_end();
        }

        $this->db->order_by('nama_kategori', 'ASC');

        return $this->db->get()->result();
    }

    public function getNoPerBarang()
    {
        return $this->db
            ->like('kode', '96', 'after')
            ->order_by('kode', 'ASC')
            ->get('no_per')
            ->result();
    }

    public function updateStatusUpload($id_usulanBarang)
    {
        $this->db->where('id_usulanBarang', $id_usulanBarang);

        return $this->db->update('usulan_barang', [
            'status_upload' => 1
        ]);
    }
}
