<?php
    session_start();
    include('./middleware.php');
    $title = 'PROFILE | TIGER APPLICATION';
    $page = 'allmember';
    require_once '../includes/connection.php';


    function check() {
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
        exit;
    }

    function getMember( $conndb , $id ) {
        $data = null;
        $sql = "SELECT * FROM `member` WHERE `id` = ? ";
        $stmt = $conndb->prepare($sql);
        $stmt->bindParam( 1 , $id );
        $stmt->execute();
        $data = $stmt->fetchAll();
        return $data ;
    }

    function datediff($str_start,$str_end){
        $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
        $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
        return $ndays;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // search id 
        $data = getMember( $conndb , $id );
    
        if ( $data >= 1) {
            $exp_date = $data[0]['exp_date'];
        } else {
            header('location:allmemner.php');
        }
    
    
        $today = date('Y-m-d');
        $df = datediff($today, $exp_date);
        $birthday = $data[0]['birthday'];
        $today = date('Y-m-d');
        list($byear, $bmonth, $bday)= explode("-",$birthday);
        list($tyear, $tmonth, $tday)= explode("-",$today);
            
        $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
        $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
        $mage = ($mnow - $mbirthday);
        
        $u_y=date("Y", $mage)-1970;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../dist/css/font.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- datatables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- sweetalert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
    .content-wrapper .content .container-fluid .row .col-4 .into {
        font-weight: bold;
        /* color: white; */
        text-align: center;
        margin-top: 1px;
    }

    label {
        position: relative;
        /* color: #fff; */
        font-size: 19px;
        cursor: pointer;
    }

    label::after {
        position: absolute;
        content: '';
        background: red;
        height: 2px;
        width: 0;
        left: 0;
        bottom: -2px;
        transition: .4s;

    }

    label:hover::after {
        width: 100%;
    }

    .content-wrapper .img_aa {
        display: block;
        margin: auto;
        border-radius: 25px;
    }

    .content-wrapper .top-menu {
        display: flex;
        justify-content: space-around;
    }

    .content-wrapper .top-menu ul li {
        margin-left: 10px;
        text-transform: uppercase;
        list-style: none;
    }

    .content-wrapper .top-menu ul li a {
        color: #fff;
    }

    .update {
        color: #fff;
        font-size: 30px;
        font-weight: 900;
        letter-spacing: 5px;
    }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Main Sidebar Container -->
        <?php include 'aside.php' ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <!-- form -->
                    <form action="sql/customer/update.php" method="post" enctype="multipart/form-data"
                        class="needs-validation">
                        <div class="row p-3">
                            <div class="col-8">
                                <div class="row mb-1">
                                    <div class="form-group col-3">
                                        <label>NUMBER CARD</label> <!-- NUMBER CARD -->
                                        <input type="text" name="m_card" class="form-control"
                                            value="<?= $data[0]['m_card'] ?>">
                                    </div>
                                    <div class="form-group col-3 ">
                                        <label>INVOCE NO.</label>
                                        <input type="text" name="invoice" class="form-control"
                                            value="<?= $data[0]['invoice'] ?>">
                                    </div>

                                    <div class="form-group col mt-4">
                                        <input type="submit" name="update" value=">>> UPDATE <<<"
                                            class="btn btn-danger btn-block update" id="btn_insert">
                                    </div>
                                </div>
                                <!-- MEMBER CARD / PASSPORT NUMBER -->
                                <div class="form-row mb-1">
                                    <div class="form-group col-6">
                                        <label> PICTURES </label>
                                        <input type="file" name="image" class="form-control mb-1" id="imgInput">
                                        <input type="text" name="image2" value="<?= $data[0]['image']?>" hidden>
                                        <input type="text" name="id" value="<?= $data[0]['id']?>" hidden>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>PASSPORT NUMBER</label>
                                        <input type="text" name="p_visa" class="form-control"
                                            value="<?= $data[0]['p_visa'] ?>">
                                    </div>
                                </div>
                                <!-- EMAIL / PHONE NUMBER -->
                                <div class="form-row mb-1">
                                    <div class="form-group col-6">
                                        <label>EMAIL</label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?= $data[0]['email'] ?>">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>PHONE NUMBER</label>
                                        <input type="number" name="phone" class="form-control"
                                            value="<?= $data[0]['phone'] ?>">
                                    </div>
                                </div>
                                <!-- SEX / FULL NAME -->
                                <div class="form-row mb-1">
                                    <div class="form-group col-3 ">
                                        <label for="floatingSelectGrid">SEX</label>
                                        <select name="sex" class="custom-select" id="floatingInput">
                                            <option value="<?= $data[0]['sex'] ?>"><?= $data[0]['sex'] ?></option>
                                            <option value="Male">MALE</option>
                                            <option value="Female">FEMALE</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-3">
                                        <label>FULL NAME</label>
                                        <input type="text" name="fname" class="form-control"
                                            value="<?= $data[0]['fname'] ?>">
                                    </div>
                                    <div class="form-group col">
                                        <label for="age">AGE</label>
                                        <input type="text" name="age" class="form-control" value="<?= $u_y ?>">
                                    </div>
                                    <div class="form-group col-3">
                                        <?php
                                            require_once '../includes/connection.php';
                                            $sql_nationality = $conndb->prepare('SELECT * FROM `tb_nationality` ORDER BY nationality_id');
                                            $sql_nationality->execute();
                                        ?>
                                        <label>NATIONALITY</label>
                                        <select name="nationalty" class="custom-select" required>
                                            <option selected><?= $data[0]['nationalty'] ?></option>
                                            <?php foreach ($sql_nationality as $sql_nationality_row ) : ?>
                                            <option value="<?php echo $sql_nationality_row['n_name']; ?>">
                                                <?php echo $sql_nationality_row['n_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- NATIONALITY BIRTH DAY -->
                                <div class="form-row mb-1">

                                    <div class="form-group col-3">
                                        <label>BIRTH DAY</label>
                                        <input type="date" name="birthday" class="form-control"
                                            value="<?= $data[0]['birthday'] ?>">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Package </label>
                                        <?php if ($data[0]['status_code'] == 2) {
                                                $sqlPackage = $conndb->query("SELECT * FROM `products`");
                                                $sqlPackage->execute(); ?>

                                            <select name="package" class="custom-select">
                                            <?php echo $resultProduct[0]['pid'] ?>
                                                <option selected><?=$data[0]['birthday']?></option>
                                                <?php foreach( $sqlPackage as $sql_package ) : ?>
                                                    <option value="<?= $sql_package['id'] ?>"><?= $sql_package['product_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                          
                                        <?php } else if ($data[0]['status_code'] == 4 ) { 
                                            $sqlProduct = $conndb->query("SELECT m.id , m.package, p.id AS pid , p.product_name 
                                            FROM `member` AS m ,`products` AS p 
                                            WHERE m.package = p.id  AND m.id = '$id' ");
                                            $sqlProduct->execute();
                                            $resultProduct = $sqlProduct->fetchAll() ; ?>

                                                <select name="package" class="custom-select">
                                                <?php echo $resultProduct[0]['pid'] ?>
                                                    <option value="<?= $resultProduct[0]['pid'] ?>"><?= $resultProduct[0]['product_name'] ?></option>

                                                    <?php
                                                        $a = $conndb->query("SELECT * FROM `products`");
                                                        $a->execute();
                                                        foreach( $a as $b ) : ?>
                                                        <option value="<?= $b['id'] ?>"><?= $b['product_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                
                                        <?php } ?>
                                    <input type="hidden" name="new_package" class="form-control">
                                </div>
                                   <?php if($data[0]['package'] == 147 || $data[0]['package'] == '10 Drop in' || $data[0]['package'] == '10 Drop In' ){?>
                                        <div class="form-group col-3">
                                            <label for="dropin"> DROP IN </label>
                                            <input type="text" name="dropin" class="form-control bg-warning"  value="<?= $data[0]['dropin'] ?>">
                                        </div>
                                    <?php } else { ?>
                                        <input type="hidden" name="dropin" value="10">
                                    <?php } ?>
                                </div>

                                <!-- ACCOMMODATION -->
                                <div class="form-row mb-1">
                                    <div class="form-group col-6">
                                        <label>ACCOMMODATION / ADDRESS </label>
                                        <textarea class="form-control" name="accom"
                                            rows="4"><?= $data[0]['accom'] ?></textarea>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>COMMENTS</label>
                                        <textarea class="form-control" name="comment"
                                            rows="4"><?= $data[0]['comment'] ?></textarea>
                                    </div>
                                </div>
                                <!-- START TRAINING / EXPIR TRAINING-->
                                <div class="form-row mb-1">
                                    <div class="form-group col-4">
                                        <label>START TRAINING</label>
                                        <input type="date" name="sta_date" class="form-control"
                                            value="<?= $data[0]['sta_date'] ?>">
                                    </div>
                                    <div class="form-group col-4">
                                        <label>EXPIR TRAINING</label>
                                        <input type="date" name="exp_date" class="form-control"
                                            value="<?= $data[0]['exp_date'] ?>">
                                    </div>
                                    <div class="form-group col-4">
                                        <?php if( $df < 0 ){?>
                                        <label> EXPIRED</label>
                                        <input type="text" name="expired" class="form-control bg-danger"
                                            value="<?= $df ?>">
                                        <?php } else { ?>
                                        <label> EXPIRY IN</label>
                                        <input type="text" name="expired" class="form-control bg-info"
                                            value="<?= $df ?>">
                                        <?php } ?>
                                    </div>

                                </div>

                                <!-- COMMENTS  EMERGENCY NUMBER -->
                                <div class="form-row mb-1">
                                    <div class="form-group col-md-6">
                                        <label>EMERGENCY NUMBER</label>
                                        <input type="text" class="form-control" name="emergency"
                                            value="<?= $data[0]['emergency'] ?>">
                                    </div>
                                    <div class="form-group col-4">
                                        <?php
                                            $sql_pay = $conndb->query("SELECT payment.pay_id , payment.pay_name,  member.payment 
                                            FROM `payment`,`member`
                                            WHERE payment.pay_id = member.payment ");
                                            $sql_pay->execute();
                                            $Fetch = $sql_pay->fetchAll();

                                            $sqlPayment = $conndb->query("SELECT * FROM payment ");
                                            $sqlPayment->execute();
                                               
                                        ?>
                                        <label>PAYMRNT</label>
                                        <select name="payment" class="form-control">
                                            <option value="<?= $Fetch[0]['payment'] ?>"><?= $Fetch[0]['pay_name'] ?></option>
                                            <?php foreach ( $sqlPayment AS $rowPay) :?>
                                                <option value="<?= $rowPay['pay_id'] ?>"><?= $rowPay['pay_name'] ?></option>
                                            <?php endforeach ?>

                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="col-4">
                                <h1 class="into">PICTURES</h1>
                                <div class="form-row">
                                    <div class="form-group">
                                        <img src="<?php echo '../memberimg/img/'.$data[0]['image'] ?> " width="80%"
                                            id="preview" class="img_aa">
                                    </div>
                                </div>
                                <br>
                                <input type="text" name="group" value="customer" hidden>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </div>
            </div>
        </div>

    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>

    <!-- Image -->
    <script>
    let imgInput = document.getElementById('imgInput');
    let preview = document.getElementById('preview');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }
    </script>
    <!-- Image -->

    <!-- error_card -->
    <?php if (isset($_SESSION['error_card'])){?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'อุ๊ปส์...',
        text: 'หมายเลขชุดนี้ ถูกใช้ไปงานแล้ว!',
        footer: ' This number has already been used. '
    })
    </script>
    <?php } unset($_SESSION['error_card']); ?>

    <!-- valid -->
    <?php if (isset($_SESSION['valid'])){?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'อุ๊ปส์...',
        text: 'หมายเลขชุดนี้ ถูกใช้ไปงานแล้ว!',
        footer: ' This number has already been used. '
    })
    </script>
    <?php } unset($_SESSION['valid']); ?>

    <!-- valid -->
    <?php if (isset($_SESSION['invalid'])){?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Good...',
        text: 'หมายเลขนี้ สามารถใช้งานได้!',
    })
    </script>
    <?php } unset($_SESSION['invalid']); ?>


    <?php $conndb = null; ?>
</body>

</html>