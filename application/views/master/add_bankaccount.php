<style>
    .float {
        position: fixed;
        width: 50px;
        height: 50px;
        bottom: 30px;
        right: 30px;
        /* background-color: #1bf000; */
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        box-shadow: 2px 2px 3px #999;
        z-index: 999;
    }

    .my-float {
        margin-top: 12px;
    }
</style>
<a href="<?= base_url('master/BankAccount'); ?>" class="btn btn-primary float">
    <i class="fa fa-chevron-left my-float" aria-hidden="true"></i>
</a>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">Add Bank Account</h5>
                                    <div class="card-body">

                                        <form class="validate-me was-validated" id="validate-me" data-validate method="POST" action="<?= base_url(); ?>BankAccount/save_data">
                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-4 col-sm-12 text-lg-end">Outlet Code</label>
                                                <div class="col-lg-6 col-md-11 col-sm-12">
                                                    <select class="form-select select2a" name="outlet-code" id="outlet-code" placeholder="Choose Outlet Code" required>
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($ListOutlet as $outlet) { ?>
                                                            <option value="<?= $outlet->CustomerCode ?>">[<?= $outlet->CustomerCode ?>] - [<?= $outlet->CustomerName; ?>]</option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please Choose Outlet Code !</div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-form-label col-lg-4 col-sm-12 text-lg-end">Bank Type</label>
                                                <div class="col-lg-5 col-md-9 col-sm-9">
                                                    <select class="form-select select2a" placeholder="Choose Bank Type" required>
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($ListBank as $bank) { ?>
                                                            <option value="<?= $bank->ShortDesc ?>">[<?= $bank->ShortDesc ?>] - [<?= $bank->Description; ?>]</option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <div class="invalid-feedback">Please Choose Bank Type !</div>
                                                </div>
                                                <div class="col-lg-2 col-md-3 col-sm-3">
                                                    <button class="btn btn-primary"><i class="icofont icofont-plus-circle"></i> Add</button>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label text-lg-end">No. Rekening</label>
                                                <div class="col-lg-6">
                                                    <input type="number" class="form-control" data-bouncer-message="" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label text-lg-end">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form-control" data-bouncer-message="The domain portion of the email address is invalid (the portion after the @)." required>
                                                </div>
                                            </div>

                                            <hr class="my-2">

                                            <div class="form-group row">
                                                <div class="col-lg-4 col-form-label"></div>
                                                <div class="col-lg-6">
                                                    <input type="submit" class="btn btn-primary" value="Save">
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>