<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pelanggan');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    // public function index()
    // {
    //     $upk = $this->input->get('upk');
    //     $tahun_rkap = $this->input->get('tahun_rkap') ?: date('Y');
    //     $data['tahun'] = $tahun_rkap;
    //     $data['upk'] = $upk;
    //     $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN UPK ' . strtoupper($upk) . ' <br> TAHUN ANGGARAN ';
    //     $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun_rkap, $upk);
    //     $data['jenis_pelanggan'] = $this->db->select('nama_jp')->get('rkap_jenis_plgn')->result_array();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/view_pelanggan', $data);
    //     $this->load->view('templates/footer');
    // }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN UPK ' . strtoupper($upk) . ' <br> TAHUN ANGGARAN ';


        // data yang sudah ada (baris per kategori, jenis, bulan)
        $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun);

        // master daftar kategori (kategori_data)
        $kategori_rows = $this->db->order_by('id_kd')->get('rkap_kategori_data')->result_array();
        if (!empty($kategori_rows)) {
            $data['kategori_list'] = array_map(function ($r) {
                return trim($r['nama_kd']);
            }, $kategori_rows);
        } else {
            // fallback jika belum punya tabel kategori_data
            $data['kategori_list'] = [
                'Samb Aktif Awal Bulan',
                'Jumlah Sambungan Baru',
                'Jumlah Penutupan Pelanggan',
                'Penyamb Kembali Pelanggan',
                'Jumlah Pencabutan Pelanggan',
                'Samb Aktif Akhir Bulan'
            ];
        }

        // master daftar jenis pelanggan (jenis_pelanggan)
        $jenis_rows = $this->db->order_by('id_jp')->get('rkap_jenis_plgn')->result_array();
        if (!empty($jenis_rows)) {
            $data['jenis_list'] = array_map(function ($r) {
                return trim($r['nama_jp']);
            }, $jenis_rows);
        } else {
            // fallback manual (samakan dengan yang ada di Excel Anda)
            $data['jenis_list'] = [
                'Sosial A', 'Sosial B', 'Rumah Tangga A', 'Rumah Tangga B', 'Rumah Tangga C',
                'Instansi Pemerintah A', 'Instansi Pemerintah B', 'ABRI', 'Niaga A', 'Niaga B', 'Khusus 2'
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/view_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $id_upk = $this->input->post('id_upk');
            $id_jp  = $this->input->post('id_jp');
            $tahun  = $this->input->post('tahun');
            $input  = $this->input->post('data'); // data[bulan][id_kd] = jumlah

            foreach ($input as $bulan => $kategoriData) {
                foreach ($kategoriData as $id_kd => $jumlah) {
                    // kosongkan jika tidak diisi
                    $jumlah = $jumlah !== "" ? (int)$jumlah : 0;

                    $this->Model_pelanggan->insert_rkap([
                        'id_upk'     => $id_upk,
                        'id_jp'      => $id_jp,
                        'id_kd'      => $id_kd,
                        'tahun'      => $tahun,
                        'bulan'      => $bulan,
                        'jumlah'     => $jumlah,
                        // 'tgl_upload' => date('Y-m-d H:i:s'),
                        // 'tgl_update' => date('Y-m-d H:i:s')
                    ]);
                }
            }

            $this->session->set_flashdata('success', "Data RKAP pelanggan berhasil disimpan");
            redirect('lembar_kerja/pelanggan/index?tahun=' . $tahun);
        }

        $data['title'] = "Form Input Data Perkembangan Pelanggan";
        $data['kategori_list'] = $this->Model_pelanggan->get_kategori(); // ambil dari tabel rkap_kategori_data
        $data['jenis_list'] = $this->Model_pelanggan->get_jenis_pelanggan(); // ambil dari tabel rkap_jenis_plgn
        $data['upk_list'] = $this->Model_pelanggan->get_upk(); // ambil dari tabel rkap_nama_upk
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/upload_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    // public function tambah()
    // {
    //     $id_upk = $this->input->post('id_upk');
    //     $id_jp  = $this->input->post('id_jp');
    //     $tahun  = $this->input->post('tahun');
    //     $bulan  = (int) $this->input->post('bulan');

    //     // input user
    //     $s_awal     = (int) $this->input->post('s_awal');
    //     $s_baru     = (int) $this->input->post('s_baru');
    //     $penutupan  = (int) $this->input->post('penutupan');
    //     $pembukaan  = (int) $this->input->post('pembukaan');
    //     $pencabutan = (int) $this->input->post('pencabutan');

    //     // jika bulan > 1, sambungan awal otomatis dari akhir bulan sebelumnya
    //     if ($bulan > 1) {
    //         $prev = $this->Rkap_model->get_sambungan_akhir($id_upk, $id_jp, $tahun, $bulan - 1);
    //         $s_awal = $prev ? $prev->jumlah : 0;
    //     }

    //     // hitung sambungan akhir
    //     $s_akhir = $s_awal + $s_baru - $penutupan + $pembukaan - $pencabutan;

    //     // simpan data
    //     $kategori_data = [
    //         1 => $s_awal,
    //         2 => $s_baru,
    //         3 => $penutupan,
    //         4 => $pembukaan,
    //         5 => $pencabutan,
    //         6 => $s_akhir
    //     ];

    //     foreach ($kategori_data as $id_kd => $jumlah) {
    //         $data = [
    //             'id_upk' => $id_upk,
    //             'id_jp'  => $id_jp,
    //             'id_kd'  => $id_kd,
    //             'tahun'  => $tahun,
    //             'bulan'  => $bulan,
    //             'jumlah' => $jumlah
    //         ];
    //         $this->Model_pelanggan->insert_or_update($data);
    //     }

    //     // setelah insert bulan ini, hitung ulang bulan berikutnya (propagasi)
    //     $this->propagate($id_upk, $id_jp, $tahun, $bulan + 1);

    //     $this->session->set_flashdata('success', "Data bulan $bulan berhasil disimpan");
    //     redirect('rkap_pelanggan/form_input');
    // }

    // public function tambah()
    // {
    //     $data['title'] = 'Input Data Perkembangan Pelanggan';
    //     $data['upk_list']   = $this->db->order_by('id_upk')->get('rkap_nama_upk')->result();               // table upk
    //     $data['jenis_list'] = $this->db->order_by('id_jp')->get('rkap_jenis_plgn')->result(); // table jenis_pelanggan
    //     $data['kategori_list'] = $this->Model_pelanggan->get_kategori(); // rkap_kategori_data
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/upload_pelanggan', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function insert_data()
    // {
    //     // ambil input, trim & sanitize
    //     $id_upk = $this->input->post('id_upk', true);
    //     $id_jp  = $this->input->post('id_jp', true);
    //     $tahun  = (int) $this->input->post('tahun', true);
    //     $bulan  = (int) $this->input->post('bulan', true);

    //     // validasi wajib
    //     if (!$id_upk || !$id_jp || !$tahun || $bulan < 1 || $bulan > 12) {
    //         $this->session->set_flashdata('error', 'Lengkapi UPK, Jenis Produk, Tahun, dan Bulan.');
    //         redirect('rkap_pelanggan/form_input');
    //         return;
    //     }

    //     // Sambungan Awal: jika bulan > 1 ambil dari sambungan akhir bulan sebelumnya,
    //     // jika bulan = 1 ambil dari input (kolom s_awal)
    //     if ($bulan > 1) {
    //         $prev = $this->Rkap_model->get_sambungan_akhir($id_upk, $id_jp, $tahun, $bulan - 1);
    //         $s_awal = $prev ? (int)$prev->jumlah : 0;
    //     } else {
    //         $s_awal = (int) $this->input->post('s_awal', true);
    //     }

    //     // Sambungan baru & lainnya diambil dari form (default 0)
    //     $s_baru     = (int) $this->input->post('s_baru', true);
    //     $penutupan  = (int) $this->input->post('penutupan', true);
    //     $pembukaan  = (int) $this->input->post('pembukaan', true);
    //     $pencabutan = (int) $this->input->post('pencabutan', true);

    //     // hitung sambungan akhir
    //     $s_akhir = $s_awal + $s_baru - $penutupan + $pembukaan - $pencabutan;

    //     // siapkan data per kategori untuk disimpan (1..6)
    //     $kategori_data = [
    //         1 => $s_awal,
    //         2 => $s_baru,
    //         3 => $penutupan,
    //         4 => $pembukaan,
    //         5 => $pencabutan,
    //         6 => $s_akhir
    //     ];

    //     foreach ($kategori_data as $id_kd => $jumlah) {
    //         $row = [
    //             'id_upk'     => (int)$id_upk,
    //             'id_jp'      => (int)$id_jp,
    //             'id_kd'      => (int)$id_kd,
    //             'tahun'      => (int)$tahun,
    //             'bulan'      => (int)$bulan,
    //             'jumlah'     => (int)$jumlah,
    //             'tgl_update' => date('Y-m-d H:i:s'),
    //             'tgl_upload' => date('Y-m-d H:i:s')
    //         ];
    //         $this->Rkap_model->insert_or_update($row);
    //     }

    //     // propagasi otomatis ke bulan berikutnya (recompute sampai Desember)
    //     $this->propagate($id_upk, $id_jp, $tahun, $bulan + 1);

    //     $this->session->set_flashdata('success', "Data bulan {$bulan} berhasil disimpan.");
    //     redirect('lembar_kerja/pelanggan');
    // }

    // propagasi ulang: rekalkulasi sambungan awal & akhir untuk bulan berikutnya dst
    private function propagate($id_upk, $id_jp, $tahun, $bulan)
    {
        if ($bulan > 12) return;

        // ambil sambungan akhir bulan sebelumnya
        $prev = $this->Rkap_model->get_sambungan_akhir($id_upk, $id_jp, $tahun, $bulan - 1);
        if (!$prev) return;

        $s_awal = (int)$prev->jumlah;

        // ambil nilai kategori lain yang sudah ada untuk bulan ini
        $rows = $this->db->get_where('rkap_pelanggan', [
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'tahun'  => $tahun,
            'bulan'  => $bulan
        ])->result();

        $map = [];
        foreach ($rows as $r) {
            $map[(int)$r->id_kd] = (int)$r->jumlah;
        }

        $s_baru     = isset($map[2]) ? $map[2] : 0;
        $penutupan  = isset($map[3]) ? $map[3] : 0;
        $pembukaan  = isset($map[4]) ? $map[4] : 0;
        $pencabutan = isset($map[5]) ? $map[5] : 0;

        $s_akhir = $s_awal + $s_baru - $penutupan + $pembukaan - $pencabutan;

        // update/insert sambungan awal (id_kd = 1)
        $this->Rkap_model->insert_or_update([
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'id_kd'  => 1,
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'jumlah' => $s_awal,
            'tgl_update' => date('Y-m-d H:i:s'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ]);

        // update/insert sambungan akhir (id_kd = 6)
        $this->Rkap_model->insert_or_update([
            'id_upk' => $id_upk,
            'id_jp'  => $id_jp,
            'id_kd'  => 6,
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'jumlah' => $s_akhir,
            'tgl_update' => date('Y-m-d H:i:s'),
            'tgl_upload' => date('Y-m-d H:i:s')
        ]);

        // lanjutkan ke bulan selanjutnya
        $this->propagate($id_upk, $id_jp, $tahun, $bulan + 1);
    }
}
