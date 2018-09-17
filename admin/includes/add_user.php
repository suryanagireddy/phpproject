<?php
if(isset($_POST['create_user'])){
        $user_name  =  $_POST['user_name'];
        $user_password =  $_POST['user_password'];
        $user_firstname  =  $_POST['user_firstname'];
        $user_lastname =  $_POST['user_lastname'];
        $user_email =  $_POST['user_email'];
        $user_role = $_POST['user_role'];
        $user_date = date('d-m-y');
    
        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];  
        move_uploaded_file($user_image_temp, "../images/$user_image");
    
    //Encrypting password
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>10));
    
    $query = "INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_image, user_email, user_role, user_date)";
    $query .= "VALUES ('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_image}', '{$user_email}', '{$user_role}', now())  ";
    
    $add_user_query = mysqli_query($connection, $query);
    
    query_error($add_user_query);
//    header("Location: users.php");
    echo "<p class ='bg-success'> User Created <a href='users.php'>View all users</a></p>";    
}

?>



<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="user-firstname">First Name</label>
    <input type="text" class="form-control" name="user_firstname">
</div>
<div class="form-group">
    <label for="user-lastname">Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
</div>

<div class="form-group">
    <label for="user-image">Image</label>
    <input type="file" name="user_image">
</div>

<div class="form-group">
<label for="user-role">User Role</label><br>
<select name="user_role" id="">
  <option value="Subscriber">Select option</option>
  <option value="Admin">Admin</option>
  <option value="Editor">Editor</option>
  <option value="Subscriber">Subscriber</option>
</select>
</div>

<div class="form-group">
    <label for="user-name">Username</label>
    <input type="text" class="form-control" name="user_name">
</div>
<div class="form-group">
    <label for="user-email">Email</label>
    <input type="email" class="form-control" name="user_email">
</div>

<div class="form-group">
    <label for="user-password">Password</label>
    <input type="password" class="form-control" name="user_password">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" name = "create_user" value = "Create User">
</div>
</form>