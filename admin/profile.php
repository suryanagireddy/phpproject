<?php include "includes/admin_header.php" ?>
   
<?php
    if(isset($_SESSION['user_name'])){
        $user_name = $_SESSION['user_name'];
        
        $query = "SELECT * FROM users WHERE user_name = '{$user_name}'";
        
        $select_user_profile_query = mysqli_query($connection,$query);
        while($row = mysqli_fetch_array($select_user_profile_query)){
            
        $user_id  =  $row['user_id'];
        $user_name  =  $row['user_name'];
        $user_firstname  =  $row['user_firstname'];
        $user_lastname =  $row['user_lastname'];
        $user_email =  $row['user_email'];
        $user_image  =  $row['user_image'];
        $user_role = $row['user_role'];
        $user_date = $row['user_date'];
        }
        
     // Post request to update profile 
      if(isset($_POST['update_profile'])){
            $user_name  =  $_POST['user_name'];
            $user_firstname  =  $_POST['user_firstname'];
            $user_lastname =  $_POST['user_lastname'];
            $user_email =  $_POST['user_email'];
            //$user_role = $_POST['user_role'];

            $user_image = $_FILES['user_image']['name'];
            $user_image_temp = $_FILES['user_image']['tmp_name'];  
            move_uploaded_file($user_image_temp, "../images/$user_image");

           if(empty($user_image)){
                $query = "SELECT * FROM users WHERE user_id = $user_id";
                $select_image = mysqli_query($connection,$query);
                while($row = mysqli_fetch_array($select_image)){
                    $user_image = $row['user_image'];
                 }
            }
    
        $query = "UPDATE users SET ";
        $query .="user_name = '{$user_name}',";
        //$query .="user_password = '{$hashed_password}',";
        $query .="user_firstname = '{$user_firstname}',";
        $query .="user_lastname = '{$user_lastname}',";
        $query .="user_email = '{$user_email}',";
        $query .="user_image = '{$user_image}',";
        //$query .="user_role = '{$user_role}',";
        $query .="user_date = now() ";
        $query .="WHERE user_id = '{$user_id}' ";
        $update_profile_query = mysqli_query($connection,$query);
        query_error($update_profile_query);
        //header("Location: profile.php");
        $updated = true;  
    }// Post request to update profile end
  }
else {
    redirect("../index.php");
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
                            <?php echo $_SESSION['user_name'] ?>
                            <small>Profile</small>
                        </h1>
                        <?php if(isset($updated)):?>
                           <p class ='bg-success'> Profile updated <a href='index.php'>Go to Dashboard</a></p>
                        <?php endIf; ?>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="user-firstname">First Name</label>
                        <input value="<?php echo $user_firstname ?>" type="text" class="form-control" name="user_firstname">
                    </div>
                    <div class="form-group">
                        <label for="user-lastname">Last Name</label>
                        <input value="<?php echo $user_lastname ?>" type="text" class="form-control" name="user_lastname">
                    </div>

                    <div class="form-group">
                        <label for="user-image">Image</label>
                        <img width="100" src="../images/<?php echo $user_image; ?>">
                        <input type="file" name="user_image">
                    </div>

                    <div class="form-group">
                    <label for="user-role">User Role: <?php echo $user_role ?></label><br>
<!--
                    <select name="user_role" id="">
                      <option value="<//?php echo $user_role ?>">Select option</option>
                      <option value="Admin">Admin</option>
                      <option value="Editor">Editor</option>
                      <option value="Subscriber">Subscriber</option>
                    </select>
-->
                    </div>

                    <div class="form-group">
                        <label for="user-name">Username</label>
                        <input value="<?php echo $user_name ?>" type="text" class="form-control" name="user_name">
                    </div>
                    
                    <div class="form-group">
                        <label for="user-email">Email</label>
                        <input value="<?php echo $user_email ?>" type="email" class="form-control" name="user_email">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name = "update_profile" value = "Update Profile">
                    </div>
                    </form>

                        
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
