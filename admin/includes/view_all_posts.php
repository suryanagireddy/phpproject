<?php
include("delete_modal.php");

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $postValueId){ 
       $bulk_options = $_POST['bulk_options'];
        
        switch($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_post_publish = mysqli_query($connection, $query);
                break;
                
            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_post_draft = mysqli_query($connection, $query);
                break;
                
                
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $delete_post_query = mysqli_query($connection, $query);
                break;
                
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId}";
                $select_post_query = mysqli_query($connection, $query);
                
                while($row = mysqli_fetch_array($select_post_query)){
                $post_title  =  $row['post_title'];
                $post_author  =  $row['post_author'];
                $post_category_id  =  $row['post_category_id'];
                $post_status  =  $row['post_status'];
                $post_image =  $row['post_image'];
                $post_tags  =  $row['post_tags'];
                $post_content = $row['post_content'];
                $post_date =$row['post_date'];  
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status)";
                $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}',now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')  ";

                $clone_post_query = mysqli_query($connection, $query);

                query_error($clone_post_query);
                break;
                
        }
        
    }
}


?>


<form action="" method ="post">
<table class= "table table-bordered table-hover">
<div id="bulkOptionsContainer" class="col-xs-4">
    
    <select class="form-control" name="bulk_options" id="">
        <option value="">Select options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
        <option value="delete">Delete</option>
        <option value="clone">Clone</option>
        
    </select>
</div>
<div class="col-xs-4">
    <input type="submit" name="submit" class="btn btn-success" value ="Apply">
    <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
</div>    


<thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Views</th>
        <th>View post</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
</thead>
<tbody>
<?php

//Find all posts
   //$query = "SELECT * FROM posts ORDER BY post_id DESC";
    
   $query = "SELECT posts.post_id, posts.post_title, posts.post_author, posts.post_category_id, posts.post_status, posts.post_image, " ;
   $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
   $query .= "FROM posts ";
   $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
    
   $select_posts = mysqli_query($connection, $query);
   while($row = mysqli_fetch_assoc($select_posts))
   {   
        $post_id  =  $row['post_id'];
        $post_title  =  $row['post_title'];
        $post_author  =  $row['post_author'];
        $post_category_id  =  $row['post_category_id'];
        $post_status  =  $row['post_status'];
        $post_image =  $row['post_image'];
        $post_tags  =  $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date =$row['post_date'];
        $post_views_count = $row['post_views_count'];
       
        $cat_id  =  $row['cat_id'];
        $cat_title  =  $row['cat_title'];
       
       echo "<tr>";
       ?>
       
       <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value ='<?php echo $post_id;  ?>'></td>
       
       <?php
        echo "<td>{$post_id}</td>"; 
        echo "<td>{$post_title}</td>";
        echo "<td>{$post_author}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_image' alt = 'image'></td>";
        echo "<td>{$post_tags}</td>";
       
       $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
       $comment_count_query= mysqli_query($connection,$query);
       query_error($comment_count_query);
       $count_comments = mysqli_num_rows($comment_count_query);

        echo "<td><a href='post_comments.php?id=$post_id' >$count_comments</a></td>";
       
        echo "<td>{$post_date}</td>";
        echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
        echo "<td><a class='btn-xs btn-primary' href='../post.php?p_id={$post_id}'>View</a></td>";
        echo "<td><a class='btn-xs btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
       
       ?>
       <form method="post">
           <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
           
           <td><input rel='<?php echo $post_id ?>' class ="btn-xs btn-danger del_link" type ="submit" name = "delete" value = "Delete"></td>
       </form>
       
       <?php
//        echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');0 \" href='posts.php?delete=           {$post_id}'>Delete</a></td>";
       
//        echo "<td><a rel= '$post_id' href='javascript:void(0)' class = 'delete-link'>Delete</a></td>";
        echo "</tr>";
   }
?>
</tbody>
</table>


<?php  
if(isset($_POST['delete_item']))
{
    $delete_post_id = $_POST['delete_item'];
    
    $query = "DELETE FROM posts WHERE post_id ={$delete_post_id}";
    $delete_post_query = mysqli_query($connection, $query);
    query_error($delete_post_query);
    //Delete comments linked to the post
    $query = "DELETE FROM comments WHERE comment_post_id ={$delete_post_id}";
    $delete_post_comments_query = mysqli_query($connection, $query);
    query_error($delete_post_comments_query);
    
    header ( "Location: posts.php" );
}
    
if(isset($_GET['reset']))
{
    $reset_post_id = $_GET['reset'];
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
    
    $reset_view_query = mysqli_query($connection, $query);
    
    query_error($reset_view_query);
    header ( "Location: posts.php" );
}


?>
</form>


<script>
$(document).ready(function(){
    
//   $(".delete-link").on('click', function(){
//       var id = $(this).attr("rel");
//       var delete_url = "posts.php?delete="+ id +"";
//       $(".delete-modal-link").attr("href", delete_url);
//       $("#myModal").modal('show');
//   }); 
    
     
        $(".del_link").on('click', function(e){
            e.preventDefault();
            var p_id = $(this).attr("rel");
            $(".delete-modal-link").val(p_id);  
            $(".modal-body").html("<h4>Are you sure you want to delete post " + p_id + "? </h4>" );
            $("#myModal").modal('show');
        });
    });
</script>
    
