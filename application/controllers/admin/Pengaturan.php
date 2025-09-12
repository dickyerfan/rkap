<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pengaturan');
        $this->load->model('Model_setting');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $data['title'] = 'Aktivasi Upload & Update Data ';
        $data['upload'] = $this->Model_pengaturan->cekUpload();
        $data['update'] = $this->Model_pengaturan->cekUpdate();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_pengaturan', $data);
        $this->load->view('templates/footer');
    }

    public function uploadOff()
    {
        $data['title'] = 'PENGATURAN ';
        $data['upload'] = $this->Model_pengaturan->cekUpload();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_uploadOff', $data);
        $this->load->view('templates/footer');
    }

    public function updateOff()
    {
        $data['title'] = 'PENGATURAN ';
        $data['update'] = $this->Model_pengaturan->cekUpdate();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_updateOff', $data);
        $this->load->view('templates/footer');
    }

    public function matikanUpload()
    {
        $this->Model_pengaturan->matikanUploadData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Status Upload berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan');
        }
    }

    public function matikanUpdate()
    {
        $this->Model_pengaturan->matikanUpdateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Status Update berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan');
        }
    }

    public function aktivasiUser()
    {
        $data['title'] = 'Aktivasi User / Pengguna ';
        $data['statusPenggunaUpk'] = $this->Model_pengaturan->cekStatusPenggunaUpk();
        $data['statusPenggunaBagian'] = $this->Model_pengaturan->cekStatusPenggunaBagian();
        // $data['statusPengisi'] = $this->Model_pengaturan->cekStatusPengisi();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_pengaturan_user', $data);
        $this->load->view('templates/footer');
    }

    public function matikanUserUpk()
    {
        $data['title'] = 'PENGATURAN ';
        $data['statusPenggunaUpk'] = $this->Model_pengaturan->cekStatusPenggunaUpk();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_matikan_user', $data);
        $this->load->view('templates/footer');
    }

    public function penggunaOffUpk()
    {
        $this->Model_pengaturan->penggunaOffUpk();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan/aktivasiUser');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Status User / Pengguna berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan/aktivasiUser');
        }
    }

    public function matikanUserBagian()
    {
        $data['title'] = 'PENGATURAN ';
        $data['statusPenggunaBagian'] = $this->Model_pengaturan->cekStatusPenggunaBagian();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_matikan_user_bagian', $data);
        $this->load->view('templates/footer');
    }

    public function penggunaOffBagian()
    {
        $this->Model_pengaturan->penggunaOffBagian();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan/aktivasiUser');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Status User / Pengguna berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/pengaturan/aktivasiUser');
        }
    }

    public function kumpul_data()
    {
        $data['title'] = 'Cek Pengumpulan Data ';
        $data['namaUpk'] = $this->Model_pengaturan->cekNamaUpk();
        $data['potensiSr'] = $this->Model_pengaturan->cekPotensiSr();
        $data['evaluasiUpk'] = $this->Model_pengaturan->cekEvaluasiUpk();
        $data['evaluasiAmdk'] = $this->Model_pengaturan->cekEvaluasiAmdk();
        $data['potensiAmdk'] = $this->Model_pengaturan->cekPotensiAmdk();
        $data['usulanUmum'] = $this->Model_pengaturan->cekUsulanUmum();
        $data['usulanBarang'] = $this->Model_pengaturan->cekUsulanBarang();
        $data['usulanInvestasi'] = $this->Model_pengaturan->cekUsulanInvestasi();
        $data['usulanPemeliharaan'] = $this->Model_pengaturan->cekUsulanPemeliharaan();
        $data['namaBagian'] = $this->Model_pengaturan->cekNamaBagian();
        $data['permasalahan'] = $this->Model_pengaturan->cekPermasalahan();
        $data['evaluasiProgram'] = $this->Model_pengaturan->cekEvaluasiProgram();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_kumpul_data', $data);
        $this->load->view('templates/footer');
    }

    public function aktivasiAdmin()
    {
        $data['title'] = 'Aktivasi Administrator ';
        $tahun = date('Y');
        $data['tahun'] = $tahun;
        $data['is_locked'] = $this->Model_setting->cekLock($tahun);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_pengaturan_admin', $data);
        $this->load->view('templates/footer');
    }

    public function lock($tahun)
    {
        $this->Model_setting->setLock($tahun, 1);
        redirect('admin/pengaturan/aktivasiAdmin');
    }

    public function unlock($tahun)
    {
        $this->Model_setting->setLock($tahun, 0);
        redirect('admin/pengaturan/aktivasiAdmin');
    }

    // public function kumpul_data()
    // {
    //     $data['title'] = 'Cek Pengumpulan Data';
    //     $bagian_upk = $this->session->userdata('upk_bagian'); // contoh
    //     $data['namaUpk'] = $this->Model_pengaturan->cekNamaUpk();
    //     $data['namaBagian'] = $this->Model_pengaturan->cekNamaBagian();
    //     $data['potensiSr'] = $this->Model_pengaturan->cekPotensiSr($bagian_upk);
    //     $data['evaluasiUpk'] = $this->Model_pengaturan->cekEvaluasiUpk($bagian_upk);
    //     $data['evaluasiAmdk'] = $this->Model_pengaturan->cekEvaluasiAmdk($bagian_upk);
    //     $data['potensiAmdk'] = $this->Model_pengaturan->cekPotensiAmdk($bagian_upk);
    //     $data['usulanUmum'] = $this->Model_pengaturan->cekUsulanUmum($bagian_upk);
    //     $data['usulanBarang'] = $this->Model_pengaturan->cekUsulanBarang($bagian_upk);
    //     $data['usulanInvestasi'] = $this->Model_pengaturan->cekUsulanInvestasi($bagian_upk);
    //     $data['usulanPemeliharaan'] = $this->Model_pengaturan->cekUsulanPemeliharaan($bagian_upk);
    //     $data['permasalahan'] = $this->Model_pengaturan->cekPermasalahan($bagian_upk);
    //     $data['evaluasiProgram'] = $this->Model_pengaturan->cekEvaluasiProgram($bagian_upk);

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('admin/view_kumpul_data', $data);
    //     $this->load->view('templates/footer');
    // }
}
