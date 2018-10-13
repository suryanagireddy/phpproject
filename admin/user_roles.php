<?php include "includes/admin_header.php" ?>

<?php 
  // Add user role    
    if(isset($_POST['submit'])){
        $role_title = trim($_POST['role_title']);
        $error = ['roletitle'=>'']; 
              
               if($role_title == ''){
                $error['roletitle']= 'Role title cannot be empty';
                }

                foreach($error as $key =>$value){
                    if(empty($value)){
                        unset($error[$key]);

                    }
                }//foreach end
  
               
               if(empty($error)){
                  add_user_role($role_title); 
               }
        
    }

                            
//Delete user role
     if(isset($_GET['delete'])){
        $delete_user_role_id = $_GET['delete'];                               
        delete_user_role($delete_user_role_id); 
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
                                   <label for="role-title">Add New User Role</label>
                                    <input type="text" class= "form-control" name="role_title">
                                    <p style="color: red;"><?php echo isset($error['roletitle']) ? $error['roletitle'] : '' ?></p>
                                </div>
                                <div class="form-group">
                                    <input class = "btn btn-primary" type="submit" name="submit" value = "Add user role">
                                </div>  
                           </form> 
                            <?php
                                //Edit User role
                                if(isset($_GET['edit'])){
                                $user_role_id = $_GET['edit'];
                                include "includes/update_user_role.php";
                                }
                            ?>
                        </div><!-- Add user role form -->
                        
                        <div class="col-xs-6">
                            <table class= "table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Role Id</th>
                                        <th>Role Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <!-- Find all user_roles-->
                                       <?php find_all_user_roles(); ?>
                                     
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
