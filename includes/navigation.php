<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./index.php">CMS Surya</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc( $select_all_categories_query))
                {  
                $category_id = $row['cat_id'];
                $category_title  =  $row['cat_title']; 
                    
                $category_class= '';
                $registration_class = '';
                $contact_class = '';
                
                $page_name = basename($_SERVER['PHP_SELF']);
                    
                    if(isset($_GET['category']) && $_GET['category'] == $category_id)
                    {
                        $category_class = 'active';
                    }
                    else {
                        
                        switch($page_name){
                        case 'registration.php';
                        $registration_class = 'active';
                        $contact_class = '';
                        break;
                        
                        case 'contact.php';
                        $registration_class = '';
                        $contact_class = 'active';
                        break;
                        
                        default:
                        $registration_class = '';
                        $contact_class = '';
                                
                        }
                    }
                echo "<li class='$category_class'><a href ='category.php?category= {$category_id}'>{$category_title}</a></li>";      
                }
                ?>

               <?php
                 if (session_status() === PHP_SESSION_NONE) session_start();
                 if(isset($_SESSION['user_name'])){
                    if(isset($_GET['p_id'])){
                        $the_post_id = $_GET['p_id'];
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit post</a></li>";
                     }
                     echo "<li><a href='admin'>Admin</a></li>";
                
                } else {
                
                echo "<li><a href='registration.php'>Registration</a></li>";
                
                }
                
               ?>
                <li class = '<?php echo $contact_class ?>'>
                    <a href="contact.php">Contact us</a>
                </li>
                    
                    
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>