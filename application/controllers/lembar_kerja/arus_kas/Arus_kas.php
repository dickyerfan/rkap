<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arus_kas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_arus_kas');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    private $mapCabang = [
        '01' => 'Bondowoso',
        '02' => 'Sukosari 1',
        '03' => 'Maesan',
        '04' => 'Tegalampel',
        '05' => 'Tapen',
        '06' => 'Prajekan',
        '07' => 'Tlogosari',
        '08' => 'Wringin',
        '09' => 'Curahdami',
        '11' => 'Tamanan',
        '12' => 'Tenggarang',
        '13' => 'AMDK',
        '14' => 'Tamankrocok',
        '15' => 'Wonosari',
        '16' => 'Klabang',
        '22' => 'Sukosari 2',
        '23' => 'Umum',
        '24' => 'Keuangan',
        '25' => 'Langganan',
        '26' => 'Pemeliharaan',
        '27' => 'Perencanaan',
        '28' => 'SPI',
    ];

    public function index()
    {
        $upk = $this->input->get('upk') ?: 'all';
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        // simpan di session utk keperluan export pdf
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $list_upk = [
            '01' => 'Bondowoso',
            '02' => 'Sukosari 1',
            '03' => 'Maesan',
            '04' => 'Tegalampel',
            '05' => 'Tapen',
            '06' => 'Prajekan',
            '07' => 'Tlogosari',
            '08' => 'Wringin',
            '09' => 'Curahdami',
            '11' => 'Tamanan',
            '12' => 'Tenggarang',
            '13' => 'AMDK',
            '14' => 'Tamankrocok',
            '15' => 'Wonosari',
            '16' => 'Klabang',
            '22' => 'Sukosari 2',
        ];

        // jika upk kosong → konsolidasi
        if ($upk && isset($list_upk[$upk])) {
            $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS <br> UPK " . strtoupper($list_upk[$upk]) . "  TAHUN ANGGARAN ";
        } else {
            $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS <br> TAHUN ANGGARAN ";
        }
        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'ARUS KAS OPERASI'],
            ['header' => 'PENERIMAAN'],
            ['kode' => '81.01', 'uraian' => 'Penerimaan Air'],
            ['kode' => '81.02', 'uraian' => 'Penerimaan Non Air'],
            ['kode' => '88', 'uraian' => 'Penerimaan Lain-lain'],
            ['kode' => '81.03', 'uraian' => 'Penerimaan Aktiva Lainnya'],
            ['header' => 'PENERIMAAN'],
            ['header' => 'PENGELUARAN'],
            ['kode' => '91', 'uraian' => 'Beban Sumber Air'],
            ['kode' => '92', 'uraian' => 'Beban Pengolahan Air'],
            ['kode' => '93', 'uraian' => 'Beban Transmisi dan Distribusi'],
            ['kode' => '96', 'uraian' => 'Beban Umum dan Administrasi'],
            ['kode' => '95', 'uraian' => 'Beban (HPP) Sambungan baru'],
            ['kode' => '98', 'uraian' => 'Beban Lain-lain'],
            ['kode' => '50.05', 'uraian' => 'Pembayaran Pajak'],
            ['kode' => '15.03', 'uraian' => 'Pembayaran Aktiva Lancar lain-lain'],
            ['kode' => '50.01', 'uraian' => 'Pembayaran Liabilitas Lancar lain-lain'],
            ['kode' => '', 'uraian' => 'Pembayaran Dapenma'],
            ['header' => 'PENGELUARAN'],
            ['header' => 'ARUS KAS DARI AKTIVITAS INVESTASI'],
            ['kode' => '', 'uraian' => 'Penambahan Aset Tetap'],
            ['kode' => '31', 'uraian' => 'Arus Kas Bersih digunakan Investasi'],
            ['header' => 'ARUS KAS DARI AKTIVITAS PENDANAAN'],
            ['kode' => '', 'uraian' => 'Penambahan PMP'],
            ['kode' => '', 'uraian' => 'Pembayaran Deviden Kepada KMP'],
            ['kode' => '62', 'uraian' => 'Pembayaran Jasa Produksi dan Tantiem'],
            ['kode' => '', 'uraian' => 'Penambahan cadangan /Koneksi Tahun lalu'],
            ['header' => 'ARUS KAS BERSIH UNTUK AKTIVITAS  PENDANAAN'],
            ['header' => 'KENAIKAN /BERKURANG BERSIH KAS DAN SETARA KAS'],
            ['header' => 'SALDO KAS SETARA KAS AWAL TAHUN'],
            ['header' => 'SALDO KAS SETARA KAS AKHIR TAHUN'],
        ];

        // ambil list kode yang ada di format (hanya entri yang punya key 'kode')
        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) $codes[] = $f['kode'];
        }


        $totals = $this->Model_arus_kas->getTotalsByCodes($tahun, $upk, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'penerimaan_air' => '81.01',
            'penerimaan_non_air' => '81.02',
            'penerimaan_lain_lain' => '88',
            'penerimaan_aktiva_lainnya' => '81.03',
            'beban_sumber_air' => '91',
            'beban_pengolahan' => '92',
            'beban_transmisi' => '93',
            'beban_sambungan' => '95',
            'beban_umum' => '96',
            'beban_lain_lain' => '98',
            'pembayaran_pajak' => '50.05',
            'pembayaran_aktiva_lainnya' => '15.03',
            'pembayaran_liabilitas_lainnya' => '50.01',
            'investasi' => '31',
            'jasa_produksi' => '62',
        ];

        foreach ($mapVar as $varName => $code) {
            if (isset($totals[$code])) {
                $data[$varName] = $totals[$code]['bulan']; // array bulan 1..12
                $data[$varName . '_total'] = $totals[$code]['total'];
            } else {
                $data[$varName] = array_fill(1, 12, 0);
                $data[$varName . '_total'] = 0;
            }
        }

        $query_saldo_awal = $this->db->select('pagu')
            ->from('rkap_arus_kas')
            ->where('no_per_id', 100)
            ->where('YEAR(bulan)', $tahun)
            ->get()
            ->row();

        $saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
        $data['saldo_awal_tahun'] = $saldo_awal_tahun;
        $data['tahun'] = $tahun;
        $data['upk']   = $upk;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/arus_kas/view_arus_kas', $data);
        $this->load->view('templates/footer');
    }


    public function export_pdf()
    {
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $list_upk = [
            '01' => 'Bondowoso',
            '02' => 'Sukosari 1',
            '03' => 'Maesan',
            '04' => 'Tegalampel',
            '05' => 'Tapen',
            '06' => 'Prajekan',
            '07' => 'Tlogosari',
            '08' => 'Wringin',
            '09' => 'Curahdami',
            '11' => 'Tamanan',
            '12' => 'Tenggarang',
            '13' => 'AMDK',
            '14' => 'Tamankrocok',
            '15' => 'Wonosari',
            '16' => 'Klabang',
            '22' => 'Sukosari 2',
        ];

        // jika upk kosong → konsolidasi
        if ($upk && isset($list_upk[$upk])) {
            $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS <br> UPK " . strtoupper($list_upk[$upk]) . "  TAHUN ANGGARAN ";
        } else {
            $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS <br> TAHUN ANGGARAN ";
        }
        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'ARUS KAS OPERASI'],
            ['header' => 'PENERIMAAN'],
            ['kode' => '81.01', 'uraian' => 'Penerimaan Air'],
            ['kode' => '81.02', 'uraian' => 'Penerimaan Non Air'],
            ['kode' => '88', 'uraian' => 'Penerimaan Lain-lain'],
            ['kode' => '81.03', 'uraian' => 'Penerimaan Aktiva Lainnya'],
            ['header' => 'PENERIMAAN'],
            ['header' => 'PENGELUARAN'],
            ['kode' => '91', 'uraian' => 'Beban Sumber Air'],
            ['kode' => '92', 'uraian' => 'Beban Pengolahan Air'],
            ['kode' => '93', 'uraian' => 'Beban Transmisi dan Distribusi'],
            ['kode' => '96', 'uraian' => 'Beban Umum dan Administrasi'],
            ['kode' => '95', 'uraian' => 'Beban (HPP) Sambungan baru'],
            ['kode' => '98', 'uraian' => 'Beban Lain-lain'],
            ['kode' => '50.05', 'uraian' => 'Pembayaran Pajak'],
            ['kode' => '15.03', 'uraian' => 'Pembayaran Aktiva Lancar lain-lain'],
            ['kode' => '50.01', 'uraian' => 'Pembayaran Liabilitas Lancar lain-lain'],
            ['kode' => '', 'uraian' => 'Pembayaran Dapenma'],
            ['header' => 'PENGELUARAN'],
            ['header' => 'ARUS KAS DARI AKTIVITAS INVESTASI'],
            ['kode' => '', 'uraian' => 'Penambahan Aset Tetap'],
            ['kode' => '31', 'uraian' => 'Arus Kas Bersih digunakan Investasi'],
            ['header' => 'ARUS KAS DARI AKTIVITAS PENDANAAN'],
            ['kode' => '', 'uraian' => 'Penambahan PMP'],
            ['kode' => '', 'uraian' => 'Pembayaran Deviden Kepada KMP'],
            ['kode' => '62', 'uraian' => 'Pembayaran Jasa Produksi dan Tantiem'],
            ['kode' => '', 'uraian' => 'Penambahan cadangan /Koneksi Tahun lalu'],
            ['header' => 'ARUS KAS BERSIH UNTUK AKTIVITAS  PENDANAAN'],
            ['header' => 'KENAIKAN /BERKURANG BERSIH KAS DAN SETARA KAS'],
            ['header' => 'SALDO KAS SETARA KAS AWAL TAHUN'],
            ['header' => 'SALDO KAS SETARA KAS AKHIR TAHUN'],
        ];

        // ambil list kode yang ada di format (hanya entri yang punya key 'kode')
        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) $codes[] = $f['kode'];
        }


        $totals = $this->Model_arus_kas->getTotalsByCodes($tahun, $upk, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'penerimaan_air' => '81.01',
            'penerimaan_non_air' => '81.02',
            'penerimaan_lain_lain' => '88',
            'penerimaan_aktiva_lainnya' => '81.03',
            'beban_sumber_air' => '91',
            'beban_pengolahan' => '92',
            'beban_transmisi' => '93',
            'beban_sambungan' => '95',
            'beban_umum' => '96',
            'beban_lain_lain' => '98',
            'pembayaran_pajak' => '50.05',
            'pembayaran_aktiva_lainnya' => '15.03',
            'pembayaran_liabilitas_lainnya' => '50.01',
            'investasi' => '31',
            'jasa_produksi' => '62',
        ];

        foreach ($mapVar as $varName => $code) {
            if (isset($totals[$code])) {
                $data[$varName] = $totals[$code]['bulan']; // array bulan 1..12
                $data[$varName . '_total'] = $totals[$code]['total'];
            } else {
                $data[$varName] = array_fill(1, 12, 0);
                $data[$varName . '_total'] = 0;
            }
        }

        $query_saldo_awal = $this->db->select('pagu')
            ->from('rkap_arus_kas')
            ->where('no_per_id', 100)
            ->where('YEAR(bulan)', $tahun)
            ->get()
            ->row();

        $saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
        $data['saldo_awal_tahun'] = $saldo_awal_tahun;
        $data['tahun'] = $tahun;
        $data['upk']   = $upk;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_arus_kas_{$tahun}" . ".pdf";

        $this->pdf->generate('lembar_kerja/arus_kas/arus_kas/laporan_pdf', $data);
    }



    public function simpan_saldo()
    {
        $tahun = $this->input->post('tahun');
        $pagu  = $this->input->post('pagu');

        // pastikan format tanggal (tahun-01-01)
        $bulan = $tahun . '-01-01';

        $this->db->where('cabang_id', 23);
        $this->db->where('no_per_id', 100);
        $this->db->where('bulan', $bulan);
        $this->db->delete('rkap_arus_kas');

        $data = [
            'cabang_id' => 23,
            'no_per_id' => 100,
            'bulan'     => $bulan,
            'pagu'      => $pagu,
        ];

        $this->db->insert('rkap_arus_kas', $data);

        $this->session->set_flashdata(
            'info',
            '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Saldo Awal berhasil disimpan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/arus_kas/arus_kas');
    }
}
