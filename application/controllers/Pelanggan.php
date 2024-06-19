<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_dashboard');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Tarif Air Minum';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('pelanggan/view_TarifAirMinum', $data);
        $this->load->view('templates/publik/footer');
    }

    public function biayaPasangBaru()
    {
        $data['title'] = 'Biaya Pasang Baru';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('pelanggan/view_BiayaPasangBaru', $data);
        $this->load->view('templates/publik/footer');
    }

    public function denda()
    {
        $data['title'] = 'Denda - Pelanggaran';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('pelanggan/view_Denda', $data);
        $this->load->view('templates/publik/footer');
    }

    public function pengaduanPelanggan()
    {
        $this->form_validation->set_rules('no_pel', 'No Pelanggan', 'required|trim|numeric');
        $this->form_validation->set_rules('nama_pel', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_tel', 'No Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('jenis_aduan', 'Jenis Pengaduan', 'required|trim');
        $this->form_validation->set_rules('wil_layanan', 'Wilayah Pelayanan', 'required|trim');
        $this->form_validation->set_rules('isi_aduan', 'Isi Pengaduan', 'required|trim');
        $this->form_validation->set_message('required', '%s harus di isi');
        $this->form_validation->set_message('numeric', '%s harus di isi angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Pengaduan Pelanggan';
            $this->load->view('templates/publik/header', $data);
            $this->load->view('pelanggan/view_PengaduanPelanggan', $data);
            $this->load->view('templates/publik/footer');
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['foto_aduan']['name'])) {
                // Lakukan proses upload file
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['max_size']      = 1000;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('foto_aduan')) {
                    $data_upload = $this->upload->data();
                    $data['foto_aduan'] = $data_upload['file_name'];
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('pelanggan/pengaduanPelanggan');
                }
            }

            // Isi data selain file yang diupload
            $data['no_pel'] = $this->input->post('no_pel', true);
            $data['nama_pel'] = $this->input->post('nama_pel', true);
            $data['alamat'] = $this->input->post('alamat', true);
            $data['no_tel'] = $this->input->post('no_tel', true);
            $data['jenis_aduan'] = $this->input->post('jenis_aduan', true);
            $data['wil_layanan'] = $this->input->post('wil_layanan', true);
            $data['isi_aduan'] = $this->input->post('isi_aduan', true);
            $data['tgl_aduan'] = date('Y-m-d H:i:s', true);

            // Simpan data ke dalam database
            $this->db->insert('pengaduan', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                  <strong>Terima kasih,</strong> Data Pengaduan berhasil di simpan, akan kami tindak lanjuti secepatnya.
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                </div>'
            );

            redirect('pelanggan/pengaduanPelanggan');
        }
    }

    public function tangkiAir()
    {
        $data['title'] = 'Tangki Air';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('pelanggan/view_TangkiAir', $data);
        $this->load->view('templates/publik/footer');
    }

    public function gantiNama()
    {
        $data['title'] = 'Prosedur Ganti Nama';
        $this->load->view('templates/publik/header', $data);
        $this->load->view('pelanggan/view_GantiNama', $data);
        $this->load->view('templates/publik/footer');
    }
}
