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


    public function rekap_rkap()
    {
        $dataTahun = $this->input->get('tahun') ?? date('Y');
        $this->session->set_userdata('tahun_rkap', $dataTahun);
        $data['title'] = 'ESTIMASI PENDAPATAN DAN BIAYA TAHUN ';
        $data['tahun'] = $dataTahun;

        // biaya usulan
        $data['biayaUsulanBarang'] = $this->Model_rekap_sr->getBiayaUsulanBarang($dataTahun);
        $data['biayaUsulanPemeliharaan'] = $this->Model_rekap_sr->getBiayaUsulanPemeliharaan($dataTahun);
        $data['biayaUsulanInvestasi'] = $this->Model_rekap_sr->getBiayaUsulanInvestasi($dataTahun);
        $data['biayaUsulanUmum'] = $this->Model_rekap_sr->getBiayaUsulanUmum($dataTahun);

        // inisialisasi
        $pendapatan_air = 0;
        $pendapatan_non_air = 0;
        $total_pend_amdk = 0;
        $total_biaya_amdk = 0;

        // pendapatan air & non air
        $tampil = $this->Model_rekap_sr->getDataUpk($dataTahun);
        $totalSr = $this->Model_rekap_sr->getTotalSRUpk();

        $tarif = 67170;
        foreach ($tampil as $row) {
            $pendapatan_air += ($row->plg_aktif + $row->tambah_sr) * $tarif * 12;
            $pendapatan_non_air = $totalSr * 1000000;
        }
        $total_sr_rupiah = $totalSr * $tarif * 12;
        $pendapatan_air_total = $pendapatan_air + $total_sr_rupiah;
        // pendapatan amdk
        $pend_amdk = $this->Model_rekap_sr->getPendAmdk($dataTahun);
        foreach ($pend_amdk as $row) {
            $total_pend_amdk += $row->harga * $row->jumlah;
        }
        // biaya amdk
        $biaya_amdk = $this->Model_rekap_sr->getBiayaAmdk($dataTahun);
        foreach ($biaya_amdk as $row) {
            $total_biaya_amdk += $row->jumlah;
        }
        // simpan ke array
        $data['pendapatan_air'] = $pendapatan_air;
        $data['pendapatan_non_air'] = $pendapatan_non_air;
        $data['total_pend_amdk'] = $total_pend_amdk;
        $data['total_biaya_amdk'] = $total_biaya_amdk;
        $data['total_sr'] = $totalSr;
        $data['total_sr_rupiah'] = $total_sr_rupiah;
        $data['pendapatan_air_total'] = $pendapatan_air_total;

        // total pendapatan & biaya
        $data['total_pendapatan'] = $pendapatan_air_total + $pendapatan_non_air + $total_pend_amdk;
        $data['total_biaya'] = $total_biaya_amdk
            + $data['biayaUsulanBarang']
            + $data['biayaUsulanInvestasi']
            + $data['biayaUsulanPemeliharaan']
            + $data['biayaUsulanUmum'];

        // laba / rugi
        $data['laba_rugi'] = $data['total_pendapatan'] - $data['total_biaya'];

        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_rekap_rkap', $data);
        $this->load->view('templates/footer');
    }


    public function export_pdf_rkap()
    {
        $dataTahun = $this->session->userdata('tahun_rkap') ?? date('Y');
        $data['title'] = 'ESTIMASI PENDAPATAN DAN BIAYA TAHUN ';
        $data['tahun'] = $dataTahun;

        // biaya usulan
        $data['biayaUsulanBarang'] = $this->Model_rekap_sr->getBiayaUsulanBarang($dataTahun);
        $data['biayaUsulanPemeliharaan'] = $this->Model_rekap_sr->getBiayaUsulanPemeliharaan($dataTahun);
        $data['biayaUsulanInvestasi'] = $this->Model_rekap_sr->getBiayaUsulanInvestasi($dataTahun);
        $data['biayaUsulanUmum'] = $this->Model_rekap_sr->getBiayaUsulanUmum($dataTahun);

        // inisialisasi
        $pendapatan_air = 0;
        $pendapatan_non_air = 0;
        $total_pend_amdk = 0;
        $total_biaya_amdk = 0;

        // pendapatan air & non air
        $tampil = $this->Model_rekap_sr->getDataUpk($dataTahun);
        $totalSr = $this->Model_rekap_sr->getTotalSRUpk();

        $tarif = 67170;
        foreach ($tampil as $row) {
            $pendapatan_air += ($row->plg_aktif + $row->tambah_sr) * $tarif * 12;
            $pendapatan_non_air = $totalSr * 1000000;
        }
        $total_sr_rupiah = $totalSr * $tarif * 12;
        $pendapatan_air_total = $pendapatan_air + $total_sr_rupiah;
        // pendapatan amdk
        $pend_amdk = $this->Model_rekap_sr->getPendAmdk($dataTahun);
        foreach ($pend_amdk as $row) {
            $total_pend_amdk += $row->harga * $row->jumlah;
        }
        // biaya amdk
        $biaya_amdk = $this->Model_rekap_sr->getBiayaAmdk($dataTahun);
        foreach ($biaya_amdk as $row) {
            $total_biaya_amdk += $row->jumlah;
        }
        // simpan ke array
        $data['pendapatan_air'] = $pendapatan_air;
        $data['pendapatan_non_air'] = $pendapatan_non_air;
        $data['total_pend_amdk'] = $total_pend_amdk;
        $data['total_biaya_amdk'] = $total_biaya_amdk;
        $data['total_sr'] = $totalSr;
        $data['total_sr_rupiah'] = $total_sr_rupiah;
        $data['pendapatan_air_total'] = $pendapatan_air_total;

        // total pendapatan & biaya
        $data['total_pendapatan'] = $pendapatan_air_total + $pendapatan_non_air + $total_pend_amdk;
        $data['total_biaya'] = $total_biaya_amdk
            + $data['biayaUsulanBarang']
            + $data['biayaUsulanInvestasi']
            + $data['biayaUsulanPemeliharaan']
            + $data['biayaUsulanUmum'];

        // laba / rugi
        $data['laba_rugi'] = $data['total_pendapatan'] - $data['total_biaya'];

        $this->pdf->setPaper('Folio', 'portrait');
        $this->pdf->filename = "rekap_rkap-{$dataTahun}.pdf";
        $this->pdf->generate('admin/laporan_rekap_rkap_pdf', $data);
    }
}
