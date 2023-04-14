

<?php 

require 'connect.php';

if(isset($_GET['search'])) {
    
    
    if(preg_match('/^([A-Za-z0-9_\-])+$/',$_GET['search'])){

        $search = '%'.$_GET['search'].'%';
        $query = $con->prepare("SELECT USERNAME, NAME, ID FROM `user` WHERE `USERNAME` LIKE ? LIMIT 10");
        $query->bind_param('s', $search);
        $query->execute();
        $query->store_result();
        $query->bind_result($username, $name, $friend_id);
        
        $username = sanitizeData($username);
        $name = sanitizeData($name);
        
        //tokenization
        $_SESSION['friend_id'] = array();
        $modal_id_temp = 0;
        //tokenization---------
        
        while($query->fetch()){
            
            $friendcheck = $con->prepare("SELECT * FROM `friend` WHERE `USER_ID` = ? AND `FRIEND_ID` = ?");
            $user_id = $_SESSION['id'];
            $friendcheck->bind_param('ii', $user_id, $friend_id);
            $friendcheck->execute();
            $friendcheck->store_result();
            
            //tokenization
            $token_friend_id = base64_encode(hash('sha256',uniqid(rand(), TRUE)));
            
            $_SESSION['friend_id']["$token_friend_id"] = "$friend_id";

            //tokenization---------
            
            echo "
            <div class='well' style='height:90px; width: 250px; position:relative'>
            <div class='container pt-3' style='top:10px'>
              <h6 class='usersearchdisplayname' style='color: white; position:absolute;'>$name</h6>
              <h6 class='usersearchusername' style='position:absolute;'>@$username</h6>";
            
            if($friendcheck->fetch()){
              echo "<form action='../src/delete_friend.php' method='post'>
                    <input type ='hidden' name='token' value='$token' />
                    <button type='submit' name='friend_id' value='$token_friend_id' style='right:0px; top:0px; position:absolute;'>Remove Friend</button>
                </form>";
            }else{
              echo "<form action='../src/insert_friend.php' method='post'>
                    <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='friend_id' value='$token_friend_id' style='right:0px; top:0px; position:absolute;'>Add Friend</button>
              </form>";
              }
              
              echo "<img class='usersearchprofile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'>
              </div>
                </div>";
        }

    }else{
        echo 'No search result';
    }
    
    
}

?>