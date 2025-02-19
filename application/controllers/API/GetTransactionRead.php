<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetTransactionRead extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function GetListTransaction()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $vPTCode . "','' ");
        // $Tgl = date('Y-m-d');
        // $vOutlet = "ALL";

        // if ($tanggal != null) {
        //     $tanggal = "" . date("Y-m-d", strtotime($tanggal)) . "";
        // } else {
        //     $tanggal = "" . date("Y-m-d") . "";
        // }

        delete_cookie('cookie_invent_outlet');
        $cookieOutlet = array(
            'name'   => 'cookie_invent_outlet',
            'value'  => $outletcode,
            'expire' => '86400'
        );
        $this->input->set_cookie($cookieOutlet);

        if ($caridata != "") {
            $vCari = "AND [Description] LIKE ''%" . $caridata . "%'' ";
        } else {
            $vCari = "";
        }

        $sql = " [w_TransactionRead] " . $fa . ",'" . $tanggal . "','" . $tanggal . "','" . $outletcode . "','" . $vPTCode . "','" . $vCari . "' ";

        // var_dump($sql);

        $data['hasil'] = $this->Models->showdata($sql);
        echo json_encode($data);
    }

    public function GetTempTransaksi()
    {
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $query = $this->Models->showdata("[w_EmailRead] 3,'" . $vPTCode . "','" . $vUserLogin . "'");
        $datacount = $this->Models->showdata("[w_EmailRead] 4,'" . $vPTCode . "','" . $vUserLogin . "'");

        // $data = array();
        // foreach ($datacount as $jml) {
        //     $totalamount = 0;
        //     foreach ($query as $hsl) {
        //         if ($jml->ToName == $hsl->ToName) {
        //             $data[] = $hsl;
        //             $totalamount += $hsl->CreditAmount;
        //         }
        //     }
        // }
        // echo json_encode($data);

        $data = array();
        $data_count = array();

        foreach ($query as $hsl) {
            $data[] = $hsl;
        }
        foreach ($datacount as $hslcount) {
            $data_count[] = $hslcount;
        }

        echo json_encode(array($data, $data_count));
    }
}
