<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian_bahan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pembelian_bahan');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('tahun_rkap', $tahun);

        // $data['barang'] = $this->Model_pembelian_bahan->getRekapPembelianBahan($tahun);
        $data['barang'] = $this->Model_pembelian_bahan->getRekapPembelianBahanOtomatis($tahun);
        $data['title'] = 'RENCANA PEMBELIAN BAHAN DAN PERLENGKAPAN';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pembelian_bahan/view_pembelian_barang', $data);
        $this->load->view('templates/footer');
    }

    // public function simpan_otomatis()
    // {
    //     $tahun = $this->session->userdata('tahun_rkap');
    //     $data = $this->Model_pembelian_bahan->getRekapPembelianBahanOtomatis($tahun);

    //     foreach ($data as $b) {
    //         for ($m = 1; $m <= 12; $m++) {
    //             $bulan_date = date("$tahun-$m-01");

    //             // Cek jika sudah ada data agar tidak duplikat
    //             $cek = $this->db->get_where('rkap_barang_beli', [
    //                 'id_barang' => $b['id_barang'],
    //                 'bulan'     => $bulan_date
    //             ])->row();

    //             if (!$cek) {
    //                 $this->db->insert('rkap_barang_beli', [
    //                     'id_barang' => $b['id_barang'],
    //                     'bulan'     => $bulan_date,
    //                     'volume'    => $b['volume'],
    //                     'harga'     => $b['harga'],
    //                     'nilai'     => $b['bulanData'][$m]
    //                 ]);
    //             }
    //         }
    //     }

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //         <strong>Berhasil!</strong> Data berhasil disimpan otomatis.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>'
    //     );

    //     redirect('lembar_kerja/arus_kas/pembelian_bahan');
    // }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['barang'] = $this->Model_pembelian_bahan->getRekapPembelianBahanOtomatis($tahun);
        $data['title'] = 'RENCANA PEMBELIAN BAHAN DAN PERLENGKAPAN';


        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pembelian_bahan_{$tahun}_.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/pembelian_bahan/laporan_pdf', $data);
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;

        // Ambil data dari model (otomatis sudah sesuaikan tahun)
        $barang = $this->Model_pembelian_bahan->getRekapPembelianBahanOtomatis($tahun);

        // Inisialisasi total bulan (1–12)
        $total_bulan = array_fill(1, 12, 0);
        $total_semua = 0;

        // Kalau tahun 2026 → kurangi id_barang 1, 2, 3
        $exclude_bulan = array_fill(1, 12, 0);
        $exclude_total = 0;

        foreach ($barang as $b) {
            for ($m = 1; $m <= 12; $m++) {
                $nilai = $b['bulanData'][$m] ?? 0;
                $total_bulan[$m] += $nilai;

                if ($tahun == 2026 && in_array($b['id_barang'], [1, 2, 3])) {
                    $exclude_bulan[$m] += $nilai;
                }
            }

            $total_semua += $b['jumlah'];

            if ($tahun == 2026 && in_array($b['id_barang'], [1, 2, 3])) {
                $exclude_total += $b['jumlah'];
            }
        }

        // Hitung final bulanan
        $final_bulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $final_bulan[$m] = $tahun == 2026
                ? $total_bulan[$m] - $exclude_bulan[$m]
                : $total_bulan[$m];
        }

        // Mapping nomor bulan ke format tanggal
        $bulan_map = [
            1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06',
            7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12'
        ];

        // Hapus data lama
        $this->db->where('cabang_id', 23);
        $this->db->where('no_per_id', 15.03);
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->delete('rkap_arus_kas');

        // Insert ke tabel rkap_arus_kas
        foreach ($bulan_map as $i => $num) {
            $record = [
                'cabang_id' => 23,
                'no_per_id' => 15.03,
                'bulan'     => "{$tahun}-{$num}-01",
                'pagu'      => $final_bulan[$i] ?? 0
            ];
            $this->db->insert('rkap_arus_kas', $record);
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data pembelian bahan berhasil digenerate ke Arus Kas!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/pembelian_bahan');
    }


    public function daftar_barang()
    {
        $tahun = $this->input->get('tahun_rkap') ?? date('Y') + 1; // default tahun depan
        $data['tahun'] = $tahun;
        $data['barang'] = $this->Model_pembelian_bahan->getAll($tahun);

        $data['title'] = 'Data Barang Sambungan Baru';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pembelian_bahan/view_daftar_barang', $data);
        $this->load->view('templates/footer');
    }

    public function input()
    {
        $data['title'] = 'Input Data Barang Sambungan Baru';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pembelian_bahan/input_daftar_barang', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        $data = [
            'no_per_id'    => $this->input->post('no_per_id'),
            'nama_barang'  => $this->input->post('nama_barang'),
            'pembagi'      => $this->input->post('pembagi'),
            'tahun'        => $this->input->post('tahun'),
            'satuan'       => $this->input->post('satuan'),
        ];

        $this->Model_pembelian_bahan->insert($data);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data barang berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Data Barang Sambungan Baru';
        $data['barang'] = $this->db->get_where('rkap_barang', ['id_barang' => $id])->row();

        if (!$data['barang']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pembelian_bahan/update_daftar_barang', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $id = $this->input->post('id_barang');

        $data = [
            'no_per_id'    => $this->input->post('no_per_id', true),
            'nama_barang'  => $this->input->post('nama_barang', true),
            'pembagi'      => $this->input->post('pembagi', true),
            'satuan'       => $this->input->post('satuan', true),
            'tahun'        => $this->input->post('tahun', true)
        ];

        $this->db->where('id_barang', $id);
        $this->db->update('rkap_barang', $data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data barang berhasil diupdate.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );

        redirect('lembar_kerja/arus_kas/pembelian_bahan/daftar_barang');
    }
}
