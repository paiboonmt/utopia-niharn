<?php 
    require_once '../includes/connection.php';
    $stmt = $conndb->query("SELECT * FROM `totel` ORDER BY id DESC LIMIT 15");
    $stmt->execute();
    $query_run = $stmt->fetchAll();
?>
<div class="card p-1">
    <div class="card-header bg-info" style="text-transform: uppercase;">
        customers per day
    </div>
    <table class="table table-sm table-hover" style="cursor: pointer;">
        <thead>
            <tr style="text-transform: uppercase;">
                <th>NO.</th>
                <th>Day</th>
                <th class="text-center">Quantity</th>
            </tr>
        </thead>

        <tbody>
            <?php

                $i = 1;
                foreach ( $query_run as $row ) :?>

                <tr>
                    <td><?php echo $i++ .'.';?></td>
                    <td><?php echo date('d/m/Y',strtotime($row['date']))?></td>
                    <td class="text-center">
                        <span class="badge badge-info d-block p-1 text-center"><?php echo $row['quantity'] ?></span>
                    </td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>
</div>
