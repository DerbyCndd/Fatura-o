<?php
  require __DIR__.'../../../htdocs/Fatura/config/funtion.php';

    if(isset($_SESSION['loggedIn'])){

        logoutSession();
        redirect('login.php', 'Logged Out Successfyly');
    }

?>