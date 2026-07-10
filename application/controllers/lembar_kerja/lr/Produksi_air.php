<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi_air extends MY_Controller
// class di ganti mengambil dari MY_Controller letaknya di application/core
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_produksi_air');
        $this->load->model('Model_pendapatan_air');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $result = $this->Model_produksi_air->getDataProduksiAir($tahun, $upk);

        $data['air_terjual'] = $result['air_terjual'];
        $data['air_produksi'] = $result['air_produksi'];
        $nama_upk = $result['nama_upk'];

        if ($upk) {
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR UPK ' . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
        } else {
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/produksi_air/view_produksi_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        // Ambil dari session, bukan dari post
        $upk   = $this->session->userdata('upk');
        $tahun = $this->session->userdata('tahun_rkap');

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();

        // simpan ke session utk keperluan export PDF
        $this->session->set_userdata('upk', $upk);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $result = $this->Model_produksi_air->getDataProduksiAir($tahun, $upk);

        $data['air_terjual'] = $result['air_terjual'];
        $data['air_produksi'] = $result['air_produksi'];
        $nama_upk = $result['nama_upk'];

        if ($upk) {
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR UPK ' . strtoupper($nama_upk) . ' <br> TAHUN ANGGARAN ';
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun, $upk);
        } else {
            $data['result'] = $this->Model_pendapatan_air->getDataPendapatanAir($tahun);
            $data['title'] = 'RENCANA PRODUKSI DAN PENJUALAN AIR (KONSOLIDASI) <br> TAHUN ANGGARAN ';
        }

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_produksi_air_{$tahun}_" . ($upk ?: 'Konsolidasi') . ".pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/lr/produksi_air/laporan_pdf', $data);
    }

    public function data_sumber()
    {
        $upk = $this->input->get('upk');
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Data Sumber';
        $data['sumber'] = $this->Model_produksi_air->getDataSumber($tahun, $upk);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/produksi_air/view_data_sumber', $data);
        $this->load->view('templates/footer');
    }

    public function input()
    {
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Tambah Data Biaya Listrik Sumber';

        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        $this->form_validation->set_rules('id_upk', 'UPK', 'required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/upload_data_sumber', $data);
            $this->load->view('templates/footer');
        } else {
            $insert_data = [
                'id_upk' => $this->input->post('id_upk'),
                'uraian' => $this->input->post('uraian'),
                'nilai'  => $this->input->post('nilai'),
                'tahun'  => $this->input->post('tahun'),
            ];
            $this->db->insert('rkap_sumber', $insert_data);
            $this->session->set_flashdata(
                'info',
                '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Data Pemakaian Listrik Sumber berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
        }
    }

    public function copy_data()
    {
        $tahun_baru = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $tahun_lama = $tahun_baru - 1;

        // ambil data tahun sebelumnya
        $data_lama = $this->Model_produksi_air->getSumber($tahun_lama);

        if (empty($data_lama)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tahun sebelumnya tidak ditemukan!
            </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
            return;
        }

        // kelompokkan per UPK
        $per_upk = [];
        foreach ($data_lama as $row) {
            $per_upk[$row->id_upk][] = $row;
        }

        $insert = [];
        $multi_upk_count = 0;

        foreach ($per_upk as $id_upk => $rows) {
            // hanya copy untuk UPK multi-sumber
            if (count($rows) <= 1) continue;

            // cek apakah UPK ini sudah punya data di tahun baru
            $this->db->where('tahun', $tahun_baru);
            $this->db->where('id_upk', $id_upk);
            $sudah_ada = $this->db->count_all_results('rkap_sumber');

            if ($sudah_ada > 0) continue;

            $multi_upk_count++;
            foreach ($rows as $row) {
                $insert[] = [
                    'uraian'       => $row->uraian,
                    'id_upk'       => $row->id_upk,
                    'nilai'        => 0,
                    'tahun'        => $tahun_baru,
                    'status'       => 1,
                    'status_update' => 1,
                    'ptgs_upload' => $this->session->userdata('nama_lengkap'),
                    'tgl_upload'  => date('Y-m-d H:i:s')
                ];
            }
        }

        if (empty($insert)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                Tidak ada UPK multi-sumber yang perlu dicopy. Data mungkin sudah ada.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
            return;
        }

        // simpan batch
        $this->Model_produksi_air->insert_batch_sumber($insert);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data ' . count($insert) . ' sumber untuk ' . $multi_upk_count . ' UPK multi-sumber berhasil dicopy dari tahun ' . $tahun_lama . ' ke ' . $tahun_baru . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/lr/produksi_air/data_sumber?tahun_rkap=' . $tahun_baru);
    }

    public function generate_sumber()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

        $data_air = $this->Model_produksi_air->getTotalAirTerjual($tahun);

        if (empty($data_air)) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data pelanggan atau pola konsumsi untuk tahun ' . $tahun . ' belum tersedia.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('lembar_kerja/lr/produksi_air/data_sumber?tahun_rkap=' . $tahun);
            return;
        }

        $efisiensi = $this->Model_produksi_air->getEfisiensi($tahun);
        $insert_count = 0;
        $update_count = 0;
        $skip_count = 0;

        foreach ($data_air as $row) {
            $id_upk = $row['id_upk'];
            $total_air_terjual = (float)$row['total_air_terjual'];

            if ($total_air_terjual <= 0) continue;

            $total_air_produksi = round($total_air_terjual * 100 / $efisiensi, 2);

            $count = $this->Model_produksi_air->countSumber($tahun, $id_upk);

            if ($count == 0) {
                $this->db->insert('rkap_sumber', [
                    'id_upk'       => $id_upk,
                    'tahun'        => $tahun,
                    'uraian'       => $row['nama_upk'],
                    'nilai'        => $total_air_produksi,
                    'status'       => 1,
                    'status_update' => 1,
                    'ptgs_upload'  => $this->session->userdata('nama_lengkap'),
                    'tgl_upload'   => date('Y-m-d H:i:s')
                ]);
                $insert_count++;
            } elseif ($count == 1) {
                $this->db->where('id_upk', $id_upk);
                $this->db->where('tahun', $tahun);
                $this->db->update('rkap_sumber', [
                    'nilai'       => $total_air_produksi,
                    'ptgs_update' => $this->session->userdata('nama_lengkap'),
                ]);
                $update_count++;
            } else {
                $skip_count++;
            }
        }

        $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> Generate selesai. Insert: ' . $insert_count . ', Update: ' . $update_count . ', Skip (multi-sumber): ' . $skip_count . '.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        $this->session->set_flashdata('info', $msg);
        redirect('lembar_kerja/lr/produksi_air/data_sumber?tahun_rkap=' . $tahun);
    }

    public function edit_sumber($id_sb)
    {
        $data['sumber'] = $this->db->get_where('rkap_sumber', ['id_sb' => $id_sb])->row_array();
        $this->db->where('status', 1);
        $data['list_upk'] = $this->db->get('rkap_nama_upk')->result();
        $data['title'] = 'Edit Data Biaya Listrik Sumber';

        $this->form_validation->set_rules('uraian', 'Uraian', 'required');
        $this->form_validation->set_rules('nilai', 'Nilai', 'required|numeric');
        $this->form_validation->set_rules('id_upk', 'UPK', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/edit_data_sumber', $data);
            $this->load->view('templates/footer');
        } else {
            $update_data = [
                'id_upk' => $this->input->post('id_upk'),
                'uraian' => $this->input->post('uraian'),
                'nilai'  => $this->input->post('nilai'),
                'ptgs_update' => $this->session->userdata('nama_lengkap')
            ];
            $this->db->where('id_sb', $id_sb);
            $this->db->update('rkap_sumber', $update_data);
            $this->session->set_flashdata(
                'info',
                '
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Sukses !!</strong> Data Pemakaian Listrik Sumber berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
            );
            redirect('lembar_kerja/lr/produksi_air/data_sumber');
        }
    }

    public function data_efisiensi()
    {
        $data['title'] = 'Data Efisiensi Air Produksi';
        $data['efisiensi'] = $this->Model_produksi_air->getAllEfisiensi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/lr/produksi_air/view_data_efisiensi', $data);
        $this->load->view('templates/footer');
    }

    public function input_efisiensi()
    {
        $data['title'] = 'Tambah Data Efisiensi';

        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');
        $this->form_validation->set_rules('efisiensi', 'Efisiensi', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/input_efisiensi', $data);
            $this->load->view('templates/footer');
        } else {
            $tahun = $this->input->post('tahun');
            if ($this->Model_produksi_air->cekTahunEfisiensi($tahun) > 0) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data efisiensi untuk tahun ' . $tahun . ' sudah ada.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect('lembar_kerja/lr/produksi_air/data_efisiensi');
                return;
            }
            $insert_data = [
                'tahun'       => $tahun,
                'efisiensi'   => $this->input->post('efisiensi'),
                'keterangan'  => $this->input->post('keterangan'),
                'ptgs_upload' => $this->session->userdata('nama_lengkap'),
            ];
            $this->Model_produksi_air->insertEfisiensi($insert_data);
            $this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Sukses!!</strong> Data efisiensi berhasil ditambahkan.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('lembar_kerja/lr/produksi_air/data_efisiensi');
        }
    }

    public function edit_efisiensi($id)
    {
        $data['efisiensi'] = $this->Model_produksi_air->getEfisiensiById($id);
        $data['title'] = 'Edit Data Efisiensi';

        $this->form_validation->set_rules('efisiensi', 'Efisiensi', 'required|numeric');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/lr/produksi_air/edit_efisiensi', $data);
            $this->load->view('templates/footer');
        } else {
            $tahun = $this->input->post('tahun');
            if ($this->Model_produksi_air->cekTahunEfisiensi($tahun, $id) > 0) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Gagal!</strong> Data efisiensi untuk tahun ' . $tahun . ' sudah ada.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                redirect('lembar_kerja/lr/produksi_air/data_efisiensi');
                return;
            }
            $update_data = [
                'tahun'       => $tahun,
                'efisiensi'   => $this->input->post('efisiensi'),
                'keterangan'  => $this->input->post('keterangan'),
                'ptgs_update' => $this->session->userdata('nama_lengkap'),
            ];
            $this->Model_produksi_air->updateEfisiensi($id, $update_data);
            $this->session->set_flashdata('info', '<div class="alert alert-primary alert-dismissible fade show" role="alert"><strong>Sukses!!</strong> Data efisiensi berhasil diperbarui.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
            redirect('lembar_kerja/lr/produksi_air/data_efisiensi');
        }
    }

    public function delete_efisiensi($id)
    {
        $this->Model_produksi_air->deleteEfisiensi($id);
        $this->session->set_flashdata('info', '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Dihapus!</strong> Data efisiensi berhasil dihapus.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        redirect('lembar_kerja/lr/produksi_air/data_efisiensi');
    }
}
