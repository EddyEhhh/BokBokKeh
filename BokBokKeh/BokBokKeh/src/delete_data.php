<html>
<body>
<?php

require_once 'connect.php';
require 'authorise_page_user.php';

if(empty($_POST["id"])){
    die('You are not authorised to view this page');
}
    
    $id = $_POST["id"];
    
    $queryuser=$conn->prepare("SELECT USER_ID from item WHERE id = ?");
    $queryuser->bind_param('i', $id);
    
    $queryuser->execute();
    $queryuser->store_result();
    
    $queryuser->bind_result($user_id);
    $queryuser->fetch();
    
    if($_SESSION['id'] == $user_id || $_SESSION['role'] == 'ADMIN'){
        $query= $con->prepare("DELETE FROM item WHERE ITEM_ID=?");
        
        $query->bind_param('i', $id); //bind the parameters
        if ($query->execute()){
         header("Location: index.php");
        }else{
         echo "Error executing query.";
        }
    }else{
        die('You are not authorised to execute this action');
    }
    
?>
</body>
</html>
