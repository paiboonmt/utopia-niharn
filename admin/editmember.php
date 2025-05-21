<?php
    include './middleware.php';
    $title = 'NEW MEMBER | TIGER APPLICATION';
    $page = 'newmember';
    include('../includes/connection.php');
    include('./customer/edit.php');
    $data = getData($conndb, $_GET['id']);
    $m_card = $data['m_card'];
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
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        .preview img {
            max-width: 100%;
            margin: 10px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-3 mt-2">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid" src="<?= '../memberimg/img/' . $data['image'] ?>">
                                    </div>
                                  
                                </div>

                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                        </div>
                        
                        <!-- /.col -->
                        <div class="col-md-9 mt-2">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="active nav-link" href="#profile" data-toggle="tab">ประวัติลูกค้า</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#edit" data-toggle="tab">แก้ไขประวัติ</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#document" data-toggle="tab">เอกสาร</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#product_history" data-toggle="tab">ประวัติการซื้อสินค้า</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">ประวัติการเช็คอิน</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">

                                        <div class="active tab-pane" id="profile">
                                            <!-- หมายเลขบัตรสมาชิก , หมายเลข วีซ่า  -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col">
                                                    <label>หมายเลขบัตรสมาชิก</label>
                                                    <input type="text" class="form-control" value="<?= $data['m_card'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>หมายเลข วีซ่า </label>
                                                    <input type="text" class="form-control" value="<?= $data['p_visa'] ?>" readonly>
                                                </div>
                                            </div>
                                            <!-- อีเมล , หมายเลขโทรศัพท์ -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col">
                                                    <label>อีเมล</label>
                                                    <input type="email" class="form-control" value="<?= $data['email'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>หมายเลขโทรศัพท์</label>
                                                    <input type="number" class="form-control" value="<?= $data['phone'] ?>" readonly>
                                                </div>
                                            </div>
                                            <!-- เพศ , ชื่อ นามสกุล ,  -->
                                            <div class="form-row mb-1">
                                                <div class="form-group">
                                                    <label>เพศ</label>
                                                    <input type="text" class="form-control" value="<?= $data['sex'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label for="floatingFull Name">ชื่อ นามสกุล</label>
                                                    <input type="text" class="form-control" value="<?= $data['fname'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>สัญชาติ</label>
                                                    <input type="text" class="form-control" value="<?= $data['nationality'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>วันเกิด</label>
                                                    <input type="date" class="form-control" value="<?= $data['birthday'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>อายุ</label>
                                                    <input type="number" class="form-control" value="<?= birthDay($data['birthday']) ?>" readonly>
                                                </div>
                                            </div>
                                            <!-- วิธีการชำระ , สินค้า  -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-4">
                                                    <label>วิธีการชำระ</label>
                                                    <input type="text" class="form-control" value="<?= $data['payment'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>สินค้า</label>
                                                    <input type="text" class="form-control" value="<?= $data['product_name'] ?>" readonly>
                                                </div>
                                                <div class="col">
                                                    <label>จำวนวนครั้ง</label>
                                                    <input type="text" class="form-control" value="<?= $data['product_value'] ?>" readonly>
                                                </div>
                                            </div>

                                            <!-- วิธีการชำระ , หมายเลขฉุกเฉิน -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col">
                                                    <label>หมายเลขฉุกเฉิน</label>
                                                    <input type="text" class="form-control" value="<?= $data['emergency'] ?>" readonly>
                                                </div>
                                                <div class="form-group col">
                                                    <label>ผู้ทำรายการ</label>
                                                    <input type="text" class="form-control" value="<?= $data['user'] ?>" readonly>
                                                </div>
                                            </div>

                                            <!-- สถานที่พัก ที่อยู่ , หมายเหตุ -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-6">
                                                    <label>สถานที่พัก ที่อยู่</label>
                                                    <textarea class="form-control" readonly><?= $data['accom'] ?></textarea>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control" readonly><?= $data['comment'] ?></textarea>
                                                </div>
                                            </div>

                                            <!-- วันที่เริ่ม เทรน , วันที่หมดอายุ  -->
                                            <div class="form-row">
                                                <div class="form-group col-4 mb-2">
                                                    <label>วันที่เริ่ม เทรน</label>
                                                    <input type="date" class="form-control" value="<?= $data['sta_date'] ?>" readonly>
                                                </div>
                                                <div class="form-group col-4 mb-2">
                                                    <label>วันที่หมดอายุ</label>
                                                    <input type="date" class="form-control" value="<?= $data['exp_date'] ?>" readonly>
                                                </div>
                                                <div class="form-group col-4 mb-2">
                                                    <label>จำนวนวัน</label>
                                                    <?php
                                                    if (datediff($data['sta_date'], $data['exp_date']) < 3) { ?>
                                                        <input type="text" class="form-control bg-danger" value="<?= datediff($data['sta_date'], $data['exp_date']) ?>" readonly>
                                                    <?php } else { ?>
                                                        <input type="text" class="form-control bg-success" value="<?= datediff($data['sta_date'], $data['exp_date']) ?>" readonly>
                                                    <?php } ?>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="product_history">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่</th>
                                                        <th>สินค้า</th>
                                                        <th>วันที่เริ่ม</th>
                                                        <th>วันที่หมดอายุ</th>
                                                        <th>ผู้ทำรายการ</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $history = getHistory($conndb, $m_card) ?>
                                                    <?php foreach ($history as $row) : ?>
                                                        <tr>
                                                            <td><?= $row['timestamp'] ?></td>
                                                            <td><?= $row['product_name'] ?></td>
                                                            <td><?= $row['sta_date'] ?></td>
                                                            <td><?= $row['exp_date'] ?></td>
                                                            <td><?= $row['user'] ?></td>
                                                            <td>
                                                                <a href="./customer/sql.php?id=<?= $row['id'] ?>&&action=deleteProduct&&member_id=<?= $data['id'] ?>"
                                                                    class="btn btn-danger"
                                                                    onclick="return confirm('แน่ใจแล้วหรือที่จะลบ');">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="document">
                                            <h5>Upload a Document</h5>
                                            <form action="./customer/sql.php" method="POST" enctype="multipart/form-data">
                                                <input type="file" class="form-control" name="documents[]" id="documents" multiple required accept="image/*">
                                                <p id="fileCount">No files selected</p>
                                                <div class="preview" id="preview"></div>
                                                <input type="text" name="uploadFiles" hidden>
                                                <input type="text" name="id" value="<?= $data['id'] ?>" hidden>
                                                <input type="text" name="m_card" value="<?= $m_card ?>" hidden>
                                                <button type="submit" class="btn btn-success form-control">Upload</button>
                                            </form>
                                            <hr>
                                            <table class="table table-sm table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่</th>
                                                        <th>ไอดี</th>
                                                        <th>รูปภาพ</th>
                                                        <th>ชื่อรูปภาพ</th>
                                                        <th>ผู้ทำรายการ</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $documents = $conndb->query("SELECT * FROM `tb_files` WHERE `m_card` LIKE '$m_card'")->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($documents as $row) : ?>
                                                        <tr>
                                                            <td><?= $row['created_at'] ?></td>
                                                            <td><?= $row['id'] ?></td>
                                                            <td>
                                                                <a href="#" data-fancybox="gallery" data-src="<?= '../memberimg/file/' . $row['image_name'] ?>"><img src="<?= '../memberimg/file/' . $row['image_name'] ?>" style="width: 50px; height: 50px;" /></a>

                                                            </td>
                                                            <td><?= $row['image_name'] ?></td>
                                                            <td><?= $row['user'] ?></td>
                                                            <td>
                                                                <a href="./customer/sql.php?id=<?= $row['id'] ?>&action=delete&&member_id=<?= $data['id'] ?>&m_card=<?= $m_card ?>"
                                                                    class="btn btn-danger"
                                                                    onclick="return confirm('แน่ใจแล้วหรือที่จะลบ');">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane" id="edit">

                                            <form action="./customer/sql.php" method="POST" enctype="multipart/form-data">

                                                <input type="text" name="updateProfile" hidden>
                                                <input type="text" name="id" value="<?= $data['id'] ?>" hidden>
                                                <input type="text" name="image" value="<?= $data['image'] ?>" hidden>

                                                <!-- หมายเลขบัตรสมาชิก , หมายเลข วีซ่า  -->
                                                <div class="form-row mb-1">
                                                    <div class="for-group col-6">
                                                        <label>หมายเลขบัตรสมาชิก</label>
                                                        <input type="text" name="m_card" class="form-control" value="<?= $data['m_card'] ?>" readonly>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label>หมายเลข วีซ่า</label>
                                                        <input type="text" name="p_visa" class="form-control" value="<?= $data['p_visa'] ?>" required>
                                                    </div>
                                                </div>

                                                <!-- อีเมล , หมายเลขโทรศัพท์ -->
                                                <div class="form-row mb-1">
                                                    <div class="form-group col">
                                                        <label>อีเมล</label>
                                                        <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
                                                    </div>
                                                    <div class="form-group col">
                                                        <label>หมายเลขโทรศัพท์</label>
                                                        <input type="number" name="phone" class="form-control" value="<?= $data['phone'] ?>" required>
                                                    </div>
                                                </div>

                                                <!-- เพศ , ชื่อ นามสกุล -->
                                                <div class="form-row mb-1">
                                                    <div class="form-group col-2">
                                                        <label>เพศ</label>
                                                        <select name="sex" class="custom-select" required>
                                                            <?php if ($data['sex'] !== 'Male') : ?>
                                                                <option value="Male">Male</option>
                                                            <?php endif; ?>
                                                            <?php if ($data['sex'] !== 'Female') : ?>
                                                                <option value="Female">Female</option>
                                                            <?php endif; ?>
                                                            <option value="<?= $data['sex'] ?>" selected><?= $data['sex'] ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                        <label for="floatingFull Name">ชื่อ นามสกุล</label>
                                                        <input type="text" name="fname" class="form-control" value="<?= $data['fname'] ?>" required>
                                                    </div>

                                                    <div class="form-group col-3">
                                                        <?php $dataNationality = getNationality($conndb) ?>
                                                        <label>สัญชาติ</label>
                                                        <select name="nationality" class="custom-select" required>
                                                            <option value="<?= $data['nationality'] ?>" selected><?= $data['nationality'] ?></option>
                                                            <?php foreach ($dataNationality as $nationality) : ?>
                                                                <option value="<?= $nationality['n_name'] ?>"><?= $nationality['n_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-2">
                                                        <label>วันเกิด</label>
                                                        <input type="date" name="birthday" class="form-control" value="<?= $data['birthday'] ?>">
                                                    </div>

                                                    <div class="form-group col">
                                                        <label>อายุ</label>
                                                        <input type="number" name="age" class="form-control" value="<?= birthDay($data['birthday']) ?>">
                                                    </div>

                                                </div>

                                                <!-- วิธีการชำระ , สินค้า  -->
                                                <div class="form-row mb-1">
                                                    <div class="form-group col-4">
                                                        <?php $payments = getPayment($conndb) ?>
                                                        <label>วิธีการชำระ</label>
                                                        <select name="payment" class="form-control" required>
                                                            <option value="<?= $data['payment'] ?>" selected><?= $data['payment'] ?></option>
                                                            <?php foreach ($payments as $payment) : ?>
                                                                <option value="<?= $payment['pay_id'] ?>|<?= $payment['pay_name'] ?>"><?= $payment['pay_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col">
                                                        <?php $products = getProduct($conndb) ?>
                                                        <label>สินค้า</label>
                                                        <select name="package" class="custom-select" required>
                                                            <option value="<?= $data['product_name'] ?>" selected><?= $data['product_name'] ?></option>
                                                            <?php foreach ($products as $product) : ?>
                                                                <option value="<?= $product['value'] ?>|<?= $product['product_name'] ?>|<?= $product['product_type'] ?>"><?= $product['product_name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col">
                                                        <div class="col">
                                                            <label>จำนวนครั้ง</label>
                                                            <input type="text" name="product_value" class="form-control" value="<?= $data['product_value'] ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- วิธีการชำระ , หมายเลขฉุกเฉิน -->
                                                <div class="form-row mb-1">

                                                    <div class="form-group col-6">
                                                        <label>หมายเลขฉุกเฉิน</label>
                                                        <input type="text" class="form-control" name="emergency" value="<?= $data['emergency'] ?>">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label>ผู้ทำรายการ</label>
                                                        <input type="text" class="form-control" name="create_by" value="<?= $data['user'] ?>" readonly>
                                                    </div>

                                                </div>

                                                <!-- สถานที่พัก ที่อยู่ , หมายเหตุ -->
                                                <div class="form-row mb-1">
                                                    <div class="form-group col-6">
                                                        <label>สถานที่พัก ที่อยู่</label>
                                                        <textarea class="form-control" name="accom"><?= $data['accom'] ?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>หมายเหตุ</label>
                                                        <textarea class="form-control" name="comment"><?= $data['comment'] ?></textarea>
                                                    </div>
                                                </div>

                                                <!-- วันที่เริ่ม เทรน , วันที่หมดอายุ , ผู้ทำรายการ -->
                                                <div class="form-row">
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>วันที่เริ่ม เทรน</label>
                                                        <input type="date" name="sta_date" class="form-control" value="<?= $data['sta_date'] ?>">
                                                    </div>
                                                    <div class="form-group col-md-6 mb-2">
                                                        <label>วันที่หมดอายุ</label>
                                                        <input type="date" name="exp_date" class="form-control" value="<?= $data['exp_date'] ?>">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <button type="submit" class="btn btn-success col">บันทึก</button>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="tab-pane" id="timeline">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
</body>

</html>
<?php $conndb = null; ?>

<script>

    // Customization example
    Fancybox.bind('[data-fancybox="gallery"]', {
        infinite: false
    });

    // File upload preview
    const input = document.getElementById('documents');
    const preview = document.getElementById('preview');
    const fileCount = document.getElementById('fileCount');

    input.addEventListener('change', function() {
        preview.innerHTML = ''; // clear preview
        const files = input.files;

        fileCount.textContent = `${files.length} file(s) selected`;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // show only image preview
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>