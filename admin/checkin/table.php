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
        $sql_data = $conndb->query("SELECT m.id as mid , m.m_card , m.fname , m.image , m.product_name,
                t.time , t.time_id , m.exp_date , m.image , o.id as orderid , od.product_name as odproduct_name, g.value 
                FROM tb_time AS t   
                INNER JOIN customer AS m ON t.ref_m_card = m.m_card
                LEFT JOIN group_type AS g ON m.m_card = g.number
                LEFT JOIN orders AS o ON m.m_card = o.ref_order_id
                LEFT JOIN order_details AS od ON o.id = od.order_id  
                WHERE date(t.time) = CURDATE() 
                ORDER BY t.time DESC LIMIT 15");
        $sql_data->execute();
        $count = 1;
        foreach ($sql_data as $row) : ?>

            <tr>
                <td><?= $count++; ?></td>
                <td><?= $row['m_card']; ?> </td>
                <td><?= $row['fname']; ?> </td>

                <!-- ชื่อสินค้า -->
                <?php if ($row['value'] == 1) : ?>
                    <td style="color: green ;font-weight: 600;"><?= $row['product_name'] ?> </td>
                <?php elseif ($row['value'] == 2) : ?>
                    <td style="color: green ;font-weight: 600;"><?= $row['product_name']; ?> </td>
                <?php endif ?>

                <td><?= date('H:i:s', strtotime($row['time'])); ?> </td>

                <?php if ($row['value'] == 1) : ?>

                    <td><a href="editmember.php?id=<?= $row['mid'] ?>" target="_blank" class="btn  btn-sm" id="customer"><i class="fas fa-street-view"></i></a></td>

                <?php elseif ($row['value'] == 2) : ?>

                    <td><a href="showBill.php?id=<?= $row['orderid'] ?>" target="_blank" class="btn btn-sm" id="daypass"><i class="fas fa-street-view"></i></a></td>

                <?php endif ?>


                <!-- EXPIRE DAY -->
                <td class="text-center">
                    <?php
                    $today = date('Y-m-d');
                    if ($row['exp_date'] > $today) { ?>
                        <button class="btn btn-success btn-sm " id="exp"><?= date('d/m/Y', strtotime($row['exp_date'])) ?></button>
                    <?php } elseif ($row['exp_date'] == $today) { ?>
                        <button class="btn btn-warning btn-sm" id="exp" onclick="exp1()"><?= date('d/m/Y', strtotime($row['exp_date'])) ?></button>
                    <?php } else { ?>
                        <button class="btn btn-danger btn-sm" id="exp" onclick="exp2()">Expired <i class="fab fa-expeditedssl"></i> </button>
                    <?php } ?>
                </td>

                <td class="text-center">
                    <button class="btn btn-danger btn-sm delete_btn" id="<?= $row['time_id']; ?>"><i class="fas fa-trash-alt"></i></button>
                </td>

            </tr>

        <?php endforeach; ?>
    </tbody>
</table>