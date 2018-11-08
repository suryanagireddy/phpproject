<?php  include "includes/header.php"; ?>
<?php  include "includes/db.php"; ?>

<?php 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

?>

<?php

require 'vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$options = array(
    'cluster' => 'ap1',
    'encrypted' => true
);

$pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);

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
         $error['email']= 'Email already exists, <a href="login.php">Click here to login</a>';
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

        $data['message'] = $user_name;

        $pusher->trigger('notifications', 'new_user', $data);
        
        //welcome mail
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        
        $stmt = mysqli_prepare($connection, "UPDATE users SET status='{$token}' WHERE user_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $user_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
            
            /**
            Mail sending
            **/
            $mail = new PHPMailer();
                                     
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = Config::SMTP_HOST;                      // Specify main and backup SMTP servers
            $mail->Username = Config::SMTP_USER;                  // SMTP username
            $mail->Password = Config::SMTP_PASSWORD;              // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = Config::SMTP_PORT;                      // TCP port to connect to
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom('srnagire@gmail.com', 'Surya');
            $mail->addAddress($user_email);
            $mail->Subject = 'Welcome email';
            $mail -> Body = '<h2 style="color:blue;">Hi '.$user_name.',</h2> 
                    <p>Thanks for signing up with Surya Blog</p>
                    <h3> Account Activation link: </h3><a href="http://localhost/cms/activation.php?email='.$user_email.'&status='.$token.' ">Click here</a>
                    <h4 style="color:grey;"> Regards,</br> SriSuryaOnline Team </h4> ';
       
            if($mail->send()){
                $registerUser = true;
            }
            else{
                return false;
            }
    }
    
}

?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
     <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
       <?php if(isset($registerUser)){ ?>
            <h2 style="text-align:center;color:green;"> Successfully registered. Please check your mail for activation link.</h2>
        <?php } else { ?>
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
    <?php } ?>
</section>


<hr>



<?php include "includes/footer.php";?>
