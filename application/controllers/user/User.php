<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_user');
        $this->load->library('form_validation');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Daftar Pengguna";
        $data['user'] = $this->model_user->getAllUser();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user/view_user', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $data['title'] = "Form Edit User";
        $data['user'] = $this->db->get_where('user', ['id' => $id])->row();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user/view_userEdit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->model_user->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('dashboard');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:50%;">
                        <strong>Sukses,</strong> Data berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('user/user');
        }
    }

    public function hapus($id)
    {
        $this->model_user->hapusData($id);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
                    <strong>Sukses,</strong> Data berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('user/user');
    }
}
