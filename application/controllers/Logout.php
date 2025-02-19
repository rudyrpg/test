<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends My_Controller
{
    function index()
    {
        $this->load->helper('cookie');

        $username = $this->input->cookie('cookie_invent_user');

        delete_cookie('cookie_invent_user');
        delete_cookie('cookie_invent_outlet');
        delete_cookie('cookie_invent_tipe');
        delete_cookie('cookie_invent_ptcode');
        delete_cookie('cookie_invent_menu');
        $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 0 WHERE Username = '" . $username . "' ");
        $this->Models->queryhandle("DELETE FROM dbo.WebLoginLog where Username = '" . $username . "'");

        redirect('login');
    }

    function backtomenu()
    {
        $this->load->helper('cookie');

        $username = $this->input->cookie('cookie_invent_user');

        delete_cookie('cookie_invent_user');
        delete_cookie('cookie_invent_outlet');
        delete_cookie('cookie_invent_tipe');
        delete_cookie('cookie_invent_ptcode');
        delete_cookie('cookie_invent_menu');
        $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 0 WHERE Username = '" . $username . "' ");
        $this->Models->queryhandle("DELETE FROM dbo.WebLoginLog WHERE Username = '" . $username . "'");

        redirect('login');
    }
}
