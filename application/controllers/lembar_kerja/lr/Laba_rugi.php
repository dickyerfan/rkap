<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laba_rugi extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
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
            $title = "PROYEKSI LABA RUGI <br> UPK " . strtoupper($list_upk[$upk]) . "  TAHUN ANGGARAN ";
        } else {
            $title = "PROYEKSI LABA RUGI <br> TAHUN ANGGARAN ";
        }
        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'PENDAPATAN'],
            ['header' => 'PENDAPATAN USAHA'],
            ['kode' => '81.01', 'uraian' => 'Pendapatan Air'],
            ['kode' => '81.02', 'uraian' => 'Pendapatan Non Air'],
            ['kode' => '81.03', 'uraian' => 'Pendapatan Usaha Lainnya'],
            ['header' => 'PENDAPATAN USAHA'],
            ['header' => 'BEBAN USAHA'],
            ['kode' => '91', 'uraian' => 'Beban Sumber Air'],
            ['kode' => '92', 'uraian' => 'Beban Pengolahan Air'],
            ['kode' => '93', 'uraian' => 'Beban Transmisi dan Distribusi'],
            ['kode' => '95', 'uraian' => 'Beban (HPP) Sambungan baru'],
            ['header' => 'BEBAN USAHA'],
            ['header' => 'LABA / (RUGI) KOTOR'],
            ['header' => 'BEBAN UMUM DAN ADMINISTRASI'],
            ['kode' => '96', 'uraian' => 'Beban Umum dan Administrasi'],
            ['header' => 'BEBAN UMUM DAN ADMINISTRASI'],
            ['header' => 'LABA / (RUGI) OPERASIONAL'],
            ['header' => 'PENDAPATAN (BEBAN) NON OPERASIONAL'],
            ['kode' => '88', 'uraian' => 'Pendapatan Non Operasional'],
            ['kode' => '98', 'uraian' => 'Beban Non Operasional'],
            ['header' => 'JUMLAH PENDAPATAN (BEBAN) NON OPERASIONAL'],
            ['header' => 'LABA SEBELUM PAJAK'],
            ['header' => 'KEUNTUNGAN/(KERUGIAN) LUAR BIASA'],
            ['kode' => '89.01.01', 'uraian' => 'Keuntungan Luar Biasa'],
            ['kode' => '99.01.01', 'uraian' => 'Kerugian Luar Biasa'],
            ['header' => 'JUMLAH KEUNTUNGAN/(KERUGIAN) LUAR BIASA'],
            ['header' => 'PAJAK PENGHASILAN'],
            ['kode' => '97.01.01', 'uraian' => 'Taksiran Pajak (pasal 25)'],
            ['kode' => '97.01.02', 'uraian' => 'Pajak Kini'],
            ['kode' => '97.01.03', 'uraian' => 'Beban Pajak Ditangguhkan'],
            ['header' => 'LABA / (RUGI) SETELAH PAJAK'],
        ];

        // ambil list kode yang ada di format (hanya entri yang punya key 'kode')
        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) $codes[] = $f['kode'];
        }


        $totals = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'pendapatan_air' => '81.01',
            'pendapatan_non_air' => '81.02',
            'pendapatan_usaha_lainnya' => '81.03',
            'beban_sumber_air' => '91',
            'beban_pengolahan' => '92',
            'beban_transmisi' => '93',
            'beban_sambungan' => '95',
            'beban_umum' => '96',
            'pendapatan_non_operasional' => '88',
            'beban_non_operasional' => '98',
            'keuntungan_luar_biasa' => '89.01.01',
            'kerugian_luar_biasa' => '99.01.01',
            'pajak_25' => '97.01.01',
            'pajak_kini' => '97.01.02',
            'pajak_tangguh' => '97.01.03'
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

        $data['tahun'] = $tahun;
        $data['upk']   = $upk;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/laba_rugi/view_laba_rugi', $data);
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
            $title = "PROYEKSI LABA RUGI  <br> UPK " . strtoupper($list_upk[$upk]) . "  TAHUN ANGGARAN ";
        } else {
            $title = "PROYEKSI LABA RUGI  <br> TAHUN ANGGARAN ";
        }
        // definisi format (sama seperti yang Anda pakai)
        $format = [
            ['header' => 'PENDAPATAN'],
            ['header' => 'PENDAPATAN USAHA'],
            ['kode' => '81.01', 'uraian' => 'Pendapatan Air'],
            ['kode' => '81.02', 'uraian' => 'Pendapatan Non Air'],
            ['kode' => '81.03', 'uraian' => 'Pendapatan Usaha Lainnya'],
            ['header' => 'PENDAPATAN USAHA'],
            ['header' => 'BEBAN USAHA'],
            ['kode' => '91', 'uraian' => 'Beban Sumber Air'],
            ['kode' => '92', 'uraian' => 'Beban Pengolahan Air'],
            ['kode' => '93', 'uraian' => 'Beban Transmisi dan Distribusi'],
            ['kode' => '95', 'uraian' => 'Beban (HPP) Sambungan baru'],
            ['header' => 'BEBAN USAHA'],
            ['header' => 'LABA / (RUGI) KOTOR'],
            ['header' => 'BEBAN UMUM DAN ADMINISTRASI'],
            ['kode' => '96', 'uraian' => 'Beban Umum dan Administrasi'],
            ['header' => 'BEBAN UMUM DAN ADMINISTRASI'],
            ['header' => 'LABA / (RUGI) OPERASIONAL'],
            ['header' => 'PENDAPATAN (BEBAN) NON OPERASIONAL'],
            ['kode' => '88', 'uraian' => 'Pendapatan Non Operasional'],
            ['kode' => '98', 'uraian' => 'Beban Non Operasional'],
            ['header' => 'JUMLAH PENDAPATAN (BEBAN) NON OPERASIONAL'],
            ['header' => 'LABA SEBELUM PAJAK'],
            ['header' => 'KEUNTUNGAN/(KERUGIAN) LUAR BIASA'],
            ['kode' => '89.01.01', 'uraian' => 'Keuntungan Luar Biasa'],
            ['kode' => '99.01.01', 'uraian' => 'Kerugian Luar Biasa'],
            ['header' => 'JUMLAH KEUNTUNGAN/(KERUGIAN) LUAR BIASA'],
            ['header' => 'PAJAK PENGHASILAN'],
            ['kode' => '97.01.01', 'uraian' => 'Taksiran Pajak (pasal 25)'],
            ['kode' => '97.01.02', 'uraian' => 'Pajak Kini'],
            ['kode' => '97.01.03', 'uraian' => 'Beban Pajak Ditangguhkan'],
            ['header' => 'LABA / (RUGI) SETELAH PAJAK'],
        ];

        // ambil list kode yang ada di format (hanya entri yang punya key 'kode')
        $codes = [];
        foreach ($format as $f) {
            if (isset($f['kode'])) $codes[] = $f['kode'];
        }


        $totals = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codes);
        // $totals[$code] => ['bulan'=>[1..12], 'total'=>...]

        // mapping ke variabel yang view lama gunakan (supaya kompatibel)
        $mapVar = [
            'pendapatan_air' => '81.01',
            'pendapatan_non_air' => '81.02',
            'pendapatan_usaha_lainnya' => '81.03',
            'beban_sumber_air' => '91',
            'beban_pengolahan' => '92',
            'beban_transmisi' => '93',
            'beban_sambungan' => '95',
            'beban_umum' => '96',
            'pendapatan_non_operasional' => '88',
            'beban_non_operasional' => '98',
            'keuntungan_luar_biasa' => '89.01.01',
            'kerugian_luar_biasa' => '99.01.01',
            'pajak_25' => '97.01.01',
            'pajak_kini' => '97.01.02',
            'pajak_tangguh' => '97.01.03'
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

        $data['tahun'] = $tahun;
        $data['upk']   = $upk;
        $data['title'] = $title;
        $data['laporan'] = $totals;
        $data['format_template'] = $format;

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_laba_rugi_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        $this->pdf->generate('lembar_kerja/lr/laba_rugi/laporan_pdf', $data);
    }


    public function pajak()
    {
        $data['title'] = "PERHITUNGAN FISKAL PPh PASAL 29 TAHUN ";

        // ambil upk dari session atau default
        $upk   = $this->session->userdata('upk') ?: 'all';
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        // ambil data laba rugi dari model
        $codes = ['81.01', '81.02', '81.03', '91', '92', '93', '95', '96', '88', '98'];
        $totals = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codes);

        // hitung laba/rugi komersial (laba sebelum pajak)
        $pendapatan = ($totals['81.01']['total'] ?? 0)
            + ($totals['81.02']['total'] ?? 0)
            + ($totals['81.03']['total'] ?? 0)
            + ($totals['88']['total'] ?? 0);

        $beban = ($totals['91']['total'] ?? 0)
            + ($totals['92']['total'] ?? 0)
            + ($totals['93']['total'] ?? 0)
            + ($totals['95']['total'] ?? 0)
            + ($totals['96']['total'] ?? 0)
            + ($totals['98']['total'] ?? 0);

        $laba_komersial = $pendapatan - $beban;

        $next_year = $tahun;
        $get_sum = function ($no_per_id) use ($upk, $next_year) {
            $this->db->select_sum('pagu');
            $this->db->like('no_per_id', $no_per_id, 'after');
            $this->db->where('YEAR(bulan)', $next_year);
            if ($upk !== 'all') {
                $this->db->where('upk', $upk);
            }
            $row = $this->db->get('rkap_rekap')->row();
            return $row ? $row->pagu : 0;
        };

        $beban_representasi = $get_sum->call($this, '96.08.14.10');
        $beban_penyisihan_piutang = $get_sum->call($this, '96.07.01');
        $pendapatan_bunga = $get_sum->call($this, '88.01');

        // BEBAN RAPAT DAN TAMU (sementara 0)
        $beban_rapat_dan_tamu = 0;
        $koreksi_ppn_masukan_amdk = 0;

        // koreksi fiskal positif & negatif
        $koreksi_fiskal_positif = $beban_rapat_dan_tamu + $beban_representasi + $beban_penyisihan_piutang + $koreksi_ppn_masukan_amdk;
        $koreksi_fiskal_negatif = $pendapatan_bunga;

        // laba setelah koreksi fiskal
        $laba_fiskal = ($laba_komersial + $koreksi_fiskal_positif) - $koreksi_fiskal_negatif;

        // nilai tetap dan rasio
        $nilai_tetap = 4800000000;
        // total pendapatan (sesuai catatan Anda: total pendapatan usaha + pendapatan non operasional)
        $total_pendapatan = $pendapatan; // jika perlu tambahkan non-operasional lain, adjust di sini
        $rasio = ($total_pendapatan > 0) ? $nilai_tetap / $total_pendapatan : 0;

        // bagian 1 = proporsi * laba fiskal
        $bagian1 = $laba_fiskal * $rasio;

        // ===== PERBAIKAN: tarif bagian1 sesuai Excel = 25% x 25% x bagian1 =====
        $pajak_bagian1 = 0.25 * 0.25 * $bagian1; // = 0.0625 * bagian1

        // bagian 2 = 12% atas sisa (laba fiskal - bagian1)
        $sisa_laba = $laba_fiskal - $bagian1;
        $pajak_bagian2 = 0.12 * $sisa_laba;

        // total pajak terutang = bagian1 + bagian2
        $pajak_terutang = $pajak_bagian1 + $pajak_bagian2;

        // pembulatan ke ribuan terdekat (sama seperti Excel Anda)
        $pajak_bulat = floor($pajak_terutang / 1000) * 1000;

        // pajak per bulan (dibagi 12)
        $pajak_per_bulan = $pajak_bulat / 12;

        $this->session->set_userdata('pajak_per_bulan', $pajak_per_bulan);

        $data['upk'] = $upk;
        $data['tahun'] = $tahun;
        $data['laba_komersial'] = $laba_komersial;
        $data['koreksi_fiskal_positif'] = $koreksi_fiskal_positif;
        $data['koreksi_fiskal_negatif'] = $koreksi_fiskal_negatif;
        $data['beban_representasi'] = $beban_representasi;
        $data['beban_penyisihan_piutang'] = $beban_penyisihan_piutang;
        $data['pendapatan_bunga'] = $pendapatan_bunga;
        $data['beban_rapat_dan_tamu'] = $beban_rapat_dan_tamu;
        $data['koreksi_ppn_masukan_amdk'] = $koreksi_ppn_masukan_amdk;
        $data['laba_fiskal'] = $laba_fiskal;
        $data['nilai_tetap'] = $nilai_tetap;
        $data['rasio'] = $rasio;
        $data['bagian1'] = $bagian1;
        $data['pajak_bagian1'] = $pajak_bagian1;
        $data['pajak_bagian2'] = $pajak_bagian2;
        $data['pajak_terutang'] = $pajak_terutang;
        $data['pajak_bulat'] = $pajak_bulat;
        $data['pajak_per_bulan'] = $pajak_per_bulan;
        $data['total_pendapatan'] = $total_pendapatan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/laba_rugi/view_pajak', $data);
        $this->load->view('templates/footer');
    }

    // public function generate_pajak()
    // {

    //     $pajak_per_bulan = $this->session->userdata('pajak_per_bulan');

    //     if (!$pajak_per_bulan) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Error!</strong> Gagal menyimpan data pajak kini ke laporan laba rugi.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //         );
    //         redirect('lembar_kerja/lr/laba_rugi/pajak');
    //     }

    //     $cabang_id = 24;
    //     $no_per_id = '97.01.02';
    //     $tahun = date('Y') + 1;

    //     // 🔹 Hapus data lama (jika ingin replace otomatis)
    //     $this->db->where('cabang_id', $cabang_id);
    //     $this->db->where('no_per_id', $no_per_id);
    //     $this->db->where('YEAR(bulan)', $tahun);
    //     $this->db->delete('rkap_rekap');

    //     // 🔹 Loop untuk generate 12 bulan
    //     for ($bulan = 1; $bulan <= 12; $bulan++) {
    //         $tanggal = sprintf('%04d-%02d-01', $tahun, $bulan);

    //         $data_insert = [
    //             'cabang_id' => $cabang_id,
    //             'no_per_id' => $no_per_id,
    //             'bulan'     => $tanggal,
    //             'pagu'      => $pajak_per_bulan
    //         ];

    //         $this->db->insert('rkap_rekap', $data_insert);
    //     }
    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Sukses!</strong> pajak kini berhasil tersimpan ke laporan laba rugi.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //     );
    //     redirect('lembar_kerja/lr/laba_rugi/pajak');
    // }

    public function generate_pajak()
    {
        $pajak_per_bulan = $this->session->userdata('pajak_per_bulan');

        if (!$pajak_per_bulan) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data pajak kini ke laporan laba rugi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/laba_rugi/pajak');
        }

        $cabang_id = 24;
        $tahun = date('Y') + 1;

        $list_no_per_id = ['97.01.02', '50.05.03'];
        foreach ($list_no_per_id as $no_per_id) {

            // 🔹 Hapus data lama (berdasarkan $no_per_id dari loop)
            $this->db->where('cabang_id', $cabang_id);
            $this->db->where('no_per_id', $no_per_id);
            $this->db->where('YEAR(bulan)', $tahun);
            $this->db->delete('rkap_rekap');

            // 🔹 Loop untuk generate 12 bulan
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $tanggal = sprintf('%04d-%02d-01', $tahun, $bulan);

                $data_insert = [
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $no_per_id,
                    'bulan'     => $tanggal,
                    'pagu'      => $pajak_per_bulan
                ];

                $this->db->insert('rkap_rekap', $data_insert);
            }
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> pajak kini berhasil tersimpan ke laporan laba rugi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/lr/laba_rugi/pajak');
    }
}
