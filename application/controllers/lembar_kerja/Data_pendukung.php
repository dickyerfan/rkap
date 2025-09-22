<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_pendukung extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_data_pendukung');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Jasa Pemeliharaan & Jasa Administrasi';
        $data['jasa_tambahan'] = $this->Model_data_pendukung->get_jasa_tambahan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/data_pendukung/view_data_pendukung', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Input Jasa Pemeliharaan & Jasa Administrasi';
        $data['upk']   = $this->db->get('rkap_nama_upk')->result();
        $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/data_pendukung/upload_jasa_tambahan', $data);
        $this->load->view('templates/footer');
    }

    public function pola_konsumsi_tarif()
    {
        $data['title'] = 'Data Pola Konsumsi';
        $data['title2'] = 'Data Tarif Rata-rata';
        $data['pola_konsumsi'] = $this->Model_data_pendukung->get_pola_konsumsi();
        $data['tarif_rata']   = $this->Model_data_pendukung->get_tarif_rata();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/data_pendukung/view_pola_konsumsi_tarif', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_pola()
    {
        $data['title'] = 'Input Pola Konsumsi';
        $data['upk']   = $this->db->get('rkap_nama_upk')->result();
        $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/data_pendukung/upload_pola_konsumsi', $data);
        $this->load->view('templates/footer');
    }
    public function tambah_tarif()
    {
        $data['title'] = 'Input Tarif Rata-rata';
        $data['upk']   = $this->db->get('rkap_nama_upk')->result();
        $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/data_pendukung/upload_tarif_rata', $data);
        $this->load->view('templates/footer');
    }

    public function save_tarif_rata()
    {
        $data = [
            'id_upk'     => $this->input->post('id_upk'),
            'id_jp'      => $this->input->post('id_jp'),
            'tahun'      => $this->input->post('tahun'),
            'tarif_rata' => $this->input->post('tarif_rata')
        ];

        $this->Model_data_pendukung->insert_tarif_rata($data);
        $this->session->set_flashdata('info', 'Data Tarif Rata-rata berhasil disimpan');
        redirect('lembar_kerja/data_pendukung/pola_konsumsi_tarif');
    }

    public function save_pola_konsumsi()
    {
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'konsumsi_rata' => $this->input->post('konsumsi_rata')
        ];

        $this->Model_data_pendukung->insert_pola_konsumsi($data);
        $this->session->set_flashdata('info', 'Data Pola Konsumsi berhasil disimpan');
        redirect('lembar_kerja/data_pendukung/pola_konsumsi_tarif');
    }

    public function save_jasa_tambahan()
    {
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'jasa_admin'    => $this->input->post('jasa_admin'),
            'jasa_pemeliharaan' => $this->input->post('jasa_pemeliharaan')
        ];

        $this->Model_data_pendukung->insert_jasa_tambahan($data);
        $this->session->set_flashdata('info', 'Data Jasa Tambahan berhasil disimpan');
        redirect('lembar_kerja/data_pendukung');
    }
}
