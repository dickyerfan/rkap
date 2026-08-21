<?php
class MY_Controller extends CI_Controller
{
    protected $status_periode;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_status');

        // Deteksi request heartbeat ping - skip touch_activity untuk hemat resource.
        // Session expiry ditangani oleh custom MY_Session_files_driver yang tidak
        // memanggil touch() saat session data tidak berubah.
        $isPing = (strpos($_SERVER['REQUEST_URI'] ?? '', '/ping') !== false);

        if (!$isPing) {
            // Heartbeat: tandai user yang masih login sebagai aktif pada tiap halaman.
            // Dipakai untuk deteksi online realtime di modul Monitoring User Login.
            if ($this->session->userdata('nama_pengguna')) {
                $this->load->model('Model_user_log');
                $this->Model_user_log->touch_activity(session_id());
            }

            // gunakan tahun yang sesuai; bisa pakai session tahun_rkap jika ada
            $tahun = $this->session->userdata('tahun_rkap') ?: date('Y');
            $this->status_periode = $this->Model_status->get_status_periode($tahun);

            // --- membuat $status_periode tersedia di semua view ---
            $this->load->vars(['status_periode' => $this->status_periode]);
        }
    }
}
