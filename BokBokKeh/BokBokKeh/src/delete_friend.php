<?php 

require 'connect.php';
require_once 'validation_user.php';
require 'authorise_page_user.php';
require 'uniquetokensession_check.php';

if(empty($_POST['friend_id'])){
    die('you are not authorised to view this page');
}

if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

if(array_key_exists($_POST['friend_id'], $_SESSION['friend_id'])){
    $token_friend_id = $_POST['friend_id'];
    $friend_id = $_SESSION['friend_id']["$token_friend_id"];
    $friend_id = intval($friend_id);
}

elseif(array_key_exists($_POST['friend_id'], $_SESSION['list_friend_id'])){
    $token_friend_id = $_POST['friend_id'];
    $friend_id = $_SESSION['list_friend_id']["$token_friend_id"];
    $friend_id = intval($friend_id);
}else{
    die("Invalid element!");
}



$query=$con->prepare("DELETE FROM `friend` WHERE `USER_ID`=? AND `FRIEND_ID`=?");

$user_id = $_SESSION["id"];

$query->bind_param('ii', $user_id, $friend_id);
if ($query->execute()){
    //die("$user_id , $friend_id");
    header("location: ../docs/$webpage.php");
}else{
    echo "Error executing query";
}
?>