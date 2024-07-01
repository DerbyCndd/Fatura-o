<?php 
include __DIR__.'../../config/funtion.php';

if(isset($_POST['saveAdmin'])){
    
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;

    if($name != '' && $email != '' && $password != ''){
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('admin-create.php', 'Email já em uso.');
                exit();
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrypt_password,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = insert('admins', $data);
        if($result){
            redirect('admins.php', 'Admin Created');
        } else {
            redirect('admin-create.php', 'Something Went Wrong');
        }
    } else {
        redirect('admin-create.php', 'Preencha com dados válidos.');
    }
}

if(isset($_POST['updateAdmin'])){
    $adminId = validate($_POST['adminId']);
    $adminData = GetById('admins', $adminId);

    if($adminData['status'] != 200){
        redirect('admin-edit.php?id=' . $adminId, 'Preencha com dados válidos.');
        exit();
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = validate($_POST['is_ban']) == true ? 1 : 0;

    if($password != ''){
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if($name != '' && $email != ''){
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);
        if($result){
            redirect('admin-edit.php?id=' . $adminId, 'Admin Updated');
        } else {
            redirect('admin-edit.php?id=' . $adminId, 'Something Went Wrong');
        }
    } else {
        redirect('admin-edit.php?id=' . $adminId, 'Preencha com dados válidos.');
    }
}

if(isset($_POST['saveCategory'])){
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status,
    ];
    $result = insert('categories', $data);
    if($result){
        redirect('categories.php', 'Category Created');
    } else {
        redirect('categories-create.php', 'Something Went Wrong');
    }
}

if(isset($_POST['saveProduct'])){
        
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;


    

    $data = [
        'category_id' =>(int) $category_id,
        'name' => $name,
        'description' => $description,
        'price' => (int)$price,
        'quantity' => (int)$quantity,
        'status' => $status
    ];
    
    registar($data);
    redirect('products-create.php?id='.$product_id, 'Update Created');

    
}

if(isset($_POST['updateProduct'])){


    $product_id = validate($_POST['product_id']);

    $productData = GetById('products', $product_id);
    if(!$productData){
        redirect('product.php','No such product found');
    }

    $category_id = validate($_POST['categoryid']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;


    $data = [
        'categoryid' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => (int)$price,
        'quantity' => (int)$quantity,
        'status' => $status
    ];

    
        updateProduct($data, $productId); 
        redirect('products-edit.php?id='.$product_id, 'Update Created');
    
}


if(isset($_POST['saveCustomers'])){
    
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) == true ? 1 : 0;

    if($name != '' ){
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('customers-creat.php', 'Email já em uso.');
                exit();
            }
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status
        ];
        $result = insert('customers', $data);
        if($result){
            redirect('customers.php', 'Customer Created');
        } else {
            redirect('customers-creat.php', 'Something Went Wrong');
        }
    } else {
        redirect('customers-creat.php', 'Preencha com dados válidos.');
    }
}



?>
