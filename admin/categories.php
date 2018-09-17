<?php include "includes/admin_header.php" ?>
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
                            <!--Add Category-->
                            <?php add_category(); ?>
                            
                            <form action="" method="post">
                                <div class="form-group">
                                   <label for="cat-title">New Category</label>
                                    <input type="text" class= "form-control" name="cat_title">
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
                                     <!-- Delete Category -->
                                       <?php delete_category(); ?>
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
