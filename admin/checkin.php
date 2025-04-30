<?php
include './middleware.php';
$title = 'CHECKIN | APPLICATION';
$page = 'checkin';
date_default_timezone_set('Asia/Bangkok');
require_once '../includes/connection.php';
$sql = "SELECT * FROM `checkin` WHERE DATE(checkin_date) = CURDATE() GROUP BY checkin_card_number";
$sql_total = $conndb->query($sql);
$sql_total->execute();
$count = $sql_total->rowCount();
$result = $sql_total->fetchAll(PDO::FETCH_ASSOC);

include './layout/header.php';

?>

<style>
  .content-wrapper h2 {
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
  #customer {
    background: linear-gradient(35deg, black 50%, rgb(221, 77, 10) 50%);
    color: #fff;
    overflow: hidden;
    transition: 0.5s;
  }

  #customer:hover {
    transform: scale(1.1);
  }

  /* btn fighter */
  #fighter {
    background: linear-gradient(35deg, black 50%, rgb(17, 0, 255) 50%);
    color: #fff;
    ;
    overflow: hidden;
    transition: 0.5s;
  }

  #fighter:hover {
    transform: scale(1.1);
  }

  /* btn daypass */
  #daypass {
    background: linear-gradient(35deg, black 50%, rgb(255, 0, 208) 50%);
    color: #fff;
    ;
    overflow: hidden;
    transition: 0.5s;
  }

  #daypass:hover {
    transform: scale(1.1);
  }

  #Dropin {
    background: linear-gradient(35deg, black 50%, rgb(255, 0, 208) 50%);
    color: #fff;
    ;
    overflow: hidden;
    transition: 0.5s;
  }

  #Dropin:hover {
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

  #exp {
    display: block;
    width: 100%;
    justify-content: center;
  }

  #clock {
    font-size: 24px;
    width: 100%;
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include 'aside.php' ?>
    <div class="content-wrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-8 mt-3">
              <!-- <h2> check in </h2> -->
              <div class="card">

                <form action="./checkin/checkinSql.php" method="post">
                  <div class="card-body">
                    <p style="text-align: center;" id="clock"> 8:10:45 </p>

                    <div class="form-floating mb-1">
                      <input type="number" name="ref_m_card" class="form-control" id="floatingInput" placeholder="Member Card" autofocus required>
                    </div>

                    <div class="d-grid gap-2 col mx-auto">
                      <input type="submit" hidden class="btn btn-primary btn-sm" value="ENETER">
                    </div>
                    จำนวนเช็คอินวันนี้ : <?= $count ?> คน
                  </div>
                </form>

              </div>
              <div class="card p-2">
                <?php include './checkin/table.php'; ?>
              </div>
            </div>
            <div class="col-4">

              <?php

              if (empty($result)) {
                echo '<div class="card mt-3">';
                echo '<img src="../dist/img/logo.png" width="70%" class="mt-3 img ">';
                echo '<div class="input-group py-2 mx-auto col-12">';
                echo '</div>';
              } else if ($result[0]['checkin_group_type'] == 1) {
                include './checkin/customer.php';
              } else if ($result[0]['checkin_group_type'] == 2) {
                include './checkin/pos.php';
              } else {
                echo '<div class="card mt-3">';
                echo '<img src="../dist/img/logo.png" width="70%" class="mt-3 img ">';
                echo '<div class="input-group py-2 mx-auto col-12">';
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
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>

<script>
  setInterval(showTime, 1000);

  function showTime() {
    let time = new Date();
    let hour = time.getHours();
    let min = time.getMinutes();
    let sec = time.getSeconds();
    am_pm = "PM";
    if (hour > 24) {
      hour -= 24;
      am_pm = " PM ";
    }
    if (hour == 0) {
      hr = 24;
      am_pm = " AM ";
    }
    hour = hour < 10 ? "0" + hour : hour;
    min = min < 10 ? "0" + min : min;
    sec = sec < 10 ? "0" + sec : sec;
    // let currentTime = hour + " : " + min + " : " + sec + " : " + am_pm;
    let currentTime = hour + " : " + min + " : " + sec;
    document.getElementById("clock").innerHTML = currentTime;
  }
  showTime();
</script>

<!-- sweet -->
<?php if (isset($_SESSION['number_error'])) { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'ไม่มีหมายเลขนี้ในระบบ!',
      showConfirmButton: true,

      // timer: 4000,
      // timerProgressBar: true,
      // color: 'red',
    });
  </script>
<?php }
unset($_SESSION['number_error']); ?>

<!-- sweet -->
<?php if (isset($_SESSION['expiry'])) { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'บัตรหมดอายุการใช้งานแล้ว!',
      footer: 'This card number has expired.!',
      timer: 10000,
      timerProgressBar: true,
      color: 'red',
    })
  </script>
<?php }
unset($_SESSION['expiry']); ?>

<!-- sweet -->
<?php if (isset($_SESSION['date_expiry'])) { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'บัตรหมดอายุการใช้งานแล้ว! ',
      footer: 'This card number has expired.!',
      timer: 10000,
      timerProgressBar: true,
      color: 'red',
    })
  </script>
<?php }
unset($_SESSION['date_expiry']); ?>

<!-- sweet -->
<?php if (isset($_SESSION['product_expired'])) { ?>
  <script>
    Swal.fire({
      icon: 'warning',
      title: 'อุ๊ปส์...',
      text: 'จำนวนครั้งในการใช้งาน หมดแล้ว !',
      footer: 'This Product expired has expired.!',
      timer: 10000,
      timerProgressBar: true,
      color: 'red',
    })
  </script>
<?php }
unset($_SESSION['product_expired']); ?>

<?php if (isset($_SESSION['not'])) { ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'อุ๊ปส์...',
      text: 'หมายเลขบัตรใช้งานไม่ได้ ไม่พบหมายเลขบัตรในระบบ !',
      footer: ' โปรดตรวจสอบหมายเลขใหม่ !'
    })
  </script>
<?php }
unset($_SESSION['not']); ?>

<?php if (isset($_SESSION['less'])) { ?>
  <script>
    Swal.fire({
      icon: 'warning',
      title: 'อุ๊ปส์...',
      text: ' ลูกค้าท่านนี้ พรุ่งนี้ใช้งานไม่ได้แล้วน่ะครับ เวลาใช้งานหมดแล้ว !',
      footer: 'กรุณาติดต่อฝ่ายขาย หรือ ฝ่ายที่เกี่ยวข้อง!'
    })
  </script>
<?php }
unset($_SESSION['less']); ?>

<script>
  $(function() {
    $("#table").DataTable({});
  });

  $(document).ready(function() {
    $('.delete_btn').click(function() {
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
            url: "./checkin/record_delete.php",
            method: 'POST',
            data: {
              id: uid
            },
            success: function(response) {
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              ).then((result) => {
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



<?php $conndb = null; ?>