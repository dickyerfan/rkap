<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_barang');
        $this->load->model('Model_rkap_barang');
        $this->load->model('Model_pengaturan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $data['tampil'] = $this->Model_usulan_barang->getData();

        $data['title'] = 'USULAN PERMINTAAN BARANG (RKAP) TAHUN ';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_barang/view_usulan_barang', $data);
        $this->load->view('templates/pengguna/footer');
    }

    // Awal Usulan barang
    public function upload()
    {
        // $statusUpload = $this->Model_usulan_barang->getStatusUpload('usulan_barang');
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
            redirect('rkap/usulan_barang');
        } else {

            $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
            $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|trim|numeric');
            $this->form_validation->set_rules('master_barang_id', 'Nama Barang', 'required|trim|numeric');
            $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric|greater_than[0]');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');
            $this->form_validation->set_message('greater_than', '%s harus lebih dari 0');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Usulan Permintaan Barang';
                // $data['kategori_barang'] = $this->Model_rkap_barang->getKategori();
                $bagian = $this->session->userdata('upk_bagian');
                $data['kategori_barang'] = $this->Model_usulan_barang->getKategoriByBagian($bagian);
                $data['master_barang'] = $this->Model_rkap_barang->getMasterBarang(date('Y'));
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/usulan_barang/upload_usulan_barang', $data);
                $this->load->view('templates/pengguna/footer');
            } else {
                $barang = $this->Model_rkap_barang->getMasterBarangTerpilih(
                    $this->input->post('master_barang_id', true),
                    date('Y'),
                    $this->input->post('kategori_id', true)
                );

                if (!$barang) {
                    $this->_setFlashError('Master barang tidak valid atau tidak tersedia untuk tahun ' . date('Y'));
                    redirect('rkap/usulan_barang/upload');
                }

                $upk_map = [
                    'Pusat' => '00',
                    'Bondowoso' => '01',
                    'Sukosari 1' => '02',
                    'Maesan' => '03',
                    'Tegalampel' => '04',
                    'Tapen' => '05',
                    'Prajekan' => '06',
                    'Tlogosari' => '07',
                    'Wringin' => '08',
                    'Curahdami' => '09',
                    'Tamanan' => '10',
                    'Tenggarang' => '11',
                    'Tamankrocok' => '12',
                    'Wonosari' => '13',
                    'Klabang' => '14',
                    'Sukosari 2' => '15',
                    'Amdk' => '16',
                    'Umum & Administrasi' => '17',
                    'Keuangan' => '18',
                    'Langganan' => '19',
                    'Perencanaan' => '20',
                    'Pemeliharaan' => '21',
                    'Satuan Pengawas Intern' => '22'
                ];

                $nama_pengguna = $this->session->userdata('nama_pengguna');
                $kode_upk = isset($upk_map[$nama_pengguna]) ? $upk_map[$nama_pengguna] : null;

                $kode_akun = $barang->kode_akun;

                if ($kode_upk) {
                    $data['no_perkiraan'] = $kode_akun . '.' . $kode_upk;
                } else {
                    $data['no_perkiraan'] = $kode_akun;
                }

                $data['tahun_rkap'] = date('Y');
                // $data['no_perkiraan'] = $barang->kode_akun;
                $data['nama_perkiraan'] = $barang->nama_barang;
                $data['latar_belakang'] = '';
                $data['solusi'] = '';
                $data['volume'] = (int) $this->input->post('volume', true);
                $data['satuan'] = $barang->satuan;
                $data['harga_satuan'] = (int) $barang->harga_satuan;
                $data['biaya'] = (int) $barang->harga_satuan * (int) $this->input->post('volume', true);
                $data['ket'] = '';
                $data['kategori'] = $barang->nama_kategori;
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['foto_ket'] = '';
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('usulan_barang', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan barang berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/usulan_barang');
            }
        }
    }

    public function upload_lain()
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
            redirect('rkap/usulan_barang');
        } else {

            $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
            $this->form_validation->set_rules('nama_perkiraan', 'Nama Pemeliharaan', 'required|trim');
            $this->form_validation->set_rules('volume', 'Volume', 'trim|numeric');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
            $this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'trim');
            $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
            $this->form_validation->set_message('required', '%s masih kosong');
            $this->form_validation->set_message('numeric', '%s harus berupa angka');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Input Usulan Barang Lainnya';
                $data['no_per'] = $this->Model_usulan_barang->getNoPerBarang();
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar');
                $this->load->view('templates/pengguna/sidebar');
                $this->load->view('rkap/usulan_barang/upload_usulan_lain', $data);
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
                        redirect('rkap/usulan_barang');
                    }
                }
                // Isi data selain file yang diupload
                $data['tahun_rkap'] = date('Y');
                $data['no_perkiraan'] = $this->input->post('no_perkiraan', true);
                $data['nama_perkiraan'] = $this->input->post('nama_perkiraan', true);
                $data['satuan'] = $this->input->post('satuan', true);
                $data['volume'] = (int) $this->input->post('volume', true);
                $data['harga_satuan'] = (int) $this->input->post('harga_satuan', true);
                $data['biaya'] = (int) $this->input->post('harga_satuan', true) * (int) $this->input->post('volume', true);
                $data['ket'] = $this->input->post('ket', true);
                $data['bagian_upk'] = $this->session->userdata('upk_bagian');
                $data['tgl_Upload'] = date('Y-m-d H:i:s');

                // Simpan data ke dalam database
                $this->db->insert('usulan_barang', $data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Usulan barang berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                );
                redirect('rkap/usulan_barang');
            }
        }
    }

    public function edit_usulan_barang($id_usulanBarang)
    {
        $data['title'] = 'Update Usulan barang';
        // $statusUpdate = $this->Model_usulan_barang->getStatusUpdate('usulan_barang');
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate();
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_barang');
        } else {
            $data['usulan_barang'] = $this->Model_usulan_barang->getUsulanBarang($id_usulanBarang);

            if (!$data['usulan_barang']) {
                $this->_setFlashError('Data usulan barang tidak ditemukan');
                redirect('rkap/usulan_barang');
            }

            $data['kategori_barang'] = $this->Model_rkap_barang->getKategori();
            $data['master_barang'] = $this->Model_rkap_barang->getMasterBarang(date('Y'));
            $masterTerpilih = $this->Model_rkap_barang->cariMasterBarang(
                date('Y'),
                $data['usulan_barang']->kategori,
                $data['usulan_barang']->nama_perkiraan
            );
            $data['master_barang_id'] = $masterTerpilih ? (int) $masterTerpilih->id : 0;
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('rkap/usulan_barang/edit_usulan_barang', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|trim|numeric');
        $this->form_validation->set_rules('master_barang_id', 'Nama Barang', 'required|trim|numeric');
        $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('greater_than', '%s harus lebih dari 0');

        if ($this->form_validation->run() == false) {
            $this->edit_usulan_barang($this->input->post('id_usulanBarang', true));
            return;
        }

        $barang = $this->Model_rkap_barang->getMasterBarangTerpilih(
            $this->input->post('master_barang_id', true),
            date('Y'),
            $this->input->post('kategori_id', true)
        );

        if (!$barang) {
            $this->_setFlashError('Master barang tidak valid atau tidak tersedia untuk tahun ' . date('Y'));
            redirect('rkap/usulan_barang');
        }

        $this->Model_usulan_barang->updateDataDariMaster($barang);
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
            redirect('rkap/usulan_barang');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data RKAP berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('rkap/usulan_barang');
        }
    }

    private function _setFlashError($pesan)
    {
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> ' . $pesan . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
    }

    // Akhir Usulan barang

    public function hapus_usulan_barang($id_usulanBarang)
    {
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate();
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('rkap/usulan_barang');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanBarang', $id_usulanBarang);
            $query = $this->db->get('usulan_barang');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanBarang', $id_usulanBarang);
            $this->db->delete('usulan_barang');

            redirect('rkap/usulan_barang');
        }
    }

    public function export_pdf()
    {
        $data['tahun'] = $this->Model_usulan_barang->getTahun();
        $data['tampil'] = $this->Model_usulan_barang->getData();
        $data['title'] = 'USULAN PERMINTAAN BARANG (RKAP) TAHUN ';

        $upk_bagian = $this->session->userdata('upk_bagian');
        $tahun = date('Y');

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Usulan Barang-{$upk_bagian}-{$tahun}.pdf";
        $this->pdf->generate('rkap/usulan_barang/laporan_pdf', $data);
    }

    public function detail_usulan_barang($id_usulanBarang)
    {
        $data['title'] = 'Detail Usulan Barang';
        $data['usulan_barang'] = $this->db->get_where('usulan_barang', ['id_usulanBarang' => $id_usulanBarang])->row();

        if (!$data['usulan_barang']) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> Data tidak ditemukan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('rkap/usulan_barang');
        }

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_barang/detail_usulan_barang', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
