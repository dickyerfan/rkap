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
        $this->load->model('Model_setting');
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
        $kategori = $this->input->get('kategori');

        // Simpan ke session
        $this->session->set_userdata('bagian_upk', $bagian_upk ?: 'SEMUA');
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);
        $this->session->set_userdata('kategori', $kategori);

        $data['tampil'] = $this->Model_usulan_barang->getFiltered($bagian_upk, $tahun_rkap, $kategori);
        $data['bagian_upk'] = $bagian_upk;
        $data['tahun'] = $tahun_rkap;
        // $data['kategori'] = $kategori;
        $data['title'] = 'USULAN PERMINTAAN BARANG (RKAP) TAHUN ';
        $data['namaUpk'] = $bagian_upk ? $bagian_upk : 'SEMUA';
        $data['is_locked'] = $is_locked;
        $data['kategori_list'] = $this->Model_usulan_barang->getKategoriBarang();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_barang/view_usulan_barang', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $dataUpk   = $this->session->userdata('bagian_upk');
        $dataTahun = $this->session->userdata('tahun_rkap') ?: date('Y');
        $kategori = $this->session->userdata('kategori');

        $data['tampil'] = $this->Model_usulan_barang->getFiltered($dataUpk, $dataTahun, $kategori);
        $data['namaUpk'] = (empty($dataUpk) || $dataUpk === 'SEMUA') ? 'SEMUA' : $dataUpk;
        $data['tahun'] = $dataTahun;
        $data['kategori'] = $kategori;
        $data['title'] = 'USULAN PERMINTAAN BARANG (RKAP) TAHUN ';

        $this->pdf->setPaper('Folio', 'portrait');

        $safeUpk = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['namaUpk']);
        $this->pdf->filename = "Usulan_barang-{$safeUpk}-{$dataTahun}.pdf";
        $this->pdf->generate('admin/usulan_barang/laporan_pdf', $data);
    }


    public function edit_usulan_barang($id_usulanBarang)
    {
        $data['title'] = 'Update Usulan barang';
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate('usulan_barang');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_barang');
        } else {
            $data['usulan_barang'] = $this->Model_usulan_barang->getUsulanBarangAdmin($id_usulanBarang);

            if (!$data['usulan_barang']) {
                $this->_set_flash('danger', 'Maaf,', 'Data usulan barang tidak ditemukan');
                redirect('admin/usulan_barang');
            }
            $kodeAkun = !empty($data['usulan_barang']->kategori)
                ? $data['usulan_barang']->kategori
                : null;
            $data['kategori_barang'] = $this->Model_rkap_barang->getKategoriDenganNoPer();
            $data['master_barang'] = $this->Model_rkap_barang->getMasterBarang($data['usulan_barang']->tahun_rkap);
            $masterTerpilih = $this->Model_rkap_barang->cariMasterBarang(
                $data['usulan_barang']->tahun_rkap,
                $data['usulan_barang']->kategori,
                $data['usulan_barang']->nama_perkiraan
            );
            $data['master_barang_id'] = $masterTerpilih ? (int) $masterTerpilih->id : 0;

            $data['no_per_list'] = $this->Model_rkap_barang->getNoPerByKodeAkun(
                $data['usulan_barang']->no_perkiraan ?? null
            );

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('admin/usulan_barang/edit_usulan_barang', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('id_usulanBarang', 'Usulan Barang', 'required|trim|numeric');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|trim|numeric');
        $this->form_validation->set_rules('master_barang_id', 'Nama Perkiraan', 'required|trim|numeric');
        $this->form_validation->set_rules('volume', 'Volume', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('greater_than', '%s harus lebih dari 0');

        if ($this->form_validation->run() == false) {
            $this->edit_usulan_barang($this->input->post('id_usulanBarang', true));
            return;
        }

        $usulan = $this->Model_usulan_barang->getUsulanBarangAdmin($this->input->post('id_usulanBarang', true));
        if (!$usulan) {
            $this->_set_flash('danger', 'Maaf,', 'Data usulan barang tidak ditemukan');
            redirect('admin/usulan_barang');
        }

        $barang = $this->Model_rkap_barang->getMasterBarangTerpilih(
            $this->input->post('master_barang_id', true),
            $usulan->tahun_rkap,
            $this->input->post('kategori_id', true)
        );

        if (!$barang) {
            $this->_set_flash('danger', 'Maaf,', 'Master barang tidak valid untuk tahun ' . $usulan->tahun_rkap);
            redirect('admin/usulan_barang/edit_usulan_barang/' . (int) $usulan->id_usulanBarang);
        }

        $noPer = $this->Model_rkap_barang->getNoPerKategori($this->input->post('kategori_id', true));
        if (!$noPer) {
            $this->_set_flash('danger', 'Maaf,', 'Kode akun kategori belum terdaftar atau tidak aktif di tabel no_per');
            redirect('admin/usulan_barang/edit_usulan_barang/' . (int) $usulan->id_usulanBarang);
        }

        $this->Model_usulan_barang->updateDataAdminDariMaster(
            $barang,
            $usulan->tahun_rkap,
            $this->input->post('harga_satuan', true)
        );
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
            redirect('admin/usulan_barang');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data RKAP berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
            );
            redirect('admin/usulan_barang');
        }
    }

    public function edit_usulan_lain($id_usulanBarang)
    {
        $data['title'] = 'Update Usulan Investasi';
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di update.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_barang');
        } else {
            $data['no_per'] = $this->Model_usulan_barang->getNoPerBarang();
            $data['usulan_lain'] = $this->Model_usulan_barang->getUsulanBarang($id_usulanBarang);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_barang/edit_usulan_lain', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update_lain()
    {
        $this->Model_usulan_barang->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/usulan_inves');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data RKAP berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('admin/usulan_barang');
        }
    }

    // public function generate_usulan_barang($id_usulanBarang)
    // {
    //     $data['title'] = 'Generate Usulan barang';
    //     $statusUpdate = $this->Model_pengaturan->getStatusUpdate('usulan_barang');
    //     if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Maaf,</strong> data sudah tidak bisa di update.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         redirect('admin/usulan_barang');
    //     } else {
    //         $data['usulan_barang'] = $this->Model_usulan_barang->getUsulanBarangAdmin($id_usulanBarang);

    //         if (!$data['usulan_barang']) {
    //             $this->_set_flash('danger', 'Maaf,', 'Data usulan barang tidak ditemukan');
    //             redirect('admin/usulan_barang');
    //         }
    //         $kodeAkun = !empty($data['usulan_barang']->kategori)
    //             ? $data['usulan_barang']->kategori
    //             : null;
    //         $data['kategori_barang'] = $this->Model_rkap_barang->getKategoriDenganNoPer();
    //         $data['master_barang'] = $this->Model_rkap_barang->getMasterBarang($data['usulan_barang']->tahun_rkap);
    //         $masterTerpilih = $this->Model_rkap_barang->cariMasterBarang(
    //             $data['usulan_barang']->tahun_rkap,
    //             $data['usulan_barang']->kategori,
    //             $data['usulan_barang']->nama_perkiraan
    //         );
    //         $data['master_barang_id'] = $masterTerpilih ? (int) $masterTerpilih->id : 0;

    //         $data['no_per_list'] = $this->Model_rkap_barang->getNoPerByKodeAkun(
    //             $data['usulan_barang']->no_perkiraan ?? null
    //         );

    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar');
    //         $this->load->view('admin/usulan_barang/generate_usulan_barang', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     }
    // }

    public function generate_usulan_barang($id_usulanBarang)
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
            redirect('admin/usulan_barang');
        }
        // Ambil data usulan
        $usulan = $this->Model_usulan_barang->getUsulanBarangAdmin($id_usulanBarang);
        if (!$usulan) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tidak ditemukan.
            </div>'
            );
            redirect('admin/usulan_barang');
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
                redirect('admin/usulan_barang/generate_usulan_barang/' . $id_usulanBarang);
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
            // bagian_upk berasal dari data usulan_barang
            // $cabang_id = $mapping_upk[$usulan->bagian_upk] ?? '';

            if ($cabang_id == '') {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger">
                    Mapping UPK tidak ditemukan.
                </div>'
                );
                redirect('admin/usulan_barang');
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
            $this->db->trans_begin();
            $result = $this->Model_usulan_barang
                ->insert_or_update_generate_barang($insert);
            $this->Model_usulan_barang
                ->updateStatusUpload($id_usulanBarang);
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
            Berhasil Generate Biaya (Laba Rugi).<br>
            Proses Insert : <b>' . $result['inserted'] . '</b><br>
            Proses Update : <b>' . $result['updated'] . '</b>
        </div>'
                );
            }

            redirect('admin/usulan_barang');
        }

        $data['usulan_barang'] = $usulan;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_barang/generate_usulan_barang', $data);
        $this->load->view('templates/footer');
    }

    // Akhir Usulan barang

    public function kategori_barang()
    {
        $data['title'] = 'Daftar Kategori Barang';
        $data['kategori_barang'] = $this->Model_rkap_barang->getKategori();

        if ($this->session->userdata('nama_pengguna') === 'administrator') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_barang/view_kategori_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('admin/usulan_barang/view_kategori_barang', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function tambah_kategori_barang()
    {
        $this->_validasi_kategori_barang();

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Kategori Barang';
            $data['kategori'] = null;
            $data['action'] = base_url('admin/usulan_barang/tambah_kategori_barang');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_barang/form_kategori_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->Model_rkap_barang->insertKategori();
            $this->_set_flash('success', 'Sukses,', 'Kategori barang berhasil disimpan');
            redirect('admin/usulan_barang/kategori_barang');
        }
    }

    public function edit_kategori_barang($id)
    {
        $data['kategori'] = $this->Model_rkap_barang->getKategoriById($id);

        if (!$data['kategori']) {
            $this->_set_flash('danger', 'Maaf,', 'Data kategori barang tidak ditemukan');
            redirect('admin/usulan_barang/kategori_barang');
        }

        $data['title'] = 'Edit Kategori Barang';
        $data['action'] = base_url('admin/usulan_barang/update_kategori_barang');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_barang/form_kategori_barang', $data);
        $this->load->view('templates/footer');
    }

    public function update_kategori_barang()
    {
        $this->_validasi_kategori_barang();

        if ($this->form_validation->run() == false) {
            $this->edit_kategori_barang($this->input->post('id', true));
        } else {
            $this->Model_rkap_barang->updateKategori();
            $this->_set_flash('success', 'Sukses,', 'Kategori barang berhasil diupdate');
            redirect('admin/usulan_barang/kategori_barang');
        }
    }

    public function hapus_kategori_barang($id)
    {
        if ($this->db->where('kategori_id', $id)->count_all_results('rkap_master_barang') > 0) {
            $this->_set_flash('danger', 'Maaf,', 'Kategori tidak bisa dihapus karena masih dipakai di master barang');
            redirect('admin/usulan_barang/kategori_barang');
        }

        $this->Model_rkap_barang->deleteKategori($id);
        $this->_set_flash('success', 'Sukses,', 'Kategori barang berhasil dihapus');
        redirect('admin/usulan_barang/kategori_barang');
    }

    public function master_barang()
    {
        $tahun = (int) ($this->input->get('tahun', true) ?: date('Y'));
        $data['title'] = 'Daftar Master Barang';
        $data['tahun'] = $tahun;
        $data['tahun_master'] = $this->Model_rkap_barang->getTahunMasterBarang();
        $data['master_barang'] = $this->Model_rkap_barang->getMasterBarang($tahun);

        if ($this->session->userdata('nama_pengguna') === 'administrator') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_barang/view_master_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('admin/usulan_barang/view_master_barang', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function tambah_master_barang()
    {
        $this->_validasi_master_barang();

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Master Barang';
            $data['barang'] = null;
            $data['tahun'] = (int) ($this->input->get('tahun', true) ?: date('Y'));
            $data['kategori_barang'] = $this->Model_rkap_barang->getKategori();
            $data['action'] = base_url('admin/usulan_barang/tambah_master_barang');

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_barang/form_master_barang', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->Model_rkap_barang->masterBarangSudahAda(
                $this->input->post('tahun', true),
                $this->input->post('kategori_id', true),
                $this->input->post('nama_barang', true)
            )) {
                $this->_set_flash('danger', 'Maaf,', 'Barang tersebut sudah ada pada tahun dan kategori yang dipilih');
                redirect('admin/usulan_barang/tambah_master_barang?tahun=' . (int) $this->input->post('tahun', true));
            }

            $this->Model_rkap_barang->insertMasterBarang();
            $this->_set_flash('success', 'Sukses,', 'Master barang berhasil disimpan');
            redirect('admin/usulan_barang/master_barang?tahun=' . (int) $this->input->post('tahun', true));
        }
    }

    public function edit_master_barang($id)
    {
        $data['barang'] = $this->Model_rkap_barang->getMasterBarangById($id);

        if (!$data['barang']) {
            $this->_set_flash('danger', 'Maaf,', 'Data master barang tidak ditemukan');
            redirect('admin/usulan_barang/master_barang');
        }

        $data['title'] = 'Edit Master Barang';
        $data['tahun'] = (int) $data['barang']->tahun;
        $data['kategori_barang'] = $this->Model_rkap_barang->getKategori();
        $data['action'] = base_url('admin/usulan_barang/update_master_barang');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_barang/form_master_barang', $data);
        $this->load->view('templates/footer');
    }

    public function update_master_barang()
    {
        $this->_validasi_master_barang();

        if ($this->form_validation->run() == false) {
            $this->edit_master_barang($this->input->post('id', true));
        } else {
            if ($this->Model_rkap_barang->masterBarangSudahAda(
                $this->input->post('tahun', true),
                $this->input->post('kategori_id', true),
                $this->input->post('nama_barang', true),
                $this->input->post('id', true)
            )) {
                $this->_set_flash('danger', 'Maaf,', 'Barang tersebut sudah ada pada tahun dan kategori yang dipilih');
                redirect('admin/usulan_barang/edit_master_barang/' . (int) $this->input->post('id', true));
            }

            $this->Model_rkap_barang->updateMasterBarang();
            $this->_set_flash('success', 'Sukses,', 'Master barang berhasil diupdate');
            redirect('admin/usulan_barang/master_barang?tahun=' . (int) $this->input->post('tahun', true));
        }
    }

    public function salin_master_barang()
    {
        $tahunTujuan = (int) $this->input->post('tahun_tujuan', true);
        $tahunSumber = $tahunTujuan - 1;

        if ($tahunTujuan < 2000 || $tahunTujuan > 2100) {
            $this->_set_flash('danger', 'Maaf,', 'Tahun tujuan tidak valid');
            redirect('admin/usulan_barang/master_barang');
        }

        $jumlah = $this->Model_rkap_barang->salinMasterBarang($tahunSumber, $tahunTujuan);

        if ($jumlah === false) {
            $this->_set_flash('danger', 'Maaf,', 'Master barang gagal disalin');
        } elseif ($jumlah === 0) {
            $this->_set_flash('warning', 'Info,', 'Tidak ada barang baru yang dapat disalin dari tahun ' . $tahunSumber);
        } else {
            $this->_set_flash('success', 'Sukses,', $jumlah . ' barang dari tahun ' . $tahunSumber . ' berhasil disalin ke tahun ' . $tahunTujuan . '. Silakan update harganya.');
        }

        redirect('admin/usulan_barang/master_barang?tahun=' . $tahunTujuan);
    }

    public function hapus_master_barang($id)
    {
        $tahun = (int) ($this->input->get('tahun', true) ?: date('Y'));
        $this->Model_rkap_barang->deleteMasterBarang($id);
        $this->_set_flash('success', 'Sukses,', 'Master barang berhasil dihapus');
        redirect('admin/usulan_barang/master_barang?tahun=' . $tahun);
    }

    private function _validasi_kategori_barang()
    {
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('kode_akun', 'Kode Akun', 'trim|max_length[20]');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[255]');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('max_length', '%s maksimal %s karakter');
    }

    private function _validasi_master_barang()
    {
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim|numeric|exact_length[4]');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|trim|numeric');
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required|trim|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required|trim|max_length[20]');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('max_length', '%s maksimal %s karakter');
    }

    private function _set_flash($tipe, $judul, $pesan)
    {
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-' . $tipe . ' alert-dismissible fade show" role="alert">
                <strong>' . $judul . '</strong> ' . $pesan . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
            </div>'
        );
    }

    public function hapus_usulan_barang($id_usulanBarang)
    {
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate('usulan_barang');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_barang');
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

            redirect('admin/usulan_barang');
        }
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
            redirect('admin/usulan_barang');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_barang/detail_usulan_barang', $data);
        $this->load->view('templates/footer');
    }

    // public function upload()
    // {

    //     $statusUpload = $this->Model_usulan_barang->getStatusUpload('usulan_barang');
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
    //             $data['title'] = 'Input Usulan Permintaan Barang';
    //             $this->load->view('templates/pengguna/header', $data);
    //             $this->load->view('templates/pengguna/navbar');
    //             $this->load->view('templates/pengguna/sidebar');
    //             $this->load->view('rkap/usulan_barang/upload_usulan_barang', $data);
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
    //                     redirect('rkap/usulan_barang');
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
    //             $this->db->insert('usulan_barang', $data);
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Data Usulan barang berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //             );
    //             redirect('rkap/usulan_barang');
    //         }
    //     }
    // }
}
