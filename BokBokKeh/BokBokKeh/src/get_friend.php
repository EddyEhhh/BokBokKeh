<?php

require 'connect.php';
require_once 'validation_user.php';

if(!isset($_SESSION['loggedin'])){
    die('You are not authorised to view this page.');
}

$_SESSION['list_friend_id'] = array();

$user_id = $_SESSION['id'];

$userfriendid = $con->prepare("SELECT FRIEND_ID, FRIEND_PERMISSION FROM `friend` WHERE USER_ID = ?");
$userfriendid->bind_param('i', $user_id);
$userfriendid->execute();
$userfriendid->store_result();
$userfriendid->bind_result($friend_id, $friend_permission);

while($userfriendid->fetch()){
    
    $queryfriendusername=$con->prepare("SELECT USERNAME, NAME FROM `user` WHERE ID = ?");
    $queryfriendusername->bind_param('i', $friend_id);
    $queryfriendusername->execute();
    $queryfriendusername->store_result();
    $queryfriendusername->bind_result($username, $name);
    
    $queryfriendusername->fetch();
    
    $username = sanitizeData($username);
    $name = sanitizeData($name);
    
    $token_get_friend_id = base64_encode(hash('sha256',uniqid(rand(), TRUE)));
    
    $_SESSION['list_friend_id']["$token_get_friend_id"] = "$friend_id";
    

    
    
    echo "<div class='well' style='height:90px; width: 520px; position:relative'>
            <div class='container pt-3' style='top:10px'>
              <h6 class='usersearchdisplayname' style='color: white; position:absolute;'>$name</h6>
              <h6 class='usersearchusername' style='position:absolute;'>@$username</h6>

              <form action='../src/delete_friend.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='friend_id' value='$token_get_friend_id' style='right:5px; top:8px; position:absolute;'>Remove friend</button>
              </form>

              <img class='usersearchprofile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'>
              ";
    $friendcheck = $con->prepare("SELECT FRIEND_PERMISSION FROM `friend` WHERE `USER_ID` = ? AND `FRIEND_ID` = ?");
    $user_id = $_SESSION['id'];
    $friendcheck->bind_param('ii', $user_id, $friend_id);
    $friendcheck->execute();
    $friendcheck->store_result();
    $friendcheck->bind_result($friend_permission);
    
    if($friend_permission==1){//if friend permission is true then set to false 
            echo "<form action='../src/update_friend.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='idremove' value='$token_get_friend_id' style='right:120px; top:8px; position: absolute;'>Remove permission</button>
            </form>";
    }else{
        echo "<form action='../src/update_friend.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='idadd' value='$token_get_friend_id' style='right:120px; top:8px; position: absolute;'>Give permission</button>
            </form>";
        
    }

                    echo "</div>
                </div>";
        


}

echo "</table>";

 
    
//    while($queryfren->fetch()){        
//        if($friend_permission == 1){
//            $friend_permission = 'Yes';-
//        }else{
//            $friend_permission = 'No';
//        }
  

    
//    }


// ON clause defines the relationship between the tables
// WHERE clasue describes which rows you are interested in

?>