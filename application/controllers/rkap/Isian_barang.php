<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Isian_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_isian_barang');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $data['tampil'] = $this->Model_isian_barang->getData();

        $data['title'] = 'USULAN PERMINTAAN BARANG (RKAP) TAHUN ';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/view_isian_barang', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function edit_isian_barang($id_usulanBarang)
    {
        $data['title'] = 'Update Usulan barang';
        $data['isian_barang'] = $this->Model_isian_barang->getIsianBarang($id_usulanBarang);
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/edit_isian_barang', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update()
    {
        $this->Model_isian_barang->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/isian_barang');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data usulan permintaan barang berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/isian_barang');
        }
    }

    // public function update()
    // {
    //     $this->Model_usulan_barang->updateData();
    //     $updated_rows = $this->db->affected_rows();
    //     if ($updated_rows <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Maaf,</strong> tidak ada perubahan data
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //             </button>
    //         </div>'
    //         );
    //         redirect('rkap/usulan_barang');
    //     } else {
    //         // Cek apakah ada file yang diupload
    //         if (!empty($_FILES['foto_ket']['name'])) {
    //             // Lakukan proses upload file
    //             $config['upload_path']   = './uploads/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //             $config['max_size']      = 1000;
    //             $this->load->library('upload', $config);

    //             if ($this->upload->do_upload('foto_ket')) {
    //                 // Mendapatkan nama file lama dari database
    //                 $usulanBarang = $this->Model_usulan_barang->getUsulanBarang($this->input->post('id_usulanBarang'));
    //                 $namaFileLama = $usulanBarang->foto_ket;

    //                 // Lakukan proses upload file baru
    //                 $data_upload = $this->upload->data();
    //                 $data['foto_ket'] = $data_upload['file_name'];
    //                 $data['id_usulanBarang'] = $this->input->post('id_usulanBarang');
    //                 $this->Model_usulan_barang->updateFoto($data);


    //                 // Hapus file lama dari folder "uploads"
    //                 if ($namaFileLama) {
    //                     $fileLamaPath = './uploads/' . $namaFileLama;
    //                     if (file_exists($fileLamaPath)) {
    //                         unlink($fileLamaPath);
    //                     }
    //                 }
    //             } else {
    //                 // Jika proses upload gagal
    //                 $error_msg = $this->upload->display_errors();
    //                 $this->session->set_flashdata('info', $error_msg);
    //                 redirect('rkap/usulan_barang');
    //             }
    //         }

    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Sukses,</strong> Data RKAP berhasil di update
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //             </button>
    //         </div>'
    //         );
    //         redirect('rkap/usulan_barang');
    //     }
    // }

    // Akhir Usulan barang

    // public function hapus_usulan_barang($id_usulanBarang)
    // {
    //     $statusUpdate = $this->Model_usulan_barang->getStatusUpdate('usulan_barang');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di hapus.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/usulan_barang');
    //     } else {
    //         // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
    //         $this->db->select('foto_ket');
    //         $this->db->where('id_usulanBarang', $id_usulanBarang);
    //         $query = $this->db->get('usulan_barang');
    //         $row = $query->row();

    //         // Hapus file jika ada
    //         if ($row && $row->foto_ket) {
    //             $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
    //             if (file_exists($file_path)) {
    //                 unlink($file_path); // Hapus file dari server
    //             }
    //         }

    //         // Hapus data dari database
    //         $this->db->where('id_usulanBarang', $id_usulanBarang);
    //         $this->db->delete('usulan_barang');

    //         redirect('rkap/usulan_barang');
    //     }
    // }
}
