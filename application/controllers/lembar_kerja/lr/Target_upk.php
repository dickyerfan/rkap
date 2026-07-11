<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Target_upk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_proyeksi_upk');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    private function _buildData($tahun, $id_upk)
    {
        $data = [];
        $data['tahun_rkap'] = $tahun;
        $data['id_upk']     = $id_upk;

        $data['upk'] = $this->db
            ->where('status', 1)
            ->order_by('kode', 'ASC')
            ->get('rkap_nama_upk')
            ->result();

        if ($id_upk == '') {
            $data['judul_upk']  = 'KONSOLIDASI';
            $data['info_upk']   = null;
        } else {
            $info = $this->Model_proyeksi_upk->getInfoUpk($id_upk);
            $data['judul_upk'] = 'UPK ' . strtoupper($info->nama_upk ?? '');
            $data['info_upk']  = $info;
        }

        $data['title'] = ($tahun == 2025 || $tahun == 2026)
            ? 'REALISASI PENCAPAIAN TAHUN ' . $tahun
            : 'TARGET KINERJA TAHUN ' . $tahun;

        $data['tampil']    = $this->Model_proyeksi_upk->getDataAll($tahun, $id_upk);
        $data['rekening']  = $this->Model_proyeksi_upk->getJumlahRekening($tahun, $id_upk);
        $data['pemakaian'] = $this->Model_proyeksi_upk->getPemakaian($tahun, $id_upk);
        $data['pendapatan'] = $this->Model_proyeksi_upk->getPendapatan($tahun, $id_upk);

        return $data;
    }

    public function index()
    {
        $tahun  = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $id_upk = $this->input->get('id_upk');

        $data = $this->_buildData($tahun, $id_upk);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/target_upk/view_target_upk', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $tahun  = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $id_upk = $this->input->get('id_upk');

        $data = $this->_buildData($tahun, $id_upk);
        $nama_file = ($id_upk == '') ? 'Konsolidasi' : ($data['info_upk']->nama_upk ?? $id_upk);

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Target_kinerja-{$nama_file}-{$tahun}.pdf";
        $this->pdf->generate('lembar_kerja/lr/target_upk/laporan_pdf', $data);
    }
}
