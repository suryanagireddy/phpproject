<?php include "includes/admin_header.php" ?>
   
<?php 
//Add Category                          
    if(isset($_POST['submit'])){
        $cat_title = trim($_POST['cat_title']);
        $error = ['cattitle'=>'']; 
              
               if($cat_title == ''){
                $error['cattitle']= 'Category title cannot be empty';
                }

                foreach($error as $key =>$value){
                    if(empty($value)){
                        unset($error[$key]);

                    }
                }//foreach end
  
               
               if(empty($error)){
                  add_category($cat_title);
               }
        
    }

                            
//Delete category
     if(isset($_GET['delete'])){
        $delete_cat_id = $_GET['delete'];                               
        delete_category($delete_cat_id); 
     }

?>
   
    <div id="wrapper">
      <!-- Navigation -->
      <?php include "includes/admin_navigation.php" ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome
                            <small><?php echo $_SESSION['user_name'] ?></small>
                        </h1>
                        <div class="col-xs-6">
                            <form action="" method="post">
                                <div class="form-group">
                                   <label for="cat-title">Add New Category</label>
                                    <input type="text" class= "form-control" name="cat_title">
                                    <p style="color: red;"><?php echo isset($error['cattitle']) ? $error['cattitle'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <input class = "btn btn-primary" type="submit" name="submit" value = "Add Category">
                                </div>  
                           </form>
                           
                           <!-- Edit Category -->
                           <?php
                            if(isset($_GET['edit'])){
                                $cat_id = $_GET['edit'];
                                include "includes/update_category.php";
                            }
                            ?>  
                        </div><!-- Add Category form -->
                        
                        <div class="col-xs-6">
                            <table class= "table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <!-- Find all categories-->
                                       <?php find_all_categories(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?> 
