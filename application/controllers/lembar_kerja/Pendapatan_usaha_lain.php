<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_usaha_lain extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_usaha_lain');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y');
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        if ($upk) {
            $result = $this->Model_pendapatan_usaha_lain->getDataPendapatanUsahaLain($tahun, $upk);
            $data['data_pendapatan_air'] = $result['data'];
            $nama_upk = $result['nama_upk'];
            $data['title'] = 'RENCANA PENDAPATAN USAHA LAINNYA UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $result = $this->Model_pendapatan_usaha_lain->getDataPendapatanUsahaLain($tahun);
            $data['data_pendapatan_air'] = $result['data'];
            $data['title'] = 'RENCANA PENDAPATAN USAHA LAINNYA (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/pendapatan_usaha_lain/view_pendapatan_usaha_lain', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['upk']   = $upk;
        $data['tahun'] = $tahun;

        if ($upk) {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
            $data['data_pendapatan_air'] = $result['data'];
            $data['total'] = $result['total'];
            $nama_upk = $result['nama_upk'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['data_pendapatan_air'] = $result['data'];
            $data['total'] = $result['total'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/pendapatan_air/laporan_pdf', $data);
    }
}
