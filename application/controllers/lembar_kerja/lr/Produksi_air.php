<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi_air extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_produksi_air');
        $this->load->model('Model_pendapatan_air');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $result = $this->Model_produksi_air->getDataProduksiAir($tahun, $upk);

        $data['air_terjual'] = $result['air_terjual'];
        $data['air_produksi'] = $result['air_produksi'];
        $nama_upk = $result['nama_upk'];

        if ($upk) {
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR UPK ' . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
        } else {
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/produksi_air/view_produksi_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $result = $this->Model_produksi_air->getDataProduksiAir($tahun, $upk);

        $data['air_terjual'] = $result['air_terjual'];
        $data['air_produksi'] = $result['air_produksi'];
        $nama_upk = $result['nama_upk'];

        if ($upk) {
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR UPK ' . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
        } else {
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_produksi_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/produksi_air/laporan_pdf', $data);
    }

    public function data_sumber()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Data Pemakaian Listrik Sumber';
        $data['sumber'] = $this->Model_produksi_air->getDataSumber($tahun, $upk);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/produksi_air/view_data_sumber', $data);
        $this->load->view('templates/footer');
    }

    public function input()
    {
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Tambah Data Biaya Listrik Sumber';

        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        $this->form_validation->set_rules('id_upk', 'UPK', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/upload_data_sumber', $data);
            $this->load->view('templates/footer');
        } else {
            $insert_data = [
                'id_upk' => $this->input->post('id_upk'),
                'uraian' => $this->input->post('uraian'),
                'nilai'  => $this->input->post('nilai'),
                'tahun'  => $this->input->post('tahun'),
            ];
            $this->db->insert('rkap_sumber', $insert_data);
            $this->session->set_flashdata(
                'info',
                '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Data Pemakaian Listrik Sumber berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
        }
    }

    public function edit_sumber($id_sb)
    {
        $data['sumber'] = $this->db->get_where('rkap_sumber', ['id_sb' => $id_sb])->row_array();
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Edit Data Biaya Listrik Sumber';

        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        $this->form_validation->set_rules('id_upk', 'UPK', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/edit_data_sumber', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = [
                'id_upk' => $this->input->post('id_upk'),
                'uraian' => $this->input->post('uraian'),
                'nilai'  => $this->input->post('nilai'),
            ];
            $this->db->where('id_sb', $id_sb);
            $this->db->update('rkap_sumber', $update_data);
            $this->session->set_flashdata('info', '<div class="alert alert-success">Data sumber berhasil diperbarui.</div>');
            $this->session->set_flashdata(
                'info',
                '
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Data Pemakaian Listrik Sumber berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
        }
    }
}
