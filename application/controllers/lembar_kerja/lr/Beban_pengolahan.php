<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beban_pengolahan extends MY_Controller
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
            '28' => 'Spi'
        ];

        // jika upk kosong → konsolidasi
        if ($upk && isset($list_upk[$upk])) {
            $title = "BIAYA PENGOLAHAN " . strtoupper($list_upk[$upk]) . "  <br>   TAHUN ANGGARAN ";
        } else {
            $title = "BIAYA PENGOLAHAN (KONSOLIDASI) <br> TAHUN ANGGARAN ";
        }

        $data['biaya'] = $this->Model_beban->get_biaya_pengolahan($tahun, $upk);
        $data['title'] = $title;
        $data['upk'] = $upk;
        $data['tahun'] = $tahun;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/beban_pengolahan/view_biaya_pengolahan', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');

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
            '23' => 'Umum',
            '24' => 'Keuangan',
            '25' => 'Langganan',
            '26' => 'Pemeliharaan',
            '27' => 'Perencanaan',
            '28' => 'Spi'
        ];

        if ($upk && isset($list_upk[$upk])) {
            $title = "BIAYA PENGOLAHAN " . strtoupper($list_upk[$upk]) . "  <br>   TAHUN ANGGARAN ";
        } else {
            $title = "BIAYA PENGOLAHAN (KONSOLIDASI) <br> TAHUN ANGGARAN ";
        }

        $data['biaya'] = $this->Model_beban->get_biaya_pengolahan($tahun, $upk);
        $data['title'] = $title;
        $data['upk'] = $upk;
        $data['tahun'] = $tahun;

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_beban_pengolahan_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/beban_pengolahan/laporan_pdf', $data);
    }


    public function tambah()
    {
        $tahun_wajib = date('Y') + 1;
        $tahun_rkap = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: $tahun_wajib;
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        if ($tahun_rkap != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Input data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect('lembar_kerja/lr/beban_pengolahan?tahun_rkap=' . $tahun_wajib);
            return;
        }

        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        if ($this->input->post()) {
            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $cabang_id  = $this->input->post('cabang_id'); // Ini array
            $no_per_id  = $this->input->post('no_per_id'); // Ini array
            $bulan_dipilih = $this->input->post('bulan');
            $pagu      = $this->input->post('pagu');      // Ini array
            $uraian     = $this->input->post('uraian');    // Ini array

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

                // ✅ Tentukan status otomatis
                // Jika no_per_id = 92.05 atau turunannya (misal 92.05.01 dst)
                $status = (preg_match('/^92\.05(\.|$)/', $value)) ? 1 : 0;

                foreach ($bulan_dipilih as $bulan) {
                    $data[] = [
                        'cabang_id'    => $cabang_id[$key],
                        'no_per_id'    => $value,
                        'uraian'       => $uraian[$key],
                        'bulan'        => sprintf('%s-%02d-01', $tahun_rkap, $bulan),
                        'pagu'         => $nilai_pagu,
                        'ptgs_upload'  => $this->session->userdata('nama_lengkap'),
                        'status'       => $status
                    ];
                }
            }

            // Cek jika $data kosong (misal form tidak diisi)
            if (empty($data)) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger">Tidak ada data untuk disimpan.</div>');
                redirect('lembar_kerja/lr/beban_pengolahan/tambah');
                return;
            }

            $result = $this->Model_beban->insert_or_update_pengolahan($data);

            // 🔔 Notifikasi insert/update (Kode Anda sudah OK)
            if ($result['inserted'] > 0 && $result['updated'] == 0) {
            }

            $this->session->set_flashdata('info', $pesan);

            // PERBAIKAN REDIRECT: Ambil $upk dari data pertama yg diinput
            $upk_redirect = $cabang_id[0] ?? 'all';
            redirect('lembar_kerja/lr/beban_pengolahan?upk=' . $upk_redirect . '&tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Beban Pengolahan';

            // Ambil data Akun
            $data['no_per_id'] = $this->db->like('kode', '92.', 'after')
                ->order_by('kode', 'ASC') // Tambahkan order by
                ->get('no_per')
                ->result();

            // TAMBAHAN: Kirim data mapping UPK ke view
            $data['mapping_upk'] = $mapping_upk;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/beban_pengolahan/upload_biaya_pengolahan', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit($encoded_key = null)
    {
        $tahun_wajib = date('Y') + 1;
        $tahun_rkap = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: $tahun_wajib;
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        if ($tahun_rkap != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Edit data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect('lembar_kerja/lr/beban_pengolahan?tahun_rkap=' . $tahun_wajib);
            return;
        }

        $upk = $this->session->userdata('upk');
        $unique_key = base64_decode(urldecode($encoded_key));
        // lalu parse unique_key seperti sebelumnya

        // Pindahkan ini ke tempat yang mudah diakses (misal di __construct atau di sini)
        $mapping_upk = [
            '01' => 'Bondowoso', '02' => 'Sukosari 1', '03' => 'Maesan', '04' => 'Tegalampel',
            '05' => 'Tapen', '06' => 'Prajekan', '07' => 'Tlogosari', '08' => 'Wringin',
            '09' => 'Curahdami', '11' => 'Tamanan', '12' => 'Tenggarang', '13' => 'AMDK',
            '14' => 'Tamankrocok', '15' => 'Wonosari', '16' => 'Klabang', '22' => 'Sukosari 2',
            '23' => 'Umum', '24' => 'Keuangan', '25' => 'Langganan', '26' => 'Pemeliharaan',
            '27' => 'Perencanaan', '28' => 'SPI'
        ];

        if ($this->input->post()) {
            // --- LOGIKA UPDATE DATA ---
            $post = $this->input->post();
            $total_updated = 0;

            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $nama_petugas = $this->session->userdata('nama_lengkap');

            // Ambil nilai header yang baru (jika diedit)
            $new_no_per_id = $post['no_per_id'];
            $new_uraian = $post['uraian'];
            $new_cabang_id = $post['cabang_id_utama'];

            // --- Identifikasi data lama (kombinasi asli dari unique_key) ---
            list($cabang_id_lama, $no_per_id_lama, $uraian_raw_lama) = explode('-', $unique_key, 3);
            $uraian_lama = str_replace('_', ' ', $uraian_raw_lama);

            // Ambil data lama utk mempertahankan ptgs_upload
            $old_rows = $this->Model_beban->get_data_to_edit($cabang_id_lama, $no_per_id_lama, $uraian_lama, $tahun_rkap);
            $ptgs_upload_map = [];
            foreach ($old_rows as $r) {
                $key_month = (int)date('n', strtotime($r['bulan']));
                $ptgs_upload_map[$key_month] = $r['ptgs_upload'];
            }

            // Hapus semua data lama tahun ini utk kombinasi ini
            $this->db->where('cabang_id', $cabang_id_lama);
            $this->db->where('no_per_id', $no_per_id_lama);
            $this->db->where('uraian', $uraian_lama);
            $this->db->where('YEAR(bulan)', (int)$tahun_rkap);
            $this->db->delete('rkap_biaya');

            // Looping data bulanan yang dikirim dari form (name="bulan[]", "id_by[]", "pagu_bulanan[]")
            $bulan_sel   = isset($post['bulan']) ? $post['bulan'] : [];
            $pagu_arr    = isset($post['pagu_bulanan']) ? $post['pagu_bulanan'] : [];

            // Gabungkan per bulan (jika dua baris memilih bulan sama, yang terakhir menang)
            $data_baru = [];
            foreach ($bulan_sel as $i => $bulan_num) {
                $bulan_num = (int)$bulan_num;
                if ($bulan_num < 1 || $bulan_num > 12) continue;

                $pagu_raw = isset($pagu_arr[$i]) ? $pagu_arr[$i] : 0;
                $pagu_clean = preg_replace('/[^0-9]/', '', $pagu_raw);
                $pagu_val = $pagu_clean === '' ? 0 : (int)$pagu_clean;

                // Hanya simpan bulan yang punya nilai
                if ($pagu_val <= 0) continue;

                // Tentukan status otomatis (92.05 -> status 1)
                $status = (preg_match('/^92\.05(\.|$)/', $new_no_per_id)) ? 1 : 0;

                $data_baru[$bulan_num] = [
                    'cabang_id'    => $new_cabang_id,
                    'no_per_id'    => $new_no_per_id,
                    'uraian'       => $new_uraian,
                    'bulan'        => sprintf('%04d-%02d-01', $tahun_rkap, $bulan_num),
                    'pagu'         => $pagu_val,
                    'status'       => $status,
                    'ptgs_upload'  => isset($ptgs_upload_map[$bulan_num]) ? $ptgs_upload_map[$bulan_num] : $nama_petugas,
                    'ptgs_update'  => $nama_petugas,
                    'tgl_update'   => date('Y-m-d H:i:s')
                ];
            }

            if (!empty($data_baru)) {
                $this->db->insert_batch('rkap_biaya', array_values($data_baru));
                $total_updated = count($data_baru);
            }

            // Notifikasi dan Redirect
            $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong>  data beban Pengolahan berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

            $this->session->set_flashdata('info', $pesan);

            // Redirect kembali ke halaman utama, menggunakan cabang_id dari post
            $upk_redirect = $post['cabang_id_utama'] ?? 'all';
            redirect('lembar_kerja/lr/beban_pengolahan?upk=' . $upk_redirect . '&tahun_rkap=' . $tahun_rkap);
        } else {
            // --- LOGIKA TAMPILKAN FORM EDIT (GET) ---
            // ... (Logika pemisahan $unique_key)
            list($cabang_id, $no_per_id, $uraian_raw) = explode('-', $unique_key, 3);
            $uraian = str_replace('_', ' ', $uraian_raw);

            //Ambil data yang akan diedit dari Model
            $data_edit = $this->Model_beban->get_data_to_edit($cabang_id, $no_per_id, $uraian, $tahun_rkap);

            if (empty($data_edit)) {
                show_404();
            }

            // Siapkan nilai awal
            $first = $data_edit[0];

            // kirim ke view: nama_bulan, mapping_upk, no_per_id sudah ada
            $data['title'] = 'Edit Beban Pengolahan';
            $data['data_edit'] = $data_edit;
            $data['mapping_upk'] = $mapping_upk;
            $data['no_per_id'] = $this->db->like('kode', '92.', 'after')->order_by('kode', 'ASC')->get('no_per')->result();
            $data['nama_bulan'] = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            $data['harga'] = isset($first['harga']) ? $first['harga'] : ($first['pagu'] ?? 0);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/beban_pengolahan/edit_biaya_pengolahan', $data);
            $this->load->view('templates/footer');
        }
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap');
        $upk   = $this->session->userdata('upk');

        // Ambil data dari rkap_biaya
        $this->db->select('cabang_id, no_per_id, bulan, pagu, status');
        $this->db->from('rkap_biaya');
        $this->db->where('YEAR(bulan)', (int)$tahun);

        if ($upk != 'all' && !empty($upk)) {
            $this->db->where('cabang_id', $upk);
        }

        // 🔹 Hanya ambil akun yang diawali 92 (biaya pengolahan)
        $this->db->like('no_per_id', '92', 'after');

        $biaya_data = $this->db->get()->result_array();

        if (empty($biaya_data)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Tidak ada data biaya pengolahan ditemukan untuk tahun ini.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/beban_pengolahan');
            return;
        }

        // Mulai transaksi
        $this->db->trans_start();

        foreach ($biaya_data as $row) {
            $data = [
                'cabang_id' => $row['cabang_id'],
                'no_per_id' => $row['no_per_id'],
                'bulan'     => $row['bulan'],
                'pagu'      => $row['pagu'],
                'status'    => $row['status'],
            ];

            // 🔹 Cek apakah data sudah ada (berdasarkan 3 kunci utama)
            $this->db->where('cabang_id', $row['cabang_id']);
            $this->db->where('no_per_id', $row['no_per_id']);
            $this->db->where('bulan', $row['bulan']);
            $cek = $this->db->get('rkap_rekap')->row_array();

            if ($cek) {
                // 🔹 Jika sudah ada, hapus dulu
                $this->db->where('id', $cek['id']);
                $this->db->delete('rkap_rekap');
            }

            // 🔹 Insert data baru
            $this->db->insert('rkap_rekap', $data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data ke Laba Rugi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Semua data biaya pengolahan berhasil digenerate ke Laba Rugi.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
        }

        redirect('lembar_kerja/lr/beban_pengolahan');
    }
}
