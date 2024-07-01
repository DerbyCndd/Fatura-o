<?php include('assets/includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 sadow">
        <div class="card_header">
            <h4 class="mb-0">Customers
                <a href="customers-creat.php" class="btn btn-primary float-end">Add Customer</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $customers = getAll('customers');
            if(!$customers){
                echo'<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($customers) > 0) {
            ?>
                <div class="table-responsive">
                    <table class="table  table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($customers as $custItem) : ?>
                                <tr>
                                    <td><?= $custItem['id'] ?> </td>
                                    <td><?= $custItem['name'] ?> </td>
                                    <td>
                                    <td>
                                        <?php
                                        if($custItem['status']==1){
                                            echo '<span class="badge bg-danger" >Hidden</span>';
                                        }else{
                                            echo '<span class="badge bg-primary" >Visible</span>';
                                        }
                                        ?>
                                         <a href="admins-edit.php?id=<?= $custItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="admins-delete.php?id=<?= $custItem['id']; ?>" class="btn btn-danger btn-sm">Delete</a>

                                    </td>

                                       
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <h4 class="mb-0">No Record Found</h4>
            <?php
            }
            ?>
        </div>

    </div>
</div>
<?php include('assets/includes/footer.php'); ?>