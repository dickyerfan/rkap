<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rkap_barang extends CI_Model
{
    public function getKategori()
    {
        return $this->db
            ->order_by('id', 'DESC')
            ->get('rkap_kategori_barang')
            ->result();
    }

    public function getKategoriDenganNoPer()
    {
        return $this->db
            ->select('rkap_kategori_barang.*, no_per.kode AS no_per_kode, no_per.name AS no_per_nama')
            ->from('rkap_kategori_barang')
            ->join('no_per', 'no_per.kode = rkap_kategori_barang.kode_akun AND no_per.status = 1', 'left')
            ->order_by('rkap_kategori_barang.nama_kategori', 'ASC')
            ->get()
            ->result();
    }

    public function getNoPerKategori($kategoriId)
    {
        return $this->db
            ->select("no_per.kode, no_per.name")
            ->from("rkap_kategori_barang")
            ->join("no_per", "no_per.kode = rkap_kategori_barang.kode_akun AND no_per.status = 1")
            ->where("rkap_kategori_barang.id", (int) $kategoriId)
            ->get()
            ->row();
    }

    public function getNoPerByKodeAkun($kodeAkun, $selectedNoPer = null)
    {
        $this->db->select("kode, name")
            ->from("no_per")
            ->where("status", 1);

        if (!empty($kodeAkun)) {
            // ambil semua yang diawali kode akun
            $this->db->like("kode", $kodeAkun, 'after');
        }

        if (!empty($selectedNoPer)) {
            $this->db->or_where("kode", $selectedNoPer);
        }

        return $this->db->order_by("kode", "ASC")->get()->result();
    }

    // public function getNoPerByKodeAkun($selectedNoPer = null)
    // {
    //     $this->db->select("kode, name")
    //         ->from("no_per")
    //         ->where("status", 1);

    //     // if (!empty($kodeAkun)) {
    //     //     $this->db->like("kode", $kodeAkun, 'after');
    //     // }

    //     if (!empty($selectedNoPer)) {
    //         $this->db->where("kode", $selectedNoPer); // TANPA OR
    //     }

    //     return $this->db->order_by("kode", "ASC")->get()->result();
    // }

    public function getKategoriById($id)
    {
        return $this->db
            ->get_where('rkap_kategori_barang', ['id' => $id])
            ->row();
    }

    public function insertKategori()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true),
            'kode_akun' => $this->input->post('kode_akun', true),
            'keterangan' => $this->input->post('keterangan', true),
        ];

        $this->db->insert('rkap_kategori_barang', $data);
    }

    public function updateKategori()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori', true),
            'kode_akun' => $this->input->post('kode_akun', true),
            'keterangan' => $this->input->post('keterangan', true),
        ];

        $this->db->where('id', $this->input->post('id', true));
        $this->db->update('rkap_kategori_barang', $data);
    }

    public function deleteKategori($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rkap_kategori_barang');
    }

    public function getMasterBarang($tahun = null)
    {
        $this->db
            ->select('rkap_master_barang.*, rkap_kategori_barang.nama_kategori, rkap_kategori_barang.kode_akun')
            ->from('rkap_master_barang')
            ->join('rkap_kategori_barang', 'rkap_kategori_barang.id = rkap_master_barang.kategori_id', 'left');

        if ($tahun !== null) {
            $this->db->where('rkap_master_barang.tahun', (int) $tahun);
        }

        return $this->db
            ->order_by('rkap_kategori_barang.id', 'DESC')
            // ->order_by('rkap_master_barang.nama_barang', 'ASC')
            ->get()
            ->result();
    }

    public function getTahunMasterBarang()
    {
        return $this->db
            ->select('tahun')
            ->distinct()
            ->order_by('tahun', 'DESC')
            ->get('rkap_master_barang')
            ->result();
    }

    public function getMasterBarangById($id)
    {
        return $this->db
            ->get_where('rkap_master_barang', ['id' => $id])
            ->row();
    }

    public function getMasterBarangTerpilih($id, $tahun, $kategoriId)
    {
        return $this->db
            ->select('rkap_master_barang.*, rkap_kategori_barang.nama_kategori, rkap_kategori_barang.kode_akun')
            ->from('rkap_master_barang')
            ->join('rkap_kategori_barang', 'rkap_kategori_barang.id = rkap_master_barang.kategori_id')
            ->where('rkap_master_barang.id', (int) $id)
            ->where('rkap_master_barang.tahun', (int) $tahun)
            ->where('rkap_master_barang.kategori_id', (int) $kategoriId)
            ->get()
            ->row();
    }

    public function cariMasterBarang($tahun, $namaKategori, $namaBarang)
    {
        return $this->db
            ->select('rkap_master_barang.id')
            ->from('rkap_master_barang')
            ->join('rkap_kategori_barang', 'rkap_kategori_barang.id = rkap_master_barang.kategori_id')
            ->where('rkap_master_barang.tahun', (int) $tahun)
            ->where('rkap_kategori_barang.nama_kategori', $namaKategori)
            ->where('rkap_master_barang.nama_barang', $namaBarang)
            ->get()
            ->row();
    }

    public function masterBarangSudahAda($tahun, $kategoriId, $namaBarang, $kecualiId = null)
    {
        $this->db
            ->where('tahun', (int) $tahun)
            ->where('kategori_id', (int) $kategoriId)
            ->where('nama_barang', trim($namaBarang));

        if ($kecualiId !== null) {
            $this->db->where('id !=', (int) $kecualiId);
        }

        return $this->db->count_all_results('rkap_master_barang') > 0;
    }

    public function insertMasterBarang()
    {
        $data = [
            'tahun' => (int) $this->input->post('tahun', true),
            'kategori_id' => $this->input->post('kategori_id', true),
            'nama_barang' => $this->input->post('nama_barang', true),
            'harga_satuan' => $this->input->post('harga_satuan', true),
            'satuan' => $this->input->post('satuan', true),
        ];

        $this->db->insert('rkap_master_barang', $data);
    }

    public function updateMasterBarang()
    {
        $data = [
            'tahun' => (int) $this->input->post('tahun', true),
            'kategori_id' => $this->input->post('kategori_id', true),
            'nama_barang' => $this->input->post('nama_barang', true),
            'harga_satuan' => $this->input->post('harga_satuan', true),
            'satuan' => $this->input->post('satuan', true),
        ];

        $this->db->where('id', $this->input->post('id', true));
        $this->db->update('rkap_master_barang', $data);
    }

    public function deleteMasterBarang($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rkap_master_barang');
    }

    public function salinMasterBarang($tahunSumber, $tahunTujuan)
    {
        $tahunSumber = (int) $tahunSumber;
        $tahunTujuan = (int) $tahunTujuan;
        $barangSumber = $this->db
            ->where('tahun', $tahunSumber)
            ->get('rkap_master_barang')
            ->result_array();

        if (empty($barangSumber)) {
            return 0;
        }

        $this->db->trans_start();
        $jumlahDisalin = 0;

        foreach ($barangSumber as $barang) {
            $sudahAda = $this->db
                ->where('tahun', $tahunTujuan)
                ->where('kategori_id', $barang['kategori_id'])
                ->where('nama_barang', $barang['nama_barang'])
                ->count_all_results('rkap_master_barang') > 0;

            if ($sudahAda) {
                continue;
            }

            $this->db->insert('rkap_master_barang', [
                'tahun' => $tahunTujuan,
                'kategori_id' => $barang['kategori_id'],
                'nama_barang' => $barang['nama_barang'],
                'harga_satuan' => $barang['harga_satuan'],
                'satuan' => $barang['satuan'],
            ]);
            $jumlahDisalin++;
        }

        $this->db->trans_complete();

        return $this->db->trans_status() ? $jumlahDisalin : false;
    }
}
