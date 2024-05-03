<?php 
    session_start();
    if(isset($_SESSION['login'])){
       header('Location: view/Dashboard.php');
       die;
    }else{
         echo '<meta http-equiv="REFRESH" content="0;url=view/login.php">';
    }
   
?> 