<?php
include '../src/connect.php';

$query= $con->prepare("UPDATE `user` SET `NAME`=?,`CONTACT`=?,`EMAIL`=?,`BIO`=? WHERE ID = ?");

session_start();
$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$bio = $_POST['bio']; 
$id = $_SESSION['id'];

$query->bind_param('ssssi', $name, $contact, $email, $bio, $id); //bind the parameters
if ($query->execute()){
    $_SESSION['name'] = $name;
    $_SESSION['contact'] = $contact;
    $_SESSION['email'] = $email;
    $_SESSION['bio'] = $bio;
    header("Location: ../docs/profile.php");
 
}else{
 echo "Error executing query.";
}
?>
