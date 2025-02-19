<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">

                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card page-header">
                                    <h5 class="m-b-10">List Outlet</h5>
                                    <!-- <div class="card-header">
                                        <h5>Basic Table</h5>
                                        <span class="d-block m-t-5">use class <code>table</code> inside table
                                            element</span>
                                    </div> -->
                                    <div class="table-border-style">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="dt-simple">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Outlet Code</th>
                                                        <th width="25%">Outlet Name</th>
                                                        <th>City</th>
                                                        <th width="20%">State</th>
                                                        <th width="12%">Zone Code</th>
                                                        <th width="12%">PTCode</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="show_data_outlet"></tbody>
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
        // const dataTable = new simpleDatatables.DataTable("#dt-simple");

        function GetData() {
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>API/GetMasterRead/GetListOutlet",
                dataType: "JSON",
                data: {
                    fa: 1
                },
                success: function(data) {
                    // $('#dt-simple').DataTable().destroy()
                    var html = '';
                    for (var i = 0; data.hasil.length > i; i++) {
                        html += '<tr>' +
                            '<td align="center">' + Number(i + 1) + '</td>' +
                            '<td>' + data.hasil[i].CustomerCode + '</td>' +
                            '<td>' + data.hasil[i].CustomerName + '</td>' +
                            '<td>' + data.hasil[i].City + '</td>' +
                            '<td>' + data.hasil[i].State + '</td>' +
                            '<td>' + data.hasil[i].ZoneCode + '</td>' +
                            // '<td>' + data.hasil[i].CompanyCode + '</td>' +
                            '<td>' + data.hasil[i].PTCode + '</td></tr>';
                    }
                    $("#show_data_outlet").html(html);
                    $('#dt-simple').DataTable({
                        // responsive: true,
                        "pageLength": 10
                    });
                }
            })
        }

        GetData();

    });
</script>