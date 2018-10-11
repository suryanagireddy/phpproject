<?php
if(isset($_GET['p_id'])){
 $edit_post_id =  $_GET['p_id'];   
}
   $query = "SELECT * FROM posts WHERE post_id = $edit_post_id ";
   $select_posts_by_id = mysqli_query($connection, $query);
   while($row = mysqli_fetch_assoc( $select_posts_by_id))
   {   
        $post_id  =  $row['post_id'];
        $post_title  =  $row['post_title'];
        $post_author  =  $row['post_author'];
        $post_category_id  =  $row['post_category_id'];
        $post_status  =  $row['post_status'];
        $post_image =  $row['post_image'];
        $post_tags  =  $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        $post_date =$row['post_date'];
   }

if(isset($_POST['update_post'])){
    $post_title  =  $_POST['post_title'];
    $post_author  =  $_POST['post_author'];
    $post_category_id  = $_POST['post_category_id'];
    $post_status  =  $_POST['post_status'];
    $post_image =  $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags  =  $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
        $select_image = mysqli_query($connection,$query);
        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row['post_image'];
        }
    }
    
    $query = "UPDATE posts SET ";
    $query .="post_title = '{$post_title}',";
    $query .="post_author = '{$post_author}',";
    $query .="post_category_id = '{$post_category_id}',";
    $query .="post_status = '{$post_status}',";
    $query .="post_title = '{$post_title}',";
    $query .="post_image = '{$post_image}',";
    $query .="post_tags = '{$post_tags}',";
    $query .="post_content = '{$post_content}',";
    $query .="post_date = now() ";
    $query .="WHERE post_id = '{$edit_post_id}' ";
    
    $update_post_query = mysqli_query($connection,$query);
    query_error($update_post_query);
    
    echo "<p class ='bg-success'> Post Updated <a href='../post.php?p_id={$edit_post_id}'>View Post</a> or <a href='posts.php'>View all posts</a></p>";
    //header("Location: posts.php");
        
}
?>

<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="post-title">Post Title</label>
    <input value="<?php echo $post_title ?>" type="text" class="form-control" name="post_title">
</div>

<div class="form-group">
<label for="post_category-id">Post Category</label>
<select name="post_category_id" id="">
<?php
    $query = "SELECT * FROM categories";
    $select_category = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc( $select_category)){   
    $cat_id  =  $row['cat_id'];
    $cat_title  =  $row['cat_title'];
    if($cat_id == $post_category_id){
        echo "<option selected value='$cat_id'>{$cat_title}</option>";
    }else{
        echo "<option value='$cat_id'>{$cat_title}</option>";
    }
    }
?>
</select>
</div>

<div class="form-group">
<label for="post-author">Post Author</label>
<select name="post_author" id="">
<?php
    $query = "SELECT * FROM users";
    $select_user = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc( $select_user)){   
    $user_name  =  $row['user_name'];
    if($user_name == $post_author){
        echo "<option selected value='$user_name'>{$user_name}</option>";
     }else{
        echo "<option value='$user_name'>{$user_name}</option>";
     }
    }
?>
</select>
</div>

<div class="form-group">
    <label for="post-status">Post Status</label>
    <select name="post_status" id="">
    <option value="<?php echo $post_status ?>"><?php echo $post_status; ?></option>
    <?php
    if($post_status == 'published'){
        echo "<option value='draft'>Draft</option>";   
    }
    else{
      echo "<option value='published'>Publish</option>";   
    }
    ?>
    
</select>
</div>
<div class="form-group">
    <label for="post-image">Post Image</label><br>
    <img width="100" src="../images/<?php echo $post_image; ?>">
    <input type="file" name="post_image">
</div>
<div class="form-group">
    <label for="post-content">Post Content</label>
    <textarea class="form-control" name="post_content" id ="body" cols="30" rows="10"><?php echo $post_content ?></textarea>
</div>
<div class="form-group">
    <label for="post-tags">Post Tags</label>
    <input value="<?php echo $post_tags ?>" type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" name = "update_post" value = "Update post">
</div>
</form>