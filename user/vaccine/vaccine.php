<?php
    session_start();
    include('./middleware.php');
    $title = 'VACCINE | TIGER APPLICATION';
    $page = 'vaccine';
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

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Modal -->
        <div class="modal fade" id="vaccin_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> CREATE NEW VACCINE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="./vaccineSql.php" method="POST">
                            <div class="form-group col">
                                <input type="text" name="vaccine" class="form-control mb-1" placeholder=" ชื่อ ">
                                <input type="text" name="country" class="form-control mb-1" placeholder="ประเทศที่ผลิต">
                                <input type="text" name="percentage" class="form-control" placeholder="เปอร์เซน การรักษา">
                            </div>
                            <div class="form-group col">
                                <input type="submit" name="insert" value="SAVE" class="btn btn-success" style="width: 100%;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <?php include 'aside.php' ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row p-3">
                        <h2>Vaccine</h2>
                        <button class="btn btn-success btn-sm ml-5 mb-2 bb" data-toggle="modal" data-target="#vaccin_add">
                            Create
                        </button>
                        <div class="col-lg-12">
                            <div class="card p-2 mt-2">
                                <table class="table table-sm  table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Percentage</th>
                                            <th class="text-center">action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require_once '../includes/connection.php';
                                            $sql = $conndb->query("SELECT * FROM `tb_vaccine`");
                                            $sql->execute();
                                            $result = $sql->fetchAll();
                                            $count = 1;
                                        foreach ($result as $row) { ?>
                                            <tr>
                                                <td><?= $count++; ?></td>
                                                <td><?= $row['name']; ?></td>
                                                <td><?= $row['country']; ?></td>
                                                <td><?= $row['percentage']; ?></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?= $row['id']; ?>"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-sm btn-danger trash" id="<?= $row['id']; ?>"><i class="fas fa-trash"></i></button>
                                                </td>

                                                <!-- Modal -->
                                                <div class="modal fade" id="edit<?= $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"> Update Name </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="./vaccineSql.php" method="POST">
                                                                    <div class="form-group col">
                                                                        <input type="text" hidden name="id" value="<?= $row['id']; ?>">
                                                                        <input type="text" name="vaccine" class="form-control mb-1" value="<?= $row['name'] ?>">
                                                                        <input type="text" name="country" class="form-control mb-1" value="<?= $row['country'] ?>">
                                                                        <input type="text" name="percentage" class="form-control" value="<?= $row['percentage'] ?>">
                                                                    </div>
                                                                    <div class="form-group col">
                                                                        <input type="submit" name="update" value="SAVE" class="btn btn-success" style="width: 100%;">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
if (isset($_SESSION['insert'])) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good job!',
            text: ' Your Create data Successfully!',
            showConfirmButton: true,
            timer: 1500
        })
    </script>
<?php endif; unset($_SESSION['insert']) ?>

<?php if (isset($_SESSION['update'])) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good job!',
            text: ' Your Update data successfully!',
            showConfirmButton: true,
            timer: 1500
        })
    </script>
<?php endif; unset($_SESSION['update']) ?>

<?php if (isset($_SESSION['delete'])) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Good job!',
            text: ' Your delete data successfully!',
            showConfirmButton: true,
            timer: 1500
        })
    </script>
<?php endif; unset($_SESSION['delete']) ?>


<script>
    $(document).ready(function() {
        $(".trash").click(function() {
            let trash_id = $(this).attr("id");
            console.log(trash_id);
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to do ?",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, I won to do !",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "./vaccineSql.php",
                        method: "POST",
                        data: {
                            id: trash_id,
                            action: 'delete'
                        },
                        success: function(response) {
                            location.reload();
                        },
                    });
                }
            });
        });
    });
</script>
<?php $conndb = null; ?>