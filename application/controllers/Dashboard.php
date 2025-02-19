<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends My_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->ceklogin();
    // $this->cekLocation();
    // $this->cekbeginning();

    ini_set('memory_limit', '256M');
    ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
    ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288'); // Setting to 512M - for pdo_sqlsrv
  }

  public function gantiPT()
  {
    extract(populateform());
    if (isset($gantiPT)) {
      $test = "coba";
      $ptcodeinput = strtoupper($ptcodeinput);
      delete_cookie('cookie_invent_pt');
      delete_cookie('cookie_invent_ptname');
      $this->Models->queryhandle("SET ANSI_NULLS ON;");
      $this->Models->queryhandle("SET ANSI_WARNINGS ON;");

      //check pt di w_CompanySetup//
      $checkPT = $this->Models->showsingle("SELECT count(*) total FROM w_CompanySetup WHERE ISNULL(isMain,0) = 1 AND PTCode = '" . $ptcodeinput . "' ");
      if ($checkPT->total < 1) {
        // die("<script language='JavaScript'>alert('PT Code Tidak Tersedia, Silahkan Hubungi IT'); document.location='" . base_url() . "dashboard/'</script>");
        $this->session->set_flashdata('msgGagalGantiPT', 'PTCode Tidak Ditemukan !');
        redirect(base_url() . "dashboard/index");
      }

      $cekPT = $this->db->query("SELECT TOP 1 * FROM dbo.w_CompanySetup WHERE ISNULL(isMain,0) = 1 AND PTCode = '" . $ptcodeinput . "'")->row();

      $cookiePTCode = array(
        'name'   => 'cookie_invent_pt',
        'value'  => $cekPT->PTCode,
        'expire' => '86400'
      );
      $this->input->set_cookie($cookiePTCode);

      $cookiePTName = array(
        'name'   => 'cookie_invent_ptname',
        'value'  => $cekPT->PTName,
        'expire' => '86400'
      );
      $this->input->set_cookie($cookiePTName);

      $this->session->set_flashdata('msgBerhasilGantiPT', 'Ganti PT Berhasil !');
      redirect(base_url() . "dashboard/index");
    }
    redirect('dashboard/index', 'refresh');
  }

  public function index()
  {
    $vCuser = $this->input->cookie('cookie_invent_user');
    $vPTCode = $this->input->cookie('cookie_invent_pt');
    // $data['tahuns'] = $this->Models->showdata("SELECT DISTINCT YEAR(TransDate) AS tahun from dbo.TransactionHeader where CustomerCode = '" . $outlet . "' order by YEAR(TransDate) desc");
    // $tahun = $this->Models->showsingle("SELECT Year(getdate()) as thn");
    // $bulan = $this->Models->showsingle("SELECT Month(getdate()) as bln");
    // $data['omset'] = $this->Models->showdata("SELECT SUM(TotalTransaction) as TotalTransaction, CONVERT(date,TransDate) as TransDate from TransactionHeader WHERE MONTH(TransDate) ='" . $bulan->bln . "' and YEAR(TransDate) ='" . $tahun->thn . "' and CustomerCode = '" . $outlet . "' GROUP BY CONVERT(date,TransDate) ");
    // $data['doughnut'] = $this->Models->showdata("[GetPaymentPie] '" . $outlet . "','" . $bulan->bln . "','" . $tahun->thn . "'");
    $data['user'] = $this->db->query("[w_UserRead] 1 ,' And Username = ''" . $vCuser . "'' '")->row();
    $data['site_url'] = $this->siteURL();

    $view = 'dashboard/dashboard';
    $this->go_to($view, $data);
  }

  function fetch_data_omset()
  {
    extract(populateform());
    $outlet = $this->input->cookie('cookie_invent_outlet');

    if ($bulan || $tahun) {
      $data = $this->Models->showdata("SELECT SUM(TotalTransaction) as TotalTransaction, CONVERT(date,TransDate) as TransDate from TransactionHeader WHERE MONTH(TransDate) ='" . $bulan . "' and YEAR(TransDate) ='" . $tahun . "' and CustomerCode = '" . $outlet . "' GROUP BY CONVERT(date,TransDate) ");
    } else {
      $data = array('Data Kosong');
    }

    echo json_encode($data);
  }
  function fetch_data_pie()
  {
    extract(populateform());
    $outlet = $this->input->cookie('cookie_invent_outlet');

    if ($tahun || $bulan) {
      $data = $this->Models->showdata("[GetPaymentPie] '" . $outlet . "','" . $bulan . "','" . $tahun . "'");
    } else {
      $data = array('Data Kosong');
      $echo = "hajaj";
    }
    echo json_encode($data);
  }

  function cekstatus()
  {
    if ($this->viewupdatestatus()) {
      $loginuser = $this->input->cookie("cookie_invent_user");
      $versi = $this->getversion();
      $data = $this->modelmodel->showsingle("SELECT * From dbo.VersionPOS WHERE VersionID ='" . $versi . "' ");
      echo json_encode($data);
      $this->modelmodel->queryhandle("UPDATE dbo.ViewUpdate SET StatusRead = 1 WHERE Username = '" . $loginuser . "' AND VersionID = '" . $versi . "'  ");
    }
  }

  function changerole($tipe, $outlet = NULL)
  {
    $tipeaktif      = $this->input->cookie('cookie_invent_tipe');
    $outletaktif    = $this->input->cookie('cookie_invent_outlet');

    if ($tipe == 1) {
      delete_cookie('cookie_invent_outlet');
      delete_cookie('cookie_invent_tipe');
      $vCk3['name'] = 'cookie_invent_tipe';
      $vCk3['value'] = 'TP011';
      $vCk3['expire'] = '86400';
      $this->input->set_cookie($vCk3);
      die("<script language='JavaScript'>alert('Pergantian Role ke Chief Berhasil !'); document.location='" . base_url() . "dashboard/'</script>");
    }

    if ($tipe == 2) {
      $vCk4['name'] = 'cookie_invent_tipe_lama';
      $vCk4['value'] = 'TP011';
      $vCk4['expire'] = '86400';
      $this->input->set_cookie($vCk4);

      delete_cookie('cookie_invent_tipe');

      $vCk3['name'] = 'cookie_invent_tipe';
      $vCk3['value'] = 'TP007';
      $vCk3['expire'] = '86400';
      $this->input->set_cookie($vCk3);
      $vCk4['name'] = 'cookie_invent_outlet';
      $vCk4['value'] = $outlet;
      $vCk4['expire'] = '86400';
      $this->input->set_cookie($vCk4);
      die("<script language='JavaScript'>alert('Pergantian Role ke SPV Berhasil !'); document.location='" . base_url() . "dashboard/'</script>");
    }
  }
}