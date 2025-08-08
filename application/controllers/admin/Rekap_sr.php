<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_sr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_rekap_sr');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $this->session->set_userdata('tahun', $tahun);
        $data['title'] = 'REKAPITULASI POTENSI SR PER UPK TAHUN ';
        $data['tahun'] = $tahun;
        $data['rekap_sr'] = $this->Model_rekap_sr->getRekapSR($tahun);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_rekap_sr', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $tahun = $this->session->userdata('tahun') ?? date('Y');
        $data['title'] = 'REKAPITULASI POTENSI SR PER UPK TAHUN ';
        $data['tahun'] = $tahun;
        $data['rekap_sr'] = $this->Model_rekap_sr->getRekapSR($tahun);

        $this->pdf->setPaper('Folio', 'portrait');
        $this->pdf->filename = "rekap_sr-{$tahun}.pdf";
        $this->pdf->generate('admin/laporan_rekap_sr_pdf', $data);
    }
}
