<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permasalahan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_permasalahan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $bagian_upk = $this->input->get('bagian_upk');
        $tahun_rkap = $this->input->get('tahun_rkap') ?: date('Y');

        // Simpan ke session
        $this->session->set_userdata('bagian_upk', $bagian_upk ?: 'SEMUA');
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);


        $data['tampil'] = $this->Model_permasalahan->getFiltered($bagian_upk, $tahun_rkap);
        $data['bagian_upk'] = $bagian_upk;
        $data['tahun'] = $tahun_rkap;
        $data['title'] = 'PERMASALAHAN YANG PERLU DITINDAK LANJUTI TAHUN ';
        $data['namaUpk'] = $bagian_upk ? $bagian_upk : 'SEMUA';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/permasalahan/view_permasalahan', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $dataUpk   = $this->session->userdata('bagian_upk');
        $dataTahun = $this->session->userdata('tahun_rkap') ?: date('Y');

        // Cukup satu panggilan
        $data['tampil']  = $this->Model_permasalahan->getFiltered($dataUpk, $dataTahun);
        $data['namaUpk'] = (empty($dataUpk) || $dataUpk === 'SEMUA') ? 'SEMUA' : $dataUpk;
        $data['tahun']   = $dataTahun;
        $data['title'] = 'PERMASALAHAN YANG PERLU DITINDAK LANJUTI TAHUN ';

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $safeUpk = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['namaUpk']);
        $this->pdf->filename = "Evaluasi Upk-{$safeUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/permasalahan/laporan_pdf', $data);
    }

    // Awal permasalahan
    public function upload()
    {

        $statusUpload = $this->Model_permasalahan->getStatusUpload('permasalahan');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/permasalahan');
        } else {

            $this->form_validation->set_rules('sub_bagian', 'Sub bagian', 'trim');
            $this->form_validation->set_rules('permasalahan', 'Permasalahan', 'required|trim');
            $this->form_validation->set_rules('penyebab', 'Penyebab', 'required|trim');
            $this->form_validation->set_rules('tindak_lanjut', 'Tindak Lanjut', 'required|trim');
            $this->form_validation->set_message('required', '%s masih kosong');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Usulan Permintaan Barang';
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/permasalahan/upload_permasalahan', $data);
                $this->load->view('templates/pengguna/footer');
            } else {

                $data['tahun_rkap'] = (int) $this->input->post('tahun_rkap', true);
                $data['sub_bagian'] = $this->input->post('sub_bagian', true);
                $data['permasalahan'] = $this->input->post('permasalahan', true);
                $data['penyebab'] = $this->input->post('penyebab', true);
                $data['tindak_lanjut'] = $this->input->post('tindak_lanjut', true);
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('permasalahan', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data permasalahan berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/permasalahan');
            }
        }
    }

    public function edit_permasalahan($id_permasalahan)
    {
        $data['title'] = 'Update Usulan barang';
        $statusUpdate = $this->Model_permasalahan->getStatusUpdate('permasalahan');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/permasalahan');
        } else {
            $data['permasalahan'] = $this->Model_permasalahan->getPermasalahan($id_permasalahan);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/permasalahan/edit_permasalahan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->Model_permasalahan->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/permasalahan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Permasalahan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/permasalahan');
        }
    }

    public function hapus_usulan_barang($id_permasalahan)
    {
        $statusUpdate = $this->Model_permasalahan->getStatusUpdate('permasalahan');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/permasalahan');
        } else {

            // Hapus data dari database
            $this->db->where('id_permasalahan', $id_permasalahan);
            $this->db->delete('permasalahan');

            redirect('rkap/permasalahan');
        }
    }
}
