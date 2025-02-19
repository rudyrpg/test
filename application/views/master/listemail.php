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

<?php $this->load->view('modal/add_banktype', true); ?>

<a href="#" class="btn btn-primary float btn-addbanktype" data-bs-target="#modaladdbanktype">
    <i class="fa fa-plus my-float" aria-hidden="true"></i>
</a>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">Daftar List Email</h5>
                                    <!-- <div class="card-header">
                                        <h5>Basic Table</h5>
                                        <span class="d-block m-t-5">use class <code>table</code> inside table
                                            element</span>
                                    </div> -->
                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="pc-dt-simple">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Kode Bank</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="show_data_email"></tbody>
                                            </table>
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
</div>

<script>
    jQuery(document).ready(function($) {
        function GetData() {
            var id = null
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>API/GetMasterRead/GetListEmail",
                dataType: "JSON",
                data: {
                    Id: id
                },
                success: function(data) {
                    console.log(data);
                    // $('#pc-dt-simple').DataTable().destroy()
                    var html = '';
                    for (var i = 0; data.hasil.length > i; i++) {
                        var flag = "<div class='badge rounded-pill bg-danger'>Non-Active</div>";
                        var active_link = "aktif-link";
                        var icon = '<i class="fa fa-check fa-fw"></i>Active';

                        if (data.hasil[i].Active === 1) {
                            flag = "<div class='badge rounded-pill bg-success'>Active</div>";
                            active_link = "nonaktif-link";
                            icon = '<i class="fa fa-close fa-fw"></i>Non-Active';
                        }

                        html += '<tr>' +
                            '<td align="center">' + Number(i + 1) + '</td>' +
                            '<td>' + data.hasil[i].BankCode + '</td>' +
                            '<td>' + data.hasil[i].ShortDesc + '</td>' +
                            '<td>' + data.hasil[i].Description + '</td>' +
                            '<td>' + flag + '</td>';
                    }
                    $("#show_data_email").html(html);
                    $('#pc-dt-simple').DataTable({
                        "pageLength": 10
                    });
                }
            })
        }

        GetData();

        // $(document).on("click", "#submit-banktype", function(e) {
        //     CancelTransaction(SubTotalAfterCalculate, reasoncancel);
        // });

        // $('#form-banktype').submit(function(e) {
        //     e.preventDefault();
        //     CancelTransaction(SubTotalAfterCalculate, reasoncancel);
        // });

    });
</script>