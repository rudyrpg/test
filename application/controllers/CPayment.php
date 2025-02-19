<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CPayment extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->ceklogin();
        $this->cek_akses();

        ini_set('memory_limit', '256M');
        ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
        ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288'); // Setting to 512M - for pdo_sqlsrv
    }

    public function ListTransaction()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $vPTCode . "','' ");
        $Tgl = date('Y-m-d');
        $vOutlet = "ALL";

        if (isset($FindTrans)) {
            if ($outletcode != "") {
                $fa = 3;
                $vOutlet = $outletcode;
            } else {
                $fa = 2;
            }

            // if ($tanggal != "") {
            //     $explode = explode('-', $tanggal);
            //     $start_date = indo_date($explode[0]);
            //     $end_date = indo_date($explode[1]);
            // } else {
            //     $start_date = $Tgl;
            //     $end_date = $Tgl;
            // }
            $data['ListTrans'] = $this->Models->showdata(" [w_TransactionRead] " . $fa . ",'" . $tanggal . "','" . $tanggal . "','" . $vOutlet . "','" . $vPTCode . "' ");
        } else {
            $data['ListTrans'] = $this->Models->showdata(" [w_TransactionRead] 1,'" . $Tgl . "','" . $Tgl . "','" . $vOutlet . "','" . $vPTCode . "' ");
        }

        $view = 'cpayment/listtransaction';
        $this->go_to($view, $data);
    }

    public function Email()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['site_url'] = $this->siteURL();
        $data['ptcode'] = $vPTCode;
        // var_dump($vPTCode);
        // die;

        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $vPTCode . "','' ");
        $data['listemail'] = $this->Models->showdata("[w_EmailRead] 1,'" . $vPTCode . "',''"); //Employee
        $data['listemail2'] = $this->Models->showdata("[w_EmailRead] 2,'" . $vPTCode . "',''"); //Outlet
        $data['listcc'] = $this->Models->showdata("[w_EmailRead] 1,'" . $vPTCode . "',''"); //Employee
        $data['listTemp'] = $this->Models->showdata("[w_EmailRead] 3,'" . $vPTCode . "','" . $vUserLogin . "'");

        // $data['listTemp'] = $this->Models->showdata("SELECT * FROM dbo.w_TempTransaction
        //                     WHERE CAST(CreatedDate AS DATE) = CAST(GETDATE() AS DATE) AND CreatedBy = '" . $vUserLogin . "'
        //                     ORDER BY ToName ASC");

        // $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $ptcode . "','' ");
        // var_dump($data['listemail']);
        // die;
        if (isset($test)) {
            var_dump($test);
            die;
        }
        $view = 'cpayment/email';
        $this->go_to($view, $data);
    }

    public function submitemail()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['user'] = $this->db->query("[w_UserRead] 1 ,' And Username = ''" . $vUserLogin . "'' '")->row();

        $to = implode(',', $toemail);
        $ccstring = implode(',', $cc);
        // var_dump($to, $ccstring);
        // die;
        $data['subject'] = $subject;
        // $data['documentno'] = $documentno;
        $data['documentno'] = $this->Models->showdata("[w_EmailRead] 3,'" . $vPTCode . "','" . $vUserLogin . "'");
        $data['documentnodistint'] = $this->Models->showdata("[w_EmailRead] 4,'" . $vPTCode . "','" . $vUserLogin . "'");
        $data['textemail'] = addslashes(htmlentities($textemail));

        //upload
        $datapath = [];
        $dir = 'assets/uploads/email_media';
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        // $regEx = "/^application\/pdf$|^image\/|^video\//";
        $regEx = "/^application\/pdf$|^image\/|^application\/(msword|vnd\.openxmlformats-officedocument\.wordprocessingml\.document)|^application\/(vnd\.ms-excel|vnd\.openxmlformats-officedocument\.spreadsheetml\.sheet)/";
        foreach ($_FILES['files']['tmp_name'] as $k => $v) {
            if (is_uploaded_file($_FILES['files']['tmp_name'][$k])) {
                if (preg_match($regEx, mime_content_type($_FILES['files']['tmp_name'][$k]), $match)) {
                    $fname = $_FILES['files']['name'][$k];
                    $i = 1;
                    while (true) {
                        $i++;
                        if (is_file($dir . '/' . $fname)) {
                            $fname = str_replace(".", '_' . $i . '.', $fname);
                        } else {
                            break;
                        }
                    }
                    $path = $dir . '/' . preg_replace('/\s+/', '', $fname);
                    $move = move_uploaded_file($_FILES['files']['tmp_name'][$k], $path);
                    // var_dump($move);
                    // die;
                    if ($move) {
                        array_push($datapath, $path);
                    }
                } else {
                    $this->session->set_flashdata('message-failed', "Invalid Upload File Type.");
                    // redirect(base_url('Media'));
                }
            } else {
                $this->session->set_flashdata('message-failed', "Uploaded file is invalid.");
                // redirect(base_url('Media'));
            }
        }
        $datafile = implode(',', $datapath);
        // var_dump($datapath);
        // die;
        // end upload

        ob_start();
        $this->load->view('cpayment/isiemail', $data);
        $viewContent = ob_get_clean();
        $this->kirimemail($viewContent, $data, $to, $ccstring, $datafile);
        // var_dump($toemail, $subject, $cc, $documentno, addslashes(htmlentities($textemail)));
        // die;
    }

    public function findtransaksi($tanggal)
    {
        $vPTCode = $this->input->cookie("cookie_invent_pt");

        $query = $this->Models->showdata("[dbo].[w_TransactionRead] 2, '" . $tanggal . "', '" . $tanggal . "', 'Employee','" . $vPTCode . "' ");
        $data = array();
        foreach ($query as $hsl) {
            $data[] = $hsl;
        }
        // extract(populateform());
        // $data = 'mantap' . $tanggal;
        echo json_encode($data);
    }

    public function isiemail()
    {
        extract(populateform());

        $view = 'cpayment/isiemail';
        $this->load->view($view);
    }


    public function kirimemail($message, $data, $to, $ccstring, $datafile)
    {
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $vPTName = $this->input->cookie("cookie_invent_ptname");
        $ci = get_instance();

        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com', // atau smptp lainnya                
            'smtp_user' => 'finance.payment06@gmail.com',  // Email gmail admin aplikasi
            'smtp_pass'   => 'gyxvcuchvevklgge',  // Password Gmail atau Sandi Aplikasi Gmail
            // 'smtp_user' => 'solehudin.rpg@gmail.com',  // Email gmail admin aplikasi
            // 'smtp_pass'   => 'jcmajymryqxkbmjs',  // Password Gmail atau Sandi Aplikasi Gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];
        $this->load->library('email', $config); // panggil library email
        $this->email->initialize($config);
        $this->email->from('finance.payment06@gmail.com', $vPTName);
        // $this->email->to('gedehuap02@gmail.com', 'ahmadraih02@gmail.com');
        $this->email->to($to);

        /*Jika ingin ada tambahan email manual pake koding yg ini*/
        // $list2 = explode(',', $ccstring);
        // array_push($list2, "solehudin.rpg@gmail.com");
        // $this->email->cc($list2);

        /*Email cc berdasarkan data tabel*/
        $this->email->cc($ccstring);

        $this->email->subject($data['subject']);
        $this->email->message($message);
        $fileupload = explode(',', $datafile);
        foreach ($fileupload as $f) {
            $this->email->attach($f);
        }


        if ($this->email->send()) {
            // echo 'berhasil';
            foreach ($fileupload as $f) {
                unlink($f);
            }

            $this->db->query("[w_InsertReportTransaction] '" . $data['subject'] . "','" . $vUserLogin . "','" . $vPTCode . "' ")->row();
            $this->db->query("[w_DeleteTempTransaction] 2,'','" . $vPTCode . "','" . $vUserLogin . "' ")->row();

            $this->session->set_flashdata('emailberhasil', 'Pengiriman Email Berhasil !');
            redirect(base_url() . "cpayment/email", "Refresh");
        } else {
            // echo 'gagal';
            redirect(base_url() . "cpayment/email", "Refresh");
            $this->session->set_flashdata('emailgagal', 'Pengiriman Email Gagal !');
        }
    }

    public function SaveTransaction()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");

        if ($vPTCode == "BIG") {
            $fa = 1;
        } else if ($vPTCode == "CPP") {
            $fa = 2;
        }


        $DocNoCount = count($DocNo);
        $data['hasil'] = [];

        for ($x = 0; $x < $DocNoCount; $x++) {

            $row = $this->db->query("[w_InsertTempTransaction] " . $fa . ", '" . $NoRek . "', '" . $DocNo[$x] . "', '" . $outletcode . "', '" . $vUserLogin . "', '" . $vPTCode . "'")->row();

            if (isset($row->MsgError)) {
                $data['hasil'][] = [
                    "MsgError" => $row->MsgError,
                ];
            } else if (isset($row->Result)) {
                $data['hasil'][] = [
                    "Result" => $row->Result,
                ];
            }
        }
        echo json_encode($data);
    }

    public function Delete_AllTransaction()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['hasil'] = $this->db->query("[w_DeleteTempTransaction] " . $fa . ",'" . $DocNo . "','" . $vPTCode . "','" . $vUserLogin . "' ")->result();

        echo json_encode($data);
    }

    public function Delete_Transaction()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['hasil'] = $this->db->query("[w_DeleteTempTransaction] " . $fa . ",'" . $DocNo . "','" . $vPTCode . "','" . $vUserLogin . "' ")->result();

        echo json_encode($data);
    }

    public function ReportTransaction()
    {
        extract(populateform());
        $data['site_url'] = $this->siteURL();
        $vPTCode = $this->input->cookie("cookie_invent_pt");
        $data['ListOutlet'] = $this->Models->showdata("[w_CustomerRead] 1,'" . $vPTCode . "','' ");
        $Tgl = date('Y-m-d');
        $vOutlet = "Employee";

        if (isset($FindTrans)) {
            if ($outletcode != "") {
                $fa = 3;
                $vOutlet = $outletcode;
            } else {
                $fa = 2;
            }

            // if ($tanggal != "") {
            //     $explode = explode('-', $tanggal);
            //     $start_date = indo_date($explode[0]);
            //     $end_date = indo_date($explode[1]);
            // } else {
            //     $start_date = $Tgl;
            //     $end_date = $Tgl;
            // }
            $data['ListRpt'] = $this->Models->showdata(" [w_ReportRead] " . $fa . ",'" . $tanggal . "','" . $tanggal . "','" . $vOutlet . "','" . $vPTCode . "' ");
        } else {
            $data['ListRpt'] = $this->Models->showdata(" [w_ReportRead] 1,'" . $Tgl . "','" . $Tgl . "','" . $vOutlet . "','" . $vPTCode . "' ");
        }

        $view = 'cpayment/reporttransaction';
        $this->go_to($view, $data);
    }

    function download_contoh()
    {
        $this->load->helper('download');
        // read file contents
        $data = file_get_contents(base_url('assets/format_import/FormatImportBankAccount.csv'));
        force_download('FormatImportBankAccount.csv', $data);
    }

    function import_proses()
    {
        extract(populateform());
        $vUserLogin = $this->input->cookie('cookie_invent_user');
        $vPTCode = $this->input->cookie("cookie_invent_pt");

        $random = md5($vUserLogin);
        $new    = array(
            'session' => $random
        );
        $this->load->library('upload');
        $this->upload->initialize(array(
            "allowed_types" => "csv",
            "upload_path" => './assets/uploads/file_import/',
            "overwrite" => true
        ));
        $data = $this->upload->data();

        if ($this->upload->file_upload("userfile")) {
            $file_data = $this->upload->data();
            $f         = fopen("./assets/uploads/file_import/" . $file_data['file_name'], "r");
            $data      = array();
            $x         = 0;

            while (($line = fgetcsv($f)) !== false) {
                $data[] = $line;
            }

            for ($x = 0; $x < count($data); $x++) {
                if ($x != 0) {
                    $newArray[] = array_combine($data[0], $data[$x]);
                }
            }

            foreach ($newArray as $key => $value) {
                $newArray[$key]['PTCode'] = $vPTCode;
                $newArray[$key]['sess_id']   = $new['session'];
                $newArray[$key]['createdby'] = $vUserLogin;
            }

            $this->db->query("DELETE FROM dbo.w_ImportBankAccount WHERE sess_id =  '" . $new['session'] . "'");
            foreach ($newArray as $arraysave) {
                $this->models->save('w_ImportBankAccount', $arraysave);
            }

            fclose($f);
            unlink("./assets/uploads/file_import/" . $file_data['file_name']);

            $cekitem   = $this->models->showdata("
                            SELECT ItemCode, Remark FROM dbo.ImportCsvDO WHERE ItemCode NOT IN (
                                SELECT ItemCode FROM dbo.Item WITH(NOLOCK)
                            ) and ItemCode <> '' and  sess_id =  '" . $new['session'] . "'");
            $countitem = $this->models->showsingle("select count(*) totaldata 
                                FROM dbo.ImportCsvDO WHERE ItemCode NOT IN (
                                SELECT ItemCode FROM dbo.Item WITH(NOLOCK)
                            ) and ItemCode <> '' and  sess_id =  '" . $new['session'] . "'
                            ");


            $cekitemstatus   = $this->models->showdata("SELECT * from ImportCsvDO a With(NoLock)
                                left join item b With(NoLock)
                                on a.ItemCode = b.ItemCode
                                where [Status] = '0'");


            if ($cekitemstatus) {
                $i = 0;
                echo "Gagal! Item berikut non aktif <br>";
                foreach ($cekitemstatus as $key) {
                    $i++;
                    echo $i . '. ' . $key->ItemCode . '<br>';
                }
                $this->db->query("delete from ImportCsvDO where sess_id = '" . $new['session'] . "'");
                die();
            }

            if ($countitem->totaldata != "") {
                $x = 0;
                echo "Harap Cek Item berikut <br>";
                foreach ($cekitem as $key) {
                    $x++;
                    echo $x . '. ' . $key->ItemCode . ' - ' . $key->Remark . '<br>';
                }
                $this->db->query("delete from ImportCsvDO where sess_id = '" . $new['session'] . "'");
                die();
            }

            $cekTipeItem = $this->db->query("SELECT ItemType FROM item where itemcode in (
                            SELECT ItemCode FROM ImportCsvDO where sess_id = '" . $new['session'] . "' and ItemCode <> ''
                            ) group by ItemType ")->result();
            $tipe = "";
            $tipeLama = "";
            foreach ($cekTipeItem as $tipeItem) {
                $tipe = $tipeItem->ItemType;
                if ($tipeLama != "") {
                    if ($tipe != $tipeLama) {
                        $this->db->query("delete from ImportCsvDO where sess_id = '" . $new['session'] . "'");
                        die("Harap pisahkan tipe item GENERAL dan MERCHANDISE");
                    }
                }
                $tipeLama = $tipe;
            }


            $this->models->showsingle("[ImportDOWeb3] '" . $new['session'] . "'");
            echo 'Done';
        } else {
            echo "FailFile";
        }
    }

    function ExecImport()
    {
        extract(populateform());
        $userlogin   = $this->input->cookie('cookie_invent_user');

        if (md5($userlogin) != $sess_id) {
            die("Session Id tidak sama dengan user login");
        }

        $this->models->showsingle("[ImportDOWeb3] '" . $sess_id . "'");

        die("<script language='JavaScript'>alert('DO berhasil di Execute'); document.location='" . base_url() . "Do_mutasi/importexcel'</script>");
    }
}
