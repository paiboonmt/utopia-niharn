<?php
  session_start();
  $title = 'SALE | TIGER APPLICATION';
  include './middleware.php';
  $page = 'sale';
  $code = round(microtime(true));
  date_default_timezone_set('Asia/Bangkok');

  unset($_SESSION['package']);
  unset($_SESSION['m_card']);
  unset($_SESSION['sta_date']);
  unset($_SESSION['exp_date']);
  unset($_SESSION['fname']);
  unset($_SESSION['comment']);
  unset($_SESSION['price']);
  unset($_SESSION['vat']);
  unset($_SESSION['pay']);
  unset($_SESSION['discount']);
  unset($_SESSION['vat7']);
  unset($_SESSION['vat3']);
  unset($_SESSION['code']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../dist/css/fancyapps.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- datatables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <style>
        .btn {
            width: 100%;
            text-align: left;
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

                        <div class="col-md-7 mt-2">
                            <div class="card p-2 ">
                                <table class="table table-sm table-hover" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Price | Weekly</th>
                                            <th>Action | Monthly</th>
                                            <th>3 Monthly</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <!-- Damage Chage -->
                                        <tr>
                                            <td>Damage Chage</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Damage Chage">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" name="code" value="0" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>
                                        <!-- Damage Chage -->

                                        <!-- Student Visa -->
                                        <tr>
                                            <td>Student Visa</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Student Visa">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" name="code" value="0" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>
                                        <!-- Student Visa -->

                                        <tr>
                                            <td>Item Test</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Item test">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="999">
                                                    <input type="submit" name="action" class="btn btn-danger" value="TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Daypass -->
                                        <tr>
                                            <td>Daypass</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Day Pass (drop-ins only)">
                                                    <input type="text" hidden name="price" value="1000">
                                                    <input type="text" hidden name="code" value="100">
                                                    <input type="text" name="code" value="100" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 1,000 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Dropin -->
                                        <tr>
                                            <td>Dropin</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Dropin">
                                                    <input type="text" hidden name="price" value="500">
                                                    <input type="text" hidden name="code" value="101">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 500 THB"> 
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Private -->
                                        <tr>
                                            <td>Private</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Private">
                                                    <input type="text" hidden name="price" value="700">
                                                    <input type="text" hidden name="code" value="102">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 700 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Private Nazee -->
                                        <tr>
                                            <td>Private Nazee</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Private Nazee">
                                                    <input type="text" hidden name="price" value="1000">
                                                    <input type="text" hidden name="code" value="103">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 1,000 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>
                                        
                                        <!-- MuayThai 10 Hours -->
                                        <tr>
                                            <td>MuayThai 10 Hours</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="MuayThai 10 Hours">
                                                    <input type="text" hidden name="price" value="6500">
                                                    <input type="text" hidden name="code" value="104">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 6,500 THB">
                                                </form>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>

                                        <!-- Western Boxing (Thai) -->
                                        <tr>
                                            <td>Western Boxing (Thai)</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Western Boxing (Thai)">
                                                    <input type="text" hidden name="price" value="700">
                                                    <input type="text" hidden name="code" value="105">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Muay Boran / Krabi Krabong -->
                                        <tr>
                                            <td>Muay Boran / Krabi Krabong</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Muay Boran / Krabi Krabong">
                                                    <input type="text" hidden name="price" value="2000">
                                                    <input type="text" hidden name="code" value="106">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- mma coach -->
                                        <tr>
                                            <td>MMA Coach </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="MMA Coach">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="107">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- BJJ Coach -->
                                        <tr>
                                            <td>BJJ Coach</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="BJJ Coach">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="108">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Western Boxing -->
                                        <tr>
                                            <td>Western Boxing</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Western Boxing">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="109">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Kick Boxing Coach -->
                                        <tr>
                                            <td>Kick Boxing Coach</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Kick Boxing Coach">
                                                    <input type="text" hidden name="price">
                                                    <input type="text" hidden name="code" value="110">
                                                    <input type="submit" name="action"class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Head Fitness Coach JAY -->
                                        <tr>
                                            <td>Head Fitness Coach JAY</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Head Fitness , Coach `JAY`">
                                                    <input type="text" hidden name="price" value="3000">
                                                    <input type="text" hidden name="code" value="111">
                                                    <input type="submit" name="action"class="btn btn-success" value="TICKET 3,000 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Fitness Coach -->
                                        <tr>
                                            <td>Fitness Coach</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Fitness Coach">
                                                    <input type="text" hidden name="price">
                                                    <input type="text" hidden name="code" value="112">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Coach Peter "The Hulk" -->
                                        <tr>
                                            <td>Coach Peter "The Hulk"</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"
                                                        value="Coach Peter `The Hulk` Weightlifting">
                                                    <input type="text" hidden name="price" value="1200">
                                                    <input type="text" hidden name="code" value="113">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 1,200 THB">
                                                </form>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>

                                        <!-- TMT CARD -->
                                        <tr>
                                            <td>TMT CARD</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="TMT CARD">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="114">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Rent Gear -->
                                        <tr>
                                            <td>Rent Gear</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Rent Gear">
                                                    <input type="text" hidden name="price" value="100">
                                                    <input type="text" hidden name="code" value="115">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 100 THB">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Use fitness area -->
                                        <tr>
                                            <td>Use fitness area</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Use Fitness Area">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="116">
                                                    <input type="submit" name="action"class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center"></td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Gear product -->
                                        <tr>
                                            <td>Gear product</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Gear product">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="117">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Taxi -->
                                        <tr>
                                            <td>Taxi</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Taxi">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="118">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 0">
                                                </form>
                                            </td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>

                                        <!-- BBQ Beatdown -->
                                        <tr>
                                            <td>BBQ Beatdown</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="BBQ Beatdown">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="119">
                                                    <input type="submit" name="action" class="btn btn-success btn-btn" value="TICKET 0">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Upgrade Training -->
                                        <tr>
                                            <td>Upgrade Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Upgrade Training">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="120">
                                                    <input type="submit" name="action" class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td>0</td>
                                            <td>-</td>
                                        </tr>

                                        <!-- Upgrade Accom -->
                                        <tr>
                                            <td>Upgrade Accom</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Upgrade Accom">
                                                    <input type="text" hidden name="price" value="0">
                                                    <input type="text" hidden name="code" value="121">
                                                    <input type="submit" name="action"class="btn btn-success" value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- limited deal Allinclusive training 20% -->
                                        <tr>
                                            <td>limited deal Allinclusive training 20%</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="limited deal Allinclusive training 20% ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="9200">
                                                    <input type="text" hidden name="code" value="200">
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 9,200 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="limited deal Allinclusive training 20% ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="25200">
                                                    <input type="text" hidden name="code" value="200">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 25,200 THB">
                                                </form>
                                            </td>
                                            <td>-</td>
                                        </tr>

                                        <!-- All Inclusive Training -->
                                        <tr>
                                            <td>All Inclusive Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="All Inclusive Training ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="5500">
                                                    <input type="text" hidden name="code" value="201">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 5,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="All Inclusive Training ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="16800">
                                                    <input type="text" hidden name="code" value="201">
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 16,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="All Inclusive Training ( 3 Months )">
                                                    <input type="text" hidden name="price" value="43000">
                                                    <input type="text" hidden name="code" value="201">
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 43,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Muay Thai Training -->
                                        <tr>
                                            <td>Muay Thai Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai Training ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="4400">
                                                    <input type="text" hidden name="code" value="202">
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 4,400 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai Training ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="13500">
                                                    <input type="text" hidden name="code" value="202">
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 13,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai Training ( 3 Months )">
                                                    <input type="text" hidden name="price" value="34500">
                                                    <input type="text" hidden name="code" value="202">
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 34,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Muay Thai & MMA Training -->
                                        <tr>
                                            <td>Muay Thai & MMA Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai & MMA Training ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="5000">
                                                    <input type="text" hidden name="code" value="203">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 5,000 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai & MMA Training ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="15300">
                                                    <input type="text" hidden name="code" value="203">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 15,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai & MMA Training ( 3 Months )">
                                                    <input type="text" hidden name="price" value="38500">
                                                    <input type="text" hidden name="code" value="203">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 38,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Western Boxing & Fitness Training -->
                                        <tr>
                                            <td>Western Boxing & Fitness Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Western Boxing & Fitness Training ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="4800">
                                                    <input type="text" hidden name="code" value="204">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 4,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Western Boxing & Fitness Training ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="14700">
                                                    <input type="text" hidden name="code" value="204">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 14,700 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Western Boxing & Fitness Training ( 3 Months )">
                                                    <input type="text" hidden name="price" value="38000">
                                                    <input type="text" hidden name="code" value="204">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 38,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Grappling & BJJ Training -->
                                        <tr>
                                            <td>Grappling & BJJ Training</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Grappling & BJJ Training ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="4600">
                                                    <input type="text" hidden name="code" value="205">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 4,600 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Grappling & BJJ Training ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="14100">
                                                    <input type="text" hidden name="code" value="205">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 14,100 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Grappling & BJJ Training ( 3 Months )">
                                                    <input type="text" hidden name="price" value="35000">
                                                    <input type="text" hidden name="code" value="205">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 35,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Fitness Training Pack -->
                                        <tr>
                                            <td>Fitness Training Pack</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Fitness Training Pack ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="5300">
                                                    <input type="text" hidden name="code" value="206">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 5,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Fitness Training Pack ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="16200">
                                                    <input type="text" hidden name="code" value="206">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 16,200 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Fitness Training Pack ( 3 Months )">
                                                    <input type="text" hidden name="price" value="40500">
                                                    <input type="text" hidden name="code" value="206">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 40,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Deluxe Training Pack -->
                                        <tr>
                                            <td>Deluxe Training Pack</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe Training Pack ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="9650">
                                                    <input type="text" hidden name="code" value="207">
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 9,650 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe Training Pack ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="31050">
                                                    <input type="text" hidden name="code" value="207">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 31,050 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe Training Pack ( 3 Months )">
                                                    <input type="text" hidden name="price" value="88750">
                                                    <input type="text" hidden name="code" value="207">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 88,750 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- V.I.P Training Pack -->
                                        <tr>
                                            <td>V.I.P Training Pack</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="V.I.P Training Pack ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="12800">
                                                    <input type="text" hidden name="code" value="208">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 12,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="V.I.P Training Pack ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="46800">
                                                    <input type="text" hidden name="code" value="208">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 46,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="V.I.P Training Pack ( 3 Months )">
                                                    <input type="text" hidden name="price" value="134500">
                                                    <input type="text" hidden name="code" value="208">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 134,500 THB">
                                                </form>
                                            </td>
                                        </tr>


                                        <!-- Basic All-Inclusive Package STANDARD  -->
                                        <tr>
                                            <td>Basic All-Inclusive Package STANDARD</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Basic All-Inclusive Package STANDARD ( 1 Weekly )">
                                                    <input type="text" name="code" value="1" hidden>
                                                    <input type="text" hidden name="price" value="14500">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 14,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Basic All-Inclusive Package STANDARD ( 1 Monthly )">
                                                    <input type="text" name="code" value="1" hidden>
                                                    <input type="text" hidden name="price" value="42800">
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 42,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Basic All-Inclusive Package STANDARD ( 3 Months )">
                                                    <input type="text" name="code" value="1" hidden>
                                                    <input type="text" hidden name="price" value="123500">
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 123,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Basic All-Inclusive Package PLUS -->
                                        <tr>
                                            <td>Basic All-Inclusive Package PLUS</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PLUS ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="16500">
                                                    <input type="text" name="code" value="2" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 16,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PLUS ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="48800">
                                                    <input type="text" name="code" value="2" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET48,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PLUS ( 3 Months )">
                                                    <input type="text" hidden name="price" value="141500">
                                                    <input type="text" name="code" value="2" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 141,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Basic All-Inclusive Package PREMIUM -->
                                        <tr>
                                            <td>Basic All-Inclusive Package PREMIUM</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PREMIUM ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="18000">
                                                    <input type="text" name="code" value="3" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 18,000 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PREMIUM ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="53800">
                                                    <input type="text" name="code" value="3" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 53,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Basic All-Inclusive Package PREMIUM ( 3 Months )">
                                                    <input type="text" hidden name="price" value="156500">
                                                    <input type="text" name="code" value="3" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 156,500 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Deluxe All-Inclusive Package STANDARD -->
                                        <tr>
                                            <td>Deluxe All-Inclusive Package STANDARD</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe All-Inclusive Package STANDARD ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="19050">
                                                    <input type="text" name="code" value="4" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 19,050 THB">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package STANDARD ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="59050">
                                                    <input type="text" name="code" value="4" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 59,050 THB">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package STANDARD ( 3 Months )">
                                                    <input type="text" hidden name="price" value="172250">
                                                    <input type="text" name="code" value="4" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 172,250 THB">
                                                </form>
                                            </td>

                                        </tr>

                                        <!-- Deluxe All-Inclusive Package PLUS -->
                                        <tr>
                                            <td>Deluxe All-Inclusive Package PLUS</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe All-Inclusive Package PLUS ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="21050">
                                                    <input type="text" name="code" value="5" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 21,050 THB">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package PLUS ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="65050">
                                                    <input type="text" name="code" value="5" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 65,050 THB">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe All-Inclusive Package PLUS ( 3 Months )">
                                                    <input type="text" hidden name="price" value="190250">
                                                    <input type="text" name="code" value="5" hidden>
                                                    <input type="submit" class="btn btn-success" name="action" value="TICKET 190,250 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Deluxe All-Inclusive Package PREMIUM -->
                                        <tr>
                                            <td>Deluxe All-Inclusive Package PREMIUM</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package PREMIUM ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="22550">
                                                    <input type="text" name="code" value="6" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 22,550 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package PREMIUM ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="70050">
                                                    <input type="text" name="code" value="6" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 70,050 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Deluxe All-Inclusive Package PREMIUM ( 3 Months )">
                                                    <input type="text" hidden name="price" value="205250">
                                                    <input type="text" name="code" value="6" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 205,250 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- VIP All-Inclusive Package PLUS -->
                                        <tr>
                                            <td>VIP All-Inclusive Package STANDARD</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package STANDARD ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="22300">
                                                    <input type="text" name="code" value="7" hidden> 
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 22,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package STANDARD ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="75300">
                                                    <input type="text" name="code" value="7" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 75,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package STANDARD ( 3 Months )">
                                                    <input type="text" hidden name="price" value="221000">
                                                    <input type="text" name="code" value="7" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 221,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- VIP All-Inclusive Package PLUS -->
                                        <tr>
                                            <td>VIP All-Inclusive Package PLUS</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PLUS ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="23800">
                                                    <input type="text" name="code" value="8" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 24,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PLUS ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="80000">
                                                    <input type="text" name="code" value="8" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 81,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PLUS ( 3 Months )">
                                                    <input type="text" hidden name="price" value="237000">
                                                    <input type="text" name="code" value="8" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 239,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- VIP All-Inclusive Package PREMIUM -->
                                        <tr>
                                            <td>VIP All-Inclusive Package PREMIUM</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PREMIUM ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="25800">
                                                    <input type="text" name="code" value="9" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 25,800 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PREMIUM ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="86300">
                                                    <input type="text" name="code" value="9" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 86,300 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="VIP All-Inclusive Package PREMIUM ( 3 Months )">
                                                    <input type="text" hidden name="price" value="254000">
                                                    <input type="text" name="code" value="9" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 254,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Weight-Loss All-Inclusive Package STANDARD -->
                                        <tr>
                                            <td>Weight-Loss All-Inclusive Package STANDARD</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package STANDARD ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="24200">
                                                    <input type="text" name="code" value="10" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 24,200 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package STANDARD ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="63400">
                                                    <input type="text" name="code" value="10" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 63,400 THB ">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package STANDARD ( 3 Months )">
                                                    <input type="text" hidden name="price" value="182700">
                                                    <input type="text" name="code" value="10" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 182,700 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Weight-Loss All-Inclusive Package PLUS -->
                                        <tr>
                                            <td>Weight-Loss All-Inclusive Package PLUS</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PLUS ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="26000">
                                                    <input type="text" name="code" value="11" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 26,000 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PLUS ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="69400">
                                                    <input type="text" name="code" value="11" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 69,400 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PLUS ( 3 Months )">
                                                    <input type="text" hidden name="price" value="200700">
                                                    <input type="text" name="code" value="11" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 200,700 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Weight-Loss All-Inclusive Package PREMIUM -->
                                        <tr>
                                            <td>Weight-Loss All-Inclusive Package PREMIUM</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PREMIUM ( 1 Weekly )">
                                                    <input type="text" hidden name="price" value="27500">
                                                    <input type="text" name="code" value="12" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 27,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PREMIUM ( 1 Monthly )">
                                                    <input type="text" hidden name="price" value="74400">
                                                    <input type="text" name="code" value="12" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 74,400 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Weight-Loss All-Inclusive Package PREMIUM ( 3 Months )">
                                                    <input type="text" hidden name="price" value="215700">
                                                    <input type="text" name="code" value="12" hidden>
                                                    <input type="submit" class="btn btn-success" name="action"value="TICKET 215,700 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- STANDARD Accommodation -->
                                        <tr>
                                            <td>STANDARD Accommodation</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="STANDARD Accommodation ( 1 Day )">
                                                    <input type="text" hidden name="price" value="1000">
                                                    <input type="text" name="code" value="13" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 1,000 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="STANDARD Accommodation ( 1 Week )">
                                                    <input type="text" hidden name="price" value="6500">
                                                    <input type="text" name="code" value="13" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 6,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="STANDARD Accommodation ( 1 Month )">
                                                    <input type="text" hidden name="price" value="16000">
                                                    <input type="text" name="code" value="13" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 16,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Deluxe Accommodation -->
                                        <tr>
                                            <td>Deluxe Accommodation</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe Accommodation ( 1 Day )">
                                                    <input type="text" hidden name="price" value="1700">
                                                    <input type="text" name="code" value="14" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 1,700 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe Accommodation ( 1 Week )">
                                                    <input type="text" hidden name="price" value="8500">
                                                    <input type="text" name="code" value="14" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 8,500 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Deluxe Accommodation ( 1 Month )">
                                                    <input type="text" hidden name="price" value="22000">
                                                    <input type="text" name="code" value="14" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 22,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- PREMIUM Accommodation -->
                                        <tr>
                                            <td>PREMIUM Accommodation</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="PREMIUM Accommodation ( 1 Day )">
                                                    <input type="text" hidden name="price" value="1900">
                                                    <input type="text" name="code" value="15" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 1,900 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="PREMIUM Accommodation ( 1 Week )">
                                                    <input type="text" hidden name="price" value="10000">
                                                    <input type="text" name="code" value="15" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 10,000 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="PREMIUM Accommodation ( 1 Month )">
                                                    <input type="text" hidden name="price" value="27000">
                                                    <input type="text" name="code" value="15" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 27,000 THB">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Tiger Money Card -->
                                        <tr>
                                            <td scope="row">Tiger Money Card</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Tiger Money Card">
                                                    <input type="text" hidden name="price" value="31500">
                                                    <input type="text" name="code" value="16" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="SALE TICKET">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Prepaid Meal Cards -->
                                        <tr>
                                            <td scope="row">Prepaid Meal Cards</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Prepaid Meal Cards ( 1 Week )">
                                                    <input type="text" hidden name="price" value="3000">
                                                    <input type="text" name="code" value="17" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 3,000">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="Prepaid Meal Cards ( 1 Month )">
                                                    <input type="text" hidden name="price" value="12000">
                                                    <input type="text" name="code" value="17" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 12,000">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Prepaid Meal Cards ( 3 Month )">
                                                    <input type="text" hidden name="price" value="36000">
                                                    <input type="text" name="code" value="17" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 36,000">
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Muay Thai Gear Package -->
                                        <tr>
                                            <td scope="row">Muay Thai Gear Package</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Muay Thai Gear Package">
                                                    <input type="text" hidden name="price" value="9000">
                                                    <input type="text" name="code" value="18" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 9,000">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- MMA Gear Package -->
                                        <tr>
                                            <td scope="row">MMA Gear Package</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package" value="MMA Gear Package">
                                                    <input type="text" hidden name="price" value="12000">
                                                    <input type="text" name="code" value="19" hidden>
                                                    <input type="submit" name="action" class="btn btn-success"value="TICKET 12,000">
                                                </form>
                                            </td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>

                                        <!-- Airport Pick-up -->
                                        <tr>
                                            <td scope="row">Airport Pick-up</td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"
                                                        value="Airport Pick-up 1-2 People">
                                                    <input type="text" hidden name="price" value="850">
                                                    <input type="text" name="code" value="20" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 850 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Airport Pick-up 3 People">
                                                    <input type="text" hidden name="price" value="950">
                                                    <input type="text" name="code" value="20" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 950 THB">
                                                </form>
                                            </td>
                                            <td>
                                                <form action="" method="post">
                                                    <input type="text" hidden name="package"value="Airport Pick-up 4-6 People">
                                                    <input type="text" hidden name="price" value="1250">
                                                    <input type="text" name="code" value="20" hidden>
                                                    <input type="submit" name="action" class="btn btn-success" value="TICKET 1,250 THB">
                                                </form>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-5 p-2">
                            <?php if (isset($_POST['action'])) { ?>
                                <div class="card">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="./saleSql.php" method="post">
                                                <input type="text" name="actionSale" hidden>
                                                <div class="card mx-auto p-3 bg-info">
                                                    <h3>SALE TICKET</h3>
                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Package</span>
                                                        </div>
                                                        <input type="text" name="package" class="form-control" value="<?=$_POST["package"]?>">
                                                        <input type="text" name="code" hidden class="form-control" value="<?=$_POST["code"]?>">
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Numbercard</span>
                                                        </div>
                                                        <input type="number" class="form-control" hidden name="m_card" id="m_card" value="<?= 2 * $code?>" required>
                                                        <input type="number" class="form-control" value="<?= 2 * $code?>"required>
                                                        <span id="massage" class="text-center"></span>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Start Date</span>
                                                        </div>
                                                        <input type="date" name="date_start" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Expire Date</span>
                                                        </div>
                                                        <input type="date" name="date_expri" class="form-control"value="<?= date('Y-m-d') ?>" required>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Price</span>
                                                        </div>
                                                        <input type="number" name="price" class="form-control"value="<?= $_POST['price'] ?>" required>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Discount</span>
                                                        </div>
                                                        <select class="custom-select" name="discount" required>
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

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Vat 7%</span>
                                                        </div>
                                                        <select class="custom-select" name="vat7">
                                                            <option value="0">0%</option>
                                                            <option value="7">7%</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Charge Card 3%</span>
                                                        </div>
                                                        <select class="custom-select" name="vat3">
                                                            <option value="0">0%</option>
                                                            <option value="3">3%</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Type of pay</span>
                                                        </div>
                                                        <select class="custom-select" name="pay" required>
                                                            <option value="Cash">Cash</option>
                                                            <option value="CreditCard">Credit Card</option>
                                                            <option value="CreditCard&Cash">Credit Card & Cash</option>
                                                            <option value="QrCode">QrCode</option>
                                                            <option value="Paypal">Paypal</option>
                                                            <option value="Direct">Direct</option>
                                                            <option value="MoneyCard">MoneyCard</option>
                                                            <option value="TMTCard">TMTCard</option>
                                                            <option value="StudentVisa">Student Visa</option>
                                                        </select>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Customer name</span>
                                                        </div>
                                                        <input type="text" name="fname" class="form-control" value="Customer"required>
                                                    </div>

                                                    <div class="form-group">
                                                        <textarea class="form-control" name="comment" rows="3"placeholder="Comment">Comment here !</textarea>
                                                    </div>

                                                    <input type="submit" id="btn-save" class="btn btn-dark text-center" value="SALE TICKET">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="row">
                                    <div class="col-12">
                                        <form action="" method="post">
                                            <div class="card mx-auto p-3 ">
                                                <h3>SALE TICKET</h3>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Package</span>
                                                    </div>
                                                    <input type="text" name="package" class="form-control" placeholder="Enter Package">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Numbercard</span>
                                                    </div>
                                                    <input type="number" class="form-control" >
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Start Date</span>
                                                    </div>
                                                    <input type="date" name="date_start" class="form-control">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Expire Date</span>
                                                    </div>
                                                    <input type="date" name="date_expri" class="form-control">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Price</span>
                                                    </div>
                                                    <input type="number" name="price" class="form-control">
                                                </div>

                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Discount</span>
                                                    </div>
                                                    <select class="custom-select" name="discount" required>
                                                        <option value="0">0%</option>
                                                        <option value="5">5%</option>
                                                        <option value="10">10%</option>
                                                        <option value="15">15%</option>
                                                        <option value="20">20%</option>
                                                        <option value="25">25%</option>
                                                        <option value="30">30%</option>
                                                    <option value="40">40%</option>
                                                    <option value="45">45%</option>
                                                    <option value="50">50%</option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Vat 7%</span>
                                                </div>
                                                <select class="custom-select" name="vat7">
                                                    <option value="0">0%</option>
                                                    <option value="7">7%</option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Vat 3%</span>
                                                </div>
                                                <select class="custom-select" name="vat3">
                                                    <option value="0">0%</option>
                                                    <option value="3">3%</option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Type of pay</span>
                                                </div>
                                                <select class="custom-select" name="pay" required>
                                                    <option value="Cash">Cash</option>
                                                    <option value="CreditCard">Credit Card</option>
                                                    <option value="QrCode">QrCode</option>
                                                    <option value="Paypal">Paypal</option>
                                                    <option value="Direct">Direct</option>
                                                    <option value="MoneyCard">MoneyCard</option>
                                                    <option value="TMTCard">TMTCard</option>
                                                    <option value="StudentVisa">Student Visa</option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Customer name</span>
                                                </div>
                                                <input type="text" name="fname" class="form-control" value="Customer" required>
                                            </div>

                                            <div class="form-group">
                                                <textarea class="form-control" name="comment" rows="3" placeholder="Comment">Comment here !</textarea>
                                            </div>

                                            <input type="text" class="btn btn-dark text-center" value="SALE TICKET">

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php }?>
                            <?php 
                                if (isset($_POST['code']) != '') {
                                    include './previewMenu.php';
                                } else {
                                    echo '';
                                }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>
    <script src="../dist/js/fancyapps.js"></script>
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- datatables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/jszip/jszip.min.js"></script>
    <script src="../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
    $("#table1").DataTable({"pageLength": 15});
    $("#table2").DataTable({});


    $('#m_card').keyup(function() {
        console.log($(this).val());
        var m_card = $(this).val();
        if (m_card == "") {
            $(this).addClass('border-danger');
            $("#massage").html("Please Enter Number");
            $("#massage").addClass("text-danger , text-size:25px");
            $("#btn-save").attr("disabled", true);
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
                        $("#btn-save").attr("disabled", true);

                        $("#m_card").removeClass("border-success");
                        $("#massage").removeClass("text-success");
                    } else {
                        $("#m_card").addClass('border-success');
                        $("#massage").html("Can use this number");
                        $("#massage").addClass("text-success");
                        $("#btn-save").attr("disabled", false);

                        $("#m_card").removeClass("border-danger");
                        $("#massage").removeClass("text-danger");
                    }
                }
            });
        }
    });

    function print() {
        window.location.href = './salePrint.php';
    }

    // Customization example
    Fancybox.bind('[data-fancybox="gallery"]', {
        infinite: false
    });

    </script>

<?php if (isset($_SESSION['success'])){ ?>
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            icon: 'success',
            title: 'Sale ticket successfully!'
        })
    </script>
<?php } unset($_SESSION['success']);?> 

</body>

</html>
<?php $conndb = null;?>