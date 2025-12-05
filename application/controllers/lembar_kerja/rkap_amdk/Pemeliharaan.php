<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemeliharaan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_amdk_pemeliharaan');
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

        $data['pemeliharaan'] = $this->Model_amdk_pemeliharaan->get_pemeliharaan($tahun);
        $data['title'] = 'RENCANA KEBUTUHAN BAHAN PEMELIHARAAN UNIT AMDK <br> TAHUN ANGGARAN ';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/pemeliharaan/view_pemeliharaan', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $data['tahun'] = $tahun;

        $data['pemeliharaan'] = $this->Model_amdk_pemeliharaan->get_pemeliharaan($tahun);
        $data['title'] = 'RENCANA KEBUTUHAN BAHAN PEMELIHARAAN UNIT AMDK <br> TAHUN ANGGARAN ';

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_pemeliharaan_amdk_{$tahun}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/rkap_amdk/pemeliharaan/laporan_pdf', $data);
    }

    public function tambah()
    {

        if ($this->input->post()) {
            $tahun_rkap = $this->session->userdata('tahun_rkap');
            $jenis = $this->input->post('jenis');
            $kategori = $this->input->post('kategori');
            $uraian = $this->input->post('uraian');
            $volume =  $this->input->post('volume');
            $harga =  $this->input->post('harga');

            // Hitung total tahun (volume * harga)
            $total_tahun = $volume * $harga;
            $per_bulan = $total_tahun / 12;

            $data = [
                'tahun_rkap'    => $tahun_rkap,
                'jenis'    => $jenis,
                'kategori'    => $kategori,
                'uraian'    => $uraian,
                'volume'        => $volume,
                'harga'        => $harga,
                'total_tahun'   => $total_tahun,
                'per_bulan'     => $per_bulan,
                'ptgs_upload'   => $this->session->userdata('nama_lengkap'),
            ];

            // Simpan ke database
            $this->Model_amdk_pemeliharaan->insert_or_update($data);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data Biaya Pemeliharaan AMDK berhasil ditambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );

            redirect('lembar_kerja/rkap_amdk/pemeliharaan?tahun_rkap=' . $tahun);
        } else {
            $data['title'] = 'Input Biaya Pemeliharaan AMDK';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('lembar_kerja/rkap_amdk/pemeliharaan/upload_pemeliharaan', $data);
            $this->load->view('templates/footer');
        }
    }


    // public function generate()
    // {
    //     $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
    //     $no_per_id = '98.02.04.08';
    //     $id_upk = 23;
    //     $cabang_id = 13;

    //     // Ganti variabel ini
    //     $this->db->select_sum('per_bulan');
    //     $this->db->where('tahun_rkap', $tahun); // <- perbaikan di sini
    //     $total_per_bulan = $this->db->get('rkap_amdk_pemeliharaan')->row()->per_bulan ?? 0;

    //     if (!$total_per_bulan) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             Belum ada data biaya pemeliharaan untuk tahun ini.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //         );
    //         redirect('lembar_kerja/rkap_amdk/pemeliharaan?tahun_rkap=' . $tahun);
    //         return;
    //     }

    //     // Hitung nilai per bulan
    //     $nilai_per_bulan = $total_per_bulan;

    //     for ($bulan = 1; $bulan <= 12; $bulan++) {
    //         $tanggal_bulan = date('Y-m-d', strtotime("$tahun-$bulan-01"));

    //         $data_insert = [
    //             'id_upk'     => $id_upk,
    //             'cabang_id'  => $cabang_id,
    //             'no_per_id'  => $no_per_id,
    //             'bulan'      => $tanggal_bulan,
    //             'pagu'       => $nilai_per_bulan,
    //         ];

    //         // cek jika sudah ada, update; jika belum, insert
    //         $cek = $this->db->get_where('rkap_rekap', [
    //             'id_upk' => $id_upk,
    //             'cabang_id' => $cabang_id,
    //             'no_per_id' => $no_per_id,
    //             'bulan' => $tanggal_bulan
    //         ])->row();

    //         if ($cek) {
    //             $this->db->where('id', $cek->id);
    //             $this->db->update('rkap_rekap', $data_insert);
    //         } else {
    //             $this->db->insert('rkap_rekap', $data_insert);
    //         }
    //     }

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //         Biaya Pemeliharaan berhasil digenerate ke Aplikasi Cetet.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>'
    //     );
    //     redirect('lembar_kerja/rkap_amdk/pemeliharaan?tahun_rkap=' . $tahun);
    // }

    public function generate()
    {
        $tahun = $this->input->get('tahun_rkap') ?: (date('Y') + 1);
        $no_per_id = '98.02.04.02';
        $cabang_id = 13;

        // Ganti variabel ini
        $this->db->select_sum('per_bulan');
        $this->db->where('tahun_rkap', $tahun); // <- perbaikan di sini
        $total_per_bulan = $this->db->get('rkap_amdk_pemeliharaan')->row()->per_bulan ?? 0;

        if (!$total_per_bulan) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Belum ada data biaya pemeliharaan untuk tahun ini.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/rkap_amdk/pemeliharaan?tahun_rkap=' . $tahun);
            return;
        }

        // Hitung nilai per bulan
        $nilai_per_bulan = $total_per_bulan;

        // variabel untuk mendeteksi aksi apa saja yang terjadi
        $ada_insert = false;
        $ada_update = false;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $tanggal_bulan = date('Y-m-d', strtotime("$tahun-$bulan-01"));

            $data_insert = [
                'cabang_id'  => $cabang_id,
                'no_per_id'  => $no_per_id,
                'bulan'      => $tanggal_bulan,
                'pagu'       => $nilai_per_bulan,
            ];

            // cek apakah data bulan ini sudah ada
            $cek = $this->db->get_where('rkap_amdk_biaya', [
                'cabang_id' => $cabang_id,
                'no_per_id' => $no_per_id,
                'bulan'     => $tanggal_bulan
            ])->row();

            if ($cek) {
                // data sudah ada -> update
                $data_insert['ptgs_update'] = $this->session->userdata('nama_lengkap');

                $this->db->where('cabang_id', $cek->cabang_id);
                $this->db->where('no_per_id', $cek->no_per_id);
                $this->db->where('bulan', $cek->bulan);
                $this->db->update('rkap_amdk_biaya', $data_insert);

                $ada_update = true;
            } else {
                // data belum ada -> insert baru
                $data_insert['ptgs_upload'] = $this->session->userdata('nama_lengkap');
                $this->db->insert('rkap_amdk_biaya', $data_insert);

                $ada_insert = true;
            }
        }
        // setelah semua bulan diproses, tentukan pesan yang tepat
        if ($ada_insert && $ada_update) {
            $pesan = '<div class="alert alert-info alert-dismissible fade show" role="alert">
        Sebagian data Biaya Pemeliharaan berhasil <b>diperbarui</b> dan sebagian <b>digenerate baru</b> ke Biaya AMDK.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        } elseif ($ada_insert) {
            $pesan = '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        Biaya Pemeliharaan berhasil <b>digenerate baru</b> ke Biaya AMDK untuk semua bulan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        } elseif ($ada_update) {
            $pesan = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        Biaya Pemeliharaan berhasil <b>diperbarui</b> di Biaya AMDK untuk semua bulan.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        } else {
            $pesan = '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
        Tidak ada perubahan data Biaya AMDK.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }

        $this->session->set_flashdata('info', $pesan);
        redirect('lembar_kerja/rkap_amdk/pemeliharaan?tahun_rkap=' . $tahun);
    }
}
