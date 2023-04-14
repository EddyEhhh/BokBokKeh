<?php
require 'connect.php';
require 'validation_user.php';
require 'authorise_page_user.php';

if(empty($_POST["posttext"])){
    die('you are not authorised to view this page');
    
}

require 'uniquetokensession_check.php';

if(isset($_SESSION['previousWebpage'])){
    $webpage = $_SESSION['previousWebpage'];
}

if(!checkpost('posttext', true, '/^[a-zA-Z0-9 \/!:)(?<>,\-+.*@\'\'\"\"\v]{1,128}$/')){
    die("Comment contains invalid input!");
}

if(array_key_exists($_POST['post_id'], $_SESSION['post_id'])){
    $token_post_id = $_POST['post_id'];
    $post_id = $_SESSION['post_id']["$token_post_id"];
    $post_id = intval($post_id);
}else{
    die("Invalid element!");
}

$user_id = $_SESSION["id"];
$posttext = $_POST["posttext"];

$queryuser=$con->prepare("SELECT USER_ID from post WHERE id = ?");

$queryuser->bind_param('i', $post_id);

$queryuser->execute();
$queryuser->store_result();

$queryuser->bind_result($user_id);
$queryuser->fetch();

if($_SESSION['id'] == $user_id || $_SESSION['role'] == 'ADMIN'){


$query= $con->prepare("UPDATE `post` SET `POST`=? WHERE `USER_ID`=? AND `ID`=?");


$query->bind_param('sii', $posttext, $user_id, $post_id); //bind the parameters

    if ($query->execute()){ //execute query
        //header("Location: ../docs/comment.php");
        header("Location: ../docs/$webpage.php");
    }
}else{
    die("An error occurred while trying to post! Pleaes try again later.");
}



?>
