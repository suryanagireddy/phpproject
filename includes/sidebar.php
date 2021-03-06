 <div class="col-md-4"> 
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input name="search" type="text" class="form-control">
            <span class="input-group-btn">
              <button name = "submit" class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
              </button>
            </span>
        </div>
        </form><!-- Search form -->
        <!-- /.input-group -->
    </div>
    
    <!-- login -->
    <div class="well">
        
        <?php if(isset($_SESSION['user_role'])): ?>
        
        <h4> Logged in as <?php echo $_SESSION['user_name']; ?></h4>
        <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        
        <?php else: ?>
        
        <h4>Login</h4>
        <form action="login.php" method="post">
        <div class="form-group">
            <input name="user_name" type="text" class="form-control" placeholder= "Enter username">
        </div>
        <div class="form-group">
            <input name="user_password" type="password" class="form-control" placeholder= "Enter password">     
        </div>
        <button class="btn btn-primary" name= "login" type="submit">Login</button>
        
        <div class="form-group">
            <a href="forgot.php?forgot=<?php echo uniqid(true); ?>"> Forgot Password </a>
        </div>
        </form><!-- login form -->
        
        <?php endif; ?>
        
    </div> 
                           

    <!-- Blog Categories Well -->
    <div class="well">
         <?php 
            $query = "SELECT * FROM categories";
            $select_categories_sidebar = mysqli_query($connection, $query);
         ?>
        <h4>Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                      <?php
                       while($row = mysqli_fetch_assoc( $select_categories_sidebar))
                           { 
                            $category_id = $row['cat_id'];
                            $category_title  =  $row['cat_title'];
                            echo "<li><a href ='category.php?category= $category_id' >{$category_title}</a></li>"; 
                           }
                      ?>
                </ul>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    
    <!-- Side Widget Well -->
    <?php include "widget.php" ?>
    

</div>