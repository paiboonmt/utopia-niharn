<?php
    include('../../middleware.php');
    $title = 'SALE | TIGER APPLICATION';
    $page = 'sale';
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
                $productIds = [];
                $grantotal = 0;
                foreach (($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
                    $productIds[] = $cartId;
                }

                $Ids = 0;

                if (count($productIds) > 0) {
                    $Ids = implode(', ', $productIds);
                }

                $i = 1;

                require_once("../../../includes/connection.php");

                $lastId =  $_SESSION['order_id'];

                $stmts = $conndb->query("SELECT p.name , o.quantity ,p.price , p.id
                    FROM `store` AS p
                    LEFT JOIN shop_order_details AS o ON  p.id = o.product_id 
                    WHERE id IN ($Ids)
                    AND order_id = $lastId
                    ");
                $stmts->execute();

                include("printCustomer.php");

                ?>
            </div>
        </div>
    <script src="../../../dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php unset($_SESSION['cart']) ?>
<script>
    window.print();
    setTimeout(function() {
        window.location.href = '../../shop.php';
    }, 1000);
</script>
</html>
<?php $conndb = null; ?>