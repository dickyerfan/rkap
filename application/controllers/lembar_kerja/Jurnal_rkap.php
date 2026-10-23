<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_rkap extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_jurnal_rkap');
        $this->load->model('Model_posisi_keuangan');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) redirect('auth');
    }

    private function loadViews($view, $data)
    {
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
        }
        $this->load->view($view, $data);
        $this->load->view('templates/footer');
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $this->session->set_userdata('tahun_rkap_jurnal', $tahun);
        $data = [
            'tahun' => $tahun,
            'header' => $this->Model_jurnal_rkap->getHeader($tahun),
            'lines' => $this->Model_jurnal_rkap->getDetails($tahun),
            'summary' => $this->Model_jurnal_rkap->getSummary($tahun),
            'title' => 'JURNAL RKAP 2027',
        ];
        $this->loadViews('lembar_kerja/jurnal_rkap/view_jurnal_rkap', $data);
    }

    public function v2()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $this->session->set_userdata('tahun_rkap_jurnal', $tahun);
        $data = [
            'tahun' => $tahun,
            'header' => $this->Model_jurnal_rkap->getHeader($tahun),
            'lines' => $this->Model_jurnal_rkap->getDetails($tahun),
            'summary' => $this->Model_jurnal_rkap->getSummary($tahun),
            'title' => 'JURNAL RKAP 2027',
            'versi' => 2,
        ];
        $this->loadViews('lembar_kerja/jurnal_rkap/view_jurnal_rkap_v2', $data);
    }

    public function simpan()
    {
        if ($this->session->userdata('level') != 'Admin') redirect('auth');
        $tahun = (int)$this->input->post('tahun');
        $versi = (string)$this->input->post('versi');
        $header = [
            'no_jurnal' => $this->input->post('no_jurnal'),
            'tanggal' => $this->input->post('tanggal'),
            'uraian_header' => $this->input->post('uraian_header'),
        ];
        $lines = $this->input->post('lines');
        $lines = is_array($lines) ? $lines : [];

        $balik = $versi === '2' ? 'lembar_kerja/jurnal_rkap/v2?tahun_rkap=' . $tahun : 'lembar_kerja/jurnal_rkap?tahun_rkap=' . $tahun;

        if ($versi === '2') {
            $cek = $this->Model_jurnal_rkap->cekBalance($lines);
            if (!$cek['seimbang']) {
                $detail = [];
                foreach (array_slice($cek['baris'], 0, 8) as $m) $detail[] = 'Baris ' . $m['no'] . ': ' . $m['pesan'];
                foreach (array_slice($cek['kelompok'], 0, 8) as $m) {
                    $detail[] = 'Kelompok ' . $m['kelompok'] . ' tidak balance (Debit ' . number_format($m['debit'], 0, ',', '.')
                        . ' - Kredit ' . number_format($m['kredit'], 0, ',', '.')
                        . ' = ' . number_format($m['selisih'], 0, ',', '.') . ')';
                }
                $this->session->set_flashdata('info', '<div class="alert alert-danger"><strong>Gagal!</strong> Jurnal belum balance, data tidak disimpan.<br><small>'
                    . implode('<br>', array_map('htmlspecialchars', $detail)) . '</small></div>');
                redirect($balik);
                return;
            }
        }

        $saved = $this->Model_jurnal_rkap->saveJournal($tahun, $header, $lines, $this->session->userdata('nama_pengguna'));
        if ($saved) {
            $this->session->set_flashdata('info', '<div class="alert alert-success"><strong>Sukses!</strong> Jurnal RKAP berhasil disimpan.</div>');
        } else {
            $this->session->set_flashdata('info', '<div class="alert alert-danger"><strong>Gagal!</strong> Jurnal RKAP tidak berhasil disimpan.</div>');
        }
        redirect($balik);
    }
}
