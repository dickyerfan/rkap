<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IjenWater extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_dashboard');
        $this->load->library('form_validation');
    }

    public function index()
    {

        $data['title'] = 'Beranda';
        $this->load->view('templates/ijenWater/header', $data);
        $this->load->view('view_ijenWater', $data);
        $this->load->view('templates/ijenWater/footer');
    }
}
