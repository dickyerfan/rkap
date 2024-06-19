<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_dashboard');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['title'] = 'Kontak';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('view_kontak', $data);
        $this->load->view('templates/publik/footer');
    }

    public function kontak()
    {
        $data['title'] = 'Kontak';
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('komentar', 'Komentar', 'required|trim');
        $this->form_validation->set_message('required', '%s harus di isi');
        $this->form_validation->set_message('valid_email', '%s harus sesuai format email');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/publik/header', $data);
            $this->load->view('view_kontak', $data);
            $this->load->view('templates/publik/footer');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Komentar Berhasil di simpan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            $data['kontak'] = $this->model_dashboard->tambahData();
            redirect('fitur/kontak');
        }
    }

    public function komentar()
    {

        $data['title'] = 'Daftar Komentar';
        $data['komentar'] = $this->model_dashboard->getKomentar();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('view_komentar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('view_komentar', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function jadwalSholat()
    {

        $data['title'] = 'Jadwal Sholat';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('view_jadwalSholat', $data);
        $this->load->view('templates/publik/footer');
    }


    public function uploadEbooks()
    {

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 10000;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('nama_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            $data['title'] = 'Upload Ebook';
            $this->load->view('templates/publik/header', $data);
            $this->load->view('view_uploadEbooks', $data);
            $this->load->view('templates/publik/footer');
        } else {
            $data['nama_file'] = $this->upload->data("file_name");
            $data['nama_ebook'] = $this->input->post('nama_ebook');
            $data['penulis'] = $this->input->post('penulis');
            $data['keterangan'] = $this->input->post('keterangan');
            $this->db->insert('ebook', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert" style="width:50%;">
                  <strong>Sukses,</strong> Data Ebook berhasil di tambahkan
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                </div>'
            );
            redirect('fitur/ebook');
        }
    }

    public function downloadEbooks($id_ebook)
    {
        $data = $this->db->get_where('ebook', ['id_ebook' => $id_ebook])->row();
        force_download('uploads/' . $data->nama_file, null);
    }


    public function ebook()
    {
        $data['title'] = 'Daftar Ebook Kitab';
        $data['ebook'] = $this->db->get('ebook')->result();
        $this->load->view('templates/publik/header', $data);
        $this->load->view('view_ebook', $data);
        $this->load->view('templates/publik/footer');
    }

    public function bacaEbook($id_ebook)
    {
        $data = $this->db->get_where('ebook', ['id_ebook' => $id_ebook])->row();
        header("content-type: application/pdf");
        readfile('uploads/' . $data->nama_file);
    }

    public function editEbook($id_ebook)
    {
        $data['ebook'] = $this->db->get_where('ebook', ['id_ebook' => $id_ebook])->row();
        $data['title'] = 'Form Edit Ebook';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('view_ebookEdit', $data);
        $this->load->view('templates/publik/footer');
    }

    public function update()
    {
        $data = [
            'nama_ebook' => $this->input->post('nama_ebook'),
            'penulis' => $this->input->post('penulis'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->db->where('id_ebook', $this->input->post('id_ebook'));
        $this->db->update('ebook', $data);

        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
                  <strong>Maaf,</strong> tidak ada perubahan data
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                </div>'
            );
            redirect('fitur/ebook');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:50%;">
                <strong>Sukses,</strong> Data Ebook berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            redirect('fitur/ebook');
        }
    }

    public function hapusEbook($id_ebook)
    {
        $cekFileLama = $this->db->get_where('ebook', ['id_ebook' => $id_ebook])->row();

        if (isset($cekFileLama->nama_file)) {
            unlink('uploads/' . $cekFileLama->nama_file);
        }

        $this->db->where('id_ebook', $id_ebook);
        $this->db->delete('ebook');

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
            <strong>Sukses,</strong> Data Ebook berhasil di hapus
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>'
        );
        redirect('fitur/ebook');
    }
}
