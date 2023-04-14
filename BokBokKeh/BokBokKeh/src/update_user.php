<html>
<body>
<?php

require_once 'connect.php';
require_once 'validation_user.php';
require 'authorise_page_user.php';
require 'uniquetokensession_check.php';


if(!isset($_POST['name'], $_POST['email'], $_POST['bio'], $_POST['contact'])){ //isset to check if data is empty
    die('You are not authorised to execute this action');
}

session_start();

$name = $_POST['name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$bio = $_POST['bio'];
$id = $_SESSION['id'];


require_once 'validation_user.php';
$errname = $errcontact = $erremail = $errbio = '';
$invalidname = $invalidcontact = $invalidemail = $invalidbio = true;

if(($invalidname = !checkpost("name",true,"/^([A-Za-z0-9_\-]){1,24}$/"))){
    $errname = "Invalid name. Name may contain up to 24 letters, numbers, underscores and dash.<br>";
}

if(($invalidcontact = !checkpost("contact",true,"/^([0-9])+$/"))){
    $errcontact = "Invalid Contact number.<br>";
}

// i behind the pattern is for case insensitive
if(($invalidemail = !checkpost("email",true, "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i"))){
    $erremail = "Invalid email format.<br>";
}

//min 8 char, a-z A-z 0-9 _ ! % * ? & - ( ) : 
if(($invalidbio = !checkpost("bio",true,"/^([A-Za-z0-9_!%*?&\-\(\) :]){0,96}$/"))){
    $errbio = "Bio may contain up to 96 letter, number and symbols(_!%*?&-():)<br>";
}

$invalidinput = $invalidname || $invalidcontact || $invalidemail || $invalidbio;

if($invalidinput){
    echo "<script>alert('$errname$errcontact$erremail$errbio')</script>";
    
    die(header("Location: ../docs/profile.php"));
    //die(header("Location: ../docs/profile.php?"));
}

$query= $con->prepare("UPDATE `user` SET `NAME`=?,`CONTACT`=?,`EMAIL`=?,`BIO`=? WHERE ID = ?");

$query->bind_param('ssssi', $name, $contact, $email, $bio, $id); //bind the parameters
if ($query->execute()){
    require_once 'sanitize_data.php';
    $_SESSION['name'] = sanitizeData($name);
    $_SESSION['contact'] = sanitizeData($contact);
    $_SESSION['email'] = sanitizeData($email);
    $_SESSION['bio'] = sanitizeData($bio);
    header("Location: ../docs/profile.php");

}else{
 echo "Error executing query.";
}
?>
</body>
</html>