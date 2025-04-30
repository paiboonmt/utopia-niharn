<?php
include './middleware.php';
$title = 'SEARCH | APPLICATION';
$page = 'search';
include_once('../includes/connection.php');
include './layout/header.php';
?>

<div class="wrapper">
    <?php include './aside.php' ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-4 mt-3">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3>SEARCH</h3>
                            </div>
                            <div class="card-body">
                                <input type="text" id="txt_input" class="form-control" autofocus required>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <h5>ขั้นตอนการค้นหาข้อมูล </h5>
                                    <li>ป้อนหมายเลขไอดีของบัตรสมาชิกได้</li>
                                    <li>ป้อนชื่อลูกค้าได้ </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 mt-3">
                        <div class="card p-2">
                            <table class="table table-sm" id="example1">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>หมายเลขบัตร</th>
                                        <th>เรียกดูข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody id="searchresult">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include './layout/footer.php'; $conndb = null; ?>

</body>
</html>

<script>
    $(document).ready(function() {
        $("#txt_input").keyup(function() {
            let input = $(this).val();
            console.log(input);
            if (input != '') {
                $.ajax({
                    url: 'searchSql.php',
                    method: 'post',
                    data: {
                        input: input
                    },
                    success: function(data) {
                        $("#searchresult").html(data);
                        console.log(data)
                    }
                });
            } else {
                $("#searchresult").html('<p> Not found </p>');
            }
        });
    });

    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
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
</script>

