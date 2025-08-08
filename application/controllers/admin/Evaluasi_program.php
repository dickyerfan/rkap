<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluasi_program extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_evaluasi_program');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $bagian = $this->input->post('bagian');
        $dataTahun = $this->input->post('tahun_rkap');
        // Set session
        $this->session->set_userdata('bagian', $bagian);
        $this->session->set_userdata('tahun_rkap', $dataTahun);
        $data['bagian'] = $bagian;
        $data['tahun'] = $dataTahun;
        $data['tampil'] = $this->Model_evaluasi_program->getData_admin($bagian, $dataTahun);
        $data['title'] = 'EVALUASI & PROGRAM (RKAP) TAHUN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/evaluasi_program/view_evaluasi_program', $data);
        $this->load->view('templates/footer');
    }

    public function edit_evaluasi_program($id_evaluasi_program)
    {
        $data['title'] = 'Update Usulan barang';
        $statusUpdate = $this->Model_evaluasi_program->getStatusUpdate('evaluasi_program');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_program');
        } else {
            $data['evaluasi_program'] = $this->Model_evaluasi_program->getEvaluasi_program($id_evaluasi_program);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/evaluasi_program/edit_evaluasi_program', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update()
    {
        $this->Model_evaluasi_program->updateData();
        $updated_rows = $this->db->affected_rows();
        if ($updated_rows <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> tidak ada perubahan data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('admin/evaluasi_program');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> Data Evaluasi & Program berhasil di update
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>'
            );
            redirect('admin/evaluasi_program');
        }
    }

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

    public function export_pdf()
    {
        $bagian = $this->session->userdata('bagian');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['bagian'] = $bagian;
        $data['tahun'] = $tahun;
        $data['tampil'] = $this->Model_evaluasi_program->getData_admin($bagian, $tahun);
        $data['title'] = 'EVALUASI & PROGRAM (RKAP) TAHUN ' . $tahun;

        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "evaluasi_program-{$bagian}-{$tahun}.pdf";
        $this->pdf->generate('admin/evaluasi_program/laporan_pdf', $data);
    }
}
