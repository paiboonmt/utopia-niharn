<?php 
    session_start();
    include '../middleware.php';
    $page = 'recordticket';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <script src="../../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                         <?php 
                             if (isset($_GET['order_id'])) {
                                echo '<pre>';
                                print_r($_GET);
                                echo '</pre>';
                                global $conndb;
                                $order_id = $_GET['order_id'];
                                $product_id = $_GET['product_id'];
                                $sql = "SELECT * FROM `order_details` WHERE order_id = '$order_id' AND product_id = '$product_id'";
                                $stmt= $conndb->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                             }
                          ?>  
                                   
                            <!-- หมายเลข -->
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" value="<?= $result[0]['product_name'] ?>">
                                <input type="text" class="form-control" value="<?= $result[0]['price'] ?>">
                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../dist/js/adminlte.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>
</body>
</html>
<?php $conndb = null; ?> 