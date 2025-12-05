<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laba_rugi_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laba_rugi');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $this->session->set_userdata('tahun_rkap', $tahun);

        $title = "PROYEKSI LABA RUGI UNIT AMDK <br> TAHUN ANGGARAN ";

        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'PENDAPATAN'],
            ['header' => 'PENDAPATAN USAHA'],
            ['kode' => ['88.02.01', '88.02.02', '88.02.03', '88.02.04', '88.02.05', '88.02.06'], 'uraian' => 'Pendapatan Air'],
            ['kode' => '88.02.07',  'uraian' => 'Pendapatan Non Air'],
            ['kode' => '88.02.08', 'uraian' => 'Pendapatan Usaha Lainnya'],
            ['header' => 'PENDAPATAN USAHA'],
            ['header' => 'BEBAN USAHA'],
            ['kode' => '98.02.01', 'uraian' => 'Beban Pegawai'],
            ['kode' => '98.02.02', 'uraian' => 'Beban BBM'],
            ['kode' => '98.02.03', 'uraian' => 'Beban Kantor'],
            ['kode' => '98.02.04', 'uraian' => 'Beban Pemeliharaan'],
            ['kode' => '98.02.05', 'uraian' => 'Beban Pemakaian'],
            ['kode' => '98.02.06', 'uraian' => 'Beban Rupa-rupa'],
            ['kode' => '98.02.07', 'uraian' => 'Beban Pemeriksaan SNI'],
            ['kode' => '98.02.08', 'uraian' => 'Beban Uji Kualitas Air'],
            ['kode' => '98.02.09', 'uraian' => 'Beban AMDK Lainnya'],
            ['kode' => '98.02.10', 'uraian' => 'Beban Penyusutan'],
            ['kode' => '98.02.11', 'uraian' => 'Beban Penghps. Piutang'],
            ['kode' => '98.02.12', 'uraian' => 'Beban Kerugian Kerusakan'],
            ['kode' => '98.02.13', 'uraian' => 'Beban Pengurusan Surat'],
            ['kode' => '98.02.14', 'uraian' => 'Beban SPPD'],
            ['header' => 'BEBAN USAHA'],
            ['header' => 'LABA / (RUGI) KOTOR'],
            ['header' => 'PAJAK PENGHASILAN'],
            ['kode' => '97.01.01', 'uraian' => 'Taksiran Pajak (pasal 25)'],
            ['kode' => '97.01.02', 'uraian' => 'Pajak Kini'],
            ['kode' => '97.01.03', 'uraian' => 'Beban Pajak Ditangguhkan'],
            ['header' => 'LABA / (RUGI) SETELAH PAJAK'],
        ];

        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) {
                if (is_array($f['kode'])) {
                    foreach ($f['kode'] as $c) $codes[] = $c;
                } else {
                    $codes[] = $f['kode'];
                }
            }
        }


        $totals = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'pendapatan_air' => ['88.02.01', '88.02.02', '88.02.03', '88.02.04', '88.02.05', '88.02.06'],
            'pendapatan_non_air' => ['88.02.07'],
            'pendapatan_usaha_lain' => ['88.02.08'],
            'beban_pegawai' => ['98.02.01'],
            'beban_bbm' => ['98.02.02'],
            'beban_kantor' => ['98.02.03'],
            'beban_pemeliharaan' => ['98.02.04'],
            'beban_pemakaian' => ['98.02.05'],
            'beban_rupa_rupa' => ['98.02.06'],
            'beban_pemeriksaan_sni' => ['98.02.07'],
            'beban_uji_kualitas_air' => ['98.02.08'],
            'beban_amdk_lain' => ['98.02.09'],
            'beban_penyusutan' => ['98.02.10'],
            'beban_penghps_piutang' => ['98.02.11'],
            'beban_kerusakan' => ['98.02.12'],
            'beban_pengurusan_surat' => ['98.02.13'],
            'beban_sppd' => ['98.02.14'],
            'pajak_25' => ['97.01.01'],
            'pajak_kini' => ['97.01.02'],
            'pajak_ditangguhkan' => ['97.01.03'],
        ];

        foreach ($mapVar as $varName => $codeList) {
            $bulanArr = array_fill(1, 12, 0);
            $total = 0;
            foreach ($codeList as $code) {
                if (isset($totals[$code])) {
                    foreach ($totals[$code]['bulan'] as $m => $v) {
                        $bulanArr[$m] += $v;
                    }
                    $total += $totals[$code]['total'];
                }
            }
            $data[$varName] = $bulanArr;
            $data[$varName . '_total'] = $total;
        }


        $data['tahun'] = $tahun;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/laba_rugi/view_laba_rugi_amdk', $data);
        $this->load->view('templates/footer');
    }


    public function export_pdf()
    {
        $tahun = $this->session->userdata('tahun_rkap');

        $title = "PROYEKSI LABA RUGI UNIT AMDK <br> TAHUN ANGGARAN ";

        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'PENDAPATAN'],
            ['header' => 'PENDAPATAN USAHA'],
            ['kode' => ['88.02.01', '88.02.02', '88.02.03', '88.02.04', '88.02.05', '88.02.06'], 'uraian' => 'Pendapatan Air'],
            ['kode' => '88.02.07',  'uraian' => 'Pendapatan Non Air'],
            ['kode' => '88.02.08', 'uraian' => 'Pendapatan Usaha Lainnya'],
            ['header' => 'PENDAPATAN USAHA'],
            ['header' => 'BEBAN USAHA'],
            ['kode' => '98.02.01', 'uraian' => 'Beban Pegawai'],
            ['kode' => '98.02.02', 'uraian' => 'Beban BBM'],
            ['kode' => '98.02.03', 'uraian' => 'Beban Kantor'],
            ['kode' => '98.02.04', 'uraian' => 'Beban Pemeliharaan'],
            ['kode' => '98.02.05', 'uraian' => 'Beban Pemakaian'],
            ['kode' => '98.02.06', 'uraian' => 'Beban Rupa-rupa'],
            ['kode' => '98.02.07', 'uraian' => 'Beban Pemeriksaan SNI'],
            ['kode' => '98.02.08', 'uraian' => 'Beban Uji Kualitas Air'],
            ['kode' => '98.02.09', 'uraian' => 'Beban AMDK Lainnya'],
            ['kode' => '98.02.10', 'uraian' => 'Beban Penyusutan'],
            ['kode' => '98.02.11', 'uraian' => 'Beban Penghps. Piutang'],
            ['kode' => '98.02.12', 'uraian' => 'Beban Kerugian Kerusakan'],
            ['kode' => '98.02.13', 'uraian' => 'Beban Pengurusan Surat'],
            ['kode' => '98.02.14', 'uraian' => 'Beban SPPD'],
            ['header' => 'BEBAN USAHA'],
            ['header' => 'LABA / (RUGI) KOTOR'],
            ['header' => 'PAJAK PENGHASILAN'],
            ['kode' => '97.01.01', 'uraian' => 'Taksiran Pajak (pasal 25)'],
            ['kode' => '97.01.02', 'uraian' => 'Pajak Kini'],
            ['kode' => '97.01.03', 'uraian' => 'Beban Pajak Ditangguhkan'],
            ['header' => 'LABA / (RUGI) SETELAH PAJAK'],
        ];

        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) {
                if (is_array($f['kode'])) {
                    foreach ($f['kode'] as $c) $codes[] = $c;
                } else {
                    $codes[] = $f['kode'];
                }
            }
        }

        $totals = $this->Model_laba_rugi->getTotalsByCodesAmdk($tahun, $codes);

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'pendapatan_air' => ['88.02.01', '88.02.02', '88.02.03', '88.02.04', '88.02.05', '88.02.06'],
            'pendapatan_non_air' => ['88.02.07'],
            'pendapatan_usaha_lain' => ['88.02.08'],
            'beban_pegawai' => ['98.02.01'],
            'beban_bbm' => ['98.02.02'],
            'beban_kantor' => ['98.02.03'],
            'beban_pemeliharaan' => ['98.02.04'],
            'beban_pemakaian' => ['98.02.05'],
            'beban_rupa_rupa' => ['98.02.06'],
            'beban_pemeriksaan_sni' => ['98.02.07'],
            'beban_uji_kualitas_air' => ['98.02.08'],
            'beban_amdk_lain' => ['98.02.09'],
            'beban_penyusutan' => ['98.02.10'],
            'beban_penghps_piutang' => ['98.02.11'],
            'beban_kerusakan' => ['98.02.12'],
            'beban_pengurusan_surat' => ['98.02.13'],
            'beban_sppd' => ['98.02.14'],
            'pajak_25' => ['97.01.01'],
            'pajak_kini' => ['97.01.02'],
            'pajak_ditangguhkan' => ['97.01.03'],
        ];

        foreach ($mapVar as $varName => $codeList) {
            $bulanArr = array_fill(1, 12, 0);
            $total = 0;
            foreach ($codeList as $code) {
                if (isset($totals[$code])) {
                    foreach ($totals[$code]['bulan'] as $m => $v) {
                        $bulanArr[$m] += $v;
                    }
                    $total += $totals[$code]['total'];
                }
            }
            $data[$varName] = $bulanArr;
            $data[$varName . '_total'] = $total;
        }

        $data['tahun'] = $tahun;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_laba_rugi_amdk_{$tahun}_" . ".pdf";

        $this->pdf->generate('lembar_kerja/rkap_amdk/laba_rugi/laporan_pdf', $data);
    }
}
