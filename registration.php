<?php  include "includes/header.php"; ?>
<?php  include "includes/db.php"; ?>

<?php

if(isset($_POST['submit'])){
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    
    if(!empty($user_name) && !empty($user_email) && !empty($user_password)){
    
    $user_name = mysqli_real_escape_string($connection, $user_name);
    $user_email = mysqli_real_escape_string($connection, $user_email);
    $user_password = mysqli_real_escape_string($connection, $user_password);
    
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>12));
        
//    $query = "SELECT randSalt FROM users";
//    $select_randsalt_query = mysqli_query($connection, $query);
//    if(!$select_randsalt_query){
//        die('Query failed!' . mysqli_error($connection));
//      }
//    //Encrypting password
//    $row = mysqli_fetch_array($select_randsalt_query);
//    $randSalt = $row['randSalt'];   
//    $user_password = crypt($user_password, $randSalt);
    
    $query = "INSERT INTO users (user_name, user_email, user_password, user_role, user_date) ";
    $query .= "VALUES('{$user_name}','{$user_email}', '{$user_password}', 'Subscriber', now())";
    $register_user_query = mysqli_query($connection, $query);
    if(!$register_user_query){
        die('Query failed!' . mysqli_error($connection));
      }
        $message = "Your Registration is submitted";
    }else{
        
        $message = "Fields cannot be empty";
        
    }
    
    
}
else {
    $message = "";
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
                       <h4 class='text-center'><?php echo $message; ?></h4>
                        <div class="form-group">
                            <label for="user-name" class="sr-only">Username</label>
                            <input type="text" name="user_name" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control" placeholder="Enter email">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>



<?php include "includes/footer.php";?>
