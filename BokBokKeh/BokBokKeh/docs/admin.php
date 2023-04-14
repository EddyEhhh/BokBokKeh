<html>
<head>
<?php

require '../src/authorise_page_user.php';
require '../src/connect.php';
require '../src/sanitize_data.php';

if($_SESSION['role']!='ADMIN'){
    die("You are not authorised to view this page");
}

?>
<title>Admin delete page</title>
</head>

<body>


<h1>Delete user's post</h1>


<?php 
$alluser = $con->prepare("SELECT USERNAME, ID FROM `user`");
$alluser->execute();
$alluser->store_result();
$alluser->bind_result($username, $user_id);

while($alluser->fetch()){
    
    echo "<form action='' method='post' style='position:relative'>
            <button type='submit' name='delete_post_id' value='$user_id' style='left:10px; position:relative; '>Delete all post from: @$username</button>";
}
echo "</form>";
?>


<h1>Delete user</h1>
		


<?php 
$alluser = $con->prepare("SELECT USERNAME, ID FROM `user`");
$alluser->execute();
$alluser->store_result();
$alluser->bind_result($username, $user_id);

while($alluser->fetch()){
    echo "<form action='' method='post' style='position:relative'>
            <button type='submit' name='delete_user_id' value='$user_id' style='left:10px; position:relative;'>Delete: @$username</button>";
}
echo "</form>";
?>




<?php

//DELETE USER's POST
if(isset($_POST['delete_post_id']) && $_SESSION['role']=='ADMIN'){
    
    $user_id = $_POST['delete_post_id'];
    
    //get all post from user
    $userpost = $con->prepare("SELECT ID FROM `post` WHERE user_id = ?");
    $userpost->bind_param('i', $user_id);
    $userpost->execute();
    $userpost->store_result();
    $userpost->bind_result($post_id);
    
    
    while($userpost->fetch()){
        
        //delete other's comment's on user's post
        $postcomment = $con->prepare("DELETE FROM `comment` WHERE POST_ID = ?");
        $postcomment->bind_param('i', $post_id);
        $postcomment->execute();
        
        
    }
    //delete all user's post
    $postcomment = $con->prepare("DELETE FROM `post` WHERE user_id = ?");
    $postcomment->bind_param('i', $user_id);
    $postcomment->execute();
    
    
}




//DELETE USER
if(isset($_POST['delete_user_id']) && $_SESSION['role']=='ADMIN'){
    $user_id =  $_POST['delete_user_id'];
    
    //delete all user's comment
    $deleteusercomment = $con->prepare("DELETE FROM `comment` WHERE USER_ID = ?");
    $deleteusercomment->bind_param('i', $user_id);
    $deleteusercomment->execute();
    
    //delete all user's friend
    $deletefriend = $con->prepare("DELETE FROM `friend` WHERE USER_ID = ? OR FRIEND_ID = ?");
    $deletefriend->bind_param('ii', $user_id, $user_id);
    $deletefriend->execute();

    //delete user
    $deleteuser = $con->prepare("DELETE FROM `user` WHERE id = ?");
    $deleteuser->bind_param('i', $user_id);
    $deleteuser->execute();
    
}







?>





</body>
</html>