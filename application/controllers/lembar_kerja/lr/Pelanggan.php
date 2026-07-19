<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Pelanggan extends CI_Controller
class Pelanggan extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pelanggan');
        $this->load->model('Model_status');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun_rkap'] = $tahun;

        $data['upk'] = $upk;
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        if ($upk) {
            $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun, $upk);
            // ambil nama_upk dari data hasil query
            $nama_upk = $data['data_pelanggan'][0]['nama_upk'] ?? '';

            $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun);
            $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // master daftar kategori (kategori_data)
        $kategori_rows = $this->db->order_by('id_kd')->get('rkap_kategori_data')->result_array();
        if (!empty($kategori_rows)) {
            $data['kategori_list'] = array_map(function ($r) {
                return trim($r['nama_kd']);
            }, $kategori_rows);
        } else {
            // fallback jika belum punya tabel kategori_data
            $data['kategori_list'] = [
                'Samb Aktif Awal Bulan',
                'Jumlah Sambungan Baru',
                'Jumlah Penutupan Pelanggan',
                'Penyamb Kembali Pelanggan',
                'Jumlah Pencabutan Pelanggan',
                'Samb Aktif Akhir Bulan'
            ];
        }

        // master daftar jenis pelanggan (jenis_pelanggan)
        $jenis_rows = $this->db->order_by('id_jp')->get('rkap_jenis_plgn')->result_array();
        if (!empty($jenis_rows)) {
            $data['jenis_list'] = array_map(function ($r) {
                return trim($r['nama_jp']);
            }, $jenis_rows);
        } else {
            // fallback manual (samakan dengan yang ada di Excel Anda)
            $data['jenis_list'] = [
                'Sosial A', 'Sosial B', 'Rumah Tangga A', 'Rumah Tangga B', 'Rumah Tangga C',
                'Instansi Pemerintah A', 'Instansi Pemerintah B', 'ABRI', 'Niaga A', 'Niaga B', 'Khusus 2'
            ];
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/perkembangan_pelanggan/view_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['upk']   = $upk;
        $data['tahun'] = $tahun;

        if ($upk && $upk !== 'SEMUA') {
            $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun, $upk);

            $nama_upk = $data['data_pelanggan'][0]['nama_upk'] ?? '';
            $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $data['data_pelanggan'] = $this->Model_pelanggan->getDataPelanggan($tahun);
            $data['title'] = 'RENCANA PERKEMBANGAN SAMBUNGAN PELANGGAN (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // Ambil master kategori & jenis (sama seperti di index)
        $kategori_rows = $this->db->order_by('id_kd')->get('rkap_kategori_data')->result_array();
        $data['kategori_list'] = !empty($kategori_rows)
            ? array_map(fn ($r) => trim($r['nama_kd']), $kategori_rows)
            : [
                'Samb Aktif Awal Bulan', 'Jumlah Sambungan Baru', 'Jumlah Penutupan Pelanggan',
                'Penyamb Kembali Pelanggan', 'Jumlah Pencabutan Pelanggan', 'Samb Aktif Akhir Bulan'
            ];

        $jenis_rows = $this->db->order_by('id_jp')->get('rkap_jenis_plgn')->result_array();
        $data['jenis_list'] = !empty($jenis_rows)
            ? array_map(fn ($r) => trim($r['nama_jp']), $jenis_rows)
            : [
                'Sosial A', 'Sosial B', 'Rumah Tangga A', 'Rumah Tangga B', 'Rumah Tangga C',
                'Instansi Pemerintah A', 'Instansi Pemerintah B', 'ABRI', 'Niaga A', 'Niaga B', 'Khusus 2'
            ];

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_perkembangan_Pelanggan_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/perkembangan_pelanggan/laporan_pdf', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Input Data Perkembangan Pelanggan';
        $data['upk_list'] = $this->db->get('rkap_nama_upk')->result();
        $data['jenis_list'] = $this->db->get('rkap_jenis_plgn')->result();

        $id_upk = $this->input->get('id_upk');
        $id_jp  = $this->input->get('id_jp');
        $tahun  = $this->input->get('tahun');

        $data['selected_id_upk'] = $id_upk;
        $data['selected_id_jp']  = $id_jp;
        $data['selected_tahun']  = $tahun;

        $existing = [];
        if ($id_upk && $id_jp && $tahun) {
            $rows = $this->db->get_where('rkap_pelanggan', [
                'id_upk' => $id_upk,
                'id_jp'  => $id_jp,
                'tahun'  => $tahun
            ])->result();
            foreach ($rows as $r) {
                $existing[$r->bulan][$r->id_kd] = $r->jumlah;
            }
        }
        $data['existing'] = $existing;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/perkembangan_pelanggan/upload_pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function insert_data()
    {
        $id_upk = $this->input->post('id_upk');
        $id_jp  = $this->input->post('id_jp');
        $tahun  = $this->input->post('tahun');

        $s_baru_arr     = $this->input->post('s_baru');
        $penutupan_arr  = $this->input->post('penutupan');
        $pembukaan_arr  = $this->input->post('pembukaan');
        $pencabutan_arr = $this->input->post('pencabutan');

        $kd_awal  = 1;
        $kd_baru  = 2;
        $kd_tutup = 3;
        $kd_buka  = 4;
        $kd_cabut = 5;
        $kd_akhir = 6;

        $now = date('Y-m-d H:i:s');

        $s_awal = 0;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            if ($bulan == 1) {
                $s_awal = (int) ($this->input->post('s_awal_1') ?: 0);
                if ($s_awal == 0) {
                    $existing_s_awal = $this->Model_pelanggan->get_jumlah($id_upk, $id_jp, $kd_awal, $tahun, 1);
                    if ($existing_s_awal > 0) {
                        $s_awal = $existing_s_awal;
                    }
                }
            }

            $s_baru = isset($s_baru_arr[$bulan]) ? (int) $s_baru_arr[$bulan] : 0;
            $tutup  = isset($penutupan_arr[$bulan]) ? (int) $penutupan_arr[$bulan] : 0;
            $buka   = isset($pembukaan_arr[$bulan]) ? (int) $pembukaan_arr[$bulan] : 0;
            $cabut  = isset($pencabutan_arr[$bulan]) ? (int) $pencabutan_arr[$bulan] : 0;

            $s_akhir = $s_awal + $s_baru - $tutup + $buka - $cabut;

            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_awal,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $s_awal,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);
            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_baru,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $s_baru,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);
            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_tutup,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $tutup,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);
            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_buka,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $buka,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);
            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_cabut,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $cabut,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);
            $this->Model_pelanggan->save_or_update([
                'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_akhir,
                'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $s_akhir,
                'tgl_update' => $now, 'tgl_upload' => $now
            ]);

            $s_awal = $s_akhir;
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data Pelanggan berhasil di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/lr/pelanggan?upk=' . $id_upk . '&tahun_rkap=' . $tahun);
    }

    private function propagate_recursive($id_upk, $id_jp, $tahun, $bulan, $s_awal)
    {
        if ($bulan > 12) return;

        $kd_awal  = 1;
        $kd_baru  = 2;
        $kd_tutup = 3;
        $kd_buka  = 4;
        $kd_cabut = 5;
        $kd_akhir = 6;

        $now = date('Y-m-d H:i:s');

        // sambungan awal bulan ini = akhir bulan sebelumnya
        $this->Model_pelanggan->save_or_update([
            'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_awal,
            'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $s_awal,
            'tgl_update' => $now, 'tgl_upload' => $now
        ]);

        // ambil input kategori lain bulan ini
        $baru  = $this->Model_pelanggan->get_jumlah($id_upk, $id_jp, $kd_baru, $tahun, $bulan);
        $tutup = $this->Model_pelanggan->get_jumlah($id_upk, $id_jp, $kd_tutup, $tahun, $bulan);
        $buka  = $this->Model_pelanggan->get_jumlah($id_upk, $id_jp, $kd_buka, $tahun, $bulan);
        $cabut = $this->Model_pelanggan->get_jumlah($id_upk, $id_jp, $kd_cabut, $tahun, $bulan);

        $s_akhir = $s_awal + $baru - $tutup + $buka - $cabut;

        // simpan akhir bulan ini
        $this->Model_pelanggan->save_or_update([
            'id_upk' => $id_upk, 'id_jp' => $id_jp, 'id_kd' => $kd_akhir,
            'tahun' => $tahun, 'bulan' => $bulan, 'jumlah' => $s_akhir,
            'tgl_update' => $now, 'tgl_upload' => $now
        ]);

        // lanjut ke bulan berikut
        if ($bulan < 12) {
            $this->propagate_recursive($id_upk, $id_jp, $tahun, $bulan + 1, $s_akhir);
        }
    }
}
