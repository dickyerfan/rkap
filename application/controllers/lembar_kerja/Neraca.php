<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Neraca extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_posisi_keuangan');
        date_default_timezone_set('Asia/Jakarta');
        if (!$this->session->userdata('level')) redirect('auth');
    }

    private function loadViews($view, $data)
    {
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar');
        }
        $this->load->view($view, $data);
        $this->load->view('templates/footer');
    }

    public function index()
    {
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $this->session->set_userdata("tahun_rkap_neraca", $tahun);
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = ["tahun" => $tahun, "lajur" => $lajur, "title" => "LAPORAN POSISI KEUANGAN (PROYEKSI) "];
        $this->loadViews('lembar_kerja/neraca/view_laporan', $data);
    }

    public function export_pdf()
    {
        $tahun = $this->session->userdata("tahun_rkap_neraca") ?: date("Y") + 1;
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = ["tahun" => $tahun, "lajur" => $lajur, "title" => "LAPORAN POSISI KEUANGAN (PROYEKSI) <br> TAHUN ANGGARAN "];
        $this->pdf->setPaper("Folio", "landscape");
        $this->pdf->filename = "Lap_Posisi_Keuangan_" . $tahun . ".pdf";
        $this->pdf->generate("lembar_kerja/neraca/laporan_pdf", $data);
    }

    public function neraca_lajur()
    {
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $this->session->set_userdata("tahun_rkap_neraca", $tahun);
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = ["tahun" => $tahun, "lajur" => $lajur, "title" => "NERACA LAJUR RKAP"];
        $this->loadViews("lembar_kerja/neraca/view_neraca_lajur", $data);
    }

    public function komparasi()
    {
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $this->session->set_userdata("tahun_rkap_neraca", $tahun);
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = ["tahun" => $tahun, "lajur" => $lajur, "title" => "KOMPARASI LAPORAN POSISI KEUANGAN "];
        $this->loadViews('lembar_kerja/neraca/view_komparasi', $data);
    }

    public function export_pdf_komparasi()
    {
        $tahun = $this->session->userdata("tahun_rkap_neraca") ?: date("Y") + 1;
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = ["tahun" => $tahun, "lajur" => $lajur, "title" => "KOMPARASI LAPORAN POSISI KEUANGAN"];
        $this->pdf->setPaper("Folio", "landscape");
        $this->pdf->filename = "Komparasi_Posisi_Keuangan_" . $tahun . ".pdf";
        $this->pdf->generate("lembar_kerja/neraca/laporan_pdf_komparasi", $data);
    }

    public function input_growth()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $data = ["tahun" => $tahun, "growth" => $this->Model_posisi_keuangan->getGrowthData($tahun), "posList" => $this->Model_posisi_keuangan->getPosList(), "title" => "Input Data Neraca Awal"];
        $this->loadViews("lembar_kerja/neraca/view_input_growth", $data);
    }
    public function simpan_growth()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->post("tahun");
        $this->Model_posisi_keuangan->saveGrowthData($tahun, $this->input->post("neraca"), $this->session->userdata("nama_pengguna"));
        $this->session->set_flashdata("info", "<div class=alert alert-success><strong>Sukses!</strong> Data neraca awal berhasil disimpan.</div>");
        redirect("lembar_kerja/neraca/input_growth?tahun_rkap=" . $tahun);
    }
    public function input_jurnal()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $data = ["tahun" => $tahun, "jurnal" => $this->Model_posisi_keuangan->getJurnalManual($tahun), "jRekap" => $this->Model_posisi_keuangan->getJurnalFromRekap($tahun), "posList" => $this->Model_posisi_keuangan->getPosList(), "title" => "Input Jurnal Penyesuaian RKAP"];
        $this->loadViews("lembar_kerja/neraca/view_input_jurnal", $data);
    }
    public function simpan_jurnal()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->post("tahun");
        $this->Model_posisi_keuangan->saveJurnalManual($tahun, $this->input->post("jurnal"), $this->session->userdata("nama_pengguna"));
        $this->session->set_flashdata("info", "<div class=alert alert-success><strong>Sukses!</strong> Jurnal penyesuaian berhasil disimpan.</div>");
        redirect("lembar_kerja/neraca/input_jurnal?tahun_rkap=" . $tahun);
    }

    public function koreksi()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->get("tahun_rkap") ?: date("Y") + 1;
        $this->session->set_userdata("tahun_rkap_neraca", $tahun);
        $lajur = $this->Model_posisi_keuangan->hitungNeracaLajur($tahun);
        $data = [
            "tahun" => $tahun,
            "lajur" => $lajur,
            "ringkas" => $this->Model_posisi_keuangan->ringkasanNeracaField($lajur),
            "ringkasTanpa" => $this->Model_posisi_keuangan->ringkasanNeracaField($this->Model_posisi_keuangan->hitungNeracaLajur($tahun, true)),
            "koreksi" => $this->Model_posisi_keuangan->getJurnalManual($tahun),
            "posList" => $this->Model_posisi_keuangan->getPosList(),
            "title" => "KOREKSI PENYIMPANGAN NERACA",
        ];
        $this->loadViews("lembar_kerja/neraca/view_koreksi_neraca", $data);
    }

    public function simpan_koreksi()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $tahun = $this->input->post("tahun");
        $clean = [];
        foreach (["koreksi", "koreksi_lain"] as $blok) {
            $rows = $this->input->post($blok);
            if (!is_array($rows)) continue;
            foreach ($rows as $vals) {
                if (!is_array($vals)) continue;
                $kode = trim((string)($vals["kode"] ?? ""));
                if ($kode === "") continue;
                $clean[] = [
                    "kode" => $kode,
                    "uraian" => trim((string)($vals["uraian"] ?? "")),
                    "debit" => $vals["debit"] ?? 0,
                    "kredit" => $vals["kredit"] ?? 0,
                ];
            }
        }
        $this->Model_posisi_keuangan->saveJurnalManual($tahun, $clean, $this->session->userdata("nama_pengguna"));
        $this->session->set_flashdata("info", "<div class=alert alert-success><strong>Sukses!</strong> Koreksi neraca tahun " . htmlspecialchars($tahun) . " berhasil disimpan.</div>");
        redirect("lembar_kerja/neraca/koreksi?tahun_rkap=" . $tahun);
    }

    public function daftar_akun()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $data = [
            "title" => "MASTER AKUN NERACA",
            "daftarAkun" => $this->Model_posisi_keuangan->getDaftarAkun(),
            "grupList" => $this->Model_posisi_keuangan->grupList(),
            "foldedCodes" => $this->Model_posisi_keuangan->getFoldedCodes(),
            "kodeEdit" => (string)$this->input->get("edit"),
            "posList" => $this->Model_posisi_keuangan->getPosList(),
        ];
        $this->loadViews("lembar_kerja/neraca/view_daftar_akun", $data);
    }

    public function simpan_akun()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $hasil = $this->Model_posisi_keuangan->simpanAkun($this->input->post(), $this->session->userdata("nama_pengguna"));
        $this->session->set_flashdata("info", $hasil["ok"]
            ? "<div class=alert alert-success><strong>Sukses!</strong> " . $hasil["pesan"] . "</div>"
            : "<div class=alert alert-danger><strong>Gagal!</strong> " . $hasil["pesan"] . "</div>");
        redirect("lembar_kerja/neraca/daftar_akun");
    }

    public function toggle_akun()
    {
        if ($this->session->userdata("level") != "Admin") redirect("auth");
        $hasil = $this->Model_posisi_keuangan->setAktifAkun(
            (string)$this->input->post("kode"),
            $this->input->post("aktif") === "1",
            $this->session->userdata("nama_pengguna")
        );
        $this->session->set_flashdata("info", $hasil["ok"]
            ? "<div class=alert alert-success><strong>Sukses!</strong> " . $hasil["pesan"] . "</div>"
            : "<div class=alert alert-danger><strong>Gagal!</strong> " . $hasil["pesan"] . "</div>");
        redirect("lembar_kerja/neraca/daftar_akun");
    }
}
