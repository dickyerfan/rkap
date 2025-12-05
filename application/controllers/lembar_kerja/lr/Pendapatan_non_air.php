<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_non_air extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
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
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
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
            $data['title'] = 'RENCANA PENDAPATAN NON AIR UPK ' . strtoupper($nama_upk_text) . ' <br> TAHUN ANGGARAN ';
        } else {
            // kalau kosong tampilkan semua (konsolidasi)
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk(null, $tahun);
            $data['title'] = 'RENCANA PENDAPATAN NON AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
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
        $this->load->view('lembar_kerja/lr/pendapatan_non_air/view_pendapatan_non_air', $data);
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
            $data['title'] = 'RENCANA PENDAPATAN NON AIR UPK ' . strtoupper($nama_upk_text) . ' <br> TAHUN ANGGARAN ';
        } else {
            // kalau kosong tampilkan semua (konsolidasi)
            $data['data_pendapatan_na']  = $this->Model_pendapatan_non_air->getPendapatanByUpk(null, $tahun);
            $data['title'] = 'RENCANA PENDAPATAN NON AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
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
        $this->pdf->filename = "Lap_pendapatan_non_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/pendapatan_non_air/laporan_pdf', $data);
    }

    public function form_generate()
    {
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Form Generate Data Pendapatan Non Air';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_non_air/upload_form_generate', $data);
        $this->load->view('templates/footer');
    }

    public function proses_generate()
    {
        $id_upk = $this->input->post('id_upk');
        $tahun  = $this->input->post('tahun');
        $bulan  = $this->input->post('bulan');

        // panggil fungsi generate
        $this->generate($id_upk, $tahun, $bulan);

        // redirect ke laporan
        // redirect("lembar_kerja/lr/pendapatan_non_air/laporan/$id_upk/$tahun/$bulan");
        redirect("lembar_kerja/lr/pendapatan_non_air");
    }

    public function generate($id_upk, $tahun, $bulan)
    {
        // === 1. Hitung Sambungan Baru ===
        $jumlah_sambungan = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 2);
        $tarif = ($bulan == 1 || $bulan == 8) ? 500000 : 1000000;
        $nilai_sambungan = $jumlah_sambungan * $tarif;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Sambungan Baru', $jumlah_sambungan, $nilai_sambungan);

        // === 2. Pendaftaran ===
        $nilai_pendaftaran = $jumlah_sambungan * 10000;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Pendaftaran', $jumlah_sambungan, $nilai_pendaftaran);

        // === 3. Balik Nama ===
        $idkd1 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 1);
        $idkd2 = $jumlah_sambungan; // id_kd=2
        $idkd3 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 3);
        $idkd4 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 4);
        $idkd5 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 5);

        $rumus = ($idkd1 + $idkd2 - $idkd3 + $idkd4 - $idkd5);
        $nilai_baliknama = $rumus * (0.002 * 50000);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Balik Nama', $rumus, $nilai_baliknama);

        // === 4. Penyambungan Kembali ===
        $jumlah_psk = $idkd4;
        $nilai_psk = $jumlah_psk * 15000;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Penyambungan Kembali', $jumlah_psk, $nilai_psk);

        // === 5. Denda ===
        $nilai_denda = $rumus * (0.35 * 10000);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Denda', $rumus, $nilai_denda);

        // === 6-8. Lainnya sementara nol ===
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Ganti Meter Rusak', 0, 0);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Penggatian Pipa Persil', 0, 0);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Non Air Lainnya', 0, 0);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Pendapatan Non Air berhasil di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect("lembar_kerja/lr/pendapatan_non_air?upk=$id_upk" . "&tahun_rkap=$tahun");

        // echo "Pendapatan Non Air berhasil digenerate untuk UPK: $id_upk, Bulan: $bulan, Tahun: $tahun";
    }
}
