<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_user_log extends CI_Model
{
    /**
     * Jendela waktu (menit) user dianggap masih "online" sejak aktivitas
     * terakhir (last_activity). Setelahnya record dianggap offline walaupun
     * logout_time masih NULL (mengakomodasi user yang menutup tab tanpa logout).
     */
    private $OFFLINE_AFTER_MINUTES = 10;

    /**
     * Catat event login.
     * Membuat record baru dengan logout_time = NULL dan last_activity = sekarang,
     * diikat ke session_id yang sedang aktif.
     */
    public function log_login($username, $nama_lengkap, $level, $tipe)
    {
        $now = date('Y-m-d H:i:s');
        $data = [
            'username'      => $username,
            'nama_lengkap'  => $nama_lengkap,
            'level'         => $level,
            'tipe'          => $tipe,
            'ip_address'    => $this->get_client_ip(),
            'user_agent'    => substr($this->input->user_agent(), 0, 250),
            'login_time'    => $now,
            'logout_time'   => null,
            'session_id'    => session_id(),
            'last_activity' => $now,
        ];

        return $this->db->insert('user_login_log', $data);
    }

    /**
     * Catat event logout pada record yang masih aktif di session ini.
     * Diupdate berdasarkan session_id agar tidak menimpa perangkat lain
     * yang masih login dengan username yang sama.
     */
    public function log_logout($username = null)
    {
        $sid = session_id();
        $this->db->where('session_id', $sid);
        $this->db->where('logout_time IS NULL');

        return $this->db->update('user_login_log', [
            'logout_time'   => date('Y-m-d H:i:s'),
            'last_activity' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Heartbeat: perbarui last_activity record yang masih aktif pada session ini.
     * Dipanggil di setiap halaman (MY_Controller) dan lewat ping AJAX (footer).
     */
    public function touch_activity($session_id)
    {
        if (!$session_id) return false;

        return $this->db
            ->where('session_id', $session_id)
            ->where('logout_time IS NULL')
            ->update('user_login_log', [
                'last_activity' => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Auto-expire: record yang logout_time NULL tapi sudah tidak ada aktivitas
     * lebih dari OFFLINE_AFTER_MINUTES dianggap offline. logout_time diisi dengan
     * waktu aktivitas terakhir agar durasi login tetap masuk akal.
     */
    private function expire_stale_sessions()
    {
        $batas = date('Y-m-d H:i:s', strtotime('-' . $this->OFFLINE_AFTER_MINUTES . ' minutes'));

        $this->db->query(
            "UPDATE user_login_log SET logout_time = last_activity
             WHERE logout_time IS NULL AND last_activity < " . $this->db->escape($batas)
        );
    }

    /**
     * Daftar user yang sedang online (belum logout + masih aktif dalam
     * OFFLINE_AFTER_MINUTES menit). Diurutkan dari yang paling baru aktif.
     */
    public function get_online_users()
    {
        $this->expire_stale_sessions();

        $batas = date('Y-m-d H:i:s', strtotime('-' . $this->OFFLINE_AFTER_MINUTES . ' minutes'));

        return $this->db
            ->select('user_login_log.*')
            ->from('user_login_log')
            ->where('logout_time IS NULL')
            ->where('last_activity >=', $batas)
            ->order_by('last_activity', 'DESC')
            ->get()
            ->result_array();
    }

    /**
     * Riwayat login terakhir, bisa difilter rentang tanggal (dari / sampai).
     */
    public function get_history($limit = 300, $dari = null, $sampai = null)
    {
        if ($dari)   $this->db->where('login_time >=', $dari . ' 00:00:00');
        if ($sampai) $this->db->where('login_time <=', $sampai . ' 23:59:59');

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
        $this->expire_stale_sessions();

        $batas = date('Y-m-d H:i:s', strtotime('-' . $this->OFFLINE_AFTER_MINUTES . ' minutes'));

        // Total user sedang online (masih aktif dalam 10 menit terakhir)
        $total_online = $this->db
            ->where('logout_time IS NULL')
            ->where('last_activity >=', $batas)
            ->count_all_results('user_login_log');

        // Total event login hari ini
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

    /**
     * Ambil IP asli pengunjung. Mengutamakan header dari proxy/CDN
     * (Cloudflare, Nginx, reverse proxy) lalu fallback ke REMOTE_ADDR.
     * $this->input->ip_address() di CodeIgniter 3 tidak membaca header itu.
     */
    private function get_client_ip()
    {
        $keys = [
            'HTTP_CF_CONNECTING_IP', // Cloudflare
            'HTTP_X_FORWARDED_FOR',  // proxy / load balancer (bisa berantai)
            'HTTP_X_REAL_IP',        // Nginx proxy
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR',
        ];

        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                // X-Forwarded-For bisa berisi "ip1, ip2, ..." -> ambil yang pertama (klien asli)
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP)) {
                        return $ip;
                    }
                }
            }
        }

        return $this->input->ip_address();
    }
}