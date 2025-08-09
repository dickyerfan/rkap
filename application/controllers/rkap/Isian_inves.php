<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Isian_inves extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_isian_inves');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $data['tampil'] = $this->Model_isian_inves->getData();

        $data['title'] = 'USULAN PERMINTAAN INVESTASI (RKAP) TAHUN ';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/view_isian_inves', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function edit_isian_inves($id_usulanInves)
    {
        $data['title'] = 'Update Usulan barang';
        $data['isian_inves'] = $this->Model_isian_inves->getIsianInves($id_usulanInves);
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/edit_isian_inves', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update()
    {
        $this->Model_isian_inves->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/isian_inves');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data usulan permintaan barang berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/isian_inves');
        }
    }
}
