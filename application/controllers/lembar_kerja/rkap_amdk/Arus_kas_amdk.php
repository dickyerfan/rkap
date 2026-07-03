<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arus_kas_amdk extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
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

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        $this->session->set_userdata('tahun_rkap', $tahun);
        $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS AMDK <br> TAHUN ANGGARAN ";

        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'ARUS KAS OPERASI'],
            ['header' => 'PENERIMAAN'],
            ['kode' => '88.02', 'uraian' => 'Penerimaan Air'],
            ['kode' => '88.02.07', 'uraian' => 'Penerimaan Non Air'],
            ['kode' => '88.02.08', 'uraian' => 'Penerimaan Lain-lain'],
            // ['kode' => '', 'uraian' => 'Penerimaan Aktiva Lainnya'],
            ['header' => 'PENERIMAAN'],
            ['header' => 'PENGELUARAN'],
            ['kode' => '98.02.01', 'uraian' => 'Beban Pegawai'],
            ['kode' => '98.02.02', 'uraian' => 'Beban BBM'],
            ['kode' => '98.02.03', 'uraian' => 'Beban Kantor'],
            ['kode' => '98.02.04', 'uraian' => 'Beban Pemeliharaan'],
            ['kode' => '98.02.05', 'uraian' => 'Beban Pemakaian Barang AMDK'],
            ['kode' => '98.02.06', 'uraian' => 'Beban Rupa-rupa'],
            ['kode' => '98.02.07', 'uraian' => 'Beban Pemeriksaan SNI'],
            ['kode' => '98.02.08', 'uraian' => 'Beban Uji Kualitas Air'],
            ['kode' => '98.02.09', 'uraian' => 'Beban AMDK Lainnya'],
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


        $totals = $this->Model_arus_kas->getTotalsByCodesAmdk($tahun, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'penerimaan_air' => '88.02',
            'penerimaan_non_air' => '88.02.07',
            'penerimaan_lain_lain' => '88.02.08',
            // 'penerimaan_aktiva_lainnya' => '',
            'beban_pegawai' => '98.02.01',
            'beban_bbm' => '98.02.02',
            'beban_kantor' => '98.02.03',
            'beban_pemeliharaan' => '98.02.04',
            'beban_pemakaian_barang_amdk' => '98.02.05',
            'beban_rupa_rupa' => '98.02.06',
            'beban_pemeriksaan_sni' => '98.02.07',
            'beban_uji_kualitas_air' => '98.02.08',
            'beban_amdk_lainnya' => '98.02.09',
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
            ->from('rkap_amdk_arus_kas')
            ->where('no_per_id', 100)
            ->where('YEAR(bulan)', $tahun)
            ->get()
            ->row();

        $saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
        $data['saldo_awal_tahun'] = $saldo_awal_tahun;
        $data['tahun'] = $tahun;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/arus_kas_amdk/view_arus_kas', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/arus_kas_amdk/view_arus_kas', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function export_pdf()
    {
        $tahun = $this->session->userdata('tahun_rkap');
        $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS AMDK <br> TAHUN ANGGARAN ";
        $format = [
            ['header' => 'ARUS KAS OPERASI'],
            ['header' => 'PENERIMAAN'],
            ['kode' => '88.02', 'uraian' => 'Penerimaan Air'],
            ['kode' => '88.02.07', 'uraian' => 'Penerimaan Non Air'],
            ['kode' => '88.02.08', 'uraian' => 'Penerimaan Lain-lain'],
            // ['kode' => '', 'uraian' => 'Penerimaan Aktiva Lainnya'],
            ['header' => 'PENERIMAAN'],
            ['header' => 'PENGELUARAN'],
            ['kode' => '98.02.01', 'uraian' => 'Beban Pegawai'],
            ['kode' => '98.02.02', 'uraian' => 'Beban BBM'],
            ['kode' => '98.02.03', 'uraian' => 'Beban Kantor'],
            ['kode' => '98.02.04', 'uraian' => 'Beban Pemeliharaan'],
            ['kode' => '98.02.05', 'uraian' => 'Beban Pemakaian Barang AMDK'],
            ['kode' => '98.02.06', 'uraian' => 'Beban Rupa-rupa'],
            ['kode' => '98.02.07', 'uraian' => 'Beban Pemeriksaan SNI'],
            ['kode' => '98.02.08', 'uraian' => 'Beban Uji Kualitas Air'],
            ['kode' => '98.02.09', 'uraian' => 'Beban AMDK Lainnya'],
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


        $totals = $this->Model_arus_kas->getTotalsByCodesAmdk($tahun, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'penerimaan_air' => '88.02',
            'penerimaan_non_air' => '88.02.07',
            'penerimaan_lain_lain' => '88.02.08',
            // 'penerimaan_aktiva_lainnya' => '',
            'beban_pegawai' => '98.02.01',
            'beban_bbm' => '98.02.02',
            'beban_kantor' => '98.02.03',
            'beban_pemeliharaan' => '98.02.04',
            'beban_pemakaian_barang_amdk' => '98.02.05',
            'beban_rupa_rupa' => '98.02.06',
            'beban_pemeriksaan_sni' => '98.02.07',
            'beban_uji_kualitas_air' => '98.02.08',
            'beban_amdk_lainnya' => '98.02.09',
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
            ->from('rkap_amdk_arus_kas')
            ->where('no_per_id', 100)
            ->where('YEAR(bulan)', $tahun)
            ->get()
            ->row();

        $saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
        $data['saldo_awal_tahun'] = $saldo_awal_tahun;
        $data['tahun'] = $tahun;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_arus_kas_{$tahun}" . ".pdf";

        $this->pdf->generate('lembar_kerja/rkap_amdk/arus_kas_amdk/laporan_pdf', $data);
    }

    // public function index()
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
    //     $this->session->set_userdata('tahun_rkap', $tahun);

    //     $title = "ANGGARAN PENERIMAAN DAN PENGELUARAN KAS AMDK <br> TAHUN ANGGARAN ";

    //     // ====== FORMAT SESUAI EXCEL ======
    //     $format = [
    //         ['header' => 'ARUS KAS OPERASI'],
    //         ['header' => 'PENERIMAAN'],
    //         ['kode' => '88.02.01', 'uraian' => 'Penjualan Air Galon'],
    //         ['kode' => '88.02.02', 'uraian' => 'Penjualan Air Gelas 220ml'],
    //         ['kode' => '88.02.03', 'uraian' => 'Penjualan Air Botol 330ml'],
    //         ['kode' => '88.02.04', 'uraian' => 'Penjualan Air Botol 500ml'],
    //         ['kode' => '88.02.05', 'uraian' => 'Penjualan Air Botol 250ml'],
    //         ['kode' => '88.02.06', 'uraian' => 'Penjualan Air Botol 1500ml'],

    //         ['kode' => '88.02.07', 'uraian' => 'Penerimaan Non Air'],
    //         ['kode' => '88.02.08', 'uraian' => 'Penerimaan Lain-lain'],

    //         ['header' => 'PENGELUARAN'],
    //         ['kode' => '98.02.01', 'uraian' => 'Beban Pegawai'],
    //         ['kode' => '98.02.02', 'uraian' => 'Beban BBM'],
    //         ['kode' => '98.02.03', 'uraian' => 'Beban Kantor'],
    //         ['kode' => '98.02.04', 'uraian' => 'Beban Pemeliharaan'],
    //         ['kode' => '98.02.05', 'uraian' => 'Beban Pemakaian Barang AMDK'],
    //         ['kode' => '98.02.06', 'uraian' => 'Beban Rupa-rupa'],
    //         ['kode' => '98.02.07', 'uraian' => 'Beban Pemeriksaan SNI'],
    //         ['kode' => '98.02.08', 'uraian' => 'Beban Uji Kualitas Air'],
    //         ['kode' => '98.02.09', 'uraian' => 'Beban AMDK Lainnya'],

    //         ['header' => 'INVESTASI'],
    //         ['kode' => '31', 'uraian' => 'Arus Kas Investasi'],

    //         ['header' => 'PENDANAAN'],
    //         ['kode' => '62', 'uraian' => 'Pembayaran Jasa Produksi dan Tantiem'],
    //         ['header' => 'ARUS KAS BERSIH UNTUK AKTIVITAS  PENDANAAN'],
    //         ['header' => 'KENAIKAN /BERKURANG BERSIH KAS DAN SETARA KAS'],
    //         ['header' => 'SALDO KAS SETARA KAS AWAL TAHUN'],
    //         ['header' => 'SALDO KAS SETARA KAS AKHIR TAHUN'],
    //     ];

    //     // ====== Ambil total untuk semua kode ======
    //     $totals = $this->Model_arus_kas->getTotalsByFormat($tahun, $format);

    //     // ====== Mapping ke variabel lama yg dipakai view ======
    //     $mapVar = [
    //         'penerimaan_air'               => ['88.02.01', '88.02.02', '88.02.03', '88.02.04', '88.02.05', '88.02.06'],
    //         'penerimaan_non_air'           => ['88.02.07'],
    //         'penerimaan_lain_lain'         => ['88.02.08'],

    //         'beban_pegawai'                => ['98.02.01'],
    //         'beban_bbm'                    => ['98.02.02'],
    //         'beban_kantor'                 => ['98.02.03'],
    //         'beban_pemeliharaan'          => ['98.02.04'],
    //         'beban_pemakaian_barang_amdk' => ['98.02.05'],
    //         'beban_rupa_rupa'              => ['98.02.06'],
    //         'beban_pemeriksaan_sni'        => ['98.02.07'],
    //         'beban_uji_kualitas_air'       => ['98.02.08'],
    //         'beban_amdk_lainnya'          => ['98.02.09'],

    //         'investasi'                    => ['31'],
    //         'jasa_produksi'                => ['62'],
    //     ];

    //     foreach ($mapVar as $varName => $kodeList) {

    //         $data[$varName] = array_fill(1, 12, 0);
    //         $data[$varName . '_total'] = 0;

    //         foreach ($kodeList as $kode) {
    //             if (isset($totals[$kode])) {
    //                 for ($i = 1; $i <= 12; $i++) {
    //                     $data[$varName][$i] += $totals[$kode]['bulan'][$i];
    //                 }
    //                 $data[$varName . '_total'] += $totals[$kode]['total'];
    //             }
    //         }
    //     }

    //     // SALDO AWAL
    //     $q = $this->db->select('pagu')
    //         ->from('rkap_amdk_arus_kas')
    //         ->where('no_per_id', 100)
    //         ->where('YEAR(bulan)', $tahun)
    //         ->get()->row();
    //     $data['saldo_awal_tahun'] = $q ? (float)$q->pagu : 0;

    //     // data view
    //     $data['tahun'] = $tahun;
    //     $data['title'] = $title;
    //     $data['format_template'] = $format;

    //     // render
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/rkap_amdk/arus_kas_amdk/view_arus_kas', $data);
    //     $this->load->view('templates/footer');
    // }

    public function simpan_saldo()
    {
        $tahun = $this->input->post('tahun');
        $pagu  = $this->input->post('pagu');

        // pastikan format tanggal (tahun-01-01)
        $bulan = $tahun . '-01-01';

        $this->db->where('no_per_id', 100);
        $this->db->where('bulan', $bulan);
        $this->db->delete('rkap_amdk_arus_kas');

        $data = [
            'no_per_id' => 100,
            'bulan'     => $bulan,
            'pagu'      => $pagu,
        ];

        $this->db->insert('rkap_amdk_arus_kas', $data);

        $this->session->set_flashdata(
            'info',
            '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Saldo Awal berhasil disimpan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/rkap_amdk/arus_kas_amdk');
    }
}
