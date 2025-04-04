<?php
    session_start();
    include('middleware.php');
    $title = 'PRINT BILL | TIGER APPLICATION';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .imgqrcode {
            height: 50px;
            width: 50px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            align-items: center;
            margin-bottom: 5px;
        }

        hr {
            border-top: 2px dashed #8c8b8b;
            outline:2px dashed #8c8b8b;
        }

        span {
            font-size: 11px;
        }

        #col{
            margin-right: 20px;
            text-align: right;
        }
        h5 {
            font-size: 10px;
            text-align: center;
        }
        .dt{
            font-size: 9px;
        }
        dd{
            font-size: 9px;
        }
        #watermark p {
            position: absolute;
            color: blue;
            font-size: 25px;
            top: 40%;
            text-align: center;
            font-weight: bold;    
            width: 100%;    
            pointer-events: none;
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);        
        } 
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php 
                    require_once("../includes/connection.php");
                    $ref_order_id = $_GET['ref_order_id'];
                    $sql = $conndb->prepare("SELECT o.ref_order_id , os.product_name , o.price , 
                    o.discount , o.vat7 , o.vat3 , o.fname , o.sta_date , o.exp_date , 
                    o.comment , m.AddBy , o.num_bill , o.pay , m.code , m.m_card , o.date , p.detail
                    FROM `voice` as o
                    INNER JOIN `voice_order_details` as  os ON o.id = os.order_id
                    INNER JOIN `member` as m ON m.package = o.id
                    INNER JOIN `products`as p ON os.product_id = p.id
                    WHERE o.ref_order_id  = '$ref_order_id'; ");
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
                ?> 
                
<p style="text-align: center; text-transform: uppercase; margin-top: 0px;">Vendor</p>
<hr>

<div class="row">
    <div class="col"><span>Tax inv. No</span></div>
    <div class="col" id="col"><span><?= $row[0]['num_bill'] ?></span></div>
</div>

<div class="row">
    <div class="col"><span>Tax inv. Date</span></div>
    <div class="col" id="col"><span><?= date('d-m-Y | H:i:s' ) ?></span></div>
</div>

<div class="row">
    <div class="col"><span>QR Code</span></div>
    <div class="col" id="col"><span><?= $row[0]['ref_order_id'] ?></span></div>
</div>

<hr>

<?php
    $total = 0;
    $ref_order_id = $_GET['ref_order_id'];
    $sql = "SELECT * 
    FROM `orders` as o
    INNER JOIN `voice_order_details` as  os
    ON o.id = os.order_id
    WHERE ref_order_id = ? ";

    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(1 , $ref_order_id , PDO::PARAM_INT);
    $stmt->execute();
    $check = $stmt->fetchAll();
    $checkCount = $stmt->rowCount();

    $idd = $check[0]['order_id'];
    $checkRow = "SELECT * FROM `voice_order_details` WHERE order_id = '$idd'";
    $stmtCheckRow = $conndb->prepare($checkRow);
    $stmtCheckRow->execute();
    $rowCount = $stmtCheckRow->rowCount();

    foreach ( $check AS $rowq ) : ?>

<div class="row">
    <div class="col col-12"><span><?= $rowq['product_name'] ?> </span></div>
    <div class="col"><span>Qty :<span><?= $rowq['quantity'] ?></span> </div>
    <div class="col" id="col"><span><?= number_format($rowq['price'] * $rowq['quantity'] ,2)?></span> </div>
</div>

<?php $total += $rowq['price'] * $rowq['quantity'] ?>

<?php endforeach; ?>

<hr>

<div class="row">
    <div class="col"><span>Total Bath : </span></div>
    <div class="col" id="col"><span><?= number_format($total,2) ?></span></div>
</div>

<!-- มี Discount -->
<?php if ( $row[0]['discount'] != 0 ) { ?>
    
    <!-- Discount -->
    <div class="row">
        <div class="col"><span>Discount <?= $row[0]['discount'] ?> % : </span></div>
        <div class="col" id="col"> <span><?= number_format( '-' . $discount , 2 ) ?></span> </div>
    </div>
    <?php $total = $total - $discount  ?>
    <!-- NET BATH -->
    <div class="row">
        <div class="col"><span>NET BATH : </span></div>
        <div class="col" id="col"><span><?= number_format($total,2) ?></span></div>
    </div>
    <!-- vat7 -->
    <?php if ( $row[0]['vat7'] != 0 ) { ?>

        <?php $vat7 = $total * 7 /100 ?>

            <div class="row">
                <div class="col"><span>VAT 7.00% :</span></div>
                <div class="col" id="col"><span><?= number_format( $vat7 , 2) ?></span></div>
            </div>

            <?php $total = $total + $vat7  ?>

            <?php if ( $row[0]['vat3'] != 0) {?>

                <?php $vat3 = ( $total * 3 ) / 100 ?> 

                <div class="row">
                    <div class="col"><span>Charge Card 3.00% :</span></div>
                    <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
                </div>

                <?php $total = $total + $vat3 ?>

                <div class="row">
                    <div class="col"><span>Total Amount : </span></div>
                    <div class="col" id="col"><span><?= number_format( $total   , 2) ?></span></div>
                </div>


            <?php } else { ?>

                <div class="row">
                    <div class="col"><span>Total Amount : </span></div>
                    <div class="col" id="col"><span><?= number_format( $total  , 2) ?></span></div>
                </div>

        <?php } ?>

        <?php } else { ?>
            <?php if ( $row[0]['vat3'] != 0) {?>
                <?php $vat3 = $total * 3 / 100  ?>
                <div class="row">
                    <div class="col"><span>Charge Card 3.00% :</span></div>
                    <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
                </div>
                <div class="row">
                    <div class="col"><span>Total Amount : </span></div>
                    <div class="col" id="col"><span><?= number_format( $total + $vat3 , 2) ?></span></div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col"><span>Total Amount : </span></div>
                    <div class="col" id="col"><span><?= number_format( $total, 2) ?></span></div>
                </div>
            <?php } ?>
        <?php } ?>


            <!-- ถ้าไม่มี Discount -->
            <?php } else { ?>
                <?php if ( $row[0]['vat7'] != 0) {?>

                    <div class="row">
                        <div class="col"><span>Vat 7.00 % :</span></div>
                        <div class="col" id="col"><span><?= number_format( $vat7, 2) ?></span></div>
                    </div>

                    <?php $total = $total + $vat7 ?>

                    <?php if ( $row[0]['vat3'] != 0) {?>

                        <?php $vat3 = $total * 3 /100  ?>

                        <div class="row">
                            <div class="col"><span>Charge Card 3%:</span></div>
                            <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
                        </div>
                        <?php $total = $total + $vat3 ?>
                    <?php } ?>

                    <div class="row">
                        <div class="col"><span>Total Amount: </span></div>
                        <div class="col" id="col"><span><?= number_format( $total , 2) ?></span></div>
                    </div>

                <?php } else { ?>

                    <?php if ( $row[0]['vat3'] != 0) { ?>

                        <div class="row">
                            <div class="col"><span>Charge Card 3%:</span></div>
                            <div class="col" id="col"><span><?= number_format( $vat3 ,2)?></span> </div>
                        </div>
                        <div class="row">
                            <div class="col"><span>Total Amount  : </span></div>
                            <div class="col" id="col"><span><?= number_format( $total + $vat3  , 2) ?></span></div>
                        </div>

                    <?php } ?>

                <?php } ?>

            <?php } ?>


            <div class="row">
                <div class="col"><span>Payment :</span></div>
                <div class="col" id="col"><span><?= $row[0]['pay'] ?></span></div>
            </div>

            <hr>
            <div id="watermark">
                <p>Canceled bill</p>
            </div>
                <!-- Customer Name  -->
                <div class="row">
                    <div class="col"><span>Customer Name :</span></div>
                    <div class="col" id="col"><span><?= $row[0]['fname'] ?></span></div>
                </div>
                <!-- Time to buy -->
                <div class="row">
                    <div class="col"><span>Time to buy :</span></div>
                    <div class="col" id="col"><span><?= date('H:i:s , d/m/Y', strtotime($row[0]['date'])) ?></span></div>
                </div>
                <!-- Start / End -->
                <div class="row">
                    <div class="col"><span>Start : <?= date('d/m/y', strtotime($row[0]['sta_date'])) ?></span></div>
                    <div class="col" id="col"><span>Expiry : <?= date('d/m/Y' , strtotime($row[0]['exp_date'])) ?></span></div>
                </div>
                <!-- comment -->
                <div class="row mt-2">
                    <div class="col"><span><?= $row[0]['comment'] ?></span></div>
                </div>
                <!-- Sale Employee -->
                <div class="row">
                    <div class="col"><span>Employee : <?= $row[0]['AddBy']  ?></span></div>
                </div>

                <div class="foot text-center" style="font-size: 10px; margin-top: 150px;">
                    <div class="row">
                        <p>reprint</p>
                        <p>Thank You.</p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    window.print();
    setTimeout(() => {
       window.location.href = 'recordTicket.php';
    }, 2000);
</script>
</html>
<?php $conndb = null; ?> 