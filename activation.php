<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<?php
    if(!isset($_GET['email']) && !isset($_GET['token'])){
        redirect('index.php');
    }
    if($stmt = mysqli_prepare($connection, 'SELECT user_name, user_email, status FROM users WHERE status=?')){
        mysqli_stmt_bind_param($stmt, "s", $_GET['status']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_name, $user_email, $status);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }


    if($_GET['status'] !== $status && $_GET['email'] !== $user_email){
        redirect('index.php');
    }
    
    if($_GET['status'] == $status && $_GET['email'] == $user_email){
        $active = 'Active';
         if($stmt = mysqli_prepare($connection, "UPDATE users SET status='$active' WHERE user_email = ?")){

            mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
            mysqli_stmt_execute($stmt);

            if(mysqli_stmt_affected_rows($stmt) >= 1){
                $activeUser = true;
            }
            mysqli_stmt_close($stmt);
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
                                
								<form action="login.php" id="login-form" role="form" autocomplete="off" class="form" method="post"> 
								<?php if(isset($activeUser)):?>
                                    <h4 style="text-align:center;color:green;"> Account activated. Please login using your credentials.</h4>
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





