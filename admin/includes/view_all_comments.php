<?php
include("delete_modal.php");
?>

<table class= "table table-bordered table-hover">
<thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Email</th>
        <th>Comment</th>
        <th>Date</th>
        <th>Status</th>
        <th>In response to</th>
        <th>Change status</th>
        <th>Delete</th>
    </tr>
</thead>
<tbody>
<?php

//Find all comments
   $query = "SELECT * FROM comments";
   $select_comments = mysqli_query($connection, $query);
   while($row = mysqli_fetch_assoc( $select_comments))
   {   
        $comment_id  =  $row['comment_id'];
        $comment_author  =  $row['comment_author'];
        $comment_email =  $row['comment_email'];
        $comment_content  =  $row['comment_content'];
        $comment_status  =  $row['comment_status'];
        $comment_date =  $row['comment_date'];
        $comment_post_id  =  $row['comment_post_id'];
        
       
        echo "<tr>";
        echo "<td>{$comment_id}</td>"; 
        echo "<td>{$comment_author}</td>";
        echo "<td>{$comment_email}</td>";          
        echo "<td>{$comment_content}</td>";      
        echo "<td>{$comment_date}</td>";
        echo "<td>{$comment_status}</td>";
       
       
           $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
           $select_post_comment = mysqli_query($connection, $query);
       
           while($row =mysqli_fetch_assoc($select_post_comment)) {
           $comment_post_id = $row['post_id'];
           $comment_post_title = $row['post_title'];
           
           echo "<td><a class='btn-xs btn-primary' href='../post.php?p_id=$comment_post_id'>{$comment_post_title}</td>";
           } 
        
            if($comment_status == 'Approved'){
                echo "<td><a class='btn-xs btn-warning' href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
            }
            else{
               echo "<td><a class='btn-xs btn-success' href='comments.php?approve={$comment_id}'>Approve</a></td>";
            }
        
       ?>
       
           <form method="post">
               <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">

               <td><input rel='<?php echo $comment_id ?>' class ="btn-xs btn-danger del_link" type ="submit" name = "delete" value = "Delete"></td>
           </form>
       
       <?php   
        echo "</tr>";     
   }
?>
</tbody>
</table>


<?php
//Unapprove comment
if(isset($_GET['unapprove']))
{
    $unapprove_comment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status ='Unapproved' WHERE comment_id = $unapprove_comment_id ";
    
    $unapprove_comment_query = mysqli_query($connection, $query);
    
    query_error($unapprove_comment_query);
    header ( "Location: comments.php" );
}

//Approve comment
if(isset($_GET['approve']))
{
    $approve_comment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status ='Approved' WHERE comment_id = $approve_comment_id ";
    
    $approve_comment_query = mysqli_query($connection, $query);
    
    query_error($approve_comment_query);
    header ( "Location: comments.php" );
}

//Delete comment
if(isset($_POST['delete_item']))
{
    if(check_admin()){
    $delete_comment_id = $_POST['delete_item'];
    $query = "DELETE FROM comments WHERE comment_id ={$delete_comment_id}";
    
    $delete_comment_query = mysqli_query($connection, $query);
    
    query_error($delete_comment_query);
    header ( "Location: comments.php" );
    }
    else
    {
      header ( "Location: comments.php" );  
    }
}
?>


<script>
$(document).ready(function(){ 
        $(".del_link").on('click', function(e){
            e.preventDefault();
            var c_id = $(this).attr("rel");
            $(".delete-modal-link").val(c_id);  
            $(".modal-body").html("<h4>Are you sure you want to delete this comment " + c_id + "? </h4>" );
            $("#myModal").modal('show');
        });
    });
</script>