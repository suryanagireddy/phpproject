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
        <th>Change to Admin</th>
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
        echo "<td><a href='users.php?change_role={$user_id}'>Make Admin</a></td>";
        echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>";
        echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
   }
?>
</tbody>
</table>


<?php
if(isset($_GET['change_role']))
{
    $change_user_id = $_GET['change_role'];
    $query = "UPDATE users SET user_role ='Admin' WHERE user_id = $change_user_id ";
    
    $change_user_query = mysqli_query($connection, $query);
    
    query_error($change_user_query);
    header ( "Location: users.php" );
}

if(isset($_GET['delete']))
{
    $delete_user_id = $_GET['delete'];
    $query = "DELETE FROM users WHERE user_id ={$delete_user_id}";
    
    $delete_user_query = mysqli_query($connection, $query);
    
    query_error($delete_user_query);
    header ( "Location: users.php" );
}


?>


</form>