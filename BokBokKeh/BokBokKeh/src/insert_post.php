<html>
<body>
<?php

require_once 'connect.php';
require_once 'validation_user.php';
require 'authorise_page_user.php';


if(empty($_POST["posttext"])){
    die('you are not authorised to view this page');
}

if(!checkpost('posttext', true, '/^[a-zA-Z0-9 \/!:)(?<>,\-+.*@\'\'\"\"\v]{1,}$/')){
        die("Unable to execute action!");
    }

require 'uniquetokensession_check.php';

if(isset($_SESSION['loggedin'])){
    $query= $con->prepare("INSERT INTO `post`(`USER_ID`, `POST`, `PUBLIC`) VALUES (?,?,?)");

    $userid= $_SESSION["id"];
    $post = $_POST["posttext"];
    $public = "PUBLIC";

    $query->bind_param('iss', $userid, $post, $public); //bind the parameters
    if ($query->execute()){ //execute query
         header("Location: ../docs/feed.php");
        }


}else{
    echo "An error occurred while trying to post! Pleaes try again later.";
}



?>
</body>
</html>
