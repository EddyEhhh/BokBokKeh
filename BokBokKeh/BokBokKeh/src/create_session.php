<?php 

if(empty($id)){
    die('You are not authorised to execute this action!');
}


session_start();

//create new session ID.
session_regenerate_id();

require_once 'sanitize_data.php';

$_SESSION['loggedin'] = TRUE;
$_SESSION['id'] = sanitizeData($id);
$_SESSION['username'] = sanitizeData($username);
$_SESSION['name'] = sanitizeData($name);
$_SESSION['contact'] = sanitizeData($contact);
$_SESSION['email'] = sanitizeData($email);
$_SESSION['profile'] = sanitizeData($profile);
$_SESSION['bio'] = sanitizeData($bio);
$_SESSION['role'] = sanitizeData($role);

//die($id.'<br>'.$username.'<br>'.$name.'<br>'.$contact.'<br>'.$email.'<br>'.$profile.'<br>'.$bio.'<br>'.$role);


?>