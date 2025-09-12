<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_Umum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_umum');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $bagian_upk = $this->input->get('bagian_upk');
        $tahun_rkap = $this->input->get('tahun_rkap');
        $kategori = $this->input->get('kategori');

        // Default tahun jika kosong
        if (!$tahun_rkap) {
            $tahun_rkap = date('Y');
        }

        $data['tampil'] = $this->Model_usulan_umum->getFiltered($bagian_upk, $tahun_rkap, $kategori);
        $data['bagian_upk'] = $bagian_upk;
        $data['tahun'] = $tahun_rkap;
        $data['kategori'] = $kategori;
        $data['title'] = 'USULAN PERMINTAAN BAGIAN UMUM (RKAP) TAHUN ';
        $data['namaUpk'] = $bagian_upk ? $bagian_upk : 'SEMUA';
        $data['kategori'] = $kategori ? $kategori : 'SEMUA';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_umum/view_usulan_umum', $data);
        $this->load->view('templates/pengguna/footer');
    }

    // Awal Usulan umum
    // public function upload()
    // {
    //     $data['upk'] = $this->Model_usulan_umum->getUpk();
    //     $statusUpload = $this->Model_usulan_umum->getStatusUpload('usulan_umum');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di input.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/usulan_barang');
    //     } else {

    //         $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
    //         $this->form_validation->set_rules('nama_perkiraan', 'Nama Barang', 'required|trim');
    //         $this->form_validation->set_rules('latar_belakang', 'Latar Belakang', 'required|trim');
    //         $this->form_validation->set_rules('solusi', 'Solusi', 'required|trim');
    //         $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric');
    //         $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
    //         $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
    //         $this->form_validation->set_rules('bagian_upk', 'Nama UPK', 'required|trim');
    //         $this->form_validation->set_rules('biaya', 'Biaya', 'trim|numeric');
    //         $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
    //         $this->form_validation->set_message('required', '%s masih kosong');
    //         $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'Input Usulan Permintaan Bagian Umum';
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/usulan_umum/upload_usulan_umum', $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             // Cek apakah ada file yang diupload
    //             if (!empty($_FILES['foto_ket']['name'])) {
    //                 // Lakukan proses upload file
    //                 $config['upload_path']   = './uploads/';
    //                 $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //                 $config['max_size']      = 2000;
    //                 $this->load->library('upload', $config);
    //                 if ($this->upload->do_upload('foto_ket')) {
    //                     $data_upload = $this->upload->data();
    //                     $data['foto_ket'] = $data_upload['file_name'];
    //                 } else {
    //                     // Jika proses upload gagal
    //                     $error_msg = $this->upload->display_errors();
    //                     $this->session->set_flashdata('info', $error_msg);
    //                     redirect('rkap/usulan_umum');
    //                 }
    //             }
    //             // Isi data selain file yang diupload
    //             $data['tahun_rkap'] = (int) $this->input->post('tahun_rkap', true);
    //             $data['no_perkiraan'] = $this->input->post('no_perkiraan', true);
    //             $data['nama_perkiraan'] = $this->input->post('nama_perkiraan', true);
    //             $data['latar_belakang'] = $this->input->post('latar_belakang', true);
    //             $data['solusi'] = $this->input->post('solusi', true);
    //             $data['volume'] = (int) $this->input->post('volume', true);
    //             $data['satuan'] = $this->input->post('satuan', true);
    //             $data['biaya'] = (int) $this->input->post('biaya', true);
    //             $data['ket'] = $this->input->post('ket', true);
    //             $data['kategori'] = $this->input->post('kategori', true);
    //             $data['bagian_upk'] = $this->input->post('bagian_upk', true);
    //             $data['tgl_Upload'] = date('Y-m-d H:i:s');

    //             // Simpan data ke dalam database
    //             $this->db->insert('usulan_umum', $data);
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data Usulan barang berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/usulan_umum');
    //         }
    //     }
    // }

    public function upload()
    {
        // Data untuk view
        $data['upk'] = $this->Model_usulan_umum->getUpk();
        // Cek status upload
        $statusUpload = $this->Model_usulan_umum->getStatusUpload('usulan_umum');
        if ($statusUpload !== null && $statusUpload->status == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> data sudah tidak bisa di input.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('rkap/usulan_barang');
            return;
        }

        // Rules form validation
        $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
        $this->form_validation->set_rules('nama_perkiraan', 'Nama Barang', 'required|trim');
        // $this->form_validation->set_rules('latar_belakang', 'Latar Belakang', 'required|trim');
        // $this->form_validation->set_rules('solusi', 'Solusi', 'required|trim');
        $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('bagian_upk', 'Nama UPK', 'required|trim');
        $this->form_validation->set_rules('biaya', 'Biaya', 'trim|numeric');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        // Jika form tidak valid
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Input Usulan Permintaan Bagian Umum';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/usulan_umum/upload_usulan_umum', $data);
            $this->load->view('templates/pengguna/footer');
            return;
        }

        // Data yang akan diinsert
        $insertData = [
            'tahun_rkap'     => (int) $this->input->post('tahun_rkap', true),
            'no_perkiraan'   => $this->input->post('no_perkiraan', true),
            'nama_perkiraan' => $this->input->post('nama_perkiraan', true),
            'latar_belakang' => $this->input->post('latar_belakang', true),
            'solusi'         => $this->input->post('solusi', true),
            'volume'         => (int) $this->input->post('volume', true),
            'satuan'         => $this->input->post('satuan', true),
            'biaya'          => (int) $this->input->post('biaya', true),
            'ket'            => $this->input->post('ket', true),
            'kategori'       => $this->input->post('kategori', true),
            'bagian_upk'     => $this->input->post('bagian_upk', true),
            'tgl_Upload'     => date('Y-m-d H:i:s')
        ];

        // Cek jika ada file yang diupload
        if (!empty($_FILES['foto_ket']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 2000; // 2MB
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_ket')) {
                $data_upload = $this->upload->data();
                $insertData['foto_ket'] = $data_upload['file_name'];
            } else {
                // Jika upload gagal
                $this->session->set_flashdata('info', $this->upload->display_errors());
                redirect('rkap/usulan_umum');
                return;
            }
        }

        // Simpan data ke database
        $this->db->insert('usulan_umum', $insertData);

        // Notifikasi sukses
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> Data Usulan barang berhasil disimpan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );

        redirect('rkap/usulan_umum');
    }


    public function edit_usulan_umum($id_usulanUmum)
    {
        $data['title'] = 'Update Usulan umum';
        $statusUpdate = $this->Model_usulan_umum->getStatusUpdate('usulan_umum');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_umum');
        } else {
            $data['usulan_umum'] = $this->Model_usulan_umum->getUsulanUmum($id_usulanUmum);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/usulan_umum/edit_usulan_umum', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->Model_usulan_umum->updateData();
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
            redirect('rkap/usulan_umum');
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
                    $usulanUmum = $this->Model_usulan_umum->getUsulanUmum($this->input->post('id_usulanUmum'));
                    $namaFileLama = $usulanUmum->foto_ket;

                    // Lakukan proses upload file baru
                    $data_upload = $this->upload->data();
                    $data['foto_ket'] = $data_upload['file_name'];
                    $data['id_usulanUmum'] = $this->input->post('id_usulanUmum');
                    $this->Model_usulan_umum->updateFoto($data);


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
                    redirect('rkap/usulan_umum');
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
            redirect('rkap/usulan_umum');
        }
    }

    // Akhir Usulan Umum

    public function hapus_usulan_umum($id_usulanUmum)
    {
        $statusUpdate = $this->Model_usulan_umum->getStatusUpdate('usulan_umum');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_umum');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanUmum', $id_usulanUmum);
            $query = $this->db->get('usulan_umum');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanUmum', $id_usulanUmum);
            $this->db->delete('usulan_umum');

            redirect('rkap/usulan_umum');
        }
    }

    public function export_pdf()
    {
        $data['tahun'] = $this->Model_usulan_umum->getTahun();
        $data['tampil'] = $this->Model_usulan_umum->getData();
        $data['title'] = 'USULAN PERMINTAAN BAGIAN UMUM (RKAP) TAHUN ';

        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahun = date('Y');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Usulan Umum-{$upk_bagian}-{$tahun}.pdf";
        $this->pdf->generate('rkap/usulan_umum/laporan_pdf', $data);
    }
}
