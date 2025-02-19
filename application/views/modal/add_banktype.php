<div class="modal fade" id="modaladdbanktype" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Bank Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-bank">
                    <div class="form-group row text-black">
                        <label class="col-sm-3 col-form-label">Kode Bank</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="kodebank" id="kodebank" autofocus required>
                            <small>Example : 014</small>
                        </div>
                    </div>
                    <div class="form-group row text-black">
                        <label class="col-sm-3 col-form-label">Nama Bank</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="namabank" id="namabank" required>
                            <small>Example : BCA</small>
                        </div>
                    </div>
                    <div class="form-group row text-black">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="descriptbank" id="descriptbank" required>
                            <small>Example : BANK CENTRAL ASIA</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" style="float: left;" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="add_bank" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/JavaScript">
    $( document ).ready(function() {
        $(document).on('click', '.btn-addbanktype', function() {
            $('#modaladdbanktype').modal('show');
            resetForm();
        });

        $('#modaladdbanktype').modal({backdrop: 'static', keyboard: false})  

        $("#kodebank").on('keyup', function (e) {
            this.value = this.value.toUpperCase();
        });

        $("#namabank").on('keyup', function (e) {
            this.value = this.value.toUpperCase();
        });

        $("#descriptbank").on('keyup', function (e) {
            this.value = this.value.toUpperCase();  
        });

        // $("#add_bank").on('click', function() {
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
        //             if(data["hasil"]["length"] > 0){
        //                 if(data['hasil'][0]['MsgError']){
        //                     var error = data['hasil'][0]['MsgError'];
        //                     swal("Warning !", error , "warning");
        //                     return;
        //                 }else if(data['hasil'][0]['Result']){
        //                     resetForm();
        //                     $('#modaladdbanktype').modal("hide");
        //                     swal("Success", "" , "success");
        //                 }
        //             }else{
        //                 swal("Sorry !", "Save Data Failed !" , "error");
        //             }
        //         },
        //         beforeSend: function(){
        //             swal("Loading", "Silahkan Tunggu ..." , "info");
        //         },
        //         error: function (jqXHR, exception) {
        //             // console.log(exception);
        //             swal("Oops !", "Harap Hubungi IT" , "error");
        //         },
        //     });
        // }

        function resetForm(){
            $('#kodebank').val('');
            $('#namabank').val('');
            $('#descriptbank').val('');
        }
    });

</script>