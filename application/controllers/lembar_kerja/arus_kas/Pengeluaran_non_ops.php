<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengeluaran_non_ops extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pengeluaran');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {

        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $title = "RENCANA PENGELUARAN NON OPERASIONAL <br> TAHUN ANGGARAN ";

        $data['biaya'] = $this->Model_pengeluaran->get_pengeluaran_no($tahun);
        $data['title'] = $title;
        $data['tahun'] = $tahun;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pengeluaran_non_ops/view_pengeluaran_non_ops', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $title = "RENCANA PENGELUARAN NON OPERASIONAL <br> TAHUN ANGGARAN ";

        $data['biaya'] = $this->Model_pengeluaran->get_pengeluaran_no($tahun);
        $data['title'] = $title;
        $data['tahun'] = $tahun;

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pengeluaran_non_ops_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/pengeluaran_non_ops/laporan_pdf', $data);
    }


    public function tambah()
    {
        if ($this->input->post()) {
            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $upk = $this->session->userdata('upk');
            $no_per_id  = $this->input->post('no_per_id');
            // $uraian     = $this->input->post('uraian');
            $pagu       = $this->input->post('pagu');
            $bulan_dipilih = $this->input->post('bulan'); // array bulan yg dipilih

            // Jika user tidak memilih bulan, anggap otomatis semua bulan
            if (empty($bulan_dipilih)) {
                $bulan_dipilih = range(1, 12);
            }

            $data = [];

            foreach ($no_per_id as $key => $value) {
                foreach ($bulan_dipilih as $bulan) {
                    $data[] = [
                        'cabang_id'     => 24,
                        'no_per_id'     => $value,
                        // 'uraian'        => $uraian[$key],
                        'bulan'         => sprintf('%s-%02d-01', $tahun_rkap, $bulan),
                        'pagu'          => $pagu[$key],
                        // 'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
                    ];
                }
            }

            $result = $this->Model_pengeluaran->insert_or_update($data);

            // 🔔 Notifikasi insert/update
            if ($result['inserted'] > 0 && $result['updated'] == 0) {
                $pesan = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> ' . $result['inserted'] . ' data baru berhasil ditambahkan .
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
            redirect('lembar_kerja/arus_kas/pengeluaran_non_ops?upk=' . $upk . '&tahun_rkap=' . $tahun_rkap);
        } else {
            $data['title'] = 'Input Pengeluaran Non Operasional';

            // 🔧 Tampilkan kode yang termasuk dalam daftar multi-kode
            // $this->db->group_start()
            //     ->like('kode', '50.05.04', 'after')
            //     ->or_like('kode', '50.01', 'after')
            //     ->group_end();

            $this->db->where('kode', '50.05.04')
                ->or_where('kode', '50.01')
                ->or_where('kode', '62.03.03');

            $data['no_per_id'] = $this->db->get('no_per')->result();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/arus_kas/pengeluaran_non_ops/upload_pengeluaran_non_ops', $data);
            $this->load->view('templates/footer');
        }
    }


    public function edit($no_per_id)
    {
        $tahun_rkap = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');

        if ($this->input->post()) {
            // --- Proses update ---
            $uraian = $this->input->post('uraian');
            $nilai  = $this->input->post('nilai'); // array [bulan => nilai]

            foreach ($nilai as $bulan => $pagu) {
                $data_update = [
                    'pagu' => $pagu,
                    'uraian' => $uraian,
                    'ptgs_update' => $this->session->userdata('nama_lengkap'),
                ];
                $this->db->where('no_per_id', $no_per_id)
                    ->where('cabang_id', $upk)
                    ->where('MONTH(bulan)', $bulan)
                    ->where('YEAR(bulan)', $tahun_rkap)
                    ->update('rkap_biaya', $data_update);
            }

            $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data beban diluar usaha berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
            redirect('lembar_kerja/arus_kas/pengeluaran_non_ops?upk=' . $upk . '&tahun_rkap=' . $tahun_rkap);
        } else {
            // --- Ambil data untuk ditampilkan di form ---
            $data['title'] = 'Edit Pengeluaran Non Operasional';
            $data['no_per'] = $this->db->get_where('no_per', ['kode' => $no_per_id])->row();
            $data['uraian'] = $this->db->select('uraian')->where('no_per_id', $no_per_id)->limit(1)->get('rkap_biaya')->row('uraian');

            // Ambil nilai tiap bulan
            $data['nilai_bulan'] = $this->db->select('MONTH(bulan) as bulan, pagu')
                ->from('rkap_biaya')
                ->where('no_per_id', $no_per_id)
                ->where('cabang_id', $upk)
                ->where('YEAR(bulan)', $tahun_rkap)
                ->get()->result_array();

            // Konversi ke array [bulan => pagu]
            $nilai_map = [];
            foreach ($data['nilai_bulan'] as $n) {
                $nilai_map[$n['bulan']] = $n['pagu'];
            }
            $data['nilai_map'] = $nilai_map;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/arus_kas/pengeluaran_non_ops/edit_pengeluaran_non_ops', $data);
            $this->load->view('templates/footer');
        }
    }

    public function generate()
    {
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;
        $data = $this->Model_pengeluaran->get_pengeluaran_no($tahun);

        // Hitung total per parent (no_per_id)
        $grouped = [];
        foreach ($data as $row) {
            $kode = $row['no_per_id'];
            if (!isset($grouped[$kode])) {
                $grouped[$kode] = [
                    'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
                    'jul' => 0, 'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0,
                    'total_tahun' => 0,
                ];
            }

            foreach (['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des'] as $bulan) {
                $grouped[$kode][$bulan] += $row[$bulan];
            }
            $grouped[$kode]['total_tahun'] += $row['total_tahun'];
        }

        // Mapping nama bulan ke nomor bulan
        $map_bulan = [
            'jan' => '01', 'feb' => '02', 'mar' => '03', 'apr' => '04', 'mei' => '05', 'jun' => '06',
            'jul' => '07', 'agu' => '08', 'sep' => '09', 'okt' => '10', 'nov' => '11', 'des' => '12'
        ];

        // Proses per no_per_id
        foreach ($grouped as $no_per_id => $nilai) {

            // 🔹 Hapus dulu semua data lama untuk no_per_id ini (sekali saja)
            $this->db->where('YEAR(bulan)', $tahun);
            $this->db->where('cabang_id', 23);
            $this->db->where('no_per_id', $no_per_id);
            $this->db->delete('rkap_arus_kas');

            // 🔹 Insert per bulan
            foreach ($map_bulan as $key => $num) {
                $pagu = $nilai[$key] ?? 0;

                $record = [
                    'cabang_id' => 23,
                    'no_per_id' => $no_per_id,
                    'bulan'     => "{$tahun}-{$num}-01",
                    'pagu'      => $pagu
                ];
                $this->db->insert('rkap_arus_kas', $record);
            }
        }

        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data Pengeluaran Non Operasional berhasil digenerate Arus Kas!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('lembar_kerja/arus_kas/pengeluaran_non_ops');
    }




    // public function generate()
    // {
    //     $tahun_rkap = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap');
    //     $cabang_id  = 13; // bisa disesuaikan kalau multi cabang

    //     // Ambil semua data biaya dari tabel rkap_amdk_biaya
    //     $biaya = $this->db
    //         ->where('YEAR(bulan)', $tahun_rkap)
    //         ->where('cabang_id', $cabang_id)
    //         ->get('rkap_amdk_biaya')
    //         ->result_array();

    //     if (empty($biaya)) {
    //         $this->session->set_flashdata('info', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //         <strong>Perhatian!</strong> Tidak ada data biaya untuk tahun ini.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>');
    //         redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_rkap);
    //         return;
    //     }

    //     $inserted = 0;
    //     $updated = 0;

    //     foreach ($biaya as $row) {
    //         // cek apakah data dengan kombinasi ini sudah ada di tabel rkap_rekap
    //         $cek = $this->db->get_where('rkap_rekap', [
    //             'cabang_id'   => $row['cabang_id'],
    //             'no_per_id'   => $row['no_per_id'],
    //             'bulan'       => $row['bulan']
    //         ])->row();

    //         $data_rekap = [
    //             'cabang_id'   => $row['cabang_id'],
    //             'no_per_id'   => $row['no_per_id'],
    //             'bulan'       => $row['bulan'],
    //             'pagu'        => $row['pagu']
    //         ];

    //         if ($cek) {
    //             // update jika sudah ada
    //             $this->db->where('id', $cek->id)->update('rkap_rekap', $data_rekap);
    //             $updated++;
    //         } else {
    //             // insert jika belum ada
    //             $this->db->insert('rkap_rekap', $data_rekap);
    //             $inserted++;
    //         }
    //     }

    //     // 🔔 Notifikasi hasil generate
    //     $pesan = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //     <strong>Generate Selesai!</strong> ' . $inserted . ' data baru ditambahkan, ' . $updated . ' data diperbarui di Aplikasi Cetet.
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    //     $this->session->set_flashdata('info', $pesan);

    //     redirect('lembar_kerja/rkap_amdk/biaya?tahun_rkap=' . $tahun_rkap);
    // }
}
