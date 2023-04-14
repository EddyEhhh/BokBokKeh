<?php 

require 'connect.php';
require_once 'validation_user.php';
require 'authorise_page_user.php'; //check if logged in

require 'uniquetokensession_check.php';

if(empty($_POST["friend_id"])){
    die('you are not authorised to view this page');
}




if(array_key_exists($_POST['friend_id'], $_SESSION['friend_id'])){
    $token_friend_id = $_POST['friend_id'];
    $friend_id = $_SESSION['friend_id']["$token_friend_id"];
    $friend_id = intval($friend_id);
}else{
    die("Invalid element!");
}

if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

$queryfren = $con->prepare("INSERT INTO `friend`(`USER_ID`, `FRIEND_ID`) VALUES (?,?)");

$user_id = $_SESSION["id"];

$queryfren->bind_param('ii', $user_id, $friend_id);
if ($queryfren->execute()){
    header("location: ../docs/$webpage.php");
}else{
    echo "An error occurred while trying to post! Pleaes try again later.";
}
?>