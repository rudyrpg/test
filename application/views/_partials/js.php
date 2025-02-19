<!-- =================================== Versi PRO =============================== -->

<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/prism.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/apexcharts.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/simple-datatables.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/utils.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/bouncer.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/choices.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/simplebar.min.js"></script>

<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/dropzone-amd-module.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/responsive.bootstrap5.min.js">
</script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/datepicker-full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/daterangepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/plugins/flatpickr.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pages/chart.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pages/dashboard-sale.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pages/dashboard-main.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pages/form-validation.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pages/widget-data.js"></script>


<!-- <script type="text/javascript" href="<?php echo base_url() ?>assets/vendor/select2/js/jquery-3.5.1.slim.min.js"></script>
<script type="text/javascript" href="<?php echo base_url() ?>assets/vendor/select2/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" href="<?php echo base_url() ?>assets/vendor/select2/js/select2.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script type="text/javascript">
    jQuery(function($) {
        //swal Login Berhasil
        var data = '<?php echo $this->session->flashdata('msgLogin'); ?>';
        if (data != "") {
            swal('Welcome !', data, 'success');
        }

        $('.data_tabel').DataTable({
            "pageLength": 10
        });

        /*Data Tabel*/
        // const dataTable = new simpleDatatables.DataTable("#pc-dt-simple");


        // [ Configuration Option ]
        $('.res-config').DataTable({
            responsive: true
        });

        // [ New Constructor ]
        var newcs = $('#new-cons').DataTable();

        new $.fn.dataTable.Responsive(newcs);

        // [ Immediately Show Hidden Details ]
        $('#show-hide-res').DataTable({
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                    type: ''
                }
            }
        });

        const d_week = new Datepicker(document.querySelector('.pc-datepicker-1'), {
            buttonClass: 'btn'
        });

        var dateToday = new Date();
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })
        $('.date-picker2').datepicker({
                autoclose: true,
                todayHighlight: true,
                minDate: dateToday,
                maxDate: dateToday,
                startDate: dateToday
            })
            //show datepicker when clicking on the icon
            .next().on(ace.click_event, function() {
                $(this).prev().focus();
            });
    });

    /*===========================================*/

    //CONVERT RUPIAH
    function rupiahjs(bilangan) {
        var bilangan = bilangan;
        var number_string = bilangan.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }
    // END CONVERT RUPIAH
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    $(document).ready(function() {
        $(".select2a").select2({
            theme: 'bootstrap4',
            placeholder: "Please Choose"
        });

        $(".select2b").select2({
            theme: 'bootstrap4',
            placeholder: "Please Select"
        });

        $(".select2c").select2({
            theme: 'bootstrap4',
            placeholder: "Please Choose Outlet"
        });

        $(".select2d").select2({
            theme: 'bootstrap4',
            placeholder: "Please Choose Email"
        });

        $(".select2e").select2({
            theme: 'bootstrap4',
            placeholder: "Please Choose",
            dropdownParent: $('#modalAddTransaction')
        });
    });

    // minimum setup
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-1'), {
            buttonClass: 'btn'
        });
    })();
    // input group layout
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-2'), {
            buttonClass: 'btn'
        });
    })();
    // enable clear button
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-3'), {
            buttonClass: 'btn',
            todayBtn: true,
            clearBtn: true
        });
    })();

    // orientation
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-4_1'), {
            buttonClass: 'btn',
            orientation: 'top left'
        });
    })();
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-4_2'), {
            buttonClass: 'btn',
            orientation: 'top right'
        });
    })();
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-4_3'), {
            buttonClass: 'btn',
            orientation: 'bottom left'
        });
    })();
    (function() {
        const d_week = new Datepicker(document.querySelector('#pc-datepicker-4_4'), {
            buttonClass: 'btn',
            orientation: 'bottom right'
        });
    })();

    // range picker
    (function() {
        const datepicker_range = new DateRangePicker(document.querySelector('.pc-datepicker-5'), {
            buttonClass: 'btn'
        });
    })();

    // inline picker
    (function() {
        const datepicker_inline = new Datepicker(document.querySelector('.pc-datepicker-6'), {
            buttonClass: 'btn'
        });
    })();

    // minimum setup
    flatpickr(document.querySelector('#pc-date_range_picker-1'), {
        mode: 'range'
    });
    flatpickr(document.querySelector('#pc-date_range_picker-2'), {
        mode: 'range'
    });
    flatpickr(document.querySelector('#pc-date_range_picker-3'), {
        mode: 'range',
        minDate: 'today',
        dateFormat: 'Y-m-d',
        disable: [
            function(date) {
                return !(date.getDate() % 8);
            }
        ]
    });
    flatpickr(document.querySelector('#pc-date_range_picker-4'), {
        mode: 'range',
        dateFormat: 'Y-m-d',
        defaultDate: ['2016-10-10', '2016-10-20']
    });
</script>


<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/pcoded.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/menu-setting.js"></script> -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/email-decode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/assets/js/rocket-loader.min.js"></script>


<script src="<?= base_url() ?>assets/vendor/summernote/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: '50vh',
        });
    });
</script>
</body>

</html>