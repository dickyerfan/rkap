<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluasi_upk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_evaluasi_upk');
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
        $data['plgBaru'] = $this->Model_evaluasi_upk->getPlgBaruUpk($dataUpk, $dataTahun);
        $data['airTerjual'] = $this->Model_evaluasi_upk->getAirTerjualUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['pendapatanAir'] = $this->Model_evaluasi_upk->getPendapatanAirUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['lembarAir'] = $this->Model_evaluasi_upk->getLembarAirUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['target'] = $this->Model_evaluasi_upk->getTargetUpk($dataUpk, $dataTahun);
        $data['usulanAdmin'] = $this->Model_evaluasi_upk->getUsulanAdminUpk($dataUpk, $dataTahun);
        $data['usulanTeknik'] = $this->Model_evaluasi_upk->getUsulanTeknikUpk($dataUpk, $dataTahun);
        // $data['statusEvaluasiUpk'] = $this->Model_evaluasi_upk->getStatusUpdate('evaluasi_upk');
        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/evaluasi_upk/view_evaluasi_upk', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $dataUpk = $this->input->post('bagian_upk');
        $dataTahun = $this->input->post('tahun_rkap');
        $data['namaUpk'] = $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['plgBaru'] = $this->Model_evaluasi_upk->getPlgBaruUpk($dataUpk, $dataTahun);
        $data['airTerjual'] = $this->Model_evaluasi_upk->getAirTerjualUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['pendapatanAir'] = $this->Model_evaluasi_upk->getPendapatanAirUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['lembarAir'] = $this->Model_evaluasi_upk->getLembarAirUpk($dataUpk, $dataTahun); // ini untuk perhitungan pola konsumsi dan tarif rata2
        $data['target'] = $this->Model_evaluasi_upk->getTargetUpk($dataUpk, $dataTahun);
        $data['usulanAdmin'] = $this->Model_evaluasi_upk->getUsulanAdminUpk($dataUpk, $dataTahun);
        $data['usulanTeknik'] = $this->Model_evaluasi_upk->getUsulanTeknikUpk($dataUpk, $dataTahun);
        $data['title'] = 'EVALUASI PENCAPAIAN TAHUN';


        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Evaluasi Upk-{$dataUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/evaluasi_upk/laporan_pdf', $data);
    }

    // public function uploadData($uploadType, $title)
    // {
    //     $data['title'] = $title;

    //     $statusUpload = $this->Model_evaluasi_upk->getStatusUpload('evaluasi_upk');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Maaf,</strong> data sudah tidak bisa di input.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //             </button>
    //         </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->form_validation->set_rules('rkap', 'RKAP', 'required|trim|numeric');
    //         $this->form_validation->set_rules('realisasi', 'Realisasi', 'required|trim|numeric');
    //         $this->form_validation->set_message('required', '%s masih kosong');
    //         $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //         if ($this->form_validation->run() == false) {
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/evaluasi_upk/' . $uploadType, $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             $data['tambah'] = $this->Model_evaluasi_upk->$uploadType();
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Evaluasi UPK berhasil di simpan
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //             );
    //             redirect('rkap/evaluasi_upk');
    //         }
    //     }
    // }

    // public function upload_plgBaru()
    // {
    //     $this->uploadData('upload_plgBaru', 'Input Penambahan Pelanggan Baru');
    // }

    // public function upload_plgAktif()
    // {
    //     $this->uploadData('upload_plgAktif', 'Input Jumlah Pelanggan Aktif');
    // }

    // public function upload_jmlRek()
    // {
    //     $this->uploadData('upload_jmlRek', 'Input Jumlah Lembar Yg Direkeningkan');
    // }
    // public function upload_airTerjual()
    // {
    //     $this->uploadData('upload_airTerjual', 'Input Air terjual');
    // }
    // public function upload_pendapatanAir()
    // {
    //     $this->uploadData('upload_pendapatanAir', 'Input Pendapatan Air');
    // }




    // public function edit_evaluasi_upk($id_evaluasi_upk)
    // {
    //     $data['title'] = 'update Evaluasi UPK';
    //     $statusUpdate = $this->Model_evaluasi_upk->getStatusUpdate('evaluasi_upk');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di update.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $data['evaluasi_upk'] = $this->Model_evaluasi_upk->getIdEvaluasiUpk($id_evaluasi_upk);
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar');
    //         $this->load->view('rkap/evaluasi_upk/edit_evaluasi_upk', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     }
    // }

    // public function update_evaluasi_upk()
    // {
    //     $this->Model_evaluasi_upk->update_evaluasi_upk();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Evaluasi UPK berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     }
    // }

    // // Awal Target Pencapaian
    // public function upload_target()
    // {
    //     $data['title'] = 'Penjelasan pendapatan tidak mencapai target tahun';
    //     $statusUpload = $this->Model_evaluasi_upk->getStatusUpload('target_pencapaian');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di input.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->form_validation->set_rules('uraian_target', 'Penjelasan Pencapaian', 'required|trim');
    //         $this->form_validation->set_message('required', '%s masih kosong');

    //         if ($this->form_validation->run() == false) {
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/evaluasi_upk/upload_target', $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             $data['tambah'] = $this->Model_evaluasi_upk->upload_target();
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data Target Pencapaian berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/evaluasi_upk');
    //         }
    //     }
    // }

    // public function edit_target_sr($id_target)
    // {
    //     $data['title'] = 'update Target Pencapaian';
    //     $statusUpdate = $this->Model_evaluasi_upk->getStatusUpdate('target_pencapaian');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di update.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $data['targetSr'] = $this->Model_evaluasi_upk->getIdTarget($id_target);
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar');
    //         $this->load->view('rkap/evaluasi_upk/edit_target_sr', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     }
    // }

    // public function update_target_sr()
    // {
    //     $this->Model_evaluasi_upk->updateTargetSr();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Target Pencapaian berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     }
    // }
    // // Akhir Target Pencapaian

    // // awal Usulan Admin
    // public function upload_usulanAdmin()
    // {
    //     $data['title'] = 'Usulan program dalam rangka peningkatan pendapatan tahun';
    //     $data['subtitle'] = 'Bidang Administrasi';
    //     $statusUpload = $this->Model_evaluasi_upk->getStatusUpload('usulan_admin');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di input.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->form_validation->set_rules('usulan_admin', 'Usulan Admin', 'required|trim');
    //         $this->form_validation->set_message('required', '%s masih kosong');

    //         if ($this->form_validation->run() == false) {
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/evaluasi_upk/upload_usulanAdmin', $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             $data['tambah'] = $this->Model_evaluasi_upk->upload_usulanAdmin();
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data RKAP berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/evaluasi_upk');
    //         }
    //     }
    // }

    // public function edit_usulan_admin($id_usulanAdmin)
    // {
    //     $data['title'] = 'update Usulan Admin';
    //     $statusUpdate = $this->Model_evaluasi_upk->getStatusUpdate('usulan_admin');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di update.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $data['usulanAdmin'] = $this->Model_evaluasi_upk->getIdUsulanAdmin($id_usulanAdmin);
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar');
    //         $this->load->view('rkap/evaluasi_upk/edit_usulan_admin', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     }
    // }

    // public function update_usulan_admin()
    // {
    //     $this->Model_evaluasi_upk->updateUsulanAdmin();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Usulan Administrasi berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     }
    // }
    // // Akhir Usulan Admin

    // // Awal Usulan teknik
    // public function upload_usulanTeknik()
    // {
    //     $data['title'] = 'Usulan program dalam rangka peningkatan pendapatan tahun';
    //     $data['subtitle'] = 'Bidang Teknik';
    //     $statusUpload = $this->Model_evaluasi_upk->getStatusUpload('usulan_teknik');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di input.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->form_validation->set_rules('usulan_teknik', 'Usulan Teknik', 'required|trim');
    //         $this->form_validation->set_message('required', '%s masih kosong');

    //         if ($this->form_validation->run() == false) {
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/evaluasi_upk/upload_usulanTeknik', $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             $data['tambah'] = $this->Model_evaluasi_upk->upload_usulanTeknik();
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data RKAP berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/evaluasi_upk');
    //         }
    //     }
    // }

    // public function edit_usulan_teknik($id_usulanTeknik)
    // {
    //     $data['title'] = 'update Usulan Teknik';
    //     $statusUpdate = $this->Model_evaluasi_upk->getStatusUpdate('usulan_teknik');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di update.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $data['usulanTeknik'] = $this->Model_evaluasi_upk->getIdUsulanTeknik($id_usulanTeknik);
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar');
    //         $this->load->view('rkap/evaluasi_upk/edit_usulan_teknik', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     }
    // }

    // public function update_usulan_teknik()
    // {
    //     $this->Model_evaluasi_upk->updateUsulanTeknik();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Usulan Teknik berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/evaluasi_upk');
    //     }
    // }
    // // Akhir Usulan Teknik
}
