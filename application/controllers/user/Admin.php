<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') != 'Admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Daftar User";
        $data['user'] = $this->Model_user->getAll();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user/view_admin', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah User/Admin";
        $data['data_karyawan'] = $this->Model_user->getKaryawan();

        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'required|trim|min_length[3]|is_unique[user.nama_pengguna]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('upk_bagian', 'Nama Bagian / UPK', 'required|trim');
        $this->form_validation->set_rules('tipe', 'Tipe User', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');
        $this->form_validation->set_message('min_length', '%s Minimal 5 karakter');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('user/view_adminTambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_user->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('user/admin');
        }
    }

    public function edit($id)
    {
        $data['title'] = "Form Edit User";
        $data['user'] = $this->db->get_where('user', ['id' => $id])->row();
        $data['data_karyawan'] = $this->Model_user->getKaryawan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('user/view_adminEdit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_user->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('user/admin');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('user/admin');
        }
    }

    public function hapus($id)
    {
        $this->Model_user->hapusData($id);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('user/admin');
    }
}
