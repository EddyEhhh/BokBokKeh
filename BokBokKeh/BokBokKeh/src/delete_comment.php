<?php 

require 'connect.php';
require_once 'validation_user.php';
require 'authorise_page_user.php'; //check if logged in


require 'uniquetokensession_check.php';


if(empty($_POST["comment_id"])){
    die('you are not authorised to view this page');
}


if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

$id = $_POST['comment_id'];
echo $_SESSION['comment_id']["$id"];

if(array_key_exists($_POST['comment_id'], $_SESSION['comment_id'])){
    $token_comment_id = $_POST['comment_id'];
    $comment_id = $_SESSION['comment_id']["$token_comment_id"];
    $comment_id = intval($comment_id);
}else{
    die("Invalid element!");
}

$query=$con->prepare("DELETE FROM `comment` WHERE `USER_ID` = ? AND `ID` = ?");

$user_id = $_SESSION["id"];


$query->bind_param('ii', $user_id, $comment_id);
if ($query->execute()){
    header("Location: ../docs/$webpage.php");
}else{
    echo "Error executing query";
}
?>