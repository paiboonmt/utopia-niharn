<?php
    session_start();
    include('./middleware.php');
    $title = 'TELEPHONE NUMBER | TIGER APPLICATION';
    $page = 'telephone';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.ico">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include './aside.php' ?>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <h1>Telephone</h1>

            <div class="col-12">
              <div class="row">
                <div class="col-6 mt-1">
                  <div class="card p-1">
                    <table class="table table-sm table-hover table-bordered">
                      <thead>
                        <tr class="bg-info">
                          <th colspan="3">Managing Director</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>101</td>
                          <td>K.Viwat</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>403</td>
                          <td>K.Suchat</td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-primary">
                          <th colspan="3">Back Office</th>
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>102</td>
                          <td>K.Tong</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>103</td>
                          <td>K.Kik</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>104</td>
                          <td>K.Dee</td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>105</td>
                          <td>K.May</td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>110</td>
                          <td>K.Tum</td>
                        </tr>
                        <tr>
                          <th scope="row">6</th>
                          <td>514</td>
                          <td>K.Phet</td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-danger">
                          <th colspan="3">Accounting</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>106</td>
                          <td>K.Pronn</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>107</td>
                          <td>K.Aon</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>108</td>
                          <td>K.Ruk</td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>109</td>
                          <td>K.Taan</td>
                        </tr>
                        <tr>
                          <th scope="row">5</th>
                          <td>302</td>
                          <td>K.Ann</td>
                        </tr>
                        <tr>
                          <th scope="row">6</th>
                          <td>303</td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-6 mt-1">
                  <div class="card p-1">
                    <table class="table table-sm table-hover table-bordered">
                      <thead>
                        <tr class="bg-success">
                          <th colspan="3">Reception</th>
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>201</td>
                          <td>Font Office</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>112</td>
                          <td></td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-purple">
                          <th colspan="3">Reservation</th>
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>212</td>
                          <td>K.Jolen</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>202</td>
                          <td>K.Lhoa & K.Aoy </td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-yellow">
                          <th colspan="3">Gear Shop</th>
                        </tr>

                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>203</td>
                          <td>Gear Shop</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>401</td>
                          <td>Store Office</td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-cyan">
                          <th colspan="3">Weight Room </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>405</td>
                          <td>K.Peter</td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-primary">
                          <th colspan="3">Studio Room </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>501</td>
                          <td>K.Hip / K.Johny</td>
                        </tr>
                      </tbody>

                      <thead>
                        <tr class="bg-black">
                          <th colspan="3" style="color:white">TIGER MUAYTHAI</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Phone</td>
                          <td>076 367 071</td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Fex</td>
                          <td>076 367 072</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  </div>
  <script src="../plugins/jquery/jquery.min.js"></script>
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dist/js/adminlte.min.js"></script>
</body>
</html>