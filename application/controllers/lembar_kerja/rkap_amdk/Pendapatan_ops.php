<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pendapatan_ops extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pendapatan_amdk');
        $this->load->model('Model_produksi_amdk');
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

        $data['pendapatan'] = $this->Model_pendapatan_amdk->getDataPendapatan($tahun);
        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PENDAPATAN UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/pendapatan/view_pendapatan', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['pendapatan'] = $this->Model_pendapatan_amdk->getDataPendapatan($tahun);
        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PENDAPATAN UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pendapatan_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/pendapatan/laporan_pdf', $data);
    }


    public function tambah()
    {
        if ($this->input->post()) {
            $id_produk = $this->input->post('id_produk');
            $id_tarif = $this->input->post('id_tarif');
            $harga = $this->input->post('harga');
            $tahun_rkap = $this->session->userdata('tahun_rkap');

            $data = [
                'id_produk' => $id_produk,
                'id_tarif' => $id_tarif,
                'harga' => $harga,
                'tahun_rkap' => $tahun_rkap,
                'ptgs_upload' => $this->session->userdata('nama_lengkap')
            ];
            $this->Model_pendapatan_amdk->insertHarga($data);

            // Jika berhasil insert
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data Harga produk AMDK berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('lembar_kerja/rkap_amdk/pendapatan_ops?tahun_rkap=' . $tahun);
        } else {
            $data['produk'] = $this->db->get('rkap_amdk_produk')->result();
            $data['tarif'] = $this->db->get('rkap_amdk_tarif')->result();
            $data['title'] = 'Input Data Harga AMDK';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/pendapatan/upload_harga', $data);
            $this->load->view('templates/footer');
        }
    }

    public function generate()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $dataPendapatan = $this->Model_pendapatan_amdk->getDataPendapatan($tahun);

        $id_upk = 23;
        $cabang_id = 13;

        // Mapping nama produk ke kode dasar
        $kode_kelompok = [
            'Galon 19L' => '88.02.01',
            'Gelas 220ml' => '88.02.02',
            'Botol 330ml' => '88.02.03',
            'Botol 500ml' => '88.02.04',
            'Botol 250ml' => '88.02.05',
            'Botol 1500ml' => '88.02.06'
        ];

        // Mapping tarif ke kode akhir
        $kode_tarif = [
            'umum' => '01',
            'retail' => '02',
            'grosir' => '03'
        ];

        foreach ($dataPendapatan['produksi'] as $produk) {
            $nama_produk = trim($produk['nama_produk']);
            $id_produk = $produk['id_produk'];

            if (!isset($kode_kelompok[$nama_produk])) continue;
            $base_kode = $kode_kelompok[$nama_produk];

            foreach ($produk['tarif'] as $tarif => $dataTarif) {
                $tarif_lower = strtolower(trim($tarif));
                if (!isset($kode_tarif[$tarif_lower])) continue;

                $kode_akun = $base_kode . '.' . $kode_tarif[$tarif_lower];
                $no_per = $this->db->get_where('no_per', ['kode' => $kode_akun])->row();
                if (!$no_per) continue;
                $no_per_id = $no_per->kode;

                // ambil id_tarif dengan helper (sesuaikan fungsi getTarifId)
                $id_tarif = $this->getTarifId($tarif);
                // ambil harga per tarif dari tabel rkap_amdk_harga
                $hargaRow = $this->db->get_where('rkap_amdk_harga', [
                    'id_produk' => $id_produk,
                    'tahun_rkap' => $tahun,
                    'id_tarif' => $id_tarif
                ])->row();
                $harga = $hargaRow ? (float)$hargaRow->harga : 0;

                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $produksi_bulan = $dataTarif['produksi'][$bulan] ?? 0;
                    $pagu = (float)$produksi_bulan * $harga;
                    if ($pagu <= 0) continue;

                    // buat format date untuk kolom bulan (gunakan tgl 1 bulan)
                    $bulan_date = $tahun . '-' . sprintf('%02d', $bulan) . '-01';

                    // Cek data existing berdasarkan no_per_id, bulan (date) dan id_upk
                    $cek = $this->db->get_where('rkap_rekap', [
                        'no_per_id' => $no_per_id,
                        'bulan' => $bulan_date,
                        'id_upk' => $id_upk,
                    ])->row();

                    if ($cek) {
                        // update
                        $this->db->where('id', $cek->id)
                            ->update('rkap_rekap', ['pagu' => $pagu]);
                    } else {
                        // insert
                        $this->db->insert('rkap_rekap', [
                            'id_upk' => $id_upk,
                            'cabang_id' => $cabang_id,
                            'no_per_id' => $no_per_id,
                            'bulan' => $bulan_date,
                            'pagu' => $pagu
                        ]);
                    }
                }
            }
        }

        $this->session->set_flashdata('info', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pendapatan AMDK berhasil digenerate ke tabel RKAP_REKAP.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    ');
        redirect('lembar_kerja/rkap_amdk/pendapatan_ops?tahun_rkap=' . $tahun);
    }


    // fungsi bantu untuk ambil id_tarif dari nama tarif
    private function getTarifId($tarif)
    {
        $this->db->where('LOWER(tarif) =', strtolower($tarif));
        $row = $this->db->get('rkap_amdk_tarif')->row();
        return $row ? $row->id_tarif : null;
    }
}
