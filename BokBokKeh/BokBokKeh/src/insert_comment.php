<?php

require 'connect.php';
require 'validation_user.php';
require 'authorise_page_user.php';
require 'uniquetokensession_check.php';

if(empty($_POST["user_comment"])){
    die('you are not authorised to view this page');
    
}

if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
    unset($_SESSION['previousWebpage']);
}

    


if(!checkpost('user_comment', true, '/^[a-zA-Z0-9 \/!:)(?<>,\-+.*@\'\'\"\"\v]{1,128}$/')){
    die("Comment contains invalid input!");
}

if(array_key_exists($_POST['post_id'], $_SESSION['post_id'])){
    $token_post_id = $_POST['post_id'];
    $post_id = $_SESSION['post_id']["$token_post_id"];
    $post_id = intval($post_id);
}else{
    die("Invalid element!");
}

$query= $con->prepare("INSERT INTO `comment` (`POST_ID`, `USER_ID`, `COMMENT`) VALUES (?,?,?)");
$user_id = $_SESSION["id"];
$comment = $_POST["user_comment"];


$query->bind_param('iis', $post_id, $user_id, $comment); //bind the parameters

    if ($query->execute()){ //execute query
     //header("Location: ../docs/comment.php");
        header("Location: ../docs/$webpage.php");
    }else{
        die("An error occurred while trying to post! Pleaes try again later.");
    }

?>