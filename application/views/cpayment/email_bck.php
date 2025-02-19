<style>
    .select2-selection__choice button {
        border: none;
        background-color: transparent;
    }

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

<a href="#" class="btn btn-primary float btn-addtrans" data-bs-target="#modalAddTransaction">
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
                                    <form action="<?= base_url('CPayment') ?>/submitemail" method="POST" id="myemail" enctype="multipart/form-data">
                                        <h5 class="m-b-10">Email</h5>
                                        <div class="form-group">
                                            <!-- <label class="form-label" for="toemail">To</label> -->
                                            <div class="form-group row text-black">
                                                <label class="col-form-label">To</label>
                                                <div class="col-sm-3">
                                                    <select class="form-select select2a options" name="options" id="options" placeholder="Choose Status" required>
                                                        <option value=""></option>
                                                        <option value="Employee" selected>Employee</option>
                                                        <option value="Outlet">Outlet</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4" id="form-outlet">
                                                    <select class="form-select select2c list-outlet" name="list-outlet" id="list-outlet" placeholder="Choose Status" required disabled>
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($ListOutlet as $outlet) { ?>
                                                            <option value="<?= $outlet->CustomerCode ?>">
                                                                <?= $outlet->CustomerCode ?> -
                                                                [<?= $outlet->CustomerName; ?>]</option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <select class="form-select select2d" name="toemail[]" id="toemailmultiple" placeholder="Choose Recipients" multiple="multiple" required>
                                                <?php foreach ($listemail as $e) { ?>
                                                    <option class="opt" value="<?= $e->Email ?>">
                                                        <?= $e->FullName . ' - [' . $e->Email . ']' ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#options").change(function() {
                                                        if (this.value == "Employee") {
                                                            $('.opt').remove();
                                                            <?php
                                                            foreach ($listemail as $e) { ?>
                                                                $('#toemailmultiple').append($('<option />', {
                                                                    class: 'opt',
                                                                    value: '<?= $e->Email ?>',
                                                                    text: '<?= $e->FullName . ' - (' . $e->Email . ')' ?>'
                                                                }));
                                                            <?php } ?>
                                                        } else {
                                                            $('.opt').remove();
                                                        }
                                                    });
                                                    $("#list-outlet").change(function() {
                                                        outlet = this.value;
                                                        getemailoutlet(outlet);
                                                    });
                                                });

                                                function getemailoutlet(outlet) {
                                                    $.ajax({
                                                        type: 'GET',
                                                        url: '<?= base_url(); ?>CPayment/getemailoutlet/' +
                                                            outlet,
                                                        dataType: 'JSON',
                                                        success: function(data) {
                                                            console.log(data);
                                                            $.each(data, function(key,
                                                                value) {
                                                                $('#toemailmultiple')
                                                                    .append($(
                                                                        '<option />', {
                                                                            class: 'opt',
                                                                            value: value
                                                                                .emailName,
                                                                            text: value
                                                                                .emailName
                                                                        }));
                                                            });

                                                        }
                                                    });
                                                }
                                            </script>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="subject">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" style="background-color:transparent">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="cc">Cc</label>
                                            <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Recipients"> -->
                                            <select class="form-select select2d" name="cc[]" id="cc" placeholder="Choose Cc" multiple="multiple" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($listcc as $e) { ?>
                                                    <option value="<?= $e->Email ?>">
                                                        <?= $e->FullName . ' - [' . $e->Email . ']' ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <!-- <div class="form-group">
                                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#caritransaction">
                                                <i class="ti-search"></i>&nbsp; Add Transaction
                                            </button>
                                        </div> -->
                                        <div class="d-flex flex-wrap gap-2" style="padding-bottom: 10px;">
                                            <!-- <button type="button" class="btn btn-primary btn-addtrans" data-bs-target="#modalAddTransaction"><i class="ti-search"></i>&nbsp; Add Data</button> -->

                                            <button type="button" class="btn btn-danger btn-clearall"><i class="feather icon-trash-2"></i>&nbsp; Clear All</button>
                                        </div>

                                        <div class="form-group">
                                            <!-- <input type="hidden" name="documentno[]" value="doc 1">
                                            <input type="hidden" name="documentno[]" value="doc 2">
                                            <input type="hidden" name="documentno[]" value="doc 3"> -->
                                            <div class="table-border-style">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No</th>
                                                                <th>Tujuan</th>
                                                                <th>NoRekening</th>
                                                                <th>DocumentNo</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="temptransaksi"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="summernote">Text Email</label>
                                            <textarea id="summernote" class="form-control" name="textemail"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="media" class="form-label">Upload File</label>
                                            <input name="files[]" class="form-control" type="file" id="media" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" onchange="filenames(this,$(this))" />
                                        </div>
                                        <!-- <ul class="list-inline me-auto mb-0">
                                            <li class="list-inline-item align-bottom">
                                                <a href="#" class="avtar avtar-s btn-link-secondary">
                                                    <i class="ti ti-file-upload f-18"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item align-bottom">
                                                <a href="#" class="avtar avtar-s btn-link-secondary">
                                                    <i class="ti ti-paperclip f-18"></i>
                                                </a>
                                            </li>
                                        </ul> -->
                                        <div class="flex-grow-1 text-center">
                                            <button class="btn btn-primary" type="submit">Kirim</button>
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

<!-- modal transaction -->
<div class="modal fade" id="caritransaction" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form class="modal-content" id="formtransaksi">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">List Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-start mb-2">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Date</label>
                        <input type="text" class="form-control" placeholder="Select Date" data-date-format="dd-mm-yyyy" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <!-- <label class="form-label">Status</label> -->
                        <div class="d-flex flex-wrap gap-2" style="padding-top: 29px;">
                            <button type="button" class="btn btn-outline-primary" name="findtransaksi" id="findtransaksi">Find Data</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="px-0 py-1">Pilih</th>
                                        <th class="px-0 py-1">PostingDate</th>
                                        <th class="px-0 py-1">DocumentNo</th>
                                        <th class="px-0 py-1">Description</th>
                                        <th class="px-0 py-1">OutletCode</th>
                                        <th class="px-0 py-1">CreditAmount</th>
                                        <th class="px-0 py-1">PostingBy</th>
                                    </tr>
                                </thead>
                                <tbody id="transactiontbody">
                                    <!-- <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checktransaction"
                                            checked>
                                    </div>
                                </td>
                                <td>sss</td>
                                <td>sss</td>
                                <td>sss</td>
                                <td>sss</td>
                                <td>sss</td>
                            </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="savetransaksi">Save</button>
            </div>
        </form>
    </div>

    <script>
        $('#findtransaksi').on('click', function() {
            if ($('#tanggal').val() != '') {
                tanggal = $('#tanggal').val().replace(/\//g, '-');
                findtransaksi(tanggal);
            }
        });

        function findtransaksi(tanggal) {
            var html = "";
            $.ajax({
                type: 'GET',
                url: '<?= base_url(); ?>CPayment/findtransaksi/' + tanggal,
                // data: tanggal,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    var i = 0;
                    $.each(data, function(key,
                        value) {
                        i++;
                        html += '<tr>';
                        html +=
                            '<td><div class="form-check"><input class="form-check-input" type="checkbox" name="notrans" value="' +
                            i + '" id="checktransaction"></div></td>';
                        html += '<td>' + value.PostingDate + '</td>';
                        html += '<td>' + value.DocumentNo + '</td>';
                        html += '<td>' + value.Description + '</td>';
                        html += '<td>' + value.OutletCode + '</td>';
                        html += '<td>' + formatRupiah(value.CreditAmount, '') + '</td>';
                        html += '<td>' + value.PostingBy + '</td>';
                        $('#transactiontbody').append(html);
                        html = "";
                    });
                }
            });
        }

        $(document).ready(function() {
            $("#formtransaksi").submit(function(event) {
                event.preventDefault();
                $.ajax({
                    url: "<?= base_url() ?>/cPayment/Email",
                    type: "POST",
                    data: {
                        'test': 'teststey',
                    }
                });
            });
        });

        $('#savetransaksi').on('click', function() {
            console.log('adjdk');
            datatransaksi = [];
            $("input:checkbox[name='notrans']:checked").each(function() {
                datatransaksi.push($(this).val());
            });
            console.log(datatransaksi);
        });
    </script>

    <script>
        jQuery(document).ready(function($) {
            (function() {
                const d_week = new Datepicker(document.querySelector('#tanggal'), {
                    buttonClass: 'btn'
                });
            })();
        });
    </script>

</div>
<!-- end modal transaction -->
<script>
    $('#savetransaksi').on('click', function() {
        console.log('adjdk');
        datatransaksi = [];
        $("input:checkbox[name='notrans']:checked").each(function() {
            datatransaksi.push($(this).val());
        });
        console.log(datatransaksi);
    });
</script>


<?php $this->load->view('modal/add_transaction', true); ?>

<script type="text/JavaScript">
    $(document).ready(function() {
        $('#form-outlet').hide();
        $('.btn-clearall').hide();
        
        $('#options').on('change', function(e) {
            if (this.value == "Outlet") {
                $('#form-outlet').show();
                $('#list-outlet').prop('required', true);
                $('#list-outlet').prop('disabled', false);
            } else if (this.value == "Employee") {
                $('#form-outlet').hide();
                $('#list-outlet').blur();
                $('#list-outlet').val('');
                $('#list-outlet').prop('required', false);
                $('#list-outlet').prop('disabled', true);
            }
        });
    });

    function GetEmailEmployeeRead(){
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>API/GetPromotionRead/GetPromotionReadList",
            dataType: "html",
            success: function(data) {
                $('#promotion-type').html(data);
                $('#promotion-type').change();
            },
            beforeSend: function( xhr ) {
                // console.log(xhr);
            }
        });
    }

    $("#list-email").on('change', function (e) {
            // PromotionCode = this.value.toUpperCase();
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>API/GetPromotionRead/CekDiscPromotion",
                dataType: "JSON",
                data : {
                    checksp : SpecialItemControl,
                    SpecialItemControl,
                    promotioncode : PromotionCode
                },
                success: function(data) {
                // console.log(data);
                    if(data["hasil"][0]["MsgError"]){
                        var error = data["hasil"][0]["MsgError"];
                        load();
                        swal("Sorry !", error , "info")
                    }else if(data["hasil"]["length"] > 0){
                        TotalPromo = data["hasil"][0].TotalPromotion;
                        $('#side-totalpromo').html('Rp '+rupiahjs(data["hasil"][0].TotalPromotion));
                    }else{
                        $('#side-totalpromo').html('Rp 0');
                    }

                    PaymentType = $('#pay-type').val();
                    if(PaymentType == "DEBIT" || PaymentType == "CREDIT"){
                        TotalCash = SubTotalAfterCalculate;
                        // console.log("SubTotalAfterCalculate="+SubTotalAfterCalculate);
                    }else if(PaymentType == "OVO" || PaymentType == "SHOPEEPAY" || PaymentType == "DANA" || PaymentType == "ATOME" || PaymentType == "GOPAY" || PaymentType == "LIVE SHOPEE" || PaymentType == "LIVE TIKTOK" || PaymentType == "KREDIVO"){
                        TotalCash = SubTotalAfterCalculate;
                        // console.log("SubTotalAfterCalculate="+SubTotalAfterCalculate);
                    }else{
                        TotalCash = 0;
                        TotalChange = 0;
                        $("#side-cash").val(TotalCash);
                        $("#side-change").val(TotalChange);
                    }

                    $("#promotion-type").blur();
                    CalculationPayment(1,SubTotal,TotalDisc,TotalPromo,TotalVoucher,TotalRedeem,TotalCash);
                }
            });
        });

    function gettemptransaksi() {
        $("#temptransaksi").children().remove();
        var html = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url(); ?>API/GetTransactionRead/GetTempTransaksi',
            // data: tanggal,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                if(data == 0){
                    $('.btn-clearall').hide();
                }else{
                    $('.btn-clearall').show();
                }

                var i = 0;
                $.each(data, function(key,
                    value) {
                    i++;
                    html += '<tr>';
                    html += '<td align="center">' + i + ' </td>';
                    html += '<td>' + value.ToName + '</td>';
                    html += '<td>' + value.ToRekening + '</td>';
                    html += '<td>' + value.DocumentNo + '</td>';
                    html += '<td>' + value.Description + '</td>';
                    html += '<td>' + formatRupiah(value.CreditAmount, '') + '</td>';
                    html += '<td align="center"><a href="#" data-DocNo="' + value.DocumentNo +
                        '" class="btn-deletetemp"><i class="feather icon-trash-2 ms-3 f-16 text-danger"></i></a></td>';
                    html += '</tr>';
                    $('#temptransaksi').append(html);
                    html = "";
                });
            }
        });
    }

    gettemptransaksi();

    function DeleteTemp(fa, DocNo) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>CPayment/Delete_Transaction",
            dataType: "JSON",
            data: {
                fa: fa,
                DocNo: DocNo
            },
            success: function(data) {
                if (data["hasil"]["length"] > 0) {
                    if (data['hasil'][0]['MsgError']) {
                        var error = data['hasil'][0]['MsgError'];
                        swal("Warning !", error, "warning");
                        return;
                    } else if (data['hasil'][0]['Result']) {
                        gettemptransaksi();
                    }
                } else {
                    swal("Sorry !", "Save Data Failed !", "error");
                }
            }
        });
    }

    $(document).on("click", ".btn-clearall", function(e) {
        var DocNo = "";
        DeleteTemp(2, DocNo);
    });

    $(document).on("click", ".btn-deletetemp", function(e) {
        var DocNo = $(this).data("DocNo");
        alert(DocNo);
        DeleteTemp(DocNo);
    });

    //swal Email Sukses
    var data = '<?php echo $this->session->flashdata('emailberhasil'); ?>';
    if (data != "") {
        swal('Congratulation !', data, 'success');
    }

    //swal Email Gagal
    var data = '<?php echo $this->session->flashdata('emailgagal'); ?>';
    if (data != "") {
        swal('Sorry !', data, 'error');
    }
</script>

<!-- <script>
    function gettemptransaksi() {
        $("#temptransaksi").children().remove();
        var html = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url(); ?>CPayment/getTransaksi',
            // data: tanggal,
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                var i = 0;
                $.each(data, function(key,
                    value) {
                    i++;
                    html += '<tr>';
                    html += '<td align="center">' + i + ' </td>';
                    html += '<td>' + value.ToName + '</td>';
                    html += '<td>' + value.ToRekening + '</td>';
                    html += '<td>' + value.DocumentNo + '</td>';
                    html += '<td>' + value.Description + '</td>';
                    html += '<td>' + formatRupiah(value.CreditAmount, '') + '</td>';
                    html += '<td align="center"><a href="#" data-transid="' + value.TempId +
                        '"class="btn-delete"><i class="feather icon-trash-2 ms-3 f-16 text-danger"></i></a></td>';
                    html += '</tr>';
                    $('#temptransaksi').append(html);
                    html = "";
                });
            }
        });
    }
</script> -->