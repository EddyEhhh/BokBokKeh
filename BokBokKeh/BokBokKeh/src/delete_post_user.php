<html>
<body>
<?php
require_once 'connect.php';
require 'authorise_page_user.php';

if(empty($_POST["id"])){
    die('You are not authorised to view this page');
}

$query= $con->prepare("DELETE FROM post WHERE ID=?");

$id = $_POST["id"];

$query->bind_param('i', $id); //bind the parameters
if ($query->execute()){
 header("Location: ../docs/profile.php");
}else{
 echo "Error executing query.";
}
?>
</body>
</html>
