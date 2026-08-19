<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_air extends MY_Controller
{

    // Batas tahun mulaiki efisiensi penagihan / pengaturan distribusi.
    // Tahun < konstanta ini selalu memakai KODE LAMA (tidak terpengaruh
    // pengaturan apapun), sehingga hanya boleh dihitung untuk kebersihan.
    private $TAHUN_AWAL_EFISIENSI = 2027;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penerimaan_air');
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

        $this->session->set_userdata('tahun_rkap', $tahun);
        $this->session->set_userdata('upk', $upk);

        // =============================================================
        // PEMILIHAN KODE (LAMA / BARU)
        // -------------------------------------------------------------
        // Efisiensi penagihan (Target UPK) HANYA berlaku mulai tahun
        // $TAHUN_MULAI_EFISIENSI dan seterusnya.
        // Tahun 2026 ke bawah TIDAK ada data efisiensi penagihan,
        // sehingga tetap memakai KODE LAMA (getDataPenerimaanAirDistribusi)
        // agar nilainya tidak berubah.
        // Ubah nilai $TAHUN_MULAI_EFISIENSI bila kebijakannya berubah.
        // =============================================================
        $TAHUN_MULAI_EFISIENSI = 2027;

        // =============================================================
        // POLA DISTRIBUSI PENERIMAAN PER TAHUN (>= 2027)
        // Tiap tahun punya pengaturannya SENDIRI di fungsi
        // get_distribusi_tahun() -> $per_tahun. Mengubah persentase satu
        // tahun TIDAK akan mengubah tahun-tahun sebelumnya.
        // Tahun 2026 ke bawah selalu memakai KODE LAMA (tidak terpengaruh).
        // =============================================================
        $dist  = $this->get_distribusi_tahun($tahun);
        $dist_tagihan = $dist['dist_tagihan'];
        $dist_thl     = $dist['dist_thl'];

        if ($tahun >= $TAHUN_MULAI_EFISIENSI) {
            // KODE BARU: penerimaan disesuaikan % efisiensi penagihan.
            $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusiEfisiensi($tahun, $upk, $dist_tagihan, $dist_thl);

            // nilai efisiensi utk dipakai di View (baris bulanan & Th Lalu)
            $data['efi_efektif']     = $res['efi_efektif'];
            $data['efi_thl_efektif'] = $res['efi_thl_efektif'];
        } else {
            // KODE LAMA (tahun 2026 ke bawah): tanpa efisiensi.
            // View otomatis memakai default 100% bila efi_* tidak dikirim.
            $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusi($tahun, $upk);
        }

        $data['per_jenis'] = $res['per_jenis'];
        $data['overall_totals'] = $res['overall_totals'];
        $data['overall_grand'] = $res['overall_grand'];

        // penanda utk View: true = pakai metode baru (efisiensi), false = kode lama
        $data['pakai_efisiensi'] = ($tahun >= $TAHUN_MULAI_EFISIENSI);

        // pengaturan distribusi persentase utk View (baris bulanan & Th Lalu)
        $data['dist_tagihan'] = $dist_tagihan;
        $data['dist_thl']     = $dist_thl;

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['title'] = 'RENCANA PENERIMAAN TAGIHAN REKENING AIR <br> TAHUN ANGGARAN ';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        // data tangki air
        $tangki_air = [
            'penggunaan_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'm3_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'tarif_rata2' => array_fill(1, 12, 0) + ['total' => 0]
        ];

        $rawData = $this->Model_pendapatan_air->getTangkiAir($upk, $tahun);
        foreach ($rawData as $row) {
            $bulan = (int)$row->bulan;
            $tangki_air['penggunaan_rata2'][$bulan] = $row->penggunaan_rata2;
            $tangki_air['m3_rata2'][$bulan] = $row->m3_rata2;
            $tangki_air['tarif_rata2'][$bulan] = $row->tarif_rata2;
        }

        // Hitung total untuk setiap baris
        foreach ($tangki_air as $key => &$values) {
            if ($key == 'm3_rata2' || $key == 'tarif_rata2') {
                $values['total'] = $values['1'];
            } else {
                $values['total'] = array_sum(array_slice($values, 0, 12));
            }
        }
        $data['tangki_air'] = $tangki_air;
        // end data tangki air

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/view_penerimaan_air', $data);
        $this->load->view('templates/footer');
    }

    public function export_pdf()
    {

        $tahun = $this->session->userdata('tahun_rkap');
        $upk = $this->session->userdata('upk');

        // =============================================================
        // PEMILIHAN KODE (LAMA / BARU) - sama seperti pada index()
        // Efisiensi penagihan HANYA berlaku mulai $TAHUN_MULAI_EFISIENSI.
        // Tahun 2026 ke bawah memakai KODE LAMA agar nilainya tidak berubah.
        // =============================================================
        $TAHUN_MULAI_EFISIENSI = 2027;

        // =============================================================
        // POLA DISTRIBUSI PENERIMAAN PER TAHUN (>= 2027)
        // Lihat get_distribusi_tahun() -> $per_tahun. Sama seperti index().
        // Mengubah persentase satu tahun TIDAK mempengaruhi tahun lain.
        // =============================================================
        $dist  = $this->get_distribusi_tahun($tahun);
        $dist_tagihan = $dist['dist_tagihan'];
        $dist_thl     = $dist['dist_thl'];

        if ($tahun >= $TAHUN_MULAI_EFISIENSI) {
            // KODE BARU: penerimaan disesuaikan % efisiensi penagihan.
            $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusiEfisiensi($tahun, $upk, $dist_tagihan, $dist_thl);

            // nilai efisiensi utk dipakai di View PDF (baris bulanan & Th Lalu)
            $data['efi_efektif']     = $res['efi_efektif'];
            $data['efi_thl_efektif'] = $res['efi_thl_efektif'];
        } else {
            // KODE LAMA (tahun 2026 ke bawah): tanpa efisiensi.
            $res = $this->Model_penerimaan_air->getDataPenerimaanAirDistribusi($tahun, $upk);
        }

        $data['per_jenis'] = $res['per_jenis'];
        $data['overall_totals'] = $res['overall_totals'];
        $data['overall_grand'] = $res['overall_grand'];

        // penanda utk View: true = pakai metode baru (efisiensi), false = kode lama
        $data['pakai_efisiensi'] = ($tahun >= $TAHUN_MULAI_EFISIENSI);

        // pengaturan distribusi persentase utk View PDF (baris bulanan & Th Lalu)
        $data['dist_tagihan'] = $dist_tagihan;
        $data['dist_thl']     = $dist_thl;

        $data['tahun'] = $tahun;
        $data['upk'] = $upk;
        $data['title'] = 'RENCANA PENERIMAAN TAGIHAN REKENING AIR <br> TAHUN ANGGARAN ';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        // data tangki air
        $tangki_air = [
            'penggunaan_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'm3_rata2' => array_fill(1, 12, 0) + ['total' => 0],
            'tarif_rata2' => array_fill(1, 12, 0) + ['total' => 0]
        ];

        $rawData = $this->Model_pendapatan_air->getTangkiAir($upk, $tahun);
        foreach ($rawData as $row) {
            $bulan = (int)$row->bulan;
            $tangki_air['penggunaan_rata2'][$bulan] = $row->penggunaan_rata2;
            $tangki_air['m3_rata2'][$bulan] = $row->m3_rata2;
            $tangki_air['tarif_rata2'][$bulan] = $row->tarif_rata2;
        }

        // Hitung total untuk setiap baris
        foreach ($tangki_air as $key => &$values) {
            if ($key == 'm3_rata2' || $key == 'tarif_rata2') {
                $values['total'] = $values['1'];
            } else {
                $values['total'] = array_sum(array_slice($values, 0, 12));
            }
        }
        $data['tangki_air'] = $tangki_air;
        // end data tangki air

        // Setting PDF
        $this->pdf->setPaper('Folio', 'landscape');
        $this->pdf->filename = "Lap_penerimaan_air_{$tahun}_{$upk}.pdf";

        // Generate dari view khusus PDF
        $this->pdf->generate('lembar_kerja/arus_kas/penerimaan_air/laporan_pdf', $data);
    }

    /**
     * PENGATURAN POLA DISTRIBUSI PENERIMAAN (TAHUN >= 2027) - PER TAHUN.
     *
     * Nilai dibaca dari tabel `rkap_setting_distribusi` sehingga bisa diubah
     * langsung lewat form di halaman (tanpa mengubah kode). Setiap tahun
     * punya baris pengaturannya SENDIRI -> mengubah satu tahun TIDAK mengubah
     * tahun sebelumnya. Tahun 2026 ke bawah selalu memakai KODE LAMA, jadi
     * tidak pernah terpengaruh oleh pengaturan ini.
     *
     * Arti nilai (pecahan, total p1+p2 = 1.00):
     *   - dist_tagihan: tagihan bulan B -> p1 diterima bulan B+1,
     *                   p2 diterima bulan B+2.
     *   - dist_thl    : sisa piutang Th Lalu -> p1 di JANUARI,
     *                   p2 di FEBRUARI.
     *
     * @param int $tahun Tahun anggaran
     * @return array ['dist_tagihan' => [...], 'dist_thl' => [...]]
     */
    private function get_distribusi_tahun($tahun)
    {
        // 1) Prioritas: pengaturan tersimpan di database (bisa diubah lewat form).
        $dari_db = $this->Model_penerimaan_air->get_setting_distribusi($tahun);
        if ($dari_db) {
            return $dari_db;
        }

        // 2) Default bila tahun tsb belum punya pengaturan tersimpan.
        return [
            'dist_tagihan' => ['p1' => 1.00, 'p2' => 0.00],
            'dist_thl'     => ['p1' => 0.90, 'p2' => 0.10],
        ];
    }

    /**
     * Tahun anggaran yang sedang aktif/dikerjakan (default: tahun depan).
     * Tahun yang LEBIH LAMA dari tahun aktif otomatis terkunci.
     */
    private function tahun_aktif()
    {
        return (int)($this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: (date('Y') + 1));
    }

    /**
     * Halaman MENU KHUSUS pengaturan persentase distribusi penerimaan per tahun.
     */
    public function setting_distribusi()
    {
        $data['title'] = 'Pengaturan Persentase Distribusi Penerimaan Air';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        $data['tahun_aktif'] = $this->tahun_aktif();

        // HANYA tampilkan tahun yang sudah tersimpan (diinput lewat form
        // "Tambah Tahun"). Tahun berikutnya ditambahkan sendiri di halaman ini.
        $data['tahun_list'] = [];
        $data['terkunci'] = [];
        if ($this->db->table_exists('rkap_setting_distribusi')) {
            $rows = $this->db->select('tahun, terkunci')->order_by('tahun', 'ASC')->get('rkap_setting_distribusi')->result_array();
            foreach ($rows as $r) {
                $thn = (int)$r['tahun'];
                $data['tahun_list'][] = $thn;
                $data['terkunci'][$thn] = (int)$r['terkunci'] === 1;
            }
        }
        // Batas tahun mulaiki efisiensi, utk menandai tahun 'kode lama' di View.
        $data['tahun_awal_efisiensi'] = $this->TAHUN_AWAL_EFISIENSI;

        // Muat nilai tiap tahun (dari DB; default bila belum tersimpan).
        $data['data_tahun'] = [];
        foreach ($data['tahun_list'] as $thn) {
            $d = $this->Model_penerimaan_air->get_setting_distribusi($thn);
            if (!$d) {
                $d = [
                    'dist_tagihan' => ['p1' => 1.00, 'p2' => 0.00],
                    'dist_thl'     => ['p1' => 0.90, 'p2' => 0.10],
                ];
            }
            $data['data_tahun'][$thn] = $d;
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/view_setting_distribusi', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Tambahkan tahun baru ke daftar pengaturan (menggunakan nilai default),
     * dipanggil dari halaman setting_distribusi.
     */
    public function tambah_tahun_distribusi()
    {
        $tahun = (int)$this->input->post('tahun');

        if (!$this->db->table_exists('rkap_setting_distribusi')) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tabel belum ada. Silakan impor file <b>rkap_setting_distribusi.sql</b> terlebih dahulu.</div>');
            redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
            return;
        }

        if ($tahun < $this->TAHUN_AWAL_EFISIENSI) {
            $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun minimal ' . $this->TAHUN_AWAL_EFISIENSI . ' (tahun ' . ($this->TAHUN_AWAL_EFISIENSI - 1) . ' ke bawah selalu memakai kode lama).</div>');
            redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
            return;
        }

        $ada = $this->db->where('tahun', $tahun)->get('rkap_setting_distribusi')->num_rows();
        if ($ada > 0) {
            $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun <b>' . $tahun . '</b> sudah ada di daftar.</div>');
        } else {
            $this->db->insert('rkap_setting_distribusi', [
                'tahun'           => $tahun,
                'dist_tagihan_p1' => 0.90,
                'dist_tagihan_p2' => 0.10,
                'dist_thl_p1'     => 0.90,
                'dist_thl_p2'     => 0.10,
                'ptgs_upload'     => $this->session->userdata('nama_lengkap') ?? 'Admin',
            ]);
            $this->session->set_flashdata('info', '<div class="alert alert-success">Tahun <b>' . $tahun . '</b> berhasil ditambahkan (memakai nilai default, silakan ubah).</div>');
        }

        redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
    }

    /**
     * Hapus satu tahun dari daftar pengaturan (tahun tsb kembali ke nilai default).
     * Tahun yang TERKUNCI tidak dapat dihapus.
     */
    public function hapus_tahun_distribusi($tahun)
    {
        $tahun = (int)$tahun;

        if ($this->db->table_exists('rkap_setting_distribusi')) {
            $row = $this->db->where('tahun', $tahun)->get('rkap_setting_distribusi')->row();
            $auto_locked = ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $tahun < $this->tahun_aktif());
            if (!$row) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger">Tahun <b>' . $tahun . '</b> tidak ditemukan di daftar pengaturan.</div>');
            } elseif ($auto_locked) {
                $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun <b>' . $tahun . '</b> terkunci OTOMATIS (lebih lama dari tahun anggaran aktif ' . $this->tahun_aktif() . ') sehingga tidak bisa dihapus.</div>');
            } elseif ((int)$row->terkunci === 1) {
                $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun <b>' . $tahun . '</b> TERKUNCI sehingga tidak bisa dihapus. Buka kuncinya terlebih dahulu.</div>');
            } else {
                $this->db->where('tahun', $tahun)->delete('rkap_setting_distribusi');
                $this->session->set_flashdata('info', '<div class="alert alert-success">Tahun <b>' . $tahun . '</b> dihapus; tahun tersebut kembali memakai nilai default.</div>');
            }
        } else {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tahun tidak valid atau tabel belum dibuat.</div>');
        }

        redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
    }

    /**
     * Kunci tahun: nilai TIDAK bisa diedit maupun dihapus (dipanggil manual).
     */
    public function kunci_tahun_distribusi($tahun)
    {
        $tahun = (int)$tahun;
        if ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $tahun < $this->tahun_aktif()) {
            $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun <b>' . $tahun . '</b> sudah terunci OTOMATIS (lebih lama dari tahun anggaran aktif ' . $this->tahun_aktif() . ').</div>');
        } elseif ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $this->db->table_exists('rkap_setting_distribusi')) {
            $this->db->where('tahun', $tahun)->update('rkap_setting_distribusi', ['terkunci' => 1]);
            $this->session->set_flashdata('info', '<div class="alert alert-success">Tahun <b>' . $tahun . '</b> terkunci (tidak bisa diedit/dihapus).</div>');
        } else {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tahun tidak valid atau tabel belum dibuat.</div>');
        }
        redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
    }

    /**
     * Buka kunci tahun: nilai dapat diedit/dihapus kembali.
     */
    public function buka_tahun_distribusi($tahun)
    {
        $tahun = (int)$tahun;
        if ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $tahun < $this->tahun_aktif()) {
            $this->session->set_flashdata('info', '<div class="alert alert-warning">Tahun <b>' . $tahun . '</b> terunci OTOMATIS (lebih lama dari tahun anggaran aktif ' . $this->tahun_aktif() . ') sehingga tidak bisa dibuka kuncinya.</div>');
        } elseif ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $this->db->table_exists('rkap_setting_distribusi')) {
            $this->db->where('tahun', $tahun)->update('rkap_setting_distribusi', ['terkunci' => 0]);
            $this->session->set_flashdata('info', '<div class="alert alert-success">Tahun <b>' . $tahun . '</b> dibuka kuncinya (bisa diedit/dihapus lagi).</div>');
        } else {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tahun tidak valid atau tabel belum dibuat.</div>');
        }
        redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
    }

    /**
     * Simpan pengaturan persentase distribusi untuk SEMUA tahun sekaligus
     * (dipanggil dari halaman setting_distribusi).
     */
    public function simpan_distribusi_all()
    {
        $rows = $this->input->post('rows');

        if (!$this->db->table_exists('rkap_setting_distribusi')) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tabel belum ada. Silakan impor file <b>rkap_setting_distribusi.sql</b> terlebih dahulu.</div>');
            redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
            return;
        }

        if (!$rows || !is_array($rows)) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger">Tidak ada data untuk disimpan.</div>');
            redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
            return;
        }

        // Daftar tahun yang TERKUNCI -> dilewati (tidak boleh diubah).
        // Gabungan: kunci manual (terkunci=1) + kunci OTOMATIS (tahun lebih lama
        // dari tahun anggaran aktif, mis. saat aktif 2028 maka 2027 ikut terkunci).
        $tahun_aktif = $this->tahun_aktif();
        $locked_years = [];
        $locked_rows = $this->db->where('terkunci', 1)->get('rkap_setting_distribusi')->result_array();
        foreach ($locked_rows as $lr) {
            $locked_years[(int)$lr['tahun']] = true;
        }

        $jml_ok = 0;
        $jml_error = 0;
        $jml_locked = 0;
        $msg = '';
        foreach ($rows as $tahun => $vals) {
            $tahun = (int)$tahun;
            if ($tahun < 2000) {
                $jml_error++;
                continue;
            }

            // Tahun terkunci: dilewati tanpa disimpan.
            $auto_locked = ($tahun >= $this->TAHUN_AWAL_EFISIENSI && $tahun < $tahun_aktif);
            if (!empty($locked_years[$tahun]) || $auto_locked) {
                $jml_locked++;
                continue;
            }

            $p1 = (float)($vals['dist_tagihan_p1'] ?? 0);
            $p2 = (float)($vals['dist_tagihan_p2'] ?? 0);
            $t1 = (float)($vals['dist_thl_p1'] ?? 0);
            $t2 = (float)($vals['dist_thl_p2'] ?? 0);

            // Validasi nilai 0-100
            foreach ([['Tagihan P1', $p1], ['Tagihan P2', $p2], ['Th Lalu P1', $t1], ['Th Lalu P2', $t2]] as $item) {
                if ($item[1] < 0 || $item[1] > 100) {
                    $jml_error++;
                    $msg = "Tahun $tahun: nilai {$item[0]} harus 0 - 100.";
                    break 2;
                }
            }
            // Validasi total tiap pasangan = 100%
            if (abs(($p1 + $p2) - 100) > 0.01) {
                $jml_error++;
                $msg = "Tahun $tahun: total Tagihan P1 + P2 harus 100%.";
                break;
            }
            if (abs(($t1 + $t2) - 100) > 0.01) {
                $jml_error++;
                $msg = "Tahun $tahun: total Th Lalu P1 + P2 harus 100%.";
                break;
            }

            $data = [
                'dist_tagihan_p1' => round($p1 / 100, 4),
                'dist_tagihan_p2' => round($p2 / 100, 4),
                'dist_thl_p1'     => round($t1 / 100, 4),
                'dist_thl_p2'     => round($t2 / 100, 4),
            ];

            if ($this->Model_penerimaan_air->simpan_setting_distribusi($tahun, $data)) {
                $jml_ok++;
            } else {
                $jml_error++;
            }
        }

        if ($jml_error > 0) {
            $info = ($jml_ok > 0 ? "$jml_ok tahun berhasil disimpan; " : '') . "$jml_error tahun gagal." . ($msg ? ' ' . $msg : '');
            $this->session->set_flashdata('info', '<div class="alert alert-warning">' . $info . '</div>');
        } elseif ($jml_locked > 0 && $jml_ok == 0) {
            $this->session->set_flashdata('info', '<div class="alert alert-info"><b>' . $jml_locked . '</b> tahun TERKUNCI dilewati (tidak diubah). Buka kuncinya terlebih dahulu bila ingin mengedit.</div>');
        } else {
            $ket = $jml_ok . ' tahun.';
            if ($jml_locked > 0) $ket .= ' ' . $jml_locked . ' tahun terkunci dilewati.';
            $this->session->set_flashdata('info', '<div class="alert alert-success">Pengaturan distribusi tersimpan untuk <b>' . $ket . '</b></div>');
        }

        redirect('lembar_kerja/arus_kas/penerimaan_air/setting_distribusi');
    }

    public function generate()
    {
        $tahun = $this->input->post('tahun');
        $cabang_id = $this->input->post('cabang_id');
        $grand_per_month = $this->input->post('pagu'); // array bulan => nilai

        if (!$tahun || empty($grand_per_month)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Gagal menyimpan data penerimaan air ke Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/arus_kas/penerimaan_air');
            return;
        }

        // Hapus data lama
        $awal_tahun = "$tahun-01-01";
        $akhir_tahun = "$tahun-12-01";

        $this->db->where('no_per_id', '81.01.01');
        $this->db->where('bulan >=', $awal_tahun);
        $this->db->where('bulan <=', $akhir_tahun);
        $this->db->delete('rkap_arus_kas');

        // Simpan data baru
        foreach ($grand_per_month as $bulan_ke => $nilai) {
            $bulan_fix = str_pad($bulan_ke, 2, '0', STR_PAD_LEFT);
            $tanggal_bulan = "$tahun-$bulan_fix-01";

            $data_insert = [
                'cabang_id' => '24',
                'no_per_id' => '81.01.01',
                'bulan'     => $tanggal_bulan,
                'pagu' => (float) $nilai

            ];

            $this->db->insert('rkap_arus_kas', $data_insert);
        }

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> Data penerimaan air berhasil digenerate ke  Arus Kas.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_air');
    }

    public function generate_ta()
    {
        $upk   = $this->session->userdata('upk'); // atau ambil dari input get/post
        $tahun = $this->input->get('tahun_rkap') ?: $this->session->userdata('tahun_rkap') ?: (date('Y') + 1);
        $this->session->set_userdata('tahun_rkap', $tahun);

        $cabang_id = $upk; // pakai upk yang sama seperti di view
        $no_per_id = '81.01.05';

        $tangki_air = $this->Model_pendapatan_air->getTangkiAir($cabang_id, $tahun);

        // if (empty($tangki_air)) {
        //     echo "DATA KOSONG untuk cabang_id = {$cabang_id}, tahun = {$tahun}";
        //     exit;
        // } else {
        //     echo "<pre>";
        //     print_r($tangki_air);
        //     echo "</pre>";
        //     exit;
        // }

        // Pastikan hasilnya berbentuk array [1..12]
        $penggunaan_rata2 = array_fill(1, 12, 0);
        $m3_rata2         = array_fill(1, 12, 0);
        $tarif_rata2      = array_fill(1, 12, 0);

        foreach ($tangki_air as $row) {
            $bulan = (int)$row->bulan;
            $penggunaan_rata2[$bulan] = (float)$row->penggunaan_rata2;
            $m3_rata2[$bulan]         = (float)$row->m3_rata2;
            $tarif_rata2[$bulan]      = (float)$row->tarif_rata2;
        }

        // 🔹 Hitung total bulanan (sesuai rumus di view)
        $total_per_bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $total_per_bulan[$i] = $penggunaan_rata2[$i] * $m3_rata2[$i] * $tarif_rata2[$i];
        }

        // 🔹 Hapus data lama agar tidak dobel
        $this->db->where('YEAR(bulan)', $tahun);
        $this->db->where('cabang_id', $cabang_id);
        $this->db->where('no_per_id', $no_per_id);
        $this->db->delete('rkap_arus_kas');

        // 🔹 Insert ke database
        for ($i = 1; $i <= 12; $i++) {
            $bulan_str = str_pad($i, 2, '0', STR_PAD_LEFT);
            $this->db->insert('rkap_arus_kas', [
                'cabang_id' => 23,
                'no_per_id' => $no_per_id,
                'bulan'     => "{$tahun}-{$bulan_str}-01",
                'pagu'      => $total_per_bulan[$i],
            ]);
        }

        $this->session->set_flashdata(
            'info',
            '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> Data Penerimaan Air Tangki berhasil digenerate ke Arus Kas.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>'
        );
        redirect('lembar_kerja/arus_kas/penerimaan_air');
    }




    public function tampil_tahun_lalu()
    {
        $tahun_rkap = $this->input->get('tahun_rkap') ?: date('Y') + 1;
        $data['tahun'] = $tahun_rkap;
        $data['title'] = 'Proyeksi Sisa Piutang Air Tahun ';
        $data['hasil'] = $this->Model_penerimaan_air->get_tahun_lalu($tahun_rkap, $this->input->get('upk'));
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/view_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function input_tahun_lalu()
    {
        $data['title'] = 'Input Data Penerimaan Air Tahun Lalu';
        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();
        $data['list_jp'] = $this->db->get('rkap_jenis_plgn')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/input_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function simpan_tahun_lalu()
    {
        $id_upk        = $this->input->post('id_upk');
        $id_jp         = $this->input->post('id_jp');
        $tahun         = $this->input->post('tahun');


        // 🔍 Cek apakah kombinasi id_produk + tahun sudah ada
        if ($this->Model_penerimaan_air->cek_tahun_lalu($id_upk, $id_jp, $tahun)) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Data piutang Air tahun lalu sudah ada.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>'
            );
            redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
            return;
        }

        // ✅ Jika belum ada, lanjut insert
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'lembar_lalu'   => $this->input->post('lembar_lalu'),
            'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
            'ptgs_upload'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
        ];

        $this->Model_penerimaan_air->insert_tahun_lalu($data);

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Piutang Air tahun lalu berhasil disimpan.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
        );

        redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    }
    // public function simpan_tahun_lalu()
    // {
    //     $data = [
    //         'id_upk'        => $this->input->post('id_upk'),
    //         'id_jp'         => $this->input->post('id_jp'),
    //         'tahun'         => $this->input->post('tahun'),
    //         'lembar_lalu'   => $this->input->post('lembar_lalu'),
    //         'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
    //         'ptgs_upload'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
    //     ];

    //     $this->Model_penerimaan_air->insert_tahun_lalu($data);

    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 <strong>Berhasil,</strong> Data Penerimaan tahun lalu berhasil disimpan.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //     );

    //     redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    // }

    public function edit_tahun_lalu($id)
    {
        $data['title'] = 'Edit Data Penerimaan Air Tahun Lalu';
        $data['data'] = $this->Model_penerimaan_air->get_tahun_lalu_by_id($id);

        $data['list_upk'] = $this->db->where('status', 1)->get('rkap_nama_upk')->result();
        $data['list_jp'] = $this->db->get('rkap_jenis_plgn')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('lembar_kerja/arus_kas/penerimaan_air/edit_tahun_lalu', $data);
        $this->load->view('templates/footer');
    }

    public function update_tahun_lalu_aksi()
    {
        $id = $this->input->post('id');
        $data = [
            'id_upk'        => $this->input->post('id_upk'),
            'id_jp'         => $this->input->post('id_jp'),
            'tahun'         => $this->input->post('tahun'),
            'lembar_lalu'   => $this->input->post('lembar_lalu'),
            'rupiah_lalu'   => $this->input->post('rupiah_lalu'),
            'ptgs_update'   => $this->session->userdata('nama_lengkap') ?? 'Admin',
        ];

        $update = $this->Model_penerimaan_air->update_tahun_lalu($id, $data);
        if ($update) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil,</strong> Data Penerimaan tahun lalu berhasil diupdate.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error,</strong> Data Penerimaan tahun lalu gagal diupdate.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
        }

        redirect('lembar_kerja/arus_kas/penerimaan_air/tampil_tahun_lalu');
    }
}
