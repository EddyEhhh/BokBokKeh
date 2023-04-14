<?php 
//SUMMARY INSERT POST, EDIT POST, DELETE POST, PUBLIC POST, Show all comment(Include comment;), Insert Comment.

//check if user came from authorised page.
if(empty($_SESSION['pageauthorise'])){
    die('You are not authorised to view this page');
    unset($_SESSION['pageauthorise']);
}

$_SESSION['post_id'] = array();
$modal_id_temp = 0;
$_SESSION['comment_id'] = array();
$modal_id_temp_comment = 0;

while($query->fetch())
{
    
    $queryuser=$con->prepare("SELECT USERNAME, NAME, ROLE from user WHERE id = ?");
    $queryuser->bind_param('i', $user_id);

    $queryuser->execute();
    $queryuser->store_result();

    $queryuser->bind_result($username, $name, $role);
    $queryuser->fetch();
    
//     //grab friend permission NOT IMPLEMENTED
//     $userpermission=$con->prepare("SELECT friend_permission from friend WHERE user_id = ? AND friend_id = ?");
//     session_start();
//     $session_user = $_SESSION['id'];
//     $userpermission->bind_param('ii', $user_id, $session_user);
    
//     $userpermission->execute();
//     $userpermission->store_result();
    
//     $userpermission->bind_result($permission);
//     $userpermission->fetch();
    
    
    if($role!="DELETED_USER" && $public!='DELETED'){

        $token_post_id = base64_encode(hash('sha256',uniqid(rand(), TRUE)));
        
        $_SESSION['post_id']["$token_post_id"] = "$id";
        
        $modal_id_temp += 1;
        
        
        require_once '../src/sanitize_data.php';

        $name = sanitizeData($name);
        $username = sanitizeData($username);
        $timestamp = sanitizeData($timestamp);
        $post = sanitizeData($post);
        $public = sanitizeData($public);


        echo //post content
        "<div class='well' class='areapost' style='position: relative'>
            <div class='container pt-3'>

            <h6 class='displayname' style='color: white; position:absolute;'>$name</h6>
            <h6 class='username' style='position:absolute;'>@$username</h6>
            <h6 class='username' style='position:absolute; right:60px;'>$timestamp</h6>
            <img class='profile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'></img>
            <div class='posttext'>
                $post
            </div>";


        if($user_id==$_SESSION['id'] or $_SESSION['role']=="ADMIN"){ //allow deleting and editing for own user and admin



            echo //delete or update post request
            "
             <button type='button' name='id' value='$modal_id_temp' style='right:120px; top:8px; position: absolute;' data-toggle='modal' data-target='#editpost$modal_id_temp'>edit</button>
                
                <!-- Edit post modal -->
               <div class='modal fade' style='overflow: visible;, height: 100px;'id='editpost$modal_id_temp' tabindex='-1' role='dialog' aria-labelledby='comment' aria-hidden='true'>
               <div class='modal-dialog' role='document' style='top:350px;'>
                    
                    

                    <!-- Edit post area -->

                          <form action='../src/update_post.php' class='post' method='post'>
                              <input type ='hidden' name='token' value='$token' />
                              <textarea name='posttext' class='textarea' maxlength='128' style='color: black; position:absolute;' contenteditable='true' required oninvalid='this.setCustomValidity('Write a post!')'>$post</textarea>
                              <button type='submit' name='post_id' value='$token_post_id' class='postbutton'>Edit</button>
                          </form>

                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        
                
                

                     
                      </div></div>

            <form action='../src/delete_post.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <button type='submit' name='id' value='$token_post_id' style='right:60px; top:8px; position: absolute;'>delete</button>
            </form>
";
            if($public=="PUBLIC"){
                echo" <form action='../src/update_post_public.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <input type='hidden' name='post_id' value='$token_post_id'>
                <button type='submit' name='public' value='PRIVATE' style='right:60px; top:60px; position: absolute;'>Public</button>
                </form>";
            }elseif($public=="PRIVATE"){
                echo" <form action='../src/update_post_public.php' method='post'>
                <input type ='hidden' name='token' value='$token' />
                <input type='hidden' name='post_id' value='$token_post_id'>
                <button type='submit' name='public' value='PUBLIC' style='right:60px; top:60px; position: absolute;'>Private</button>
                </form>";
            }

        }
        
        //comment
    echo "</div><br>
            <div class='well'>";
            
            //latest 3 comments content
                $querycomment=$con->prepare("SELECT * from comment WHERE POST_ID = ? ORDER BY TIMESTAMP DESC LIMIT 3");
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


                        echo"
                            <div class='container pt-3'>
                        <h6 class='displayname' style='color: white; position:absolute;'>$name</h6>
                        <h6 class='username' style='position:absolute;'>@$username</h6>
                        <h6 class='username' style='position:absolute; right:60px;'>$timestamp</h6>
                        <img class='profile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'></img>
                        <div class='posttext'>
                            $comment
                        </div>";
                        
                
                    echo "</div><hr>";
                            
                }
                
               
                
                //show more comment
                
                echo 
            "
            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#comment$id'>
              Show all Comment
            </button>


            <div class='modal' id='comment$id' style='z-index: 1400' role='dialog' aria-labelledby='comment' aria-hidden='true>
            	<div class='modal-dialog role='document'>
                  <div class='modal-content' style='left: 35%;'>
                    <div class='modal-header'>
                      <h4 class='modal-title'>Comments</h4>    
                      <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button></div>
                
                    <div class='modal-body'>";
                      require 'get_comment.php';
                      
                    
                      
                   


                    
                      //output comments in modal
                    //require 'get_comment.php';


                echo "</div></div></div>";



        echo "</div>
            <form action='../src/insert_comment.php' method='post'>
                  <input type ='hidden' name='token' value='$token' />
                  <textarea name='user_comment' class='commentarea' contenteditable='true' required oninvalid='this.setCustomValidity(\'Write a comment!\')'></textarea>             
                  <button type='submit' name='post_id' value='$token_post_id' class='commentbutton'>Comment</button>
            </form>
        </div>";
        
    }//end if ($role="deleted_user")

}//end while

?>