<?php

require 'connect.php';
require 'validation_user.php';
require 'authorise_page_user.php'; //check if logged in


require 'uniquetokensession_check.php';

if(!isset($_POST['comment_id'], $_POST['comment'])){ //isset to check if data is empty
    die('Missing input');
}


if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

if(!checkpost('comment', true, '/^[a-zA-Z0-9 \/!:)(?<>,\-+.*@\'\'\"\"\v]{1,128}$/')){
    die("Comment contains invalid input!");
}

$user_id = $_SESSION["id"];
$comment = $_POST["comment"];
$comment_id = $_POST["comment_id"];

if(array_key_exists($_POST['comment_id'], $_SESSION['comment_id'])){
    $token_comment_id = $_POST['comment_id'];
    $comment_id = $_SESSION['comment_id']["$token_comment_id"];
    $comment_id = intval($comment_id);
}else{
    die("Invalid element!");
}

$queryuser=$con->prepare("SELECT USER_ID from comment WHERE id = ?");

$queryuser->bind_param('i', $comment_id);

$queryuser->execute();
$queryuser->store_result();

$queryuser->bind_result($user_id);
$queryuser->fetch();

if($_SESSION['id'] == $user_id || $_SESSION['role'] == 'ADMIN'){

$query= $con->prepare("UPDATE `comment` SET `COMMENT`=? WHERE `USER_ID`=? AND `ID`=? ");

//add access control prevention

$query->bind_param('sii', $comment, $user_id, $comment_id); //bind the parameters
$query->execute();

    if(isset($webpage)){
        
        header("Location: ../docs/$webpage.php");
    }
    

}else{
 echo "An error occurred while trying to post! Pleaes try again later.";
}
?>