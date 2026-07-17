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

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $this->generate($id_upk, $tahun, $bulan);
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Pendapatan Non Air untuk 12 bulan berhasil di generate.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );

        redirect("lembar_kerja/lr/pendapatan_non_air?upk=$id_upk&tahun=$tahun");
    }

    public function form_manual()
    {
        $upk = $this->input->get('upk');
        $tahun_wajib = date('Y') + 1;
        $tahun = $this->input->get('tahun') ?: $tahun_wajib;

        if (!$upk) {
            redirect('lembar_kerja/lr/pendapatan_non_air');
        }

        if ($tahun != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Input data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect("lembar_kerja/lr/pendapatan_non_air?upk=$upk&tahun=$tahun_wajib");
            return;
        }

        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['upk'] = $upk;
        $data['tahun'] = $tahun;
        $data['title'] = 'Input Pendapatan Non Air Lainnya';

        // ambil data yang sudah ada
        $manual_jenis = [
            'Pendapatan Ganti Meter Rusak',
            'Pendapatan Penggatian Pipa Persil',
            'Pendapatan Non Air Lainnya'
        ];
        $data['existing'] = [];
        $this->db->where('id_upk', $upk);
        $this->db->where('tahun', $tahun);
        $this->db->where_in('jenis_pendapatan', $manual_jenis);
        foreach ($this->db->get('rkap_pendapatan_na')->result() as $row) {
            $data['existing'][$row->jenis_pendapatan][$row->bulan] = $row;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_non_air/form_manual', $data);
        $this->load->view('templates/footer');
    }

    public function save_manual()
    {
        $id_upk = $this->input->post('id_upk');
        $tahun  = $this->input->post('tahun');
        $tahun_wajib = date('Y') + 1;
        $nilai  = isset($_POST['nilai']) ? $_POST['nilai'] : [];

        if (empty($id_upk) || empty($tahun)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Data UPK atau Tahun tidak valid.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect("lembar_kerja/lr/pendapatan_non_air?upk=$id_upk&tahun=$tahun");
        }

        if ($tahun != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Input data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect("lembar_kerja/lr/pendapatan_non_air?upk=$id_upk&tahun=$tahun_wajib");
            return;
        }

        $map_jenis = [
            'Pendapatan_Ganti_Meter_Rusak' => 'Pendapatan Ganti Meter Rusak',
            'Pendapatan_Penggatian_Pipa_Persil' => 'Pendapatan Penggatian Pipa Persil',
            'Pendapatan_Non_Air_Lainnya' => 'Pendapatan Non Air Lainnya'
        ];

        foreach ($map_jenis as $safe_key => $jenis) {
            $kode_perkiraan = $this->Model_pendapatan_non_air->getNoPerId($id_upk, $jenis);
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $raw = (isset($nilai[$safe_key][$bulan]) && $nilai[$safe_key][$bulan] !== '') ? $nilai[$safe_key][$bulan] : '0';
                $raw = preg_replace('/[^0-9]/', '', $raw);
                $nilai_bersih = (int) $raw;

                $this->db->where([
                    'id_upk' => $id_upk,
                    'tahun'  => $tahun,
                    'bulan'  => $bulan,
                    'jenis_pendapatan' => $jenis
                ]);
                $cek = $this->db->get('rkap_pendapatan_na')->row();

                $data = [
                    'id_upk'           => $id_upk,
                    'tahun'            => $tahun,
                    'bulan'            => $bulan,
                    'jenis_pendapatan' => $jenis,
                    'jumlah'           => 0,
                    'nilai'            => $nilai_bersih,
                    'no_per_id'        => $kode_perkiraan
                ];

                if ($cek) {
                    $this->db->where('id', $cek->id);
                    $this->db->update('rkap_pendapatan_na', $data);
                } else {
                    $this->db->insert('rkap_pendapatan_na', $data);
                }

                $upk = $this->db->select('kode')->from('rkap_nama_upk')->where('id_upk', $id_upk)->get()->row();
                $cabang_id = $upk ? $upk->kode : null;
                $bulan_tgl = date('Y-m-d', strtotime("$tahun-$bulan-01"));

                $this->db->where(['id_upk' => $id_upk, 'no_per_id' => $kode_perkiraan, 'bulan' => $bulan_tgl]);
                $cek_rekap = $this->db->get('rkap_rekap')->row();

                $data_rekap = [
                    'id_upk'    => $id_upk,
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $kode_perkiraan,
                    'bulan'     => $bulan_tgl,
                    'pagu'      => $nilai_bersih
                ];

                if ($cek_rekap) {
                    $this->db->where('id', $cek_rekap->id);
                    $this->db->update('rkap_rekap', $data_rekap);
                } else {
                    $this->db->insert('rkap_rekap', $data_rekap);
                }
            }
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data Pendapatan Non Air Lainnya berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );

        redirect("lembar_kerja/lr/pendapatan_non_air?upk=$id_upk&tahun=$tahun");
    }

    public function generate($id_upk, $tahun, $bulan)
    {
        // === Baca tarif dari database (dinamis) ===
        $tarif_promo        = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Sambungan Baru', 'tarif_promo');
        $tarif_normal       = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Sambungan Baru', 'tarif_normal');
        $bulan_promo        = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Sambungan Baru', 'bulan_promo');
        $biaya_pendaftaran  = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Pendaftaran', 'biaya_pendaftaran');
        $persen_balik_nama  = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Balik Nama', 'persen_balik_nama');
        $nilai_balik_nama   = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Balik Nama', 'nilai_balik_nama');
        $biaya_psk          = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Penyambungan Kembali', 'biaya_psk');
        $persen_telat       = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Denda', 'persen_telat');
        $denda_per_pelanggan = $this->Model_pendapatan_non_air->getTarif($tahun, 'Pendapatan Denda', 'denda_per_pelanggan');

        // cek apakah bulan ini termasuk promo
        $arr_bulan_promo = array_map('trim', explode(',', $bulan_promo));
        $tarif = in_array($bulan, $arr_bulan_promo) ? $tarif_promo : $tarif_normal;

        // === 1. Hitung Sambungan Baru ===
        $jumlah_sambungan = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 2);
        $nilai_sambungan = $jumlah_sambungan * $tarif;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Sambungan Baru', $jumlah_sambungan, $nilai_sambungan);

        // === 2. Pendaftaran ===
        $nilai_pendaftaran = $jumlah_sambungan * $biaya_pendaftaran;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Pendaftaran', $jumlah_sambungan, $nilai_pendaftaran);

        // === 3. Balik Nama ===
        $idkd1 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 1);
        $idkd2 = $jumlah_sambungan; // id_kd=2
        $idkd3 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 3);
        $idkd4 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 4);
        $idkd5 = $this->Model_pendapatan_non_air->getJumlahByKd($id_upk, $tahun, $bulan, 5);

        $rumus = ($idkd1 + $idkd2 - $idkd3 + $idkd4 - $idkd5);
        $nilai_baliknama = $rumus * ($persen_balik_nama * $nilai_balik_nama);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Balik Nama', $rumus, $nilai_baliknama);

        // === 4. Penyambungan Kembali ===
        $jumlah_psk = $idkd4;
        $nilai_psk = $jumlah_psk * $biaya_psk;
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Penyambungan Kembali', $jumlah_psk, $nilai_psk);

        // === 5. Denda ===
        $nilai_denda = $rumus * ($persen_telat * $denda_per_pelanggan);
        $this->Model_pendapatan_non_air->savePendapatan($id_upk, $tahun, $bulan, 'Pendapatan Denda', $rumus, $nilai_denda);

        // === 6-8. Lainnya (d(input manual, tidak di-generate) ===
    }
}
