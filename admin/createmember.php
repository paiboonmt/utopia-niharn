<?php
include './middleware.php';
$title = 'NEW MEMBER | TIGER APPLICATION';
$page = 'newmember';
include '../includes/connection.php';
?>

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
                    <form action="./customer/sql.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row p-1">
                            <!-- ภาพ -->
                            <div class="col-4">
                                <h1 class="into">ภาพ</h1>
                                <div class="card p-1">
                                    <div id="imgControl" class="d-none mx-auto">
                                        <img id="imgUpload" class="img-fluid" width="100%">
                                    </div>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="card p-2">

                                    <h3 class="into">ข้อมูลสมาชิก</h3>
                                    <hr>
                                    <!-- MEMBER CARD NUMBER / INVOICE NUMBER -->
                                    <div class="row mb-1">
                                        <div class="form-group col-6">
                                            <label>หมายเลขสมาชิก<span id="massage" class="text-center"></span> </label>
                                            <input type="number" name="m_card" id="m_card" class="form-control" autofocus required>
                                            <div class="valid-feedback">
                                                Member card number is valid!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid member card number.
                                            </div>
                                        </div>
                                        <div class="form-group col-6 ">
                                            <label>หมายเลขบิล</label>
                                            <input type="text" name="invoice" class="form-control" value="110" required>
                                            <div class="valid-feedback">
                                                invoice number looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid invoice number.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PICTURES / PASSPORT NUMBER -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-6">
                                            <label> ภาพ </label>
                                            <input type="file" class="form-control" id="file" name="image" onchange="readURL(this)" required>
                                            <div class="valid-feedback">
                                                Image uploaded successfully!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please upload a valid image file.
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>หมายเลขบัตรประชาชน พาสปอร์ต</label>
                                            <input type="text" name="p_visa" class="form-control" value="11223344" required>
                                        </div>
                                    </div>

                                    <!-- EMAIL / PHONE NUMBER -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-6">
                                            <label>อีเมล</label>
                                            <input type="email" name="email" class="form-control" value="dev@local.com">
                                            <div class="valid-feedback">
                                                Email looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid email address.
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>หมายเลขโทรศัพท์</label>
                                            <input type="number" name="phone" class="form-control" value="12345678910" required>
                                            <div class="valid-feedback">
                                                Phone number looks good!
                                            </div>
                                            <div class="invalid-feedback">
                                                Please provide a valid phone number.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SEX / FULL NAME -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-md-3 ">
                                            <label>เพศ</label>
                                            <select name="sex" class="custom-select" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="floatingFull Name">ชื่อลูกค้า</label>
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
                                            <label>สัญชาต</label>
                                            <select name="nationality" class="custom-select" required>
                                                <option value="" disabled selected>-Cloose-</option>
                                                <?php foreach ($sql_nationality as $sql_nationality_row) : ?>
                                                    <option value="<?= $sql_nationality_row['n_name']; ?>">
                                                        <?= $sql_nationality_row['n_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- BIRTH DAY -->
                                        <div class="form-group col-2">
                                            <label>วันเกิด</label>
                                            <input type="date" name="birthday" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>

                                        <!-- products -->
                                        <div class="form-group col">
                                            <?php
                                            $products = $conndb->prepare("SELECT * FROM `products` ORDER BY id");
                                            $products->execute();
                                            ?>
                                            <label>สินค้า</label>
                                            <select name="package" class="custom-select" required>
                                                <option value="" disabled selected>-Cloose-</option>
                                                <?php foreach ($products as $product) : ?>
                                                    <option value="<?= $product['value'] ?>|<?= $product['product_name']; ?>|<?= $product['product_type']; ?>"><?= $product['product_name']; ?></option>
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
                                            <label>วิธีการชำระ</label>
                                            <select name="payment" class="form-control" required>
                                                <option value="" disabled selected="">-Cloose-</option>
                                                <?php foreach ($payments as $payment) : ?>
                                                    <option value="<?= $payment['pay_id'] ?>|<?= $payment['pay_name'] ?>"><?= $payment['pay_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>เบอร์โทรฉุกเฉิน</label>
                                            <input type="text" class="form-control" name="emergency" value="1169">
                                        </div>
                                    </div>

                                    <!-- ACCOMMODATION -->
                                    <div class="form-row mb-1">
                                        <div class="form-group col-6">
                                            <label>ที่อยู่ ที่พัก</label>
                                            <textarea class="form-control" name="accom">Phuket Thailand</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>บันทึกข้อมูลอื่นๆ</label>
                                            <textarea class="form-control" name="comment">Dev Test System</textarea>
                                        </div>
                                    </div>

                                    <!-- START TRAINING / EXPIR TRAINING-->
                                    <div class="form-row">
                                        <div class="form-group col-md-6 mb-1">
                                            <label>เริ่มใช้งาน</label>
                                            <input type="date" name="sta_date" class="form-control" value="<?= date('Y-m-d') ?>">
                                        </div>
                                        <div class="form-group col-md-6 mb-1">
                                            <label>หมดอายุการใช้งาน</label>
                                            <input type="date" name="exp_date" class="form-control" value="<?= date('Y-m-d', strtotime('+10 days')) ?>">
                                        </div>
                                    </div>

                                </div>
                                <input type="submit" name="insert" value="บันทึกข้อมูล" class="btn btn-success btn-block" id="btn_insert">
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



        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <!-- error_card -->
    <?php if (isset($_SESSION['error_card'])) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'อุ๊ปส์...',
                text: 'หมายเลขชุดนี้ ถูกใช้ไปงานแล้ว!',
                footer: ' This number has already been used. '
            })
        </script>
    <?php }
    unset($_SESSION['error_card']); ?>

    <!-- valid -->
    <?php if (isset($_SESSION['valid'])) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'อุ๊ปส์...',
                text: 'หมายเลขชุดนี้ ถูกใช้ไปงานแล้ว!',
                footer: ' This number has already been used. '
            })
        </script>
    <?php }
    unset($_SESSION['valid']); ?>

    <!-- valid -->
    <?php if (isset($_SESSION['invalid'])) { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Good...',
                text: 'หมายเลขนี้ สามารถใช้งานได้!',
            })
        </script>
    <?php }
    unset($_SESSION['invalid']); ?>

    <?php $conndb = null; ?>

</body>

</html>