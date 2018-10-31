<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
 
<?php
 if(isset($_POST['liked'])) {

     $post_id = $_POST['post_id'];
     $user_id = $_POST['user_id'];

      //1 =  FETCHING THE RIGHT POST
     $query = "SELECT * FROM posts WHERE post_id=$post_id";
     $postResult = mysqli_query($connection, $query);
     $post = mysqli_fetch_array($postResult);
     $likes = $post['likes'];

     // 2 = UPDATE - INCREMENTING WITH LIKES

     mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

     // 3 = CREATE LIKES FOR POST

     mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
     exit();
 }

 if(isset($_POST['unliked'])) {
     
     $post_id = $_POST['post_id'];
     $user_id = $_POST['user_id'];

     //1 =  FETCHING THE RIGHT POST

     $query = "SELECT * FROM posts WHERE post_id=$post_id";
     $postResult = mysqli_query($connection, $query);
     $post = mysqli_fetch_array($postResult);
     $likes = $post['likes'];

     //2 = DELETE LIKES

     mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");


     //3 = UPDATE WITH DECREMENTING WITH LIKES

     mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

     exit();
 }
 ?>
  
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if(isset($_GET['p_id'])){
                    $the_post_id =$_GET['p_id'];
                    
                    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$the_post_id}'";
                    $views_count_query = mysqli_query($connection, $view_query);
                    if(!$views_count_query){
                        die("Query Failed!" . mysqli_error($connection));
                    }
                    
                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){
                        $stmt1 = mysqli_prepare($connection, "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ?");
                       //$query = "SELECT * FROM posts WHERE post_id = $the_post_id";  
                    }
                    else{
                        //$query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status= 'published'";
                        $stmt2 = mysqli_prepare($connection , "SELECT post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_id = ? AND post_status = ? ");
                        $published = 'published';
                    }
                    
                    if(isset($stmt1)){
                        
                    mysqli_stmt_bind_param($stmt1, "i", $the_post_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt1;
                        
                    }else {
                        
                    mysqli_stmt_bind_param($stmt2, "is", $the_post_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;
                    }
                
                while(mysqli_stmt_fetch($stmt)) {

                ?>
                <!-- Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <hr>
                
                <?php 
                   mysqli_stmt_free_result($stmt);
                 ?>
                   <?php  if(isLoggedIn()){  ?>
                            <div class="row">
                                <p class="pull-left"><a class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>" 
                                href=""><span class="glyphicon glyphicon-thumbs-up" 
                                data-toggle="tooltip" data-placement="top" 
                                title="<?php echo userLikedThisPost($the_post_id) ? ' You liked this before' : 'Want to like it?'; ?>"></span>
                                <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?></a></p>
                            </div>
                   <?php  } else { ?>
                            <div class="row">
                                <p class="pull-left login-to-post">You need to <a href="/cms/login.php">Login</a> to like </p>
                            </div>
                    <?php } ?>
                    
                    
                <div class="row">
                    <p class="pull-left likes">Likes: <?php getPostlikes($the_post_id); ?></p>
                </div>
                <div class="clearfix"></div>

                <?php } ?>
            
            <!-- Comments Column -->
            <!-- Post Comments -->
                
            <?php

            if(isset($_POST['create_comment'])){

                $the_post_id = $_GET['p_id'];

                $comment_author = $_POST['comment_author'];
                $comment_email =  $_POST['comment_email'];
                $comment_content =  $_POST['comment_content'];

                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content) && ($comment_content != '')){

                $query =  "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now())  " ;

                $create_comment_query = mysqli_query($connection, $query);
                    
                echo "<div class='alert alert-success'> Your Comment is received and under review !</div>";
                $message = "";
                }else{ 
                    $message = "Fields cannot be empty";
                }
              }
                else 
                {
                    $message ="";
                }
            ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <h5 class="text-center"><?php echo $message ?></h5>
                    <form action="" method="post" role="form">
                       <div class="form-group">
                           <label for="comment-author">Author</label>
                           <input type="text" class="form-control" name="comment_author" >
                       </div>
                       <div class="form-group">
                           <label for="comment-email">Email</label>
                           <input type="email" class="form-control" name="comment_email" >
                       </div>
                        <div class="form-group">
                            <label for="comment-content">Comments</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name= "create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php
                 $query = "SELECT * FROM comments WHERE comment_post_id= {$the_post_id} ";
                 $query .= "AND comment_status = 'Approved' ";
                 $query .= "ORDER BY comment_id DESC ";
                 $select_comment_query = mysqli_query($connection, $query);
                   while($row = mysqli_fetch_assoc( $select_comment_query))
                   {   
                    $comment_author  =  $row['comment_author'];
                    $comment_content  =  $row['comment_content'];
                    $comment_date =  $row['comment_date'];

                ?>
                
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author ?>
                            <small><?php echo $comment_date ?></small>
                        </h4>
                        <?php echo $comment_content ?>
                    </div>
                </div>
                
                
                <?php  } } 
                else{
                    header("Location: index.php");
                }
                ?>

                
                
            
            </div>

            <!-- Blog Sidebar Widgets Column -->
           <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>


<script>
    $(document).ready(function(){
        $("[data-toggle='tooltip']").tooltip();
        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php echo loggedInUserId(); ?>;
        
        // LIKING
        $('.like').click(function(){
            $.ajax({
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });
        // UNLIKING

        $('.unlike').click(function(){
            $.ajax({
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });
    });
</script>

