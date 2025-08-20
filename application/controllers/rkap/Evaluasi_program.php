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
        $data['tampil'] = $this->Model_evaluasi_program->getData();
        $data['usulan'] = $this->Model_evaluasi_program->getData_usulan();
        $data['title'] = 'EVALUASI RKAP TAHUN ';
        $data['title2'] = 'USULAN PROGRAM RKAP TAHUN ';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/evaluasi_program/view_evaluasi_program', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function export_pdf()
    {
        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahun = date('Y');
        $data['tampil'] = $this->Model_evaluasi_program->getData();
        $data['usulan'] = $this->Model_evaluasi_program->getData_usulan();
        $data['title'] = 'EVALUASI RKAP TAHUN ';
        $data['title2'] = 'USULAN PROGRAM RKAP TAHUN ';
        $data['tahun'] = $tahun;
        $data['upk_bagian'] = $upk_bagian;

        $this->pdf->setPaper('folio', 'portrait');
        $this->pdf->filename = "evaluasi_program-{$upk_bagian}-{$tahun}.pdf";
        $this->pdf->generate('rkap/evaluasi_program/laporan_pdf', $data);
    }

    // Awal Usulan barang
    public function upload()
    {

        $statusUpload = $this->Model_evaluasi_program->getStatusUpload('evaluasi_program');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_program');
        } else {

            $this->form_validation->set_rules('evaluasi', 'Evaluasi', 'required|trim');
            $this->form_validation->set_rules('tindak_lanjut', 'Tindak Lanjut', 'required|trim');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Evaluasi & Program';
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_program/upload_evaluasi_program', $data);
                $this->load->view('templates/pengguna/footer');
            } else {

                $data['tahun_rkap'] = (int) $this->input->post('tahun_rkap', true);
                $data['evaluasi'] = $this->input->post('evaluasi', true);
                $data['tindak_lanjut'] = $this->input->post('tindak_lanjut', true);
                $data['keterangan'] = $this->input->post('keterangan', true);
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('evaluasi_program', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Evaluasi & Program berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/evaluasi_program');
            }
        }
    }
    public function upload_usulan()
    {

        $statusUpload = $this->Model_evaluasi_program->getStatusUpload('evaluasi_program');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_program');
        } else {

            $this->form_validation->set_rules('usulan', 'Usulan', 'required|trim');
            $this->form_validation->set_rules('solusi', 'Solusi', 'required|trim');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Evaluasi & Program';
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_program/upload_usulan', $data);
                $this->load->view('templates/pengguna/footer');
            } else {

                $data['tahun_rkap'] = (int) $this->input->post('tahun_rkap', true);
                $data['usulan'] = $this->input->post('usulan', true);
                $data['solusi'] = $this->input->post('solusi', true);
                $data['keterangan'] = $this->input->post('keterangan', true);
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('evaluasi_usulan', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan Program berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/evaluasi_program');
            }
        }
    }

    public function edit_evaluasi_program($id_evaluasi_program)
    {
        $data['title'] = 'Update Evaluasi & Usulan Program';
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
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_program/edit_evaluasi_program', $data);
            $this->load->view('templates/pengguna/footer');
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
            redirect('rkap/evaluasi_program');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> Data Evaluasi & Program berhasil di update
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>'
            );
            redirect('rkap/evaluasi_program');
        }
    }

    public function edit_usulan_program($id_usulan)
    {
        $data['title'] = 'Update Evaluasi & Usulan Program';
        $statusUpdate = $this->Model_evaluasi_program->getStatusUpdate('evaluasi_usulan');
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
            $data['evaluasi_usulan'] = $this->Model_evaluasi_program->getEvaluasi_usulan($id_usulan);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_program/edit_usulan_program', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_usulan()
    {
        $this->Model_evaluasi_program->updateData_usulan();
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
            redirect('rkap/evaluasi_program');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> Data Usulan Program berhasil di update
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>'
            );
            redirect('rkap/evaluasi_program');
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
}
