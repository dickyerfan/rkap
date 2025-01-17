<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Potensi_sr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_potensi_sr');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $dataUpk = $this->input->post('bagian_upk');
        $dataTahun = $this->input->post('tahun_rkap');
        $data['namaUpk'] = $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['tampil'] = $this->Model_potensi_sr->getDataUpk($dataUpk, $dataTahun);
        $data['keterangan'] = $this->Model_potensi_sr->getKeteranganUpk($dataUpk, $dataTahun);
        $data['airBaku'] = $this->Model_potensi_sr->getAirBakuUpk($dataUpk, $dataTahun);
        $data['totalSr'] = $this->Model_potensi_sr->getTotalSRUpk($dataUpk);

        $data['title'] = 'ESTIMASI KEBUTUHAN AIR BAKU DAN POTENSI PELANGGAN';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/rkap/view_potensi_sr', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $dataUpk = $this->input->post('bagian_upk');
        $dataTahun = $this->input->post('tahun_rkap');
        $data['namaUpk'] = $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['tampil'] = $this->Model_potensi_sr->getDataUpk($dataUpk, $dataTahun);
        $data['keterangan'] = $this->Model_potensi_sr->getKeteranganUpk($dataUpk, $dataTahun);
        $data['airBaku'] = $this->Model_potensi_sr->getAirBakuUpk($dataUpk, $dataTahun);
        $data['totalSr'] = $this->Model_potensi_sr->getTotalSRUpk($dataUpk);

        $data['title'] = 'ESTIMASI KEBUTUHAN AIR BAKU DAN POTENSI PELANGGAN';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/rkap/view_potensi_sr', $data);
        $this->load->view('templates/footer');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Potensi SR-{$dataUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/potensi_sr/laporan_pdf', $data);
    }

    // Awal Potensi SR
    public function upload()
    {
        $data['title'] = 'Input Data Potensi SR Baru';
        $statusUpload = $this->Model_potensi_sr->getStatusUpload('potensi_sr');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {

            $this->form_validation->set_rules('kap_pro', 'Nama Pasien', 'trim');
            $this->form_validation->set_rules('kap_manf', 'Kapasitas Dimanfaatkan', 'required|trim|numeric');
            $this->form_validation->set_rules('jam_op', 'Jam Operasional', 'required|trim|numeric');
            $this->form_validation->set_rules('tk_bocor', 'Tingkat Kebocoran', 'required|trim');
            $this->form_validation->set_rules('plg_aktif', 'Pelanggan Aktif', 'required|trim|numeric');
            $this->form_validation->set_rules('tambah_sr', 'Tambah SR', 'required|trim|numeric');
            $this->form_validation->set_rules('pola_kon', 'Pola Konsumsi', 'required|trim|numeric');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/upload_potensi_sr', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_potensi_sr->uploadData();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data RKAP berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/Potensi_sr');
            }
        }
    }

    public function editPotensiSr($upk_bagian)
    {
        $data['title'] = 'Update Data Potensi SR Baru';
        $statusUpdate = $this->Model_potensi_sr->getStatusUpdate('potensi_sr');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $data['potensiSr'] = $this->Model_potensi_sr->getUpkBagian($upk_bagian);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/potensi_sr/edit_potensi_sr', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->Model_potensi_sr->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        }
    }
    // Akhir Potensi SR


    // Awal Keterangan Potensi SR
    public function upload_ket()
    {
        $data['title'] = 'Input Data Pemetaan SR Baru';
        $statusUpload = $this->Model_potensi_sr->getStatusUpload('ket_potensi_sr');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $this->form_validation->set_rules('nama_wil', 'Nama Wilayah', 'required|trim');
            $this->form_validation->set_rules('jumlah_sr', 'Jumlah SR', 'required|trim|numeric');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/upload_ket_potensi_sr', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_potensi_sr->uploadData_ket();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('rkap/Potensi_sr');
            }
        }
    }

    public function edit_ket_potensi($id_ket_potensi)
    {
        $data['title'] = 'update Data Potensi SR Baru';
        $statusUpdate = $this->Model_potensi_sr->getStatusUpdate('ket_potensi_sr');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $data['ketPotensi'] = $this->Model_potensi_sr->getIdKetPotensi($id_ket_potensi);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/potensi_sr/edit_ket_potensi', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_ket_potensi()
    {
        $this->Model_potensi_sr->update_ket_potensi();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pemetaan SR berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        }
    }

    // Akhir Keterangan Potensi SR

    // Awal Air Baku
    public function upload_tbh_airbaku()
    {
        $data['title'] = 'Input Penambahan Air Baku';
        $statusAirBaku = $this->Model_potensi_sr->getStatusUpload('tambah_air_baku');
        if ($statusAirBaku !== null && $statusAirBaku->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {

            $this->form_validation->set_rules('uraian', 'Penambahan Air Baku', 'required|trim');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/upload_tbh_airbaku', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_potensi_sr->uploadData_tbh_airbaku();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('rkap/Potensi_sr');
            }
        }
    }

    public function edit_air_baku($id_tambah_air_baku)
    {
        $data['title'] = 'update Penambahan Air Baku';
        $statusUpdate = $this->Model_potensi_sr->getStatusUpdate('tambah_air_baku');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $data['airBaku'] = $this->Model_potensi_sr->getIdAirBaku($id_tambah_air_baku);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/potensi_sr/edit_air_baku', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_air_baku()
    {
        $this->Model_potensi_sr->update_air_baku();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Penambahan Air Baku berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/Potensi_sr');
        }
    }
    // Akhir Air Baku

}
