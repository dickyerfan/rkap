<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_produksi_amdk');
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

        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PRODUKSI UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/view_produksi', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PRODUKSI UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_produksi_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/laporan_pdf', $data);
    }


    public function tambah()
    {
        if ($this->input->post()) {
            $id_produk = $this->input->post('id_produk');
            $tahun = $this->input->post('tahun_rkap');
            $jumlah = $this->input->post('jumlah_produksi');

            // Panggil fungsi insert di model dan simpan hasilnya ke variabel
            $hasil = $this->Model_produksi_amdk->insertProduksi($id_produk, $tahun, $jumlah);

            if (!$hasil) {
                // Jika sudah ada data
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data untuk produk dan tahun ini sudah ada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                );
                redirect('lembar_kerja/rkap_amdk/produksi');
                return; // hentikan eksekusi
            }

            // Jika berhasil insert
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data produksi AMDK berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
        } else {
            $data['produk'] = $this->db->get('rkap_amdk_produk')->result();
            $data['title'] = 'Input Data Produksi AMDK';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/upload_produksi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit($id_produk, $tahun)
    {
        // Ambil data produksi 12 bulan untuk produk & tahun ini
        $data['produksi'] = $this->Model_produksi_amdk->getProduksiByProdukTahun($id_produk, $tahun);

        if (!$data['produksi']) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data tidak ditemukan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
        }

        $data['produk'] = $this->db->get_where('rkap_amdk_produk', ['id_produk' => $id_produk])->row();
        $data['tahun_rkap'] = $tahun;
        $data['title'] = 'Edit Data Produksi AMDK';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/edit_produksi', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $id_produk = $this->input->post('id_produk');
        $tahun = $this->input->post('tahun_rkap');
        $jumlah = $this->input->post('jumlah_produksi');
        $ptgs_update = $this->session->userdata('nama_lengkap'); // array dari input form

        $this->Model_produksi_amdk->updateProduksi($id_produk, $tahun, $jumlah, $ptgs_update);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data produksi AMDK berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
    }
}
