<?php
class My_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Models', '', TRUE);
        $this->load->helper('cookie');
        $this->Models->queryhandle("SET ANSI_NULLS ON;");
        $this->Models->queryhandle("SET ANSI_WARNINGS ON;");
        ini_set('max_execution_time', 0);
    }

    function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        return $protocol . $domainName;
    }

    function viewupdatestatus()
    {
        $user = $this->input->cookie('cookie_invent_user');
        $versi = $this->getversion();
        return false;
    }

    function cekLocation()
    {
        $username = $this->input->cookie('cookie_invent_user');
        return $this->db->query(" [LocationRead] 2, ' and b.Username = ''" . $username . "'' '")->row()->LocationCode;
    }


    function cek_akses()
    {
        $tipe = $this->input->cookie('cookie_invent_tipe');
        $controller = strtoupper($this->uri->segment(1));
        $method     = strtoupper($this->uri->segment(2));
        $gabung     = $controller . '/' . $method;
        $cek_menu_akses = $this->db->query("SELECT TOP 1 * FROM dbo.MenuWebAccess a
        INNER JOIN dbo.ModuleWeb b ON a.MenuID = b.MenuID
        WHERE a.UserType ='" . $tipe . "' AND ([Path] ='" . $gabung . "' OR [Path] = '" . $controller . "')
        AND Flag in ('1','2')")->row();
        if (!$cek_menu_akses) {
            die("<script language='JavaScript'>alert('Akses dilarang !!!'); document.location='" . base_url() . "Dashboard'</script>");
        } else {
            return true;
        }
    }

    function cekbeginning()
    {
        $cekBeggining = $this->db->query("[SetTransactionBalance] 1,'" . $this->cekLocation() . "',0,0,0,''")->row();
        // var_dump($cekBeggining);
        if ($cekBeggining->Result == 2) {
            //Setting BeginningBalance !
            redirect(base_url() . 'TransactionBalance/beginning');
        } else if ($cekBeggining->Result == 1) {
            //Setting EndBalance !
            redirect(base_url() . 'TransactionBalance/end');
        } else if ($cekBeggining->Result == 3) {
            die("<script language='JavaScript'>alert('" . $cekBeggining->MsgError . "'); document.location='" . base_url() . "Logout'</script>");
        }
    }

    function ceklogin()
    {
        $this->Models->queryhandle("DELETE FROM dbo.WebLoginLog WHERE ExpiredTime < GETDATE()");
        $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 0 
                                    WHERE Username COLLATE database_default NOT IN (SELECT Username FROM dbo.WebLoginLog)");

        $username = $this->input->cookie('cookie_invent_user');
        $sesi = $this->input->cookie('cookie_invent_sesi');
        $jam = $this->Models->showsingle("SELECT GETDATE() AS skrg, DATEADD (hour , 6 , GETDATE() ) expired");

        $datacekuser = $this->Models->showsingle("SELECT count(*) total FROM dbo.WebLoginLog
                                                  WHERE Username = '" . $username . "' AND Sesi = '" . $sesi . "' ");
        // var_dump($username, $sesi, $datacekuser->total);
        // die;

        if ($datacekuser->total < 1) {
            delete_cookie('cookie_invent_user');
            delete_cookie('cookie_invent_outlet');
            delete_cookie('cookie_invent_tipe');
            delete_cookie('cookie_invent_pt');
            $this->Models->queryhandle("UPDATE dbo.w_UserLogin SET LoginStatus = 0 WHERE Username = '" . $username . "' ");
            $this->Models->queryhandle("DELETE FROM dbo.webloginlog WHERE Username = '" . $username . "' ");

            die("<script language='JavaScript'>alert('Your time has expired, please re-login !'); document.location='" . base_url() . "logout'</script>");
            // $this->session->set_flashdata('msgLoginUlang', 'Your time has expired, please re-login !');
            // redirect(base_url() . "logout", "Refresh");
        }

        $this->Models->queryhandle("UPDATE dbo.WebLoginLog SET ExpiredTime = '" . $jam->expired . "' WHERE Username = '" . $username . "' ");

        if ($username == NULL) {
            die("<script language='JavaScript'>alert('Your time has expired, please re-login !'); document.location='" . base_url() . "logout'</script>");
            // $this->session->set_flashdata('msgLoginUlang', 'Your time has expired, please re-login !');
            // redirect(base_url() . "logout", "Refresh");
        }

        $vCuser = $this->input->cookie('cookie_invent_user');
        $vCsesi = $this->input->cookie('cookie_invent_sesi');
        $vCtipe = $this->input->cookie('cookie_invent_tipe');
        $vCoutlet = $this->input->cookie('cookie_invent_outlet');
        $vCptcode = $this->input->cookie('cookie_invent_pt');

        //Now check to DB
        $vCookie1['name'] = 'cookie_invent_user';
        $vCookie1['value'] = $vCuser;
        $vCookie1['expire'] = '86400';
        $this->input->set_cookie($vCookie1);
        //simpan ke cookie token/sesi
        $vCookie2['name'] = 'cookie_invent_sesi';
        $vCookie2['value'] = $vCsesi;
        $vCookie2['expire'] = '86400';
        $this->input->set_cookie($vCookie2);
        //simpan ke cookie token/sesi
        $vCookie3['name'] = 'cookie_invent_tipe';
        $vCookie3['value'] = $vCtipe;
        $vCookie3['expire'] = '86400';
        $this->input->set_cookie($vCookie3);

        $vCookie4['name'] = 'cookie_invent_outlet';
        $vCookie4['value'] = $vCoutlet;
        $vCookie4['expire'] = '86400';
        $this->input->set_cookie($vCookie4);

        $vCookie5['name'] = 'cookie_invent_pt';
        $vCookie5['value'] = $vCptcode;
        $vCookie5['expire'] = '86400';
        $this->input->set_cookie($vCookie5);
    }

    function who_online()
    {
        $type = $this->input->cookie('cookie_invent_tipe');
        if ($type == "TP001") {
            return "Developer";
        } else if ($type == "TP002") {
            return "IT Support";
        } else if (($type == "TP003") or ($type == "TP004")) {
            return $this->input->cookie('cookie_invent_outlet');
        } else {
            return $this->input->cookie('cookie_invent_user');
        }
    }

    function go_to($view, $data, $params = null)
    {
        // $data['version_active'] = $this->Models->showsingle("SELECT TOP 1 * FROM dbo.VersionPOS ORDER BY ReleasedDate DESC");
        $vCuser = $this->input->cookie('cookie_invent_user');
        // $data['online'] = $this->who_online();
        $data['content'] = $view;
        // $data['outlethandle'] = "";
        $data['user'] = $this->db->query("[w_UserRead] 1 ,' And Username = ''" . $vCuser . "'' '")->row();

        if ($this->input->cookie('cookie_invent_tipe') == "TP011") {
            $cekoutlethandle = $this->Models->showdata("SELECT OutletCode FROM [192.168.0.221].[Payroll].dbo.Arealeader WHERE NipLeader = '" . $vCuser . "'");
            if ($cekoutlethandle) {
                $data['outlethandle'] = $cekoutlethandle;
            }
        }

        // $this->load->view('_partials/header');
        // $this->load->view('_partials/navbar');
        // $this->load->view('_partials/sidebar');
        // $this->load->view($view, $data);
        // $this->load->view('_partials/footer');
        // $this->load->view('_partials/js');

        $this->load->view('_partials/header');
        $this->load->view('_partials/sidebar');
        $this->load->view('_partials/navbar', $data);

        if ($params == 'table') {
            // $this->load->view('_partials/tableheader');
            $this->load->view($view);
            $this->load->view('_tables/tablecontent', $data);
            $this->load->view('_tables/tablefooter');
            $this->load->view('_partials/footer');
        } else {
            $this->load->view($view, $data);
            // $this->load->view('_partials/footer');
            $this->load->view('_partials/js');
        }
    }

    function getversion()
    {
        $versi = $this->Models->showsingle("SELECT TOP 1 * FROM dbo.VersionPOS ORDER BY VersionID DESC");
        return $versi->VersionID;
    }

    function menu_baru()
    {
        $user = $this->input->cookie('cookie_invent_user');
        $type_lama = $this->input->cookie('cookie_invent_tipe_lama');
        $type = $this->input->cookie('cookie_invent_tipe');
        $query = $this->db->query(" SELECT b.* FROM dbo.MenuWebAccess a
                                    INNER JOIN dbo.ModuleWeb b ON a.MenuID = b.MenuID
                                    WHERE b.Flag = 1 AND UserType = '" . $type . "' ORDER BY ModulUrut ASC")->result();

        echo "<ul class='nav pcoded-inner-navbar '>";
        foreach ($query as $hasil) {
            $number_child = $this->db->query("SELECT * FROM dbo.ModuleWeb WHERE Parents = " . $hasil->MenuID . "")->num_rows();
            $a = "";
            $b = "";
            $href = base_url() . $hasil->Path;

            if (($hasil->Path == $this->parent_url($this->uri->segment(1))) || ($hasil->Path ==  $this->uri->segment(1))) {
                $a = " active";
                // $b = "";
                // $href = base_url() . $hasil->Path;
            }

            if ($number_child > 0) {
                $a = "";
                $b = " pcoded-hasmenu";
                $href = "#";
            }

            if ($hasil->Parents == 0) {
                echo "<li class='nav-item" . $b . "" . $a . "'>";
                echo " <a href='" . $href . "' class='nav-link'>
                            <span class='pcoded-micon'><i class='" . $hasil->Icon . "'></i></span>
                            <span class='pcoded-mtext'>" . $hasil->ModuleName . "</span>
                        </a>";
                $this->get_child($hasil->MenuID);
                echo "</li>";
            }
        }

        // if (($type == "TP011") or ($type_lama == "TP011")) {
        //     $this->generatehandle($user);
        // }
        echo "</ul>";
    }

    function generatehandle($user)
    {
        //Check data
        $cekarea = $this->Models->showsingle("SELECT count(*) totaldata FROM [192.168.0.221].[Payroll].dbo.arealeader WHERE NipLeader = '" . $user . "' ");
        $outletcookie = $this->input->cookie('cookie_invent_outlet');
        if ($cekarea->totaldata > 0) {
            echo '<li class="header"><b>Ganti Outlet / Role</b></li>';
            $generatearea = $this->Models->showdata("SELECT OutletCode FROM [192.168.0.221].[Payroll].dbo.arealeader WHERE NipLeader = '" . $user . "'");

            if ($this->input->cookie('cookie_invent_tipe') == "TP011") {
                $s = "class='active'";
            } else {
                $s = "";
            }

            echo "<li " . $s . "><a href='" . base_url() . "Dashboard/changerole/1/'><b>Chief / RM</b></a></li>";

            foreach ($generatearea as $area) {
                if ($outletcookie == $area->OutletCode) {
                    $s = "class='active'";
                } else {
                    $s = "";
                }
                echo "<li " . $s . "><a href='" . base_url() . "Dashboard/changerole/2/" . $area->OutletCode . "'><b>SPV - " . $area->OutletCode . "</b></a></li>";
            }
        }
    }

    function get_child($kode)
    {
        $type = $this->input->cookie('cookie_invent_tipe');
        $query = $this->db->query(" SELECT b.* FROM dbo.MenuWebAccess a
                                    INNER JOIN dbo.ModuleWeb b ON a.MenuID = b.MenuID 
                                    WHERE b.Flag = 1 AND UserType = '" . $type . "' AND Parents = '" . $kode . "' ORDER BY ModulUrut ASC");
        if ($query->num_rows() > 0) {
            echo "<ul class='pcoded-submenu'>";
            foreach ($query->result() as $hsl) {
                $aa = "";
                if ($hsl->Path ==  $this->uri->segment(1) . '/' . $this->uri->segment(2)) {
                    $aa = "active";
                }

                echo "<li class='" . $aa . "'>
                <a href='" . base_url() . $hsl->Path . "'>" . $hsl->ModuleName . "</a></li>";
            }
            echo "</ul>";
        }
    }

    function get_second_child($kode)
    {
        $type = $this->input->cookie('cookie_invent_tipe');
        $query = $this->db->query(" SELECT b.* FROM dbo.MenuWebAccess a
                                    INNER JOIN dbo.ModuleWeb b ON a.MenuID = b.MenuID 
                                    WHERE b.Flag = 1 AND UserType='" . $type . "' AND Parents = '" . $kode . "' ORDER BY ModulUrut ASC");

        if ($query->num_rows() > 0) {
            echo "<ul class='pcoded-submenu''>";
            foreach ($query->result() as $hsl) {
                $sss = "";
                if ($hsl->Path ==  $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3)) {
                    $sss = "active";
                }

                echo "<li class = '" . $sss . "' >";
                echo " <a href='" . base_url() . $hsl->Path . "'>
                            <span class='pcoded-micon'><i class='ti-angle-right'></i></span>
                            <span class='pcoded-mtext' data-i18n='nav.basic-components.alert'>" . $hsl->ModuleName . "</span>
                            <span class='pcoded-mcaret'></span>
                        </a>
                    </li>";
            }
            echo "</ul>";
        }
    }

    function parent_url($kode = '')
    {
        $query2 = $this->db->query("SELECT b.Path AS PathParent FROM dbo.ModuleWeb a 
                                    LEFT JOIN dbo.ModuleWeb b on a.Parents = b.MenuID  
                                    WHERE b.Flag = 1 AND a.Path = '" . $kode . "'");

        if ($query2->num_rows() > 0) {
            return $query2->row()->PathParent;
        } else {
            return false;
        }
    }
}
