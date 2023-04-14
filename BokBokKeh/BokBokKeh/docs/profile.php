  <!DOCTYPE html>
<html>

<?php
require '../src/authorise_page_user.php';

require '../src/sanitize_data.php';

require '../src/uniquetokensession.php';

$_SESSION['previousWebpage']='profile';

?>



<head>

	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
    <script src="https://kit.fontawesome.com/0c4f236ae7.js"></script>
    
    <link href="../src/home_page.css" rel="stylesheet" type="text/css">
    <link href="../src/profilepage.css" rel="stylesheet" type="text/css">
    <link rel='stylesheet' href='../src/friend.css'>
    
    
    
</head>
<?php $username = $_SESSION['username'];?>

	<title><?php echo $username?> | BokBokKeh</title>
<body style="background-color: #121212;">

    <h2>Profile</h2>


        <!--Left partition-->
  		<div class="col-sm-3">
  			<?php //session_start(); if(echo $_SESSION['id']=ErrorException::class){ }?>
  	
        <ul style="display: block">
			<li><a href="../docs/feed.php" ><i class="fas fa-home"></i><span>&nbsp;&nbsp;Feed</span></a></li>
			<!-- <li><a href="#" ><i class="far fa-user-circle"></i><span>&nbsp;&nbsp;Profile</span></a></li> -->
		</ul>
				
  		</div>
  		
  		<!--Center  partition-->
  		<div class="col-sm-6">
  		
  		

        <div class="row">
        <div class="col-sm-12">
          <div class="well">
            <div class="container pt-3" style="max-width:100%; word-wrap: break-word;">
              
              
              
<!--               <input class="post" type="submit" value="Post"> -->
              
              <h4 class="userdisplayname" style="color: white; position:absolute;"><?php echo $_SESSION['name']?></h4>
              <h6 class="userusername" style="position:absolute;">@<?php echo $_SESSION['username']?></h6>
              
              
              <p class="userusername" style="position:absolute; word-wrap: break-word; width: 460px;"><br><?php echo $_SESSION["bio"];?></p>
              
  
              <img class="profilepic" src="../images/profile.JPG" alt="Avatar" style="position:relative;">
              
              <button type='button' style='right:80px; top:50px; position: absolute;' class='btn btn-primary' data-toggle='modal' data-target='#editprofile'>Edit Profile</button>
            	<button type='button' style='right:80px; top:80px; position: absolute;' class='btn btn-primary' data-toggle='modal' data-target='#friendlist'>Friend list</button>
                          
            
<!--               UPDATE USER DATA POPUP                         -->
        <!-- The edit profile Modal -->
                    <div class='modal fade' id='editprofile' tabindex='-1' role='dialog' aria-labelledby='comment' aria-hidden='true'>
            
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title' id='comment'><b>Profile</b></h1>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                
                
                <div class='modal-body' style='background-color: RGB(48,48,48)'>
                		
                		<!-- Delete user button -->
                        <form action='../src/delete_user.php' method='post'>
                        <input type ='hidden' name='token' value='<?php echo $token?>' />  
                        <button name='delete' value='delete' type='submit' style='right:60px; top:8px; position: absolute;'>Delete account!</button>
                        </form>
                        
                          <form action="../src/update_user.php" method="post">

                          
        						<img class='profile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'></img>      
        						<input type ='hidden' name='token' value='<?php echo $token?>' />    
                                <label for="fname" style="color: white;">@<?php echo $_SESSION['username']?></label><br><br>
                                <label for="name" style='color: white;'>Display name</label><br>
                                <input type="text" name="name" value=<?php echo $_SESSION["name"];?>>*<br><br>
                                <label for="contact" style='color: white;'>Contact:</label><br>
                                <input type="text" name="contact" value=<?php echo $_SESSION["contact"];?>><br><br>
                                <label for="email" style='color: white;'>Email:</label><br>
                                <input type="text" name="email" value=<?php echo $_SESSION["email"];?>>*<br><br>
                                <label for="bio" style='color: white;'>Bio:</label><br>
                                <textarea name="bio"><?php echo $_SESSION["bio"];?></textarea>
                              <input type="submit" value="Submit">
                        </form> 
                        </div>
                      </div></div>
                    
                    </div>
                    
                    <!-- The friend list Modal -->
                    <div class='modal fade' id='friendlist' tabindex='-1' role='dialog' aria-labelledby='comment' aria-hidden='true'>
            
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title' id='comment'><b>Friends</b></h1>
                            <button type='button' style='color:black' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                
                
                <div class='modal-body' style='background-color: RGB(48,48,48), position: relative; height: 400px;'>
                        
                     <div class='container pt-3' style='top:10px'>
                         <?php require '../src/get_friend.php';?>

                        </div>
                      </div></div></div>
                    
                    </div>
                    
                    
    	
                 <div class="icons">


<!--                     <a class = "photo">
                    <i class="fas fa-photo-video"></i>
                    <span style = "font-size: 12px">Photo</span>
                    </a> --> 
                    
<!--                     <a class = "texts"> 
                     <i class="far fa-laugh-squint"></i> 
                    <span style = "font-size: 12px">Whats on your mind?</span>
                       </a> -->
                    
                    
                    
                    
                        
                </div>
             	
              
            </div>
            
         	 </div>
          <!-- post -->
          
            
             
             
            <?php
                require '../src/connect.php';    
            
                $query=$con->prepare("select * from post WHERE user_id = ? ORDER BY TIMESTAMP DESC");
                $query->bind_param('i', $_SESSION['id']);
                
                $query->execute();
                $query->store_result();
                
                $query->bind_result($id, $user_id, $post, $image, $timestamp, $public);
                
                
                
                $_SESSION['pageauthorise'] = 'get_post';
                include '../src/get_post.php';
                
                    
            ?>
          </div>
           <!-- post -->
          
          
          
          
          
        </div>
  		</div>
  		
  	
  		
  		<!--Right partition-->
  		<div class="col-sm-3">
  		
  		
            <div>
            	<form method="get" action='profile.php'>
                    <input class="searchhome" type="search" name='search' placeholder="Search">
                    <button type="submit">Search</button>
            	</form>
	
                <?php 

                require '../src/get_user.php';

                ?>


            </div>
            
            
            <!-- Trigger/Open The Modal -->
        
    	
</div>
		
        		
        	


</body>


    
    <script type="text/javascript">
            	// Get the modal
        var modal = document.getElementById("myModal");
        
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks the button, open the modal 
        btn.onclick = function() {
          modal.style.display = "block";
        }
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
          modal.style.display = "none";
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
    </script>
  

</html>



    
    
