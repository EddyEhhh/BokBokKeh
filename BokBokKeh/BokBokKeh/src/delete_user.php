<?php
//can only see if logged in as admin
include 'connect.php';
require 'authorise_page_user.php'; //check if logged in

require 'uniquetokensession_check.php';

    
if(!isset($_SESSION["id"])){ //isset to check if data is empty
    die('You are not authorised to execute this action!');
}
    
    $query= $con->prepare("UPDATE `user` SET `role`=? WHERE ID = ?");
    $id = $_SESSION["id"];
    $delete_role = "DELETED_USER";
    
    $query->bind_param('si', $delete_role, $id);
    //bind the parameters
    if ($query->execute()){
        require 'logout.php';
    }else{
     echo "Error executing query.";
    }
    
    //implemented checks on other pages, to check if USER is deleted to prevent their data from being retrieved
?>

