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
                
            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
            mysqli_stmt_bind_param($stmt, 'si', $new_cat_title, $cat_id);
            mysqli_stmt_execute($stmt);    
            query_error($stmt);
            mysqli_stmt_close($stmt);
            header("Location: categories.php");
            }
        ?>

    </div>
    <div class="form-group">
        <input class = "btn btn-primary" type="submit" name="update_category" value = "Update Category">
    </div>  
</form>  