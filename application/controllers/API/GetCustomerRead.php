<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GetCustomerRead extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->ceklogin();
    }

    public function GetCustomerReadList()
    {
        extract(populateform());
        // $outlet = $this->input->cookie('cookie_invent_outlet');

        $fa = 1;
        $data['hasil'] = $this->Models->showdata("[w_CustomerRead] '" . $fa . "','" . $ptcode . "','' ");
        foreach ($data['hasil'] as $row) {
            echo "<option value='" . $row->CustomerCode . "'>" . $row->CustomerName . "</option>";
        }
    }
}
