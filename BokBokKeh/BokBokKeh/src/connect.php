<?php 

$con = mysqli_connect("localhost","root","","bokbokkeh"); //connect to database
if (!$con){
    die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

?>