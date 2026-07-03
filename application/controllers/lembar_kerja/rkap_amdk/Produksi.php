<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_produksi_amdk');
        date_default_timezone_set('Asia/Jakarta');
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

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/view_produksi', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $this->session->set_userdata('tahun_rkap', $tahun);

        $data['produksi'] = $this->Model_produksi_amdk->getDataProduksi($tahun);
        $data['title'] = 'RENCANA PRODUKSI UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_produksi_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/laporan_pdf', $data);
    }


    public function tambah()
    {
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
                redirect('lembar_kerja/rkap_amdk/produksi');
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
            redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
        } else {
            // $data['produk'] = $this->db->get('rkap_amdk_produk')->result();
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
            $this->load->view('lembar_kerja/rkap_amdk/upload_produksi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function edit($id_produk, $tahun)
    {
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
            redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
        }

        $data['produk'] = $this->db->get_where('rkap_amdk_produk', ['id_produk' => $id_produk])->row();
        $data['tahun_rkap'] = $tahun;
        $data['title'] = 'Edit Data Produksi AMDK';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/edit_produksi', $data);
        $this->load->view('templates/footer');
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
        redirect('lembar_kerja/rkap_amdk/produksi?tahun_rkap=' . $tahun);
    }

    // Persentase produksi AMDK
    public function persen()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;
        $data['title'] = 'Data Persentase Produksi AMDK';
        // kirim tahun ke model
        $data['data'] = $this->Model_produksi_amdk->getPersen($tahun);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/persen/view_persen', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_persen()
    {
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
                redirect('lembar_kerja/rkap_amdk/produksi/persen');
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
            redirect('lembar_kerja/rkap_amdk/produksi/persen');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/persen/upload_persen', $data);
        $this->load->view('templates/footer');
    }

    public function edit_persen($id_persentase)
    {
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
            redirect('lembar_kerja/rkap_amdk/produksi/persen');
        }
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/persen/edit_persen', $data);
        $this->load->view('templates/footer');
    }
    // akhir persentase produksi AMDK

    // Tarif AMDK
    public function tarif()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;
        $data['title'] = 'Daftar Tarif AMDK';
        // kirim tahun ke model
        $data['data'] = $this->Model_produksi_amdk->getTarif($tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/tarif/view_tarif', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/tarif/view_tarif', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }
    public function copy_tarif()
    {
        $tahun_baru = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $tahun_lama = $tahun_baru - 1;

        // ambil data tahun sebelumnya
        $data_lama = $this->Model_produksi_amdk->getTarif($tahun_lama);

        if (empty($data_lama)) {

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tahun sebelumnya tidak ditemukan!
            </div>'
            );
            redirect('lembar_kerja/rkap_amdk/produksi/tarif');
            return;
        }
        $insert = [];

        foreach ($data_lama as $row) {

            if ($this->Model_produksi_amdk->cek_tahun_tarif($tahun_baru) > 0) {

                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data tahun ini sudah pernah dicopy!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
                );
                redirect('lembar_kerja/rkap_amdk/produksi/tarif');
                return;
            }

            $insert[] = [
                'tarif'       => $row->tarif,
                'tahun_rkap'  => $tahun_baru,
                'status'      => 1,
                'status_update' => 1,
                'ptgs_upload' => $this->session->userdata('nama_lengkap'),
                'tgl_upload'  => date('Y-m-d H:i:s')
            ];
        }

        // simpan batch
        $this->Model_produksi_amdk->insert_batch_tarif($insert);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data tarif berhasil dicopy dari tahun ' . $tahun_lama . ' ke ' . $tahun_baru . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/rkap_amdk/produksi/tarif?tahun_rkap=' . $tahun_baru);
    }

    // public function edit_tarif($id_tarif)
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
    //     $data['tahun'] = $tahun;
    //     $data['title'] = 'Edit Tarif AMDK';
    //     $data['row']   = $this->Model_produksi_amdk->get_tarif_by_id($id_tarif);
    //     $data['tarif']  = $this->Model_produksi_amdk->get_tarif($tahun);

    //     if ($this->input->post()) {
    //         $data_update = [
    //             'tarif'         => $this->input->post('tarif'),
    //             'tahun_rkap'    => $this->input->post('tahun_rkap'),
    //             'ptgs_update'   => $this->session->userdata('nama_lengkap'),
    //             'tgl_update'    => date('Y-m-d H:i:s')
    //         ];

    //         $this->Model_produksi_amdk->update_tarif($id_tarif, $data_update);

    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 Data Tarif AMDK berhasil diperbarui!
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );

    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Berhasil!</strong> Data Tarif AMDK berhasil diperbarui!
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //         );
    //         redirect('lembar_kerja/rkap_amdk/produksi/tarif');
    //     }
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('lembar_kerja/rkap_amdk/tarif/edit_tarif', $data);
    //     $this->load->view('templates/footer');
    // }

    // {Produk amdk}
    public function produk()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $data['tahun'] = $tahun;
        $data['title'] = 'Daftar Produk AMDK';
        // kirim tahun ke model
        $data['data'] = $this->Model_produksi_amdk->getProduk($tahun);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/produk/view_produk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/produk/view_produk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function copy_produk()
    {
        $tahun_baru = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $tahun_lama = $tahun_baru - 1;

        // ambil data tahun sebelumnya
        $data_lama = $this->Model_produksi_amdk->getProduk($tahun_lama);

        if (empty($data_lama)) {

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tahun sebelumnya tidak ditemukan!
            </div>'
            );
            redirect('lembar_kerja/rkap_amdk/produksi/produk');
            return;
        }
        $insert = [];

        foreach ($data_lama as $row) {
            if ($this->Model_produksi_amdk->cek_tahun_produk($tahun_baru) > 0) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data tahun ini sudah pernah dicopy!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
                );
                redirect('lembar_kerja/rkap_amdk/produksi/produk');
                return;
            }

            $insert[] = [
                'nama_produk' => $row->nama_produk,
                'satuan'      => $row->satuan,
                'tahun_rkap'  => $tahun_baru,
                'status'      => 1,
                'status_update' => 1,
                'ptgs_upload' => $this->session->userdata('nama_lengkap'),
                'tgl_upload'  => date('Y-m-d H:i:s')
            ];
        }

        // simpan batch
        $this->Model_produksi_amdk->insert_batch_produk($insert);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data produk berhasil dicopy dari tahun ' . $tahun_lama . ' ke ' . $tahun_baru . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/rkap_amdk/produksi/produk?tahun_rkap=' . $tahun_baru);
    }
}
