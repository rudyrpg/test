<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetMasterRead extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->ceklogin();
    }

    public function GetListBank()
    {
        extract(populateform());
        $id = $this->input->post('Id');
        $sql = "SELECT * FROM dbo.w_BankType WITH(NOLOCK) ORDER BY BankCode ASC";
        $data['hasil'] = $this->Models->showdata($sql);
        if ($id != null) {
            $sql .= " WHERE IdBank = $id";
        }
        echo json_encode($data);
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

    public function GetBankAccountPerOutlet($outletcode)
    {
        extract(populateform());
        $PTCode = $this->input->cookie("cookie_invent_pt");

        $fa = 4;
        $data['hasil'] = $this->Models->showdata("[w_BankAccountRead] '" . $fa . "','" . $PTCode . "','" . $outletcode . "' ");
        foreach ($data['hasil'] as $brow) {
            echo "<option value='" . $brow->NoRekening . "'>" . $brow->TypeBayar . " - [" . $brow->NameRekening . "]</option>";
        }
    }

    public function GetBankAccountEmployee()
    {
        extract(populateform());
        $PTCode = $this->input->cookie("cookie_invent_pt");

        $fa = 1;
        $data['hasil'] = $this->Models->showdata("[w_BankAccountRead] '" . $fa . "','" . $PTCode . "','' ");
        foreach ($data['hasil'] as $emprow) {
            echo "<option value='" . $emprow->BankAccountNo . "'>" . $emprow->ShortDesc . " - [" . $emprow->FullName . "]</option>";
        }
    }

    public function GetListEmail()
    {
        extract(populateform());
        $id = $this->input->post('Id');
        $sql = "SELECT * FROM dbo.w_BankType WITH(NOLOCK) ORDER BY BankCode ASC";
        $data['hasil'] = $this->Models->showdata($sql);
        if ($id != null) {
            $sql .= " WHERE IdBank = $id";
        }
        echo json_encode($data);
    }

    public function GetListOutlet()
    {
        extract(populateform());
        $PTCode = $this->input->cookie("cookie_invent_pt");

        // $sql = "SELECT * FROM dbo.Customer WHERE [Status] = 1 AND ClosingStatus = 1 AND PTCode = 'CPP' ORDER BY CustomerCode ASC";
        $sql = "[w_CustomerRead] " . $fa . ",'" . $PTCode . "','' ";
        $data['hasil'] = $this->Models->showdata($sql);

        echo json_encode($data);
    }

    public function GetListEmailEmployee()
    {
        extract(populateform());
        $PTCode = $this->input->cookie("cookie_invent_pt");

        $fa = 1;
        $data['hasil'] = $this->Models->showdata("[w_EmailRead] '" . $fa . "','" . $PTCode . "','' ");
        // echo "<option value=''>-- Pilih Tipe --</option>";
        foreach ($data['hasil'] as $row) {
            echo "<option value='" . $row->Email . "'>" . $row->FullName . " - [ " . $row->Email . " ]</option>";
        }
    }

    public function GetListEmailOutlet($outletcode)
    {
        extract(populateform());
        $PTCode = $this->input->cookie("cookie_invent_pt");

        $fa = 2;
        $data['hasil'] = $this->Models->showdata("[w_EmailRead] '" . $fa . "','" . $PTCode . "','" . $outletcode . "' ");
        // echo "<option value=''>-- Pilih Tipe --</option>";
        foreach ($data['hasil'] as $row) {
            echo "<option value='" . $row->Email . "'>" . $row->NameRekening . " - [ " . $row->Email . " ]</option>";
        }
    }
}
