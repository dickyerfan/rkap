<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rkap_admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_status');

        if (
            $this->session->userdata('tipe') != 'admin' &&
            $this->session->userdata('level') != 'administrator'
        ) {
            $this->session->set_flashdata('info', 'Anda tidak memiliki hak akses.');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['status'] = $this->Model_status->get_all();
        $data['title'] = 'STATUS PERIODE APLIKASI ';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('rkap_admin/view_admin', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $tahun = date('Y') + 1;
        $status = $this->input->post('status_periode');
        $this->Model_status->update_status_periode($tahun, $status);
        $this->session->set_flashdata(
            'info',
            '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Status periode berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('rkap_admin');
    }
}
