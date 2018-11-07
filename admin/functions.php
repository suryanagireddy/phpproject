<?php

//===== DATABASE HELPER FUNCTIONS =====//

function stmtConnection(){
    global $connection;
    return mysqli_stmt_init($connection);
}

function redirect($location){
    header("Location:" . $location);
    exit;
}

function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    query_error($result);
    return $result;
}

function query_error($result){
    global $connection;
    if(!$result){
        die("Error". mysqli_error($connection));
    }
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}

function count_records($result){
    return mysqli_num_rows($result);
}

//===== END DATABASE HELPERS =====//

//===== AUTHENTICATION HELPERS =====//

function check_admin(){
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id=".$_SESSION['user_id']."");
        $row = fetchRecords($result);
        if($row['user_role'] == 'Admin'){
            return true;
        }else {
            return false;
        }
    }
    return false;    
}

function is_admin($user_name){
    global $connection;
    
    $query = "SELECT user_role FROM users WHERE user_name = '$user_name'";
    $user_query = mysqli_query($connection, $query);
    
    $row = mysqli_fetch_array($user_query);
    
    if($row['user_role'] == 'Admin'){
        return true;
    }
    else {
        return false;
    }     
}

//===== END AUTHENTICATION HELPERS =====//

//===== USER HELPERS =====//

function get_user_name(){
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
   return false; 
}

function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE user_name='" . $_SESSION['user_name'] ."'");
        query_error($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

//===== END USER HELPERS =====//

//===== GENERAL HELPERS =====//

function imagePlaceholder($image=''){
    if(!$image){
        return 'default.jpg';
    }
    else{
        return $image;
    }
}

function escape($string) {
   global $connection;
   return mysqli_real_escape_string($connection, trim($string));
}

function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

//===== END GENERAL HELPERS =====//

//===== USER SPECIFIC HELPERS=====//

function is_the_logged_in_user_owner($post_id){
    $result = query("SELECT user_id FROM posts WHERE post_id={$post_id} AND user_id=".loggedInUserId()."");
    return count_records($result) >= 1 ? true : false;
}

function get_all_user_posts(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts WHERE post_author= '$post_author' ");
    //return query("SELECT * FROM posts WHERE post_author= " .get_user_name(). "");
}

function get_all_posts_user_comments(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author= '$post_author'");
}

function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}

function get_all_user_published_posts(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts WHERE post_author= '$post_author' AND post_status='published'");
}

function get_all_user_draft_posts(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts WHERE post_author= '$post_author' AND post_status='draft'");
}

function get_all_user_approved_posts_comments(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author= '$post_author' AND comment_status='Approved'");
}

function get_all_user_unapproved_posts_comments(){
    $post_author= get_user_name();
    return query("SELECT * FROM posts INNER JOIN comments ON posts.post_id = comments.comment_post_id WHERE post_author= '$post_author' AND comment_status='Unapproved'");
}

//===== END USER SPECIFIC HELPERS=====//

//===== POST LIKE HELPERS =====//

function userLikedThisPost($post_id){
    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    query_error($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostlikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    query_error($result);
    echo mysqli_num_rows($result);

}

//===== END POST LIKE HELPERS =====//

function set_message($msg){
  if(!$msg){
           $_SESSION['message']= $msg;
           } 
   else{
        $msg = "";
    }
}


function display_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

//===== CATEGORY ONLINE HELPERS =====//

function add_category($cat_title){ 
     global $connection;
     // Add Category
      $user_id = loggedInUserId();
      $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title,user_id) VALUES(?,?) ");
      mysqli_stmt_bind_param($stmt, 'si', $cat_title, $user_id);
      mysqli_stmt_execute($stmt);
      query_error($stmt);

      //close db connection
      mysqli_stmt_close($stmt); 
}

function find_all_categories(){
       global $connection;
       //Find all categories
       $query = "SELECT * FROM categories";
       $select_categories = mysqli_query($connection, $query);
       while($row = mysqli_fetch_assoc( $select_categories))
       {   
        $cat_id  =  $row['cat_id'];
        $cat_title  =  $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>"; 
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "</tr>";
       }
}

function delete_category($delete_cat_id){
    global $connection;
    //Delete Category
    $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
    $delete_category =mysqli_query($connection, $query);
    header("Location: categories.php");

}

//===== END CARTEGORY HELPERS =====//

//===== USER ROLE HELPERS =====//

function add_user_role($role_title){ 
     global $connection;
     // Add user role
        $stmt = mysqli_prepare($connection, "INSERT INTO user_roles(role_title) VALUES(?) ");
        mysqli_stmt_bind_param($stmt, 's', $role_title);
        mysqli_stmt_execute($stmt);
        query_error($stmt);
    // close db connection
        mysqli_stmt_close($stmt); 
    
    header("Location: user_roles.php");
}

function find_all_user_roles(){
       global $connection;
       //Find all user_roles
       $query = "SELECT * FROM user_roles";
       $select_user_roles = mysqli_query($connection, $query);
       while($row = mysqli_fetch_assoc( $select_user_roles))
       {   
        $role_id  =  $row['role_id'];
        $role_title  =  $row['role_title'];
        echo "<tr>";
        echo "<td>{$role_id}</td>"; 
        echo "<td>{$role_title}</td>";
        echo "<td><a href='user_roles.php?edit={$role_id}'>Edit</a></td>";
        echo "<td><a href='user_roles.php?delete={$role_id}'>Delete</a></td>";
        echo "</tr>";
       }
}

function delete_user_role($delete_user_role_id){
    global $connection;
    //Delete user role
    $query = "DELETE FROM user_roles WHERE role_id = {$delete_user_role_id}";
    $delete_user_role =mysqli_query($connection, $query);
    header("Location: user_roles.php");
}

//===== END USER ROLE HELPERS =====//

//===== USERS ONLINE HELPERS =====//

function users_online(){ 
    if(isset($_GET['onlineusers'])){
      global $connection;
        if(!$connection){
            session_start();
            include("../includes/db.php");
            $session = session_id();

            $time = time();
            $time_out_in_seconds = 30;
            $time_out  = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if($count == NULL){
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            }else{
             mysqli_query($connection, "UPDATE users_online SET time ='$time' WHERE session = '$session'"); 
            }

            $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'"); 
            echo $users_online_count = mysqli_num_rows($users_online_query);   
        }
    }//get request isset()     
}
users_online();

//===== END USERS ONLINE HELPERS =====//

//===== DASHBOARD COUNT HELPERS =====//

function recordCount($table){
    global $connection;
    
    $query = "SELECT * FROM $table";
    $select_all_from_table = mysqli_query($connection, $query);
    $count = mysqli_num_rows($select_all_from_table);
    
    return $count;
}


function checkCount($table, $column, $status){
    global $connection;
    
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $select_all_from_table = mysqli_query($connection, $query);
    $status_count = mysqli_num_rows($select_all_from_table);
    
    return $status_count;
    
}

//===== END DASHBOARD COUNT HELPERS =====//

// TO check user_name exists

function username_exists($user_name){
    global $connection;
    
    $query = "SELECT user_name FROM users WHERE user_name = '$user_name'";
    $user_name_query = mysqli_query($connection, $query);
    query_error($user_name_query);
    
    if(mysqli_num_rows($user_name_query) > 0){
        return true;
    }else{
        return false;
    }    
}


// TO check user_email exists
function useremail_exists($user_email){
    global $connection;
    
    $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
    $user_email_query = mysqli_query($connection, $query);
    query_error($user_email_query);
    
    if(mysqli_num_rows($user_email_query) > 0){
        return true;
    }else{
        return false;
    }    
}

// Register user
function register_user($user_name, $user_email, $user_password){
    
    global $connection;
    
    $user_name = mysqli_real_escape_string($connection, $user_name);
    $user_email = mysqli_real_escape_string($connection, $user_email);
    $user_password = mysqli_real_escape_string($connection, $user_password);
    
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=>12));
            
    $query = "INSERT INTO users (user_name, user_email, user_password, user_role, user_date) ";
    $query .= "VALUES('{$user_name}','{$user_email}', '{$user_password}', 'Subscriber', now())";
    $register_user_query = mysqli_query($connection, $query);
    query_error($register_user_query);   
    
}


// Login the user

function login_user($user_name, $user_password){
    
    global $connection;
    
    $user_name = mysqli_real_escape_string($connection, $user_name);
    $user_password = mysqli_real_escape_string($connection, $user_password);
    
    $query = "SELECT * FROM users WHERE user_name = '{$user_name}'";
    $select_user_query = mysqli_query($connection, $query);
    query_error($select_user_query);
    
    while($row = mysqli_fetch_array($select_user_query)){
        $db_user_id = $row['user_id'];
        $db_user_name = $row['user_name'];
        $db_user_password =  $row['user_password'];
        $db_user_firstname  =  $row['user_firstname'];
        $db_user_lastname =  $row['user_lastname'];
        $db_user_email =  $row['user_email'];
        $db_user_role = $row['user_role'];
     
     if(password_verify($user_password,$db_user_password)){
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['user_name'] = $db_user_name;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        redirect("/cms/admin");
    }
    else{
        return false;
    }
  }
  return false;   
}

?>