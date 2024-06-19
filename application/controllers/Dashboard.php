<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('form_validation');
		// if ($this->session->userdata('level') != 'Admin') {
		// 	redirect('publik');
		// }
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

		$data['direktur'] = $this->db->query("SELECT * FROM karyawan LEFT JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan WHERE jabatan.nama_jabatan = 'Direktur' AND aktif = '1' ")->row();

		//SPI
		$data['spi'] = $this->db->query("SELECT * FROM karyawan LEFT JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan WHERE jabatan.nama_jabatan = 'Ketua' AND aktif = '1' ")->row();

		$data['a_spi'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Anggota' AND bagian.nama_bagian = 'S P I' AND subag.nama_subag = 'S P I' AND aktif = '1' ")->result();

		// Langganan
		$data['lang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Langganan' AND aktif = '1' ")->row();

		$data['k_lang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Langganan' AND aktif = '1' ")->row();

		$data['s_lang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Langganan' AND aktif = '1' ")->result();

		$data['k_tagih'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Penagihan' AND aktif = '1' ")->row();

		$data['s_tagih'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Penagihan' AND aktif = '1' ")->result();

		//Umum
		$data['umum'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Umum' AND aktif = '1' ")->row();

		$data['k_umum'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->row();

		$data['s_umum'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->result();

		$data['s_umumSec'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Security)' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->result();

		$data['k_admin'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->row();

		$data['s_admin'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->result();

		$data['k_person'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Personalia' AND aktif = '1' ")->row();

		$data['s_person'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Personalia' AND aktif = '1' ")->result();

		//Keuangan
		$data['keu'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Keuangan' AND aktif = '1' ")->row();

		$data['k_kas'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Kas' AND aktif = '1' ")->row();

		$data['s_kas'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Kas' AND aktif = '1' ")->result();

		$data['k_buku'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Pembukuan' AND aktif = '1' ")->row();

		$data['s_buku'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Pembukuan' AND aktif = '1' ")->result();

		$data['k_rek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Rekening' AND aktif = '1' ")->row();

		$data['s_rek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Rekening' AND aktif = '1' ")->result();

		//Perencanaan
		$data['renc'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Perencanaan' AND aktif = '1' ")->row();

		$data['k_renc'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'Perencanaan' AND aktif = '1' ")->row();

		$data['s_renc'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'Perencanaan' AND aktif = '1' ")->result();

		$data['k_awas'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'pengawasan' AND aktif = '1' ")->row();

		$data['s_awas'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'pengawasan' AND aktif = '1' ")->result();

		//Pemeliharaan
		$data['peml'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Pemeliharaan' AND aktif = '1' ")->row();

		$data['k_peml'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->row();

		$data['s_peml_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->result();

		$data['s_peml_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->result();

		$data['k_alat'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->row();

		$data['s_alat_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->result();

		$data['s_alat_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->result();

		//Bondowoso
		$data['bond'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

		$data['bond_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

		$data['bond_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

		$data['bond_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

		$data['bond_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

		$data['bond_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

		$data['bond_p_lang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Pelayanan Pelanggan' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

		$data['bond_s_lang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Pelayanan Pelanggan' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

		// sukosari 1
		$data['suko1'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

		$data['suko1_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

		$data['suko1_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

		$data['suko1_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

		$data['suko1_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

		$data['suko1_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

		// Maesan
		$data['maesan'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

		$data['maesan_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

		$data['maesan_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

		$data['maesan_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

		$data['maesan_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

		$data['maesan_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

		// Tegalampel
		$data['tegalampel'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

		$data['tegalampel_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

		$data['tegalampel_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();

		$data['tegalampel_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();

		$data['tegalampel_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

		$data['tegalampel_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();


		// Tapen
		$data['tapen'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

		$data['tapen_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

		$data['tapen_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

		$data['tapen_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

		$data['tapen_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

		$data['tapen_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

		// Prajekan
		$data['prajekan'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

		$data['prajekan_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

		$data['prajekan_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

		$data['prajekan_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

		$data['prajekan_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

		$data['prajekan_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

		// Tlogosari
		$data['tlogosari'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

		$data['tlogosari_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

		$data['tlogosari_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

		$data['tlogosari_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

		$data['tlogosari_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

		$data['tlogosari_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

		// Wringin
		$data['wringin'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

		$data['wringin_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

		$data['wringin_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

		$data['wringin_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

		$data['wringin_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

		$data['wringin_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

		// Curahdami
		$data['curahdami'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->row();

		$data['curahdami_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->row();

		$data['curahdami_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

		$data['curahdami_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

		$data['curahdami_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'curahdami' AND aktif = '1' ")->row();

		$data['curahdami_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

		// Tamanan
		$data['tamanan'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

		$data['tamanan_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

		$data['tamanan_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

		$data['tamanan_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

		$data['tamanan_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

		$data['tamanan_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

		// Tenggarang
		$data['tenggarang'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

		$data['tenggarang_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

		$data['tenggarang_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

		$data['tenggarang_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

		$data['tenggarang_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

		$data['tenggarang_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

		// Tamankrocok
		$data['tamankrocok'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

		$data['tamankrocok_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

		$data['tamankrocok_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

		$data['tamankrocok_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

		$data['tamankrocok_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

		$data['tamankrocok_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

		// Wonosari
		$data['wonosari'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

		$data['wonosari_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

		$data['wonosari_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->result();

		$data['wonosari_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wonosari' AND aktif = '1' ")->result();

		$data['wonosari_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

		$data['wonosari_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->result();

		// Sukosari 2
		$data['suko2'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

		$data['suko2_p_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

		$data['suko2_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();

		$data['suko2_s_admPm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();

		$data['suko2_p_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

		$data['suko2_s_tek'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();

		//Amdk
		$data['amdk'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Manager' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'A M D K' AND aktif = '1' ")->row();

		$data['amdk_qc'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Quality Control' AND aktif = '1' ")->row();

		$data['amdk_s_qc'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Quality Control' AND aktif = '1' ")->result();

		$data['amdk_pro'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Produksi' AND aktif = '1' ")->row();

		$data['amdk_s_pro'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Produksi' AND aktif = '1' ")->result();

		$data['amdk_pasar'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Pemasaran' AND aktif = '1' ")->row();

		$data['amdk_s_pasar'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Pemasaran' AND aktif = '1' ")->result();

		$data['amdk_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->row();

		$data['amdk_s_adm'] = $this->db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.id_jabatan = jabatan.id_jabatan JOIN bagian ON karyawan.id_bagian = bagian.id_bagian JOIN subag ON karyawan.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->result();

		$data['title'] = 'Dashboard';
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');
		$this->load->view('templates/sidebar');
		$this->load->view('view_dashboard', $data);
		$this->load->view('templates/footer');
	}
}
