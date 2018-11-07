<?php
if(isset($_POST['create_post'])){
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['post_author'];
    
        $result = query("SELECT * FROM users WHERE user_name='$post_author'");
        query_error($result);
        $user = mysqli_fetch_array($result);
        $post_user_id = $user['user_id'];
    
    $post_status = $_POST['post_status'];
    
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    $post_date = date('d-m-y');
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user_id, post_date, post_image, post_content, post_tags, post_status)";
    $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}','$post_user_id', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')  ";
    
    $new_post_query = mysqli_query($connection, $query);
    
    query_error($new_post_query);
    
    $the_post_id = mysqli_insert_id($connection);
    
    echo "<p class ='bg-success'> Post Created <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>View all posts</a></p>"; 
}

?>



<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
    <label for="post-title">Post Title</label>
    <input type="text" class="form-control" name="post_title">
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
        echo "<option value='$cat_id'>{$cat_title}</option>";
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
        echo "<option value='$user_name'>{$user_name}</option>";
    }
?>
</select>
</div>

<div class="form-group">
    <label for="post-status">Post Status</label>
    <select name="post_status" id="">
        <option value="draft">Select Options</option>
        <option value="published">Publish</option>
        <option value="draft">Draft</option>
    </select>
    
</div>
<div class="form-group">
    <label for="post-image">Post Image</label>
    <input type="file" name="post_image">
</div>
<div class="form-group">
    <label for="post-content">Post Content</label>
    <textarea class="form-control" name="post_content" id ="body" cols="30" rows="10"></textarea>
</div>
<div class="form-group">
    <label for="post-tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" name = "create_post" value = "Create post">
</div>
</form>