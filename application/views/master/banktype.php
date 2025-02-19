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

    .btn-radius {
        /* width: 35px; */
        border-radius: 50px;
    }
</style>

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
                                    <h5 class="m-b-10">Daftar List Bank</h5>
                                    <!-- <div class="card-header">
                                        <h5>Basic Table</h5>
                                        <span class="d-block m-t-5">use class <code>table</code> inside table
                                            element</span>
                                    </div> -->
                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dt-bank">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Kode Bank</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="show_data"></tbody>
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

<?php $this->load->view('modal/add_banktype', true); ?>

<script>
    jQuery(document).ready(function($) {
        function GetData() {
            var id = null
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>API/GetMasterRead/GetListBank",
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
                            '<td align="center">' + flag + '</td>' +
                            '<td align="center"> <a href="#" data-BankCode="' + data["hasil"][i].BankCode +
                            '" data-ShortDesc="' + data["hasil"][i].ShortDesc +
                            '" data-Description="' + data["hasil"][i].Description +
                            '" data-Quantity="' + data["hasil"][i].Quantity +
                            '" data-flag="' + flag +
                            '" class="btn-edit"><i class="icon feather icon-edit f-16 text-primary"></i></a>' +
                            '<a href="#" data-BankCode="' + data["hasil"][i].BankCode + '" class="btn-delete"><i class="feather icon-trash-2 ms-3 f-16 text-danger"></i></a></td></tr>';
                    }
                    $("#show_data").html(html);
                    $('#dt-bank').DataTable({
                        // "pageLength": 10
                        responsive: true
                    });
                    // $('#dt-bank').DataTable();
                }
            })
        }

        GetData();

        $(document).on("click", "#add_bank", function(e) {
            var kodebank = $('#kodebank').val();
            var namabank = $('#namabank').val();
            var descriptbank = $('#descriptbank').val();
            InsertBank(kodebank, namabank, descriptbank);
        });

        $('#form-bank').submit(function(e) {
            e.preventDefault();
            var kodebank = $('#kodebank').val();
            var namabank = $('#namabank').val();
            var descriptbank = $('#descriptbank').val();
            InsertBank(kodebank, namabank, descriptbank);
        });

        function InsertBank(kodebank, namabank, descriptbank) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Master/Add_BankType",
                dataType: "JSON",
                data: {
                    fa: 1,
                    kodebank: kodebank,
                    namabank: namabank,
                    descriptbank: descriptbank
                },
                success: function(data) {
                    console.log(data);
                    if (data["hasil"]["length"] > 0) {
                        if (data['hasil'][0]['MsgError']) {
                            var error = data['hasil'][0]['MsgError'];
                            swal("Warning !", error, "warning");
                            return;
                        } else if (data['hasil'][0]['Result']) {
                            swal({
                                    title: "Success",
                                    text: "Save Data Berhasil !",
                                    icon: "success",
                                })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });
                        }
                    } else {
                        swal("Sorry !", "Save Data Failed !", "error");
                    }
                },
                beforeSend: function() {
                    swal({
                        title: "Please Wait ...",
                        text: "Tunggu Sampai Process Selesai !",
                        icon: "info",
                        buttons: false
                    });
                },
                error: function(jqXHR, exception) {
                    // console.log(exception);
                    swal("Oops !", "Harap Hubungi IT", "error");
                },
            });
        }

        $(document).on("click", ".btn-delete", function(e) {
            var BankCode = $(this).data("bankcode");
            // alert(BankCode);
            swal({
                    title: "Confirmation !",
                    text: "Anda yakin ingin hapus data " + BankCode + " ?",
                    icon: "info",
                    buttons: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        DeleteData(BankCode);
                    } else {
                        swal("Cancel !", "Hapus Data Dibatalkan !", "warning");
                    }
                });
        });

        function DeleteData(BankCode) {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Master/Delete_BankType",
                dataType: "JSON",
                data: {
                    BankCode: BankCode
                },
                success: function(data) {
                    if (data["hasil"]["length"] > 0) {
                        if (data['hasil'][0]['MsgError']) {
                            var error = data['hasil'][0]['MsgError'];
                            swal("Warning !", error, "warning");
                            return;
                        } else if (data['hasil'][0]['Result']) {
                            swal({
                                    title: "Success",
                                    text: "Hapus Data Berhasil !",
                                    icon: "success",
                                })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });
                        }
                    } else {
                        swal("Sorry !", "Save Data Failed !", "error");
                    }
                }
            });
        }
    });
</script>