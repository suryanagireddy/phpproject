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
        <th>Approve</th>
        <th>Unapprove</th>
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
           
           echo "<td><a href='../post.php?p_id=$comment_post_id'>{$comment_post_title}</td>";
           } 
        

        
        echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>";
        echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";
        echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";
        echo "</tr>";
   }
?>
</tbody>
</table>


<?php 
if(isset($_GET['unapprove']))
{
    $unapprove_comment_id = $_GET['unapprove'];
    $query = "UPDATE comments SET comment_status ='Unapproved' WHERE comment_id = $unapprove_comment_id ";
    
    $unapprove_comment_query = mysqli_query($connection, $query);
    
    query_error($unapprove_comment_query);
    header ( "Location: comments.php" );
}

if(isset($_GET['approve']))
{
    $approve_comment_id = $_GET['approve'];
    $query = "UPDATE comments SET comment_status ='Approved' WHERE comment_id = $approve_comment_id ";
    
    $approve_comment_query = mysqli_query($connection, $query);
    
    query_error($approve_comment_query);
    header ( "Location: comments.php" );
}



if(isset($_GET['delete']))
{
    $delete_comment_id = $_GET['delete'];
    $query = "DELETE FROM comments WHERE comment_id ={$delete_comment_id}";
    
    $delete_comment_query = mysqli_query($connection, $query);
    
    query_error($delete_comment_query);
    header ( "Location: comments.php" );
    
    
    //update comment count
//    $query = "UPDATE posts SET post_comment_count = post_comment_count - 1 ";
//    $query .= "WHERE post_id = $comment_post_id ";
//
//    $update_comment_count =  mysqli_query($connection, $query);
}


?>