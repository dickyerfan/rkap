<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ringkasan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Model_laba_rugi');
		$this->load->model('Model_arus_kas');
		$this->load->model('Model_investasi');
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index()
	{
		if ($this->session->userdata('level') != 'Admin') {
			$this->session->set_flashdata(
				'info',
				'<div class="alert alert-danger alert-dismissible fade show" role="alert">
	                    <strong>Maaf,</strong> Anda harus login sebagai Admin...
	                  </div>'
			);
			redirect('auth');
		}

		$tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;
		$upk   = $this->input->get('upk') ?? 'all';

		$this->session->set_userdata('upk', $upk);
		$this->session->set_userdata('tahun_rkap', $tahun);

		$codePendapatanUsaha = ['81.01', '81.02', '81.03'];
		$pendapatan = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codePendapatanUsaha);

		$codeBebanUsaha = ['91', '92', '93', '95'];
		$beban = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codeBebanUsaha);


		$data['beban_umum'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'96'
		]);

		$data['non_usaha'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'88', '98'
		]);

		$data['luar_biasa'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'89.01.01', '99.01.01'
		]);


		// PERHITUNGAN TOTAL-TOTAL
		// Pendapatan
		$pendapatan_usaha_total =
			($pendapatan['81.01']['total'] ?? 0) +
			($pendapatan['81.02']['total'] ?? 0) +
			($pendapatan['81.03']['total'] ?? 0);

		// Beban usaha
		$beban_usaha_total =
			$beban['91']['total'] +
			$beban['92']['total'] +
			$beban['93']['total'] +
			$beban['95']['total'];

		// Laba usaha
		$laba_usaha = $pendapatan_usaha_total - $beban_usaha_total;

		// Beban umum
		$beban_umum_total = $data['beban_umum']['96']['total'];

		// Laba operasional
		$laba_operasional = $laba_usaha - $beban_umum_total;

		// Non usaha
		$pendapatan_non_usaha = $data['non_usaha']['88']['total'];
		$beban_non_usaha      = $data['non_usaha']['98']['total'];
		$selisih_non_usaha    = $pendapatan_non_usaha - $beban_non_usaha;

		// Laba sebelum pajak
		$laba_sebelum_pajak = $laba_operasional + $selisih_non_usaha;

		// Luar biasa
		$keuntungan_lb = $data['luar_biasa']['89.01.01']['total'];
		$kerugian_lb   = $data['luar_biasa']['99.01.01']['total'];
		$selisih_lb    = $keuntungan_lb - $kerugian_lb;

		// Hitung pajak badan
		$codes = ['81.01', '81.02', '81.03', '91', '92', '93', '95', '96', '88', '98'];
		$totals = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codes);

		// hitung laba/rugi komersial (laba sebelum pajak)
		$pendapatan = ($totals['81.01']['total'] ?? 0)
			+ ($totals['81.02']['total'] ?? 0)
			+ ($totals['81.03']['total'] ?? 0)
			+ ($totals['88']['total'] ?? 0);

		$beban = ($totals['91']['total'] ?? 0)
			+ ($totals['92']['total'] ?? 0)
			+ ($totals['93']['total'] ?? 0)
			+ ($totals['95']['total'] ?? 0)
			+ ($totals['96']['total'] ?? 0)
			+ ($totals['98']['total'] ?? 0);

		$laba_komersial = $pendapatan - $beban;

		$next_year = $tahun;
		$get_sum = function ($no_per_id) use ($upk, $next_year) {
			$this->db->select_sum('pagu');
			$this->db->like('no_per_id', $no_per_id, 'after');
			$this->db->where('YEAR(bulan)', $next_year);
			if ($upk !== 'all') {
				$this->db->where('upk', $upk);
			}
			$row = $this->db->get('rkap_rekap')->row();
			return $row ? $row->pagu : 0;
		};

		$beban_representasi = $get_sum->call($this, '96.08.14.10');
		$beban_penyisihan_piutang = $get_sum->call($this, '96.07.01');
		$pendapatan_bunga = $get_sum->call($this, '88.01');

		// BEBAN RAPAT DAN TAMU (sementara 0)
		$beban_rapat_dan_tamu = 0;
		$koreksi_ppn_masukan_amdk = 0;

		// koreksi fiskal positif & negatif
		$koreksi_fiskal_positif = $beban_rapat_dan_tamu + $beban_representasi + $beban_penyisihan_piutang + $koreksi_ppn_masukan_amdk;
		$koreksi_fiskal_negatif = $pendapatan_bunga;

		// laba setelah koreksi fiskal
		$laba_fiskal = ($laba_komersial + $koreksi_fiskal_positif) - $koreksi_fiskal_negatif;

		// nilai tetap dan rasio
		$nilai_tetap = 4800000000;
		// total pendapatan (sesuai catatan Anda: total pendapatan usaha + pendapatan non operasional)
		$total_pendapatan = $pendapatan; // jika perlu tambahkan non-operasional lain, adjust di sini
		$rasio = ($total_pendapatan > 0) ? $nilai_tetap / $total_pendapatan : 0;

		// bagian 1 = proporsi * laba fiskal
		$bagian1 = $laba_fiskal * $rasio;

		// ===== PERBAIKAN: tarif bagian1 sesuai Excel = 25% x 25% x bagian1 =====
		$pajak_bagian1 = 0.25 * 0.25 * $bagian1; // = 0.0625 * bagian1

		// bagian 2 = 12% atas sisa (laba fiskal - bagian1)
		$sisa_laba = $laba_fiskal - $bagian1;
		$pajak_bagian2 = 0.12 * $sisa_laba;

		// total pajak terutang = bagian1 + bagian2
		$pajak_terutang = $pajak_bagian1 + $pajak_bagian2;

		// pembulatan ke ribuan terdekat (sama seperti Excel Anda)
		$pajak_bulat = floor($pajak_terutang / 1000) * 1000;
		$laba_setelah_pajak = ($laba_sebelum_pajak + $selisih_lb) - $pajak_bulat;


		// Kirim ke view

		$data['pendapatan_usaha_total'] = $pendapatan_usaha_total;
		$data['beban_usaha_total'] = $beban_usaha_total;
		$data['laba_usaha'] = $laba_usaha;
		$data['beban_umum_total'] = $beban_umum_total;
		$data['laba_operasional'] = $laba_operasional;
		$data['pendapatan_non_usaha'] = $pendapatan_non_usaha;
		$data['beban_non_usaha'] = $beban_non_usaha;
		$data['selisih_non_usaha'] = $selisih_non_usaha;
		$data['laba_sebelum_pajak'] = $laba_sebelum_pajak;
		$data['keuntungan_luar_biasa'] = $keuntungan_lb;
		$data['kerugian_luar_biasa'] = $kerugian_lb;
		$data['selisih_luar_biasa'] = $selisih_lb;
		$data['biaya_pajak'] = $pajak_bulat;
		$data['laba_setelah_pajak'] = $laba_setelah_pajak;

		// ini untuk arus kas
		$upk = $this->input->get('upk') ?: 'all';
		$tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

		// daftar kode yang ingin diambil totalnya
		$codes = [
			'81.01', '81.02', '88', '81.03',
			'91', '92', '93', '95', '96', '98',
			'31', '62', '50.05', '15.03', '50.01'
		];

		$totals = $this->Model_arus_kas->getTotalsByCodes($tahun, $upk, $codes);
		$penerimaan_air = $totals['81.01']['total'] ?? 0;
		$penerimaan_non_air = $totals['81.02']['total'] ?? 0;
		$penerimaan_usaha = $penerimaan_air + $penerimaan_non_air;
		$penerimaan_non_usaha = $totals['88']['total'] ?? 0;
		$penerimaan_aktiva = $totals['81.03']['total'] ?? 0;
		$penerimaan_total = $penerimaan_usaha + $penerimaan_non_usaha + $penerimaan_aktiva;

		$beban_sumber_air = $totals['91']['total'] ?? 0;
		$beban_pengolahan = $totals['92']['total'] ?? 0;
		$beban_transmisi = $totals['93']['total'] ?? 0;
		$beban_sambungan = $totals['95']['total'] ?? 0;
		$beban_umum = $totals['96']['total'] ?? 0;
		$beban_lain_lain = $totals['98']['total'] ?? 0;
		$pajak = $totals['50.05']['total'] ?? 0;
		$aktiva_lainnya = $totals['15.03']['total'] ?? 0;
		$liabilitas_lainya = $totals['50.01']['total'] ?? 0;
		$investasi = $totals['31']['total'] ?? 0;
		$jasa_produksi = $totals['62']['total'] ?? 0;

		$beban = $beban_sumber_air + $beban_pengolahan + $beban_transmisi + $beban_sambungan + $beban_umum + $pajak + $aktiva_lainnya + $liabilitas_lainya;
		$total_beban = $beban + $beban_lain_lain + $investasi + $jasa_produksi;
		$surplus = $penerimaan_total - $total_beban;

		$query_saldo_awal = $this->db->select('pagu')
			->from('rkap_arus_kas')
			->where('no_per_id', 100)
			->where('YEAR(bulan)', $tahun)
			->get()
			->row();

		$saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
		$saldo_akhir = $saldo_awal_tahun + $surplus;

		// mapping ke variabel lebih mudah dibaca
		$data['total'] = [
			'penerimaan_air'         => $penerimaan_usaha ?? 0,
			'penerimaan_lain_lain'   => $penerimaan_non_usaha ?? 0,
			'penerimaan_aktiva'      => $totals['81.03']['total'] ?? 0,
			'penerimaan_total'       => $penerimaan_total ?? 0,
			'beban'      			 => $beban ?? 0,
			'beban_lain_lain'        => $totals['98']['total'] ?? 0,
			'total_beban'            => $total_beban ?? 0,
			'investasi'              => $totals['31']['total'] ?? 0,
			'jasa_produksi'          => $totals['62']['total'] ?? 0,
			'surplus'                => $surplus,
			'saldo_awal'       		 => $saldo_awal_tahun,
			'saldo_akhir'            => $saldo_akhir

		];

		// investasi
		$data['investasi'] = $this->Model_investasi->get_rekap_per_akun($tahun);

		$data['tahun'] = $tahun;
		$data['title'] = 'RINGKASAN ANGGARAN PDAM KABUPATEN BONDOWOSO';

		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		$this->load->view('templates/sidebar');
		$this->load->view('view_ringkasan', $data);
		$this->load->view('templates/footer');
	}

	public function export_pdf()
	{

		$tahun = $this->session->userdata('tahun_rkap');
		$upk = $this->session->userdata('upk');

		$codePendapatanUsaha = ['81.01', '81.02', '81.03'];
		$pendapatan = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codePendapatanUsaha);

		$codeBebanUsaha = ['91', '92', '93', '95'];
		$beban = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codeBebanUsaha);


		$data['beban_umum'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'96'
		]);

		$data['non_usaha'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'88', '98'
		]);

		$data['luar_biasa'] = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, [
			'89.01.01', '99.01.01'
		]);


		// PERHITUNGAN TOTAL-TOTAL
		// Pendapatan
		$pendapatan_usaha_total =
			($pendapatan['81.01']['total'] ?? 0) +
			($pendapatan['81.02']['total'] ?? 0) +
			($pendapatan['81.03']['total'] ?? 0);

		// Beban usaha
		$beban_usaha_total =
			$beban['91']['total'] +
			$beban['92']['total'] +
			$beban['93']['total'] +
			$beban['95']['total'];

		// Laba usaha
		$laba_usaha = $pendapatan_usaha_total - $beban_usaha_total;

		// Beban umum
		$beban_umum_total = $data['beban_umum']['96']['total'];

		// Laba operasional
		$laba_operasional = $laba_usaha - $beban_umum_total;

		// Non usaha
		$pendapatan_non_usaha = $data['non_usaha']['88']['total'];
		$beban_non_usaha      = $data['non_usaha']['98']['total'];
		$selisih_non_usaha    = $pendapatan_non_usaha - $beban_non_usaha;

		// Laba sebelum pajak
		$laba_sebelum_pajak = $laba_operasional + $selisih_non_usaha;

		// Luar biasa
		$keuntungan_lb = $data['luar_biasa']['89.01.01']['total'];
		$kerugian_lb   = $data['luar_biasa']['99.01.01']['total'];
		$selisih_lb    = $keuntungan_lb - $kerugian_lb;

		// Hitung pajak badan
		$codes = ['81.01', '81.02', '81.03', '91', '92', '93', '95', '96', '88', '98'];
		$totals = $this->Model_laba_rugi->getTotalsByCodes($tahun, $upk, $codes);

		// hitung laba/rugi komersial (laba sebelum pajak)
		$pendapatan = ($totals['81.01']['total'] ?? 0)
			+ ($totals['81.02']['total'] ?? 0)
			+ ($totals['81.03']['total'] ?? 0)
			+ ($totals['88']['total'] ?? 0);

		$beban = ($totals['91']['total'] ?? 0)
			+ ($totals['92']['total'] ?? 0)
			+ ($totals['93']['total'] ?? 0)
			+ ($totals['95']['total'] ?? 0)
			+ ($totals['96']['total'] ?? 0)
			+ ($totals['98']['total'] ?? 0);

		$laba_komersial = $pendapatan - $beban;

		$next_year = $tahun;
		$get_sum = function ($no_per_id) use ($upk, $next_year) {
			$this->db->select_sum('pagu');
			$this->db->like('no_per_id', $no_per_id, 'after');
			$this->db->where('YEAR(bulan)', $next_year);
			if ($upk !== 'all') {
				$this->db->where('upk', $upk);
			}
			$row = $this->db->get('rkap_rekap')->row();
			return $row ? $row->pagu : 0;
		};

		$beban_representasi = $get_sum->call($this, '96.08.14.10');
		$beban_penyisihan_piutang = $get_sum->call($this, '96.07.01');
		$pendapatan_bunga = $get_sum->call($this, '88.01');

		// BEBAN RAPAT DAN TAMU (sementara 0)
		$beban_rapat_dan_tamu = 0;
		$koreksi_ppn_masukan_amdk = 0;

		// koreksi fiskal positif & negatif
		$koreksi_fiskal_positif = $beban_rapat_dan_tamu + $beban_representasi + $beban_penyisihan_piutang + $koreksi_ppn_masukan_amdk;
		$koreksi_fiskal_negatif = $pendapatan_bunga;

		// laba setelah koreksi fiskal
		$laba_fiskal = ($laba_komersial + $koreksi_fiskal_positif) - $koreksi_fiskal_negatif;

		// nilai tetap dan rasio
		$nilai_tetap = 4800000000;
		// total pendapatan (sesuai catatan Anda: total pendapatan usaha + pendapatan non operasional)
		$total_pendapatan = $pendapatan; // jika perlu tambahkan non-operasional lain, adjust di sini
		$rasio = ($total_pendapatan > 0) ? $nilai_tetap / $total_pendapatan : 0;

		// bagian 1 = proporsi * laba fiskal
		$bagian1 = $laba_fiskal * $rasio;

		// ===== PERBAIKAN: tarif bagian1 sesuai Excel = 25% x 25% x bagian1 =====
		$pajak_bagian1 = 0.25 * 0.25 * $bagian1; // = 0.0625 * bagian1

		// bagian 2 = 12% atas sisa (laba fiskal - bagian1)
		$sisa_laba = $laba_fiskal - $bagian1;
		$pajak_bagian2 = 0.12 * $sisa_laba;

		// total pajak terutang = bagian1 + bagian2
		$pajak_terutang = $pajak_bagian1 + $pajak_bagian2;

		// pembulatan ke ribuan terdekat (sama seperti Excel Anda)
		$pajak_bulat = floor($pajak_terutang / 1000) * 1000;
		$laba_setelah_pajak = ($laba_sebelum_pajak + $selisih_lb) - $pajak_bulat;


		// Kirim ke view

		$data['pendapatan_usaha_total'] = $pendapatan_usaha_total;
		$data['beban_usaha_total'] = $beban_usaha_total;
		$data['laba_usaha'] = $laba_usaha;
		$data['beban_umum_total'] = $beban_umum_total;
		$data['laba_operasional'] = $laba_operasional;
		$data['pendapatan_non_usaha'] = $pendapatan_non_usaha;
		$data['beban_non_usaha'] = $beban_non_usaha;
		$data['selisih_non_usaha'] = $selisih_non_usaha;
		$data['laba_sebelum_pajak'] = $laba_sebelum_pajak;
		$data['keuntungan_luar_biasa'] = $keuntungan_lb;
		$data['kerugian_luar_biasa'] = $kerugian_lb;
		$data['selisih_luar_biasa'] = $selisih_lb;
		$data['biaya_pajak'] = $pajak_bulat;
		$data['laba_setelah_pajak'] = $laba_setelah_pajak;

		// ini untuk arus kas
		$upk = $this->input->get('upk') ?: 'all';
		$tahun = $this->input->get('tahun_rkap') ?: date('Y') + 1;

		// daftar kode yang ingin diambil totalnya
		$codes = [
			'81.01', '81.02', '88', '81.03',
			'91', '92', '93', '95', '96', '98',
			'31', '62', '50.05', '15.03', '50.01'
		];

		$totals = $this->Model_arus_kas->getTotalsByCodes($tahun, $upk, $codes);
		$penerimaan_air = $totals['81.01']['total'] ?? 0;
		$penerimaan_non_air = $totals['81.02']['total'] ?? 0;
		$penerimaan_usaha = $penerimaan_air + $penerimaan_non_air;
		$penerimaan_non_usaha = $totals['88']['total'] ?? 0;
		$penerimaan_aktiva = $totals['81.03']['total'] ?? 0;
		$penerimaan_total = $penerimaan_usaha + $penerimaan_non_usaha + $penerimaan_aktiva;

		$beban_sumber_air = $totals['91']['total'] ?? 0;
		$beban_pengolahan = $totals['92']['total'] ?? 0;
		$beban_transmisi = $totals['93']['total'] ?? 0;
		$beban_sambungan = $totals['95']['total'] ?? 0;
		$beban_umum = $totals['96']['total'] ?? 0;
		$beban_lain_lain = $totals['98']['total'] ?? 0;
		$pajak = $totals['50.05']['total'] ?? 0;
		$aktiva_lainnya = $totals['15.03']['total'] ?? 0;
		$liabilitas_lainya = $totals['50.01']['total'] ?? 0;
		$investasi = $totals['31']['total'] ?? 0;
		$jasa_produksi = $totals['62']['total'] ?? 0;

		$beban = $beban_sumber_air + $beban_pengolahan + $beban_transmisi + $beban_sambungan + $beban_umum + $pajak + $aktiva_lainnya + $liabilitas_lainya;
		$total_beban = $beban + $beban_lain_lain + $investasi + $jasa_produksi;
		$surplus = $penerimaan_total - $total_beban;

		$query_saldo_awal = $this->db->select('pagu')
			->from('rkap_arus_kas')
			->where('no_per_id', 100)
			->where('YEAR(bulan)', $tahun)
			->get()
			->row();

		$saldo_awal_tahun = $query_saldo_awal ? (float)$query_saldo_awal->pagu : 0;
		$saldo_akhir = $saldo_awal_tahun + $surplus;

		// mapping ke variabel lebih mudah dibaca
		$data['total'] = [
			'penerimaan_air'         => $penerimaan_usaha ?? 0,
			'penerimaan_lain_lain'   => $penerimaan_non_usaha ?? 0,
			'penerimaan_aktiva'      => $totals['81.03']['total'] ?? 0,
			'penerimaan_total'       => $penerimaan_total ?? 0,
			'beban'      			 => $beban ?? 0,
			'beban_lain_lain'        => $totals['98']['total'] ?? 0,
			'total_beban'            => $total_beban ?? 0,
			'investasi'              => $totals['31']['total'] ?? 0,
			'jasa_produksi'          => $totals['62']['total'] ?? 0,
			'surplus'                => $surplus,
			'saldo_awal'       		 => $saldo_awal_tahun,
			'saldo_akhir'            => $saldo_akhir

		];

		// investasi
		$data['investasi'] = $this->Model_investasi->get_rekap_per_akun($tahun);

		$data['tahun'] = $tahun;
		$data['title'] = 'RINGKASAN ANGGARAN PDAM KABUPATEN BONDOWOSO';


		// Setting PDF
		$this->pdf->setPaper('Folio', 'landscape');
		$this->pdf->filename = "ringkasan_rkap_{$tahun}.pdf";

		// Generate dari view khusus PDF
		$this->pdf->generate('laporan_ringkasan_pdf', $data);
	}
}
