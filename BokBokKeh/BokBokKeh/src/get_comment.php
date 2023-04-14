<?php

//require_once 'connect.php';


if(empty($_SESSION['pageauthorise'])){
    die('You are not authorised to view this page');
    unset($_SESSION['pageauthorise']);
}



$querycomment=$con->prepare("SELECT * from comment WHERE POST_ID = ? ORDER BY TIMESTAMP DESC");
$querycomment->bind_param('i', $id);

$querycomment->execute();
$querycomment->store_result();

$querycomment->bind_result($comment_id, $post_id, $user_id, $timestamp, $comment);

while($querycomment->fetch()){
    $querycommentuser=$con->prepare("SELECT USERNAME, NAME from user WHERE ID = ?");
    $querycommentuser->bind_param('i', $user_id);
    
    $querycommentuser->execute();
    $querycommentuser->store_result();
    
    $querycommentuser->bind_result($username, $name);
    $querycommentuser->fetch();
    
    $name = sanitizeData($name);
    $username = sanitizeData($username);
    $timestamp = sanitizeData($timestamp);
    $comment = sanitizeData($comment);
    
    

    echo "<div class='container pt-3' style='color: white; position:relative;'>
            <h6 class='displayname' style='color: white; position:absolute;'>$name</h6>
            <h6 class='username' style='position:absolute;'>@$username</h6>
            <h6 class='username' style='position:absolute; left:350px;'>$timestamp</h6>
            <img class='profile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'></img>
                <div class='posttext'>
                    $comment
                </div>
";

    if($user_id==$_SESSION['id'] or $_SESSION['role']=="ADMIN"){ //allow deleting and editing for own user and admin
        
        $token_comment_id = base64_encode(hash('sha256',uniqid(rand(), TRUE)));
        
        $_SESSION['comment_id']["$token_comment_id"] = "$comment_id";
        
        $modal_id_temp_comment += 1;

        
            echo //delete or update post request
            "
            <div class='modal' id='edit$modal_id_temp_comment' data-backdrop='static' style='z-index: 1600'>
            	<div class='modal-dialog'>
                  <div class='modal-content'>
                    
                      
                      <button type='button' style='color:black' class='close' data-dismiss='modal' aria-hidden='true'>Close</button>
                    <div class='container'></div>
                    <div class='modal-body' style='height:60px;'>
            
                    <form action='../src/update_comment.php' method='post'>
                    <input type ='hidden' name='token' value='$token' />
                    <textarea name='comment' class='textarea' style='margin-left: 0px; color: black; position:absolute;' contenteditable='true' required>$comment</textarea>
                    <button type='submit' name='comment_id' value='$token_comment_id' style='bottom:1px; right: 1px; position: absolute; color:black;'>Edit Comment</button>
                    </form>
                     <button type='submit' data-dismiss='modal' class='btn'>Close</button>
                    ";

                                              
            echo
            "        
                    
                      
                    </div>
                  </div>
                </div>
            </div>
                            

            <a data-toggle='modal' href='#edit$modal_id_temp_comment'>Edit</a>
            

            <form action='../src/delete_comment.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='comment_id' value='$token_comment_id' style='right:0px; top:0px; position: relative;'>delete</button>
            </form>";
                }//delete and edit       

    echo "

</div><hr>

";    

}


?>

<html>

<!-- <button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#test1'>Open Modal 1 </button>



 <div id='test1' class='modal fade' role='dialog' style='z-index: 1400;'>
  <div class='modal-dialog'>
     Modal content
    <div class='modal-content'>
      
      <div class='modal-body'>
      	<button type='button' class='btn btn-info btn-lg' data-toggle='modal'      data-target='#test2'>Open Modal 2</button>
      	
      </div>      
    </div>
  </div>
</div> -->



</html>  













