<?php 
  session_start();
  include './middleware.php';
  $title = 'NEW MEMBER | TIGER APPLICATION';
  $page = 'newmember';
//   $refresh_interval = 10; // วินาที
?>
<!-- <script>
    setTimeout(function(){
        location.reload();
    }, < $refresh_interval * 1000; ?>);
</script> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.png">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../dist/css/font.css">
    <!-- sweetalert2 -->
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>

    <style>
        .content-wrapper .content .container-fluid .row .col-4 .into {
            font-weight: bold;
            color: #000;
            text-align: center;
            margin-top: 25px;
        }

        label {
            position: relative;
            color: #000;
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

    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

<?php include 'aside.php' ?>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <!-- form -->
                    <form action="./customer/sql.php" method="post" enctype="multipart/form-data" class="needs-validation">
                        <div class="row p-1">
                            <!-- ภาพ -->
                            <div class="col-4">
                                <h1 class="into">PICTURES</h1>
                                    <div class="form-row">
                                        <div id="imgControl" class="d-none mx-auto">
                                            <img id="imgUpload" class="img-fluid my-3" width="100%">
                                        </div>
                                    </div>
                                <br>
                                <input type="submit" name="insert" value="SAVE" class="btn btn-success btn-block" id="btn_insert">
                            </div>

                            <div class="col-8">
                                <div class="card p-2">

                                    <!-- NUMBER CARD -->
                                    <div class="row mb-1">
                                        <div class="form-group col-6">
                                            <label>NUMBER CARD <span id="massage" class="text-center"></span> </label>
                                            <input type="text" name="m_card" id="m_card" class="form-control" value="110" autofocus required>
                                        </div>
                                        <div class="form-group col-6 ">
                                            <label>INVOCE NO.</label>
                                            <input type="text" name="invoice" class="form-control" value="110" required>
                                        </div>
                                    </div>

                                    <!-- PICTURES / PASSPORT NUMBER -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-md-6">
                                            <label> PICTURES </label>
                                            <input type="file" class="form-control" id="file" name="image" onchange="readURL(this)" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>PASSPORT NUMBER</label>
                                            <input type="text" name="p_visa" class="form-control" value="11223344" required>
                                        </div>
                                    </div>

                                    <!-- EMAIL / PHONE NUMBER -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-md-6">
                                            <label>EMAIL</label>
                                            <input type="email" name="email" class="form-control" value="dev@local.com">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>PHONE NUMBER</label>
                                            <input type="number" name="phone" class="form-control" value="12345678910" required>
                                        </div>
                                    </div>

                                    <!-- SEX / FULL NAME -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-md-3 ">
                                            <label>SEX</label>
                                            <select name="sex" class="custom-select" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="floatingFull Name">FULL NAME</label>
                                            <input type="text" name="fname" class="form-control" value="Dev Admin" required>
                                        </div>
                                    </div>

                                    <!-- NATIONALITY -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-4">
                                            <?php
                                                  $sql_nationality = $conndb->prepare('SELECT * FROM `tb_nationality`');
                                                  $sql_nationality->execute();
                                              ?>
                                            <label>NATIONALITY</label>
                                            <select name="nationality" class="custom-select" required>
                                                <option value="" disabled selected>-Cloose-</option>
                                                <?php foreach ($sql_nationality as $sql_nationality_row ) : ?>
                                                <option value="<?= $sql_nationality_row['n_name']; ?>">
                                                    <?= $sql_nationality_row['n_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- BIRTH DAY -->
                                        <div class="form-group col-2">
                                            <label>BIRTH DAY</label>
                                            <input type="date" name="birthday" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>

                                        <!-- products -->
                                        <div class="form-group col">
                                            <?php 
                                                $products = $conndb->prepare("SELECT * FROM `products` ORDER BY id");
                                                $products->execute();
                                            ?>
                                            <label>PACKAGE</label>
                                            <select name="package" class="custom-select" required>
                                                <option value="" disabled selected>-Cloose-</option>
                                                    <?php foreach ($products as $product ) : ?>
                                                <option value="<?= $product['id']?>"><?= $product['product_name'];?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- payments -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-6">
                                             <?php 
                                                $payments = $conndb->query("SELECT * FROM payment ");
                                                $payments->execute();
                                             ?> 
                                            <label>PAYMRNT</label>
                                            <select name="payment" class="form-control" required>
                                                <option value="" disabled selected="">-Cloose-</option>
                                                <?php  foreach ($payments AS $payment) : ?> 
                                                    <option value="<?= $payment['pay_id'] ?>"><?= $payment['pay_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>EMERGENCY NUMBER</label>
                                            <input type="text" class="form-control" name="emergency"placeholder="Emergency Contact Number">
                                        </div>
                                    </div>

                                    <!-- ACCOMMODATION -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-6">
                                            <label>ACCOMMODATION / ADDRESS </label>
                                            <textarea class="form-control" name="accom" placeholder="ADDRESS"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>COMMENTS</label>
                                            <textarea class="form-control" name="comment"placeholder="comment here"></textarea>
                                        </div>
                                    </div>
                                   
                                    <!-- START TRAINING / EXPIR TRAINING-->
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-1">
                                            <label>START TRAINING</label>
                                            <input type="date" name="sta_date" class="form-control"  value="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-1">
                                            <label>EXPIR TRAINING</label>
                                            <input type="date" name="exp_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </div>
            </div>
        </div>

    </div>

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

    <script>
        function readURL(input) {
            if (input.files[0]) {
                let reader = new FileReader();
                document.querySelector('#imgControl').classList.replace("d-none", "d-block");
                reader.onload = function(e) {
                    let element = document.querySelector('#imgUpload');
                    element.setAttribute("src", e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        // ค้นหาข้อมูลบัตร
        $('#m_card').keyup(function() {
            console.log($(this).val());
            var m_card = $(this).val();
            if (m_card == "") {
                $(this).addClass('border-danger');
                $("#massage").html("Please Enter Number");
                $("#massage").addClass("text-danger , text-size:25px");
                $("#btn_insert").attr("disabled", true);
            } else {
                $.ajax({
                    method: 'post',
                    url: 'CheckCard.php',
                    data: {
                        data: m_card
                    },
                    success: function(data) {
                        if (data == 1) {
                            $("#m_card").addClass('border-danger');
                            $("#massage").html("Can't use number");
                            $("#massage").addClass("text-danger");
                            $("#btn_insert").attr("disabled", true);

                            $("#m_card").removeClass("border-success");
                            $("#massage").removeClass("text-success");
                        } else {
                            $("#m_card").addClass('border-success');
                            $("#massage").html("Can use this number");
                            $("#massage").addClass("text-success");
                            $("#btn_insert").attr("disabled", false);

                            $("#m_card").removeClass("border-danger");
                            $("#massage").removeClass("text-danger");
                        }
                    }
                });
            }
        });
    </script>

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