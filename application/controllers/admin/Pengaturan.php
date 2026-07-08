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
        $data['upload_bagian'] = $this->Model_pengaturan->cekUploadBagian();
        $data['upload_amdk'] = $this->Model_pengaturan->cekUploadAmdk();
        $data['update'] = $this->Model_pengaturan->cekUpdate();
        $data['update_bagian'] = $this->Model_pengaturan->cekUpdateBagian();
        $data['update_amdk'] = $this->Model_pengaturan->cekUpdateAmdk();
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
    public function uploadOffBagian()
    {
        $data['title'] = 'PENGATURAN ';
        $data['upload_bagian'] = $this->Model_pengaturan->cekUploadBagian();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_uploadOffBagian', $data);
        $this->load->view('templates/footer');
    }
    public function uploadOffAmdk()
    {
        $data['title'] = 'PENGATURAN ';
        $data['upload_amdk'] = $this->Model_pengaturan->cekUploadAmdk();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_uploadOffAmdk', $data);
        $this->load->view('templates/footer');
    }

    public function updateOffBagian()
    {
        $data['title'] = 'PENGATURAN ';
        $data['update_bagian'] = $this->Model_pengaturan->cekUpdateBagian();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_updateOffBagian', $data);
        $this->load->view('templates/footer');
    }
    public function updateOffAmdk()
    {
        $data['title'] = 'PENGATURAN ';
        $data['update_amdk'] = $this->Model_pengaturan->cekUpdateAmdk();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_updateOffAmdk', $data);
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
    public function matikanUploadBagian()
    {
        $this->Model_pengaturan->matikanUploadDataBagian();
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
    public function matikanUploadAmdk()
    {
        $this->Model_pengaturan->matikanUploadDataAmdk();
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
    public function matikanUpdateBagian()
    {
        $this->Model_pengaturan->matikanUpdateDataBagian();
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
    public function matikanUpdateAmdk()
    {
        $this->Model_pengaturan->matikanUpdateDataAmdk();
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
        $data['title'] = 'Aktivasi User (Untuk Mematikan user agar tidak bisa login) ';
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
        $data['proyeksiUpk'] = $this->Model_pengaturan->cekProyeksiUpk();

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/view_kumpul_data', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('admin/view_kumpul_data', $data);
            $this->load->view('templates/pengguna/footer');
        }
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

    public function struktur()
    {
        $data['title'] = 'Struktur Karyawan';
        $data['karyawan_aktif'] = $this->db->query("
            SELECT k.*, b.nama_bagian, s.nama_subag, j.nama_jabatan
            FROM karyawan k
            LEFT JOIN bagian b ON k.id_bagian = b.id_bagian
            LEFT JOIN subag s ON k.id_subag = s.id_subag
            LEFT JOIN jabatan j ON k.id_jabatan = j.id_jabatan
            WHERE k.aktif = 1
            ORDER BY b.nama_bagian DESC, s.nama_subag DESC, j.nama_jabatan , k.nama DESC
        ")->result();
        $data['karyawan_purna'] = $this->db->query("
            SELECT k.*, b.nama_bagian, s.nama_subag, j.nama_jabatan
            FROM karyawan k
            LEFT JOIN bagian b ON k.id_bagian = b.id_bagian
            LEFT JOIN subag s ON k.id_subag = s.id_subag
            LEFT JOIN jabatan j ON k.id_jabatan = j.id_jabatan
            WHERE k.aktif = 0
            ORDER BY k.nama
        ")->result();
        $data['bagian'] = $this->db->get('bagian')->result();
        $data['subag'] = $this->db->get('subag')->result();
        $data['jabatan'] = $this->db->get('jabatan')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_struktur_karyawan', $data);
        $this->load->view('templates/footer');
    }

    public function strukturTambah()
    {
        $this->db->insert('karyawan', [
            'id_bagian' => $this->input->post('id_bagian'),
            'id_subag' => $this->input->post('id_subag'),
            'id_jabatan' => $this->input->post('id_jabatan'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'agama' => $this->input->post('agama'),
            'status_pegawai' => $this->input->post('status_pegawai'),
            'nik' => $this->input->post('nik'),
            'no_hp' => $this->input->post('no_hp'),
            'jenkel' => $this->input->post('jenkel'),
            'tmp_lahir' => $this->input->post('tmp_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'aktif' => 1,
        ]);
        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Karyawan berhasil ditambahkan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('admin/pengaturan/struktur');
    }

    public function strukturEdit()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->update('karyawan', [
            'id_bagian' => $this->input->post('id_bagian'),
            'id_subag' => $this->input->post('id_subag'),
            'id_jabatan' => $this->input->post('id_jabatan'),
            'nama' => $this->input->post('nama'),
            'alamat' => $this->input->post('alamat'),
            'agama' => $this->input->post('agama'),
            'status_pegawai' => $this->input->post('status_pegawai'),
            'nik' => $this->input->post('nik'),
            'no_hp' => $this->input->post('no_hp'),
            'jenkel' => $this->input->post('jenkel'),
            'tmp_lahir' => $this->input->post('tmp_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
        ]);
        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data karyawan berhasil diupdate
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('admin/pengaturan/struktur');
    }

    public function strukturNonaktifkan($id)
    {
        $this->db->where('id', $id);
        $this->db->update('karyawan', ['aktif' => 0]);
        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Karyawan dinonaktifkan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('admin/pengaturan/struktur');
    }

    public function strukturAktifkan($id)
    {
        $this->db->where('id', $id);
        $this->db->update('karyawan', ['aktif' => 1]);
        $this->session->set_flashdata('info', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Karyawan diaktifkan kembali
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        redirect('admin/pengaturan/struktur');
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
