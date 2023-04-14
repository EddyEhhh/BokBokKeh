<!DOCTYPE html>
<html>


<?php

require '../src/authorise_page_user.php';

require '../src/sanitize_data.php';

require '../src/uniquetokensession.php';

$_SESSION['previousWebpage']= 'feed';
?>

<head>
	<meta charset="UTF-8">
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/0c4f236ae7.js"></script>
    <link href="../src/home_page.css" rel="stylesheet" type="text/css">
    <link rel='stylesheet' href='../src/friend.css'>
    
    
</head>
	<title>BokBokKeh</title>
<body>
	
    <h2>Home</h2>

    
    
        <!--Left partition-->
  		<div class="col-sm-3">
  			<?php //session_start(); if(echo $_SESSION['id']=ErrorException::class){ }?>
  		
  	
        <div class="well" >
        	
            <div class="container pt-3" onclick="window.location.href='profile.php'">
            	
              <h6 class="displayname" style="color: white; position:absolute;"><?php echo $_SESSION['name']?></a></h6>
              <h6 class="username" style="position:absolute;">@<?php echo $_SESSION['username']?></h6>
              
              <form style="right:10px; top:30px;" action="../src/logout.php" method="post" class="homelogout">
          		
              <input type="submit" value="logout">
              </form>
              
              <img class="profile img-circle" src="../images/profile.JPG" alt="Avatar" style="position:relative;">
              
              
              
              </div></div>  		
  		</div>
  		
  		<!--Center  partition-->
  		<div class="col-sm-6">
  		

        <div class="row">
        <div class="col-sm-12">
          <div class="well">
            <div class="container pt-3">
              
              <form action="../src/insert_post.php" class="post" method="post">
              <textarea name="posttext" class="textarea" maxlength='128' style="color: black; position:absolute;" contenteditable="true" required oninvalid="this.setCustomValidity('Write a post!')"></textarea>
          	  <input type ='hidden' name='token' value='<?php echo $token; ?>' />
              <input type="submit" value="Submit" class="postbutton">
              </form>
              
              
              
<!--               <input class="post" type="submit" value="Post"> -->
              
              
              <img class="profile img-circle" src="../images/profile.JPG" alt="Avatar" style="position:relative;">
            
                 <div class="icons">
                	
                	
                    <a class = "photo">
                    <i class="fas fa-photo-video"></i>
                    <span style = "font-size: 12px">Photo</span>
                    </a>
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
                $query=$con->prepare("select * from post ORDER BY TIMESTAMP DESC");
                
                $query->execute();
                $query->store_result();
                
                $query->bind_result($id, $user_id, $post, $image, $timestamp, $public);
                
                
                
                $_SESSION['pageauthorise'] = "get_post";
                include '../src/get_post.php';
               
                    
            ?>
          </div>
           <!-- post -->
          
          
          
          
          
        </div>
  		</div>
  		
  	
  		
  		<!--Right partition-->
  		<div class="col-sm-3">
  		
  		
            <div>
            	<form method="get" action='feed.php'>
                    <input class="searchhome" type="search" name='search' placeholder="Search">
                    <button type="submit">Search</button>
            	</form> 
                
                
                <?php 
                    
                require '../src/get_user.php';
                
                ?>
                
                
            </div>


  		</div>
  		


       



</body>


<style>
.modal:nth-of-type(even) {
    z-index: 1052 !important;
}
.modal-backdrop.show:nth-of-type(even) {
    z-index: 1051 !important;
}
</style>

</html>

    
    
