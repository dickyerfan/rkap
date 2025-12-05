<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_na extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_amdk');
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

        $data['pendapatan'] = $this->Model_pendapatan_amdk->get_pendapatan_na($tahun);
        $data['title'] = 'RENCANA PENDAPATAN NON AIR UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/pendapatan/view_pendapatan_na', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['pendapatan'] = $this->Model_pendapatan_amdk->get_pendapatan_na($tahun);
        $data['title'] = 'RENCANA PENDAPATAN NON AIR UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_NA_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/pendapatan/laporan_na_pdf', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Input Pendapatan Non Air AMDK';

        $data['no_per_galon']   = $this->db->like('kode', '88.02.07', 'after')->get('no_per')->result();
        $data['no_per_lainnya'] = $this->db->like('kode', '88.02.08', 'after')->get('no_per')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/pendapatan/upload_pendapatan_na', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        $tahun   = $this->input->post('tahun');
        $bulan   = $this->input->post('bulan');
        $jenis   = $this->input->post('jenis');
        $kode    = $this->input->post('kode');
        $pagu    = $this->input->post('pagu');

        $this->Model_pendapatan_amdk->save($tahun, $kode, $pagu);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Pendapatan Non Air AMDK berhasil di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/rkap_amdk/pendapatan_na');
    }
}
