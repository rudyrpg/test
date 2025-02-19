<!DOCTYPE html>
<html lang="en">

<head>
    <!-- css untuk select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jika menggunakan bootstrap4 gunakan css ini  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <!-- cdn bootstrap4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Single Select Box</label>
                    <select id="kota" name="kota" class="form-control">
                        <option value=""></option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bogor">Bogor</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang">Tangerang</option>
                        <option value="Bekasi">Bekasi</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Surabaya">Surabaya</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="form-group">
                    <label>Multi Select Box</label>
                    <select id="kota2" name="kota2[]" class="form-control" multiple="multiple">
                        <option value=""></option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bogor">Bogor</option>
                        <option value="Depok">Depok</option>
                        <option value="Tangerang">Tangerang</option>
                        <option value="Bekasi">Bekasi</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Surabaya">Surabaya</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- wajib jquery  -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- js untuk bootstrap4  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <!-- js untuk select2  -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#kota").select2({
                theme: 'bootstrap4',
                placeholder: "Please Select"
            });

            $("#kota2").select2({
                theme: 'bootstrap4',
                placeholder: "Please Select"
            });
        });
    </script>
</body>

</html>