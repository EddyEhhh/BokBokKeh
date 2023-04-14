<?php 

if(empty($_SESSION['token'])){
    die('You are not authorised to execute this action!');
}

if($_SESSION['token'] != $_POST['token'] or (time() - $_SESSION['token_time']) > 300){//if token does not match or time is more than 10 minutes
        die("Token expired. Please refresh page.");
    }

    
?>