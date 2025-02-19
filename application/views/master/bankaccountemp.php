<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">List Bank Account & Email Employee</h5>

                                    <div class="mb-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="submit" class="btn btn-primary disabled" name="ListEmployee" title="List Bank Account Employee">Employee</button>

                                            <form class="form-vertikal" action="<?= base_url() ?>master/bankaccountoutlet" method="POST">
                                                <button type="submit" class="btn btn-success" name="ListOulet" title="List Bank Account Outlet">Outlet</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dt-bankacc">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Nik</th>
                                                        <th>Full Name</th>
                                                        <th>Position</th>
                                                        <th>Department</th>
                                                        <th>HandPhone</th>
                                                        <th>Email</th>
                                                        <th>Bank Code</th>
                                                        <th>Bank</th>
                                                        <th>No Rekening</th>
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
                    fa: 1
                },
                success: function(data) {
                    // console.log(data);
                    var html = '';
                    for (var i = 0; data.hasil.length > i; i++) {
                        html += '<tr>' +
                            '<td align="center">' + Number(i + 1) + '</td>' +
                            '<td>' + data.hasil[i].Nip + '</td>' +
                            '<td>' + data.hasil[i].FullName + '</td>' +
                            '<td>' + data.hasil[i].Position + '</td>' +
                            '<td>' + data.hasil[i].Department + '</td>' +
                            '<td>' + data.hasil[i].HandPhone + '</td>' +
                            '<td>' + data.hasil[i].Email + '</td>' +
                            '<td>' + data.hasil[i].BankCode + '</td>' +
                            '<td>' + data.hasil[i].ShortDesc + '</td>' +
                            '<td>' + data.hasil[i].BankAccountNo + '</td>';
                    }
                    $("#show_data").html(html);
                    $('#dt-bankacc').DataTable({
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