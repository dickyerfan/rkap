<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_non_air extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_non_air');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['list_no_per'] = $this->db->get_where('no_per', ['kode' => '81.02'])->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        if ($upk) {
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk($upk, $tahun);
            // ambil nama UPK
            $nama_upk = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
            $nama_upk_text = $nama_upk ? $nama_upk->nama_upk : '';
            $data['title'] = 'RENCANA PENERIMAAN NON AIR UPK ' . strtoupper($nama_upk_text) . ' <br> TAHUN ANGGARAN ';
        } else {
            // kalau kosong tampilkan semua (konsolidasi)
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk(null, $tahun);
            $data['title'] = 'RENCANA PENERIMAAN NON AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $pendapatan = [];
        foreach ($data['data_pendapatan_na'] as $row) {
            $jenis = $row->jenis_pendapatan;
            $bulan = $row->bulan;
            $nilai = $row->nilai;

            // 1. Inisialisasi: Pastikan nilai awal di-set 0 jika belum ada.
            if (!isset($pendapatan[$jenis][$bulan])) {
                $pendapatan[$jenis][$bulan] = 0;
            }

            // 2. Penjumlahan/Konsolidasi: Tambahkan nilai ke total yang sudah ada.
            $pendapatan[$jenis][$bulan] += $nilai;
        }
        $data['pendapatan'] = $pendapatan;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_non_air/view_penerimaan_non_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['upk']   = $upk;
        $data['tahun'] = $tahun;

        if ($upk) {
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk($upk, $tahun);
            // ambil nama UPK
            $nama_upk = $this->db->get_where('rkap_nama_upk', ['id_upk' => $upk])->row();
            $nama_upk_text = $nama_upk ? $nama_upk->nama_upk : '';
            $data['title'] = 'RENCANA PENERIMAAN NON AIR UPK ' . strtoupper($nama_upk_text) . ' <br> TAHUN ANGGARAN ';
        } else {
            // kalau kosong tampilkan semua (konsolidasi)
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk(null, $tahun);
            $data['title'] = 'RENCANA PENERIMAAN NON AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $pendapatan = [];
        foreach ($data['data_pendapatan_na'] as $row) {
            $jenis = $row->jenis_pendapatan;
            $bulan = $row->bulan;
            $nilai = $row->nilai;

            // 1. Inisialisasi: Pastikan nilai awal di-set 0 jika belum ada.
            if (!isset($pendapatan[$jenis][$bulan])) {
                $pendapatan[$jenis][$bulan] = 0;
            }

            // 2. Penjumlahan/Konsolidasi: Tambahkan nilai ke total yang sudah ada.
            $pendapatan[$jenis][$bulan] += $nilai;
        }
        $data['pendapatan'] = $pendapatan;

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/penerimaan_non_air/laporan_pdf', $data);
    }

    public function generate()
    {
        $upk = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;
        $cabang_id = 24;
        $no_per_id = '81.02';

        // ambil data pendapatan sesuai yang tampil di index()
        $data_pendapatan_na = $this->Model_pendapatan_non_air->getPendapatanByUpk($upk, $tahun);

        // hitung total per jenis dan per bulan
        $pendapatan = [];
        foreach ($data_pendapatan_na as $row) {
            $jenis = $row->jenis_pendapatan;
            $bulan = (int)$row->bulan;
            $nilai = (float)$row->nilai;

            if (!isset($pendapatan[$jenis][$bulan])) {
                $pendapatan[$jenis][$bulan] = 0;
            }
            $pendapatan[$jenis][$bulan] += $nilai;
        }

        // hitung total semua jenis per bulan
        $total_per_bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $sum = 0;
            foreach ($pendapatan as $jenis => $bulanData) {
                $sum += isset($bulanData[$i]) ? $bulanData[$i] : 0;
            }
            $total_per_bulan[$i] = $sum;
        }

        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";

        $this->db->where('no_per_id', '81.02');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');

        // simpan hasil ke tabel rkap_arus_kas
        foreach ($total_per_bulan as $i => $nilai) {
            $bulan_date = sprintf('%04d-%02d-01', $tahun, $i);
            $data_insert = [
                'cabang_id' => $cabang_id,
                'no_per_id' => $no_per_id,
                'bulan'     => $bulan_date,
                'pagu'      => $nilai
            ];

            // bisa insert langsung
            $this->db->insert('rkap_arus_kas', $data_insert);
        }

        // beri notifikasi
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan non air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );

        redirect('lembar_kerja/arus_kas/penerimaan_non_air');
    }


    // public function generate()
    // {
    //     $upk = $this->session->userdata('upk');
    //     $tahun = $this->session->userdata('tahun_rkap');
    //     $cabang_id = 24;
    //     $no_per_id = '81.02';

    //     // ambil data pendapatan sesuai yang tampil di index()
    //     $data_pendapatan_na = $this->Model_pendapatan_non_air->getPendapatanByUpk($upk, $tahun);

    //     // hitung total per jenis dan per bulan
    //     $pendapatan = [];
    //     foreach ($data_pendapatan_na as $row) {
    //         $jenis = $row->jenis_pendapatan;
    //         $bulan = (int)$row->bulan;
    //         $nilai = (float)$row->nilai;

    //         if (!isset($pendapatan[$jenis][$bulan])) {
    //             $pendapatan[$jenis][$bulan] = 0;
    //         }
    //         $pendapatan[$jenis][$bulan] += $nilai;
    //     }

    //     // hitung total semua jenis per bulan (seperti baris "Jumlah" di view)
    //     $total_per_bulan = [];
    //     for ($i = 1; $i <= 12; $i++) {
    //         $sum = 0;
    //         foreach ($pendapatan as $jenis => $bulanData) {
    //             $sum += isset($bulanData[$i]) ? $bulanData[$i] : 0;
    //         }
    //         $total_per_bulan[$i] = $sum;
    //     }

    //     // simpan hasil ke tabel rkap_arus_kas
    //     foreach ($total_per_bulan as $i => $nilai) {
    //         $bulan_date = sprintf('%04d-%02d-01', $tahun, $i);

    //         // Cek apakah data sudah ada
    //         $cek = $this->db->get_where('rkap_arus_kas', [
    //             'cabang_id' => 24,
    //             'no_per_id' => '81.02',
    //             'bulan' => $bulan_date
    //         ])->row();

    //         $data_insert = [
    //             'cabang_id' => 24,
    //             'no_per_id' => '81.02',
    //             'bulan'     => $bulan_date,
    //             'pagu'      => $nilai
    //         ];


    //         $this->db->insert('rkap_arus_kas', $data_insert);
    //         // if ($cek) {
    //         //     // Jika sudah ada → update
    //         //     $this->db->where('no_per_id', '81.02');
    //         //     $this->db->where('bulan', $bulan_date);
    //         //     $this->db->update('rkap_arus_kas', $data_insert);
    //         // } else {
    //         //     // Jika belum ada → insert baru
    //         //     $this->db->insert('rkap_arus_kas', $data_insert);
    //         // }

    //         // Debug opsional
    //         // echo "<pre>Proses bulan $i - " . $this->db->last_query() . "</pre>";
    //     }
    //     // exit;

    //     $this->session->set_flashdata('info', 'Data berhasil di-generate ke tabel rkap_arus_kas');
    //     redirect('lembar_kerja/arus_kas/penerimaan_non_air');
    // }
}
