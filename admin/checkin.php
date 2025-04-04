<?php
  session_start();
  include './middleware.php';
  $title = 'CHECKIN | APPLICATION';
  $page = 'checkin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../dist/img/logo.jpg">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../dist/css/font.css">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
  <style>
    .content-wrapper  h2 {
      color: #000;
      text-transform: uppercase;
      text-align: center;
      font-weight: 900;
      margin-top: 12px;
      letter-spacing: 3px;
    }
    .table th {
      text-transform: uppercase;
      font-size: 16px;
    }
    .table td {
      font-size: 14px;
    }
    .table tr td {
      font-size: 14px;
      text-transform: uppercase;
    }
    /* btn customer */
    #customer{
      background:linear-gradient(35deg,black 50%,rgb(221, 77, 10) 50%);
      color:#fff;
      overflow: hidden;
      transition: 0.5s;
    }
    #customer:hover{
      transform: scale(1.1);
    }
    /* btn fighter */
    #fighter{
      background:linear-gradient(35deg,black 50%,rgb(17, 0, 255) 50%);
      color: #fff;;
      overflow: hidden;
      transition: 0.5s;
    }
    #fighter:hover{
      transform: scale(1.1);
    }
    /* btn daypass */
    #daypass{
      background:linear-gradient(35deg,black 50%,rgb(255, 0, 208) 50%);
      color: #fff;;
      overflow: hidden;
      transition: 0.5s;
    }
    #daypass:hover{
      transform: scale(1.1);
    }
    #Dropin{
      background:linear-gradient(35deg,black 50%,rgb(255, 0, 208) 50%);
      color: #fff;;
      overflow: hidden;
      transition: 0.5s;
    }
    #Dropin:hover{
      transform: scale(1.1);
    }
    .content-wrapper .col-4 .img {
      position: relative;
      align-items: center;
      justify-content: center;
      border-radius: 15px;
      margin-left: 15%;
      box-shadow: 0 0 10px #113af1;
    }
    #exp{
      display: block;
      width: 100%;
      justify-content: center;
    }
    #clock {
      font-size: 24px;
      width: 100% ;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include 'aside.php'?>
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
              <h2> check in </h2>
                <div class="card">
                 
                    <form action="./checkinSql.php" method="post">
                      <div class="card-body">
                          <p style="text-align: center;" id="clock" > 8:10:45 </p>
                            <div class="form-floating mb-1">
                                <input type="number" name="ref_m_card" class="form-control" id="floatingInput" placeholder="Member Card" autofocus required>
                            </div>
      
                            <div class="d-grid gap-2 col mx-auto">
                                <input type="submit" hidden class="btn btn-primary btn-sm" value="ENETER">
                            </div>
                      </div>
                    </form>
                  
                </div>
                <div class="card p-2">
                  <?php include './checkin/record1.php';?>
                </div>
            </div>
            <div class="col-4">
              <?php include './checkin/profile.php'?>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<script>
  setInterval(showTime, 1000);
  function showTime() {
      let time = new Date();
      let hour = time.getHours();
      let min = time.getMinutes();
      let sec = time.getSeconds();
      am_pm = "AM";
      if (hour > 12) {
          hour -= 12;
          am_pm = " PM ";
      }
      if (hour == 0) {
          hr = 12;
          am_pm = " AM ";
      }
      hour = hour < 10 ? "0" + hour : hour;
      min = min < 10 ? "0" + min : min;
      sec = sec < 10 ? "0" + sec : sec;
      let currentTime = hour + ":"  + min + ":" + sec + am_pm;
      document.getElementById("clock") .innerHTML = currentTime;
  }
showTime();
</script>

<!-- sweet -->
<?php if (isset($_SESSION['expiry'])) {?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'อุ๊ปส์...',
        text: 'บัตรหมดอายุการใช้งานแล้ว!',
        footer: 'This card number has expired.!'
      })
    </script>
<?php } unset($_SESSION['expiry']);?>

<?php if (isset($_SESSION['not'])) {?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'หมายเลขบัตรใช้งานไม่ได้ ไม่พบหมายเลขบัตรในระบบ !',
      footer: ' โปรดตรวจสอบหมายเลขใหม่ !'
    })
  </script>
<?php } unset($_SESSION['not']);?>

<?php if (isset($_SESSION['less'])) {?>
  <script>
    Swal.fire({
      icon: 'warning',
      title: 'อุ๊ปส์...',
      text: ' ลูกค้าท่านนี้ พรุ่งนี้ใช้งานไม่ได้แล้วน่ะครับ เวลาใช้งานหมดแล้ว !',
      footer: 'กรุณาติดต่อฝ่ายขาย หรือ ฝ่ายที่เกี่ยวข้อง!'
    })
  </script>
<?php } unset($_SESSION['less']);?>

<?php if (isset($_SESSION['dropin_ex'])) {?>
   <?php if ($_SESSION['package'] == '10 Drop In') {?>
      <script>
        Swal.fire({
          icon: ' warning',
          title:' อุ๊ปส์...',
          text: ' ลูกค้าท่านนี้ Package 10 Drop in ใช้งานครบแล้วครับ !'
        })
      </script>
  <?php }?>
<?php } unset($_SESSION['dropin_ex']);unset($_SESSION['package']);?>

<script>

  $(function() {
    $("#table").DataTable({
    });
  });
  
  $(document).ready(function () {
      $('.delete_btn').click(function(){
          let uid = $(this).attr("id");
          console.log(uid);
          Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url:"sql/record_delete.php",
                      method: 'POST',
                      data:{id:uid},
                      success: function (response) {
                          Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                          ).then((result)=>{
                              location.reload();
                          });
                      }
                  });
              }
          });
      });
  });
</script>

<!-- Alert btn -->
<script>

  function exp1() {
    Swal.fire({
      icon: 'info',
      title: 'อุ๊ปส์...',
      text: ' ลูกค้าท่านนี้ ใช้งานได้วันนี้วันสุดท้ายยยย !'
    })
  }

  function exp2() {
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'บัตรหมดอายุการใช้งานแล้ว!'
    })
  }

</script>

</body>
</html>
<?php $conndb = null;?>
