<?php 
  session_start();
  include 'middleware.php';
  $title = 'RECORD CHECKIN | APPLICATION';
  $page = 'record';
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
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include './aside.php' ?> 
  <div class="content-wrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-3">
                <div class="card p-3">
                    <table class="table table-sm table-hover" id="example1">
                        <thead>
                            <tr>
                                <th >ลำดับที่</th>
                                <th >หมายเลขบัตร</th>
                                <th >ชื่อ</th>
                                <th >ชื่อ บริการ</th>
                                <th >เวลา</th>
                                <th >เรียกดู</th>
                                <th class="text-center">วันหมดอายุ</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php
                                    require_once('../includes/connection.php');
                                    $sql_data = $conndb->query("SELECT m.id , m.m_card , m.fname,m.image , m.package ,m.status_code,
                                    m.type_training,t.date ,t.time,t.time_id,m.group,m.sponsored,m.sta_date,m.status,m.comment, o.id as orderid,
                                    m.exp_date,m.image,m.type_fighter
                                    FROM tb_time AS t   
                                    LEFT JOIN member AS m ON t.ref_m_card = m.m_card
                                    LEFT JOIN orders AS o ON m.m_card = o.ref_order_id
                                    WHERE date(t.time) = CURDATE()
                                    GROUP BY m.m_card
                                    ORDER BY t.time DESC");
                                    $sql_data->execute();
                                    $count = 1;
                                
                                    foreach($sql_data as $row ) : ?>

                                    <tr>
                                        <td><?= $count++; ?> </td>

                                        <td><?= $row['m_card']; ?> </td>

                                        <td><?= $row['fname']; ?> </td>

                                        <?php if ( $row['status_code'] == 1 ) {?> 

                                            <td  style="color: green;"><?= 'Ticket' ?> </td>

                                        <?php } elseif ( $row['status_code'] == 2) {?>

                                            <td  style="color: green;"><?= $row['package']; ?> </td>
                                            
                                        <?php } else { ?>

                                            <td  style="color: red;font-weight: 600;"> <?= $row['type_fighter'].' / '.$row['type_training'] ?> </td>
                                        
                                        <?php }?>
                                            
                                        <td ><?= date('H:i:s',strtotime($row['time'])); ?> </td>

                                        <?php if( $row['status_code']== 1 ) {?>

                                            <td><a href="showBill.php?id=<?= $row['orderid'] ?>" target="_blank" class="btn btn-info"><i class="fas fa-eye"></a></td>

                                        <?php } elseif ($row['status_code'] == 2) {?>

                                            <td><a href="member_profile.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-success"><i class="fas fa-eye"></i></a></td>
                                            
                                        <?php } else { ?>
                                                
                                            <td><a href="fighter_profile.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-danger" id="fighter"><i class="fas fa-eye"></i></a></td>

                                        <?php }?>
                                        
                                        <td class="text-center" >
                                            <?php  $today = date('Y-m-d');
                                            if ($row['exp_date'] > $today ) { ?>
                                                <button class="btn btn-success btn-sm " id="exp" ><?php echo date('d/m/Y',strtotime($row['exp_date'])) ?></button>
                                            <?php } elseif( $row['exp_date'] == $today ) {?>
                                                <button class="btn btn-warning btn-sm" id="exp" onclick="exp1()" ><?php echo date('d/m/Y',strtotime($row['exp_date'])) ?></button>
                                            <?php }else {?>
                                                <button class="btn btn-danger btn-sm" id="exp" onclick="exp2()">Expired <i class="fab fa-expeditedssl"></i> </button>
                                            <?php } ?>
                                        </td> 
                    
                                        <td class="text-center"> 
                                            <button class="btn btn-danger btn-sm delete_btn" id="<?= $row['time_id'];?>"><i class="fas fa-trash-alt"></i></button>
                                        </td>

                                    </tr>
                                <?php endforeach;?> 
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.js"></script>

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

</body>
</html>

<script>
    
    $(function() {
        $("#example1").DataTable({
          "responsive": true,
          "lengthChange": false,
          "autoWidth": false,
          "buttons": ["excel"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
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

<?php $conndb = null; ?>
