<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_transaksi');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') != 'Admin') {
            redirect('publik');
        }
    }

    public function index()
    {

        $data['title'] = 'Daftar transaksi';
        $data['transaksi'] = $this->model_transaksi->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/view_transaksi', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        if (isset($_POST['tambah'])) {
            $tanggal = $this->input->post('tanggal');
            $tanggal = explode('-', $tanggal);
            $tahun = $tanggal[0];
            $bulan = $tanggal[1];
        }

        $data['title'] = 'Form Tambah Transaksi';
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|trim');
        $this->form_validation->set_rules('uraian', 'Uraian', 'required|trim');
        $this->form_validation->set_rules('rupiah', 'Rupiah', 'required|trim|integer');
        $this->form_validation->set_rules('jenis_transaksi', 'Jenis Transaksi', 'required|trim');
        $this->form_validation->set_rules('jenis_donasi', 'Jenis Donasi', 'required|trim');
        // $this->form_validation->set_rules('kode_saldo', 'Kode Saldo', 'required|trim');
        $this->form_validation->set_message('required', '%s Harus di isi');
        $this->form_validation->set_message('integer', '%s Harus berupa angka');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('transaksi/view_TransaksiTambah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data Transaksi Berhasil di simpan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            $data['transaksi'] = $this->model_transaksi->tambahData('keuangan');
            $alamat = 'transaksi?bulan=' . $bulan . '&tahun=' . $tahun . '&add_post=';
            redirect($alamat);
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Form Edit Transaksi';
        $data['transaksi'] = $this->model_transaksi->getIdtransaksi($id, 'keuangan');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('transaksi/view_TransaksiEdit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        if (isset($_POST['tambah'])) {
            $tanggal = $this->input->post('tanggal');
            $tanggal = explode('-', $tanggal);
            $tahun = $tanggal[0];
            $bulan = $tanggal[1];
        }
        $this->model_transaksi->updateData('keuangan');
        $alamat = 'transaksi?bulan=' . $bulan . '&tahun=' . $tahun . '&add_post=';
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Maaf,</strong> tidak ada perubahan data
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                </div>'
            );
            redirect($alamat);
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data Transaksi berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            redirect($alamat);
        }
    }

    public function hapus($id)
    {
        $this->model_transaksi->hapusData($id, 'keuangan');
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> Data transaksi berhasil di hapus
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>'
        );
        redirect('transaksi');
    }

    // public function ambilSaldo()
    // {
    //     if (isset($_POST['tanggalPilih'])) {
    //         $bulanskrng = $this->input->post('bulan', true);
    //         $tahun = $this->input->post('tahun', true);
    //         if($bulanskrng == 1){
    //             $bulanLalu = 12;
    //             $tahun = $tahun - 1;
    //         }else{
    //             $bulanLalu = $bulanskrng - 1;
    //             $tahun = $this->input->post('tahun', true);
    //         }

    //      } 

    //     $bulanSaldo = date('m');
    //     $tahunSaldo = date('Y');

    //     $this->db->select('sum(rupiah) as masuk');
    //     $this->db->from('keuangan');
    //     $this->db->where('MONTH(tanggal)', $bulanLalu);
    //     $this->db->where('YEAR(tanggal)', $tahun);
    //     $this->db->where('jenis_transaksi', 'penerimaan');
    //     $masuk = $this->db->get()->result();
    //     foreach ($masuk as $row) {
    //         $masuk = $row->masuk;
    //     }
    //     $this->db->select('sum(rupiah) as keluar');
    //     $this->db->from('keuangan');
    //     $this->db->where('MONTH(tanggal)', $bulanLalu);
    //     $this->db->where('YEAR(tanggal)', $tahun);
    //     $this->db->where('jenis_transaksi', 'pengeluaran');
    //     $keluar = $this->db->get()->result();
    //     foreach ($keluar as $row) {
    //         $keluar = $row->keluar;
    //     }
    //     $saldo = $masuk - $keluar;

    //     $bulanDB = $this->model_transaksi->getSaldo();
    //     foreach($bulanDB as $row){
    //         $bulanDB = $row->rupiah;
    //     }

    //     if ($saldo == $bulanDB){

    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //             <strong>Maaf,</strong> Saldo Awal Sudah ditambahkan
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //             </button>
    //           </div>'
    //         );
    //         redirect('transaksi');
    //     }else {
    //         $data = [
    //             "tanggal" => $tahunSaldo.'-'.$bulanSaldo.'-'.'01',
    //             "uraian" => 'Saldo Awal',
    //             "rupiah" => $saldo,
    //             "jenis_transaksi" => 'penerimaan',
    //             "jenis_donasi" => 'umum',
    //             "kode_saldo" => 1,
    //         ];
    //         $this->db->insert("keuangan", $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //             <strong>Sukses,</strong> Saldo berhasil ditambahkan
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //             </button>
    //           </div>'
    //         );
    //         redirect('transaksi');
    //     }
    // }

    public function ambilSaldoAwal()
    {
        $bulanskrng = date('m');
        if ($bulanskrng < 10) {
            $bulanskrng = str_split($bulanskrng)[1];
        }
        $tahun = date('Y');

        if ($bulanskrng == 1) {
            $bulanLalu = 12;
            $tahun = $tahun - 1;
        } else {
            $bulanLalu = $bulanskrng - 1;
            $tahun = date('Y');
        }

        $bulanSaldo = date('m');
        $tahunSaldo = date('Y');

        $this->db->select('sum(rupiah) as masuk');
        $this->db->from('keuangan');
        $this->db->where('MONTH(tanggal)', $bulanLalu);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('jenis_transaksi', 'penerimaan');
        $masuk = $this->db->get()->result();
        foreach ($masuk as $row) {
            $masuk = $row->masuk;
        }
        $this->db->select('sum(rupiah) as keluar');
        $this->db->from('keuangan');
        $this->db->where('MONTH(tanggal)', $bulanLalu);
        $this->db->where('YEAR(tanggal)', $tahun);
        $this->db->where('jenis_transaksi', 'pengeluaran');
        $keluar = $this->db->get()->result();
        foreach ($keluar as $row) {
            $keluar = $row->keluar;
        }
        $saldo = $masuk - $keluar;

        $bulanDB = $this->model_transaksi->getSaldo();
        foreach ($bulanDB as $row) {
            $bulanDB = $row->rupiah;
        }

        $tampilBulan = date('m');
        switch ($tampilBulan) {
            case '01':
                $tampilBulan = "Januari";
                break;
            case '02':
                $tampilBulan = "Februari";
                break;
            case '03':
                $tampilBulan = "Maret";
                break;
            case '04':
                $tampilBulan = "April";
                break;
            case '05':
                $tampilBulan = "Mei";
                break;
            case '06':
                $tampilBulan = "Juni";
                break;
            case '07':
                $tampilBulan = "Juli";
                break;
            case '08':
                $tampilBulan = "Agustus";
                break;
            case '09':
                $tampilBulan = "September";
                break;
            case '10':
                $tampilBulan = "Oktober";
                break;
            case '11':
                $tampilBulan = "November";
                break;
            case '12':
                $tampilBulan = "Desember";
                break;
        }
        $tampilTahun = date('Y');

        if ($saldo == $bulanDB) {

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Maaf,</strong> Saldo Awal Sudah ditambahkan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            redirect('transaksi');
        } else {
            $data = [
                "tanggal" => $tahunSaldo . '-' . $bulanSaldo . '-' . '01',
                "uraian" => 'Saldo Awal ' . $tampilBulan . ' ' . $tampilTahun,
                "rupiah" => $saldo,
                "jenis_transaksi" => 'penerimaan',
                "jenis_donasi" => 'umum',
                "kode_saldo" => 1,
            ];
            $this->db->insert("keuangan", $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Saldo berhasil ditambahkan
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            redirect('transaksi');
        }
    }
}
