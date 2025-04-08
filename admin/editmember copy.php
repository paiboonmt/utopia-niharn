<?php
session_start();
include './middleware.php';
$title = 'NEW MEMBER | TIGER APPLICATION';
$page = 'newmember';
include('../includes/connection.php');
include('./customer/edit.php');
$data = getData($conndb, $_GET['id']);
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
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="<?= '../memberimg/img/' . $data['image'] ?>">
                                    </div>
                                    <h3 class="profile-username text-center"><?= $data['fname'] ?></h3>
                                    <a href="#" class="btn btn-primary btn-block"><b>ประวัติลูกค้า</b></a>
                                </div>

                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">About</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-book mr-1"></i> หมายเลขบัตรสมาชิก</strong>

                                    <p class="text-muted">
                                        Member number | <?= $data['m_card'] ?>
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location | Nationality</strong>

                                    <p class="text-muted">
                                        <?= $data['nationality'] ?>
                                    </p>

                                    <hr>

                                    <strong><i class="fas fa-pencil-alt mr-1"></i> หมายเลข invoice</strong>

                                    <p class="text-muted">
                                        Invoice number | <?= $data['invoice'] ?>
                                    </p>

                                    <hr>

                                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                                    <p class="text-muted">
                                        <?= $data['comment'] ?>
                                    </p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9 mt-2">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">ประวัติลูกค้า</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div class="form-row mb-1">
                                                <div class="form-group col-md-12">
                                                    <label>หมายเลข วีซ่า </label>
                                                    <input type="text" name="p_visa" class="form-control" value="<?= $data['p_visa'] ?>" required>
                                                </div>
                                            </div>

                                            <!-- EMAIL / PHONE NUMBER -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-md-6">
                                                    <label>อีเมล</label>
                                                    <input type="email" name="email" class="form-control" value="<?= $data['email'] ?>">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>หมายเลขโทรศัพท์</label>
                                                    <input type="number" name="phone" class="form-control" value="<?= $data['phone'] ?>" required>
                                                </div>
                                            </div>

                                            <!-- SEX / FULL NAME -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-md-3 ">
                                                    <label>เพศ</label>
                                                    <select name="sex" class="custom-select" required>
                                                        <option value="<?= $data['sex'] ?>" selected><?= $data['sex'] ?></option>
                                                        <!-- <option value="Male">ชาย</option>
                                                        <option value="Female">หญิง</option> -->
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-9">
                                                    <label for="floatingFull Name">FULL NAME</label>
                                                    <input type="text" name="fname" class="form-control" value="<?= $data['fname'] ?>" required>
                                                </div>
                                            </div>

                                            <!-- สัญชาติ  -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-4">
                                                    <?php $dataNationality = getNationality($conndb) ?>
                                                    <label>สัญชาติ</label>
                                                    <select name="nationality" class="custom-select" required>
                                                        <option value="<?= $data['nationality'] ?>" selected><?= $data['nationality'] ?></option>
                                                        <?php foreach ($dataNationality as $ss) : ?>
                                                            <option value="<?= $ss['n_name']; ?>"><?= $ss['n_name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- วันเกิด -->
                                                <div class="form-group col-2">
                                                    <label>วันเกิด</label>
                                                    <input type="date" name="birthday" class="form-control" value="<?= $data['birthday'] ?>">
                                                </div>

                                                <!-- สินค้า -->
                                                <div class="form-group col">
                                                    <?php $products = getProduct($conndb) ?>
                                                    <label>สินค้า</label>
                                                    <select name="package" class="custom-select" required>
                                                        <option value="<?= $data['package'] ?>" selected><?= $data['package'] ?></option>
                                                        <?php foreach ($products as $product) : ?>
                                                            <option value="<?= $product['product_name'] ?>"><?= $product['product_name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- วิธีการชำระ , หมายเลขฉุกเฉิน -->
                                            <div class="form-row mb-1">
                                                <div class="form-group col-6">
                                                    <?php $payments = getPayment($conndb) ?>
                                                    <label>วิธีการชำระ</label>
                                                    <select name="payment" class="form-control" required>
                                                        <option value="<?= $data['payment'] ?>" selected><?= $data['payment'] ?></option>
                                                        <?php foreach ($payments as $payment) : ?>
                                                            <option value="<?= $payment['pay_name'] ?>"><?= $payment['pay_name'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>หมายเลขฉุกเฉิน</label>
                                                    <input type="text" class="form-control" name="emergency" value="<?= $data['emergency'] ?>">
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
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>ผู้ทำรายการ</label>
                                                    <input type="text" class="form-control" name="create_by" value="<?= $data['user'] ?>" readonly>
                                                </div>
                                            </div>




                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="timeline">
                                            <!-- The timeline -->
                                            <div class="timeline timeline-inverse">
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-danger">
                                                        10 Feb. 2014
                                                    </span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-envelope bg-primary"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                                        <div class="timeline-body">
                                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                            quora plaxo ideeli hulu weebly balihoo...
                                                        </div>
                                                        <div class="timeline-footer">
                                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-user bg-info"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                                        </h3>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-comments bg-warning"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                                        <div class="timeline-body">
                                                            Take me to your leader!
                                                            Switzerland is small and neutral!
                                                            We are more like Germany, ambitious and misunderstood!
                                                        </div>
                                                        <div class="timeline-footer">
                                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                <!-- timeline time label -->
                                                <div class="time-label">
                                                    <span class="bg-success">
                                                        3 Jan. 2014
                                                    </span>
                                                </div>
                                                <!-- /.timeline-label -->
                                                <!-- timeline item -->
                                                <div>
                                                    <i class="fas fa-camera bg-purple"></i>

                                                    <div class="timeline-item">
                                                        <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                                                        <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                                                        <div class="timeline-body">
                                                            <img src="https://placehold.it/150x100" alt="...">
                                                            <img src="https://placehold.it/150x100" alt="...">
                                                            <img src="https://placehold.it/150x100" alt="...">
                                                            <img src="https://placehold.it/150x100" alt="...">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->
                                                <div>
                                                    <i class="far fa-clock bg-gray"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="settings">
                                            <form class="form-horizontal">
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>
<?php $conndb = null; ?>