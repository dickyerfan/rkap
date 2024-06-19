<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluasi_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_evaluasi_amdk');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';
        $data['tenaga_kerja'] = $this->Model_evaluasi_amdk->getTenagaKerja();
        $data['piutang_usaha'] = $this->Model_evaluasi_amdk->getPiutangUsaha();
        $data['pendapatan_usaha'] = $this->Model_evaluasi_amdk->getPendapatanUsaha();
        $data['statusEvaluasiAmdk'] = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
        $data['target'] = $this->Model_evaluasi_amdk->getTarget();
        $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getUsulanAdmin();
        $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getUsulanTeknik();

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/evaluasi_amdk/view_evaluasi_amdk', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function uploadData($uploadType, $title)
    {
        $data['title'] = $title;

        $statusUpload = $this->Model_evaluasi_amdk->getStatusUpload('evaluasi_amdk');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> data sudah tidak bisa di input.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->form_validation->set_rules('uraian_evaluasi', 'Uraian Evaluasi', 'required|trim|is_unique[evaluasi_amdk.uraian_evaluasi]');
            $this->form_validation->set_rules('rkap', 'RKAP', 'required|trim|numeric');
            $this->form_validation->set_rules('realisasi', 'Realisasi', 'required|trim|numeric');
            $this->form_validation->set_message('is_unique', '%s sudah tersedia');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_amdk/' . $uploadType, $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_evaluasi_amdk->$uploadType();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('rkap/evaluasi_amdk');
            }
        }
    }

    public function upload_tenaga_kerja()
    {
        $this->uploadData('upload_tenaga_kerja', 'Input Tenaga Kerja');
    }

    public function upload_piutang_usaha()
    {
        $this->uploadData('upload_piutang_usaha', 'Input Piutang Usaha');
    }
    public function upload_pendapatan_usaha()
    {
        $this->uploadData('upload_pendapatan_usaha', 'Input Pendapatan Usaha');
    }




    public function edit_evaluasi_amdk($id_evaluasi_amdk)
    {
        $data['title'] = 'update Evaluasi amdk';
        $statusUpdate = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0 && $this->session->userdata('level') == 'Pengguna') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $data['evaluasi_amdk'] = $this->Model_evaluasi_amdk->getIdEvaluasiAmdk($id_evaluasi_amdk);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_amdk/edit_evaluasi_amdk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_evaluasi_amdk()
    {
        $this->Model_evaluasi_amdk->update_evaluasi_amdk();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Evaluasi amdk berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        }
    }


    // Awal Target Pencapaian
    public function upload_target()
    {
        $data['title'] = 'Penjelasan pendapatan tidak mencapai target tahun';
        $statusUpload = $this->Model_evaluasi_amdk->getStatusUpload('target_pencapaian');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->form_validation->set_rules('uraian_target', 'Penjelasan Pencapaian', 'required|trim');
            $this->form_validation->set_message('required', '%s masih kosong');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_amdk/upload_target', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_evaluasi_amdk->upload_target();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Target Pencapaian berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/evaluasi_amdk');
            }
        }
    }

    public function edit_target_sr($id_target)
    {
        $data['title'] = 'update Target Pencapaian';
        $statusUpdate = $this->Model_evaluasi_amdk->getStatusUpdate('target_pencapaian');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $data['targetSr'] = $this->Model_evaluasi_amdk->getIdTarget($id_target);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_amdk/edit_target_sr', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_target_sr()
    {
        $this->Model_evaluasi_amdk->updateTargetSr();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Target Pencapaian berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        }
    }
    // Akhir Target Pencapaian

    // awal Usulan Admin
    public function upload_usulanAdmin()
    {
        $data['title'] = 'Usulan program dalam rangka peningkatan pendapatan tahun';
        $data['subtitle'] = 'Bidang Administrasi';
        $statusUpload = $this->Model_evaluasi_amdk->getStatusUpload('usulan_admin');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->form_validation->set_rules('usulan_admin', 'Usulan Admin', 'required|trim');
            $this->form_validation->set_message('required', '%s masih kosong');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_amdk/upload_usulanAdmin', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_evaluasi_amdk->upload_usulanAdmin();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan Administrasi berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/evaluasi_amdk');
            }
        }
    }

    public function edit_usulan_admin($id_usulanAdmin)
    {
        $data['title'] = 'update Usulan Admin';
        $statusUpdate = $this->Model_evaluasi_amdk->getStatusUpdate('usulan_admin');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getIdUsulanAdmin($id_usulanAdmin);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_amdk/edit_usulan_admin', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_usulan_admin()
    {
        $this->Model_evaluasi_amdk->updateUsulanAdmin();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Usulan Administrasi berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        }
    }
    // Akhir Usulan Admin

    // Awal Usulan teknik
    public function upload_usulanTeknik()
    {
        $data['title'] = 'Usulan program dalam rangka peningkatan pendapatan tahun';
        $data['subtitle'] = 'Bidang Teknik';
        $statusUpload = $this->Model_evaluasi_amdk->getStatusUpload('usulan_teknik');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->form_validation->set_rules('usulan_teknik', 'Usulan Teknik', 'required|trim');
            $this->form_validation->set_message('required', '%s masih kosong');

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/evaluasi_amdk/upload_usulanTeknik', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $data['tambah'] = $this->Model_evaluasi_amdk->upload_usulanTeknik();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan Teknik berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/evaluasi_amdk');
            }
        }
    }

    public function edit_usulan_teknik($id_usulanTeknik)
    {
        $data['title'] = 'update Usulan Teknik';
        $statusUpdate = $this->Model_evaluasi_amdk->getStatusUpdate('usulan_teknik');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getIdUsulanTeknik($id_usulanTeknik);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/evaluasi_amdk/edit_usulan_teknik', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update_usulan_teknik()
    {
        $this->Model_evaluasi_amdk->updateUsulanTeknik();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Usulan Teknik berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('rkap/evaluasi_amdk');
        }
    }
    // Akhir Usulan Teknik

    public function export_pdf()
    {

        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';
        $data['tahun'] = $this->Model_evaluasi_amdk->getTahun();
        $data['tenaga_kerja'] = $this->Model_evaluasi_amdk->getTenagaKerja();
        $data['piutang_usaha'] = $this->Model_evaluasi_amdk->getPiutangUsaha();
        $data['pendapatan_usaha'] = $this->Model_evaluasi_amdk->getPendapatanUsaha();
        $data['statusEvaluasiAmdk'] = $this->Model_evaluasi_amdk->getStatusUpdate('evaluasi_amdk');
        $data['target'] = $this->Model_evaluasi_amdk->getTarget();
        $data['usulanAdmin'] = $this->Model_evaluasi_amdk->getUsulanAdmin();
        $data['usulanTeknik'] = $this->Model_evaluasi_amdk->getUsulanTeknik();

        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahun = date('Y');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Potensi Sr-{$upk_bagian}-{$tahun}.pdf";
        $this->pdf->generate('rkap/evaluasi_amdk/laporan_pdf', $data);
    }
}
