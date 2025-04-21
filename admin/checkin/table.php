<table class="table table-sm table-hover py-2">
    <thead>
        <tr>
            <th> No </th>
            <th> CardID </th>
            <th> Full Name </th>
            <th> Package </th>
            <th> Date / time </th>
            <th> view </th>
            <th class="text-center"> Expire Day </th>
            <th class="text-center"> Action </th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once '../includes/connection.php';
        $sql_data = $conndb->query("SELECT `checkin_id`, `checkin_card_number`, `checkin_group_type`, `checkin_customer_name`, `checkin_product`, `checkin_time`, `checkin_expriy` FROM `checkin`
            WHERE DATE(`checkin_time`) = CURDATE()
            ORDER BY checkin_time DESC LIMIT 15");
        $sql_data->execute();
        $result = $sql_data->fetchAll(PDO::FETCH_ASSOC);
        $count = 1;
        foreach ($result as $row) { ?>  

            <tr>    
            <td><?= $count++; ?></td>
            <td><?= htmlspecialchars($row['checkin_card_number']); ?> </td>
            <td><?= htmlspecialchars($row['checkin_customer_name']); ?> </td>

            <!-- ชื่อสินค้า -->
            <td style="color: green; font-weight: 600;">
                <?= htmlspecialchars($row['checkin_product']); ?>
            </td>

            <td><?= date('H:i:s', strtotime($row['checkin_time'])); ?> </td>

            <td>
                <?php if ($row['checkin_group_type'] == 1) { ?>

                <a href="editmember.php?id=<?= $row['checkin_card_number'] ?>" target="_blank" class="btn btn-sm" id="customer"><i class="fas fa-street-view"></i></a>

                <?php } elseif ($row['checkin_group_type'] == 2) { ?>

                <a href="showBill.php?ref_order_id=<?= $row['checkin_card_number'] ?>" target="_blank" class="btn btn-sm" id="daypass"><i class="fas fa-street-view"></i></a>

                <?php } ?>
            </td>

            <!-- EXPIRE DAY -->
            <td class="text-center">
                <?php
                $today = date('Y-m-d');
                if ($row['checkin_expriy'] > $today) { ?>
                <button class="btn btn-success btn-sm" id="exp"><?= date('d/m/Y', strtotime($row['checkin_expriy'])); ?></button>
                <?php } elseif ($row['checkin_expriy'] == $today) { ?>
                <button class="btn btn-warning btn-sm" id="exp" onclick="exp1()"><?= date('d/m/Y', strtotime($row['checkin_expriy'])); ?></button>
                <?php } else { ?>
                <button class="btn btn-danger btn-sm" id="exp" onclick="exp2()">Expired <i class="fab fa-expeditedssl"></i></button>
                <?php } ?>
            </td>

            <td class="text-center">
                <button class="btn btn-danger btn-sm delete_btn" id="<?= $row['checkin_id']; ?>"><i class="fas fa-trash-alt"></i></button>
            </td>

        <?php } ?>
        </tr>
        <?php if (empty($result)) { ?>
            <tr>
                <td colspan="8" class="text-center">No data available</td>
            </tr>
        <?php } ?>
        </tr>
    </tbody>
</table>
