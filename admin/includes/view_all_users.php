<?php
include("delete_modal.php");
?>

<table class= "table table-bordered table-hover">
<thead>
    <tr>
        <th>Id</th>
        <th>UserName</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Image</th>
        <th>Email</th>
        <th>Role</th>
        <th>Date</th>
        <th>Admin</th>
        <th>Edit</th>
        <th>Delete</th>

    </tr>
</thead>
<tbody>
<?php

//Find all USERS
   $query = "SELECT * FROM users";
   $select_users = mysqli_query($connection, $query);
   while($row = mysqli_fetch_assoc( $select_users))
   {   
        $user_id  =  $row['user_id'];
        $user_name  =  $row['user_name'];
        $user_password =  $row['user_password'];
        $user_firstname  =  $row['user_firstname'];
        $user_lastname =  $row['user_lastname'];
        $user_email =  $row['user_email'];
        $user_image  =  $row['user_image'];
        $user_role = $row['user_role'];
        $user_date = $row['user_date'];
        
       
        echo "<tr>";
        echo "<td>{$user_id}</td>"; 
        echo "<td>{$user_name}</td>";
        echo "<td>{$user_firstname}</td>";          
        echo "<td>{$user_lastname}</td>";
        echo "<td><img width='100' src='../images/$user_image' alt = 'image'></td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td>{$user_date}</td>";
       
       if($user_role == 'Admin'){
         echo "<td><a class='btn-xs btn-primary' href='users.php?change_role={$user_id}'>Remove Admin</a></td>";  
       }else{
            echo "<td><a class='btn-xs btn-primary' href='users.php?change_role_admin={$user_id}'>Make Admin</a></td>";   
       }
       
        echo "<td><a class='btn-xs btn-info' href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
       
       ?>
       
       <form method="post">
               <input type="hidden" name="user_id" value="<?php echo $user_id ?>">

               <td><input rel='<?php echo $user_id ?>' class ="btn-xs btn-danger del_link" type ="submit" name = "delete" value = "Delete"></td>
        </form>
       
       <?php
        //echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
   }
?>
</tbody>
</table>


<?php
if(isset($_GET['change_role_admin']))
{
    $change_user_id = $_GET['change_role_admin'];
    $query = "UPDATE users SET user_role ='Admin' WHERE user_id = $change_user_id ";
    
    $change_user_query = mysqli_query($connection, $query);
    
    query_error($change_user_query);
    header ( "Location: users.php" );
}

if(isset($_GET['change_role']))
{
    $change_user_id = $_GET['change_role'];
    $query = "UPDATE users SET user_role ='Subscriber' WHERE user_id = $change_user_id ";
    
    $change_user_query = mysqli_query($connection, $query);
    
    query_error($change_user_query);
    header ( "Location: users.php" );
}

if(isset($_POST['delete_item']))
{
    if(check_admin()){
    $delete_user_id = $_POST['delete_item'];
    $query = "DELETE FROM users WHERE user_id ={$delete_user_id}";
    
    $delete_user_query = mysqli_query($connection, $query);
    
    query_error($delete_user_query);
    header ( "Location: users.php" );
    }
    else
    {
      header ( "Location: users.php" );  
    }
}


?>

<script>
$(document).ready(function(){ 
        $(".del_link").on('click', function(e){
            e.preventDefault();
            var u_id = $(this).attr("rel");
            $(".delete-modal-link").val(u_id);  
            $(".modal-body").html("<h4>Are you sure you want to delete this user " + u_id + "? </h4>" );
            $("#myModal").modal('show');
        });
    });
</script>


