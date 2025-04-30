<?php
$title = 'จัดการสมาชิก';
include 'middleware.php';
$page = 'usersetting';
require_once("../includes/connection.php");

$sql = "SELECT * FROM `tb_user`";
$stmt = $conndb->query($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['addUser'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role = $_POST['role'];
    $site = $_POST['site'];
    $status = $_POST['status'];
    $sql = "INSERT INTO `tb_user` (`username`, `password`, `role`, `site`, `status`) 
    VALUES (:username, :password, :role, :site, :status)";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':site', $site);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        header('location: usersetting.php');
        $conndb = null;
    }
}

if (isset($_POST['updateUset'])) {

    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];
    $site = $_POST['site'];
    $status = $_POST['status'];

    $sql = "UPDATE `tb_user` SET `username` = :username, `password` = :password, `role` = :role, `site` = :site, `status` = :status WHERE `id` = :id";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':site', $site);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        header('location: usersetting.php');
        $conndb = null;
    }
}


include './layout/header.php';
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include './aside.php' ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Modal -->
                        <div class="modal fade" id="addItem" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addItemTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">เพื่มสินค้าบริการ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Username</span>
                                                </div>
                                                <input type="text" class="form-control" name="username" required>
                                            </div>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Password</span>
                                                </div>
                                                <input type="text" class="form-control" name="password" require>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Site</span>
                                                </div>
                                                <select name="site" class="form-control" required>
                                                    <option value="" disabled selected>--Choose--</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Account</option>

                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Group</span>
                                                </div>
                                                <select name="role" class="form-control" required>
                                                    <option value="" disabled selected>--Choose--</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                    <option value="account">Account</option>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Status</span>
                                                </div>
                                                <select name="status" class="form-control" required>
                                                    <option value="" disabled selected>--Choose--</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Not Active</option>
                                                </select>
                                            </div>

                                            <input type="submit" name="addUser" value="Save" class="form-control btn btn-success">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card mt-2">
                                <div class="card-header bg-dark">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button style="width: 250px; text-transform: uppercase;" type="button" class="btn btn-info" data-toggle="modal" data-target="#addItem">
                                                <i class="fas fa-plus"></i> | เพื่มสินค้าบริการ
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <span style="float: right;">
                                                <h3>รายชื่อผู้ใช้งานโปรแกรม</h3>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm" id="example1">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ไอดี</th>
                                                <th>ชื่อผู้ใช้งาน</th>
                                                <th>สิทธเข้าใช้งาน</th>
                                                <th>สถานะ</th>
                                                <th class="text-center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1;
                                            foreach ($result as $item) : ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $item['id'] ?></td>
                                                    <td><?= htmlspecialchars($item['username']); ?></td>
                                                    <td><?= htmlspecialchars($item['role']); ?></td>
                                                    <td><?= htmlspecialchars($item['status']); ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#id<?= $item['id'] ?>">
                                                            <i class="fas fa-edit"></i> | แก้ไข
                                                        </button>
                                                        <button class="btn btn-danger btn-sm trash">Delete</button>
                                                    </td>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="id<?= $item['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addItemTitle" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไข</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post">

                                                                        <input type="text" hidden name="id" value="<?= $item['id'] ?>">

                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Username</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="username" value="<?= $item['username'] ?>">
                                                                        </div>

                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Password</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="password" placeholder="Enter new password to update">
                                                                        </div>

                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Site</span>
                                                                            </div>
                                                                            <select name="site" class="form-control" required>
                                                                                <option value="<?= $item['site'] ?>" selected><?= $item['site'] ?></option>
                                                                                <option value="1">admin</option>
                                                                                <option value="2">account</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Group</span>
                                                                            </div>
                                                                            <select name="role" class="form-control" required>
                                                                                <option value="<?= $item['role'] ?>" selected><?= $item['role'] ?></option>
                                                                                <option value="admin">Admin</option>
                                                                                <option value="user">User</option>
                                                                                <option value="account">Account</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="input-group mb-2">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Status</span>
                                                                            </div>
                                                                            <select name="status" class="form-control" required>
                                                                                <option value="<?= $item['status'] ?>" selected><?= $item['status'] ?></option>
                                                                                <option value="1">Active</option>
                                                                                <option value="0">Not Active</option>
                                                                            </select>
                                                                        </div>

                                                                        <input type="submit" name="updateUset" value="Save" class="form-control btn btn-success">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include './layout/footer.php'; ?>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["excel"],
                "stateSave": true
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>

</body>

</html>
<?php $conndb = null; ?>