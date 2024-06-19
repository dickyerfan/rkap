<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaduan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pengaduan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('publik');
        }
    }
    public function index()
    {

        $data['title'] = 'Daftar Pengaduan Pelanggan';
        $data['pengaduan'] = $this->model_pengaduan->getPengaduan();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('view_pengaduan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('view_pengaduan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }
}
