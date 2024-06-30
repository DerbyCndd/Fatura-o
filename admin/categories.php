<?php include('assets/includes/header.php'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 sadow">
        <div class="card_header">
            <h4 class="mb-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $categories = getAll('categories');
            if(!$categories){
                echo'<h4>Something Went Wrong</h4>';
                return false;
            }
            if (mysqli_num_rows($categories) > 0) {
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

                            <?php foreach ($categories as $categoryItem) : ?>
                                <tr>
                                    <td><?= $categoryItem['id'] ?> </td>
                                    <td><?= $categoryItem['name'] ?> </td>
                                    <td>
                                    <td>
                                        <?php
                                        if($categoryItem['status']==1){
                                            echo '<span class="badge bg-danger" >Hidden</span>';
                                        }else{
                                            echo '<span class="badge bg-primary" >Visible</span>';
                                        }
                                        ?>

                                    </td>

                                        <a href="admins-edit.php?id=<?= $categoryItem['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <a href="admins-delete.php?id=<?= $categoryItem['id']; ?>" class="btn btn-danger btn-sm">Delete</a>

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
<?php include('assets/includes/footer.php') ?>