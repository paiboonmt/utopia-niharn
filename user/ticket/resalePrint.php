<?php
    session_start();
    include('./middleware.php');
    $title = 'SALE | TIGER APPLICATION';
    include './middleware.php';
    $page = 'sale';
    date_default_timezone_set('Asia/Bangkok');

    if ( isset($_GET['id'])) {
        $id = $_GET['id'];
        
        include "../includes/connection.php";
        $stmt = $conndb->query("SELECT `id`,`package`, `m_card` , `fname` ,`AddBy` , `sta_date`, `exp_date`, `date`,`comment`, `price`,`pay` ,`discount` ,`vat7`,`vat3`, `code`, `total`
        FROM `member` WHERE id = '$id' ");
        $stmt->execute();

        foreach ( $stmt AS $row ) {
            $_SESSION['package'] = $row['package'];
            $_SESSION['m_card'] = $row['m_card'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['AddBy'] = $row['AddBy'];
            $_SESSION['sta_date'] = $row['sta_date'];
            $_SESSION['exp_date'] = $row['exp_date'];
            $_SESSION['date'] = $row['date'];
            $_SESSION['comment'] = $row['comment'];
            $_SESSION['price'] = $row['price'];
            $_SESSION['pay'] = $row['pay'];
            $_SESSION['vat7'] = $row['vat7'];
            $_SESSION['vat3'] = $row['vat3'];
            $_SESSION['discount'] = $row['discount'];    
            $_SESSION['code'] = $row['code']; 
            $_SESSION['total'] = $row['total']; 
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
               * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .imgqrcode {
            height: 80px;
            width: 80px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            align-items: center;
            margin-bottom: 5px;
        }

        hr {
            border-top: 1px dashed #8c8b8b;
        }

        span {
            font-size: 12px;
        }

        #col{
            margin-right: 20px;
            text-align: right;
        }
        .foot{
            margin-bottom: 400px;
            font-size: 8px;
        }
        h5{
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h5 class="text-center">Tiger Muay Thai & MMA Training Camp</h5>
                <div class="text-center">
                    <img src="https://qrcode.tec-it.com/API/QRCode?data=<?= $_SESSION['m_card'] ?>%0a&backcolor=%23ffffff" class="imgqrcode">
                </div>
                <?php
    
                    $price  = $_SESSION['price'];

                    $discount = $_SESSION['discount'];

                    $discount = ($price * $discount) / 100 ;

                    $price = $_SESSION['price'] - $discount;

                    $vat7 = ($price * $_SESSION['vat7']) / 100;

                    $price = $price + $vat7;

                    $vat3 = ($price * $_SESSION['vat3']) /100;

                    $total = $price + $vat3;

                    $_SESSION['total'];
                ?>
                <br>

                    <?php if ($_SESSION['total'] != 0) { 
                        include './salePrintEnd.php';
                    } else { 
                        include './salePrintEndEdite.php';
                    } ?> 

            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mt-2">
           <div class="col-md-12 mt-5">
           <?php include 'salePrintVendor.php'; ?>
           </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
<script>
    window.print();

    setInterval(count, 1000);

    function count() {
        // window.onafterprint = window.close
        window.location.href = './recordticket.php';
        console.log('ok')
        $_SESSION['remove'] = true;
    }
</script>

</html>