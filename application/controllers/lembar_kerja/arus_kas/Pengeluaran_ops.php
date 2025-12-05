<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pengeluaran_ops extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pengeluaran');
        $this->load->model('Model_pengeluaran_26');
        $this->load->model('Model_beban');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {

        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $upk = $this->input->get('upk') ?: 23;

        $this->session->set_userdata('tahun_rkap', $tahun);
        $this->session->set_userdata('upk', $upk);

        $title = "RENCANA PENGELUARAAN OPERASI LAINNYA <br> TAHUN ANGGARAN ";

        if ($tahun == 2026) {
            $this->load->model('Model_pengeluaran_26', 'model_pengeluaran');
        } else {
            $this->load->model('Model_pengeluaran', 'model_pengeluaran');
        }

        $data['sumber'] = $this->model_pengeluaran->get_pengeluaran_ops_sumber($tahun);
        $data['pengolahan'] = $this->model_pengeluaran->get_pengeluaran_ops_pengolahan($tahun);
        $data['trandis'] = $this->model_pengeluaran->get_pengeluaran_ops_trandis($tahun);
        $data['umum'] = $this->model_pengeluaran->get_pengeluaran_ops_umum($tahun);
        $data['hpp']   = $this->Model_beban->get_hpp($tahun, $upk) ?? [];
        $data['title'] = $title;
        $data['tahun'] = $tahun;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/pengeluaran_ops/view_pengeluaran_ops', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');
        $title = "RENCANA PENGELUARAN OPERASI LAINNYA <br> TAHUN ANGGARAN ";

        if ($tahun == 2026) {
            $this->load->model('Model_pengeluaran_26', 'model_pengeluaran');
        } else {
            $this->load->model('Model_pengeluaran', 'model_pengeluaran');
        }

        $data['sumber'] = $this->model_pengeluaran->get_pengeluaran_ops_sumber($tahun);
        $data['pengolahan'] = $this->model_pengeluaran->get_pengeluaran_ops_pengolahan($tahun);
        $data['trandis'] = $this->model_pengeluaran->get_pengeluaran_ops_trandis($tahun);
        $data['umum'] = $this->model_pengeluaran->get_pengeluaran_ops_umum($tahun);
        $data['hpp']   = $this->Model_beban->get_hpp($tahun, $upk) ?? [];
        $data['title'] = $title;
        $data['tahun'] = $tahun;

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pengeluaran_ops_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/pengeluaran_ops/laporan_pdf', $data);
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
        // ambil tahun dinamis (dari session atau GET)
        $tahun = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $cabang_id = 23;

        // mapping kategori -> kode awal 2 digit yang mau diisi ke no_per_id
        $mapping = [
            'sumber'     => ['model_fn' => 'get_pengeluaran_ops_sumber',     'kode' => '91'],
            'pengolahan' => ['model_fn' => 'get_pengeluaran_ops_pengolahan', 'kode' => '92'],
            'trandis'    => ['model_fn' => 'get_pengeluaran_ops_trandis',    'kode' => '93'],
            'umum'       => ['model_fn' => 'get_pengeluaran_ops_umum',       'kode' => '96'],
        ];

        // map index bulan ke nama yang digunakan di hasil model/view
        $map_bulan = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
            5 => 'mei', 6 => 'jun', 7 => 'jul', 8 => 'agu',
            9 => 'sep', 10 => 'okt', 11 => 'nov', 12 => 'des'
        ];

        foreach ($mapping as $kategori => $meta) {
            $fn = $meta['model_fn'];
            $kode_no_per = $meta['kode'];

            // panggil model: pastikan fungsi ada di Model_pengeluaran
            $rows = $this->Model_pengeluaran->{$fn}($tahun); // hasil array of rows dengan kolom 'jan'..'des'

            // inisialisasi total per bulan untuk kategori ini
            $total_bulan = array_fill(1, 12, 0);

            // jumlahkan per bulan — ini meniru logika view yang menghasilkan $total_bulan
            foreach ($rows as $r) {
                foreach ($map_bulan as $i => $nama_bulan) {
                    // beberapa model mengembalikan numeric string; pastikan cast ke float
                    $val = isset($r[$nama_bulan]) ? (float)$r[$nama_bulan] : 0;
                    $total_bulan[$i] += $val;
                }
            }

            // Hapus data lama HANYA untuk kombinasi (tahun, cabang_id, no_per_id) ini
            $this->db->where('YEAR(bulan)', $tahun);
            $this->db->where('cabang_id', $cabang_id);
            $this->db->where('no_per_id', $kode_no_per);
            $this->db->delete('rkap_arus_kas');

            // Insert 12 baris (satu per bulan) untuk kategori ini
            foreach ($map_bulan as $i => $nama_bulan) {
                $bulan_str = str_pad($i, 2, '0', STR_PAD_LEFT); // '01'..'12'
                $record = [
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $kode_no_per,
                    'bulan'     => "{$tahun}-{$bulan_str}-01",
                    'pagu'      => $total_bulan[$i]
                ];
                $this->db->insert('rkap_arus_kas', $record);
            }
        }

        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data Pengeluaran Operasional berhasil digenerate Arus Kas!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('lembar_kerja/arus_kas/pengeluaran_ops');
    }



    public function generate_hpp()
    {
        $tahun = $this->session->userdata('tahun_rkap');

        // Ambil data dari rkap_biaya
        $this->db->select('cabang_id, no_per_id, bulan, pagu, status');
        $this->db->from('rkap_biaya');
        $this->db->where('YEAR(bulan)', (int)$tahun);
        $this->db->like('no_per_id', '95', 'after');
        $biaya_data = $this->db->get()->result_array();

        if (empty($biaya_data)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Tidak ada data biaya HPP ditemukan untuk tahun ini.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/arus_kas/pengeluaran_ops');
            return;
        }

        // 🔹 Hapus data lama tahun tersebut untuk no_per_id yang dimulai 93*
        $this->db->where('YEAR(bulan)', (int)$tahun);
        $this->db->like('no_per_id', '95', 'after');
        $this->db->delete('rkap_arus_kas');

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

            // 🔹 Insert data baru
            $this->db->insert('rkap_arus_kas', $data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data biaya HPP Sambungan Baru ke Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> Semua data biaya HPP Sambungan Baru berhasil digenerate ke Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
        }

        redirect('lembar_kerja/arus_kas/pengeluaran_ops');
    }
}
