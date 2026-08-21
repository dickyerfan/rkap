<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_log extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user_log');

        // Endpoint `ping` dipakai sebagai heartbeat AJAX oleh SEMUA user yang
        // login (bukan hanya admin), sehingga tidak ikut dibatasi akses.
        $method = $this->router->fetch_method();
        if ($method === 'ping') {
            return;
        }

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

        // Filter rentang tanggal untuk riwayat
        $data['dari']   = $this->input->get('dari');
        $data['sampai'] = $this->input->get('sampai');

        if ($data['dari'] || $data['sampai']) {
            // Filter tanggal aktif: tampilkan sesuai rentang yang dipilih
            $data['history'] = $this->Model_user_log->get_history(500, $data['dari'], $data['sampai']);
            $data['filtered'] = true;
        } else {
            // Default: tampilkan hanya hari ini + kemarin saja
            $yesterday = date('Y-m-d', strtotime('-1 day'));
            $data['history'] = $this->Model_user_log->get_history(500, $yesterday);
            $data['filtered'] = false;
        }

        $data['stats'] = $this->Model_user_log->get_stats();

        // Menentukan tab yang aktif (agar setelah filter tetap di tab Riwayat)
        $data['active_tab'] = ($this->input->get('tab') === 'history') ? 'history' : 'online';

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

    /**
     * Endpoint heartbeat AJAX (dipanggil by footer tiap ~60 detik).
     * Hanya memperbarui last_activity di database user_login_log.
     *
     * Session ID diambil dari query string 'sid' (bukan dari session_id()
     * atau $this->session) agar tidak ada akses ke session CodeIgniter.
     */
    public function ping()
    {
        $sid = $this->input->get('sid', true);

        if ($sid) {
            $this->Model_user_log->touch_activity($sid);
        }

        echo json_encode([
            'success' => true,
            'time'    => date('H:i:s'),
        ]);
    }
}