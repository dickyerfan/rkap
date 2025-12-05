<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_air extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

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

        if ($upk) {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
            $data['data_pendapatan_air'] = $result['data'];
            $nama_upk = $result['nama_upk'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['title2'] = 'RENCANA PENJUALAN TANGKI AIR UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['data_pendapatan_air'] = $result['data'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA (KONSOLIDASI) <br> TAHUN ANGGARAN ';
            $data['title2'] = 'RENCANA PENJUALAN TANGKI AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_air/view_pendapatan_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['upk']   = $upk;
        $data['tahun'] = $tahun;

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

        if ($upk) {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
            $data['data_pendapatan_air'] = $result['data'];
            $nama_upk = $result['nama_upk'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['title2'] = 'RENCANA PENJUALAN TANGKI AIR UPK '
                . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
        } else {
            $result = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['data_pendapatan_air'] = $result['data'];
            $data['title'] = 'RENCANA PENJUALAN AIR DAN UNSUR LAINNYA (KONSOLIDASI) <br> TAHUN ANGGARAN ';
            $data['title2'] = 'RENCANA PENJUALAN TANGKI AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/pendapatan_air/laporan_pdf', $data);
    }

    public function generate_rekap()
    {
        $upk   = $this->input->post('upk');
        $tahun = $this->input->post('tahun');

        if ($upk && $tahun) {
            $this->Model_pendapatan_air->insertRekapPendapatanAir($tahun, $upk);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data Pendapatan Air berhasil digenerate ke tabel rkap_rekap.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Data Pendapatan Air gagal digenerate ke tabel rkap_rekap.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }

        redirect('lembar_kerja/lr/pendapatan_air?upk=' . $upk . '&tahun_rkap=' . $tahun);
    }

    public function tangki_air()
    {
        $tahun = $this->input->get('tahun') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $no_per_list = $this->db->like('kode', '81.01.05.01')->get('no_per')->result_array();
        $data['no_per_list'] = $no_per_list;
        $data['title'] = 'Form Pendapatan Tangki Air';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/pendapatan_air/upload_tangki_air', $data);
        $this->load->view('templates/footer');
    }

    public function save()
    {
        // === Ambil data input ===
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');

        $data = [
            'cabang_id'        => 25, // kode bagian langganan
            'id_upk'           => 1,  // UPK Bondowoso
            'tahun'            => $tahun,
            'bulan'            => $bulan,
            'no_per_id'        => $this->input->post('no_per_id'),
            'penggunaan_rata2' => $this->input->post('penggunaan_rata2'),
            'm3_rata2'         => $this->input->post('m3_rata2'),
            'tarif_rata2'      => $this->input->post('tarif_rata2')
        ];

        // === Simpan / Update ke tabel rkap_tangki_air ===
        $this->Model_pendapatan_air->save_tangki_air($data);

        // === Hitung nilai pagu ===
        $pagu = $data['m3_rata2'] * $data['penggunaan_rata2'] * $data['tarif_rata2'];

        // === Format tanggal untuk field tanggal (tgl 01 setiap bulan) ===
        $tanggal = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-01';
        // === Susun data rekap ===
        $rekap = [
            'id_upk'    => $data['id_upk'],
            'cabang_id' => $data['cabang_id'],
            'no_per_id' => $data['no_per_id'],
            'bulan'     => $tanggal,
            'pagu'      => $pagu
        ];

        // === Simpan atau update ke tabel rkap_rekap ===
        $this->Model_pendapatan_air->save_rekap_tangki($rekap);

        // === Flash message & redirect ===
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Pendapatan Tangki Air berhasil disimpan dan direkap.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/lr/pendapatan_air');
    }
}
