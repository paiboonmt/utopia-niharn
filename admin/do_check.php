<?php 
    include '../includes/connection.php';
    if (isset($_POST['input'])) {
        $input = $_POST['input'];
        $stmt = $conndb->query("SELECT * FROM member WHERE `fname` LIKE '{$input}%' OR  `m_card` LIKE '{$input}%' OR  `package` LIKE '{$input}%' ");
        $stmt->execute();

        if ($stmt -> rowCount() > 0) { ?>
<table class="table">
    <thead class="table table-sm" id="myTable">
        <tr>
            <th>id</th>
            <th>card</th>
            <th>fname</th>
            <th>Group</th>
            <th>View</th>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($stmt as $row ) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['m_card'] ?></td>
            <td><?= $row['fname'] ?></td>
            <td><?= $row['group'] ?></td>
            <td>
                <?php 
                    if ($row['group'] == 'customer'){ ?>
                    <a href="member_profile.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm" target="_bank"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                <?php } else { ?>
                    <a href="fighter_profile.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" target="_bank"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                <?php } ?>
            </td>

        </tr>
        <?php  } ?>
    </tbody>

</table>
<?php } } ?>