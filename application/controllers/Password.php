<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		if (!$this->session->userdata('nama_pengguna')) {
			redirect('auth');
		}
	}

	public function index()
	{
		$data['title'] = "Ganti password";

		$this->form_validation->set_rules('passLama', 'Password Lama', 'required|trim');
		$this->form_validation->set_rules('passBaru', 'Password Baru', 'required|trim|min_length[4]');
		$this->form_validation->set_rules('passConf', 'Password Konfirmasi', 'required|trim|matches[passBaru]');
		$this->form_validation->set_message('required', '%s Harus di isi');
		$this->form_validation->set_message('min_length', '%s Minimal 5 karakter');
		$this->form_validation->set_message('matches', '%s harus sama dengan password baru');

		if ($this->form_validation->run() == false) {
			if ($this->session->userdata('level') != 'Admin') {
				$this->load->view('templates/pengguna/header', $data);
				$this->load->view('templates/pengguna/navbar');
				$this->load->view('templates/pengguna/sidebar');
				$this->load->view('view_gantiPassword', $data);
				$this->load->view('templates/pengguna/footer');
			} else {
				$this->load->view('templates/header', $data);
				$this->load->view('templates/navbar');
				$this->load->view('templates/sidebar');
				$this->load->view('view_gantiPassword', $data);
				$this->load->view('templates/footer');
			}
		} else {
			$cek_pass = $this->db->get_where('user', ['nama_pengguna' => $this->session->userdata('nama_pengguna')])->row();
			$passwordLama = $this->input->post('passLama');
			$passwordBaru = $this->input->post('passBaru');

			if (!password_verify($passwordLama, $cek_pass->password)) {
				$this->session->set_flashdata(
					'info',
					'<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
							<strong>Maaf,</strong> Password saat ini salah
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
							</button>
						  </div>'
				);
				redirect('password');
			} else {
				if ($passwordLama == $passwordBaru) {
					$this->session->set_flashdata(
						'info',
						'<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
								<strong>Maaf,</strong> Password lama tidak boleh sama dengan password baru
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
								</button>
							  </div>'
					);
					redirect('password');
				} else {
					$passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);
					$this->db->set('password', $passwordHash);
					$this->db->where('nama_pengguna', $this->session->userdata('nama_pengguna'));
					$this->db->update('user');

					$this->session->set_flashdata(
						'info',
						'<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:50%;">
								<strong>Selamat,</strong> Password berhasil di ganti
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
								</button>
							  </div>'
					);
					redirect('auth/logout');
				}
			}
		}
	}

	public function profil()
	{
		$data['title'] = "Profil";
		if ($this->session->userdata('level') != 'Admin') {
			$this->load->view('templates/pengguna/header', $data);
			$this->load->view('templates/pengguna/navbar');
			$this->load->view('templates/pengguna/sidebar');
			$this->load->view('view_profil', $data);
			$this->load->view('templates/pengguna/footer');
		} else {
			$this->load->view('templates/header', $data);
			$this->load->view('templates/navbar');
			$this->load->view('templates/sidebar');
			$this->load->view('view_profil', $data);
			$this->load->view('templates/footer');
		}
	}
}
