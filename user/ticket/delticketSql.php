<?php 
  session_start();
  include './middleware.php';
  include_once('../includes/connection.php');
  if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $stmt = $conndb->query("SELECT * FROM member WHERE `fname` LIKE '{$input}%' OR  `m_card` LIKE '{$input}%' OR  `package` LIKE '{$input}%' ");
    $stmt->execute();
    if ($stmt -> rowCount() > 0) { ?>
    <table class="table">
        <thead class="table table-sm" id="myTable">
            <tr>
              <th>Card id</th>
              <th>Packages</th>
              <th>Group</th>
              <th>Image</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stmt as $row ) { ?>
            <tr>
                <td><?= $row['m_card'] ?></td>
                <td><?= $row['package'] ?></td>
                <td><?= $row['group'] ?></td>
                <?php if ( $row['group'] == 'customer') { ?>
                  <?php if ( $row['package'] == 'Day Pass') { ?>
                    <td>
                      <a href="#"><img src="<?= 'http://172.16.0.3/memberimg/img/' . $row['image']; ?>" width="60" height="60"></a>
                    </td>
                  <?php } else { ?>
                    <td>
                    <a href="member_profile.php?id=<?= $row['id']; ?>" target="_bank"><img src="<?= 'http://172.16.0.3/memberimg/img/' . $row['image']; ?>" width="60" height="60"></a>
                    </td>
                  <?php } ?>

                <?php } else { ?>
                  <td>
                  <a href="fighter_profile.php?id=<?= $row['id'] ?>" target="_bank"><img src="<?= 'http://172.16.0.3/fighterimg/img/' . $row['image'] ?>" width="60" height="60"></a>
                  </td>
                <?php } ?>
                
                <td><?= $row['fname'] ?></td>
                <td>
                  <a href="./delticketSql.php?id=<?= $row['id'];?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php  } ?>
        </tbody>
    </table>
<?php }
}  
else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM `member` WHERE id = :id";
    $stmt = $conndb->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    header('location:sale.php');
}


$conndb = null; 


?>