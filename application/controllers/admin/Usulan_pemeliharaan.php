<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_pemeliharaan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_pemeliharaan');
        $this->load->model('Model_amdk_biaya');
        $this->load->model('Model_setting');
        $this->load->model('Model_pengaturan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {
        $bagian_upk = $this->input->get('bagian_upk');
        $tahun_rkap = $this->input->get('tahun_rkap') ?: date('Y');
        $is_locked = $this->Model_setting->cekLock($tahun_rkap);

        // Simpan ke session
        $this->session->set_userdata('bagian_upk', $bagian_upk ?: 'SEMUA');
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        $data['tampil'] = $this->Model_usulan_pemeliharaan->getFiltered($bagian_upk, $tahun_rkap);
        $data['bagian_upk'] = $bagian_upk;
        $data['tahun'] = $tahun_rkap;
        $data['title'] = 'USULAN PEMELIHARAAN (RKAP) TAHUN ';
        $data['namaUpk'] = $bagian_upk ? $bagian_upk : 'SEMUA';
        $data['is_locked'] = $is_locked;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_pemeliharaan/view_usulan_pemeliharaan', $data);
        $this->load->view('templates/footer');
    }

    // public function index()
    // {
    //     $dataUpk = $this->input->post('bagian_upk');
    //     $dataTahun = $this->input->post('tahun_rkap');
    //     $data['namaUpk'] = $dataUpk;
    //     $data['tahun'] = $dataTahun;
    //     $data['tampil'] = $this->Model_usulan_pemeliharaan->getDataUpk($dataUpk, $dataTahun);
    //     $data['seleksi'] = $this->Model_usulan_pemeliharaan->getNamaUpk($dataUpk, $dataTahun);
    //     $data['title'] = 'USULAN PEMELIHARAAN (RKAP) TAHUN ';
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('admin/usulan_pemeliharaan/view_usulan_pemeliharaan', $data);
    //     $this->load->view('templates/footer');
    // }

    public function export_pdf()
    {
        $dataUpk   = $this->session->userdata('bagian_upk');
        $dataTahun = $this->session->userdata('tahun_rkap') ?: date('Y');

        $data['tampil'] = $this->Model_usulan_pemeliharaan->getFiltered($dataUpk, $dataTahun);
        $data['namaUpk'] = (empty($dataUpk) || $dataUpk === 'SEMUA') ? 'SEMUA' : $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['title'] = 'USULAN PEMELIHARAAN (RKAP) TAHUN ';

        $this->pdf->setPaper('Folio', 'landscape');

        $safeUpk = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['namaUpk']);
        $this->pdf->filename = "Usulan_pemel-{$safeUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/usulan_pemeliharaan/laporan_pdf', $data);
    }

    // // Awal Usulan pemeliharaan
    // public function upload()
    // {

    //     $statusUpload = $this->Model_usulan_pemeliharaan->getStatusUpload('usulan_pemeliharaan');
    //     if ($statusUpload !== null && $statusUpload->status == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di input.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('rkap/usulan_pemeliharaan');
    //     } else {

    //         $this->form_validation->set_rules('no_perkiraan', 'No Perkiraan', 'trim');
    //         $this->form_validation->set_rules('nama_perkiraan', 'Nama Perkiraan', 'required|trim');
    //         $this->form_validation->set_rules('latar_belakang', 'Latar Belakang', 'required|trim');
    //         $this->form_validation->set_rules('solusi', 'Solusi', 'required|trim');
    //         $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric');
    //         $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
    //         $this->form_validation->set_rules('biaya', 'Biaya', 'trim');
    //         $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
    //         $this->form_validation->set_message('required', '%s masih kosong');
    //         $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //         if ($this->form_validation->run() == false) {
    //             $data['title'] = 'Input Usulan Pemeliharaan';
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/usulan_pemeliharaan/upload_usulan_pemeliharaan', $data);
    //             $this->load->view('templates/pengguna/footer');
    //         } else {
    //             // Cek apakah ada file yang diupload
    //             if (!empty($_FILES['foto_ket']['name'])) {
    //                 // Lakukan proses upload file
    //                 $config['upload_path']   = './uploads/';
    //                 $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //                 $config['max_size']      = 1000;
    //                 $this->load->library('upload', $config);
    //                 if ($this->upload->do_upload('foto_ket')) {
    //                     $data_upload = $this->upload->data();
    //                     $data['foto_ket'] = $data_upload['file_name'];
    //                 } else {
    //                     // Jika proses upload gagal
    //                     $error_msg = $this->upload->display_errors();
    //                     $this->session->set_flashdata('info', $error_msg);
    //                     redirect('rkap/usulan_pemeliharaan');
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
    //             $data['bagian_upk'] = $this->session->userdata('upk_bagian');
    //             $data['tgl_Upload'] = date('Y-m-d H:i:s');

    //             // Simpan data ke dalam database
    //             $this->db->insert('usulan_pemeliharaan', $data);
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data Usulan pemeliharaan berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/usulan_pemeliharaan');
    //         }
    //     }
    // }

    public function edit_usulan_pemeliharaan($id_usulanPemeliharaan)
    {
        $data['title'] = 'Update Usulan pemeliharaan';
        $statusUpdate = $this->Model_usulan_pemeliharaan->getStatusUpdate('usulan_pemeliharaan');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_pemeliharaan');
        } else {
            $data['no_per'] = $this->Model_usulan_pemeliharaan->getNoPerPemeliharaan();
            $data['usulan_pemeliharaan'] = $this->Model_usulan_pemeliharaan->getUsulanPemeliharaan($id_usulanPemeliharaan);
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('admin/usulan_pemeliharaan/edit_usulan_pemeliharaan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    // public function update()
    // {
    //     $this->Model_usulan_pemeliharaan->updateData();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/usulan_pemeliharaan');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data usulan pemeliharaan berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('rkap/usulan_pemeliharaan');
    //     }
    // }

    public function update()
    {
        $this->Model_usulan_pemeliharaan->updateData();
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
            redirect('admin/usulan_pemeliharaan');
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
                    $usulanPemeliharaan = $this->Model_usulan_pemeliharaan->getUsulanPemeliharaan($this->input->post('id_usulanPemeliharaan'));
                    $namaFileLama = $usulanPemeliharaan->foto_ket;

                    // Lakukan proses upload file baru
                    $data_upload = $this->upload->data();
                    $data['foto_ket'] = $data_upload['file_name'];
                    $data['id_usulanPemeliharaan'] = $this->input->post('id_usulanPemeliharaan');
                    $this->Model_usulan_pemeliharaan->updateFoto($data);


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
                    redirect('admin/usulan_pemeliharaan');
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
            redirect('admin/usulan_pemeliharaan');
        }
    }

    // Akhir Usulan pemeliharaan

    public function hapus_usulan_pemeliharaan($id_usulanPemeliharaan)
    {
        $statusUpdate = $this->Model_usulan_pemeliharaan->getStatusUpdate('usulan_pemeliharaan');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_pemeliharaan');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanPemeliharaan', $id_usulanPemeliharaan);
            $query = $this->db->get('usulan_pemeliharaan');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanPemeliharaan', $id_usulanPemeliharaan);
            $this->db->delete('usulan_pemeliharaan');

            redirect('admin/usulan_pemeliharaan');
        }
    }

    public function detail_usulan_pemeliharaan($id_usulanPemeliharaan)
    {
        $data['title'] = 'Detail Usulan Pemeliharaan';
        $data['usulan_pemeliharaan'] = $this->db->get_where('usulan_pemeliharaan', ['id_usulanPemeliharaan' => $id_usulanPemeliharaan])->row();

        if (!$data['usulan_pemeliharaan']) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> Data tidak ditemukan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('admin/usulan_pemeliharaan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_pemeliharaan/detail_usulan_pemeliharaan', $data);
        $this->load->view('templates/footer');
    }

    public function generate_usulan_pemeliharaan($id_usulanPemeliharaan)
    {
        $data['title'] = 'Generate Data Ke Biaya (LABA RUGI)';
        // Cek status update
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate();
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data sudah tidak bisa diproses.
            </div>'
            );
            redirect('admin/usulan_pemeliharaan');
        }
        // Ambil data usulan
        $usulan = $this->Model_usulan_pemeliharaan->getUsulanPemeliharaanAdmin($id_usulanPemeliharaan);
        if (!$usulan) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tidak ditemukan.
            </div>'
            );
            redirect('admin/usulan_pemeliharaan');
        }

        // PROSES GENERATE
        if ($this->input->post()) {
            $bulanDipilih = $this->input->post('bulan');
            if (empty($bulanDipilih)) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger">
                    Pilih minimal satu bulan.
                </div>'
                );
                redirect('admin/usulan_pemeliharaan/generate_usulan_pemeliharaan/' . $id_usulanPemeliharaan);
            }

            // Mapping UPK
            $mapping_upk = [
                'pusat'        => '00',
                'bondowoso'    => '01',
                'sukosari1'    => '02',
                'maesan'       => '03',
                'tegalampel'   => '04',
                'tapen'        => '05',
                'prajekan'     => '06',
                'tlogosari'    => '07',
                'wringin'      => '08',
                'curahdami'    => '09',
                'tamanan'      => '11',
                'tenggarang'   => '12',
                'amdk'         => '13',
                'tamankrocok'  => '14',
                'wonosari'     => '15',
                'klabang'      => '16',
                'sukosari2'    => '22',
                'umum'         => '23',
                'keuangan'     => '24',
                'langganan'    => '25',
                'pemeliharaan' => '26',
                'perencanaan'  => '27',
                'spi'          => '28'
            ];

            $bagian = strtolower(trim($usulan->bagian_upk));
            $cabang_id = $mapping_upk[$bagian] ?? '';
            // bagian_upk berasal dari data usulan_pemeliharaan, mapping_upk digunakan untuk mendapatkan cabang_id yang sesuai. Jika bagian_upk tidak ada dalam mapping, cabang_id akan menjadi string kosong.
            $cabang_id = $mapping_upk[$usulan->bagian_upk] ?? '';

            if ($cabang_id == '') {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger">
                    Mapping UPK tidak ditemukan.
                </div>'
                );
                redirect('admin/usulan_pemeliharaan');
            }

            //  Siapkan data
            $tahun = $usulan->tahun_rkap + 1;
            $insert = [];
            foreach ($bulanDipilih as $bulan) {
                $insert[] = [
                    'id_upk' => NULL,
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $usulan->no_perkiraan,
                    'bulan' => sprintf(
                        '%04d-%02d-01',
                        $tahun,
                        $bulan
                    ),
                    'uraian' => $usulan->nama_perkiraan,
                    'pagu' => $usulan->biaya,
                    'status' => 0,
                    'status_update' => 0,
                    'ptgs_upload' => $this->session->userdata('nama_lengkap')

                ];
            }

            // Simpan
            // $result = $this->Model_usulan_pemeliharaan
            //     ->insert_or_update_generate_pemeliharaan($insert);
            // $this->session->set_flashdata(
            //     'info',
            //     '<div class="alert alert-success">
            //     Berhasil Generate Biaya (Laba Rugi).<br>
            //     Proses Insert : <b>' . $result['inserted'] . '</b><br>
            //     Proses Update : <b>' . $result['updated'] . '</b>
            // </div>'
            // );

            $this->db->trans_begin();
            if ($usulan->bagian_upk == 'amdk') {
                $result = $this->Model_amdk_biaya->insert_or_update($insert);
            } else {
                $result = $this->Model_usulan_pemeliharaan->insert_or_update_generate_pemeliharaan($insert);
            }
            $this->Model_usulan_pemeliharaan->updateStatusUpload($id_usulanPemeliharaan);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger">
            Generate gagal.
        </div>'
                );
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-success">
            Berhasil Generate Pemeliharaan.<br>
            Proses Insert : <b>' . $result['inserted'] . '</b><br>
            Proses Update : <b>' . $result['updated'] . '</b>
        </div>'
                );
            }
            redirect('admin/usulan_pemeliharaan');
        }

        $data['usulan_pemeliharaan'] = $usulan;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_pemeliharaan/generate_usulan_pemeliharaan', $data);
        $this->load->view('templates/footer');
    }
}
