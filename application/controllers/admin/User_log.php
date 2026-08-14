<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user_log');

        // Hanya Admin dengan tipe admin yang boleh mengakses menu ini
        if ($this->session->userdata('level') != 'Admin' || $this->session->userdata('tipe') != 'admin') {
            $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Dilarang!</strong> Anda tidak memiliki akses ke halaman ini.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['title'] = 'Monitoring User Login';
        $data['online_users'] = $this->Model_user_log->get_online_users();
        $data['history'] = $this->Model_user_log->get_history(100);
        $data['stats'] = $this->Model_user_log->get_stats();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('admin/view_user_log', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Endpoint AJAX untuk auto-refresh data online.
     */
    public function get_online()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $online = $this->Model_user_log->get_online_users();
        $stats = $this->Model_user_log->get_stats();

        echo json_encode([
            'success' => true,
            'stats'   => $stats,
            'online'  => $online,
        ]);
    }
}