<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluasi_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_evaluasi_amdk');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $dataTahun = $this->input->post('tahun_rkap') ? $this->input->post('tahun_rkap') : date('Y');
        $data['tahun'] = $dataTahun;
        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';
        $data['tenaga_kerja'] = $this->Model_evaluasi_amdk->getTenagaKerjaAmdk($dataTahun);
        $data['piutang_usaha'] = $this->Model_evaluasi_amdk->getPiutangUsahaAmdk($dataTahun);
        $data['pendapatan_usaha'] = $this->Model_evaluasi_amdk->getPendapatanUsahaAmdk($dataTahun);
        $data['statusEvaluasiAmdk'] = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
        $data['target'] = $this->Model_evaluasi_amdk->getTargetAmdk($dataTahun);
        $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getUsulanAdminAmdk($dataTahun);
        $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getUsulanTeknikAmdk($dataTahun);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/evaluasi_amdk/view_evaluasi_amdk', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $dataTahun = $this->input->post('tahun_rkap');
        $data['tahun'] = $dataTahun;
        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';
        $data['tenaga_kerja'] = $this->Model_evaluasi_amdk->getTenagaKerjaAmdk($dataTahun);
        $data['piutang_usaha'] = $this->Model_evaluasi_amdk->getPiutangUsahaAmdk($dataTahun);
        $data['pendapatan_usaha'] = $this->Model_evaluasi_amdk->getPendapatanUsahaAmdk($dataTahun);
        $data['statusEvaluasiAmdk'] = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
        $data['target'] = $this->Model_evaluasi_amdk->getTargetAmdk($dataTahun);
        $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getUsulanAdminAmdk($dataTahun);
        $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getUsulanTeknikAmdk($dataTahun);


        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahunCetak = date('Y');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Evaluasi Amdk-{$upk_bagian}-{$tahunCetak}.pdf";
        $this->pdf->generate('admin/evaluasi_amdk/laporan_pdf', $data);
    }
}
