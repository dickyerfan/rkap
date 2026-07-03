<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usulan_inves extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_usulan_inves');
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

        // Simpan ke session
        $this->session->set_userdata('bagian_upk', $bagian_upk ?: 'SEMUA');
        $this->session->set_userdata('tahun_rkap', $tahun_rkap);

        $data['tampil'] = $this->Model_usulan_inves->getFiltered($bagian_upk, $tahun_rkap);
        $data['bagian_upk'] = $bagian_upk;
        $data['tahun'] = $tahun_rkap;
        $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
        $data['namaUpk'] = $bagian_upk ? $bagian_upk : 'SEMUA';
        $data['is_locked'] = $is_locked;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_inves/view_usulan_investasi', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {
        $dataUpk   = $this->session->userdata('bagian_upk');
        $dataTahun = $this->session->userdata('tahun_rkap') ?: date('Y');

        // Cukup satu panggilan
        $data['tampil']  = $this->Model_usulan_inves->getFiltered($dataUpk, $dataTahun);
        $data['namaUpk'] = (empty($dataUpk) || $dataUpk === 'SEMUA') ? 'SEMUA' : $dataUpk;
        $data['tahun']   = $dataTahun;
        $data['title']   = 'USULAN INVESTASI (RKAP) TAHUN ';

        $this->pdf->setPaper('Folio', 'portrait');

        $safeUpk = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['namaUpk']);
        $this->pdf->filename = "Usulan_inves-{$safeUpk}-{$dataTahun}.pdf";

        $this->pdf->generate('admin/usulan_inves/laporan_pdf', $data);
    }


    // public function index()
    // {

    //     $dataUpk = $this->input->post('bagian_upk');
    //     $dataTahun = $this->input->post('tahun_rkap');
    //     $data['namaUpk'] = $dataUpk;
    //     $data['tahun'] = $dataTahun;
    //     $data['tampil'] = $this->Model_usulan_inves->getDataUpk($dataUpk, $dataTahun);
    //     $data['seleksi'] = $this->Model_usulan_inves->getNamaUpk($dataUpk, $dataTahun);
    //     $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
    //     $this->load->view('templates/header', $data);
    //     $this->load->view('templates/navbar');
    //     $this->load->view('templates/sidebar');
    //     $this->load->view('admin/usulan_inves/view_usulan_investasi', $data);
    //     $this->load->view('templates/footer');
    // }


    // public function export_pdf()
    // {
    //     $dataUpk = $this->input->post('bagian_upk');
    //     $dataTahun = $this->input->post('tahun_rkap');
    //     $data['namaUpk'] = $dataUpk;
    //     $data['tahun'] = $dataTahun;
    //     $data['tampil'] = $this->Model_usulan_inves->getDataUpk($dataUpk, $dataTahun);
    //     $data['seleksi'] = $this->Model_usulan_inves->getNamaUpk($dataUpk, $dataTahun);
    //     $data['title'] = 'USULAN INVESTASI (RKAP) TAHUN ';
    //     // Set paper size and orientation
    //     $this->pdf->setPaper('A4', 'portrait');

    //     // $this->pdf->filename = "Potensi Sr.pdf";
    //     $this->pdf->filename = "Evaluasi Upk-{$dataUpk}-{$dataTahun}.pdf";
    //     $this->pdf->generate('admin/usulan_inves/laporan_pdf', $data);
    // }

    public function edit_usulan_investasi($id_usulanInvestasi)
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
            redirect('admin/usulan_inves');
        } else {
            $data['no_per'] = $this->Model_usulan_inves->getNoPerInves();
            $data['usulan_investasi'] = $this->Model_usulan_inves->getUsulanInves($id_usulanInvestasi);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('admin/usulan_inves/edit_usulan_investasi', $data);
            $this->load->view('templates/footer');
        }
    }

    public function update()
    {
        $this->Model_usulan_inves->updateData();
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
            redirect('admin/usulan_inves');
        }
    }

    public function hapus_usulan_investasi($id_usulanInvestasi)
    {
        $statusUpdate = $this->Model_usulan_inves->getStatusUpdate('usulan_investasi');
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> data sudah tidak bisa di hapus.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('admin/usulan_inves');
        } else {
            // Ambil informasi file yang ingin dihapus (misalnya nama file) dari database
            $this->db->select('foto_ket');
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $query = $this->db->get('usulan_investasi');
            $row = $query->row();

            // Hapus file jika ada
            if ($row && $row->foto_ket) {
                $file_path = FCPATH . 'uploads/' . $row->foto_ket; // Ganti dengan path yang sesuai
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file dari server
                }
            }

            // Hapus data dari database
            $this->db->where('id_usulanInvestasi', $id_usulanInvestasi);
            $this->db->delete('usulan_investasi');

            redirect('admin/usulan_inves');
        }
    }

    public function detail_usulan_investasi($id_usulanInvestasi)
    {
        $data['title'] = 'Detail Usulan Investasi';
        $data['usulan_investasi'] = $this->db->get_where('usulan_investasi', ['id_usulanInvestasi' => $id_usulanInvestasi])->row();

        if (!$data['usulan_investasi']) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> Data tidak ditemukan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('admin/usulan_investasi');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_inves/detail_usulan_investasi', $data);
        $this->load->view('templates/footer');
    }

    public function generate_usulan_inves($id_usulanInvestasi)
    {
        $data['title'] = 'Generate Data Ke INVESTASI (ARUS KAS)';
        // Cek status update
        $statusUpdate = $this->Model_pengaturan->getStatusUpdate();
        if ($statusUpdate !== null && $statusUpdate->status_update == 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data sudah tidak bisa diproses.
            </div>'
            );
            redirect('admin/usulan_inves');
        }
        // Ambil data usulan
        $usulan = $this->Model_usulan_inves->getUsulanInvestasiAdmin($id_usulanInvestasi);
        if (!$usulan) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger">
                Data tidak ditemukan.
            </div>'
            );
            redirect('admin/usulan_inves');
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
                redirect('admin/usulan_inves/generate_usulan_inves/' . $id_usulanInvestasi);
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
            // bagian_upk berasal dari data usulan_investasi, mapping_upk digunakan untuk mendapatkan cabang_id yang sesuai. Jika bagian_upk tidak ada dalam mapping, cabang_id akan menjadi string kosong.
            $cabang_id = $mapping_upk[$usulan->bagian_upk] ?? '';

            if ($cabang_id == '') {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger">
                    Mapping UPK tidak ditemukan.
                </div>'
                );
                redirect('admin/usulan_inves');
            }

            //  Siapkan data
            $tahun = $usulan->tahun_rkap + 1;
            $insert = [];
            foreach ($bulanDipilih as $bulan) {
                $insert[] = [
                    'id_upk' => NULL,
                    'cabang_id' => $cabang_id,
                    'no_per_id' => $usulan->no_perkiraan,
                    'vol' => $usulan->volume,
                    'sat' => $usulan->satuan,
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
            // $result = $this->Model_usulan_inves
            //     ->insert_or_update_generate_inves($insert);
            // $this->session->set_flashdata(
            //     'info',
            //     '<div class="alert alert-success">
            //     Berhasil Generate Investasi (Arus Kas).<br>
            //     Proses Insert : <b>' . $result['inserted'] . '</b><br>
            //     Proses Update : <b>' . $result['updated'] . '</b>
            // </div>'
            // );

            $this->db->trans_begin();
            $result = $this->Model_usulan_inves
                ->insert_or_update_generate_inves($insert);
            $this->Model_usulan_inves->updateStatusUpload($id_usulanInvestasi);
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
            Berhasil Generate Investasi (Arus Kas).<br>
            Proses Insert : <b>' . $result['inserted'] . '</b><br>
            Proses Update : <b>' . $result['updated'] . '</b>
        </div>'
                );
            }
            redirect('admin/usulan_inves');
        }

        $data['usulan_investasi'] = $usulan;
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/usulan_inves/generate_usulan_inves', $data);
        $this->load->view('templates/footer');
    }
}
