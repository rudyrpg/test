<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Login - E-Payment</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content />
    <meta name="keywords" content>
    <meta name="author" content="Codedthemes" />

    <link rel="icon" href="<?php echo base_url() ?>assets/images/rpg/logorpg2.png" type="<?php echo base_url() ?>image/png/ico/icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/icon/themify-icons/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/icon/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/icon/icofont/css/icofont.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/assets/css/style-preset.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/jquery.mCustomScrollbar.css">

    <script src="<?php echo base_url() ?>assets/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/sweetalert/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/sweetalert/push/push.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/sweetalert/sweetalert.css">
</head>

<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="col-sm-10 auth-content w-auto">
                <img src="<?php echo base_url() ?>assets/images/rpg/logorpg2.png" width="20%" alt class="img-fluid">
                <h1 class="text-white my-4">Welcome !</h1>
                <h4 class="text-white font-weight-normal">Signin to your account and get explore E-Payments from RPGroup.<br />Don't forget to be happy for today !</h4>
            </div>
        </div>
        <div class="auth-side-form">
            <div class="auth-content">
                <img src="<?php echo base_url() ?>assets/images/rpg/logorpg.png" width="30%" alt class="img-fluid mb-1 d-block d-xl-none d-lg-none">
                <h3 class="mb-4 f-w-400">Sign In</h3>
                <form action="<?= base_url("login/proses_login"); ?>" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="ti-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Input NIK" required>
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text"><i class="ti-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <!-- <div class="form-group text-left mt-2">
                        <div class="checkbox checkbox-primary d-inline">
                            <input type="checkbox" name="checkbox-p-1" id="checkbox-p-1" checked>
                            <label for="checkbox-p-1" class="cr">Save credentials</label>
                        </div>
                    </div> -->
                    <button name="login" type="submit" class="btn btn-grd-primary mt-2 mb-0" style="width: 100%;"><i class="icofont icofont-key"></i> Sign In</button>
                    <div class="text-center">
                        <div class="saprator my-4"><span>OR</span></div>
                        <p class="mb-2 mt-4 text-muted">Forgot password? <a href="auth-reset-password-img-side.html" class="f-w-400">Reset</a></p>
                        <p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup-img-side.html" class="f-w-400">Signup</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/bootstrap.min.js"></script>


<script type="text/javascript">
    //swal Login Gagal
    var data = '<?php echo $this->session->flashdata('msgLoginGagal'); ?>';
    if (data != "") {
        swal('Failed !', data, 'error');
    }

    //swal User Not Found
    var data = '<?php echo $this->session->flashdata('msgUserNotFound'); ?>';
    if (data != "") {
        swal('Failed !', data, 'error');
    }

    //swal Login Ulang
    var data = '<?php echo $this->session->flashdata('msgLoginUlang'); ?>';
    if (data != "") {
        swal('Failed !', data, 'error');
    }

    //swal Login Gagal Belum Absen
    var data = '<?php echo $this->session->flashdata('msgBelumAbsen'); ?>';
    if (data != "") {
        swal('Hayoo Ngapain !', data, 'warning');
    }

    //swal Register Sukses
    var data = '<?php echo $this->session->flashdata('msgRegisterSukses'); ?>';
    if (data != "") {
        swal('Congratulation !', data, 'success');
    }

    //swal Register Gagal
    var data = '<?php echo $this->session->flashdata('msgRegisterGagal'); ?>';
    if (data != "") {
        swal('Sorry !', data, 'warning');
    }
</script>
</body>

</html>