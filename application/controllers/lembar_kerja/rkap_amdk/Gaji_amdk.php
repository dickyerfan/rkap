<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_amdk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_investasi');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $upk = 13;
        $this->session->set_userdata('tahun_rkap', $tahun);
        $this->session->set_userdata('upk', $upk);

        $title = "RENCANA BIAYA TENAGA KERJA AMDK <br> TAHUN ANGGARAN ";
        $data['biaya'] = $this->Model_investasi->get_investasi_amdk($tahun, $upk);

        $data['title'] = $title;
        $data['tahun'] = $tahun;
        $data['upk'] = $upk;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/rkap_amdk/gaji_amdk/view_gaji', $data);
        $this->load->view('templates/footer');
    }

    // public function export_pdf()
    // {

    //     $tahun = $this->session->userdata('tahun_rkap');
    //     $upk = $this->session->userdata('upk');

    //     $title = "RENCANA PENGELUARAN INVESTASI AMDK <br> TAHUN ANGGARAN ";
    //     $data['biaya'] = $this->Model_investasi->get_investasi_amdk($tahun, $upk);

    //     $data['title'] = $title;
    //     $data['tahun'] = $tahun;
    //     $data['upk'] = $upk;

    //     // Setting PDF
    //     $this->pdf->setPaper('Folio', 'landscape');
    //     $this->pdf->filename = "Lap_investasi_{$tahun}.pdf";

    //     // Generate dari view khusus PDF
    //     $this->pdf->generate('lembar_kerja/rkap_amdk/investasi/laporan_pdf', $data);
    // }

    // public function tambah()
    // {
    //     // Pindahkan mapping UPK ke sini agar bisa dipakai di form
    //     $mapping_upk = [
    //         '13' => 'AMDK'
    //     ];

    //     if ($this->input->post()) {
    //         $tahun_rkap = $this->session->userdata('tahun_rkap');
    //         // $cabang_id  = $this->input->post('cabang_id'); // Ini array
    //         $no_per_id  = $this->input->post('no_per_id'); // Ini array
    //         $bulan_dipilih = $this->input->post('bulan');
    //         $vol        = $this->input->post('vol');        // Ini array
    //         $sat        = $this->input->post('sat');        // Ini array
    //         $pagu      = $this->input->post('pagu');      // Ini array
    //         // $harga      = $this->input->post('harga');      // Ini array
    //         $uraian     = $this->input->post('uraian');    // Ini array

    //         // Jika user tidak memilih bulan, anggap otomatis semua bulan
    //         if (empty($bulan_dipilih)) {
    //             $bulan_dipilih = range(1, 12);
    //         }

    //         $data = [];

    //         // Loop berdasarkan no_per_id (yang seharusnya punya jumlah index yg sama dgn input lain)
    //         foreach ($no_per_id as $key => $value) {
    //             // Pastikan ada data di key ini, skip jika tidak (misal form kosong)
    //             if (!isset($value) || empty($value)) {
    //                 continue;
    //             }

    //             foreach ($bulan_dipilih as $bulan) {
    //                 // Ambil harga dari string (mis '1.000.000') dan ubah jadi angka
    //                 // $harga_clean = preg_replace("/[^0-9]/", "", $harga[$key]);
    //                 // $vol_clean = preg_replace("/[^0-9]/", "", $vol[$key]);
    //                 // $nilai_pagu = (float)$vol_clean * (float)$harga_clean;
    //                 $pagu_clean = preg_replace("/[^0-9]/", "", $pagu[$key]);

    //                 $data[] = [
    //                     'cabang_id'    => 13,
    //                     'no_per_id'    => $value,
    //                     'uraian'       => $uraian[$key],
    //                     'bulan'        => sprintf('%s-%02d-01', $tahun_rkap, $bulan),
    //                     'vol'          => $vol[$key],
    //                     'sat'          => $sat[$key],
    //                     // 'harga'        => $harga_clean,
    //                     'pagu'         => $pagu_clean,
    //                     'ptgs_upload'  => $this->session->userdata('nama_lengkap'),
    //                 ];
    //             }
    //         }

    //         // Cek jika $data kosong (misal form tidak diisi)
    //         if (empty($data)) {
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Gagal!</strong> Tidak ada data untuk disimpan.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //             );
    //             redirect('lembar_kerja/rkap_amdk/investasi/tambah');
    //             return;
    //         }

    //         $result = $this->Model_investasi->insert_or_update_amdk($data);

    //         // 🔔 Notifikasi insert/update (Kode Anda sudah OK)
    //         if ($result['inserted'] > 0 && $result['updated'] == 0) {
    //         }

    //         $this->session->set_flashdata('info', $pesan);

    //         // PERBAIKAN REDIRECT: Ambil $upk dari data pertama yg diinput
    //         $upk_redirect = $cabang_id[0] ?? 'all';
    //         redirect('lembar_kerja/rkap_amdk/investasi_amdk?upk=' . $upk_redirect . '&tahun_rkap=' . $tahun_rkap);
    //     } else {
    //         $data['title'] = 'Input Investasi AMDK';

    //         // Ambil data Akun
    //         $this->db->group_start()
    //             ->like('kode', '31.', 'after')
    //             ->or_like('kode', '42.', 'after')
    //             ->group_end()
    //             ->where('cab_id', 13)
    //             ->order_by('kode', 'ASC');

    //         $data['no_per_id'] = $this->db->get('no_per')->result();


    //         // TAMBAHAN: Kirim data mapping UPK ke view
    //         $data['mapping_upk'] = $mapping_upk;

    //         // TAMBAHAN: Kirim data Satuan ke view
    //         $data['satuan_list'] = ['unit', 'meter', 'buah', 'set', 'sak', 'm2', 'm3', 'ls'];

    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('lembar_kerja/rkap_amdk/investasi/upload_investasi', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    // public function edit($cabang_id, $no_per_id, $uraian_encoded)
    // {
    //     $uraian = base64_decode($uraian_encoded);
    //     // Pemetaan nama UPK
    //     $mapping_upk = [
    //         '13' => 'AMDK'
    //     ];

    //     // 🟢 1. Jika form disubmit (POST)
    //     if ($this->input->post()) {
    //         $post = $this->input->post();
    //         $data_update = [];
    //         $total_updated = 0;

    //         $tahun_rkap = $this->session->userdata('tahun_rkap');
    //         $nama_petugas = $this->session->userdata('nama_lengkap');

    //         // Header data baru dari form
    //         $new_no_per_id = $post['no_per_id'];
    //         $new_uraian    = $post['uraian'];
    //         $new_cabang_id = 13;

    //         // Bersihkan nilai pagu (pastikan float)
    //         $new_pagu_clean = preg_replace("/[^0-9]/", "", $post['pagu']);
    //         $new_pagu_clean = (float)$new_pagu_clean;

    //         // Loop semua bulan yang dikirim dari form
    //         foreach ($post['id_inves'] as $key => $id_inves) {
    //             $vol_clean = preg_replace("/[^0-9]/", "", $post['vol'][$key]);
    //             $vol_clean = (float)$vol_clean;

    //             // Catatan: variabel $nilai_pagu sebelumnya tidak didefinisikan
    //             // jadi kita hapus saja syarat itu agar update tetap jalan
    //             if ($id_inves) {
    //                 $data_update[] = [
    //                     'id_inves'      => $id_inves,
    //                     'cabang_id'     => $new_cabang_id,
    //                     'no_per_id'     => $new_no_per_id,
    //                     'uraian'        => $new_uraian,
    //                     'vol'           => $vol_clean,
    //                     'sat'           => $post['sat'],
    //                     'pagu'          => $new_pagu_clean,
    //                     'ptgs_update'   => $nama_petugas,
    //                     'tgl_update'    => date('Y-m-d H:i:s')
    //                 ];
    //             }
    //         }

    //         // Jalankan update batch via Model
    //         if (!empty($data_update)) {
    //             $result = $this->Model_investasi->update_batch_investasi_amdk($data_update);
    //             $total_updated = $result;
    //         }

    //         // Pesan sukses
    //         $pesan = '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //         <strong>Sukses!</strong> ' . $total_updated . ' data bulanan berhasil diperbarui.
    //         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     </div>';
    //         $this->session->set_flashdata('info', $pesan);

    //         // Redirect ke halaman utama
    //         $upk_redirect = $post['cabang_id_utama'] ?? 'all';
    //         redirect('lembar_kerja/rkap_amdk/investasi_amdk?upk=' . $upk_redirect . '&tahun_rkap=' . $tahun_rkap);
    //     }

    //     // 🟢 2. Jika tidak ada POST (tampilkan form edit)
    //     else {
    //         if (!$cabang_id || !$no_per_id || !$uraian) {
    //             show_error('Parameter tidak lengkap untuk mengedit data.');
    //             return;
    //         }

    //         $uraian = urldecode($uraian);

    //         // Ambil data dari model
    //         $data_edit = $this->Model_investasi->get_data_to_edit_amdk($cabang_id, $no_per_id, $uraian);

    //         if (empty($data_edit)) {
    //             show_error('Data investasi tidak ditemukan.');
    //             return;
    //         }

    //         // Siapkan data untuk view
    //         $data['title']        = 'Edit Investasi';
    //         $data['data_edit']    = $data_edit;
    //         $data['mapping_upk']  = $mapping_upk;
    //         $data['satuan_list']  = ['unit', 'meter', 'buah', 'set', 'sak', 'm2', 'm3', 'ls'];
    //         $data['nama_bulan']   = [
    //             1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    //             5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    //             9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    //         ];

    //         // Ambil daftar kode perkiraan untuk dropdown
    //         $this->db->group_start()
    //             ->like('kode', '31.', 'after')
    //             ->or_like('kode', '42.', 'after')
    //             ->group_end()
    //             ->where('cab_id', 13)
    //             ->order_by('kode', 'ASC');

    //         $data['no_per_id'] = $this->db->get('no_per')->result();

    //         // Load view lengkap
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('lembar_kerja/rkap_amdk/investasi/edit_investasi', $data);
    //         $this->load->view('templates/footer');
    //     }
    // }

    // public function generate()
    // {
    //     $tahun = $this->session->userdata('tahun_rkap') ?: date('Y') + 1;

    //     // Ambil data dari model (sama seperti di index)
    //     $data = $this->Model_investasi->get_investasi_amdk($tahun, '13');

    //     // Inisialisasi grand total
    //     $grand_total = [
    //         'jan' => 0, 'feb' => 0, 'mar' => 0, 'apr' => 0, 'mei' => 0, 'jun' => 0,
    //         'jul' => 0, 'agu' => 0, 'sep' => 0, 'okt' => 0, 'nov' => 0, 'des' => 0,
    //     ];

    //     // Loop semua parent → children untuk menghitung grand total
    //     foreach ($data as $parent) {
    //         if (!empty($parent['children'])) {
    //             foreach ($parent['children'] as $c) {
    //                 foreach ($grand_total as $bulan => $_) {
    //                     if (isset($c[$bulan])) {
    //                         $grand_total[$bulan] += $c[$bulan];
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Mapping bulan ke format tanggal
    //     $bulan_map = [
    //         'jan' => '01', 'feb' => '02', 'mar' => '03', 'apr' => '04', 'mei' => '05', 'jun' => '06',
    //         'jul' => '07', 'agu' => '08', 'sep' => '09', 'okt' => '10', 'nov' => '11', 'des' => '12'
    //     ];

    //     // Hapus data sebelumnya (opsional jika ingin replace)
    //     $this->db->where('no_per_id', 31);
    //     $this->db->where('YEAR(bulan)', $tahun);
    //     $this->db->delete('rkap_amdk_arus_kas');

    //     // Insert data baru ke tabel rkap_arus_kas
    //     foreach ($bulan_map as $key => $num) {
    //         $record = [
    //             'no_per_id' => 31,
    //             'bulan'     => "{$tahun}-{$num}-01",
    //             'pagu'      => $grand_total[$key] ?? 0

    //         ];
    //         $this->db->insert('rkap_amdk_arus_kas', $record);
    //     }

    //     // Redirect kembali ke halaman investasi dengan pesan sukses
    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             <strong>Berhasil!</strong> Data Investasi AMDK berhasil digenerate ke Arus Kas AMDK.
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>'
    //     );
    //     redirect('lembar_kerja/rkap_amdk/investasi_amdk');
    // }
}
