<?php include('assets/includes/header.php') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 sadow">
        <div class="card_header">
            <h4 class="mb-0">Add Order
                <a href="orders.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <form action="orders-code.php" method="POST">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="">Select Product</label>
                        <select name="product_id" class="form-select">
                            <option value="">--Select Product--</option>
                            <?php
                            $products = getAll('products');
                            if ($products){
                              if(mysqli_num_rows($products) > 0){
                                foreach($products as $proItem){
                                    echo '<option value="'.$proItem['id'].'">'.$proItem['name'].'</option>';
                                }
                                
                              }else{
                                echo '<option value="">No Product Found</option>';

                              }

                            }else{
                                echo '<option value="">Something Went Wrong</option>';

                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" value="1" class="form-control" >
                    </div>
                    <div class="col-md-3 mb-3 text-end">
                        <br/>    
                    <button type="submit" name="saveOrder" class="btn btn-primary">Order</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="card mt-3">
        <di class="card-header">
            <h1 class="mb-0">Products </h1>
            <div class="card-body">
                <?php
                    if(isset($_SESSION['productItems'])){
                        $sessionProducts = $_SESSION['productItems'];
                        ?>
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $i=1;
                                     foreach($sessionProducts as $key => $Item ) : ?>
                                    <tr>
                                        <td><?= $i++ ;?></td>
                                        <td><?= $Item['name'] ;?></td>
                                        <td><?= $Item['price'] ;?></td>
                                        <td>
                                            <div class="input-group qtyBox">
                                                <input type="hidden" value="<?= $Item['product_id'] ;?>" class="proId"/>
                                                <button class="input-group-text decrement" >-</button>
                                                <input type="text" value="<?= $Item['quantity'] ;?>" class="qty quantityInput">
                                                <button class="input-group-text increment " >+</button>
                                            </div>
                                        </td>
                                        <td><?= $Item['price'] * $Item['quantity'];?></td>
                                        <td>
                                        <a href="order-item-delete.php?index=<?= $key ?>" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }else{
                        echo'<h5>No Items  added</h5>';
                    }
                ?>
            </div>
        </di>
    </div>
    
</div>
<?php include('assets/includes/footer.php') ?>