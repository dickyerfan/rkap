<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_inves extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_inves');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $data['tampil'] = $this->Model_usulan_inves->getData();

        $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_investasi/view_usulan_investasi', $data);
        $this->load->view('templates/pengguna/footer');
    }

    // Awal Usulan Investasi
    public function upload()
    {

        $statusUpload = $this->Model_usulan_inves->getStatusUpload('usulan_investasi');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di input.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_inves');
        } else {

            $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
            $this->form_validation->set_rules('nama_perkiraan', 'Nama Perkiraan', 'required|trim');
            $this->form_validation->set_rules('latar_belakang', 'Latar Belakang', 'required|trim');
            $this->form_validation->set_rules('solusi', 'Solusi', 'required|trim');
            $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
            $this->form_validation->set_rules('biaya', 'Biaya', 'trim');
            $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Usulan Investasi';
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/usulan_investasi/upload_usulan_investasi', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                // Cek apakah ada file yang diupload
                if (!empty($_FILES['foto_ket']['name'])) {
                    // Lakukan proses upload file
                    $config['upload_path']   = './uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size']      = 1000;
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('foto_ket')) {
                        $data_upload = $this->upload->data();
                        $data['foto_ket'] = $data_upload['file_name'];
                    } else {
                        // Jika proses upload gagal
                        $error_msg = $this->upload->display_errors();
                        $this->session->set_flashdata('info', $error_msg);
                        redirect('rkap/usulan_inves');
                    }
                }
                // Isi data selain file yang diupload
                $data['tahun_rkap'] = (int) $this->input->post('tahun_rkap', true);
                $data['no_perkiraan'] = $this->input->post('no_perkiraan', true);
                $data['nama_perkiraan'] = $this->input->post('nama_perkiraan', true);
                $data['latar_belakang'] = $this->input->post('latar_belakang', true);
                $data['solusi'] = $this->input->post('solusi', true);
                $data['volume'] = (int) $this->input->post('volume', true);
                $data['satuan'] = $this->input->post('satuan', true);
                $data['biaya'] = (int) $this->input->post('biaya', true);
                $data['ket'] = $this->input->post('ket', true);
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('usulan_investasi', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan Investasi berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/usulan_inves');
            }
        }
    }

    public function edit_usulan_investasi($id_usulanInvestasi)
    {
        $data['title'] = 'Update Usulan Investasi';
        $statusUpdate = $this->Model_usulan_inves->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0 && $this->session->userdata('level') == 'Pengguna') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_inves');
        } else {
            $data['usulan_investasi'] = $this->Model_usulan_inves->getUsulanInves($id_usulanInvestasi);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/usulan_investasi/edit_usulan_investasi', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    // public function update()
    // {
    //     $this->Model_usulan_inves->updateData();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/usulan_inves');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data RKAP berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/usulan_inves');
    //     }
    // }

    public function update()
    {
        $this->Model_usulan_inves->updateData();
        $updated_rows = $this->db->affected_rows();

        if ($updated_rows <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> tidak ada perubahan data
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('rkap/usulan_inves');
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['foto_ket']['name'])) {
                // Lakukan proses upload file
                $config['upload_path']   = './uploads/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 1000;
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('foto_ket')) {
                    // Mendapatkan nama file lama dari database
                    $usulanInvestasi = $this->Model_usulan_inves->getUsulanInves($this->input->post('id_usulanInvestasi'));
                    $namaFileLama = $usulanInvestasi->foto_ket;

                    // Lakukan proses upload file baru
                    $data_upload = $this->upload->data();
                    $data['foto_ket'] = $data_upload['file_name'];
                    $data['id_usulanInvestasi'] = $this->input->post('id_usulanInvestasi');
                    $this->Model_usulan_inves->updateFoto($data);


                    // Hapus file lama dari folder "uploads"
                    if ($namaFileLama) {
                        $fileLamaPath = './uploads/' . $namaFileLama;
                        if (file_exists($fileLamaPath)) {
                            unlink($fileLamaPath);
                        }
                    }
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('rkap/usulan_inves');
                }
            }

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data RKAP berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('rkap/usulan_inves');
        }
    }

    // Akhir Usulan Investasi

    public function hapus_usulan_investasi($id_usulanInvestasi)
    {
        $statusUpdate = $this->Model_usulan_inves->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_inves');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $query = $this->db->get('usulan_investasi');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $this->db->delete('usulan_investasi');

            redirect('rkap/usulan_inves');
        }
    }

    public function export_pdf()
    {

        $data['tahun'] = $this->Model_usulan_inves->getTahun();
        $data['tampil'] = $this->Model_usulan_inves->getData();
        $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';

        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahun = date('Y');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Usulan Investasi-{$upk_bagian}-{$tahun}.pdf";
        $this->pdf->generate('rkap/usulan_investasi/laporan_pdf', $data);
    }
}
