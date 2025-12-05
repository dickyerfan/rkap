<?php
class MY_Controller extends CI_Controller
{
    protected $status_periode;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_status');

        // gunakan tahun yang sesuai; bisa pakai session tahun_rkap jika ada
        $tahun = $this->session->userdata('tahun_rkap') ?: date('Y');
        $this->status_periode = $this->Model_status->get_status_periode($tahun);

        // --- membuat $status_periode tersedia di semua view ---
        $this->load->vars(['status_periode' => $this->status_periode]);
    }
}
