<?php 
  include './middleware.php';
  include_once('../includes/connection.php');

  if (isset($_POST['input'])) {

    $input = $_POST['input'];
    $sql = "SELECT * FROM `group_type` WHERE `number` LIKE '%{$input}%'";

    $stmt = $conndb->query($sql);
    $stmt->execute(); 
    $data = $stmt->fetchAll();

    $count = $stmt->rowCount();
    $i = 1;
    foreach ( $data as $row ) { ?>
     <tr>
      <td><?= $i++ ?></td>
      <td><?= $row['number']; ?></td>
      <td>
        <?php if ( $row['value'] == 1 ) : ?>
          <a href="viewbill.php?id=<?= $row['number'] ?>" class="btn btn-success">
          <i class="fas fa-binoculars"></i>
          </a>
        <?php else : ?>
          <a href="recordticketEdit?id=<?= $row['number'] ?>" class="btn btn-danger">
          <i class="fas fa-binoculars"></i>
          </a>
        <?php endif ?>
      </td>
     </tr>

    <?php } 

  } 
  
  $conndb = null;
?>

