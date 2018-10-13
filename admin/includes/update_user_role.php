<form action="" method="post">
    <div class="form-group">
       <label for="role_title">Edit User Role Name</label>

        <?php
           // Update User role
            if (isset($_GET['edit'])){
            $user_role_id = $_GET['edit'];
            $query = "SELECT * FROM user_roles WHERE role_id = $user_role_id ";
            $select_edit_user_role = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc( $select_edit_user_role)){   
            $role_id  =  $row['role_id'];
            $role_title  =  $row['role_title'];
        ?>
        <input value= "<?php if(isset($role_title)){echo $role_title;} ?>" type="text" class= "form-control" name="role_title">
        <?php } } ?>

        <?php
            // Update category
            if(isset($_POST['update_role_title'])){
            $new_role_title = $_POST['role_title'];
                
            $stmt = mysqli_prepare($connection, "UPDATE user_roles SET role_title = ? WHERE role_id = ? ");
            mysqli_stmt_bind_param($stmt, 'si', $new_role_title, $user_role_id);
            mysqli_stmt_execute($stmt);    
            query_error($stmt);
            mysqli_stmt_close($stmt);
            header("Location: user_roles.php");
            }
        ?>

    </div>
    <div class="form-group">
        <input class = "btn btn-primary" type="submit" name="update_role_title" value = "Update User Role Name">
    </div>  
</form>  