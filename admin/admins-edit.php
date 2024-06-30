<?php include('assets/includes/header.php') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 sadow">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST">

                <?php
                $adminId = checkParamId('id');
                $adminData = GetById('admins', $adminId);
                if ($adminData) {
                    if ($adminData['status'] == 200) {
                ?>

                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id'];?>">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" required value="<?= $adminData['data']['name'];?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <input type="text" name="email" required value="<?= $adminData['data']['email'];?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password *</label>
                                <input type="password" name="password" required value="<?= $adminData['data']['password'];?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Phone Number *</label>
                                <input type="number" name="phone" required value="<?= $adminData['data']['phone'];?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Is Ban *</label>
                                <input type="checkbox" name="is_ban" <?= $adminData['data']['is_ban'] == true ? 'checked':'' ; ?> style="width: 30px;height: 30px;" />
                            </div>
                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>'.$adminData['message'] . '</h5>';
                    }
                } else {
                    echo 'Something Went Wrong';
                    return false;
                }
                ?>
            </form>

        </div>
    </div>
</div>
<?php include('assets/includes/footer.php') ?>