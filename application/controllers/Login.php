<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends My_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->input->cookie('cookie_invent_user') != NULL) {
            redirect('dashboard', 'refresh');
        } else {
            $this->load->view('login');
        }
    }

    public function proses_login()
    {
        extract(populateform());

        $query = $this->db->query(" SELECT Username, Alias, UserType FROM dbo.w_UserLogin WITH (NOLOCK)
                                    WHERE (Username = '" . $username . "' OR Alias = '" . $username . "') AND Password = '" . md5($password) . "' AND Flag = 1 ");

        if ($query->num_rows() > 0) {

            $vToken   = $this->randstring();
            $username = $query->row()->Username;
            $fullname = $query->row()->Alias;
            $usertipe = $query->row()->UserType;

            //Delete login data 
            $this->Models->queryhandle("DELETE FROM dbo.WebLoginLog WHERE Username = '" . $username . "'");
            $newdata = array(
                'username'  => strtoupper($username),
                'logged_in' => TRUE,
                'tipe'      => $query->row()->UserType
            );

            $cekPT = $this->db->query("SELECT TOP 1 * FROM dbo.w_CompanySetup WHERE ISNULL(isMain,0) = 1")->row();

            $this->input_cookie_login($username, $fullname, $usertipe, $vToken, $cekPT->PTCode, $cekPT->PTName);

            // if (($query->row()->UserType == "TP001") or ($query->row()->UserType == "TP002")) {
            //     //DEVLOPER & DEPARTEMENT IT
            //     $vCk4['name'] = 'cookie_invent_outlet';
            //     $vCk4['value'] = 'IT';
            //     $vCk4['expire'] = '86400';
            //     $this->input->set_cookie($vCk4);
            // } else if (($query->row()->UserType == "TP003") or ($query->row()->UserType == "TP004") or ($query->row()->UserType == "TP005")) {
            //     $dataOt = $this->Models->showsingle("[UserRead] 1 ,'And Username =''" . $username . "'''");
            //     $vCk5['name'] = 'cookie_invent_outlet';
            //     $vCk5['value'] = $dataOt->OutletCode;
            //     $vCk5['expire'] = '86400';
            //     $this->input->set_cookie($vCk5);
            // } else if ($query->row()->UserType == "TP007") {
            //     $this->Models->queryhandle("SET ANSI_NULLS ON;");
            //     $this->Models->queryhandle("SET ANSI_WARNINGS ON;");
            //     $dataOt = $this->Models->showsingle("
            // 		SELECT TOP 1 OutletCode FROM [192.168.0.221].[Payroll].dbo.Arealeader WITH (NOLOCK) 
            // 		WHERE NipLeader = '" . $username . "' and Flag ='1'
            // 		OR NipChief = '" . $username . "' 
            // 		OR NipRM = '" . $username . "'");
            //     $vCk6['name'] = 'cookie_invent_outlet';
            //     $vCk6['value'] = $dataOt->OutletCode;
            //     $vCk6['expire'] = '86400';
            //     $this->input->set_cookie($vCk6);
            // } else if ($query->row()->UserType == "TP008") {
            //     $vCk4['name'] = 'cookie_invent_outlet';
            //     $vCk4['value'] = '';
            //     $vCk4['expire'] = '86400';
            //     $this->input->set_cookie($vCk4);
            // } else if ($query->row()->UserType == "TP011") {
            //     $cekRMGDG = $this->Models->showsingle("SELECT * FROM dbo.Reseller WHERE Nip ='" . $username . "'");
            //     if ($cekRMGDG) {
            //         $cekRMGDG2 = $cekRMGDG->tipe;
            //         $cekRMGDG3 = $cekRMGDG->ResellerCode;
            //         $vCk7['name'] = 'cookie_invent_outlet';
            //         $vCk7['value'] = $cekRMGDG3;
            //         $vCk7['expire'] = '86400';
            //         $this->input->set_cookie($vCk7);
            //     }
            // }

            //Update Login Status//
            $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 1, LastLogin = GETDATE()
                                        WHERE Username = '" . $username . "' ");
            $jam = $this->db->query("SELECT GETDATE() AS sekarang, DATEADD (HOUR, 6 , GETDATE()) AS hangus")->row();

            // print_r($jam);
            // die();
            $this->db->query("INSERT INTO dbo.WebLoginLog (Username, Sesi, TimeIn, ExpiredTime) 
                              VALUES ( '" . $username . "','" . $vToken . "','" . $jam->sekarang . "','" . $jam->hangus . "' ) ");


            $this->session->set_flashdata('msgLogin', 'Login Success !');
            redirect(base_url() . "dashboard", "Refresh");
        } else {
            $this->session->set_flashdata('msgLoginGagal', 'Login Failed !');
            redirect(base_url() . "login", "Refresh");
        }
    }

    function auto_login($username = null)
    {
        // Cek Sudah Beggining & End Ballance Blom

        extract(populateform());
        //GET Password
        $cek = $this->db->query("SELECT * FROM dbo.w_UserLogin a WITH(NOLOCK) WHERE (a.username = '" . $username . "' OR a.Alias = '" . $username . "') AND a.Flag = 1 ")->row();


        if (!$cek) {
            // die("<script language='JavaScript'>alert('Username " . $username . " tidak terdaftar di webstore, Harap hubungi Developer IT'); document.location='" . $site->url . "'</script>");
            $this->session->set_flashdata('msgUserNotFound', 'Username "' . $username . '" tidak terdaftar, Silahkan Hubungi IT !');
            redirect(base_url() . "login", "Refresh");
        }

        // ================================================================

        $query = $this->db->query("SELECT Username, Alias, UserType FROM dbo.w_UserLogin WITH (NOLOCK)
                                    WHERE (Username = '" . $username . "' OR Alias = '" . $username . "') AND Password = '" . $cek->Password . "' AND Flag = 1 ");

        if ($query->num_rows() > 0) {

            $vToken   = $this->randstring();
            $username = $query->row()->Username;
            $fullname = $query->row()->Alias;
            $usertipe = $query->row()->UserType;

            //Delete login data 
            $this->Models->queryhandle("DELETE FROM dbo.WebLoginLog WHERE Username = '" . $username . "'");
            $newdata = array(
                'username'  => strtoupper($username),
                'logged_in' => TRUE,
                'tipe'      => $query->row()->UserType
            );

            $cekPT = $this->db->query("SELECT TOP 1 * FROM dbo.w_CompanySetup WHERE ISNULL(isMain,0) = 1")->row();

            $this->input_cookie_login($username, $fullname, $usertipe, $vToken, $cekPT->PTCode, $cekPT->PTName);

            //Update Login Status//
            $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 1, LastLogin = GETDATE() WHERE Username = '" . $username . "' ");
            $jam = $this->db->query("SELECT GETDATE() AS sekarang, DATEADD (HOUR, 6 , GETDATE()) AS hangus")->row();

            // print_r($jam);
            // die();
            $this->db->query("INSERT INTO dbo.WebLoginLog (Username, Sesi, TimeIn, ExpiredTime) 
                              VALUES ( '" . $username . "','" . $vToken . "','" . $jam->sekarang . "','" . $jam->hangus . "' ) ");

            $this->session->set_flashdata('msgLogin', 'Login Success !');
            redirect(base_url() . "dashboard", "Refresh");
        } else {
            redirect(base_url() . "login", "Refresh");
            $this->session->set_flashdata('msgLoginGagal', 'Login Failed !');
        }
    }

    function proses_register()
    {
        extract(populateform());
        $hasil = $this->db->query("[RegisterUserLogin] '" . $nikregis . "' ")->row();

        var_dump($hasil->Result);

        if ($hasil->Result == "Success") {
            $this->session->set_flashdata('msgRegisterSukses', 'Registration Berhasil, Silahkan Login !');
            redirect(base_url() . "login", "Refresh");
        } else if ($hasil->MsgError) {
            $this->session->set_flashdata('msgRegisterGagal', $hasil->MsgError);
            redirect(base_url() . "login", "Refresh");
        } else {
            $this->session->set_flashdata('msgRegisterGagal', 'Registration Failed !');
            redirect(base_url() . "login", "Refresh");
        }
    }

    function randstring()
    {
        $pass = 60;
        $allchar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        mt_srand((float) microtime() * 1000000);
        $string = '';
        for ($i = 0; $i < $pass; $i++) {
            $string .= $allchar[mt_rand(0, strlen($allchar) - 1)];
        }
        return $string;
    }

    function input_cookie_login($vUser, $vUserName, $vTipe, $vToken, $vPTCode, $vPTName)
    {
        $cookie1 = array(
            'name'   => 'cookie_invent_user',
            'value'  => strtoupper($vUser),
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie1);

        $cookie2 = array(
            'name'   => 'cookie_invent_sesi',
            'value'  => $vToken,
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie2);

        $cookie3 = array(
            'name'   => 'cookie_invent_tipe',
            'value'  => $vTipe,
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie3);

        $cookie4 = array(
            'name'   => 'cookie_invent_pt',
            'value'  => $vPTCode,
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie4);

        $cookie5 = array(
            'name'   => 'cookie_invent_ptname',
            'value'  => $vPTName,
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie5);

        $cookie6 = array(
            'name'   => 'cookie_invent_username',
            'value'  => strtoupper($vUserName),
            'expire' => '86400'
        );
        $this->input->set_cookie($cookie6);
    }
}
