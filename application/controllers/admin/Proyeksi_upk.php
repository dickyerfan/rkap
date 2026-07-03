<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyeksi_upk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_proyeksi_upk');
        $this->load->model('Model_pengaturan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $id_upk = $this->input->get('id_upk');
        $data['tahun_rkap']  = $tahun;
        $data['id_upk'] = $id_upk;

        $data['upk'] = $this->db
            ->where('status =', 1)
            ->order_by('kode', 'ASC')
            ->get('rkap_nama_upk')
            ->result();

        if ($id_upk == '') {
            $data['judul_upk'] = 'KONSOLIDASI';
        } else {
            $u = $this->db
                ->where('id_upk', $id_upk)
                ->get('rkap_nama_upk')
                ->row();
            $data['judul_upk'] = 'UPK ' . strtoupper($u->nama_upk);
        }
        $data['tampil'] = $this->Model_proyeksi_upk->getDataAll($tahun, $id_upk);

        if ($tahun == 2025 || $tahun == 2026) {
            $data['title'] = 'REALISASI PENCAPAIAN TAHUN ' . $tahun;
        } else {
            $data['title'] = 'PROYEKSI / TARGET TAHUN ' . $tahun;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/proyeksi_upk/view_proyeksi_upk', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $nama_upk = $this->session->userdata('upk_bagian');
        $upk = $this->db
            ->where('nama_upk', $nama_upk)
            ->get('rkap_nama_upk')
            ->row();
        $id_upk = $upk->id_upk ?? 0;
        $data['tahun'] = $tahun;
        $data['tampil'] = $this->Model_proyeksi_upk->getData($tahun, $id_upk);
        $data['title'] = 'PROYEKSI / TARGET TAHUN ' . $tahun;

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'landscape');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Proyeksi_upk-{$nama_upk}-{$tahun}.pdf";
        $this->pdf->generate('admin/proyeksi_upk/laporan_pdf', $data);
    }

    public function upload()
    {
        $statusUpload = $this->Model_pengaturan->getStatusUpload();
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> sudah tidak bisa input data baru.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/proyeksi_upk');
        } else {
            $nama_upk = $this->session->userdata('upk_bagian');
            $upk = $this->db
                ->where('nama_upk', $nama_upk)
                ->get('rkap_nama_upk')
                ->row();
            $id_upk = $upk->id_upk ?? 0;
            $tahun = $this->input->post('tahun_rkap') ?: ($this->input->get('tahun_rkap') ?: (date('Y') + 1));

            if ($this->input->method() === 'post') {

                $sr_baru     = $this->input->post('sr_baru');
                $penutupan   = $this->input->post('penutupan');
                $pencabutan  = $this->input->post('pencabutan');
                $pembukaan   = $this->input->post('pembukaan');
                $tera_meter  = $this->input->post('tera_meter');
                $ganti_meter = $this->input->post('ganti_meter');
                $efi_tagih   = $this->input->post('efi_tagih');
                $errors = [];
                $nama_bulan = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];

                for ($bulan = 1; $bulan <= 12; $bulan++) {

                    $fields = [
                        'SR Baru'      => $sr_baru[$bulan]     ?? 0,
                        'Penutupan'    => $penutupan[$bulan]   ?? 0,
                        'Pencabutan'   => $pencabutan[$bulan]  ?? 0,
                        'Pembukaan'    => $pembukaan[$bulan]   ?? 0,
                        'Tera Meter'   => $tera_meter[$bulan]  ?? 0,
                        'Ganti Meter'  => $ganti_meter[$bulan] ?? 0,
                    ];

                    foreach ($fields as $label => $val) {
                        if (!is_numeric($val) || $val < 0) {
                            $errors[] = $nama_bulan[$bulan] . ' - ' . $label . ' tidak boleh angka negatif';
                        }
                    }

                    $efi = $efi_tagih[$bulan] ?? 0;
                    if (!is_numeric($efi) || $efi < 0 || $efi > 100) {
                        $errors[] = $nama_bulan[$bulan] . ' - Efisiensi Penagihan harus di antara 0 - 100';
                    }
                }

                // kalau ada error, hentikan proses simpan dan kembalikan ke form
                if (!empty($errors)) {
                    $this->session->set_flashdata('error_validasi', $errors);
                    redirect('admin/proyeksi_upk/upload?tahun_rkap=' . $tahun);
                }

                // ===== Cek apakah ada perubahan data =====
                $ada_perubahan = false;

                for ($bulan = 1; $bulan <= 12; $bulan++) {

                    $cek = $this->Model_proyeksi_upk->cekData($tahun, $id_upk, $bulan);

                    $baru = [
                        'sr_baru'     => (float) ($sr_baru[$bulan]     ?? 0),
                        'penutupan'   => (float) ($penutupan[$bulan]   ?? 0),
                        'pencabutan'  => (float) ($pencabutan[$bulan]  ?? 0),
                        'pembukaan'   => (float) ($pembukaan[$bulan]   ?? 0),
                        'tera_meter'  => (float) ($tera_meter[$bulan]  ?? 0),
                        'ganti_meter' => (float) ($ganti_meter[$bulan] ?? 0),
                        'efi_tagih'   => round((float) ($efi_tagih[$bulan] ?? 0), 2),
                    ];

                    if (!$cek) {
                        // data belum ada sama sekali untuk bulan ini = dianggap data baru, bukan "tidak ada perubahan"
                        $ada_perubahan = true;
                        continue;
                    }

                    $lama = [
                        'sr_baru'     => (float) $cek->sr_baru,
                        'penutupan'   => (float) $cek->penutupan,
                        'pencabutan'  => (float) $cek->pencabutan,
                        'pembukaan'   => (float) $cek->pembukaan,
                        'tera_meter'  => (float) $cek->tera_meter,
                        'ganti_meter' => (float) $cek->ganti_meter,
                        'efi_tagih'   => round((float) $cek->efi_tagih, 2),
                    ];

                    if ($baru !== $lama) {
                        $ada_perubahan = true;
                    }
                }

                if (!$ada_perubahan) {
                    $this->session->set_flashdata('info', '<div class="alert alert-warning">Tidak ada perubahan data yang dilakukan</div>');
                    redirect('admin/proyeksi_upk?tahun_rkap=' . $tahun);
                }
                // ===== Selesai cek perubahan =====

                $ptgs = $this->session->userdata('nama_pengguna');

                for ($bulan = 1; $bulan <= 12; $bulan++) {

                    $set = [
                        'id_upk'      => $id_upk,
                        'tahun_rkap'  => $tahun,
                        'bulan'       => $bulan,
                        'sr_baru'     => $sr_baru[$bulan] ?? 0,
                        'penutupan'   => $penutupan[$bulan] ?? 0,
                        'pencabutan'  => $pencabutan[$bulan] ?? 0,
                        'pembukaan'   => $pembukaan[$bulan] ?? 0,
                        'tera_meter'  => $tera_meter[$bulan] ?? 0,
                        'ganti_meter' => $ganti_meter[$bulan] ?? 0,
                        'efi_tagih'   => $efi_tagih[$bulan] ?? 0,
                    ];

                    $cek = $this->Model_proyeksi_upk->cekData($tahun, $id_upk, $bulan);

                    if ($cek) {
                        $set['status_update'] = 1;
                        $set['tgl_update']    = date('Y-m-d H:i:s');
                        $set['ptgs_update']   = $ptgs;

                        $this->Model_proyeksi_upk->updateData($cek->id_evaluasi, $set);
                    } else {
                        $set['status']     = 1;
                        $set['tgl_upload'] = date('Y-m-d H:i:s');
                        $set['ptgs_upload'] = $ptgs;
                        $this->Model_proyeksi_upk->insertData($set);
                    }
                }

                $this->session->set_flashdata('info', '<div class="alert alert-success">Data berhasil disimpan</div>');
                redirect('admin/proyeksi_upk?tahun_rkap=' . $tahun);
            }

            $data['tahun']  = $tahun;
            $data['tampil'] = $this->Model_proyeksi_upk->getData($tahun, $id_upk);
            $data['title']  = 'UPLOAD PROYEKSI UPK TAHUN ' . $tahun;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/proyeksi_upk/upload_proyeksi_upk', $data);
            $this->load->view('templates/footer');
        }
    }
}
