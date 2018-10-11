<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
  
<body>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if(isset($_GET['author'])){
                   $the_post_author =$_GET['author'];
                    
                   if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Admin'){
                        $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}'";
                    }
                    else{
                        $query = "SELECT * FROM posts WHERE post_author = '{$the_post_author}' AND post_status = 'published'";
                    }
    
                   $select_author_posts_query = mysqli_query($connection, $query);
                    
                   if(mysqli_num_rows($select_author_posts_query) < 1){
                      echo "<h1 class='text-center'>No Posts available</h1>";  
                    }
                    else{
                    while($row = mysqli_fetch_assoc( $select_author_posts_query)){
                    $post_id      =  $row['post_id'];   
                    $post_title   =  $row['post_title'];
                    $post_author  =  $row['post_author'];
                    $post_date    =  $row['post_date'];
                    $post_image   =  $row['post_image'];
                    $post_content =  $row['post_content'];
               ?>
                        
                <h1 class="page-header">
                    <?php echo $the_post_author; ?> 
                    <small>Posts</small>
                </h1>

                <!-- Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More<span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>  
                                                      
            <?php }  } } 
                else{
                    
                    header("Location: index.php");
                } ?>
            
            
            
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

</html>

