<?php include('assets/includes/header.php') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <div class="card mt-4 shadow">
        <div class="card_header">
            <h4 class="mb-0">Order View
                <a href="orders.php" class="btn btn-danger mx-2 btn-sm float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php

            if (isset($_GET['track'])) {

                $trackingNo = validate($_GET['track']);
                $query = "SELECT o.*, c.* FROM orders o, customers c WHERE o.tracking_no = '$trackingNo' AND c.id = o.customer_id ORDER BY o.id DESC";
                $orders = mysqli_query($conn, $query);

                if ($orders) {

                    if (mysqli_num_rows($orders) > 0) {

                        $orderData = mysqli_fetch_assoc($orders);
                        $orderId = $orderData['id'];
            ?>

                        <div class="card card-body shadow border-1 mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Order Details</h4>
                                    <label class="mb-1">
                                        Tracking No:
                                        <span class="fw-bold"><?= $orderData['tracking_no']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Order Date:
                                        <span class="fw-bold"><?= $orderData['order_date']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Order Status:
                                        <span class="fw-bold"><?= $orderData['order_status']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Payment Mode:
                                        <span class="fw-bold"><?= $orderData['payment_mode']; ?></span>
                                    </label>
                                    <br />
                                </div>
                                <div class="col-md-6">
                                    <h4>User Details</h4>
                                    <label class="mb-1">
                                        Name:
                                        <span class="fw-bold"><?= $orderData['name']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Email:
                                        <span class="fw-bold"><?= $orderData['email']; ?></span>
                                    </label>
                                    <br />
                                    <label class="mb-1">
                                        Phone:
                                        <span class="fw-bold"><?= $orderData['phone']; ?></span>
                                    </label>
                                    <br />
                                </div>
                            </div>
                        </div>
                        <?php

                        $orderItemQuery = "SELECT 
                                            oi.quantity as orderItemQuantity, 
                                            oi.price as orderItemPrice, 
                                            o.*, 
                                            oi.*, 
                                            p.name as productName 
                                        FROM 
                                            orders as o
                                        JOIN 
                                            order_items as oi ON oi.order_id = o.id
                                        JOIN 
                                            products as p ON p.id = oi.product_id 
                                        WHERE 
                                            o.tracking_no = '$trackingNo'";

                        $orderItemRes = mysqli_query($conn, $orderItemQuery);
                        if ($orderItemRes) {

                            if (mysqli_num_rows($orderItemRes) > 0) {
                                $totalPrice = 0; // Variável para acumular o total

                        ?>

                                <h4 class="my-3">Order Items Details</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItemRes as $orderItemRow) : 
                                            $itemTotal = $orderItemRow['orderItemPrice'] * $orderItemRow['orderItemQuantity'];
                                            $totalPrice += $itemTotal;
                                        ?>

                                            <tr>
                                                <td>
                                                    <?= $orderItemRow['productName']; ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= number_format($orderItemRow['orderItemPrice'], 0); ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= $orderItemRow['orderItemQuantity']; ?>
                                                </td>
                                                <td width="15%" class="fw-bold text-center">
                                                    <?= number_format($itemTotal, 0); ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td class="text-end fw-bold">Total Price: </td>
                                            <td colspan="3" class="text-end fw-bold">Rs: <?= number_format($totalPrice, 0); ?></td>
                                        </tr>
                                    </tbody>
                                </table>

            <?php
                            }
                        }
                    } else {

                        echo '<h5>No Record Found!</h5>';
                        return false;
                    }
                } else {
                    echo '<h5>Something Went Wrong!</h5>';
                }
            }


            ?>
        </div>
    </div>
</div>

<?php
include('assets/includes/footer.php')
?>
