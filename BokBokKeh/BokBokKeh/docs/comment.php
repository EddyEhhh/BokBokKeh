<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
</head>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comment">
  Comment
</button>

<!-- Modal -->
<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="comment" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="comment"><b>Comments</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

                <?php
                $conn = mysqli_connect("localhost","root","","bokbokkeh");
                $query=$conn->prepare("select * from comment WHERE user_id = ? ORDER BY TIMESTAMP DESC");
                $query->bind_param('i', $_SESSION['id']);
                
                $query->execute();
                $query->store_result();
                
                $query->bind_result($post_id, $user_id, $timestamp, $comment);
                
                
                $webpage='_user';
                
                include '../src/get_comment.php';
                
                    
            ?>
    </div>
  </div>
</div>


</html>
