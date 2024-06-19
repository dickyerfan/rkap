<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_dashboard');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['upks'] = [
            ['name' => 'UPK Bondowoso'],
            ['name' => 'UPK Sukosari 1'],
            ['name' => 'UPK Maesan'],
            ['name' => 'UPK Tegalampel'],
            ['name' => 'UPK Tapen'],
            ['name' => 'UPK Prajekan'],
            ['name' => 'UPK Tlogosari'],
            ['name' => 'UPK Wringin'],
            ['name' => 'UPK Curahdami'],
            ['name' => 'UPK Tamanan'],
            ['name' => 'UPK Tenggarang'],
            ['name' => 'UPK Tamankrocok'],
            ['name' => 'UPK Wonosari'],
            ['name' => 'UPK Sukosari 2']
        ];

        $data['title'] = 'Cakupan Layanan';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('layanan/view_layanan', $data);
        $this->load->view('templates/publik/footer');
    }

    public function sumberAirBaku()
    {
        $data['title'] = 'Sumber Air Baku';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('layanan/view_Sab', $data);
        $this->load->view('templates/publik/footer');
    }

    public function infoPelayanan()
    {
        $data['title'] = 'Info Pelayanan';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('layanan/view_InfoPelayanan', $data);
        $this->load->view('templates/publik/footer');
    }

    public function kapasitasProduksi()
    {
        $data['title'] = 'Kapasitas Produksi';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('layanan/view_KapasitasProduksi', $data);
        $this->load->view('templates/publik/footer');
    }
    public function informasiTeknis()
    {
        $data['title'] = 'Informasi Teknis';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('layanan/view_InformasiTeknis', $data);
        $this->load->view('templates/publik/footer');
    }
}
