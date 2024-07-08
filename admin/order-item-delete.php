<?php

require '../config/funtion.php';
$paramResult = checkParamId('index');

if(is_numeric($paramResult)){

    $indexValue = validate($paramResult);
    
    if((isset($_SESSION['productItems'])) && isset($_SESSION['productItemIds'])){

        unset($_SESSION['productItems'][$indexValue]);
        unset($_SESSION['productItemIds'][$indexValue]);
        
        redirect('order-creat.php','Item Removed');

    }else{

        redirect('order-item-delete.php','There is no param');
    }
}else{

    redirect('order-item-delete.php','param not numeric');
}

?>