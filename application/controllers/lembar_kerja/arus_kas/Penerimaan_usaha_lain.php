<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_usaha_lain extends MY_Controller
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

        $data['subsidi'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.01.05.02');
        $data['penagihan'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');
        $data['title'] = 'RENCANA PENERIMAAN USAHA LAINNYA';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_usaha_lain/view_penerimaan_usaha_lain', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['subsidi'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.01.05.02');
        $data['penagihan'] = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');
        $data['title'] = 'RENCANA PENERIMAAN USAHA LAINNYA';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_usaha_lain_{$tahun}_.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/penerimaan_usaha_lain/laporan_pdf', $data);
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;

        // ambil rekap data
        $penagihan = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');

        // hitung total per bulan (gabungan)
        $penagihan_total_bulan = array_fill(1, 12, 0);

        foreach ($penagihan as $row) {
            for ($i = 1; $i <= 12; $i++) {
                $penagihan_total_bulan[$i] += $row['bulan'][$i] ?? 0;
            }
        }

        // gabungkan untuk grand total per bulan
        $grand_bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grand_bulan[$i] = ($penagihan_total_bulan[$i] ?? 0);
        }

        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";
        $this->db->where('no_per_id', '81.03');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');
        // mulai simpan ke tabel rkap_arus_kas
        foreach ($grand_bulan as $bulan => $nilai) {
            $data = [
                'id_upk'     => null,              // isi sesuai kebutuhan
                'cabang_id'  => 24,                // ubah sesuai cabang
                'no_per_id'  => '81.03',           // kode target
                'bulan'      => sprintf('%d-%02d-01', $tahun, $bulan),
                'pagu'       => $nilai,
            ];

            $this->db->insert('rkap_arus_kas', $data);
        }
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan non air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_usaha_lain');
    }
    // public function generate()
    // {
    //     $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;

    //     // ambil rekap data
    //     $subsidi   = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.01.05.02');
    //     $penagihan = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.03.01');

    //     // hitung total per bulan (gabungan)
    //     $subsidi_total_bulan   = array_fill(1, 12, 0);
    //     $penagihan_total_bulan = array_fill(1, 12, 0);

    //     foreach ($subsidi as $row) {
    //         for ($i = 1; $i <= 12; $i++) {
    //             $subsidi_total_bulan[$i] += $row['bulan'][$i] ?? 0;
    //         }
    //     }

    //     foreach ($penagihan as $row) {
    //         for ($i = 1; $i <= 12; $i++) {
    //             $penagihan_total_bulan[$i] += $row['bulan'][$i] ?? 0;
    //         }
    //     }

    //     // gabungkan untuk grand total per bulan
    //     $grand_bulan = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $grand_bulan[$i] = ($subsidi_total_bulan[$i] ?? 0) + ($penagihan_total_bulan[$i] ?? 0);
    //     }

    //     $awal_tahun = "$tahun-01-01";
    //     $akhir_tahun = "$tahun-12-01";
    //     $this->db->where('no_per_id', '81.03');
    //     $this->db->where('bulan >=', $awal_tahun);
    //     $this->db->where('bulan <=', $akhir_tahun);
    //     $this->db->delete('rkap_arus_kas');
    //     // mulai simpan ke tabel rkap_arus_kas
    //     foreach ($grand_bulan as $bulan => $nilai) {
    //         $data = [
    //             'id_upk'     => null,              // isi sesuai kebutuhan
    //             'cabang_id'  => 24,                // ubah sesuai cabang
    //             'no_per_id'  => '81.03',           // kode target
    //             'bulan'      => sprintf('%d-%02d-01', $tahun, $bulan),
    //             'pagu'       => $nilai,
    //         ];

    //         $this->db->insert('rkap_arus_kas', $data);
    //     }
    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Berhasil!</strong> Data penerimaan non air berhasil digenerate ke  Arus Kas.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //     );
    //     redirect('lembar_kerja/arus_kas/penerimaan_usaha_lain');
    // }
    public function generate_subsidi()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;
        $subsidi   = $this->Model_pendapatan_usaha_lain->getRekapPendapatanUsahaLainnya($tahun, '81.01.05.02');
        if (!$subsidi) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Data penerimaan subsidi tidak ditemukan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
            );
            redirect('lembar_kerja/arus_kas/penerimaan_usaha_lain');
        }
        // hitung total per bulan (gabungan)

        $subsidi_total_bulan   = array_fill(1, 12, 0);

        foreach ($subsidi as $row) {
            for ($i = 1; $i <= 12; $i++) {
                $subsidi_total_bulan[$i] += $row['bulan'][$i] ?? 0;
            }
        }

        // gabungkan untuk grand total per bulan
        $grand_bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grand_bulan[$i] = ($subsidi_total_bulan[$i] ?? 0);
        }

        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";
        $this->db->where('no_per_id', '81.01.05.02');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');
        // mulai simpan ke tabel rkap_arus_kas
        foreach ($grand_bulan as $bulan => $nilai) {
            $data = [
                'id_upk'     => null,              // isi sesuai kebutuhan
                'cabang_id'  => 24,                // ubah sesuai cabang
                'no_per_id'  => '81.01.05.02',           // kode target
                'bulan'      => sprintf('%d-%02d-01', $tahun, $bulan),
                'pagu'       => $nilai,
            ];

            $this->db->insert('rkap_arus_kas', $data);
        }
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan non air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_usaha_lain');
    }
}
