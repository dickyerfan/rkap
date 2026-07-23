<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_upk extends MY_Controller
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
        $this->load->model('Model_proyeksi_upk');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $id_upk = $this->input->get('id_upk');
        $tahun_ini = date('Y');
        $tahun_depan = $tahun_ini + 1;

        $data['tahun_ini'] = $tahun_ini;
        $data['tahun_depan'] = $tahun_depan;

        $data['upk_list'] = $this->db->where('status =', 1)->order_by('kode', 'ASC')->get('rkap_nama_upk')->result();
        $data['selected_upk'] = $id_upk;

        if ($id_upk === 'amdk') {
            $data['is_amdk'] = true;
            $data['title'] = 'DASHBOARD AMDK';
            $data = $this->getAmdkData($data, $tahun_ini, $tahun_depan);
            $view = 'admin/dashboard_upk/view_dashboard_upk';
        } elseif (!empty($id_upk)) {
            $data['is_amdk'] = false;
            $upk = $this->db->where('id_upk', $id_upk)->get('rkap_nama_upk')->row();
            $data['nama_upk'] = $upk->nama_upk ?? '';
            $upk_bagian = strtolower(str_replace(' ', '', $data['nama_upk']));
            $cabang_id = $upk->kode ?? '';
            $data['cabang_id'] = $cabang_id;
            $data['upk_bagian'] = $upk_bagian;
            $data['title'] = 'DASHBOARD ' . strtoupper($data['nama_upk']);
            $data = $this->getUpkData($data, $tahun_ini, $tahun_depan, $cabang_id, $upk_bagian, $id_upk);
            $view = 'admin/dashboard_upk/view_dashboard_upk';
        } else {
            $data['is_amdk'] = false;
            $data['is_total'] = true;
            $data['title'] = 'DASHBOARD RKAP - KONSOLIDASI';
            $data = $this->getTotalData($data, $tahun_ini, $tahun_depan);
            $view = 'admin/dashboard_upk/view_dashboard_upk';
        }

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view($view, $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view($view, $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    private function getUpkData($data, $tahun_ini, $tahun_depan, $cabang_id, $upk_bagian, $id_upk = null)
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

        $data['potensi_sr_ini'] = $this->db->get_where('potensi_sr', ['tahun_rkap' => $tahun_ini - 1, 'bagian_upk' => $upk_bagian])->row();
        $data['potensi_sr_depan'] = $this->db->get_where('potensi_sr', ['tahun_rkap' => $tahun_depan - 1, 'bagian_upk' => $upk_bagian])->row();

        $data['selisih_plg_aktif'] = ($data['potensi_sr_depan']->plg_aktif ?? 0) - ($data['potensi_sr_ini']->plg_aktif ?? 0);
        $data['selisih_tambah_sr'] = ($data['potensi_sr_depan']->tambah_sr ?? 0) - ($data['potensi_sr_ini']->tambah_sr ?? 0);
        $data['selisih_kap_pro'] = ($data['potensi_sr_depan']->kap_pro ?? 0) - ($data['potensi_sr_ini']->kap_pro ?? 0);
        $data['selisih_kap_manf'] = ($data['potensi_sr_depan']->kap_manf ?? 0) - ($data['potensi_sr_ini']->kap_manf ?? 0);
        $data['selisih_tk_bocor'] = ($data['potensi_sr_depan']->tk_bocor ?? 0) - ($data['potensi_sr_ini']->tk_bocor ?? 0);
        $data['selisih_pola_kon'] = ($data['potensi_sr_depan']->pola_kon ?? 0) - ($data['potensi_sr_ini']->pola_kon ?? 0);

        $data['evaluasi_upk_ini'] = $this->db->get_where('evaluasi_upk', ['tahun_rkap' => $tahun_ini, 'bagian_upk' => $upk_bagian])->result();

        // --- Perbandingan Target UPK (bulan per bulan) ---
        $tahun_lalu = $tahun_ini;
        $tahun_sekarang = $tahun_depan;
        $data = $this->getPerbandinganData($data, $tahun_lalu, $tahun_sekarang, $id_upk);

        return $data;
    }

    private function getAmdkData($data, $tahun_ini, $tahun_depan)
    {
        $codePendapatanUsaha = ['88.02'];
        $codeBebanUsaha = ['98.02'];
        $codeBebanUmum = ['96'];
        $codeNonUsaha = ['97'];

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

    private function getTotalData($data, $tahun_ini, $tahun_depan)
    {
        $codePendapatanUsaha = ['81.01', '81.02', '81.03'];
        $codeBebanUsaha = ['91', '92', '93', '95'];
        $codeBebanUmum = ['96'];
        $codeNonUsaha = ['88', '98'];
        $codeLuarBiasa = ['89.01.01', '99.01.01'];
        $codePajak = ['97.01.01', '97.01.02', '97.01.03'];

        $data['pendapatan_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codePendapatanUsaha);
        $data['pendapatan_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codePendapatanUsaha);

        $data['beban_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codeBebanUsaha);
        $data['beban_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codeBebanUsaha);

        $data['beban_umum_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codeBebanUmum);
        $data['beban_umum_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codeBebanUmum);

        $data['non_usaha_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codeNonUsaha);
        $data['non_usaha_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codeNonUsaha);

        $data['luar_biasa_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codeLuarBiasa);
        $data['luar_biasa_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codeLuarBiasa);

        $data['pajak_ini'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_ini, 'all', $codePajak);
        $data['pajak_depan'] = $this->Model_laba_rugi->getTotalsByCodes($tahun_depan, 'all', $codePajak);

        $data['total_pendapatan_ini'] = $this->sumTotals($data['pendapatan_ini']);
        $data['total_pendapatan_depan'] = $this->sumTotals($data['pendapatan_depan']);

        $data['total_beban_ini'] = $this->sumTotals($data['beban_ini']);
        $data['total_beban_depan'] = $this->sumTotals($data['beban_depan']);

        $data['total_beban_umum_ini'] = $data['beban_umum_ini']['96']['total'] ?? 0;
        $data['total_beban_umum_depan'] = $data['beban_umum_depan']['96']['total'] ?? 0;

        $pend_non_usaha_ini = ($data['non_usaha_ini']['88']['total'] ?? 0) - ($data['non_usaha_ini']['98']['total'] ?? 0);
        $pend_non_usaha_depan = ($data['non_usaha_depan']['88']['total'] ?? 0) - ($data['non_usaha_depan']['98']['total'] ?? 0);

        $data['total_luar_biasa_ini'] = ($data['luar_biasa_ini']['89.01.01']['total'] ?? 0) - ($data['luar_biasa_ini']['99.01.01']['total'] ?? 0);
        $data['total_luar_biasa_depan'] = ($data['luar_biasa_depan']['89.01.01']['total'] ?? 0) - ($data['luar_biasa_depan']['99.01.01']['total'] ?? 0);

        $data['total_pajak_ini'] = $this->sumTotals($data['pajak_ini']);
        $data['total_pajak_depan'] = $this->sumTotals($data['pajak_depan']);

        $data['laba_kotor_ini'] = $data['total_pendapatan_ini'] - $data['total_beban_ini'];
        $data['laba_kotor_depan'] = $data['total_pendapatan_depan'] - $data['total_beban_depan'];

        $data['laba_operasional_ini'] = $data['laba_kotor_ini'] - $data['total_beban_umum_ini'];
        $data['laba_operasional_depan'] = $data['laba_kotor_depan'] - $data['total_beban_umum_depan'];

        $data['laba_sebelum_pajak_ini'] = $data['laba_operasional_ini'] + $pend_non_usaha_ini;
        $data['laba_sebelum_pajak_depan'] = $data['laba_operasional_depan'] + $pend_non_usaha_depan;

        $data['laba_bersih_ini'] = $data['laba_sebelum_pajak_ini'] + $data['total_luar_biasa_ini'] - $data['total_pajak_ini'];
        $data['laba_bersih_depan'] = $data['laba_sebelum_pajak_depan'] + $data['total_luar_biasa_depan'] - $data['total_pajak_depan'];

        $tahun_lalu = $tahun_ini;
        $tahun_sekarang = $tahun_depan;
        $data = $this->getPerbandinganData($data, $tahun_lalu, $tahun_sekarang, null);

        return $data;
    }

    public function export_pdf()
    {
        $id_upk = $this->input->get('id_upk');

        if ($id_upk === 'amdk') {
            redirect('admin/dashboard_upk');
        }

        $tahun_ini = date('Y');
        $tahun_depan = $tahun_ini + 1;

        $data['tahun_ini'] = $tahun_ini;
        $data['tahun_depan'] = $tahun_depan;
        $data['is_amdk'] = false;

        if (!empty($id_upk)) {
            $upk = $this->db->where('id_upk', $id_upk)->get('rkap_nama_upk')->row();
            $data['nama_upk'] = $upk->nama_upk ?? '';
            $upk_bagian = strtolower(str_replace(' ', '', $data['nama_upk']));
            $cabang_id = $upk->kode ?? '';
            $data['cabang_id'] = $cabang_id;
            $data['upk_bagian'] = $upk_bagian;
            $data = $this->getUpkData($data, $tahun_ini, $tahun_depan, $cabang_id, $upk_bagian, $id_upk);

            $nama_file = 'Dashboard_RKAP_' . strtoupper(str_replace(' ', '', $data['nama_upk']));
        } else {
            $data['is_total'] = true;
            $data = $this->getTotalData($data, $tahun_ini, $tahun_depan);

            $nama_file = 'Dashboard_RKAP_KONSOLIDASI';
        }

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = $nama_file . '.pdf';
        $this->pdf->generate('admin/dashboard_upk/laporan_pdf', $data);
    }

    private function sumTotals($data)
    {
        $total = 0;
        foreach ($data as $item) {
            $total += $item['total'] ?? 0;
        }
        return $total;
    }

    private function mapMonthly($rows, $field = null)
    {
        $map = [];
        foreach ($rows as $r) {
            $b = (int) $r->bulan;
            $map[$b] = $field ? (float) ($r->$field ?? 0) : $r;
        }
        return $map;
    }

    private function getPelangganMonthly($tahun, $id_upk = null)
    {
        $this->db
            ->select('bulan, id_kd, SUM(jumlah) as total')
            ->from('rkap_pelanggan')
            ->where('tahun', $tahun)
            ->where_in('id_kd', [2, 3, 4, 5])
            ->group_by('bulan, id_kd')
            ->order_by('bulan, id_kd');

        if (!empty($id_upk)) {
            $this->db->where('id_upk', $id_upk);
        }

        $rows = $this->db->get()->result();

        $map = [];
        foreach ($rows as $r) {
            $b = (int) $r->bulan;
            $kd = (int) $r->id_kd;
            $map[$b][$kd] = (float) $r->total;
        }
        return $map;
    }

    private function getPerbandinganData($data, $tahun_lalu, $tahun_sekarang, $id_upk)
    {
        $data['tahun_lalu'] = $tahun_lalu;
        $data['tahun_sekarang'] = $tahun_sekarang;

        $data['pelanggan_lalu'] = $this->getPelangganMonthly($tahun_lalu, $id_upk);
        $data['pelanggan_sekarang'] = $this->getPelangganMonthly($tahun_sekarang, $id_upk);

        // ambil tera_meter, ganti_meter, efi_tagih dari rkap_evaluasi_pelanggan (target_upk)
        $extra_lalu = $this->Model_proyeksi_upk->getDataAll($tahun_lalu, $id_upk);
        $extra_sekarang = $this->Model_proyeksi_upk->getDataAll($tahun_sekarang, $id_upk);
        $data['extra_lalu'] = $this->mapMonthly($extra_lalu);
        $data['extra_sekarang'] = $this->mapMonthly($extra_sekarang);

        $data['jml_rekening_lalu'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getJumlahRekening($tahun_lalu, $id_upk),
            'jumlah_rekening'
        );
        $data['jml_rekening_sekarang'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getJumlahRekening($tahun_sekarang, $id_upk),
            'jumlah_rekening'
        );

        $data['pemakaian_lalu'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getPemakaian($tahun_lalu, $id_upk),
            'pemakaian'
        );
        $data['pemakaian_sekarang'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getPemakaian($tahun_sekarang, $id_upk),
            'pemakaian'
        );

        $data['pendapatan_lalu'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getPendapatan($tahun_lalu, $id_upk),
            'pendapatan'
        );
        $data['pendapatan_sekarang'] = $this->mapMonthly(
            $this->Model_proyeksi_upk->getPendapatan($tahun_sekarang, $id_upk),
            'pendapatan'
        );

        return $data;
    }
}
