<?php
$vUserLogin = $this->input->cookie('cookie_invent_user');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
    <style>
        /* Styling for better presentation, you can customize this according to your needs */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .wrapper {
            width: 100%;
            margin: 0 auto;
        }

        header,
        footer {
            padding: 10px;
            text-align: left;
        }

        content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: rgb(51, 186, 240);
            color: #000;
        }

        footer a {
            color: #000;
            text-decoration: none;
            /* margin: 0 10px; */
            border: 1px solid #000;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <header>
            <!-- <h1>Email Title</h1> -->
        </header>

        <content>
            <h3>Dear Bapak / Ibu</h3>
            <p>Berikut kami informasikan <?= $subject ?></p>
            <table>
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Pemilik Rekening</th>
                        <th>Nomor Rekening</th>
                        <th>Berita</th>
                        <th>Jumlah</th>
                        <!-- <th>Total Amount</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 0;
                    $i = 1;

                    foreach ($documentnodistint as $listdis) {
                        $totalamount = 0;
                        foreach ($documentno as $list) {
                            if ($listdis->ToRekening == $list->ToRekening) {
                                $no++; ?>
                                <tr>
                                    <td align="center"> <?= $no; ?> </td>
                                    <td><?= $list->ToName; ?></td>
                                    <td><?= $list->ToRekening; ?></td>
                                    <td><?= $list->Description; ?></td>
                                    <td><?= 'Rp ' . number_format($list->CreditAmount); ?></td>

                                    <?php $totalamount += $list->CreditAmount;
                                    $i++; ?>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr>
                            <td colspan="4" style="text-align:center;font-weight:bold">Total Transfer</td>
                            <td style="font-weight:bold"><?= 'Rp ' . number_format($totalamount); ?></td>
                        </tr>
                    <?php } ?>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            <br>
            <hr>
            <?php echo html_entity_decode($textemail); ?>
        </content>

        <footer>
            <p><b>Regards,</b></p>
            <p><b><?= $user->Alias; ?><br>Finance | RPGroup</b><br>
                Plumpang Semper No.3<br>
                Jakarta Utara, Indonesia 14260</p>
            <br>
            <p>Find Us</p>
            <p>
                <a href="https://www.instagram.com/nghty.id/" style="border: none;">Instagram Naughty</a><br>
                <a href="https://www.instagram.com/lesfemmes.id/" style="border: none;">Instagram LesFemmes</a><br>
                <a href="https://www.tiktok.com/@naughty_id" style="border: none;">Tiktok Naughty</a><br>
                <a href="https://www.tiktok.com/@lesfemmes_id" style="border: none;">Tiktok LesFemmes</a>
            </p>
        </footer>
    </div>
</body>

</html>