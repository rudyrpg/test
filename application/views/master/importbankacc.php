<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">Import Bank Account</h5>
                                    <!-- <div class="card-header">
                                        <h5>Basic Table</h5>
                                        <span class="d-block m-t-5">use class <code>table</code> inside table
                                            element</span>
                                    </div> -->

                                    <div class="card-body">
                                        <div class="alert alert-success" role="alert">Berikut File Format CSV ...
                                            <a target="_blank" href="<?= base_url(); ?>CPayment/download_contoh"> <b> klik disini untuk download</b></a>
                                        </div>
                                        <div class="form-group row text-black">
                                            <!-- <label class="col-sm-1 col-form-label">Upload File</label> -->
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="file" id="filebank" required>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-primary" id="upload"><i class="ti-export me-2"></i> Upload Now</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 text-center">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-12">
                                                <a href="" style="color: black" id="show">Show List <i class="fa fa-caret-down" aria-hidden="true" id="icon-down"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <section class="content" style="margin-top: 20px" id="field">
                                        <div class="table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="dt-import">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th>Outlet Code</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody id="show_data_outlet"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </section>
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
    $(document).ready(function() {
        $("#field").hide();

        $("#show").click(function(e) {
            e.preventDefault();
            $("#field").toggle(1000);
        });

        $("#upload").click(function() {
            swal({
                    title: "Upload File Bank Account",
                    text: "Anda yakin ingin upload file ?",
                    icon: "info",
                    buttons: true,
                })
                .then((isConfirm) => {
                    if (isConfirm) {
                        var formUrl = "<?= base_url(); ?>CPayment/import_proses";
                        var formData = new FormData($('.form-horizontal')[0]);
                        $.ajax({
                            url: formUrl,
                            type: 'POST',
                            data: formData,
                            mimeType: "multipart/form-data",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(data) {
                                console.log('errornya haha');
                                console.log(data);
                                if (data === 'FailFile') {
                                    alert('Harap pilih file atau pastikan file anda adalah CSV');
                                    return;
                                } else if (data === 'Done') {
                                    swal("Good Jobs!", "Proses Import Berhasil !", "success")
                                } else {
                                    swal(data)
                                }
                            },
                            beforeSend: function() {
                                loadingImport();
                            }
                        });
                    } else {
                        swal("Cancel !", "Upload File Dibatalkan !", "warning");
                    }
                });
        });
    });

    function loadingImport() {
        swal({
            title: "Process Import ...",
            text: "Tunggu Sampai Process Selesai !",
            icon: "warning",
            buttons: false
        });
    }
</script>