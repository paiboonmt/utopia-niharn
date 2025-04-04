<?php 
    session_start();
    $title = 'TICKET | TIGER APPLICATION';
    include 'middleware.php';
    $page = 'reportTicket';
    require_once("../includes/connection.php");
    
    function checkId($conndb ,$id) {
        $result = null;
        $sql = 'SELECT * FROM `orders` WHERE `id` = :id ';
        $stmt= $conndb->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }

    if ( isset($_GET['id'])) {
        
        $data = checkId($conndb , $_GET['id'] );
        if ( $data >= 1 ) {
            // echo $data;
            $id = $_GET['id'];
            $sql = "SELECT * 
            FROM `orders` as o
            INNER JOIN `order_details` as  os
            ON o.id = os.order_id
            WHERE id = ? ";

            $stmt = $conndb->prepare($sql);
            $stmt->bindParam(1 , $id , PDO::PARAM_INT);
            $stmt->execute();

            $sqlProduct = "SELECT * FROM `products`";
            $stmtProduct = $conndb->query($sqlProduct);
            $stmtProduct->execute();

        } else {
            header("location:recordticket.php");
            exit;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <style>
    .double_line {
        text-decoration-line: underline;
        text-decoration-style: double;
        color: red;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php'?>
        <div class="content-wrapper">
            <div class="content">
            <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <div class="card mt-2 p-2">
                                <div class="card-header bg-dark">
                                   <div class="row">
                                        <div class="col-sm-6 me-auto">
                                            <h3>แบบแก้ไขบิลขาย</h3>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop">
                                                Add item
                                            </button>
                                            <button class="btn btn-info" onclick="reloadpage()">Refresh</button>
                                        </div>
                                    </div> 
                                </div>
                                <div class="card-body">
                                <form action="./recordticketSql.php" method="post">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>สินค้า</th>
                                                <th>จำนวน</th>
                                                <th>ราคา</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 1;
                                                $total = 0;
                                                $befortotal = 0;
                                                $countRow = $stmt->rowCount();
                                                foreach ( $stmt AS $row ) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $row['product_name']?></td>
                                                <td><?= $row['quantity']?></td>
                                                <input type="text" name="product_name" hidden value="<?= $row['product_name'] ?>">
                                                <input type="text" name="product_id" hidden value="<?= $row['product_id'] ?>">
                                                <td class="text-right"><?= number_format($row['price'],2)?></td>
                                                <td class="text-right">
                                                    <a href="recordticketEditBill.php?order_id=<?= $row['order_id'] ?>&product_id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    <?php if ( $countRow != 1 ) :?>
                                                        <a onclick="return confirm('Are your sure delete it ?')" href="recordticketSql.php?id=<?= $row['id'] ?>&pro_id=<?= $row['product_id'] ?>&act=delete" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                    <?php else :?>
                                                        <a onclick="return confirm('ไม่สามารถลบข้อมูลได้')" href="" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
                                                    <?php endif; ?>

                                                </td>
                                                <td></td>

                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content bg-dark">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Add item</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="recordticketSql.php" method="post">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                <label>Product name</label>
                                                                    <select id="my-select" name="new_product_id" class="form-control" >
                                                                        <?php foreach ( $stmtProduct AS $rowProduct) : ?>

                                                                        <option value="<?= $rowProduct['id'] ?>"><?= $rowProduct['product_name']. "| |" . $rowProduct['price'] ?></option>

                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label> Quantity </label>
                                                                <input type="number" name="quantity" class="form-control" value="1" min="1">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="addItem" class="btn btn-primary">ENTER</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                    </form>
                                                    </div>
                                                
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            </tr>
                                            
                                            <?php $befortotal += $row['price'] * $row['quantity']  ?> 
                                            <?php $total += $row['price'] * $row['quantity'] ?> 
                                            <?php endforeach; ?>
                                        </tbody>

                                        <tfoot>
                                            
                                        <?php if ( !empty($row['discount']) ) { ?>

                                            <!-- ราคารวมสินค้าทั้งหมด -->
                                            <tr>
                                                <td colspan="3">ราคารวมสินค้าทั้งหมด</td>
                                                <td class="text-right double_line"><?= number_format($total,2) ?></td>
                                                <td class="text-right">บาท</td>
                                            </tr>
                                            <!-- ส่วนลด -->
                                            <tr>
                                                <td colspan="2">ส่วนลด </td>
                                                <td ><?= $row['discount'] . '%' ?></td>
                                                    <?php $discount = $row['discount'] * $total / 100  ?> 
                                                <td class="text-right "><?= number_format($discount , 2) ?></td>
                                                <td class="text-right">บาท</td>
                                            </tr>
                                            <!-- ราคา - ส่วนลด -->
                                            <tr>
                                                <td colspan="3">ราคา - ส่วนลด</td>
                                                <td class="text-right double_line"><?= number_format($total - $discount,2) ?></td>
                                                <td class="text-right">บาท</td>
                                            </tr>

                                            <?php  $net = $total - $discount ;

                                    
                                                if ($row['vat7'] == 7 && $row['vat3'] == 3 ) :?>
                                                    <?php 
                                                        $vat7 = ( $row['vat7'] * $net ) / 100  ; 
                                                        $net7 = $net + $vat7;
                                                        $vat3 = ($row['vat3'] * $net7 ) / 100 ;
                                                    ?> 

                                                    <tr>
                                                        <td colspan="2">ภาษีมูลค่าเพิ่ม :</td>
                                                        <td><?= '7'.'%'; ?></td>
                                                        <td class="text-right"><?= number_format( $vat7 , 2 )  ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3">(ราคาสินค้าทั้งหมด - ด้วยส่วนลด) :  <?= number_format( $net ,2 ) . ' + ' . number_format( $vat7 , 2 )  ?> </td>
                                                        <td class="text-right double_line"><?= number_format( $vat7 + $net , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">ชาร์จ บัตรเครดิต : </td>
                                                        <td><?= '3'.'%'; ?></td>
                                                        <td class="text-right"><?= number_format( $vat3 , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr> 

                                                    <tr>
                                                        <td colspan="2">(ราคาสินค้าทั้งหมด - ด้วยส่วนลด) :  <?= number_format($net7 ,2 ). ' + ' . number_format( $vat3 , 2 )    ?> </td>
                                                        <td></td>
                                                        <td class="text-right"><?= number_format( $totalAmount =  $vat7 + $net + $vat3 , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>

                                                <?php elseif ($row['vat7'] == 7 && $row['vat3'] == 0) :?>
                                                    <?php 
                                                         $vat7 = ($net * 7) / 100 ;
                                                         $totalAmount = $net + $vat7;    
                                                    ?> 
                                                    <tr>
                                                        <td colspan="2">ภาษี : </td>
                                                        <td><?= '7'.'%'; ?></td>
                                                        <td class="text-right"><?= number_format( $vat7 , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>     
                                                    <tr>
                                                        <td colspan="2">รวมราคาสินค้ากับภาษี : <?= number_format($net,2) .' + '. number_format($vat7,2)  ?> </td>
                                                        <td></td>
                                                        <td class="text-right" ><?= number_format(  $totalAmount , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>  

                                                <?php elseif ($row['vat7'] == 0 && $row['vat3'] == 3) :?> 
                                                    <?php  $netVat3 = ($net * 3) / 100; ?> 
                                                    <tr>
                                                        <td colspan="2">ภาษี :</td>
                                                        <td><?= '3'.'%'; ?></td>
                                                        <td class="text-right"><?= number_format( $netVat3 , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr> 
                                                    <tr>
                                                        <td colspan="2">รวมราคาสินค้ากับภาษี : <?= number_format( $net , 2 ) . ' + ' . number_format($netVat3,2) ?></td>
                                                        <td></td>
                                                        <td class="text-right"><?= number_format($totalAmount =   $net + $netVat3  , 2 ); ?></td>
                                                        <td class="text-right">บาท</td>
                                                    </tr>
                                                <?php elseif ($row['vat7'] == 0 && $row['vat3'] == 0) :?> 
                                                     <?php $totalAmount = $net; ?>        
                                                <?php endif; ?> 
                                            
                                                                             

                                        <?php } else { ?> 

                                            <?php $net = 0; ?> 

                                                <tr>
                                                    <td colspan="3">ราคารวมสินค้าทั้งหมด</td>
                                                    <td class="text-right double_line" ><?= number_format($total,2) ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>

                                            <?php 
                                            
                                            if ( $row['vat7'] == 7 && $row['vat3'] == 3 ) :?>

                                                <?php 
                                                    $vat7 = ( $total * 7 ) / 100 ;
                                                    $totalAmount = $total + $vat7;
                                                ?> 

                                                <tr>
                                                    <td colspan="2">ภาษีมูลค่าเพิ่ม :</td>
                                                    <td><?= '7'.'%'; ?></td>
                                                    <td class="text-right"><?= number_format( $vat7 , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2">(ราคาสินค้าทั้งหมด - ด้วยส่วนลด) + ด้วย ภาษี 7% :</td>
                                                    <td></td>
                                                    <td class="text-right double_line"><?= number_format( $totalAmount , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>

                                                <?php 
                                                    $vat3 = ( $totalAmount * 3  ) / 100 ;
                                                    $totalAmount = $totalAmount + $vat3;
                                                ?> 

                                                <tr>
                                                    <td colspan="2">ชาร์จ บัตรเครดิต : </td>
                                                    <td><?= '3'.'%'; ?></td>
                                                    <td class="text-right"><?= number_format( $vat3 , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr> 

                                                <tr>
                                                    <td colspan="2">(ราคาสินค้าทั้งหมด - ด้วยส่วนลด) + ด้วย ภาษี 3% :</td>
                                                    <td></td>
                                                    <td class="text-right"><?= number_format( $totalAmount , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>

                                                <!-- <tr>
                                                    <td colspan="3">ราคารวมสินค้าทั้งหมด</td>
                                                    <td class="text-right double_line" ><?= number_format( $totalAmount , 2 ) ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr> -->

                                            <?php elseif ($row['vat7'] == 7 && $row['vat3'] == 0) :?>
                                                <?php 
                                                    $vat7 = ( $total * 7 ) / 100 ;
                                                    $totalAmount = $total + $vat7;
                                                ?> 
                                                <tr>
                                                    <td colspan="2">ภาษี : </td>
                                                    <td><?= '7'.'%'; ?></td>
                                                    <td class="text-right"><?= number_format( $vat7 , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>   

                                                <tr>
                                                    <td colspan="2">รวมราคาสินค้ากับภาษี 7%</td>
                                                    <td></td>
                                                    <td class="text-right" ><?= number_format(  $totalAmount , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>

                                            <?php elseif ($row['vat7'] == 0 && $row['vat3'] == 3) :?>

                                                <?php 
                                                    $vat3 = ( $total * 3 ) / 100 ;   
                                                    $totalAmount = $total + $vat3 ;
                                                ?> 


                                                <tr>
                                                    <td colspan="2">ภาษี : </td>
                                                    <td><?= $row['vat3'] . '%'; ?></td>
                                                    <td class="text-right"><?= number_format( $vat3 , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>   

                                                <tr>
                                                    <td colspan="2">รวมราคาสินค้ากับภาษี 3%</td>
                                                    <td></td>
                                                    <td class="text-right" ><?= number_format(  $totalAmount , 2 ); ?></td>
                                                    <td class="text-right">บาท</td>
                                                </tr>  

                                            <?php else :?> 
                                                <?php $totalAmount = $total; ?> 
                                            <?php endif; ?> 
                                        <?php } ?>

                                        </tfoot>
                                    </table>

                                <section id="2">
                                    <!-- หมายเลขบิล -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลขบิล : </label>
                                        </div>
                                        <input type="text" disabled class="form-control" value="<?= $row['num_bill'] ?>">
                                        <input type="text" name="m_card" hidden class="form-control"value="<?= $row['num_bill'] ?>">
                                    </div>
                                    <!-- หมายเลข -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">หมายเลข : </label>
                                        </div>
                                        <input type="text" disabled class="form-control" value="<?= $row['ref_order_id'] ?>">
                                        <input type="text" name="m_card" hidden class="form-control"value="<?= $row['ref_order_id'] ?>">
                                    </div>
                                    <!-- ส่วนลด -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">ส่วนลด : </label>
                                        </div>
                                        <select class="custom-select" name="discount">
                                            <option selected><?= $row['discount'] ?></option>
                                            <option value="0">0%</option>
                                            <option value="5">5%</option>
                                            <option value="10">10%</option>
                                            <option value="15">15%</option>
                                            <option value="20">20%</option>
                                            <option value="25">25%</option>
                                            <option value="30">30%</option>
                                            <option value="35">35%</option>
                                            <option value="40">40%</option>
                                            <option value="45">45%</option>
                                            <option value="50">50%</option>
                                        </select>
                                    </div>
                                    <!-- ประเภทการจ่าย -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ประเภทการจ่าย : </span>
                                        </div>
                                        <?php 
                                            $sqlPayment = $conndb->query("SELECT * FROM `payment` ORDER BY `pay_id` ASC");
                                            $sqlPayment->execute();
                                        ?> 
                                        <select class="custom-select" name="pay" id="paymentMethodSelect">
                                            <option selected><?= $row['pay'] ?></option>
                                            <?php foreach ( $sqlPayment AS $rowPayment ) :?>
                                                <option value="<?= $rowPayment['pay_name'] ?>"><?= $rowPayment['pay_name'] ?></option>
                                            <?php endforeach; ?> 
                                        </select>
                                    </div>
                                    <!-- Vat 7% -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ภาษี 7% : </span>
                                        </div>
                                        <input type="text" name="vat7" class="form-control" id="paymentDetails7" value="<?= $row['vat7'] ?>" required>
                                    </div>
                                    <!-- Charge Card 3% -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">บัตรเครดิตชาจ 3% : </span>
                                        </div>
                                        <input type="text" name="vat3" class="form-control" id="paymentDetails3" value="<?= $row['vat3'] ?>" required>
                                    </div>
                                    <!-- เริ่ม / หมด -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">เริ่ม</span>
                                                </div>
                                                <input type="date" name="sta_date" class="form-control"value="<?= $row['sta_date'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group mb-1">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">หมด</span>
                                                </div>
                                                <input type="date" name="exp_date" class="form-control"value="<?= $row['exp_date'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Customer name -->
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ชื่อลูกค้า : </span>
                                        </div>
                                        <input type="text" name="fname" class="form-control" value="<?= $row['fname'] ?>" required>
                                    </div>
                                    <!-- comment -->
                                    <div class="form-group">
                                        <textarea class="form-control" name="comment" rows="2" ><?= $row['comment'] ?></textarea>
                                    </div>
                                    <input type="text" name="order_id" hidden class="form-control" value="<?= $row['id'] ?>">          
                                    <div class="input-group mb-1">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">ยอดรวมทั้งหมด : </span>
                                        </div>
                                        <input type="text" class="form-control double_line" value="<?= number_format($totalAmount,2) ?>">
                                    </div>
                                    <input type="number" name="grandTotal" hidden class="form-control" value="<?= $totalAmount ?>">
                                    <div class="input-group mb-3">
                                        <input type="text" name="befortotal" hidden value="<?= $befortotal ?>">
                                        <input type="text"  class="form-control" hidden value="<?= $total ?> บาท">
                                    </div>
                                    <div class="row">
                                        <input type="submit" name="updateOrder" id="befor" class="btn btn-warning form-control" value="อัปเดท">
                                        <input type="submit" name="saveUpdateOrder" id="after" class="btn btn-success form-control" value="บันทึก || ปริ้น">
                                    </div>
                                </section>

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
    <script> 
        var paymentMethodSelect = document.getElementById("paymentMethodSelect");
        var paymentDetailsInput3 = document.getElementById("paymentDetails3");
        var paymentDetailsInput7 = document.getElementById("paymentDetails7");

        paymentMethodSelect.addEventListener("change", function() {
            if (paymentMethodSelect.value === "Cash" ||
                paymentMethodSelect.value === "QrCode" ||
                paymentMethodSelect.value === "Paypal") {
                paymentDetailsInput7.value = "7", paymentDetailsInput3.value = "0";
            } else if (paymentMethodSelect.value === "CreditCard" ||
                paymentMethodSelect.value === "VisaCard" ||
                paymentMethodSelect.value === "MasterCard" ||
                paymentMethodSelect.value === "UnionPay" ||
                paymentMethodSelect.value === "AmericanExpress") {
                paymentDetailsInput3.value = "3", paymentDetailsInput7.value = "0";
            } else if ( paymentMethodSelect.value === "Cash and cardit card") {
                paymentDetailsInput7.value = "7";
                paymentDetailsInput3.value = "3";
            } else {
                paymentDetailsInput7.value = "0";
                paymentDetailsInput3.value = "0";
            }

        });

        // refeash
        function reloadpage () {
            location.reload();
        }
    </script>

    <?php if (isset($_SESSION['updateBil'])){ ?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'Update Successfully!'
            }),
    
            document.getElementById("befor").hidden=true;
            document.getElementById("after").hidden=false;

        </script>
        
    <?php } else {?> 
        
        <script>
            document.getElementById("after").hidden=true;  
        </script> 
        
    <?php } unset($_SESSION['updateBil']);?>

    <?php if(isset($_SESSION['editBill'])) :?>
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ'
            });
        </script>  
    <?php endif; unset($_SESSION['editBill']); ?>
</body>
</html>
<?php $conndb = null; ?> 