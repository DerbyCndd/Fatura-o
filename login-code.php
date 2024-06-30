<?php

require __DIR__.'../../../htdocs/Fatura/config/funtion.php';

if(isset($_POST['loginBtn'])){
    
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    if($email != '' && $password != '' ){

        $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1 ";
        $result = mysqli_query($conn,$query);

        if($result){

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password']; 

                if(!password_verify($password,$hashedPassword)){
                    redirect('login.php', 'Invalid Password');
                }
                if($row['is_ban'] == 1){
                    redirect('login.php', 'Your Account has been banned ');
                }
                
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone']
                ];
                
                redirect('admin/index.php', 'Logged In Successfuly');                


            }else{
                redirect('login.php', 'Invalid Email Adress');                
            }

        }else{
            redirect('login.php', 'Something Went Wrong');
        }
    }

}





?>