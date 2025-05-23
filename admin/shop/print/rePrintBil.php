<?php
include('../../middleware.php');
$title = 'PRINT BILL | TIGER APPLICATION';
date_default_timezone_set('Asia/Bangkok');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./print.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php
                require_once("../../../includes/connection.php");
                $id = $_GET['id'];
                $sql = $conndb->prepare("SELECT * ,`shop_orders`.total as sumtotal
                FROM `shop_orders`
                INNER JOIN `shop_order_details` ON `shop_orders`.`id` = `shop_order_details`.`order_id`
                WHERE `shop_orders`.`id` = '$id'");
                $sql->execute();
                $row = $sql->fetchAll(PDO::FETCH_ASSOC);

                // function discount($total, $discount)
                // {
                //     $discount = $total * $discount / 100;
                //     return $discount;
                // }
                // function vat7($total, $vat7)
                // {
                //     $vat7 = ($total * 7) / 100;
                //     return $vat7;
                // }
                // function vat3($total, $vat3)
                // {
                //     $vat3 = ($total * 3) / 100;
                //     return $vat3;
                // }

                // $total = $row[0]['price'];
                // $vat7 = vat7($row[0]['price'], $row[0]['vat7']);
                // $vat3 = vat3($row[0]['price'], $row[0]['vat3']);


                include("rePrintCustomer.php");

                ?>
            </div>
        </div>
    </div>
    <script src="../../../dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    window.print();
    setTimeout(function() {
        window.close();
    }, 1000);
</script>
</html>
<?php $conndb = null; ?>