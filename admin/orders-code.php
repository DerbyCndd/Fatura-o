<?php
    include __DIR__ . '../../config/funtion.php';

    session_start(); 
    
    if (!isset($_SESSION['productItems'])) {
        $_SESSION['productItems'] = [];
    }

    if (!isset($_SESSION['productItemIds'])) {
        $_SESSION['productItemIds'] = [];
    }

    if (isset($_POST['saveOrder'])) {
        $productId = validate($_POST['product_id']);
        $quantity = validate($_POST['quantity']);

        $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId' LIMIT 1");

        if ($checkProduct) {
            if (mysqli_num_rows($checkProduct) > 0) {
                $row = mysqli_fetch_assoc($checkProduct);
                if ($row['quantity'] < $quantity) {
                    redirect('order-creat.php', 'Only ' . $quantity . ' Available');
                }

                $productData = [
                    'product_id' => $row['id'],
                    'name' => $row['name'],
                    'price' => $row['price'],
                    'quantity' => $quantity // Corrigido para adicionar a quantidade correta
                ];

                if (!in_array($row['id'], $_SESSION['productItemIds'])) {
                    array_push($_SESSION['productItemIds'], $row['id']);
                    array_push($_SESSION['productItems'], $productData);
                } else {
                    foreach ($_SESSION['productItems'] as $key => $prodSessionItem) {
                        if ($prodSessionItem['product_id'] == $row['id']) {
                            $newQuantity = $prodSessionItem['quantity'] + $quantity;
                            $productData = [
                                'product_id' => $row['id'],
                                'name' => $row['name'],
                                'price' => $row['price'],
                                'quantity' => $newQuantity
                            ];
                            $_SESSION['productItems'][$key] = $productData;
                        }
                    }
                }
                redirect('order-creat.php', 'Item Added ' . $row['name']);
            } else {
                redirect('order-creat.php', 'No Product Found');
            }
        } else {
            redirect('order-creat.php', 'Something Went Wrong');
        }
    }


    if(isset($_POST['productIncDec'])){

        $productId = validate($_POST['product_id']);
        $quantity = validate($_POST['quantity']);


        $flag = false;
        foreach( $_POST['productItems'] as $key => $item  ){

            if($item['$product_id'] == $productId){
                $flag = true;   
                $_SESSION['productItems'][$key]['$quantity'] == $quantity;
            }
        }

        if($flag){
           
             json_encode(200,'success', 'Udpdated');
            ;
        }else{
            json_encode(500,'error', 'Something Went Wrong');

        }


    }

    if(isset($_SESSION['proceedToPlaceBtn'])){

        $phone = validate($_POST['cphone']);
        $payment_mode = validate($_POST['payment_mode']);

        $checkCustomer = mysqli_query($conn, " SELECT * FROM customers WHERE phone  = '$phone' LIMIT 1 " );
        if($checkCustomer){

            if(mysqli_num_rows($checkCustomer) > 0){
                $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
                $_SESSION['cphone'] = $phone;
                $_SESSION['payment_mode'] = $payment_mode;
                jsonResponse(200,'success','Customer Found');

            }else{
                $_SESSION['cphone'] = $phone;
                jsonResponse(404,'warning','Customer Not Found');

            }
        }else{

            jsonResponse(500,'error','Something Went Wrong');
        }
    }


?>
