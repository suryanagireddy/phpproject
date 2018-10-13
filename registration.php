<?php  include "includes/header.php"; ?>
<?php  include "includes/db.php"; ?>

<?php

if($_SERVER['REQUEST_METHOD']=="POST"){
    $user_name = trim($_POST['user_name']);
    $user_email = trim($_POST['user_email']);
    $user_password = trim($_POST['user_password']);
    
   $error = [
       'username'=>'',
       'email'=>'',
       'password' =>''   
   ];
    
     if(strlen($user_name)<4){
         $error['username']= 'Username is too short';
     }  
     if($user_name == ''){
         $error['username']= 'Username cannot be empty';
     }
     if(username_exists($user_name)){
         $error['username']= 'User Name already exists';
     }
     if($user_email == ''){
         $error['email']= 'Email cannot be empty';
     }
     if(useremail_exists($user_email)){
         $error['email']= 'Email already exists, <a href="index.php>Please login</a>"';
     }
    if(strlen($user_password)<5){
         $error['password']= 'Password is too short';
     }  
     if($user_password ==''){
         $error['password']= 'Password cannot be empty';
     }

    foreach($error as $key =>$value){
        if(empty($value)){
            unset($error[$key]);
          
        }
    }//foreach end
  
    if(empty($error)){
        register_user($user_name, $user_email, $user_password);
        login_user($user_name, $user_password);  
    }
    
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
     <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="user-name" class="sr-only">Username</label>
                            <input type="text" name="user_name" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value = "<?php echo isset($user_name) ? $user_name : '' ?>">
                            
                            <p style="color: red;"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control" placeholder="Enter email" autocomplete="on" value = "<?php echo isset($user_email) ? $user_email : '' ?>">
                            
                            <p style="color: red;"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                            
                            <p style="color: red;"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>



<?php include "includes/footer.php";?>
