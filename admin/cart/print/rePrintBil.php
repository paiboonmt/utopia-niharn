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
                    $sql = $conndb->prepare("SELECT o.ref_order_id , os.product_name , o.price , 
                    o.discount , o.vat7 , o.vat3 , o.fname , o.sta_date , o.exp_date , 
                    o.comment , m.AddBy , o.num_bill , o.pay , m.code , m.m_card , o.date 
                    FROM `orders` as o
                    INNER JOIN `order_details` as  os ON o.id = os.order_id
                    INNER JOIN `member` as m ON m.package = o.id
                    INNER JOIN `products`as p ON os.product_id = p.id
                    WHERE o.id  = '$id'; ");
                    $sql->execute();
                    $row = $sql->fetchAll();
                                                          
                    function discount($total,$discount){
                        $discount = $total * $discount / 100;
                        return $discount;
                    }
                    function vat7($total,$vat7){
                        $vat7 = ($total * 7) / 100 ;
                        return $vat7;
                    }
                    function vat3($total,$vat3){
                        $vat3 = ($total * 3) / 100;
                        return $vat3;
                    }
                
                    $total = $row[0]['price'];
                    $discount = discount($row[0]['price'],$row[0]['discount']);
                    $vat7 = vat7($row[0]['price'],$row[0]['vat7']);
                    $vat3 = vat3($row[0]['price'],$row[0]['vat3']);

                    
                    // include("rePrintCustomer.php");
                    include("rePrintVender.php");
                    
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