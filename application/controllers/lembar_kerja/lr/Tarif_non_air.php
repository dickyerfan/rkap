<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarif_non_air extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_tarif_non_air');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['title'] = 'Data Tarif Pendapatan Non Air';
        $data['tarif_grouped'] = $this->Model_tarif_non_air->get_tarif_grouped($tahun);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_non_air/view_tarif_non_air', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id = null)
    {
        $row = $this->Model_tarif_non_air->get_tarif_by_id($id);
        if (!$row) {
            show_404();
        }

        $tahun_sekarang = date('Y');
        if ($row->tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data tarif tahun ' . $row->tahun . ' tidak boleh diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $row->tahun);
        }

        $data['row'] = $row;
        $data['title'] = 'Edit Tarif Non Air';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_non_air/edit_tarif_non_air', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $nilai = $this->input->post('nilai');

        $row = $this->Model_tarif_non_air->get_tarif_by_id($id);
        if (!$row) {
            show_404();
        }

        $tahun_sekarang = date('Y');
        if ($row->tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data tahun ' . $row->tahun . ' tidak bisa diupdate.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $row->tahun);
        }

        $this->Model_tarif_non_air->update_tarif($id, str_replace(',', '.', $nilai));

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil,</strong> Data tarif berhasil diupdate.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );

        redirect('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $row->tahun);
    }

    public function duplicate_next_year()
    {
        $tahun_asal   = $this->input->get('tahun_asal');
        $tahun_tujuan = $tahun_asal + 1;

        $result = $this->Model_tarif_non_air->duplicate($tahun_asal, $tahun_tujuan);

        if ($result === true) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data tarif non air tahun ' . $tahun_asal . ' berhasil disalin ke tahun ' . $tahun_tujuan . '.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
        } elseif ($result === 'exist') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Data tarif non air tahun ' . $tahun_tujuan . ' sudah ada. Tidak Bisa Duplikasi Data.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Tidak ada data di tahun ' . $tahun_asal . ' untuk disalin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
        }
        redirect('lembar_kerja/lr/tarif_non_air?tahun_rkap=' . $tahun_tujuan);
    }
}
