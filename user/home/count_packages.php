<?php 
    require_once '../includes/connection.php';
    $stmt = $conndb->query("SELECT  m.package , COUNT(t.ref_m_card) , m.group , t.time
    FROM tb_time AS t
    LEFT JOIN member AS m ON t.ref_m_card = m.m_card
    WHERE  date(t.time) =curdate() AND m.group = 'customer'
    GROUP BY package
    ORDER BY COUNT(m.package) DESC");
    $stmt->execute();
    $query_run = $stmt->fetchAll();
?>
<div class="card p-1 shadow">
    <div class="card-header bg-success" style="text-transform: uppercase;">
        Customer come in today
    </div>
    <table class="table table-sm table-hover" style="cursor: pointer;">
        <thead>
            <tr style="text-transform: uppercase;">
                <th>NO.</th>
                <th>TYPE</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach ( $query_run as $row ) :?>
            <tr>
                <td><?= $i++ .'.';?></td>
                <td><?= $row['package'] ?></td>
                <td style="text-align:center ;">
                    <span class="badge badge-success d-block p-1 text-center"><?= $row[1] ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
