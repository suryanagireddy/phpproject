<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

?>

<?php

if(!isset($_GET['forgot'])){
    redirect('index.php');
}

if(ifItIsMethod('post')){
    if(isset($_POST['email'])){
        $user_email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        
        if(useremail_exists($user_email)){
            $stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?");
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
            $mail->Subject = 'Reset password link';
            $mail->Body = '<p>Please use the link to reset the password
<a href="http://localhost/cms/reset.php?email='.$user_email.'&token='.$token.' ">http://localhost/cms/reset.php?email='.$user_email.'&token='.$token.'</a>
</p>';
            
            if($mail->send()){
                $emailSent = true;
            }
        }
        else{
            $notRegister = true;
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
                            <?php if(!isset($emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">
                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <?php if(isset($notRegister)):?>
                                            <p style="color: red;"> Email is not Registered </p>
                                        <?php endIf; ?>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>
                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>
                                </div><!-- Body-->
                            <?php else: ?>
                            <h2> Reset link sent, Please Check your mail </h2>

                            <?php endIf; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

