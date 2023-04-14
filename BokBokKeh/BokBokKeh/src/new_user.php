<?php
//-----Connect to database-----

require_once 'connect.php';
libxml_disable_entity_loader($disable=true);
//-----Data validation-----

if(!isset($_POST['username'], $_POST['password'], $_POST['contact'], $_POST['email'])){ //isset to check if data is empty
    die(header("Location: ../docs/profile.php"));
}

require 'captchatest.php';

$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['username'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$none = '';
$role = 'USER';


//Check if username exist
if($query = $con->prepare('SELECT id FROM user WHERE username = ?')){
    $query->bind_param('s', $username);
    $query->execute();
    $query->store_result();

    if($query->num_rows > 0){
        //check if there is any query retrived
        echo 'Username exist, please choose another!';
    }else{
        //register
        //input validation check
        
        require_once 'validation_user.php';
        $errusername = $errpassword = $errcontact = $erremail = '';
        $invalidusername = $invalidpassword = $invalidemail = $invalidcontact = true;
        
        if(($invalidusername = !checkpost("username",true,"/^([A-Za-z0-9_\-])+$/"))){
            $errusername = "username=invalid&";
        }
        
        //min 8 char, a-z A-z 0-9 _ ! % * ? & -
        if(($invalidpassword = !checkpost("password",true,"/^([A-Za-z0-9_!%*?&\-]){8,}$/"))){
            $errpassword = "password=invalid&";
        }
        
        // i behind the pattern is for case insensitive
        if(($invalidemail = !checkpost("email",true, "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i"))){
            $erremail = "email=invalid&";
        }
        
        if(($invalidcontact = !checkpost("contact",true,"/^([0-9])+$/"))){
            $errcontact = "contact=invalid&";
        }
        
        // check captcha success
        if($invalidcaptcha = !$result['success']){
            $errcaptcha = "captcha=invalid&";
        }
        
        $invalidinput = $invalidusername || $invalidpassword || $invalidemail || $invalidcontact || $invalidcaptcha;
        
        if($invalidinput){
            die(header("Location: ../docs/register.php?"."$errusername$errpassword$erremail$errcontact$errcaptcha"));
        }
        
        //END input validation-----------------------------------
        
        elseif(!$invalidinput){
            $query = $con->prepare("INSERT INTO `user` (`USERNAME`,`PASSWORD`,`NAME`,`CONTACT`,`EMAIL`,`PROFILE`, `ROLE`) VALUES (?,?,?,?,?,?,?)");
            //hash username -> encode -> substring (cutting) -> hash -> encode -> salting + password -> hash -> encode
            //hash password
            
            //salting
            $salt = base64_encode(hash('SHA512', $username));
            $salt = base64_encode(hash('SHA512', substr($salt, 2, -4)));
            
            
            $password = hash('SHA512', $salt.$password);
            $password = base64_encode($password);
            //
            
            //$none = profile picture, implement later
            $query->bind_param('sssssbs', $username, $password, $name, $contact, $email, $none, $role);
            $query->execute();

            //get user id
            $queryuserid = $con->prepare("SELECT ID, PROFILE, BIO from `user` WHERE username = ?");
            $queryuserid->bind_param('s', $username);
            $queryuserid->execute();
            $queryuserid->store_result();  
            $queryuserid->bind_result($id, $profile, $bio);
            $queryuserid->fetch();

            require '../src/create_session.php';

            header("Location: ../docs/feed.php");

            
        }else{
            echo 'Oh no :( Something went wrong while registering!';
        }
        
    }
}else{
    echo 'Oh no :( Something went wrong!';
}

?>

