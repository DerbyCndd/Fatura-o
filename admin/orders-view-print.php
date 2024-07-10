<?php include('assets/includes/header.php') ?>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card_header">
            <h4 class="mb-0">Print Order
                <a href="product.php" class="btn btn-primary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            <?php
            if (isset($_GET['track'])) {

                $trackingNo = validate($_GET['track']);
                if ($trackingNo == '') {
            ?>
                    <div class="text-center py-5">
                        <h5>No Tracking Number Parameter Found</h5>
                        <div>
                            <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                        </div>
                    </div>
            <?php
                } else {
                    $orderQuery = "SELECT o.*, c.* FROM orders o, customers c
                                WHERE c.id = o.customer_id 
                                AND o.tracking_no = '$trackingNo' LIMIT 1";
                    $orderQueryRes = mysqli_query($conn, $orderQuery);

                    if (!$orderQueryRes) {
                        echo "<h5>Something Went Wrong</h5>";
                        return false;
                    }

                    if (mysqli_num_rows($orderQueryRes) > 0) {
                        $orderDataRow = mysqli_fetch_assoc($orderQueryRes);
            ?>
                        <table style="width: 100%; margin-bottom: 20px;">

                            <tbody>
                                <tr>
                                    <td style="text-align: center;" colspan="2">
                                        <h4 style="font-size: 23px; line-height: 30px; margin:2px; padding: 0;">FATURAÇÃO</h4>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;"> Kilamba, Luanda, Angola</p>
                                        <p style="font-size: 16px; line-height: 24px; margin:2px; padding: 0;">FATURAÇÃO ltd.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Customer Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Name: <?= $orderDataRow['name']; ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Phone No.: <?= $orderDataRow['phone']; ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Customer Email Id: <?= $orderDataRow['email']; ?></p>
                                    </td>
                                    <td align="end">
                                        <h5 style="font-size: 20px; line-height: 30px; margin:0px; padding: 0;">Invoice Details</h5>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice No.: <?= $orderDataRow['tracking_no']; ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Invoice Date: <?= date('d M Y'); ?></p>
                                        <p style="font-size: 14px; line-height: 20px; margin:0px; padding: 0;">Address: Kilamba, Luanda</p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <?php

                        $orderItemQuery = "SELECT oi.quantity as orderItemQuantity, oi.price as orderItemPrice, p.name as productName 
                                        FROM order_items oi 
                                        JOIN products p ON p.id = oi.product_id 
                                        JOIN orders o ON o.id = oi.order_id 
                                        WHERE o.tracking_no = '$trackingNo'";

                        $orderItemQueryRes = mysqli_query($conn, $orderItemQuery);

                        if ($orderItemQueryRes) {
                            if (mysqli_num_rows($orderItemQueryRes) > 0) {
                                $totalPrice = 0; // Variável para acumular o total
                        ?>
                                <div class="table-responsive mb-3">
                                    <table style="width: 100%;" cellpadding="5">
                                        <thead>
                                            <tr>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Price</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                                <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($orderItemQueryRes as $row) :
                                                $itemTotal = $row['orderItemPrice'] * $row['orderItemQuantity'];
                                                $totalPrice += $itemTotal;
                                            ?>
                                                <tr>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $i++; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $row['productName']; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['orderItemPrice'], 0); ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;"><?= $row['orderItemQuantity']; ?></td>
                                                    <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                        <?= number_format($itemTotal, 0); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="4" align="end" style="font-weight: bold;">Grand Total:</td>
                                                <td colspan="1" style="font-weight: bold;"><?= number_format($totalPrice, 0); ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Payment Mode: <?= $orderDataRow['payment_mode']; ?></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>

                        <?php
                            } else {
                                echo "<h5>No data found</h5>";
                                return false;
                            }
                        } else {
                            echo "<h5>Something Went Wrong</h5>";
                            return false;
                        }
                    } else {
                        echo "<h5>No Data Found</h5>";
                        return false;
                    }
                }
            } else {
                ?>
                <div class="text-center py-5">
                    <h5>No Tracking Number Parameter Found</h5>
                    <div>
                        <a href="orders.php" class="btn btn-primary mt-4 w-25">Go back to orders</a>
                    </div>
                </div>

            <?php
            }
            ?>

        </div>
    </div>
</div>

<?php
include('assets/includes/footer.php')
?>
