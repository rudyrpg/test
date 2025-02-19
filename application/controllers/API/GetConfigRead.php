<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetConfigRead extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->ceklogin();
    }

    public function GetListBankAccount()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $PTCode = $this->input->cookie("cookie_invent_pt");

        $sql = "[w_BankAccountRead] " . $fa . ",'" . $PTCode . "','' ";
        $data['hasil'] = $this->Models->showdata($sql);

        echo json_encode($data);
    }
}
