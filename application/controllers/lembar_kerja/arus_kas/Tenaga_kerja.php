<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Tenaga_kerja extends CI_Controller
class Tenaga_kerja extends MY_Controller

{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_tenaga_kerja');
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
        $this->session->set_userdata('tahun_rkap', $tahun);
        $this->session->set_userdata('upk', $upk);

        $data['naker'] = $this->Model_tenaga_kerja->get_naker($tahun, $upk);
        $data['title'] = 'RENCANA GAJI KARYAWAN ' . strtoupper($upk) . ' <br> TAHUN ANGGARAN';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/view_tenaga_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;

        $data['naker'] = $this->Model_tenaga_kerja->get_naker($tahun, $upk);
        $data['title'] = 'RENCANA GAJI KARYAWAN ' . strtoupper($upk) . ' <br> TAHUN ANGGARAN';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_by_tenaga_kerja_{$tahun}_upk_{$upk}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/tenaga_kerja/laporan_pdf', $data);
    }

    public function generate_tahunan()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);
        $bulan_mulai = 1;

        $this->db->where('aktif', 1);
        $pegawai_list = $this->db->get('rkap_pegawai')->result_array();

        foreach ($pegawai_list as $pegawai) {
            $gaji_pokok = $this->input->post('gaji_pokok_' . $pegawai['id']); // input manual di form
            $j_istri = $this->input->post('j_istri_' . $pegawai['id']);
            $j_anak = $this->input->post('j_anak_' . $pegawai['id']);

            for ($bulan = $bulan_mulai; $bulan <= 12; $bulan++) {
                $komponen = $this->Model_tenaga_kerja->hitung_komponen($pegawai, $gaji_pokok, $j_istri, $j_anak);
                $tgl_bulan = sprintf('%04d-%02d-01', $tahun, $bulan);

                // Cek apakah data sudah pernah digenerate untuk pegawai dan bulan ini
                $cek = $this->db->get_where('rkap_tenaga_kerja', [
                    'id_pegawai' => $pegawai['id'],
                    'bulan' => $tgl_bulan
                ])->num_rows();

                if ($cek == 0) {
                    // Hitung komponen gaji berdasarkan model perhitungan
                    $komponen = $this->Model_tenaga_kerja->hitung_komponen(
                        $pegawai,
                        $gaji_pokok,
                        $j_istri,
                        $j_anak
                    );

                    $data = array_merge($komponen, [
                        'id_pegawai' => $pegawai['id'],
                        'nama' => $pegawai['nama'],
                        'bagian' => $pegawai['bagian'],
                        'kategori' => $pegawai['kategori'],
                        'jabatan' => $pegawai['jabatan'],
                        'dapenma' => $pegawai['dapenma'],
                        'status_pegawai' => $pegawai['status_pegawai'],
                        'bulan' => $tgl_bulan,
                        'gaji_pokok' => $gaji_pokok,
                        'j_istri' => $j_istri,
                        'j_anak' => $j_anak,
                        't_perumahan' => 0 // manual

                    ]);

                    $this->Model_tenaga_kerja->simpan($data);
                }
            }
        }

        redirect('lembar_kerja/arus_kas/tenaga_kerja');
    }

    public function edit($id)
    {
        // CEGAH jika tidak boleh input/edit
        if (!can_input(
            $this->session->userdata('nama_pengguna'),
            $this->session->userdata('level'),
            $this->status_periode
        )) {
            show_error('Aksi edit tidak diperbolehkan pada periode ini.', 403);
        }

        $data['title'] = 'Edit Data Tenaga Kerja';

        $this->db->select('ptk.*');
        $this->db->from('rkap_tenaga_kerja ptk');
        $this->db->where('ptk.id_tk', $id);
        $data['pegawai'] = $this->db->get()->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/update_tenaga_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $id_tk = $this->input->post('id_tk');
        $pegawai = $this->db->get_where('rkap_tenaga_kerja', ['id_tk' => $id_tk])->row_array();

        if (!$pegawai) {
            show_error('Data tenaga kerja tidak ditemukan.');
            return;
        }

        $tahun = date('Y', strtotime($pegawai['bulan']));
        $nama   = $pegawai['nama'];
        $bagian = $pegawai['bagian'];
        $kategori = $pegawai['kategori'];
        $jabatan = $pegawai['jabatan'];
        $dapenma    = (float)$pegawai['dapenma'];

        $t_transport = $pegawai['t_transport'];
        $uang_makan  = $pegawai['uang_makan'];

        // Input dari form
        $gaji_pokok  = (float)$this->input->post('gaji_pokok');
        $j_istri     = (float)$this->input->post('j_istri');
        $j_anak      = (float)$this->input->post('j_anak');
        $t_perumahan = (float)$this->input->post('t_perumahan');
        $t_jabatan   = (float)$this->input->post('t_jabatan');
        // $bpjs_tk     = (float)$this->input->post('bpjs_tk');

        // Hitung otomatis
        if ($pegawai['status_pegawai'] == 'Karyawan Tetap') {
            $t_istri = 0.10 * $gaji_pokok * $j_istri;
            $t_anak  = 0.05 * $gaji_pokok * $j_anak;
            $t_pangan = 100000 * (1 + $j_istri + $j_anak);
        } else {
            $t_istri = 0;
            $t_anak  = 0;
            $t_pangan = 0;
        }

        // hitung direktur dan manajer
        if ($pegawai['jabatan'] == 'Manajer') {
            $t_istri = 0;
            $t_anak  = 0;
            $t_jabatan = 0;
            $t_transport = 0;
            $t_pangan = 0;
            $uang_makan = 0;
            $t_perumahan = 0;
            $bpjs_tk = 0;
            $dapenmapamsi = 0;
        } elseif ($pegawai['jabatan'] == 'Direktur') {
            $t_istri = 0;
            $t_anak  = 0;
            $t_jabatan = 0;
            $t_transport = 0;
            $t_pangan = 0;
            $uang_makan = 0;
            $t_perumahan = 0;
            $dapenmapamsi = 0;
        }

        $bpjs_kesehatan = ($gaji_pokok + $t_istri + $t_anak + $t_pangan + $t_perumahan) * 0.04;

        if ($pegawai['jabatan'] == 'Manajer') {
            $t_istri = 0;
            $t_anak  = 0;
            $t_jabatan = 0;
            $t_transport = 0;
            $t_pangan = 0;
            $uang_makan = 0;
            $t_perumahan = 0;
            $bpjs_tk = 0;
            $dapenmapamsi = 0;
        } else {
            $bpjs_tk = ($gaji_pokok + $t_istri + $t_anak + $t_pangan + $t_perumahan) * 0.0689;
        }

        if ($dapenma == 1) {
            $dapenmapamsi = ($gaji_pokok + $t_istri + $t_anak) * 0.1517;
        } else {
            $dapenmapamsi = 0;
        }

        if ($pegawai['jabatan'] == 'Direktur') {
            $dapenmapamsi = 0;
        }

        $total_gaji = $gaji_pokok + $t_istri + $t_anak + $t_pangan + $t_jabatan + $t_perumahan
            + $uang_makan + $t_transport + $bpjs_tk + $bpjs_kesehatan + $dapenmapamsi;

        if ($pegawai['jabatan'] == 'Manajer') {
            $data_update = [
                'gaji_pokok' => $gaji_pokok,
                'j_istri' => $j_istri,
                'j_anak' => $j_anak,
                't_istri' => $t_istri,
                't_anak' => $t_anak,
                't_pangan' => $t_pangan,
                'uang_makan' => $uang_makan,
                't_transport' => $t_transport,
                't_perumahan' => $t_perumahan,
                't_jabatan' => $t_jabatan,
                'bpjs_tk' => $bpjs_tk,
                'bpjs_kesehatan' => $bpjs_kesehatan,
                'dapenmapamsi' => $dapenmapamsi,
                'total_gaji' => $total_gaji,
                'ptgs_update' => $this->session->userdata('nama_lengkap'),
            ];
        } elseif ($pegawai['jabatan'] == 'Direktur') {
            $data_update = [
                'gaji_pokok' => $gaji_pokok,
                'j_istri' => $j_istri,
                'j_anak' => $j_anak,
                't_istri' => $t_istri,
                't_anak' => $t_anak,
                'uang_makan' => $uang_makan,
                't_transport' => $t_transport,
                't_pangan' => $t_pangan,
                't_perumahan' => $t_perumahan,
                't_jabatan' => $t_jabatan,
                'bpjs_tk' => $bpjs_tk,
                'bpjs_kesehatan' => $bpjs_kesehatan,
                'dapenmapamsi' => $dapenmapamsi,
                'total_gaji' => $total_gaji,
                'ptgs_update' => $this->session->userdata('nama_lengkap'),
            ];
        } else {
            $data_update = [
                'gaji_pokok' => $gaji_pokok,
                'j_istri' => $j_istri,
                'j_anak' => $j_anak,
                't_istri' => $t_istri,
                't_anak' => $t_anak,
                't_pangan' => $t_pangan,
                't_perumahan' => $t_perumahan,
                't_jabatan' => $t_jabatan,
                'bpjs_tk' => $bpjs_tk,
                'bpjs_kesehatan' => $bpjs_kesehatan,
                'dapenmapamsi' => $dapenmapamsi,
                'total_gaji' => $total_gaji,
                'ptgs_update' => $this->session->userdata('nama_lengkap'),
            ];
        }


        // Update seluruh bulan di tahun yang sama untuk pegawai tsb
        $this->db->where('nama', $nama);
        $this->db->where('bagian', $bagian);
        $this->db->where('kategori', $kategori);
        $this->db->where('jabatan', $jabatan);
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->update('rkap_tenaga_kerja', $data_update);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                   Data tenaga kerja untuk 12 bulan berhasil diperbarui otomatis.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/arus_kas/tenaga_kerja?upk=' . urlencode($bagian) . '&tahun_rkap=' . $tahun);
    }

    public function kenaikan_gaji()
    {
        $upk = $this->session->userdata('upk');
        $tahun = $this->input->post('tahun_rkap') ?: ($this->session->userdata('tahun_rkap') ?: (date('Y') + 1));
        $bulan_naik = (int)$this->input->post('bulan_naik');
        $persentase_naik = (float)$this->input->post('persentase_naik');

        // Ambil daftar pegawai yang sudah ada di rkap_tenaga_kerja untuk tahun tsb
        $pegawai_list = $this->db->query("
        SELECT id_pegawai, nama, bagian, kategori, jabatan, status_pegawai, dapenma
        FROM rkap_tenaga_kerja
        WHERE YEAR(bulan) = ?
        GROUP BY id_pegawai, nama, bagian, kategori, jabatan, status_pegawai, dapenma
    ", [$tahun])->result_array();

        foreach ($pegawai_list as $pegawai) {
            // Tentukan bulan sebelum kenaikan
            if ($bulan_naik == 1) {
                $tahun_sebelum = $tahun - 1;
                $bulan_sebelum = sprintf('%04d-12-01', $tahun_sebelum);
            } else {
                $bulan_sebelum = sprintf('%04d-%02d-01', $tahun, $bulan_naik - 1);
            }

            $data_sebelum = $this->db->get_where('rkap_tenaga_kerja', [
                'id_pegawai' => $pegawai['id_pegawai'],
                'bulan' => $bulan_sebelum
            ])->row_array();

            if ($data_sebelum) {
                // Hitung gaji pokok baru
                $gaji_pokok_baru = $data_sebelum['gaji_pokok'] * (1 + ($persentase_naik / 100));

                // Update semua bulan setelah bulan kenaikan
                for ($bulan = $bulan_naik; $bulan <= 12; $bulan++) {
                    $tgl_bulan = sprintf('%04d-%02d-01', $tahun, $bulan);

                    // Hitung ulang komponen secara manual (karena snapshot)
                    if ($pegawai['jabatan'] == 'Direktur') {
                        $t_istri  = 0;
                        $t_anak   = 0;
                        $t_pangan = 0;
                    } elseif ($pegawai['status_pegawai'] == 'Karyawan Tetap') {
                        // Logika perhitungan normal hanya dijalankan jika bukan Direktur DAN statusnya Karyawan Tetap
                        $t_istri  = 0.10 * $gaji_pokok_baru * $data_sebelum['j_istri'];
                        $t_anak   = 0.05 * $gaji_pokok_baru * $data_sebelum['j_anak'];
                        $t_pangan = 100000 * (1 + $data_sebelum['j_istri'] + $data_sebelum['j_anak']);
                    } else {
                        // Jika status_pegawai BUKAN 'Karyawan Tetap' DAN BUKAN Direktur
                        $t_istri  = 0;
                        $t_anak   = 0;
                        $t_pangan = 0;
                    }
                    // if ($pegawai['status_pegawai'] == 'Karyawan Tetap') {
                    //     $t_istri  = 0.10 * $gaji_pokok_baru * $data_sebelum['j_istri'];
                    //     $t_anak   = 0.05 * $gaji_pokok_baru * $data_sebelum['j_anak'];
                    //     $t_pangan = 100000 * (1 + $data_sebelum['j_istri'] + $data_sebelum['j_anak']);
                    // } else {
                    //     $t_istri = 0;
                    //     $t_anak = 0;
                    //     $t_pangan = 0;
                    // }

                    $bpjs_kesehatan = ($gaji_pokok_baru + $t_istri + $t_anak + $t_pangan + $data_sebelum['t_perumahan']) * 0.04;
                    $bpjs_tk = ($gaji_pokok_baru + $t_istri + $t_anak + $t_pangan + $data_sebelum['t_perumahan']) * 0.0689;
                    // $dapenmapamsi = ($pegawai['dapenma'] == 1)
                    //     ? ($gaji_pokok_baru + $t_istri + $t_anak) * 0.1517
                    //     : 0;

                    if ($pegawai['jabatan'] == 'Direktur') {
                        $dapenmapamsi = 0;
                    } else {
                        // Jalankan logika Dapenma hanya jika bukan Direktur
                        if ($pegawai['dapenma'] == 1) {
                            $dapenmapamsi = ($gaji_pokok_baru + $t_istri + $t_anak) * 0.1517;
                        } else {
                            $dapenmapamsi = 0;
                        }
                    }

                    if ($pegawai['jabatan'] == 'Manajer') {
                        $bpjs_tk = 0;
                    }

                    $total_gaji = $gaji_pokok_baru + $t_istri + $t_anak + $t_pangan + $data_sebelum['t_jabatan']
                        + $data_sebelum['t_perumahan'] + $data_sebelum['uang_makan'] + $data_sebelum['t_transport']
                        + $bpjs_tk  + $bpjs_kesehatan + $dapenmapamsi;

                    $data_update = [
                        'gaji_pokok' => $gaji_pokok_baru,
                        't_istri' => $t_istri,
                        't_anak' => $t_anak,
                        't_pangan' => $t_pangan,
                        'bpjs_kesehatan' => $bpjs_kesehatan,
                        'bpjs_tk' => $bpjs_tk,
                        'dapenmapamsi' => $dapenmapamsi,
                        'total_gaji' => $total_gaji,
                        'ptgs_update' => $this->session->userdata('nama_lengkap'),
                    ];

                    $this->db->where('id_pegawai', $pegawai['id_pegawai']);
                    $this->db->where('bulan', $tgl_bulan);
                    $this->db->update('rkap_tenaga_kerja', $data_update);
                }
            }
        }

        // $this->session->set_flashdata('info', 'Kenaikan gaji otomatis berhasil diterapkan mulai bulan ' . date('F', mktime(0, 0, 0, $bulan_naik, 1)) . '.');
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                   Kenaikan gaji otomatis berhasil diterapkan mulai bulan ' . date('F', mktime(0, 0, 0, $bulan_naik, 1)) . '.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('lembar_kerja/arus_kas/tenaga_kerja?upk=' . $upk . '&tahun_rkap=' . $tahun);
    }

    // public function hapus_setelah_pensiun($id_pegawai)
    // {
    //     $data['title'] = 'Edit Data Pensiun Tenaga Kerja';

    //     // Ambil data pegawai
    //     $this->db->select('*');
    //     $this->db->from('rkap_tenaga_kerja');
    //     $this->db->where('id_pegawai', $id_pegawai);
    //     $data['pegawai'] = $this->db->get()->row_array();

    //     // Jika tidak ditemukan, redirect
    //     if (!$data['pegawai']) {
    //         $this->session->set_flashdata('info', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //     Data pegawai tidak ditemukan.
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>');
    //         redirect('lembar_kerja/arus_kas/tenaga_kerja');
    //     }

    //     // Load view
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/update_pensiun', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function update_pensiun()
    // {
    //     $id_pegawai = $this->input->post('id_pegawai');
    //     $bulan_pensiun = (int)$this->input->post('bulan_pensiun');

    //     if (!$id_pegawai || !$bulan_pensiun) {
    //         $this->session->set_flashdata('info', '<div class="alert alert-danger">Data tidak valid.</div>');
    //         redirect('lembar_kerja/arus_kas/tenaga_kerja');
    //     }

    //     // Ambil tahun dari data pegawai
    //     $pegawai = $this->db->get_where('rkap_tenaga_kerja', ['id_pegawai' => $id_pegawai])->row_array();
    //     if (!$pegawai) {
    //         $this->session->set_flashdata('info', '<div class="alert alert-danger">Data pegawai tidak ditemukan.</div>');
    //         redirect('lembar_kerja/arus_kas/tenaga_kerja');
    //     }

    //     $tahun = date('Y', strtotime($pegawai['bulan']));

    //     $deleted_count = 0;
    //     for ($bulan = $bulan_pensiun + 1; $bulan <= 12; $bulan++) {
    //         $tgl_bulan = sprintf('%04d-%02d-01', $tahun, $bulan);
    //         $this->db->where('id_pegawai', $id_pegawai);
    //         $this->db->where('bulan', $tgl_bulan);
    //         $this->db->delete('rkap_tenaga_kerja');
    //         $deleted_count += $this->db->affected_rows();
    //     }

    //     if ($deleted_count > 0) {
    //         $this->session->set_flashdata('info', '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //         Data pensiun berhasil dihapus.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>');
    //     } else {
    //         $this->session->set_flashdata('info', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //         Tidak ada data yang dihapus. Pastikan bulan pensiun dan data pegawai benar.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>');
    //     }

    //     redirect('lembar_kerja/arus_kas/tenaga_kerja');
    // }

    public function generate_biaya()
    {
        if (!can_generate(
            $this->session->userdata('nama_pengguna'),
            $this->session->userdata('level'),
            $this->status_periode
        )) {
            show_error('Fitur generate tidak diperbolehkan pada periode ini.', 403);
        }

        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;
        $upk = $this->session->userdata('upk');

        $hasil = $this->Model_tenaga_kerja->generate_biaya($tahun, $upk);
    }
    public function generate_biaya_amdk()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;
        $hasil = $this->Model_tenaga_kerja->generate_biaya_amdk($tahun);
    }

    public function rekap()
    {
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;
        $this->session->set_userdata('tahun_rkap_rekap', $tahun);

        $data['tahun'] = $tahun;
        $data['rekap'] = $this->Model_tenaga_kerja->get_rekap_naker($tahun);
        $data['title'] = 'REKAP RENCANA GAJI PEGAWAI TAHUN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/view_rekap_tenaga_kerja', $data);
        $this->load->view('templates/footer');
    }

    public function export_rekap_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap_rekap');
        $data['tahun'] = $tahun;

        $data['rekap'] = $this->Model_tenaga_kerja->get_rekap_naker($tahun);
        $data['title'] = 'REKAP RENCANA GAJI PEGAWAI TAHUN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_rekap_tenaga_kerja_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/tenaga_kerja/laporan_rekap_pdf', $data);
    }


    // daftar pegawai
    public function pegawai()
    {
        $upk = $this->input->get('upk');
        $data['upk'] = $upk;
        $data['tahun'] = $this->session->userdata('tahun_rkap');
        $this->session->set_userdata('upk_pegawai', $upk);

        $data['pegawai'] = $this->Model_tenaga_kerja->get_pegawai($upk);
        $data['title'] = 'DAFTAR KARYAWAN ' . strtoupper($upk);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/view_pegawai', $data);
        $this->load->view('templates/footer');
    }

    public function export_pegawai_pdf()
    {
        $upk = $this->session->userdata('upk_pegawai');
        $data['upk'] = $upk;
        $data['tahun'] = $this->session->userdata('tahun_rkap');

        $data['pegawai'] = $this->Model_tenaga_kerja->get_pegawai($upk);
        $data['title'] = 'DAFTAR KARYAWAN ' . strtoupper($upk);

        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_daftar_pegawai_{$upk}.pdf";
        $this->pdf->generate('lembar_kerja/arus_kas/tenaga_kerja/laporan_pegawai_pdf', $data);
    }

    public function tambah_pegawai()
    {
        $data['title'] = 'Tambah Data Pegawai';
        $this->form_validation->set_rules('nama', 'Nama Pegawai', 'required');
        $this->form_validation->set_rules('bagian', 'Bagian', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('status_pegawai', 'Status Pegawai', 'required');
        $this->form_validation->set_rules('jenkel', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('dapenma', 'Dapenma', 'required');
        $this->form_validation->set_message('required', '%s Harus di isi');
        // Tambahkan aturan validasi lain sesuai kebutuhan Anda

        if ($this->form_validation->run() == FALSE) {
            $data['pegawai'] = [
                'nama' => set_value('nama', ''),
                'bagian' => set_value('bagian', ''),
                'jabatan' => set_value('jabatan', ''),
                'kategori' => set_value('kategori', ''),
                'status_pegawai' => set_value('status_pegawai', ''),
                'jenkel' => set_value('jenkel', ''),
                'dapenma' => set_value('dapenma', ''),
            ];

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/tambah_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $data_insert = [
                'nama'           => $this->input->post('nama'),
                'bagian'         => $this->input->post('bagian'),
                'jabatan'        => $this->input->post('jabatan'),
                'kategori'       => $this->input->post('kategori'),
                'status_pegawai' => $this->input->post('status_pegawai'),
                'jenkel'         => $this->input->post('jenkel'),
                'dapenma'        => $this->input->post('dapenma'),
                'ptgs_upload'    => $this->session->userdata('nama_lengkap'),
            ];
            $this->db->insert('rkap_pegawai', $data_insert);
            $bagian = $this->input->post('bagian');
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    Data Pegawai Baru berhasil ditambahkan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('lembar_kerja/arus_kas/tenaga_kerja/pegawai?upk=' . $bagian);
        }
    }

    public function edit_pegawai($id)
    {
        $data['title'] = 'Edit Data Pegawai';
        $data['pegawai'] = $this->Model_tenaga_kerja->get_pegawai_by_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/tenaga_kerja/update_pegawai', $data);
        $this->load->view('templates/footer');
    }

    public function update_pegawai()
    {
        $id = $this->input->post('id');
        $upk = $this->input->post('bagian');
        $data_update = [
            'id' => $this->input->post('id'),
            'bagian' => $this->input->post('bagian'),
            'kategori' => $this->input->post('kategori'),
            'status_pegawai' => $this->input->post('status_pegawai'),
            'jabatan' => $this->input->post('jabatan'),
            'dapenma' => $this->input->post('dapenma'),
            'jenkel' => $this->input->post('jenkel'),
            'aktif' => $this->input->post('aktif'),
            'ptgs_update' => $this->session->userdata('nama_lengkap'),
        ];

        $this->db->where('id', $id)->update('rkap_pegawai', $data_update);

        redirect('lembar_kerja/arus_kas/tenaga_kerja/pegawai?upk=' . $upk);
    }
    // end daftar pegawai
}
