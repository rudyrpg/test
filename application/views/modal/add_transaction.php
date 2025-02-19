<?php
$vPTCode = $this->input->cookie('cookie_invent_pt');
?>

<!-- modal transaction -->
<div class="modal fade" id="modalAddTransaction" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <!-- <div class="modal-content"> -->
        <form class="modal-content" action="javascript:void(0)" method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">List Transaction <?= $vPTCode ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-start mb-2">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bank Account</label>
                        <select class="form-control select2e" name="" id="list-rek" placeholder="Choose Status" required>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Posting Date</label>
                        <input type="text" class="form-control findtanggal" id="findtanggal" placeholder="Select Date" autocomplete="off" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Search Description</label>
                        <input type="text" class="form-control" name="caridata" id="caridata" placeholder="Input Keyword" autocomplete="off">
                    </div>
                    <div class=" col-md-3 mb-3">
                        <!-- <label class="form-label">Status</label> -->
                        <div class="d-flex flex-wrap gap-2" style="padding-top: 29px;">
                            <button type="submit" class="btn btn-outline-primary btn-finddata">Find Data</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dt-trans">
                                <thead>
                                    <tr>
                                        <!-- <th class="px-0 py-1">Pilih</th> -->
                                        <th><input type="checkbox" name="checkall" id="checkall" value="all"></th>
                                        <th>No</th>
                                        <th>PostingDate</th>
                                        <th>DocumentNo</th>
                                        <th>Description</th>
                                        <th>OutletCode</th>
                                        <th>CreditAmount</th>
                                        <th>PostingBy</th>
                                    </tr>
                                </thead>
                                <tbody id="showtrans"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-save">Save</button>
            </div>
        </form>
        <!-- </div> -->
    </div>
</div>
<!-- end modal transaction -->

<script type="text/JavaScript">
    jQuery(document).ready(function($) { 
        // minimum setup
        (function() {
            const d_week = new Datepicker(document.querySelector('#findtanggal'), {
                buttonClass: 'btn'
            });
        })();

        // $('#dt-trans').DataTable().destroy();

        // $('#dt-trans').DataTable();

        // $('#dt-trans').dataTable({
        //     "pageLength": 10
        // });

        // $("#checkAll").click(function(){
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });

        $('#checkall').on('change', function() {
            if (this.checked) {
                for (var i = 0; i < $('.ckbox-trans').length; i++) {
                    $('.ckbox-trans')[i].checked = true; // Mengganti status semua checkbox menjadi dicentang
                }
                console.log('ceklis', $('.ckbox-trans').length);
            } else {
                for (var i = 0; i < $('.ckbox-trans').length; i++) {
                    $('.ckbox-trans')[i].checked =
                        false;
                }
                console.log('no ceklis');
            }
        });
    });


    $(document).on('click', '.btn-addtrans', function() {
        $("#showtrans").children().remove();
        $('#modalAddTransaction').modal('show');
        $('#caridata').val('');

        if ($('.options').val() == "Employee") {
            outletcode = "Employee";
            GetBankAccountEmp();
        } else if ($('.options').val() == "Outlet") {
            outletcode = $('.list-outlet').val();
            GetBankAccount(outletcode);
        }
    });

    $(document).on("click", ".btn-finddata", function(e) {
        if ($('#findtanggal').val() != '') {
            var tanggal = $('#findtanggal').val();
            outletcode = $('.list-outlet').val();
            var caridata = $('#caridata').val();

            if ($('.options').val() == "Employee") {
                outletcode = "Employee";
                TransactionRead(4, tanggal, outletcode, caridata);
            } else if ($('.options').val() == "Outlet") {
                TransactionRead(5, tanggal, outletcode, caridata);
            }

            // alert(caridata);
        }
    });

    function GetBankAccountEmp(){
        // alert(outletcode);
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>API/GetMasterRead/GetBankAccountEmployee",
            dataType: "html",
            success: function(data) {
                // console.log(data);
                $('#list-rek').html(data);
            },
            beforeSend: function( xhr ) {
                // console.log(xhr);
            }
        });
    }

    function GetBankAccount(outletcode){
        // alert(outletcode);
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>API/GetMasterRead/GetBankAccountPerOutlet/" + outletcode,
            dataType: "html",
            success: function(data) {
                // console.log(data);
                $('#list-rek').html(data);
            },
            beforeSend: function( xhr ) {
                // console.log(xhr);
            }
        });
    }

    function TransactionRead(fa, tanggal, outletcode, caridata) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Api/GetTransactionRead/GetListTransaction",
            dataType: "JSON",
            data: {
                fa: fa,
                tanggal: tanggal,
                outletcode: outletcode,
                caridata: caridata
            },
            success: function(data) {
                // console.log(data);
                if(data["hasil"]["length"] > 0){
                    var html = '';
                    for (var i = 0; data["hasil"]["length"] > i; i++) {
                        html += '<tr>' +
                            '<td><input onclick="" class="ckbox-trans ace" type="checkbox" value="' + data["hasil"][i]["DocumentNo"] + '"><span class="lbl"></span></td>' +
                            '<td><nobr>' + data["hasil"][i]["TransId"] + '</nobr></td>' +
                            '<td><nobr>' + data["hasil"][i]["PostingDate"] + '</nobr></td>' +
                            '<td><nobr>' + data["hasil"][i]["DocumentNo"] + '</nobr></td>' +
                            '<td><nobr>' + data["hasil"][i]["Description"] + '</nobr></td>' +
                            '<td><nobr>' + data["hasil"][i]["OutletCode"] + '</nobr></td>' +
                            '<td><nobr>Rp ' + rupiahjs(data["hasil"][i]["CreditAmount"]) + '</nobr></td>' +
                            '<td><nobr>' + data["hasil"][i]["PostingBy"] + '</nobr></td>' +
                            '</tr>';
                    }
                    $("#showtrans").html(html);
                    // $('#dt-trans').DataTable();
                    // $('#dt-trans').DataTable({
                    //     "pageLength": 10
                    // });
                }else{
                    $("#showtrans").children().remove();
                    swal("Sorry !", "Data Tidak Ditemukan !" , "warning");
                }
            }
        });
    }

    function SaveTransaction(){
            var count = $(".ckbox-trans:checked").length;
            if(count < 1){
                swal("Warning !", "Harap Ceklis terlebih dahulu", "warning");
                return;
            }

            var checkValues = $('.ckbox-trans:checked').map(function(){
                console.log($(this).val());
                return $(this).val();
            }).get();

            var checkValuesDoc = $('.ckbox-trans:checked').map(function(){
                console.log($(this).val());
                return $(this).val();
            }).get();
            
            var NoRek = $("#list-rek").val();
            
            if ($('.options').val() == "Employee") {
                var outletcode = "Employee";
            } else if ($('.options').val() == "Outlet") {
                var outletcode = $('.list-outlet').val();
            }

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>/CPayment/SaveTransaction",
                dataType: "JSON",
                data: {
                    DocNo: checkValuesDoc,
                    NoRek: NoRek,
                    outletcode: outletcode
                    // Number_Card: Number_Card
                },
                success: function(data) {
                    console.log(data);
                    for (var i = 0; data["hasil"]["length"] > i; i++) {
                        if(data['hasil'][i]['MsgError']){
                            var error = data['hasil'][i]['MsgError'];
                            swal("Warning !", error , "warning");
                        }else if(data['hasil'][i]['Result']){
                            swal("Success", "Data Berhasil Disimpan !" , "success");
                            swal({
                                    title: "Success",
                                    text: "Data Berhasil Disimpan !",
                                    icon: "success",
                                })
                                .then((isConfirm) => {
                                    if (isConfirm) {
                                        $('#modalAddTransaction').modal('hide');
                                        gettemptransaksi();
                                    }
                                });
                        }else{
                            swal("Oops !", "Harap Hubungi IT" , "error");
                        }
                    }   
                },
                beforeSend: function(){
                    // swal("Loading", "Harap Tunggu ya kak..." , "warning");
                },
                error: function (jqXHR, exception) {
                    console.log(exception);
                    swal("Oops !", "Harap Hubungi IT" , "error");
                },
            });
        }

        $(".btn-save").click(function(){
            SaveTransaction();
            // gettemptransaksi();
        });
</script>