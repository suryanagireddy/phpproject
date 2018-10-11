<?php  include "includes/header.php"; ?>
<?php  include "includes/db.php"; ?>

<?php
if(isset($_POST['submit'])){
    
    $from = "From:" .$_POST['from_email'];
    $to = "srnagire@gmail.com";
    $subject = wordwrap($_POST['subject'],70);
    $body = $_POST['message'];
    
    if(!empty($from) && !empty($subject) && !empty($body)){
    mail($to,$subject,$body,$from);
    $message = "Your Form is submitted";   
    }
    else{  
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                       <h4 class='text-center'><?php echo $message; ?></h4>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="from_email" id="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Enter Message here"></textarea>
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


<hr>



<?php include "includes/footer.php";?>
