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

<a href="<?= base_url('master/ImportBankAccount'); ?>" class="btn btn-success float">
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
                                    <h5 class="m-b-10">List Bank Account & Email Outlet</h5>

                                    <div class="mb-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <form class="form-vertikal" action="<?= base_url() ?>master/bankaccountemp" method="POST">
                                                <button type="submit" class="btn btn-primary" name="ListEmployee" title="List Bank Account Employee">Employee</button>
                                            </form>

                                            <button type="submit" class="btn btn-success disabled" name="ListOulet" title="List Bank Account Outlet">Outlet</button>
                                        </div>
                                    </div>

                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dt-bankaccoutlet">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>OutletCode</th>
                                                        <th>Type Bayar</th>
                                                        <th>Bank Name</th>
                                                        <th>Pemilik Rekening</th>
                                                        <th>No Rekening</th>
                                                        <th>Email</th>
                                                        <th>PTCode</th>
                                                        <!-- <th class="text-center">Action</th> -->
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

<script>
    jQuery(document).ready(function($) {
        function GetData() {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>API/GetMasterRead/GetListBankAccount",
                dataType: "JSON",
                data: {
                    fa: 3
                },
                success: function(data) {
                    // console.log(data);
                    var html = '';
                    for (var i = 0; data.hasil.length > i; i++) {
                        html += '<tr>' +
                            '<td align="center">' + Number(i + 1) + '</td>' +
                            '<td>' + data.hasil[i].OutletCode + '</td>' +
                            '<td>' + data.hasil[i].TypeBayar + '</td>' +
                            '<td>' + data.hasil[i].BankName + '</td>' +
                            '<td>' + data.hasil[i].NameRekening + '</td>' +
                            '<td>' + data.hasil[i].NoRekening + '</td>' +
                            '<td>' + data.hasil[i].Email + '</td>' +
                            '<td>' + data.hasil[i].PTCode + '</td>';
                    }
                    $("#show_data").html(html);
                    $('#dt-bankaccoutlet').DataTable({
                        // "pageLength": 10
                        responsive: true
                    });
                    // $('#dt-bankacc').DataTable();
                }
            })
        }

        GetData();

        // $(document).on("click", "#add_bank", function(e) {
        //     var kodebank = $('#kodebank').val();
        //     var namabank = $('#namabank').val();
        //     var descriptbank = $('#descriptbank').val();
        //     InsertBank(kodebank, namabank, descriptbank);
        // });

        // $('#form-bank').submit(function(e) {
        //     e.preventDefault();
        //     var kodebank = $('#kodebank').val();
        //     var namabank = $('#namabank').val();
        //     var descriptbank = $('#descriptbank').val();
        //     InsertBank(kodebank, namabank, descriptbank);
        // });

        // function InsertBank(kodebank, namabank, descriptbank) {
        //     $.ajax({
        //         type: "POST",
        //         url: "<?= base_url(); ?>Master/Add_BankType",
        //         dataType: "JSON",
        //         data: {
        //             fa: 1,
        //             kodebank: kodebank,
        //             namabank: namabank,
        //             descriptbank: descriptbank
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             if (data["hasil"]["length"] > 0) {
        //                 if (data['hasil'][0]['MsgError']) {
        //                     var error = data['hasil'][0]['MsgError'];
        //                     swal("Warning !", error, "warning");
        //                     return;
        //                 } else if (data['hasil'][0]['Result']) {
        //                     swal({
        //                             title: "Success",
        //                             text: "Save Data Berhasil !",
        //                             icon: "success",
        //                         })
        //                         .then((isConfirm) => {
        //                             if (isConfirm) {
        //                                 location.reload();
        //                             }
        //                         });
        //                 }
        //             } else {
        //                 swal("Sorry !", "Save Data Failed !", "error");
        //             }
        //         },
        //         beforeSend: function() {
        //             swal({
        //                 title: "Please Wait ...",
        //                 text: "Tunggu Sampai Process Selesai !",
        //                 icon: "info",
        //                 buttons: false
        //             });
        //         },
        //         error: function(jqXHR, exception) {
        //             // console.log(exception);
        //             swal("Oops !", "Harap Hubungi IT", "error");
        //         },
        //     });
        // }

        // $(document).on("click", ".btn-delete", function(e) {
        //     var kodebank = $(this).data("BankCode");
        //     var namabank = $(this).data("ShortDesc");
        //     alert($(this).data("BankCode"));
        //     swal({
        //             title: "Confirmation !",
        //             text: "Anda yakin ingin hapus data ?",
        //             icon: "info",
        //             buttons: true,
        //         })
        //         .then((isConfirm) => {
        //             if (isConfirm) {
        //                 DeleteData(kodebank, namabank);
        //             } else {
        //                 swal("Cancel !", "Hapus Data Dibatalkan !", "warning");
        //             }
        //         });
        // });

        // function DeleteData(kodebank, namabank) {
        //     $.ajax({
        //         type: "POST",
        //         url: "<?= base_url(); ?>Master/Delete_BankType",
        //         dataType: "JSON",
        //         data: {
        //             fa: 3,
        //             kodebank: kodebank,
        //             namabank: namabank
        //         },
        //         success: function(data) {
        //             if (data["hasil"]["length"] > 0) {
        //                 if (data['hasil'][0]['MsgError']) {
        //                     var error = data['hasil'][0]['MsgError'];
        //                     swal("Warning !", error, "warning");
        //                     return;
        //                 } else if (data['hasil'][0]['Result']) {
        //                     swal({
        //                             title: "Success",
        //                             text: "Hapus Data Berhasil !",
        //                             icon: "success",
        //                         })
        //                         .then((isConfirm) => {
        //                             if (isConfirm) {
        //                                 location.reload();
        //                             }
        //                         });
        //                 }
        //             } else {
        //                 swal("Sorry !", "Save Data Failed !", "error");
        //             }
        //         }
        //     });
        // }

    });
</script>