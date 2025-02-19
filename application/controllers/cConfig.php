<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cConfig extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->ceklogin();
        $this->cek_akses();
    }

    public function BankAccount()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'config/bankaccount';
        $this->go_to($view, $data);
    }

    public function BankAccountOutlet()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'config/bankaccountoutlet';
        $this->go_to($view, $data);
    }

    public function Profile()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'config/profile';
        $this->go_to($view, $data);
    }
}
