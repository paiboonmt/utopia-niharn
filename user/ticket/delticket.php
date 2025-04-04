<?php 
  session_start();
  $title = 'TICKET | TIGER APPLICATION';
  include './middleware.php';
  $page = 'delticket';
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
  <style>
    img {
      border-radius: 50px;
      width: 50px;
      height: 50px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include './aside.php' ?> 
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 p-2">
            <div class="card-deck">
              <!-- Daypass ไม่กำหนดวัน -->
                <div class="card bg-dark ">
                    <div class="card-body">
                        <h1>Enter number card</h1>
                        <p class="card-text">Day pass จำนวน 1 วัน </p>
                        <input type="text" id="m_card" class="form-control" autofocus required>
                    </div>
                </div>              
            </div>
          </div>
          <div class="col-md-8 p-2">
            <div class="card">
              <div class="card-body" id="searchresult"></div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.js"></script>
<script>
    $(document).ready(function(){
       $("#m_card").keyup(function(){
        let input = $(this).val();
           if ( input != '') {
            $.ajax({
                url : './delticketSql.php',
                method : 'post',
                data : {input : input},
                success : function(data){
                    $("#searchresult").html(data);
                    console.log(data)
                }
            });
           }else{
                $("#searchresult").html(' <p> Not found </p>');
           } 
       });
    });

</script>
</body>
</html>
<?php $conndb = null; ?> 