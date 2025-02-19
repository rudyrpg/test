<?php
$userlogin  = $this->input->cookie("cookie_invent_user");
$ptcode  = $this->input->cookie("cookie_invent_pt");
?>
<style>
    .header-searchx {
        line-height: 0.8;
    }

    .main-searchx {
        padding: 13px 0;
    }

    .input-groupx {
        margin-bottom: 0;
        background-color: white;
        border-radius: 20px;
        border: 1px solid grey;
    }

    .form-controlx {
        padding: 0.3rem 0.75rem;
        /* display: none; */
        width: 120px;
        border: none;
        background-color: transparent;
    }

    .input-group-addony {
        padding: 0.3rem 0.75rem 0.3rem 0;
        background-color: transparent;
        border: none;
    }

    .input-group-addonx {
        padding: 0.3rem 0 0.3rem 0.75rem;
        background-color: transparent;
        border: none;
    }

    .search-btnx {
        color: black;
    }

    .search-closex {
        color: black;
        display: none;
    }
</style>

<header class="navbar pcoded-header navbar-expand-lg navbar-light headerpos-fixed <?php if ($ptcode == "CPP") {
                                                                                        echo 'header-red';
                                                                                    } else if ($ptcode == "BIG") {
                                                                                        echo 'header-blue';
                                                                                    } ?>">
    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="#"><span></span></a>
        <a href="<?php echo base_url() ?>dashboard" class="b-brand">
            <img src="<?php echo base_url() ?>assets/images/logo.png" alt class="logo">
            <img src="<?php echo base_url() ?>assets/images/logo-icon.png" alt class="logo-thumb">
        </a>
        <a href="#" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
            <li>
                <a href="#!" onclick="javascript:toggleFullScreen()">
                    <i class="feather icon-maximize"></i>
                </a>
            </li>
            <!-- <li>
                <h6>[CPP] - [CIPTA PUTRI PERTIWI]</h6>
            </li> -->
            <li>
                <div class="mobile-searchx">
                    <div class="header-searchx">
                        <div class="main-searchx morphsearch-searchx open">
                            <form action="<?= base_url(); ?>dashboard/gantiPT" method="POST" class="navbar-form">
                                <div class="input-groupx">
                                    <!-- <span class="input-group-addonx search-closex"><i class="ti-close"></i></span> -->
                                    <input required name="ptcodeinput" type="text" class="form-controlx ptcodeinput" placeholder="Enter PTCode" value="<?= $ptcode ?>">
                                    <button class="input-group-addony search-btnx" type="submit" name="gantiPT"><i class="ti-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="icon feather icon-bell"></i><span class="badge bg-danger"><span class="sr-only"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-end notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">Notifications</h6>
                            <!-- <div class="float-end">
                                <a href="#" class="m-r-10">mark as read</a>
                                <a href="#">clear all</a>
                            </div> -->
                        </div>
                        <ul class="noti-body">
                            <li class="n-title">
                                <p class="m-b-0">NEW</p>
                            </li>
                            <li class="notification">
                                <div class="media">
                                    <img class="img-radius" src="<?php echo base_url() ?>assets/images/avatar-1.jpg" alt="Generic placeholder image">
                                    <div class="media-body">
                                        <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
                                        <p>New ticket Added</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="noti-footer">
                            <a href="#">show all</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown">
                    <a href="#" class="displayChatbox dropdown-toggle"><i class="icon feather icon-mail"></i><span class="badge bg-success"><span class="sr-only"></span></span></a>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="<?php echo base_url() ?>assets/images/avatar-1.jpg" class="img-radius wid-40" alt="User-Profile-Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-notification">
                        <div class="pro-head">
                            <img src="<?php echo base_url() ?>assets/images/avatar-1.jpg" class="img-radius" alt="User-Profile-Image">
                            <span><?= $userlogin ?></span>
                            <a href="<?php echo base_url() ?>Logout" class="dud-logout" title="Logout">
                                <i class="ti-power-off"></i>
                            </a>
                        </div>
                        <ul class="pro-body">
                            <li><a href="user-profile.html" class="dropdown-item"><i class="ti-user"></i> Profile</a></li>
                            <li><a href="email_inbox.html" class="dropdown-item"><i class="ti-comment-alt"></i> My Messages</a></li>
                            <li><a href="auth-signin.html" class="dropdown-item"><i class="ti-lock"></i> Lock Screen</a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>

<script>
    $(".ptcodeinput").on('keyup', function(e) {
        this.value = this.value.toUpperCase();
    });

    //swal Gagal Ganti PT
    var data = '<?php echo $this->session->flashdata('msgGagalGantiPT'); ?>';
    if (data != "") {
        swal('Failed !', data, 'error');
        $('.ptcodeinput').focus();
    }

    //swal Berhasil Ganti PT
    var data = '<?php echo $this->session->flashdata('msgBerhasilGantiPT'); ?>';
    if (data != "") {
        swal('Success !', data, 'success');
    }

    // $('.search-btnx').on('click', function() {
    //     $('.search-closex').css('display', 'inline');
    //     $('.form-controlx').css('width', '200px');
    //     $('.input-groupx').css('background-color', 'white');
    //     $('.search-btnx').css('color', 'black');
    // });
    // $('.search-closex').on('click', function() {
    //     $('.search-closex').css('display', 'none');
    //     $('.form-controlx').css('width', '0');
    //     $('.input-groupx').css('background-color', 'transparent');
    //     $('.search-btnx').css('color', 'white');
    // });
    // $('#btn-cari').on('click', function() {
    //     if ($('.form-controlx').val() != '') {
    //         console.log('carii', $('.form-controlx').val());
    //     }
    // });
</script>