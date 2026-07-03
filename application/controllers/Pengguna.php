<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

    private $cabang_map = [
        'bondowoso'   => '01',
        'sukosari1'   => '02',
        'maesan'      => '03',
        'tegalampel'  => '04',
        'tapen'       => '05',
        'prajekan'    => '06',
        'tlogosari'   => '07',
        'wringin'     => '08',
        'curahdami'   => '09',
        'tamanan'     => '11',
        'tenggarang'  => '12',
        'tamankrocok' => '14',
        'wonosari'    => '15',
        'klabang'     => '16',
        'sukosari2'   => '22',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_laba_rugi');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        if ($this->session->userdata('level') != 'Pengguna') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Pengguna...
                      </div>'
            );
            redirect('auth');
        }

        $upk_bagian = $this->session->userdata('upk_bagian');
        $tipe = $this->session->userdata('tipe');
        $isAmdk = ($upk_bagian === 'amdk');
        $tahun_ini = date('Y');
        $tahun_depan = $tahun_ini + 1;

        $data['tahun_ini'] = $tahun_ini;
        $data['tahun_depan'] = $tahun_depan;

        if ($isAmdk) {
            $data = $this->getAmdkData($data, $tahun_ini, $tahun_depan);
            $view = 'view_dashboard_pengguna_amdk';
        } elseif ($tipe === 'upk' && isset($this->cabang_map[$upk_bagian])) {
            $cabang_id = $this->cabang_map[$upk_bagian];
            $data['cabang_id'] = $cabang_id;
            $data = $this->getUpkData($data, $tahun_ini, $tahun_depan, $cabang_id, $upk_bagian);
            $view = 'view_dashboard_pengguna';
        } else {
            $data['title'] = 'Dashboard';
            $view = 'view_dashboard';
        }

        $data['title'] = 'Dashboard RKAP';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view($view, $data);
        $this->load->view('templates/pengguna/footer');
    }

    private function getUpkData($data, $tahun_ini, $tahun_depan, $cabang_id, $upk_bagian)
    {
        $codePendapatanUsaha = ['81.01', '81.02', '81.03'];
        $codeBebanUsaha = ['91', '92', '93', '95'];
        $codeBebanUmum = ['96'];
        $codeNonUsaha = ['88', '98'];

        $data['pendapatan_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, $cabang_id, $codePendapatanUsaha);
        $data['pendapatan_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, $cabang_id, $codePendapatanUsaha);

        $data['beban_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, $cabang_id, $codeBebanUsaha);
        $data['beban_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, $cabang_id, $codeBebanUsaha);

        $data['beban_umum_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, $cabang_id, $codeBebanUmum);
        $data['beban_umum_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, $cabang_id, $codeBebanUmum);

        $data['non_usaha_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, $cabang_id, $codeNonUsaha);
        $data['non_usaha_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, $cabang_id, $codeNonUsaha);

        $data['total_pendapatan_ini'] = $this->sumTotals($data['pendapatan_ini']);
        $data['total_pendapatan_depan'] = $this->sumTotals($data['pendapatan_depan']);

        $data['total_beban_ini'] = $this->sumTotals($data['beban_ini']);
        $data['total_beban_depan'] = $this->sumTotals($data['beban_depan']);

        $data['total_beban_umum_ini'] = $data['beban_umum_ini']['96']['total'] ?? 0;
        $data['total_beban_umum_depan'] = $data['beban_umum_depan']['96']['total'] ?? 0;

        $pend_non_usaha_ini = ($data['non_usaha_ini']['88']['total'] ?? 0) - ($data['non_usaha_ini']['98']['total'] ?? 0);
        $pend_non_usaha_depan = ($data['non_usaha_depan']['88']['total'] ?? 0) - ($data['non_usaha_depan']['98']['total'] ?? 0);

        $data['laba_usaha_ini'] = $data['total_pendapatan_ini'] - $data['total_beban_ini'];
        $data['laba_usaha_depan'] = $data['total_pendapatan_depan'] - $data['total_beban_depan'];

        $data['laba_operasional_ini'] = $data['laba_usaha_ini'] - $data['total_beban_umum_ini'];
        $data['laba_operasional_depan'] = $data['laba_usaha_depan'] - $data['total_beban_umum_depan'];

        $data['laba_bersih_ini'] = $data['laba_operasional_ini'] + $pend_non_usaha_ini;
        $data['laba_bersih_depan'] = $data['laba_operasional_depan'] + $pend_non_usaha_depan;

        $data['potensi_sr_ini'] = $this->db->get_where('potensi_sr', ['tahun_rkap' => $tahun_ini, 'bagian_upk' => $upk_bagian])->row();
        $data['potensi_sr_depan'] = $this->db->get_where('potensi_sr', ['tahun_rkap' => $tahun_depan, 'bagian_upk' => $upk_bagian])->row();

        $data['evaluasi_upk_ini'] = $this->db->get_where('evaluasi_upk', ['tahun_rkap' => $tahun_ini, 'bagian_upk' => $upk_bagian])->result();
        $data['evaluasi_upk_depan'] = $this->db->get_where('evaluasi_upk', ['tahun_rkap' => $tahun_depan, 'bagian_upk' => $upk_bagian])->result();

        $data['nama_upk'] = ucwords(str_replace(['1', '2'], [' 1', ' 2'], $upk_bagian));

        return $data;
    }

    private function getAmdkData($data, $tahun_ini, $tahun_depan)
    {
        $codePendapatanUsaha = ['81.01', '81.02', '81.03'];
        $codeBebanUsaha = ['91', '92', '93', '95'];
        $codeBebanUmum = ['96'];
        $codeNonUsaha = ['88', '98'];

        $data['pendapatan_ini'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_ini, $codePendapatanUsaha);
        $data['pendapatan_depan'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_depan, $codePendapatanUsaha);

        $data['beban_ini'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_ini, $codeBebanUsaha);
        $data['beban_depan'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_depan, $codeBebanUsaha);

        $data['beban_umum_ini'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_ini, $codeBebanUmum);
        $data['beban_umum_depan'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_depan, $codeBebanUmum);

        $data['non_usaha_ini'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_ini, $codeNonUsaha);
        $data['non_usaha_depan'] = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun_depan, $codeNonUsaha);

        $data['total_pendapatan_ini'] = $this->sumTotals($data['pendapatan_ini']);
        $data['total_pendapatan_depan'] = $this->sumTotals($data['pendapatan_depan']);

        $data['total_beban_ini'] = $this->sumTotals($data['beban_ini']);
        $data['total_beban_depan'] = $this->sumTotals($data['beban_depan']);

        $data['total_beban_umum_ini'] = $data['beban_umum_ini']['96']['total'] ?? 0;
        $data['total_beban_umum_depan'] = $data['beban_umum_depan']['96']['total'] ?? 0;

        $pend_non_usaha_ini = ($data['non_usaha_ini']['88']['total'] ?? 0) - ($data['non_usaha_ini']['98']['total'] ?? 0);
        $pend_non_usaha_depan = ($data['non_usaha_depan']['88']['total'] ?? 0) - ($data['non_usaha_depan']['98']['total'] ?? 0);

        $data['laba_usaha_ini'] = $data['total_pendapatan_ini'] - $data['total_beban_ini'];
        $data['laba_usaha_depan'] = $data['total_pendapatan_depan'] - $data['total_beban_depan'];

        $data['laba_operasional_ini'] = $data['laba_usaha_ini'] - $data['total_beban_umum_ini'];
        $data['laba_operasional_depan'] = $data['laba_usaha_depan'] - $data['total_beban_umum_depan'];

        $data['laba_bersih_ini'] = $data['laba_operasional_ini'] + $pend_non_usaha_ini;
        $data['laba_bersih_depan'] = $data['laba_operasional_depan'] + $pend_non_usaha_depan;

        $data['evaluasi_amdk_ini'] = $this->db->get_where('evaluasi_amdk', ['tahun_rkap' => $tahun_ini])->result();
        $data['evaluasi_amdk_depan'] = $this->db->get_where('evaluasi_amdk', ['tahun_rkap' => $tahun_depan])->result();

        $data['produksi_amdk_ini'] = $this->db->select('p.*, pr.nama_produk')
            ->from('rkap_amdk_produksi p')
            ->join('rkap_amdk_produk pr', 'p.id_produk = pr.id_produk')
            ->where('p.tahun_rkap', $tahun_ini)
            ->get()->result();
        $data['produksi_amdk_depan'] = $this->db->select('p.*, pr.nama_produk')
            ->from('rkap_amdk_produksi p')
            ->join('rkap_amdk_produk pr', 'p.id_produk = pr.id_produk')
            ->where('p.tahun_rkap', $tahun_depan)
            ->get()->result();

        return $data;
    }

    private function sumTotals($data)
    {
        $total = 0;
        foreach ($data as $item) {
            $total += $item['total'] ?? 0;
        }
        return $total;
    }
}
