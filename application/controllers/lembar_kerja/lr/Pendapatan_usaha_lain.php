<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_usaha_lain extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_usaha_lain');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['subsidi'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.03');
        $data['penagihan'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');
        $data['title'] = 'RENCANA PENDAPATAN USAHA LAINNYA';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_usaha_lain/view_pendapatan_usaha_lain', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['subsidi'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.03');
        $data['penagihan'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');
        $data['title'] = 'RENCANA PENDAPATAN USAHA LAINNYA';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_usaha_lain_{$tahun}_.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/pendapatan_usaha_lain/laporan_pdf', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Input Data Pendapatan Usaha Lainnya';

        $data['no_per_subsidi']   = $this->db->like('kode', '81.03.03', 'after')->get('no_per')->result();
        $data['no_per_penagihan'] = $this->db->like('kode', '81.03.01', 'after')->get('no_per')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_usaha_lain/upload_pendapatan_usaha_lain', $data);
        $this->load->view('templates/footer');
    }
    public function save()
    {
        $tahun   = $this->input->post('tahun');
        $bulan   = $this->input->post('bulan'); // hanya dipakai untuk subsidi
        $jenis   = $this->input->post('jenis'); // subsidi / penagihan
        $kode    = $this->input->post('kode');  // ex: 81.01.05.02 atau 81.03.01.01
        $pagu    = $this->input->post('pagu');

        if ($jenis == 'subsidi') {
            $this->Model_pendapatan_usaha_lain->saveSubsidi($tahun, $bulan, $kode, $pagu);
        } elseif ($jenis == 'penagihan') {
            $this->Model_pendapatan_usaha_lain->savePenagihan($tahun, $kode, $pagu);
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Pendapatan Usaha Lainnya berhasil di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/lr/pendapatan_usaha_lain');
    }

    // public function save()
    // {
    //     $tahun_input    = $this->input->post('tahun'); // dari hidden input (Y+1)
    //     $tahun_sekarang = date('Y');

    //     // Cek: kalau tahun_input == tahun_sekarang → tolak
    //     if ($tahun_input == $tahun_sekarang) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Gagal,</strong> RKAP tahun ' . $tahun_input . ' sudah terkunci.Silakan input untuk tahun ' . ($tahun_sekarang + 1) . '
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //         );
    //         redirect('lembar_kerja/lr/pendapatan_usaha_lain');
    //         return;
    //     }

    //     // kalau lolos, proses simpan sesuai jenis
    //     $bulan   = $this->input->post('bulan');
    //     $jenis   = $this->input->post('jenis');
    //     $kode    = $this->input->post('kode');
    //     $pagu    = $this->input->post('pagu');

    //     if ($jenis == 'subsidi') {
    //         $this->Model_pendapatan_usaha_lain->saveSubsidi($tahun_input, $bulan, $kode, $pagu);
    //     } elseif ($jenis == 'penagihan') {
    //         $this->Model_pendapatan_usaha_lain->savePenagihan($tahun_input, $kode, $pagu);
    //     }

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Berhasil,</strong> Pendapatan Usaha Lainnya berhasil di input.
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //     );
    //     redirect('lembar_kerja/lr/pendapatan_usaha_lain');
    // }
}
