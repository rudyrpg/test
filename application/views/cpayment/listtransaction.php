<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">Daftar List Transaction</h5>
                                    <form method="POST">
                                        <div class="row center">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="text" class="form-control" placeholder="Select Date" data-date-format="dd-mm-yyyy" name="tanggal" id="input-datepicker" autocomplete="off">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Outlet Code</label>
                                                <select class="form-select select2a" name="outletcode" id="outletcode" placeholder="Choose Outlet Code" autocomplete="off">
                                                    <option value=""></option>
                                                    <!-- <option value="ALL">[ALL] - [ALL OUTLET]</option> -->
                                                    <?php
                                                    foreach ($ListOutlet as $outlet) { ?>
                                                        <option value="<?= $outlet->CustomerCode ?>">[<?= $outlet->CustomerCode ?>] - [<?= $outlet->CustomerName; ?>]</option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-md-3 mb-3">
                                                <label class="form-label">Status</label>
                                                <select class="form-select select2a" name="postingstatus" id="postingstatus" placeholder="Choose Status" autocomplete="off" required>
                                                    <option value=""></option>
                                                    <option value="sudah">Sudah Posting</option>
                                                    <option value="belum">Belum Posting</option>
                                                </select>
                                            </div> -->

                                            <div class="col-md-3 mb-3">
                                                <!-- <label class="form-label">Status</label> -->
                                                <div class="d-flex flex-wrap gap-2" style="padding-top: 29px;">
                                                    <button type="submit" class="btn btn-outline-primary" name="FindTrans" id="FindTrans">Find Data</button>
                                                    <button type="submit" class="btn btn-outline-primary" name="AllData" id="AllData">All Data</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <hr class=" my-2">

                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="pc-dt-simple">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Trans Date</th>
                                                        <th>DocumentNo</th>
                                                        <th>Description</th>
                                                        <th>Outlet Code</th>
                                                        <th>Credit Amount</th>
                                                        <th>Posting By</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $no = 0;
                                                    foreach ($ListTrans as $list) {
                                                        $no++; ?>
                                                        <tr>
                                                            <td> <?= $no; ?> </td>
                                                            <td><?= indo_date($list->PostingDate); ?></td>
                                                            <td><?= $list->DocumentNo; ?></td>
                                                            <td><?= $list->Description; ?></td>
                                                            <td><?= $list->OutletCode; ?></td>
                                                            <td><?= 'Rp ' . number_format($list->CreditAmount); ?></td>
                                                            <td><?= $list->PostingBy; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
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
        $('#pc-dt-simple').DataTable({
            "pageLength": 10
        });

        // minimum setup
        (function() {
            const d_week = new Datepicker(document.querySelector('#input-datepicker'), {
                buttonClass: 'btn'
            });
        })();

        // range picker
        flatpickr(document.querySelector('#input-daterange'), {
            mode: 'range'
        });
    });
</script>