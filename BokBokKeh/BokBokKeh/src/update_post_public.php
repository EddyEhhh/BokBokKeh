<?php
require 'connect.php';
require 'validation_user.php';
require 'authorise_page_user.php';
require 'uniquetokensession_check.php';



if(empty($_POST["public"]) or empty($_POST["post_id"])){
    die('you are not authorised to view this page');
    
}

if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

if(array_key_exists($_POST['post_id'], $_SESSION['post_id'])){
    $token_post_id = $_POST['post_id'];
    $post_id = $_SESSION['post_id']["$token_post_id"];
    $post_id = intval($post_id);
}else{
    die("Invalid element!");
}

$public = $_POST["public"];


if(!($public=="PUBLIC" or $public=="PRIVATE")){
    die("Unable to execute action!");
}


$queryuser=$con->prepare("SELECT USER_ID from post WHERE id = ?");

$queryuser->bind_param('i', $post_id);

$queryuser->execute();
$queryuser->store_result();

$queryuser->bind_result($user_id);
$queryuser->fetch();

if($_SESSION['id'] == $user_id || $_SESSION['role'] == 'ADMIN'){


$query= $con->prepare("UPDATE `post` SET `PUBLIC`=? WHERE `USER_ID`=? AND `ID`=?");


$query->bind_param('sii', $public, $user_id, $post_id); //bind the parameters

    if ($query->execute()){ //execute query
        //header("Location: ../docs/comment.php");
        header("Location: ../docs/$webpage.php");
    }
}else{
    die("An error occurred while trying to post! Pleaes try again later.");
}



?>
