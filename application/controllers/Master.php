<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->ceklogin();
        $this->cek_akses();
    }

    public function Bank()
    {
        extract(populateform());
        $data['name'] = $this->input->cookie('cookie_invent_user');
        $data['site_url'] = $this->siteURL();

        $view = 'master/banktype';
        $this->go_to($view, $data);
    }

    public function Add_BankType()
    {
        extract(populateform());
        $userlogin = $this->input->cookie("cookie_invent_user");

        $data['hasil'] = $this->db->query("[w_InsertUpdateBankType] " . $fa . ",'" . $kodebank . "','" . $namabank . "','" . $descriptbank . "','" . $userlogin . "' ")->result();

        // var_dump($data[0]->MsgError);
        // var_dump($data[0]->Result);

        echo json_encode($data);
    }

    public function Delete_BankType()
    {
        extract(populateform());
        $data['hasil'] = $this->db->query("[w_DeleteBankType] " . $BankCode . " ")->result();

        echo json_encode($data);
    }

    public function BankAccountEmp()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'master/bankaccountemp';
        $this->go_to($view, $data);
    }

    public function BankAccountOutlet()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'master/bankaccountoutlet';
        $this->go_to($view, $data);
    }

    public function Add_Baccount()
    {
        extract(populateform());
        $data['name'] = $this->input->cookie('cookie_invent_user');
        $data['site_url'] = $this->siteURL();
        $ptcode = 'CPP';
        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $ptcode . "','' ");
        $data['ListBank'] = $this->Models->showdata("SELECT * FROM w_BankType WITH(READPAST) WHERE Active = 1 ORDER BY IdBank ASC");

        $view = 'master/add_bankaccount';
        $this->go_to($view, $data);
    }

    public function ListEmail()
    {
        extract(populateform());
        $data['name'] = $this->input->cookie('cookie_invent_user');
        $data['site_url'] = $this->siteURL();

        $view = 'master/listemail';
        $this->go_to($view, $data);
    }

    public function Outlet()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $view = 'master/listcustomer';
        $this->go_to($view, $data);
    }

    public function ImportBankAccount()
    {
        extract(populateform());
        $data['name'] = $this->input->cookie('cookie_invent_user');
        $data['site_url'] = $this->siteURL();
        $ptcode = 'CPP';
        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $ptcode . "','' ");
        $data['ListBank'] = $this->Models->showdata("SELECT * FROM w_BankType WITH(READPAST) WHERE Active = 1 ORDER BY IdBank ASC");

        $view = 'master/importbankacc';
        $this->go_to($view, $data);
    }
}
