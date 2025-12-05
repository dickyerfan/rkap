<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_pendukung extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_data_pendukung');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    // jasa pemeliharaan & jasa administrasi
    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['title'] = 'Data Jasa Pemeliharaan & Jasa Administrasi';
        $data['jasa_tambahan'] = $this->Model_data_pendukung->get_jasa_tambahan($tahun);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/data_pendukung/view_data_pendukung', $data);
        $this->load->view('templates/footer');
    }

    // public function tambah()
    // {
    //     $data['title'] = 'Input Jasa Pemeliharaan & Jasa Administrasi';
    //     $data['upk']   = $this->db->get('rkap_nama_upk')->result();
    //     $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/lr/data_pendukung/upload_jasa_tambahan', $data);
    //     $this->load->view('templates/footer');
    // }

    public function duplicate_next_year()
    {
        $tahun_asal   = $this->input->get('tahun_asal');
        $tahun_tujuan = $tahun_asal + 1;

        $result = $this->Model_data_pendukung->duplicate_jasa_tambahan($tahun_asal, $tahun_tujuan);

        if ($result === true) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data jasa tambahan tahun ' . $tahun_asal . ' berhasil disalin ke tahun ' . $tahun_tujuan . '.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } elseif ($result === "exist") {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Data jasa tambahan tahun ' . $tahun_tujuan . ' sudah ada. Tidak Bisa Duplikasi Data.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Tidak ada data di tahun ' . $tahun_asal . ' untuk disalin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }
        redirect('lembar_kerja/lr/data_pendukung?tahun_rkap=' . $tahun_tujuan);
    }

    public function edit_jasa_tambahan($id = null)
    {
        $row = $this->db->get_where('rkap_jasa_tambahan', ['id' => $id])->row();

        if (!$row) {
            show_404();
        }

        $tahun_sekarang = date('Y');

        // Cegah edit jika tahun data == tahun sekarang
        if ($row->tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data jasa tambahan tahun ' . $row->tahun . ' tidak boleh diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung?tahun_rkap=' . $row->tahun);
        }

        $data['row'] = $row;

        // untuk select option
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['list_jp']  = $this->db->get('rkap_jenis_plgn')->result();

        $data['title'] = 'Edit Jasa Tambahan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/data_pendukung/edit_jasa_tambahan', $data);
        $this->load->view('templates/footer');
    }

    // method proses update
    public function update_jasa_tambahan()
    {
        $id = $this->input->post('id');

        $tahun = $this->input->post('tahun');
        $tahun_sekarang = date('Y');

        // Cegah update jika tahun = tahun berjalan
        if ($tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data tahun ' . $tahun . ' tidak bisa diupdate.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung?tahun_rkap=' . $tahun);
        }

        $data = [
            'jasa_admin'        => $this->input->post('jasa_admin'),
            'jasa_pemeliharaan' => $this->input->post('jasa_pemeliharaan'),
        ];

        $this->db->where('id', $id);
        $this->db->update('rkap_jasa_tambahan', $data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil,</strong> Data jasa tambahan berhasil diupdate.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );

        redirect('lembar_kerja/lr/data_pendukung?tahun_rkap=' . $this->input->post('tahun'));
    }

    // akhir jasa pemeliharaan & jasa administrasi

    public function pola_konsumsi_tarif()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['title'] = 'Data Pola Konsumsi';
        $data['title2'] = 'Data Tarif Rata-rata';
        $data['pola_konsumsi'] = $this->Model_data_pendukung->get_pola_konsumsi($tahun);
        $data['tarif_rata']   = $this->Model_data_pendukung->get_tarif_rata($tahun);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/data_pendukung/view_pola_konsumsi_tarif', $data);
        $this->load->view('templates/footer');
    }

    public function duplicate_next_year_pola()
    {
        $tahun_asal   = $this->input->get('tahun_asal');
        $tahun_tujuan = $tahun_asal + 1;

        $result = $this->Model_data_pendukung->duplicate_pola($tahun_asal, $tahun_tujuan);

        if ($result === true) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data pola konsumsi tahun ' . $tahun_asal . ' berhasil disalin ke tahun ' . $tahun_tujuan . '.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } elseif ($result === "exist") {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Data pola konsumsi tahun ' . $tahun_tujuan . ' sudah ada. Tidak Bisa Duplikasi Data.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Tidak ada data di tahun ' . $tahun_asal . ' untuk disalin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }
        redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $tahun_tujuan);
    }

    public function edit_pola($id = null)
    {
        $row = $this->db->get_where('rkap_pola_konsumsi', ['id' => $id])->row();

        if (!$row) {
            show_404();
        }

        $tahun_sekarang = date('Y');

        // Cegah edit jika tahun data == tahun sekarang
        if ($row->tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data Pola Konsumsi tahun ' . $row->tahun . ' tidak boleh diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $row->tahun);
        }

        $data['row'] = $row;

        // untuk select option
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['list_jp']  = $this->db->get('rkap_jenis_plgn')->result();

        $data['title'] = 'Edit Jasa Tambahan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/data_pendukung/edit_pola_konsumsi', $data);
        $this->load->view('templates/footer');
    }

    public function update_pola()
    {
        $id = $this->input->post('id');

        $tahun = $this->input->post('tahun');
        $tahun_sekarang = date('Y');

        // Cegah update jika tahun = tahun berjalan
        if ($tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data tahun ' . $tahun . ' tidak bisa diupdate.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $tahun);
        }

        $data = [
            'konsumsi_rata'        => $this->input->post('konsumsi_rata'),
        ];

        $this->db->where('id', $id);
        $this->db->update('rkap_pola_konsumsi', $data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil,</strong> Data Pola Konsumsi berhasil diupdate.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );

        redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $this->input->post('tahun'));
    }

    public function duplicate_next_year_tarif()
    {
        $tahun_asal   = $this->input->get('tahun_asal');
        $tahun_tujuan = $tahun_asal + 1;

        $result = $this->Model_data_pendukung->duplicate_tarif($tahun_asal, $tahun_tujuan);

        if ($result === true) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data tarif rata-rata tahun ' . $tahun_asal . ' berhasil disalin ke tahun ' . $tahun_tujuan . '.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } elseif ($result === "exist") {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Data tarif rata-rata tahun ' . $tahun_tujuan . ' sudah ada. Tidak Bisa Duplikasi Data.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Tidak ada data di tahun ' . $tahun_asal . ' untuk disalin.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }
        redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $tahun_tujuan);
    }

    public function edit_tarif($id = null)
    {
        $row = $this->db->get_where('rkap_tarif_rata', ['id' => $id])->row();

        if (!$row) {
            show_404();
        }

        $tahun_sekarang = date('Y');

        // Cegah edit jika tahun data == tahun sekarang
        if ($row->tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data Tarif Rata-rata tahun ' . $row->tahun . ' tidak boleh diedit.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $row->tahun);
        }

        $data['row'] = $row;

        // untuk select option
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['list_jp']  = $this->db->get('rkap_jenis_plgn')->result();

        $data['title'] = 'Edit Jasa Tambahan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/data_pendukung/edit_tarif_rata', $data);
        $this->load->view('templates/footer');
    }

    public function update_tarif()
    {
        $id = $this->input->post('id');

        $tahun = $this->input->post('tahun');
        $tahun_sekarang = date('Y');

        // Cegah update jika tahun = tahun berjalan
        if ($tahun == $tahun_sekarang) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Data tahun ' . $tahun . ' tidak bisa diupdate.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $tahun);
        }

        $data = [
            'tarif_rata'        => $this->input->post('tarif_rata'),
        ];

        $this->db->where('id', $id);
        $this->db->update('rkap_tarif_rata', $data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil,</strong> Data Tarif Rata-rata berhasil diupdate.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );

        redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif?tahun_rkap=' . $this->input->post('tahun'));
    }

    // public function tambah_pola()
    // {
    //     $data['title'] = 'Input Pola Konsumsi';
    //     $data['upk']   = $this->db->get('rkap_nama_upk')->result();
    //     $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/lr/data_pendukung/upload_pola_konsumsi', $data);
    //     $this->load->view('templates/footer');
    // }
    // public function tambah_tarif()
    // {
    //     $data['title'] = 'Input Tarif Rata-rata';
    //     $data['upk']   = $this->db->get('rkap_nama_upk')->result();
    //     $data['jenis'] = $this->db->get('rkap_jenis_plgn')->result();

    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/lr/data_pendukung/upload_tarif_rata', $data);
    //     $this->load->view('templates/footer');
    // }

    // public function save_tarif_rata()
    // {
    //     $data = [
    //         'id_upk'     => $this->input->post('id_upk'),
    //         'id_jp'      => $this->input->post('id_jp'),
    //         'tahun'      => $this->input->post('tahun'),
    //         'tarif_rata' => $this->input->post('tarif_rata')
    //     ];

    //     $this->Model_data_pendukung->insert_tarif_rata($data);
    //     $this->session->set_flashdata('info', 'Data Tarif Rata-rata berhasil disimpan');
    //     redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif');
    // }

    // public function save_pola_konsumsi()
    // {
    //     $data = [
    //         'id_upk'        => $this->input->post('id_upk'),
    //         'id_jp'         => $this->input->post('id_jp'),
    //         'tahun'         => $this->input->post('tahun'),
    //         'konsumsi_rata' => $this->input->post('konsumsi_rata')
    //     ];

    //     $this->Model_data_pendukung->insert_pola_konsumsi($data);
    //     $this->session->set_flashdata('info', 'Data Pola Konsumsi berhasil disimpan');
    //     redirect('lembar_kerja/lr/data_pendukung/pola_konsumsi_tarif');
    // }

    // public function save_jasa_tambahan()
    // {
    //     $data = [
    //         'id_upk'        => $this->input->post('id_upk'),
    //         'id_jp'         => $this->input->post('id_jp'),
    //         'tahun'         => $this->input->post('tahun'),
    //         'jasa_admin'    => $this->input->post('jasa_admin'),
    //         'jasa_pemeliharaan' => $this->input->post('jasa_pemeliharaan')
    //     ];

    //     $this->Model_data_pendukung->insert_jasa_tambahan($data);
    //     $this->session->set_flashdata('info', 'Data Jasa Tambahan berhasil disimpan');
    //     redirect('lembar_kerja/lr/data_pendukung');
    // }
}
