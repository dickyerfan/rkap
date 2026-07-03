<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_produksi_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_produksi_amdk');
        $this->load->model('Model_pengaturan');
        $this->load->library('form_validation');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }
    public function index()
    {

        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;
        $this->session->set_userdata('tahun_rkap', $tahun);
        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PRODUKSI UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_produksi_amdk/view_produksi', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function tambah()
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
            redirect('rkap/usulan_produksi_amdk');
        } else {
            if ($this->input->post()) {
                $id_produk = $this->input->post('id_produk');
                $tahun = $this->input->post('tahun_rkap');
                $jumlah = $this->input->post('jumlah_produksi');

                // Panggil fungsi insert di model dan simpan hasilnya ke variabel
                $hasil = $this->Model_produksi_amdk->insertProduksi($id_produk, $tahun, $jumlah);

                if (!$hasil) {
                    // Jika sudah ada data
                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data untuk produk dan tahun ini sudah ada!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                    );
                    redirect('rkap/usulan_produksi_amdk?tahun_rkap=' . $tahun);
                    return; // hentikan eksekusi
                }

                // Jika berhasil insert
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data produksi AMDK berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                );
                redirect('rkap/usulan_produksi_amdk?tahun_rkap=' . $tahun);
            } else {
                $tahun = $this->session->userdata('tahun_rkap');
                $data['produk'] = $this->db
                    ->where([
                        'status' => 1,
                        'tahun_rkap' => $tahun
                    ])
                    ->get('rkap_amdk_produk')
                    ->result();
                $data['title'] = 'Input Data Produksi AMDK';
                $this->load->view('templates/header', $data);
                $this->load->view('templates/navbar');
                $this->load->view('templates/sidebar');
                $this->load->view('rkap/usulan_produksi_amdk/upload_produksi', $data);
                $this->load->view('templates/footer');
            }
        }
    }

    public function edit($id_produk, $tahun)
    {
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
            redirect('rkap/usulan_produksi_amdk');
        } else {
            // Ambil data produksi 12 bulan untuk produk & tahun ini
            $data['produksi'] = $this->Model_produksi_amdk->getProduksiByProdukTahun($id_produk, $tahun);

            if (!$data['produksi']) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data tidak ditemukan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                );
                redirect('rkap/usulan_produksi_amdk?tahun_rkap=' . $tahun);
            }

            $data['produk'] = $this->db->get_where('rkap_amdk_produk', ['id_produk' => $id_produk])->row();
            $data['tahun_rkap'] = $tahun;
            $data['title'] = 'Edit Data Produksi AMDK';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('rkap/usulan_produksi_amdk/edit_produksi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update()
    {
        $id_produk = $this->input->post('id_produk');
        $tahun = $this->input->post('tahun_rkap');
        $jumlah = $this->input->post('jumlah_produksi');
        $ptgs_update = $this->session->userdata('nama_lengkap'); // array dari input form

        $this->Model_produksi_amdk->updateProduksi($id_produk, $tahun, $jumlah, $ptgs_update);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data produksi AMDK berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );
        redirect('rkap/usulan_produksi_amdk?tahun_rkap=' . $tahun);
    }

    public function persen()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;
        $data['title'] = 'Data Persentase Produksi AMDK';
        // kirim tahun ke model
        $data['data'] = $this->Model_produksi_amdk->getPersen($tahun);

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar');
        $this->load->view('rkap/usulan_produksi_amdk/view_persen', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function tambah_persen()
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
            redirect('rkap/usulan_produksi_amdk/persen');
        } else {
            $data['title'] = 'Tambah Persentase AMDK';
            $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
            $data['tahun'] = $tahun;
            $data['produk'] = $this->Model_produksi_amdk->get_produk($tahun);
            $data['tarif']  = $this->Model_produksi_amdk->get_tarif($tahun);

            if ($this->input->post()) {
                // CEK DUPLIKAT (DI SINI)
                $cek = $this->Model_produksi_amdk->cek_duplikat(
                    $this->input->post('id_produk'),
                    $this->input->post('id_tarif'),
                    $this->input->post('tahun_rkap')
                );

                if ($cek > 0) {

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-danger">
                Data kombinasi ini sudah ada (Produk + Tarif + Tahun)!
            </div>'
                    );
                    redirect('rkap/usulan_produksi_amdk/persen');
                    return; // stop proses
                }

                $data_insert = [
                    'id_produk'     => $this->input->post('id_produk'),
                    'id_tarif'      => $this->input->post('id_tarif'),
                    'persen'        => $this->input->post('persen'),
                    'tahun_rkap'    => $this->input->post('tahun_rkap'),
                    'status'        => 1,
                    'status_update' => 1,
                    'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
                    'tgl_upload'    => date('Y-m-d H:i:s')
                ];

                $this->Model_produksi_amdk->insert($data_insert);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-success">Data berhasil ditambahkan</div>'
                );
                redirect('rkap/usulan_produksi_amdk/persen');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('rkap/usulan_produksi_amdk/upload_persen', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit_persen($id_persentase)
    {
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
            redirect('rkap/usulan_produksi_amdk/persen');
        } else {
            $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
            $data['tahun'] = $tahun;
            $data['title'] = 'Edit Persentase AMDK';
            $data['row']   = $this->Model_produksi_amdk->get_by_id($id_persentase);
            $data['produk'] = $this->Model_produksi_amdk->get_produk($tahun);
            $data['tarif']  = $this->Model_produksi_amdk->get_tarif($tahun);

            if ($this->input->post()) {
                $data_update = [
                    'id_produk'     => $this->input->post('id_produk'),
                    'id_tarif'      => $this->input->post('id_tarif'),
                    'persen'        => $this->input->post('persen'),
                    'tahun_rkap'    => $this->input->post('tahun_rkap'),
                    'ptgs_update'   => $this->session->userdata('nama_lengkap'),
                    'tgl_update'    => date('Y-m-d H:i:s')
                ];

                $this->Model_produksi_amdk->update($id_persentase, $data_update);

                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data persentase AMDK berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                );
                redirect('rkap/usulan_produksi_amdk/persen');
            }
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('rkap/usulan_produksi_amdk/edit_persen', $data);
            $this->load->view('templates/footer');
        }
    }
}
