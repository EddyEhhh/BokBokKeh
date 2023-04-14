<?php 

if(empty($_SESSION['loggedin'])){
    session_start();
}

session_destroy(); ;

header("Location: ../docs/login.php");
?>