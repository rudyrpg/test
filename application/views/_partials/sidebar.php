<?php
$userlogin  = $this->input->cookie("cookie_invent_user");
$PTCode  = $this->input->cookie("cookie_invent_pt");
?>

<nav class="pcoded-navbar menupos-fixed menu-light ">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div ">

            <!-- <form action="<?= base_url(); ?>Dashboard/gantiPT" method="POST" class="text-center">
                <div class="input-group mb-3">
                    <input required name="cari-pt" type="text" value="<?= $PTCode ?>" class="form-control">
                    <span class="input-group-btn">
                        <button type="submit" name="gantioutlet" id="search-btn" class="btn btn-flat"><i class="fa fa-caret-square-o-right"></i></button>
                    </span>
                    <span class="input-group-addony search-btnx" id="btn-cari"><i class="ti-search"></i></span>
                </div>
            </form> -->

            <?php
            $CI = &get_instance();
            $CI->menu_baru();
            ?>

            <div class="card text-center">
                <div class="card-block">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button> -->
                    <!-- <i class="feather icon-sunset f-40"></i> -->
                    <img src="<?php echo base_url() ?>assets/images/rpg/logorpg.png" width="40%" alt class="logo-thumb">
                    <h6 class="mt-3">Help?</h6>
                    <p>Please contact us on our HelpDesk for need any support</p>
                    <a href="https://helpdesk.rpgroup.co.id/" target="_blank" class="btn btn-primary btn-sm text-white m-0">Find Us</a>
                </div>
            </div>
        </div>
    </div>
</nav>