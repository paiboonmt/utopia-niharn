<?php 
    session_start();
    include 'middleware.php';
    $page = 'recordticket';
    $title = 'แก้ไขบิล';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php'?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php if (isset($_GET['order_id'])) {            
                                global $conndb;
                                $order_id = $_GET['order_id'];
                                $product_id = $_GET['product_id'];
                                $sql = "SELECT * FROM `order_details` WHERE order_id = '$order_id' AND product_id = '$product_id'";
                                $stmt= $conndb->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->fetchAll();
                             }
                          ?>

                        <div class="col-8">
                            <div class="card p-2">
                                <div class="card-header bg-dark">แก้ไขข้อมูล รายการสินค้า</div>
                                <div class="card-body">
                                    <form action="recordticketSql.php" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">product_name</span>
                                            </div>
                                            <input type="text" class="form-control" name="product_name"value="<?= $result[0]['product_name'] ?>" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Quantity</span>
                                            </div>
                                            <input type="text" class="form-control" name="quantity"value="<?= $result[0]['quantity'] ?>" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">price</span>
                                            </div>
                                            <input type="text" class="form-control" name="price"value="<?= $result[0]['price'] ?>" required>
                                        </div>
                                        <input type="text" name="order_id" hidden value="<?= $result[0]['order_id']?>">
                                        <input type="text" name="product_id" hidden value="<?= $result[0]['product_id'] ?>">
                                        <input type="submit" name="editBill" value="บันทึก" class="btn btn-success form-control">
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>
    <script src="../plugins/toastr/toastr.min.js"></script>
</body>

</html>
<?php $conndb = null; ?>