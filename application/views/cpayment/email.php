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
                                                        <?php foreach ($ListOutlet as $outlet) { ?>
                                                            <option class="toko" value="<?= $outlet->CustomerCode ?>">
                                                                <?= $outlet->CustomerCode ?> - [ <?= $outlet->CustomerName; ?> ]</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <select class="form-select select2d mailto" name="toemail[]" id="toemailmultiple" placeholder="Choose Recipients" multiple="multiple" required>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="subject">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" style="background-color:transparent" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="cc">Cc</label>
                                            <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Recipients"> -->
                                            <select class="form-select select2d" name="cc[]" id="cc" placeholder="Choose Cc" multiple="multiple" required>
                                                <option value=""></option>
                                                <?php foreach ($listcc as $e) { ?>
                                                    <option value="<?= $e->Email ?>">
                                                        <?= $e->FullName . ' - [' . $e->Email . ']' ?></option>
                                                <?php } ?>
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
                                            <button class="btn btn-primary btn-kirim" type="submit"><i class="fa fa-paper-plane me-1"></i> Kirim</button>
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


<?php $this->load->view('modal/add_transaction', true); ?>

<script type="text/JavaScript">
    $(document).ready(function() {
        var outletcode = "";

        gettemptransaksi();
        GetListEmailEmployee();

        $('#form-outlet').hide();
        $('.btn-clearall').hide();
        
        $('#options').on('change', function(e) {
            if (this.value == "Outlet") {
                // $('.opt').remove();
                // GetListEmailOutlet();
                $('#form-outlet').show();
                $('#list-outlet').prop('required', true);
                $('#list-outlet').prop('disabled', false);
                $('#toemailmultiple').prop('disabled', true);
            } else if (this.value == "Employee") {
                // $(".toko").remove();
                GetListEmailEmployee();
                $('#form-outlet').hide();
                $('#list-outlet').blur();
                $('#list-outlet').val('');
                $('#list-outlet').prop('required', false);
                $('#list-outlet').prop('disabled', true);
            }
        });

        $('#list-outlet').on('change', function (e) {
            outletcode = $('.list-outlet').val();
            // alert(outletcode);
            $('#toemailmultiple').prop('disabled', false);
            GetListEmailOutlet(outletcode);
        });
    });

    function GetListEmailEmployee(){
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>API/GetMasterRead/GetListEmailEmployee",
            dataType: "html",
            success: function(data) {
                // console.log(data);
                $('.mailto').html(data);
            },
            beforeSend: function( xhr ) {
                // console.log(xhr);
            }
        });
    }

    function GetListEmailOutlet(outletcode){
        $.ajax({
            type: "GET",
            url: "<?= base_url(); ?>API/GetMasterRead/GetListEmailOutlet/"+ outletcode,
            dataType: "html",
            success: function(data) {
                // console.log(data);
                $('#toemailmultiple').html(data);
            },
            beforeSend: function( xhr ) {
                // console.log(xhr);
            }
        });
    }

    function gettemptransaksi() {
        
        $("#temptransaksi").children().remove();
        var html = "";
        $.ajax({
            type: 'GET',
            url: '<?= base_url(); ?>API/GetTransactionRead/GetTempTransaksi',
            // data: tanggal,
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);--
                if(data == 0){
                    $('.btn-clearall').hide();
                }else{
                    $('.btn-clearall').show();
                }

                var i = 0;
                var x = 0;
                var count_key = data.length;
                var rek = "";
                var data1 = data[0];
                var data2 = data[1];
                var TempRekening = '';
                var Countall = data1.length;
                let CountData = 0;
                var rek = '';
                
                let totalamount = 0;
                
                $.each(data1, function(key, value) {
                    // console.log("print:"+ data1);
                    
                    // href = "<?= base_url(); ?>CPayment/Delete_Transaction/" + value.DocumentNo;
                    ToName = value.ToName
                    ToRekening = value.ToRekening; 
                    DocumentNo = value.DocumentNo;
                    Description = value.Description;
                    CreditAmount = value.CreditAmount;
                    i++;
                    x++;
                    
                    html += '<tr>';
                    html += '<td>' + i + ' </td>';
                    html += '<td>' + ToName + '</td>';
                    // html += '<td>' + ToRekening + '--'+TempRekening+ '</td>';
                    html += '<td>' + ToRekening + '</td>';

                    html += '<td>' + DocumentNo + '</td>';
                    html += '<td>' + Description + '</td>';
                    html += '<td>' + formatRupiah(CreditAmount, '') + '</td>';
                    html += '<td align="center"><a href="#" class="btn-deleterow" data-docno="'+ DocumentNo +'" class="btn-deletetemp"><i class="feather icon-trash-2 ms-3 f-16 text-danger"></i></a></td>';
                    html += '</tr>';
                    
                        $.each(data2, function(key, value) {
                            if(ToRekening === value.ToRekening){
                                CountData = value.jml;
                            }
                        });
                        
                    totalamount += parseInt(CreditAmount) ;

                    if (x === CountData){
                        html += '<tr>';
                        html += '<td>&nbsp;</td>';
                        html += '<td colspan="4" style="text-align:center;font-weight:bold">Total Amount :</td>';
                        html += '<td><b> Rp '+rupiahjs(totalamount) +'</b></td>';
                        html += '<td>&nbsp;</td>';
                        html += '</tr>';
                    totalamount = 0;  
                    x=0;
                }
                CountData = 0; 
                TempRekening = ToRekening; 
                   
                $('#temptransaksi').append(html);
                html = "";
                });
            }
        });
    }

    function DeleteTempAll(fa, DocNo) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>CPayment/Delete_AllTransaction",
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

    function DeleteTemp(fa, DocNo)
        {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>CPayment/Delete_Transaction",
                dataType: "JSON",
                data: {
                    fa: fa,
                    DocNo : DocNo
                },
                success: function(data) { 
                    gettemptransaksi();
                }
            });
        }

    $(document).on("click", ".btn-clearall", function(e) {
        var DocNo = "";
        DeleteTempAll(2, DocNo);
    });

    $(document).on("click", ".btn-deleterow", function(e) {
        // var getLink = $(this).attr('href');
        var DocNo = $(this).data("docno");
        // alert(DocNo);
        DeleteTemp(1, DocNo);
    });

    // $("#list-outlet").on('change', function (e) {
    //     NumberCard = $('#list-outlet').val();

    //     $cookieOutlet = array(
    //         'name'   => 'cookie_invent_outlet',
    //         'value'  => NumberCard,
    //         'expire' => '86400'
    //     );
    //     $this->input->set_cookie($cookieOutlet);
    // });

    
    // $(document).on("click", ".btn-kirim", function(e) {
    //     loadingKirim();
    // });

    //swal Email Sukses
    var data = '<?php echo $this->session->flashdata('emailberhasil'); ?>';
    if (data != "") {
        swal('Complete !', data, 'success');
        // $('.btn-kirim').prop("disabled", false);
    }

    //swal Email Gagal
    var data = '<?php echo $this->session->flashdata('emailgagal'); ?>';
    if (data != "") {
        swal('Sorry !', data, 'error');
    }

    function loadingKirim() {
        $('.btn-kirim').prop("disabled", true);
        swal({
            title: "Send Email ...",
            text: "Tunggu Sampai Process Selesai !",
            icon: "warning",
            buttons: false
        });
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