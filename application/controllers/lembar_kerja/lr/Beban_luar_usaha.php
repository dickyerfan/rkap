<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beban_luar_usaha extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_beban');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk') ?: 'all';
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        // simpan di session utk keperluan export pdf
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $list_upk = [
            '23' => 'Umum',
            '24' => 'Keuangan',
            '25' => 'Langganan',
            '26' => 'Pemeliharaan',
            '27' => 'Perencanaan',
            '28' => 'Spi',
            '13' => 'AMDK'
        ];

        if ($upk && isset($list_upk[$upk])) {
            $title = "BIAYA DILUAR USAHA " . strtoupper($list_upk[$upk]) . "  <br>   TAHUN ANGGARAN ";
        } else {
            $title = "BIAYA DILUAR USAHA (KONSOLIDASI) <br> TAHUN ANGGARAN ";
        }

        $data['biaya'] = $this->Model_beban->get_biaya_lu($tahun, $upk);
        $data['title'] = $title;
        $data['upk'] = $upk;
        $data['tahun'] = $tahun;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/beban_luar_usaha/view_biaya_lu', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');

        $list_upk = [
            '23' => 'Umum',
            '24' => 'Keuangan',
            '25' => 'Langganan',
            '26' => 'Pemeliharaan',
            '27' => 'Perencanaan',
            '28' => 'Spi',
            '13' => 'AMDK'
        ];

        if ($upk && isset($list_upk[$upk])) {
            $title = "BIAYA DILUAR USAHA " . strtoupper($list_upk[$upk]) . "  <br>   TAHUN ANGGARAN ";
        } else {
            $title = "BIAYA DILUAR USAHA (KONSOLIDASI) <br> TAHUN ANGGARAN ";
        }

        $data['biaya'] = $this->Model_beban->get_biaya_lu($tahun, $upk);
        $data['title'] = $title;
        $data['upk'] = $upk;
        $data['tahun'] = $tahun;

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_biaya_luar_usaha_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/beban_luar_usaha/laporan_pdf', $data);
    }


    public function tambah()
    {

        if ($this->input->post()) {
            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $cabang_id  = $this->input->post('cabang_id');
            $no_per_id  = $this->input->post('no_per_id');
            $bulan_dipilih = $this->input->post('bulan');
            $pagu      = $this->input->post('pagu');
            $uraian     = $this->input->post('uraian');

            // Jika user tidak memilih bulan, anggap otomatis semua bulan
            if (empty($bulan_dipilih)) {
                $bulan_dipilih = range(1, 12);
            }

            $data = [];

            foreach ($no_per_id as $key => $value) {
                if (!isset($value) || empty($value)) continue;

                // Bersihkan nilai pagu dari titik, koma, dan karakter non-digit
                $nilai_pagu = preg_replace('/[^0-9]/', '', $pagu[$key]);
                if ($nilai_pagu === '') $nilai_pagu = 0;

                foreach ($bulan_dipilih as $bulan) {
                    $data[] = [
                        'cabang_id'    => 24,
                        'no_per_id'    => $value,
                        'uraian'       => $uraian[$key],
                        'bulan'        => sprintf('%s-%02d-01', $tahun_rkap, $bulan),
                        'pagu'         => $nilai_pagu,
                        'ptgs_upload'  => $this->session->userdata('nama_lengkap')
                    ];
                }
            }

            // Cek jika $data kosong (misal form tidak diisi)
            if (empty($data)) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger">Tidak ada data untuk disimpan.</div>');
                redirect('lembar_kerja/lr/beban_luar_usaha/tambah');
                return;
            }

            $result = $this->Model_beban->insert_or_update_lu($data);

            // 🔔 Notifikasi insert/update (Kode Anda sudah OK)
            if ($result['inserted'] > 0 && $result['updated'] == 0) {
            }

            $this->session->set_flashdata('info', $pesan);

            // PERBAIKAN REDIRECT: Ambil $upk dari data pertama yg diinput
            // $upk_redirect = $cabang_id[0] ?? 'all';
            redirect('lembar_kerja/lr/beban_luar_usaha?tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Beban Luar Usaha';

            // Ambil data Akun
            $data['no_per_id'] =
                $this->db->like('kode', '98.01', 'after')
                ->or_like('kode', '99.', 'after')
                ->order_by('kode', 'ASC') // Tambahkan order by
                ->get('no_per')
                ->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/beban_luar_usaha/upload_biaya_lu', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit($encoded_key = null)
    {
        $upk = $this->session->userdata('upk');
        $unique_key = base64_decode(urldecode($encoded_key));
        $mapping_upk = [
            '13' => 'AMDK',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        if ($this->input->post()) {
            // --- LOGIKA UPDATE DATA ---
            $post = $this->input->post();
            $data_update = [];
            $total_updated = 0;

            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $nama_petugas = $this->session->userdata('nama_lengkap');

            // Ambil nilai header yang baru (jika diedit)
            $new_no_per_id = $post['no_per_id'];
            $new_uraian = $post['uraian'];
            $new_cabang_id = $post['cabang_id_utama'];

            $new_pagu_raw = isset($post['pagu']) ? $post['pagu'] : 0;
            $new_pagu_clean = preg_replace('/[^0-9]/', '', $new_pagu_raw);
            $new_pagu = (int)$new_pagu_clean;

            // Bersihkan harga global yang dikirim (input name="harga")
            $new_harga_clean = isset($post['harga']) ? preg_replace('/[^0-9]/', '', $post['harga']) : '';
            $new_harga_clean = $new_harga_clean === '' ? 0 : (float)$new_harga_clean;

            // Looping data bulanan yang dikirim dari form
            foreach ($post['id_by'] as $key => $id_by) {


                // Hanya update jika ada perubahan volume atau harga, atau jika pagu > 0
                if ($id_by) {
                    $data_update[] = [
                        'id_by'      => $id_by,
                        'cabang_id'     => $new_cabang_id,
                        'no_per_id'     => $new_no_per_id,
                        'uraian'        => $new_uraian,
                        'pagu'          => $new_pagu,
                        'ptgs_update'   => $nama_petugas,
                        'tgl_update'    => date('Y-m-d H:i:s')
                    ];
                }
            }

            // Jalankan update batch di Model
            if (!empty($data_update)) {
                $result = $this->Model_beban->update_batch($data_update);
                $total_updated = $result;
            }

            // Notifikasi dan Redirect
            $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong>  data beban luar usaha berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

            $this->session->set_flashdata('info', $pesan);

            // Redirect kembali ke halaman utama, menggunakan cabang_id dari post
            $upk_redirect = $post['cabang_id_utama'] ?? 'all';
            redirect('lembar_kerja/lr/beban_luar_usaha?upk=' . $upk_redirect . '&tahun_rkap=' . $tahun_rkap);
        } else {
            // --- LOGIKA TAMPILKAN FORM EDIT (GET) ---
            // ... (Logika pemisahan $unique_key)
            list($cabang_id, $no_per_id, $uraian_raw) = explode('-', $unique_key, 3);
            $uraian = str_replace('_', ' ', $uraian_raw);

            //Ambil data yang akan diedit dari Model
            $data_edit = $this->Model_beban->get_data_to_edit($cabang_id, $no_per_id, $uraian);

            if (empty($data_edit)) {
                show_404();
            }

            // Siapkan nilai awal
            $first = $data_edit[0];

            // kirim ke view: nama_bulan, mapping_upk, no_per_id sudah ada
            $data['title'] = 'Edit Beban Luar Usaha';
            $data['data_edit'] = $data_edit;
            $data['mapping_upk'] = $mapping_upk;
            $data['no_per_id'] = $this->db
                ->group_start()
                ->like('kode', '98.', 'after')
                ->or_like('kode', '99.', 'after')
                ->group_end()
                ->order_by('kode', 'ASC')
                ->get('no_per')
                ->result();
            $data['nama_bulan'] = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $data['harga'] = isset($first['harga']) ? $first['harga'] : ($first['pagu'] ?? 0);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/beban_luar_usaha/edit_biaya_lu', $data);
            $this->load->view('templates/footer');
        }
    }




    // ini fungsi edit bisa per bulan
    // public function edit($no_per_id)
    // {
    //     $tahun_rkap = $this->session->userdata('tahun_rkap');
    //     $upk = $this->session->userdata('upk');

    //     if ($this->input->post()) {
    //         // --- Proses update ---
    //         $uraian = $this->input->post('uraian');
    //         $nilai  = $this->input->post('nilai'); // array [bulan => nilai]

    //         foreach ($nilai as $bulan => $pagu) {
    //             $data_update = [
    //                 'pagu' => $pagu,
    //                 'uraian' => $uraian,
    //                 'ptgs_update' => $this->session->userdata('nama_lengkap'),
    //             ];
    //             $this->db->where('no_per_id', $no_per_id)
    //                 ->where('cabang_id', $upk)
    //                 ->where('MONTH(bulan)', $bulan)
    //                 ->where('YEAR(bulan)', $tahun_rkap)
    //                 ->update('rkap_biaya', $data_update);
    //         }

    //         $this->session->set_flashdata('info', '
    //         <div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Berhasil!</strong> Data beban diluar usaha berhasil diperbarui.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>
    //     ');
    //         redirect('lembar_kerja/lr/beban_luar_usaha?upk=' . $upk . '&tahun_rkap=' . $tahun_rkap);
    //     } else {
    //         // --- Ambil data untuk ditampilkan di form ---
    //         $data['title'] = 'Edit Data Beban Luar Usaha';
    //         $data['no_per'] = $this->db->get_where('no_per', ['kode' => $no_per_id])->row();
    //         $data['uraian'] = $this->db->select('uraian')->where('no_per_id', $no_per_id)->limit(1)->get('rkap_biaya')->row('uraian');

    //         // Ambil nilai tiap bulan
    //         $data['nilai_bulan'] = $this->db->select('MONTH(bulan) as bulan, pagu')
    //             ->from('rkap_biaya')
    //             ->where('no_per_id', $no_per_id)
    //             ->where('cabang_id', $upk)
    //             ->where('YEAR(bulan)', $tahun_rkap)
    //             ->get()->result_array();

    //         // Konversi ke array [bulan => pagu]
    //         $nilai_map = [];
    //         foreach ($data['nilai_bulan'] as $n) {
    //             $nilai_map[$n['bulan']] = $n['pagu'];
    //         }
    //         $data['nilai_map'] = $nilai_map;

    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('lembar_kerja/lr/beban_luar_usaha/edit_biaya_lu', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    public function generate2()
    {
        $tahun = $this->session->userdata('tahun_rkap');
        $upk   = $this->session->userdata('upk');

        // 🔹 Kode yang akan dijumlahkan semua child-nya
        $parent_kode = ['98.01.01', '98.01.02', '98.01.03', '98.01.04', '98.01.05', '98.01.06', '99.01.01'];


        // --- AMBIL DATA ---
        $this->db->select('cabang_id, no_per_id, bulan, pagu, status');
        $this->db->from('rkap_biaya');
        $this->db->where('YEAR(bulan)', (int)$tahun);

        if ($upk != 'all' && !empty($upk)) {
            $this->db->where('cabang_id', $upk);
        }

        // Ambil semua akun 98.* dan 99.*
        $this->db->group_start()
            ->like('no_per_id', '98', 'after')
            ->or_like('no_per_id', '99', 'after')
            ->group_end();

        $biaya_data = $this->db->get()->result_array();

        if (empty($biaya_data)) {
            $this->session->set_flashdata('info', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Tidak ada data biaya luar usaha ditemukan untuk tahun ini.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('lembar_kerja/lr/beban_luar_usaha');
            return;
        }

        // --- MULAI TRANSAKSI ---
        $this->db->trans_start();

        // 🔹 Hapus data lama untuk tahun yang sama (98 dan 99)
        $this->db->where('YEAR(bulan)', (int)$tahun);
        $this->db->group_start()
            ->like('no_per_id', '98.01', 'after')
            ->or_like('no_per_id', '99.01', 'after')
            ->group_end();
        if ($upk != 'all' && !empty($upk)) {
            $this->db->where('cabang_id', $upk);
        }
        $this->db->delete('rkap_rekap');

        // --- STEP 1: SUM data per parent (98.01.01, 98.01.06, 99.01.01) ---
        foreach ($parent_kode as $kode) {
            $total = 0;
            $cabang_id = null;
            $status = null;

            foreach ($biaya_data as $row) {
                if (strpos($row['no_per_id'], $kode) === 0) { // child dari parent
                    $total += $row['pagu'];
                    $cabang_id = $row['cabang_id'];
                    $status = $row['status'];
                }
            }

            // Jika ada total hasil penjumlahan, generate 12 bulan
            if ($total > 0) {
                $pagu_bulanan = round($total / 12, 2);

                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $this->db->insert('rkap_rekap', [
                        'cabang_id' => $cabang_id ?: ($upk != 'all' ? $upk : 0),
                        'no_per_id' => $kode,
                        'bulan'     => sprintf('%d-%02d-01', $tahun, $bulan),
                        'pagu'      => $pagu_bulanan,
                        'status'    => $status ?: 'aktif'
                    ]);
                }
            }
        }
        $this->db->trans_complete();

        // --- CEK HASIL TRANSAKSI ---
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('info', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data ke Laba Rugi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        } else {
            $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Semua data biaya luar usaha berhasil digenerate ke Laba Rugi untuk tahun ' . $tahun . '.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }

        redirect('lembar_kerja/lr/beban_luar_usaha');
    }


    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap');
        $upk   = $this->session->userdata('upk');

        // 🔹 Parent yang dibagi 12 bulan
        $parent_bagi12 = ['98.01.01', '98.01.06', '99.01.01'];
        // 🔹 Parent lain (generate sesuai bulan asli)
        $parent_semua  = ['98.01.01', '98.01.02', '98.01.03', '98.01.04', '98.01.05', '98.01.06', '99.01.01'];

        // --- AMBIL DATA ---
        $this->db->select('cabang_id, no_per_id, bulan, pagu, status');
        $this->db->from('rkap_biaya');
        $this->db->where('YEAR(bulan)', (int)$tahun);

        if ($upk != 'all' && !empty($upk)) {
            $this->db->where('cabang_id', $upk);
        }

        $this->db->group_start()
            ->like('no_per_id', '98', 'after')
            ->or_like('no_per_id', '99', 'after')
            ->group_end();

        $biaya_data = $this->db->get()->result_array();

        if (empty($biaya_data)) {
            $this->session->set_flashdata('info', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Tidak ada data biaya luar usaha ditemukan untuk tahun ini.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect('lembar_kerja/lr/beban_luar_usaha');
            return;
        }

        // --- MULAI TRANSAKSI ---
        $this->db->trans_start();

        // Hapus data lama
        $this->db->where('YEAR(bulan)', (int)$tahun);
        $this->db->group_start()
            ->like('no_per_id', '98.01', 'after')
            ->or_like('no_per_id', '99.01', 'after')
            ->group_end();
        if ($upk != 'all' && !empty($upk)) {
            $this->db->where('cabang_id', $upk);
        }
        $this->db->delete('rkap_rekap');

        // --- STEP 1: PROSES SEMUA PARENT ---
        foreach ($parent_semua as $kode) {

            // 🔸 Cari data sesuai parent
            $filtered = array_filter($biaya_data, function ($row) use ($kode) {
                return strpos($row['no_per_id'], $kode) === 0;
            });

            if (empty($filtered)) continue;

            $cabang_id = reset($filtered)['cabang_id'];
            $status = reset($filtered)['status'];

            // Jika termasuk kategori bagi 12 bulan
            if (in_array($kode, $parent_bagi12)) {
                $total = array_sum(array_column($filtered, 'pagu'));
                $pagu_bulanan = round($total / 12, 2);

                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $this->db->insert('rkap_rekap', [
                        'cabang_id' => $cabang_id ?: ($upk != 'all' ? $upk : 0),
                        'no_per_id' => $kode,
                        'bulan'     => sprintf('%d-%02d-01', $tahun, $bulan),
                        'pagu'      => $pagu_bulanan,
                        'status'    => $status ?: 'aktif'
                    ]);
                }
            } else {
                // Jika bukan bagi 12, generate sesuai bulan aslinya
                foreach ($filtered as $row) {
                    $this->db->insert('rkap_rekap', [
                        'cabang_id' => $row['cabang_id'],
                        'no_per_id' => $kode,
                        'bulan'     => $row['bulan'],
                        'pagu'      => $row['pagu'],
                        'status'    => $row['status']
                    ]);
                }
            }
        }

        $this->db->trans_complete();

        // --- CEK HASIL TRANSAKSI ---
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('info', '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Gagal menyimpan data ke Laba Rugi.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        } else {
            $this->session->set_flashdata('info', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Semua data biaya luar usaha berhasil digenerate ke Laba Rugi untuk tahun ' . $tahun . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }

        redirect('lembar_kerja/lr/beban_luar_usaha');
    }
}
