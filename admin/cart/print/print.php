<?php
    session_start();
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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .imgqrcode {
            height: 150px;
            width: 150px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            align-items: center;
            margin-bottom: 5px;
        }

        hr {
            border-top: 2px dashed #8c8b8b;
            outline: 2px dashed #8c8b8b;
        }

        span {
            font-size: 12px;
        }

        #col {
            margin-right: 10px;
            text-align: right;
        }

        h5 {
            font-size: 10px;
            text-align: center;
        }

        .dt {
            font-size: 9px;
        }

        dd {
            font-size: 9px;
        }
    </style>
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

                $stmts = $conndb->query("SELECT p.product_name , o.quantity ,p.price , p.id
                    FROM `products` AS p
                    LEFT JOIN order_details AS o ON  p.id = o.product_id 
                    WHERE id IN ($Ids)
                    AND order_id = $lastId
                    ");
                $stmts->execute();

                include("printCustomer.php");
                include("printVendor.php");

                ?>
            </div>
        </div>
    <script src="../../../dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php unset($_SESSION['cart']) ?>
<script>
    window.print();
    setTimeout(function() {
        window.location.href = '../../cart.php';
    }, 1000);
</script>
</html>
<?php $conndb = null; ?>