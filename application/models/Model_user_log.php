<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user_log extends CI_Model
{
    /**
     * Catat event login.
     * Membuat record baru dengan logout_time = NULL (menandakan masih online).
     */
    public function log_login($username, $nama_lengkap, $level, $tipe)
    {
        $data = [
            'username'      => $username,
            'nama_lengkap'  => $nama_lengkap,
            'level'         => $level,
            'tipe'          => $tipe,
            'ip_address'    => $this->input->ip_address(),
            'user_agent'    => substr($this->input->user_agent(), 0, 250),
            'login_time'    => date('Y-m-d H:i:s'),
            'logout_time'   => null,
        ];

        return $this->db->insert('user_login_log', $data);
    }

    /**
     * Catat event logout.
     * Set logout_time = NOW() pada record terbaru yang belum logout.
     */
    public function log_logout($username)
    {
        $this->db->where('username', $username);
        $this->db->where('logout_time IS NULL');
        return $this->db->update('user_login_log', [
            'logout_time' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Daftar user yang sedang online (belum logout).
     * Diurutkan dari yang paling baru login.
     */
    public function get_online_users()
    {
        return $this->db
            ->select('user_login_log.*')
            ->from('user_login_log')
            ->where('logout_time IS NULL')
            ->order_by('login_time', 'DESC')
            ->get()
            ->result_array();
    }

    /**
     * Riwayat login terakhir.
     */
    public function get_history($limit = 100)
    {
        return $this->db
            ->select('user_login_log.*')
            ->from('user_login_log')
            ->order_by('login_time', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result_array();
    }

    /**
     * Statistik ringkas untuk dashboard monitoring.
     */
    public function get_stats()
    {
        // Total user sedang online
        $total_online = $this->db
            ->where('logout_time IS NULL')
            ->count_all_results('user_login_log');

        // Total login hari ini
        $total_login_hari_ini = $this->db
            ->where('DATE(login_time)', date('Y-m-d'))
            ->count_all_results('user_login_log');

        // Total user aktif (status = 1) dari tabel user
        $total_user_aktif = $this->db
            ->where('status', 1)
            ->count_all_results('user');

        return [
            'total_online'        => (int) $total_online,
            'login_hari_ini'      => (int) $total_login_hari_ini,
            'total_user_aktif'    => (int) $total_user_aktif,
        ];
    }
}
