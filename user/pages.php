<div class="card mt-2">
    <div class=" p-2">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="#Profile" data-toggle="tab">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab">File Document</a></li>
            <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Checkin history</a></li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">

            <div class="tab-pane active" id="Profile">
                <div class="row">
                    <div class="col">
                        <div class="card p-1">
                            <div class="row">

                                <div class="col-md-8">

                                    <div class="row mb-2">
                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"> Status </span>
                                                </div>
                                                <!-- ส่งหมายเลขบัตร  -->
                                                <?php
                                                if ($result[0]['exp_date'] >= $today ) { ?>
                                                    <input type="text" class="form-control bg-success" value="Active">
                                                <?php } else { ?>
                                                    <input type="text" class="form-control bg-danger" value="Expired">
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-danger">Emergency</span>
                                                </div>
                                                <input type="text" class="form-control" name="emergency" value="<?= $result[0]['emergency'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Member Card id</span>
                                                </div>
                                                <!-- ส่งหมายเลขบัตร  -->
                                                <input type="text" class="form-control" value="<?= $result[0]['m_card'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Passport | Visa | ID</span>
                                                </div>
                                                <!-- ส่งหมายเลข invoice -->
                                                <input type="text" class="form-control" name="invoice" value="<?= $result[0]['p_visa'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">

                                        <div class="input-group col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Gender</span>
                                                </div>
                                                <!-- ส่ง เพศ -->
                                                <select name="sex" class="form-control">
                                                    <option selected><?= $result[0]['sex'] ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">First and last name</span>
                                                </div>
                                                <input type="text" class="form-control" name="fname" value="<?= $result[0]['fname'] ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Birth Day</span>
                                                </div>
                                                <input type="date" class="form-control" name="birthday" value="<?= $result[0]['birthday'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Age</span>
                                                </div>
                                                <input type="number" class="form-control" name="age" value="<?= $u_y ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row mb-2">

                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Email</span>
                                                </div>
                                                <input type="email" class="form-control" name="email" value="<?= $result[0]['email'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col-md-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Nationality</span>
                                                </div>
                                                <input type="text" name="nationalty" class="form-control" value="<?= $result[0]['nationalty'] ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <!-- ************************************ -->
                                    <div class="form-row mb-2">

                                        <div class="input-group col-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Height</span>
                                                </div>
                                                <input type="text" class="form-control" value="<?= $result[0]['height'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col-6">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Weigh</span>
                                                </div>
                                                <input type="text" class="form-control" value="<?= $result[0]['weigh'] ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- ************************************ -->

                                    <div class="form-row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Phone</span>
                                                </div>
                                                <input type="number" class="form-control" name="phone" value="<?= $result[0]['phone'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">FIGHTER NAME</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['fightname'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Vaccine</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['vaccine'] ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">TENURE OF AGREEMENT</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['tenure'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-secondary">TYPE OF TRAINING</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['type_training'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-secondary">TYPE OF FIGHTER</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['type_fighter'] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">BENNEFITS</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['sponsored'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">COMMISSION</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['commission'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">AFFILIATE</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['affiliate'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">MEALPLAN</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['mealplan_month'] ?>">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">FACEBOOK</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['facebook'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">INSTAGRAM</span>
                                                </div>
                                                <input type="text" class="form-control" name="phone" value="<?= $result[0]['instagram'] ?>">
                                            </div>
                                        </div>

                                    </div>


                                    <!-- ************************************ -->
                                    <div class="form-row mb-2">

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-cyan">Start Training</span>
                                                </div>
                                                <input type="date" class="form-control" name="sta_date" value="<?= $result[0]['sta_date'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-cyan">Expiry date</span>
                                                </div>
                                                <input type="date" class="form-control" name="exp_date" value="<?= $result[0]['exp_date'] ?>">
                                            </div>
                                        </div>

                                        <div class="input-group col">
                                            <?php if ($df < 0) { ?>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-cyan">Expiry date</span>
                                                </div>
                                                <input type="text" class="form-control bg-danger text-center" value="<?= $df ?>">
                                            <?php } else { ?>
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-cyan">WILL EXPIRY IN</span>
                                                </div>
                                                <input type="text" class="form-control bg-success text-center" value="<?= $df ?>">
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <!-- ************************************ -->
                                    <div class="form-row mb-2">
                                        <div class="input-group col-md-6">
                                            <textarea name="comment" cols="30" rows="6" class="form-control" placeholder="Comments here!"><?= $result[0]['comment'] ?></textarea>
                                        </div>
                                        <div class="input-group col-md-6">
                                            <textarea name="accom" cols="30" rows="6" class="form-control" placeholder="Accommodation / Address input here!"><?= $result[0]['accom'] ?></textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4 text-center">
                                    <div class="form-row justify-content-center mb-2">
                                        <img src="<?= 'http://172.16.0.3/fighterimg/img/' . $result[0]['image'] ?>" width="75%" class="img-thumbnail">
                                    </div>
                                    <div class="col-4 text-center">
                                        <input type="hidden" class="form-control" value="<?= $result[0]['image'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="file">
                <div class="row mb-1">
                    <div class="col">
                        <div class="card">
                            <div class="card-header py-2">
                                <h5>Files</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_qury_files = $conndb->query("SELECT * FROM tb_files WHERE product_id = $id ");
                                        $sql_qury_files->execute();
                                        $result_files = $sql_qury_files->fetchAll();
                                        foreach ($result_files as $datar) { ?>
                                            <tr>
                                                <td>
                                                    <a class="mr-2" href="#" data-fancybox="gallery" data-src="<?= 'http://172.16.0.3/fighterimg/file/' . $datar['image'] ?>"><img src="<?= '../fighterimg/file/' . $datar['image'] ?>" width="100" height="100" /></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tab-pane" id="history">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-sm" id="time_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>card id </th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                $sql = "SELECT t.time,t.ref_m_card
                                            FROM `tb_time` AS t
                                            INNER JOIN `member` AS m 
                                            ON t.ref_m_card = m.m_card
                                            WHERE m.m_card = ? order by time desc";
                                $result2 = $conndb->prepare($sql);
                                $result2->bindParam(1, $result[0]['m_card']);
                                $result2->execute();
                                $fetchData = $result2->fetchAll();

                                foreach ($fetchData as $row11) :
                                ?>
                                    <tr>
                                        <td><?= $cnt++ ?></td>
                                        <td><?= $row11['ref_m_card'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($row11['time'])) ?></td>
                                        <td><?= date('H:i:s', strtotime($row11['time'])) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>