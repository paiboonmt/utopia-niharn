<?php
    session_start();
    include './middleware.php';
    $title = 'SPONSOR FIGHTER | TIGER APPLICATION';
    $page = 'sponsor';

if (isset($_GET['id'])) {
    require_once '../includes/connection.php';
    $id = $_GET['id'];
    $sql_data = $conndb->prepare("SELECT * FROM `member` WHERE id = :TT");
    $sql_data->bindParam(":TT", $id);
    $sql_data->execute();
    $result = $sql_data->fetchAll();


    // อายุบัตรสมาชิก
    $exp_date = $result[0]['exp_date'];
    function datediff($str_start, $str_end) {
        $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
        $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
        $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
        return $ndays;
    }
    $today = date('Y-m-d');
    $df = datediff($today, $exp_date);

    // อายุ
    $birthday = $result[0]['birthday'];
    $today = date('Y-m-d');
    list($byear, $bmonth, $bday) = explode("-", $birthday);       //จุดต้องเปลี่ยน
    list($tyear, $tmonth, $tday) = explode("-", $today);                //จุดต้องเปลี่ยน

    $mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear);
    $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
    $mage = ($mnow - $mbirthday);

    $u_y = date("Y", $mage) - 1970;

    $status = 'Expiry';

    $sql_file = "SELECT * FROM `tb_files` WHERE product_id = $id ";
    $f_result = $conndb->query($sql_file);
    $f_result->execute();
    $fet_file = $f_result->fetchAll();
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
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'aside.php' ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php include 'pages.php' ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="../plugins/fancybox/fancybox.umd.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        // Customization example
        Fancybox.bind('[data-fancybox="gallery"]', {
            infinite: false
        });
    </script>

    <?php $conndb = null; ?>

</body>

</html>