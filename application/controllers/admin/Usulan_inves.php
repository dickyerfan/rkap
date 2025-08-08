<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_inves extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_inves');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $dataUpk = $this->input->post('bagian_upk');
        $dataTahun = $this->input->post('tahun_rkap');
        $data['namaUpk'] = $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['tampil'] = $this->Model_usulan_inves->getDataUpk($dataUpk, $dataTahun);
        $data['seleksi'] = $this->Model_usulan_inves->getNamaUpk($dataUpk, $dataTahun);
        $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_inves/view_usulan_investasi', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $dataUpk = $this->input->post('bagian_upk');
        $dataTahun = $this->input->post('tahun_rkap');
        $data['namaUpk'] = $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['tampil'] = $this->Model_usulan_inves->getDataUpk($dataUpk, $dataTahun);
        $data['seleksi'] = $this->Model_usulan_inves->getNamaUpk($dataUpk, $dataTahun);
        $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Evaluasi Upk-{$dataUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/usulan_inves/laporan_pdf', $data);
    }

    public function edit_usulan_investasi($id_usulanInvestasi)
    {
        $data['title'] = 'Update Usulan Investasi';
        $statusUpdate = $this->Model_usulan_inves->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_inves');
        } else {
            $data['usulan_investasi'] = $this->Model_usulan_inves->getUsulanInves($id_usulanInvestasi);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_inves/edit_usulan_investasi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update()
    {
        $this->Model_usulan_inves->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/usulan_inves');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/usulan_inves');
        }
    }

    public function hapus_usulan_investasi($id_usulanInvestasi)
    {
        $statusUpdate = $this->Model_usulan_inves->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_inves');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $query = $this->db->get('usulan_investasi');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $this->db->delete('usulan_investasi');

            redirect('admin/usulan_inves');
        }
    }

    public function detail_usulan_investasi($id_usulanInvestasi)
    {
        $data['title'] = 'Detail Usulan Investasi';
        $data['usulan_investasi'] = $this->db->get_where('usulan_investasi', ['id_usulanInvestasi' => $id_usulanInvestasi])->row();

        if (!$data['usulan_investasi']) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> Data tidak ditemukan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('admin/usulan_investasi');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_inves/detail_usulan_investasi', $data);
        $this->load->view('templates/footer');
    }
}
