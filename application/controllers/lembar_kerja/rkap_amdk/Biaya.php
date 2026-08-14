<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biaya extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_amdk_biaya');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {

        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['biaya'] = $this->Model_amdk_biaya->get_biaya($tahun);
        $data['title'] = 'RENCANA BIAYA UNIT AMDK <br> TAHUN ANGGARAN ';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/biaya/view_biaya', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/biaya/view_biaya', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }


    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['biaya'] = $this->Model_amdk_biaya->get_biaya($tahun);
        $data['title'] = 'RENCANA BIAYA UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_biaya_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/biaya/laporan_pdf', $data);
    }

    // public function tambah()
    // {

    //     if ($this->input->post()) {
    //         $tahun_rkap = $this->session->userdata('tahun_rkap');
    //         $no_per_id = $this->input->post('no_per_id');
    //         $uraian = $this->input->post('uraian');
    //         $pagu =  $this->input->post('pagu');

    //         $data = [];

    //         foreach ($no_per_id as $key => $value) {
    //             for ($bulan = 1; $bulan <= 12; $bulan++) {
    //                 $data[] = [
    //                     'cabang_id'     => 13,
    //                     'no_per_id'     => $value,
    //                     'uraian'        => $uraian[$key],
    //                     'bulan'         => sprintf('%s-%02d-01', $tahun_rkap, $bulan), // format YYYY-MM-01
    //                     'pagu'          => $pagu[$key],
    //                     'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
    //                 ];
    //             }
    //         }

    //         $result = $this->Model_amdk_biaya->insert_or_update($data);

    //         if ($result['inserted'] > 0 && $result['updated'] == 0) {
    //             $pesan = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //             <strong>Sukses</strong> ' . $result['inserted'] . ' data baru berhasil ditambahkan.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //           </div>';
    //         } elseif ($result['updated'] > 0 && $result['inserted'] == 0) {
    //             $pesan = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //             <strong>Sukses Update!</strong> ' . $result['updated'] . ' data berhasil diperbarui.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //           </div>';
    //         } else {
    //             $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
    //             <strong>Berhasil!</strong> ' . $result['inserted'] . ' data baru dan ' . $result['updated'] . ' data diperbarui.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //           </div>';
    //         }

    //         $this->session->set_flashdata('info', $pesan);
    //         redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_rkap);
    //     } else {
    //         $data['title'] = 'Input Biaya Unit AMDK';
    //         $data['no_per_id'] = $this->db->like('kode', '98.02', 'after')
    //             ->get('no_per')
    //             ->result();

    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('lembar_kerja/rkap_amdk/biaya/upload_biaya', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    public function tambah()
    {
        $tahun_wajib = date('Y') + 1;
        $tahun_rkap = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: $tahun_wajib;
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        if ($tahun_rkap != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Input data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_wajib);
            return;
        }

        if ($this->input->post()) {
            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $no_per_id  = $this->input->post('no_per_id');
            $uraian     = $this->input->post('uraian');
            $pagu       = $this->input->post('pagu');
            $bulan_dipilih = $this->input->post('bulan'); // array bulan yg dipilih

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
                // Jika no_per_id = 98. atau turunannya (misal 92.05.01 dst)
                $status = (preg_match('/^98\.02\.(10|11|12)(\.|$)/', $value)) ? 1 : 0;

                foreach ($bulan_dipilih as $bulan) {
                    $data[] = [
                        'cabang_id'     => 13,
                        'no_per_id'     => $value,
                        'uraian'        => $uraian[$key],
                        'bulan'         => sprintf('%s-%02d-01', $tahun_rkap, $bulan),
                        'pagu'          => $pagu[$key],
                        'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
                        'status'        => $status
                    ];
                }
            }

            $result = $this->Model_amdk_biaya->insert_or_update($data);

            // 🔔 Notifikasi insert/update
            if ($result['inserted'] > 0 && $result['updated'] == 0) {
                $pesan = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> ' . $result['inserted'] . ' data baru berhasil ditambahkan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            } elseif ($result['updated'] > 0 && $result['inserted'] == 0) {
                $pesan = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Diperbarui!</strong> ' . $result['updated'] . ' data berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            } else {
                $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> ' . $result['inserted'] . ' data baru dan ' . $result['updated'] . ' data diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }

            $this->session->set_flashdata('info', $pesan);
            redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Biaya Unit AMDK';
            $data['no_per_id'] = $this->db->like('kode', '98.02', 'after')
                ->get('no_per')
                ->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/biaya/upload_biaya', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit($encoded_key = null)
    {
        $tahun_wajib = date('Y') + 1;
        $tahun_rkap  = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: $tahun_wajib;
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        if ($tahun_rkap != $tahun_wajib) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Edit data hanya untuk tahun RKAP ' . $tahun_wajib . '</div>');
            redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_wajib);
            return;
        }

        $unique_key = base64_decode(urldecode($encoded_key));

        if ($this->input->post()) {
            // --- LOGIKA UPDATE DATA ---
            $post             = $this->input->post();
            $new_no_per_id    = $post['no_per_id'];
            $new_uraian       = $post['uraian'];
            $new_cabang_id    = '13'; // AMDK selalu cabang 13

            // Parse kombinasi asli dari unique_key
            list($cabang_id_lama, $no_per_id_lama, $uraian_raw_lama) = explode('-', $unique_key, 3);
            $uraian_lama = str_replace('_', ' ', $uraian_raw_lama);

            $nama_petugas = $this->session->userdata('nama_lengkap');

            // Ambil data lama utk mempertahankan ptgs_upload
            $old_rows      = $this->Model_amdk_biaya->get_data_to_edit($cabang_id_lama, $no_per_id_lama, $uraian_lama, $tahun_rkap);
            $ptgs_upload_map = [];
            foreach ($old_rows as $r) {
                $key_month                = (int) date('n', strtotime($r['bulan']));
                $ptgs_upload_map[$key_month] = $r['ptgs_upload'] ?? null;
            }

            // Hapus semua data lama tahun ini utk kombinasi ini
            $this->db->where('cabang_id', $cabang_id_lama);
            $this->db->where('no_per_id', $no_per_id_lama);
            $this->db->where('uraian', $uraian_lama);
            $this->db->where('YEAR(bulan)', (int) $tahun_rkap);
            $this->db->delete('rkap_amdk_biaya');

            // Looping data bulanan dari form
            $bulan_sel = isset($post['bulan']) ? $post['bulan'] : [];
            $pagu_arr  = isset($post['pagu_bulanan']) ? $post['pagu_bulanan'] : [];

            $data_baru = [];
            foreach ($bulan_sel as $i => $bulan_num) {
                $bulan_num = (int) $bulan_num;
                if ($bulan_num < 1 || $bulan_num > 12) continue;

                $pagu_raw   = isset($pagu_arr[$i]) ? $pagu_arr[$i] : 0;
                $pagu_clean = preg_replace('/[^0-9]/', '', $pagu_raw);
                $pagu_val   = $pagu_clean === '' ? 0 : (int) $pagu_clean;

                if ($pagu_val <= 0) continue;

                // Status otomatis: jika no_per_id = 98.02.10/11/12 → status 1
                $status = (preg_match('/^98\.02\.(10|11|12)(\.|$)/', $new_no_per_id)) ? 1 : 0;

                $data_baru[$bulan_num] = [
                    'cabang_id'    => $new_cabang_id,
                    'no_per_id'    => $new_no_per_id,
                    'uraian'       => $new_uraian,
                    'bulan'        => sprintf('%04d-%02d-01', $tahun_rkap, $bulan_num),
                    'pagu'         => $pagu_val,
                    'status'       => $status,
                    'ptgs_upload'  => $ptgs_upload_map[$bulan_num] ?? $nama_petugas,
                    'ptgs_update'  => $nama_petugas,
                    'tgl_update'   => date('Y-m-d H:i:s'),
                ];
            }

            if (!empty($data_baru)) {
                $this->db->insert_batch('rkap_amdk_biaya', array_values($data_baru));
            }

            $this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Data biaya AMDK berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');

            redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_rkap);
        } else {
            // --- LOGIKA TAMPILKAN FORM EDIT (GET) ---
            list($cabang_id, $no_per_id, $uraian_raw) = explode('-', $unique_key, 3);
            $uraian = str_replace('_', ' ', $uraian_raw);

            $data_edit = $this->Model_amdk_biaya->get_data_to_edit($cabang_id, $no_per_id, $uraian, $tahun_rkap);

            if (empty($data_edit)) {
                show_404();
            }

            $first = $data_edit[0];

            $data['title']     = 'Edit Biaya Unit AMDK';
            $data['data_edit'] = $data_edit;
            $data['no_per_id'] = $this->db->like('kode', '98.02', 'after')->order_by('kode', 'ASC')->get('no_per')->result();
            $data['nama_bulan'] = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/biaya/edit_biaya', $data);
            $this->load->view('templates/footer');
        }
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap');

        if (!$tahun) {
            $tahun = date('Y') + 1;
        }

        // Ambil data biaya
        $biaya = $this->Model_amdk_biaya->get_biaya($tahun);

        // Mapping bulan
        $map_bulan = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        // ------------------------------
        // 1. Kelompokkan seperti di VIEW
        // ------------------------------
        $grouped = [];
        foreach ($biaya as $r) {
            $parts = explode('.', $r['kode']);
            $parent = implode('.', array_slice($parts, 0, 3)); // ex: 98.02.01

            $grouped[$parent]['children'][] = $r;

            foreach ($map_bulan as $b => $nm) {
                if (!isset($grouped[$parent]['subtotal'][$nm])) {
                    $grouped[$parent]['subtotal'][$nm] = 0;
                }
                $grouped[$parent]['subtotal'][$nm] += $r[$nm];
            }
        }

        // ------------------------------
        // 2. Hapus data lama 98.02.* di arus kas
        // ------------------------------
        $this->db->like('no_per_id', '98.02', 'after');
        $this->db->delete('rkap_amdk_arus_kas');

        // ------------------------------
        // 3. Insert ulang subtotals ke arus kas & rekap
        // ------------------------------
        $id_upk = 23;
        $cabang_id = 13;

        foreach ($grouped as $parent => $data_parent) {

            foreach ($map_bulan as $b => $nama_bulan) {

                $nilai = $data_parent['subtotal'][$nama_bulan] ?? 0;

                $bulan_date = sprintf("%d-%02d-01", $tahun, $b);

                // --- ke arus kas ---
                $insert = [
                    'no_per_id' => $parent,
                    'bulan'     => $bulan_date,
                    'pagu'      => $nilai
                ];
                $this->db->insert('rkap_amdk_arus_kas', $insert);

                // --- ke rekap (untuk laba rugi) ---
                $cek = $this->db->get_where('rkap_rekap', [
                    'no_per_id' => $parent,
                    'bulan'     => $bulan_date,
                    'id_upk'    => $id_upk,
                ])->row();

                if ($cek) {
                    $this->db->where('id', $cek->id)->update('rkap_rekap', [
                        'pagu' => $nilai
                    ]);
                } else {
                    $this->db->insert('rkap_rekap', [
                        'id_upk'    => $id_upk,
                        'cabang_id' => $cabang_id,
                        'no_per_id' => $parent,
                        'bulan'     => $bulan_date,
                        'pagu'      => $nilai
                    ]);
                }
            }
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Semua data biaya AMDK berhasil digenerate ke Laba Rugi & Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );

        redirect('lembar_kerja/rkap_amdk/biaya');
    }
}
