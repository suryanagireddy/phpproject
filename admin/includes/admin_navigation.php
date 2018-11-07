<?php require_once 'functions.php'; ?>
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="../index.php">Home</a></li>
<!--        <li><a href=''>Users online:<//?php echo users_online(); ?></a></li>-->
        <li><a href="">Users Online: <span class="usersonline"></span></a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['user_name'] ?><b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                   <a href="./changepassword.php"><i class="fa fa-fw fa-key"></i>Change password</a>
                </li>
                
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    
    
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
           <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> My Dashboard</a>
            </li>
        
            <?php
                 if (session_status() === PHP_SESSION_NONE) session_start();
                 if(check_admin()):
             ?>
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Admin Dashboard</a>
                    </li>
            <?php  endIf;  ?>    
                    
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="./posts.php">View all posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add post</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-desktop"></i> Categories</a>
            </li>
            
            <?php
                 if (session_status() === PHP_SESSION_NONE) session_start();
                 if(check_admin()):
                     ?>
                    <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="users_dropdown" class="collapse">
                        <li>
                            <a href="users.php">View all Users</a>
                        </li>
                        <li>
                            <a href="users.php?source=add_user">Add User</a>
                        </li>
                        <li>
                            <a href="user_roles.php">Add User Role</a>
                        </li>
                    </ul>
                    </li>
            <?php  endIf;  ?>
            
            <li >
                <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments </a>
            </li>
            
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#profile_dropdown"><i class="fa fa-fw fa-wrench"></i> Profile <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="profile_dropdown" class="collapse">
                    <li>
                       <a href="./profile.php"> Edit Profile </a>
                    </li>
                    <li>
                        <a href="./changepassword.php">Change password</a>
                    </li>
                </ul>
            </li>
<!--
            <li>
                <a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Settings </a>
            </li>
-->
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>