<?php
//-----Connect to database-----
require 'connect.php';
libxml_disable_entity_loader($disable=true);
//-----Data validation-----



if(!isset($_POST['username'], $_POST['password'])){ //isset to check if data is empty
    die(header("Location: ../docs/login.php"));
}


require 'captchatest.php';

//Check if username exist
if($query = $con->prepare('SELECT * FROM user WHERE USERNAME = ?')){
    $query->bind_param('s', $_POST['username']);
    $query->execute();
    $query->store_result();

    if($query->num_rows > 0){
        
        require_once 'validation_user.php';
        $errusername = $errpassword = '';
        $invalidusername = $invalidpassword = true;
        // a-z A-z 0-9 _ -
        $invalidusername = !checkpost("username",true,"/^([A-Za-z0-9_\-])+$/");
        //min 8 char, a-z A-z 0-9 _ ! % * ? & -
        $invalidpassword = !checkpost("password",true,"/^([A-Za-z0-9_!%*?&\-]){8,}$/");
        
        $invalidinput = $invalidusername || $invalidpassword;

        if($invalidinput){
            die(header("Location: ../docs/login.php?"."err=invalid"));
        }
        
        if(!$result['success']){
            die(header("Location: ../docs/login.php?"."captcha=invalid"));
        }
        //check if there is any query RETRIEVE
            $query->bind_result($id, $username, $password, $name, $contact, $email ,$profile, $bio, $role);
            $query->fetch();
        //hash username -> encode -> substring (cutting) -> hash -> encode -> salting + password -> hash -> encode
            $salt = base64_encode(hash('SHA512', $_POST['username']));
            $salt = base64_encode(hash('SHA512', substr($salt, 2, -4)));
            
            $input_password = hash('SHA512', $salt.$_POST['password']);
            $input_password = base64_encode($input_password);
       //check password is correct & check if user is deleted & check captcha successful
       if($input_password == $password && $role != "DELETED_USER" && $result['success']){
            
            include '../src/create_session.php';
            
            header("Location: ../docs/feed.php");
        }else{
            die(header("Location: ../docs/login.php?"."err=invalid"));
            
    }}else{
        die(header("Location: ../docs/login.php?"."err=invalid"));
    }

}


?>

