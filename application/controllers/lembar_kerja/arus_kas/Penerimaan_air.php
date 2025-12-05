<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_air extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penerimaan_air');
        $this->load->model('Model_pendapatan_air');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {

        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        $this->session->set_userdata('tahun_rkap', $tahun);
        $this->session->set_userdata('upk', $upk);

        $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusi($tahun, $upk);

        $data['per_jenis'] = $res['per_jenis'];
        $data['overall_totals'] = $res['overall_totals'];
        $data['overall_grand'] = $res['overall_grand'];

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['title'] = 'RENCANA PENERIMAAN TAGIHAN REKENING AIR <br> TAHUN ANGGARAN ';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        // data tangki air
        $tangki_air = [
            'penggunaan_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'm3_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'tarif_rata2' => array_fill(1, 12, 0) + ['total' => 0]
        ];

        $rawData = $this->Model_pendapatan_air->getTangkiAir($upk, $tahun);
        foreach ($rawData as $row) {
            $bulan = (int)$row->bulan;
            $tangki_air['penggunaan_rata2'][$bulan] = $row->penggunaan_rata2;
            $tangki_air['m3_rata2'][$bulan] = $row->m3_rata2;
            $tangki_air['tarif_rata2'][$bulan] = $row->tarif_rata2;
        }

        // Hitung total untuk setiap baris
        foreach ($tangki_air as $key => &$values) {
            if ($key == 'm3_rata2' || $key == 'tarif_rata2') {
                $values['total'] = $values['1'];
            } else {
                $values['total'] = array_sum(array_slice($values, 0, 12));
            }
        }
        $data['tangki_air'] = $tangki_air;
        // end data tangki air

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/view_penerimaan_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');


        $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusi($tahun, $upk);

        $data['per_jenis'] = $res['per_jenis'];
        $data['overall_totals'] = $res['overall_totals'];
        $data['overall_grand'] = $res['overall_grand'];

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['title'] = 'RENCANA PENERIMAAN TAGIHAN REKENING AIR <br> TAHUN ANGGARAN ';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        // data tangki air
        $tangki_air = [
            'penggunaan_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'm3_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'tarif_rata2' => array_fill(1, 12, 0) + ['total' => 0]
        ];

        $rawData = $this->Model_pendapatan_air->getTangkiAir($upk, $tahun);
        foreach ($rawData as $row) {
            $bulan = (int)$row->bulan;
            $tangki_air['penggunaan_rata2'][$bulan] = $row->penggunaan_rata2;
            $tangki_air['m3_rata2'][$bulan] = $row->m3_rata2;
            $tangki_air['tarif_rata2'][$bulan] = $row->tarif_rata2;
        }

        // Hitung total untuk setiap baris
        foreach ($tangki_air as $key => &$values) {
            if ($key == 'm3_rata2' || $key == 'tarif_rata2') {
                $values['total'] = $values['1'];
            } else {
                $values['total'] = array_sum(array_slice($values, 0, 12));
            }
        }
        $data['tangki_air'] = $tangki_air;
        // end data tangki air

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_penerimaan_air_{$tahun}_{$upk}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/penerimaan_air/laporan_pdf', $data);
    }

    public function generate()
    {
        $tahun = $this->input->post('tahun');
        $cabang_id = $this->input->post('cabang_id');
        $grand_per_month = $this->input->post('pagu'); // array bulan => nilai

        if (!$tahun || empty($grand_per_month)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data penerimaan air ke Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/arus_kas/penerimaan_air');
            return;
        }

        // Hapus data lama
        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";

        $this->db->where('no_per_id', '81.01.01');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');

        // Simpan data baru
        foreach ($grand_per_month as $bulan_ke => $nilai) {
            $bulan_fix = str_pad($bulan_ke, 2, '0', STR_PAD_LEFT);
            $tanggal_bulan = "$tahun-$bulan_fix-01";

            $data_insert = [
                'cabang_id' => '24',
                'no_per_id' => '81.01.01',
                'bulan'     => $tanggal_bulan,
                'pagu' => (float) $nilai

            ];

            $this->db->insert('rkap_arus_kas', $data_insert);
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_air');
    }

    public function generate_ta()
    {
        $upk   = $this->session->userdata('upk'); // atau ambil dari input get/post
        $tahun = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $cabang_id = $upk; // pakai upk yang sama seperti di view
        $no_per_id = '81.01.05';

        $tangki_air = $this->Model_pendapatan_air->getTangkiAir($cabang_id, $tahun);

        // if (empty($tangki_air)) {
        //     echo "DATA KOSONG untuk cabang_id = {$cabang_id}, tahun = {$tahun}";
        //     exit;
        // } else {
        //     echo "<pre>";
        //     print_r($tangki_air);
        //     echo "</pre>";
        //     exit;
        // }

        // Pastikan hasilnya berbentuk array [1..12]
        $penggunaan_rata2 = array_fill(1, 12, 0);
        $m3_rata2         = array_fill(1, 12, 0);
        $tarif_rata2      = array_fill(1, 12, 0);

        foreach ($tangki_air as $row) {
            $bulan = (int)$row->bulan;
            $penggunaan_rata2[$bulan] = (float)$row->penggunaan_rata2;
            $m3_rata2[$bulan]         = (float)$row->m3_rata2;
            $tarif_rata2[$bulan]      = (float)$row->tarif_rata2;
        }

        // 🔹 Hitung total bulanan (sesuai rumus di view)
        $total_per_bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $total_per_bulan[$i] = $penggunaan_rata2[$i] * $m3_rata2[$i] * $tarif_rata2[$i];
        }

        // 🔹 Hapus data lama agar tidak dobel
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->where('cabang_id', $cabang_id);
        $this->db->where('no_per_id', $no_per_id);
        $this->db->delete('rkap_arus_kas');

        // 🔹 Insert ke database
        for ($i = 1; $i <= 12; $i++) {
            $bulan_str = str_pad($i, 2, '0', STR_PAD_LEFT);
            $this->db->insert('rkap_arus_kas', [
                'cabang_id' => 23,
                'no_per_id' => $no_per_id,
                'bulan'     => "{$tahun}-{$bulan_str}-01",
                'pagu'      => $total_per_bulan[$i],
            ]);
        }

        $this->session->set_flashdata(
            'info',
            '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data Penerimaan Air Tangki berhasil digenerate ke Arus Kas.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_air');
    }




    public function tampil_tahun_lalu()
    {
        $tahun_rkap = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun_rkap;
        $data['title'] = 'Proyeksi Sisa Piutang Air Tahun ';
        $data['hasil'] = $this->Model_penerimaan_air->get_tahun_lalu($tahun_rkap, $this->input->get('upk'));
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/view_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function input_tahun_lalu()
    {
        $data['title'] = 'Input Data Penerimaan Air Tahun Lalu';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();
        $data['list_jp'] = $this->db->get('rkap_jenis_plgn')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/input_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_tahun_lalu()
    {
        $id_upk        = $this->input->post('id_upk');
        $id_jp         = $this->input->post('id_jp');
        $tahun         = $this->input->post('tahun');


        // 🔍 Cek apakah kombinasi id_produk + tahun sudah ada
        if ($this->Model_penerimaan_air->cek_tahun_lalu($id_upk, $id_jp, $tahun)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data piutang Air tahun lalu sudah ada.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
            return;
        }

        // ✅ Jika belum ada, lanjut insert
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'lembar_lalu'   => $this->input->post('lembar_lalu'),
            'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
            'ptgs_upload'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
        ];

        $this->Model_penerimaan_air->insert_tahun_lalu($data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Piutang Air tahun lalu berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );

        redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    }
    // public function simpan_tahun_lalu()
    // {
    //     $data = [
    //         'id_upk'        => $this->input->post('id_upk'),
    //         'id_jp'         => $this->input->post('id_jp'),
    //         'tahun'         => $this->input->post('tahun'),
    //         'lembar_lalu'   => $this->input->post('lembar_lalu'),
    //         'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
    //         'ptgs_upload'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
    //     ];

    //     $this->Model_penerimaan_air->insert_tahun_lalu($data);

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 <strong>Berhasil,</strong> Data Penerimaan tahun lalu berhasil disimpan.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //     );

    //     redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    // }

    public function edit_tahun_lalu($id)
    {
        $data['title'] = 'Edit Data Penerimaan Air Tahun Lalu';
        $data['data'] = $this->Model_penerimaan_air->get_tahun_lalu_by_id($id);

        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();
        $data['list_jp'] = $this->db->get('rkap_jenis_plgn')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/edit_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function update_tahun_lalu_aksi()
    {
        $id = $this->input->post('id');
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'lembar_lalu'   => $this->input->post('lembar_lalu'),
            'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
            'ptgs_update'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
        ];

        $update = $this->Model_penerimaan_air->update_tahun_lalu($id, $data);
        if ($update) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data Penerimaan tahun lalu berhasil diupdate.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error,</strong> Data Penerimaan tahun lalu gagal diupdate.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }

        redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    }
}
