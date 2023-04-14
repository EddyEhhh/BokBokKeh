<?php 

die("test");

$page = $_GET['page'] ?? 'land';

echo file_get_contents("$page.php");

?>