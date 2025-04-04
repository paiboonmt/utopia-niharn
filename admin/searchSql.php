<?php 
  session_start();
  include './middleware.php';
  include_once('../includes/connection.php');

  if (isset($_POST['input'])) {

    $input = $_POST['input'];
    $sql = "SELECT m.m_card , m.image , m.fname , m.status_code , m.id AS mid , m.sta_date ,m.exp_date , m.package , m.type_training,
    p.id AS pid , p.product_name   
    FROM member AS m
    LEFT JOIN products AS p ON m.package = p.id 
    WHERE m.fname LIKE '%{$input}%' 
    OR  m.m_card LIKE '%{$input}%' ";

    $stmt = $conndb->query($sql);
    $stmt->execute(); 
    $data = $stmt->fetchAll();

    $count = $stmt->rowCount();

    foreach ( $data as $row ) { ?>
      <tr>
        <?php if ( $data[0]['status_code'] == 1) :?>
          <td>
            <a href="recordticketEdit.php?id=<?= $row['package'] ?>" target="_blank" class="btn btn-info"><i class="fas fa-street-view"></i></a>
          </td>
        <?php elseif ( $data[0]['status_code'] == 2 ) :?> 
          <td>
            <a href="member_profile.php?id=<?= $row['mid'] ?>" target="_blank" class="btn btn-success"><i class="fas fa-street-view"></i></a>
          </td>
        <?php elseif ( $data[0]['status_code'] == 3 ) :?> 
          <td>
            <a href="fighter_profile.php?id=<?= $row['mid'] ?>" target="_blank" class="btn btn-danger"><i class="fas fa-street-view"></i></a>
          </td>
        <?php elseif ( $data[0]['status_code'] == 4 ) :?> 
          <td>
            <a href="member_profile.php?id=<?= $row['mid'] ?>" target="_blank" class="btn btn-warning"><i class="fas fa-street-view"></i></a>
          </td>
        <?php endif; ?> 

        <td><?= $row['m_card'] ?></td>
        <td><?= $row['fname'] ?></td>
 
        <?php if ( $data[0]['status_code'] == 1 ) : ?>
          <td><?= 'Ticket' ?></td>
        <?php elseif ( $data[0]['status_code'] == 2 ) : ?>
          <td><?= $row['package'] ?></td>
        <?php elseif ( $data[0]['status_code'] == 3 ) : ?>
          <td><?= $row['type_training'] ?></td>
        <?php elseif ( $data[0]['status_code'] == 4 ) : ?>
          <td><?= $row['product_name'] ?></td>
        <?php endif ?> 
        <td><?= $row['sta_date'] ?></td>
        <td><?= $row['exp_date'] ?></td>
      </tr>

    <?php }  

  } 
  
  $conndb = null;
?>

