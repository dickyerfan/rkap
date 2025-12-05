<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bahan_baku extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_bahan_baku');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {

        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['bahan_baku'] = $this->Model_bahan_baku->get_bahan_baku($tahun);
        $data['title'] = 'RENCANA PEMBELIAN BAHAN BAKU UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/bahan_baku/view_bahan_baku', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['bahan_baku'] = $this->Model_bahan_baku->get_bahan_baku($tahun);
        $data['title'] = 'RENCANA PEMBELIAN BAHAN BAKU UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_bahan_baku_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/bahan_baku/laporan_pdf', $data);
    }

    // public function tambah()
    // {
    //     $data['daftar_bahan'] = [
    //         'Galon' => ['Galon', 'Tisu', 'Stiker Galon', 'Tutup Galon', 'Liquid Galon'],
    //         'Gelas 220 ml' => ['Cup/Gelas', 'Lid Cup', 'Sedotan', 'Dus 220ml', 'Isolasi'],
    //         'Botol 330 ml' => ['Botol 330ml', 'Sring', 'Dus 330ml', 'Tutup Botol 330ml', 'Isolasi'],
    //         'Botol 500 ml' => ['Botol 500ml', 'Sring', 'Dus 500ml', 'Tutup Botol 500ml', 'Isolasi'],
    //         'Botol 250 ml' => ['Botol 250ml', 'Stiker', 'Tutup Botol 250ml', 'Plastik'],
    //         'Botol 1500 ml' => ['Botol 1500ml', 'Sring', 'Dus 1500ml', 'Tutup Botol 1500ml', 'Isolasi']
    //     ];

    //     if ($this->input->post()) {
    //         $id_produk = $this->input->post('id_produk');
    //         $nama_bahan = $this->input->post('nama_bahan');
    //         $volume =  $this->input->post('volume');
    //         $harga_satuan =  $this->input->post('harga_satuan');
    //         $tahun_rkap = $this->session->userdata('tahun_rkap');

    //         // Ambil total produksi produk dari tabel produksi
    //         $produksi = $this->db
    //             ->select_sum('jumlah_produksi')
    //             ->where('id_produk', $id_produk)
    //             ->where('tahun_rkap', $tahun_rkap)
    //             ->get('rkap_amdk_produksi')
    //             ->row()->jumlah_produksi ?? 0;

    //         // Hitung total tahun (volume * harga)
    //         $total_tahun = $volume * $harga_satuan;

    //         $data = [
    //             'id_produk'     => $id_produk,
    //             'tahun_rkap'    => $tahun_rkap,
    //             'nama_bahan'    => $nama_bahan,
    //             'volume'        => $volume,
    //             'harga_satuan'  => $harga_satuan,
    //             'total_tahun'   => $total_tahun,
    //             'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
    //         ];

    //         // Simpan ke database
    //         $this->Model_bahan_baku->insert_or_update_bahan($data);

    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 Data Bahan Baku AMDK berhasil ditambahkan!
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );

    //         redirect('lembar_kerja/rkap_amdk/bahan_baku?tahun_rkap=' . $tahun);
    //     } else {
    //         $data['title'] = 'Input Bahan Baku AMDK';
    //         $data['produk'] = $this->db->get('rkap_amdk_produk')->result();

    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('lembar_kerja/rkap_amdk/bahan_baku/upload_bahan_baku', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    public function tambah()
    {
        $data['daftar_bahan'] = [
            'Galon 19L' => ['Galon', 'Tisu', 'Stiker Galon', 'Tutup Galon', 'Liquid Galon'],
            'Gelas 220ml' => ['Cup/Gelas', 'Lid Cup', 'Sedotan', 'Dus 220ml', 'Isolasi'],
            'Botol 330ml' => ['Botol 330ml', 'Sring', 'Dus 330ml',  'Isolasi'],
            'Botol 500ml' => ['Botol 500ml', 'Sring', 'Dus 500ml',  'Isolasi'],
            'Botol 250ml' => ['Botol 250ml', 'Stiker', 'Tutup Botol 250ml', 'Plastik'],
            'Botol 1500ml' => ['Botol 1500ml', 'Sring', 'Dus 1500ml', 'Isolasi']
        ];

        // Ambil daftar produk dari database
        $produk_db = $this->db->get('rkap_amdk_produk')->result();
        $produk_mapping = [];
        foreach ($produk_db as $p) {
            $produk_mapping[$p->nama_produk] = $p->id_produk;
        }
        $data['produk_mapping'] = $produk_mapping; // kirim ke view

        if ($this->input->post()) {
            $nama_produk = $this->input->post('id_produk'); // masih kirim nama produk
            $id_produk = $produk_mapping[$nama_produk] ?? null;
            $nama_bahan = $this->input->post('nama_bahan');
            $volume = $this->input->post('volume');
            $harga_satuan = $this->input->post('harga_satuan');
            $tahun_rkap = $this->input->get('tahun_rkap') ?: (date('Y') + 1);

            if (!$id_produk) {
                show_error('ID produk tidak ditemukan untuk nama produk: ' . $nama_produk);
            }

            $total_tahun = $volume * $harga_satuan;

            $data_insert = [
                'id_produk'     => $id_produk,
                'tahun_rkap'    => $tahun_rkap,
                'nama_bahan'    => $nama_bahan,
                'volume'        => $volume,
                'harga_satuan'  => $harga_satuan,
                'total_tahun'   => $total_tahun,
                'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
            ];

            $this->Model_bahan_baku->insert_or_update_bahan($data_insert);

            $this->session->set_flashdata('info', '<div class="alert alert-success">Data bahan baku berhasil disimpan!</div>');
            redirect('lembar_kerja/rkap_amdk/bahan_baku?tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Bahan Baku AMDK';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/bahan_baku/upload_bahan_baku', $data);
            $this->load->view('templates/footer');
        }
    }

    public function tambah_perlengkapan()
    {
        $data['daftar_bahan'] = [
            'Perlengkapan Lab' => ['Aquades', 'MQ Water', 'Petri Film', 'Ozon Reagent', 'Tisu lab', 'Alkohol 90%', 'Pipet Plastik', 'Spiritus', 'Termometer Ruangan'],
            'Perlengkapan Lainnya' => ['Kanibo Mobil & R. Produksi', 'Tisu', 'Sabun Cair', 'Masker', 'Tutup Kepala', 'Sarung tangan', 'Alkohol 90%', 'Selang Bening'],
        ];

        if ($this->input->post()) {
            $id_produk = $this->input->post('id_produk');
            $nama_bahan = $this->input->post('nama_bahan');
            $volume = $this->input->post('volume');
            $harga_satuan = $this->input->post('harga_satuan');
            $tahun_rkap = $this->input->get('tahun_rkap') ?: (date('Y') + 1);

            $total_tahun = $volume * $harga_satuan;

            $data_insert = [
                'id_produk'     => $id_produk,
                'tahun_rkap'    => $tahun_rkap,
                'nama_bahan'    => $nama_bahan,
                'volume'        => $volume,
                'harga_satuan'  => $harga_satuan,
                'total_tahun'   => $total_tahun,
                'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
            ];

            $this->Model_bahan_baku->insert_or_update_perlengkapan($data_insert);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses</strong> Biaya Perlengkapan berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/rkap_amdk/bahan_baku?tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Bahan Baku AMDK';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/bahan_baku/upload_perlengkapan', $data);
            $this->load->view('templates/footer');
        }
    }

    // public function generate()
    // {
    //     $tahun = $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);

    //     // Ambil semua data bahan baku tahun ini
    //     $bahan_baku = $this->Model_bahan_baku->get_bahan_baku($tahun);

    //     if (empty($bahan_baku)) {
    //         $this->session->set_flashdata('info', '
    //         <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Error!</strong> Tidak ada data bahan baku ditemukan untuk tahun ' . $tahun . '.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>');
    //         redirect('lembar_kerja/rkap_amdk/bahan_baku');
    //         return;
    //     }

    //     // Mapping id_produk ke no_per_id dan uraian
    //     $mapping = [
    //         1 => ['no_per_id' => '98.02.05.01', 'uraian' => 'Bahan Baku Galon'],
    //         2 => ['no_per_id' => '98.02.05.02', 'uraian' => 'Bahan Baku Gelas 220 ml'],
    //         3 => ['no_per_id' => '98.02.05.03', 'uraian' => 'Bahan Baku Botol 330 ml'],
    //         4 => ['no_per_id' => '98.02.05.04', 'uraian' => 'Bahan Baku Botol 500 ml'],
    //         5 => ['no_per_id' => '98.02.05.05', 'uraian' => 'Bahan Baku Botol 250 ml'],
    //         6 => ['no_per_id' => '98.02.05.06', 'uraian' => 'Bahan Baku Botol 1500 ml'],
    //         7 => ['no_per_id' => '98.02.05.07', 'uraian' => 'Perlengkapan Lab'],
    //         8 => ['no_per_id' => '98.02.05.09', 'uraian' => 'Perlengkapan Lainnya'],
    //     ];

    //     $this->db->trans_start();

    //     foreach ($bahan_baku as $bahan) {
    //         $id_produk = (int)$bahan['id_produk'];
    //         if (!isset($mapping[$id_produk])) {
    //             continue; // skip jika tidak ada mapping
    //         }

    //         $no_per_id = $mapping[$id_produk]['no_per_id'];
    //         $uraian    = $mapping[$id_produk]['uraian'];
    //         $pagu_bulan = (float)$bahan['total_tahun'] / 12;

    //         // 🔹 Hapus data lama jika sudah ada (biar tidak dobel)
    //         $this->db->where('no_per_id', $no_per_id);
    //         $this->db->where('YEAR(bulan)', (int)$tahun);
    //         $this->db->delete('rkap_amdk_biaya');

    //         // 🔹 Insert untuk 12 bulan
    //         for ($bulan = 1; $bulan <= 12; $bulan++) {
    //             $data_insert = [
    //                 'cabang_id' => 13,
    //                 'no_per_id' => $no_per_id,
    //                 'bulan'     => sprintf('%d-%02d-01', $tahun, $bulan), // contoh: 2026-01-01
    //                 'uraian'    => $uraian,
    //                 'pagu'      => round($pagu_bulan, 2)
    //             ];
    //             $this->db->insert('rkap_amdk_biaya', $data_insert);
    //         }
    //     }

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === FALSE) {
    //         $this->session->set_flashdata('info', '
    //         <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Error!</strong> Gagal generate data biaya bahan baku ke tabel biaya.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>');
    //     } else {
    //         $this->session->set_flashdata('info', '
    //         <div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Sukses!</strong> Data biaya bahan baku berhasil digenerate ke tabel biaya untuk tahun ' . $tahun . '.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>');
    //     }

    //     redirect('lembar_kerja/rkap_amdk/bahan_baku');
    // }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);
        $this->load->model('Model_bahan_baku');

        // Ambil semua data bahan baku tahun ini
        $bahan_baku = $this->Model_bahan_baku->get_bahan_baku($tahun);

        if (empty($bahan_baku)) {
            $this->session->set_flashdata('info', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Tidak ada data bahan baku ditemukan untuk tahun ' . $tahun . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect('lembar_kerja/rkap_amdk/bahan_baku');
            return;
        }

        // 🔹 Mapping id_produk ke akun & uraian
        $mapping = [
            1 => ['no_per_id' => '98.02.05.01', 'uraian' => 'Bahan Baku Galon'],
            2 => ['no_per_id' => '98.02.05.02', 'uraian' => 'Bahan Baku Gelas 220 ml'],
            3 => ['no_per_id' => '98.02.05.03', 'uraian' => 'Bahan Baku Botol 330 ml'],
            4 => ['no_per_id' => '98.02.05.04', 'uraian' => 'Bahan Baku Botol 500 ml'],
            5 => ['no_per_id' => '98.02.05.06', 'uraian' => 'Bahan Baku Botol 250 ml'],
            6 => ['no_per_id' => '98.02.05.05', 'uraian' => 'Bahan Baku Botol 1500 ml'],
            7 => ['no_per_id' => '98.02.05.07', 'uraian' => 'Perlengkapan Lab'],
            8 => ['no_per_id' => '98.02.05.09', 'uraian' => 'Perlengkapan Lainnya'],
        ];

        // 🔹 Kelompokkan data berdasarkan id_produk
        $grouped = [];
        foreach ($bahan_baku as $bahan) {
            $id_produk = (int)$bahan['id_produk'];
            if (!isset($grouped[$id_produk])) {
                $grouped[$id_produk] = 0;
            }
            $grouped[$id_produk] += (float)$bahan['total_tahun'];
        }

        $this->db->trans_start();

        foreach ($grouped as $id_produk => $total_tahun) {
            if (!isset($mapping[$id_produk])) continue;

            $no_per_id = $mapping[$id_produk]['no_per_id'];
            $uraian = $mapping[$id_produk]['uraian'];
            $pagu_bulan = round($total_tahun / 12, 2);

            // 🔹 Hapus data lama (agar tidak dobel)
            $this->db->where('no_per_id', $no_per_id);
            $this->db->where('YEAR(bulan)', (int)$tahun);
            $this->db->delete('rkap_amdk_biaya');

            // 🔹 Insert ke-12 bulan
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $data_insert = [
                    'cabang_id' => 13,
                    'no_per_id' => $no_per_id,
                    'bulan'     => sprintf('%d-%02d-01', $tahun, $bulan),
                    'uraian'    => $uraian,
                    'pagu'      => $pagu_bulan,
                    'ptgs_upload' => $this->session->userdata('nama_lengkap')
                ];
                $this->db->insert('rkap_amdk_biaya', $data_insert);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('info', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Gagal generate data biaya bahan baku ke tabel biaya.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        } else {
            $this->session->set_flashdata('info', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Data biaya bahan baku berhasil digenerate ke tabel biaya untuk tahun ' . $tahun . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }

        redirect('lembar_kerja/rkap_amdk/bahan_baku');
    }



    // public function generate()
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

    //     // mapping id_produk ke kode perkiraan
    //     $kode_perkiraan = [
    //         1 => '98.02.05.01', // Galon
    //         2 => '98.02.05.02', // Gelas 220ml
    //         3 => '98.02.05.03', // Botol 330ml
    //         4 => '98.02.05.04', // Botol 500ml
    //         5 => '98.02.05.05', // Botol 250ml
    //         6 => '98.02.05.06', // Botol 1500ml
    //     ];

    //     $id_upk = 23;
    //     $cabang_id = 13;

    //     // Ambil total bahan per produk
    //     $produk_list = $this->db
    //         ->select('id_produk, SUM(total_tahun) AS total_bahan')
    //         ->where('tahun_rkap', $tahun)
    //         ->group_by('id_produk')
    //         ->get('rkap_amdk_bahan')
    //         ->result();

    //     if (!$produk_list) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 Belum ada data bahan baku untuk tahun ini.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('lembar_kerja/rkap_amdk/bahan_baku?tahun_rkap=' . $tahun);
    //         return;
    //     }

    //     foreach ($produk_list as $produk) {
    //         if (!isset($kode_perkiraan[$produk->id_produk])) continue;

    //         $no_per_id = $kode_perkiraan[$produk->id_produk];
    //         $nilai_per_bulan = $produk->total_bahan / 12;

    //         for ($bulan = 1; $bulan <= 12; $bulan++) {
    //             $tanggal_bulan = date('Y-m-d', strtotime("$tahun-$bulan-01"));

    //             $data_insert = [
    //                 'id_upk'     => $id_upk,
    //                 'cabang_id'  => $cabang_id,
    //                 'no_per_id'  => $no_per_id,
    //                 'bulan'      => $tanggal_bulan,
    //                 'pagu'       => $nilai_per_bulan,
    //             ];

    //             // cek jika sudah ada, update; jika belum, insert
    //             $cek = $this->db->get_where('rkap_rekap', [
    //                 'id_upk' => $id_upk,
    //                 'cabang_id' => $cabang_id,
    //                 'no_per_id' => $no_per_id,
    //                 'bulan' => $tanggal_bulan
    //             ])->row();

    //             if ($cek) {
    //                 $this->db->where('id', $cek->id);
    //                 $this->db->update('rkap_rekap', $data_insert);
    //             } else {
    //                 $this->db->insert('rkap_rekap', $data_insert);
    //             }
    //         }
    //     }

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                 Data bahan baku berhasil digenerate ke Aplikasi Cetet.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //     );
    //     redirect('lembar_kerja/rkap_amdk/bahan_baku?tahun_rkap=' . $tahun);
    // }
}
