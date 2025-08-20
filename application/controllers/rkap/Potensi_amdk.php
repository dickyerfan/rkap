<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Potensi_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_potensi_amdk');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $data['title'] = 'ESTIMASI LABA RUGI AMDK TAHUN';
        $data['title1'] = 'ESTIMASI PENDAPATAN AMDK TAHUN';
        $data['title2'] = 'ESTIMASI BIAYA AMDK TAHUN';
        $data['produksi'] = $this->Model_potensi_amdk->getProduksi();
        $data['biaya'] = $this->Model_potensi_amdk->getBiaya();

        $pend_air = $this->Model_potensi_amdk->getPendAir();
        $pend_non_air = $this->Model_potensi_amdk->getPendNonAir();

        $total_pend_air = 0;
        foreach ($pend_air as $row) {
            $total = $row->harga * $row->jumlah;
            $total_pend_air += $total;
        }

        $total_pendNon_air = 0;
        foreach ($pend_non_air as $row) {
            $total = $row->harga * $row->jumlah;
            $total_pendNon_air += $total;
        }

        $by_peg = $this->Model_potensi_amdk->getBiayaPegawai();
        $by_ops = $this->Model_potensi_amdk->getBiayaOperasional();

        $total_by_peg = 0;
        foreach ($by_peg as $row) {
            $total_by_peg +=  $row->jumlah;
        }

        $total_by_ops = 0;
        foreach ($by_ops as $row) {
            $total_by_ops +=  $row->jumlah;
        }

        $laba_rugi = ($total_pend_air + $total_pendNon_air) - ($total_by_peg + $total_by_ops);

        $data['total_pend_air'] = $total_pend_air;
        $data['total_pendNon_air'] = $total_pendNon_air;
        $data['total_by_peg'] = $total_by_peg;
        $data['total_by_ops'] = $total_by_ops;
        $data['laba_rugi'] = $laba_rugi;

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/potensi_amdk/view_potensi_amdk', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function upload()
    {
        $data['title'] = 'Input Estimasi Pendapatan';
        $statusUpload = $this->Model_potensi_amdk->getStatusUpload('potensi_amdk');

        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> data sudah tidak bisa di input.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('rkap/Potensi_amdk');
        } else {

            $this->form_validation->set_rules('uraian', 'Uraian', 'required|trim');
            $this->form_validation->set_rules('harga', 'Harga', 'required|trim|numeric');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim|numeric');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/potensi_amdk/upload_potensi_amdk', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                // Cek apakah data dengan uraian & tahun_rkap sudah ada
                $uraian     = trim($this->input->post('uraian', true));
                $tarif    = trim($this->input->post('tarif', true));
                $tahun_rkap = date('Y');

                $cek = $this->Model_potensi_amdk->cekDuplikat($uraian, $tarif, $tahun_rkap);

                if ($cek) {
                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Data dengan uraian <b>' . $uraian . '</b> untuk tahun ' . $tahun_rkap . ' sudah ada.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                    );
                    redirect('rkap/Potensi_amdk/upload');
                }

                // Simpan jika belum ada
                $this->Model_potensi_amdk->uploadData();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Pendapatan AMDK berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
                );
                redirect('rkap/Potensi_amdk');
            }
        }
    }

    public function edit_potensi_amdk($id_potensi_amdk)
    {
        $data['title'] = 'Update Estimasi Pendapatan';
        $statusUpdate = $this->Model_potensi_amdk->getStatusUpdate('potensi_amdk');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/potensi_amdk');
        } else {
            $data['potensi_amdk'] = $this->Model_potensi_amdk->getPotensiAmdk($id_potensi_amdk);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/potensi_amdk/edit_potensi_amdk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->Model_potensi_amdk->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/potensi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data potensi amdk berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/potensi_amdk');
        }
    }

    public function upload_biaya()
    {
        $data['title'] = 'Input Estimasi Biaya';
        $statusUpload = $this->Model_potensi_amdk->getStatusUpload('biaya_amdk');

        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> data sudah tidak bisa di input.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('rkap/Potensi_amdk');
        } else {

            $this->form_validation->set_rules('tipe_biaya', 'Tipe Biaya', 'required|trim');
            $this->form_validation->set_rules('nama_biaya', 'Nama Biaya', 'required|trim');
            $this->form_validation->set_rules('rincian_biaya', 'Rincian Biaya', 'required|trim');
            $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim|numeric');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/potensi_amdk/upload_biaya_amdk', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $rincian_biaya    = trim($this->input->post('rincian_biaya', true));
                $tahun_rkap = date('Y');
                $cek = $this->Model_potensi_amdk->cekDuplikatBiaya($rincian_biaya, $tahun_rkap);

                if ($cek) {
                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Data dengan nama biaya <b>' . $rincian_biaya . '</b> untuk tahun ' . $tahun_rkap . ' sudah ada.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                    );
                    redirect('rkap/Potensi_amdk/upload_biaya');
                }

                // Simpan jika belum ada
                $this->Model_potensi_amdk->uploadDataBiaya();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Biaya AMDK berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
                );
                redirect('rkap/Potensi_amdk');
            }
        }
    }

    public function edit_biaya_amdk($id_biaya_amdk)
    {
        $data['title'] = 'Update Biaya AMDK';
        $statusUpdate = $this->Model_potensi_amdk->getStatusUpdate('biaya_amdk');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/potensi_amdk');
        } else {
            $data['biaya_amdk'] = $this->Model_potensi_amdk->getBiayaAmdk($id_biaya_amdk);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/potensi_amdk/edit_biaya_amdk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_biaya()
    {
        $this->Model_potensi_amdk->updateDataBiaya();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/potensi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Biaya amdk berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/potensi_amdk');
        }
    }

    // public function export_pdf()
    // {

    //     $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';
    //     $data['tahun'] = $this->Model_evaluasi_amdk->getTahun();
    //     $data['tenaga_kerja'] = $this->Model_evaluasi_amdk->getTenagaKerja();
    //     $data['piutang_usaha'] = $this->Model_evaluasi_amdk->getPiutangUsaha();
    //     $data['pendapatan_usaha'] = $this->Model_evaluasi_amdk->getPendapatanUsaha();
    //     $data['statusEvaluasiAmdk'] = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
    //     $data['target'] = $this->Model_evaluasi_amdk->getTarget();
    //     $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getUsulanAdmin();
    //     $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getUsulanTeknik();

    //     $upk_bagian = $this->session->userdata('upk_bagian');
    //     $tahun = date('Y');

    //     // Set paper size and orientation
    //     $this->pdf->setPaper('A4', 'portrait');
    //     // $this->pdf->filename = "Potensi Sr.pdf";
    //     $this->pdf->filename = "Potensi Sr-{$upk_bagian}-{$tahun}.pdf";
    //     $this->pdf->generate('rkap/evaluasi_amdk/laporan_pdf', $data);
    // }
}
