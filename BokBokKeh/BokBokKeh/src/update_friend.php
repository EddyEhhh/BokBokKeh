<?php 

require 'connect.php';
require_once 'validation_user.php';
require_once 'authorise_page_user.php';
require 'uniquetokensession_check.php';

if(!isset($_SESSION['loggedin'])){
    die('You are not authorised to view this page.');
}



if(isset($_POST['idremove'])){
    $friend_permission = 0;
    $friend_id = $_POST['idremove'];
//    if(!checkpost('idremove', true, '/^[0-9]{1,11}$/')){
//        die("Invalid input");
//    }
}elseif(isset($_POST['idadd'])){
    $friend_permission = 1;
    $friend_id = $_POST['idadd'];
//    if(!checkpost('idadd', true, '/^[0-9]{1,11}$/')){
//        die("Invalid input");
//    }
}else{
    die('You are not authorised to execute this action!');
}

if(array_key_exists($friend_id, $_SESSION['list_friend_id'])){
    $token_friend_id = $friend_id;
    $friend_id = $_SESSION['list_friend_id']["$token_friend_id"];
    $friend_id = intval($friend_id);
}else{
    die("Invalid element!");
}


    $queryfren = $con->prepare("UPDATE friend SET FRIEND_PERMISSION=? WHERE USER_ID=? AND FRIEND_ID=?");
   
    $user_id = $_SESSION["id"];
    
    $queryfren->bind_param('iii', $friend_permission, $user_id, $friend_id);    
    if($queryfren->execute()){        
        header("location: ../docs/profile.php");
    }else{
        echo "An error occurred while trying to post! Pleaes try again later.";
    }

?>