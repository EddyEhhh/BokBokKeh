 <html> 
 <?php

require '../src/authorise_page_user.php';

require '../src/sanitize_data.php';
?>
 <head>
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- modal stylesheet -->
	<link type="text/css" ref="stylesheet" href="../src/multi_page_modal.css">
	<!-- modal javascript -->
	<script src="../src/multi_page_modal.js"></script>
 </head>

<!-- Button trigger modal -->
<div class="button">
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#comment">
  Comments
</button>
</div>

<!-- Modal -->
<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="comment">
  <div class="modal-dialog" role="document">
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="comment">Comments</h4>
      
      </div>
      
      <div class="modal-body" style='background-color: RGB(48,48,48)'>
	  
        <div class="modal-split">
		 	<?php require '../src/get_comment.php';?>
		</div>
		
		<div class="modal-split">
			<form action="../src/update_comment.php" method="post">
        		<img class='profile img-circle' src='../images/profile.JPG' alt='Avatar' style='position:relative;'></img>          
                    <br><br>
                <label for="name" style='color: white;'><?php echo $_SESSION['username']?></label><br>
                <label for="contact" style='color: white;'>Comment</label>
                	<br><br>
                <textarea name="comment" ><?php echo $_POST['comment'];?></textarea>
            </form>		
		</div>	

      </div>

      <div class="modal-footer">
 <!--Nothing Goes Here but is needed! -->
      </div>
    </div>
  </div>
</div>
  
  </html>