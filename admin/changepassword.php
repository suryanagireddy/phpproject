<?php include "includes/admin_header.php" ?>
   
<?php
    if(isset($_SESSION['user_name'])){
     $user_name = $_SESSION['user_name'];

      if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
        $password = trim($_POST['password']);
        $confirmPassword = trim($_POST['confirmPassword']);
        
        $error = ['password'=>'','confirmPassword'=>'', 'match'=>''];
        
        if(strlen($password)<6){
         $error['password']= 'Password is too short';
        }  
        if($password == ''){
         $error['password']= 'password cannot be empty';
        }
        if($confirmPassword == ''){
         $error['confirmPassword']= 'Confirm password cannot be empty';  
        }
        if($password != $confirmPassword){
         $error['match']= 'Passwords dont match';    
        }
        
        foreach($error as $key =>$value){
            if(empty($value)){
                unset($error[$key]);
             }
        }//foreach end
        
        if(empty($error)){
            $password = trim($_POST['password']);
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
            
                $stmt = mysqli_prepare($connection, "UPDATE users SET user_password='{$hashedPassword}' WHERE user_name = ?");
                mysqli_stmt_bind_param($stmt, "s", $user_name);
                mysqli_stmt_execute($stmt);

                if(mysqli_stmt_affected_rows($stmt) >= 1){
                    $changed = true; 
                }
                mysqli_stmt_close($stmt);    
        }
    }
    }else{
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
                            <small>Change password</small>
                        </h1>
                        <?php if(isset($changed)):?>
                           <p class ='bg-success'> Password changed <a href='index.php'>Go to Dashboard</a></p>
                        <?php endIf; ?>
                          <form action="" method="post" enctype="multipart/form-data">
                                    <p><?php echo isset($error['match']) ? $error['match'] : '' ?></p>
                                    <div class="form-group">
                                            <input id="password" name="password" placeholder="New password" class="form-control"  type="password">
                                        <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                    </div>
                                    <div class="form-group">
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm New password" class="form-control"  type="password">
                                        <p><?php echo isset($error['confirmPassword']) ? $error['confirmPassword'] : '' ?></p>
                                    </div>
                                    <div class="form-group">
                                        <input name="changePassword" class="btn btn-primary" value="Change Password" type="submit">
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
