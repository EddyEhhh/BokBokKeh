<html>
<body>

<?php

require_once 'connect.php';
require 'authorise_page_user.php';
require_once 'validation_user.php';

if(empty($_POST["id"])){
    die('You are not authorised to view this page');
}

require 'uniquetokensession_check.php';
    
if(array_key_exists($_POST['id'], $_SESSION['post_id'])){
    $token_post_id = $_POST['id'];
    $id = $_SESSION['post_id']["$token_post_id"];
    $id = intval($id);
}else{
    die("Invalid element!");
}

    if(isset($_SESSION['previousWebpage'])){
        $webpage = $_SESSION['previousWebpage'];
        unset($_SESSION['previousWebpage']);
    }
    
    $queryuser=$con->prepare("SELECT USER_ID from POST WHERE id = ?");
    
    $queryuser->bind_param('i', $id);
    
    $queryuser->execute();
    $queryuser->store_result();
    
    $queryuser->bind_result($user_id);
    $queryuser->fetch();
    
    if($_SESSION['id'] == $user_id || $_SESSION['role'] == 'ADMIN'){
        
        $query= $con->prepare("UPDATE `POST` SET `PUBLIC`=? WHERE ID = ?");
        $delete_post = "DELETED";
        
        $query->bind_param('si', $delete_post, $id); //bind the parameters

        $query->execute();
        
        if(isset($webpage)){
            header("Location: ../docs/$webpage.php");
        }
        
    }else{
        die('You are not authorised to execute this action');
    }
    
    
?>

<?php
// $con = mysqli_connect("localhost","root","","bokbokkeh"); //connect to database
// if (!$con){
// die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
// }
// $query= $con->prepare("DELETE FROM post WHERE ID=?");

// $id = $_POST["id"];
// $query->bind_param('i', $id); //bind the parameters
// if ($query->execute()){
//  header("Location: ../docs/feed.php");
// }else{
//  echo "Error executing query.";
// }
// ?>

</body>
</html>
