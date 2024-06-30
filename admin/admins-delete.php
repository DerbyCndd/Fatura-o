<?php
include __DIR__.'../../config/funtion.php';

$result = checkParamId('id');

if(is_numeric($result)){
    $adminId = validate($result);
    $admin = GetById('admins', $adminId);

    if($admin['status'] == 200){
        
        $adminResult = delete('admins', $adminId);
        if($adminDelete){
            redirect('admins.php','Admiin Deleted');

        }else{
            redirect('admins.php','Something Went Wrong.');
        }

    }else{
        redirect('admins.php',$admin['message']);
    }
}else{
    redirect('admins.php','Something Went Wrong.');

}

?>