<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php
       checkIfUserIsLoggedInAndRedirect('/admin');
       if(ifItIsMethod('post')){
           if(isset($_POST['user_name']) && isset($_POST['user_password'])){
              $user_name = trim($_POST['user_name']);
              $user_password = trim($_POST['user_password']);
              $user_name = mysqli_real_escape_string($connection, $user_name);
              $user_password = mysqli_real_escape_string($connection, $user_password);
               
               $error = ['username'=>'', 'password' =>'']; 
              
               if($user_name == ''){
                $error['username']= 'Username cannot be empty';
                }
               
               if($user_name != ''){
               if(!username_exists($user_name)){
                 $error['username']= 'User Name doesnot exists';
                 }
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
                   login_user($user_name, $user_password);
                   
                   if(login_user($user_name, $user_password) === false){
                       $nologin = true;  
                   }
               }
          }	
       }
?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">
							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">
                                
								<form id="login-form" role="form" autocomplete="off" class="form" method="post"> 
								<?php if(isset($nologin)):?>
                                    <p> Wrong Credentials!! Forgot password <a href="forgot.php?forgot=<?php echo uniqid(true); ?>"> Click here</a> </p>
                                <?php endIf; ?> 
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input type="text" name="user_name" class="form-control" id="username" placeholder="Enter Username" autocomplete="on" value = "<?php echo isset($user_name) ? $user_name : '' ?>">
										</div>
										<p style="color: red;"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="user_password" type="password" class="form-control" placeholder="Enter Password">
										</div>
										<p style="color: red;"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
									</div>

									<div class="form-group">
										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>
                                   
                                    <div class="form-group">
                                        <a href="forgot.php?forgot=<?php echo uniqid(true); ?>"> Forgot Password </a>
                                    </div>

								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->
