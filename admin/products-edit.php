<?php include('assets/includes/header.php') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 sadow">
        <div class="card_header">
            <h4 class="mb-0">Edit Product
                <a href="product.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php
                $paramValue = checkParamId('id');
                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not a number</h5>';
                    return false;
                }
                $product = GetById('products', $paramValue);

                if ($product) {

                    if ($product['status'] == 200) {

                ?>

                        <input type="hidden"  name="product_id" value="<?=$product['data']['id'] ?>" >
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label>Select Category Id</label>
                                <select name="categoryid" class="form-select">
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories) {

                                        if (mysqli_num_rows($categories) > 0) {

                                            foreach ($categories as $cateItem) {
                                    ?>
                                                <option value="<?= $cateItem['id'] ?>">

                                                    <?= $product['data']['categoryid'] == $cateItem['id']  ? '' : '' ;?>

                                                    <?=$cateItem['name'];?>
                                                </option>
                                    <?php
                                            }
                                        } else {
                                            echo '<option value="">No Category Found</option>';
                                        }
                                    } else {
                                        echo '<option value="">Select Category</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Product Name *</label>
                                <input type="text" name="name" required value="<?= $product['data']['name'] ?>" class="form-control" />
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" rows="3"><?= $product['data']['description'] ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Price *</label>
                                <input type="number" name="price" required value="<?= $product['data']['price'] ?>" class="form-control" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="">Quantity *</label>
                                <input type="number" name="quantity" required value="<?= $product['data']['quantity'] ?>" class="form-control" />
                            </div>
                           
                            <div class="col-md-6">
                                <label>Status (UnChecked=Visible,Cheked=Hidden)</label>
                                <br />
                                <input type="checkbox" name="status" <?= $product['data']['status'] == true ? 'checked' : ''; ?> style="width:30px;height:30px" ;>

                            </div>
                            <div class="col-md-6 mb-3 text-end">
                                <br />
                                <button type="submit" name="updateProduct" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                <?php
                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something Went Wrong</h5>';
                    return false;
                }
                ?>
            </form>

        </div>
    </div>
</div>
<?php include('assets/includes/footer.php') ?>