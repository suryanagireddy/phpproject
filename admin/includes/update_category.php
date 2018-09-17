<form action="" method="post">
    <div class="form-group">
       <label for="cat_title">Edit Category</label>

        <?php
           // Update Category
            if (isset($_GET['edit'])){
            $cat_id = $_GET['edit'];
            $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
            $select_edit_category = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc( $select_edit_category)){   
            $cat_id  =  $row['cat_id'];
            $cat_title  =  $row['cat_title'];
        ?>
        <input value= "<?php if(isset($cat_title)){echo $cat_title;} ?>" type="text" class= "form-control" name="cat_title">
        <?php } } ?>

        <?php
            // Update category
            if(isset($_POST['update_category'])){
            $new_cat_title = $_POST['cat_title'];
            $query = "UPDATE categories SET cat_title = '{$new_cat_title}' WHERE cat_id = {$cat_id} ";
            $update_category_query = mysqli_query($connection, $query);
            query_error($update_category_query);
            header("Location: categories.php");
            }
           ?>

    </div>
    <div class="form-group">
        <input class = "btn btn-primary" type="submit" name="update_category" value = "Update Category">
    </div>  
</form>  