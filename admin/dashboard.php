<?php include "includes/admin_header.php" ?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin Dashboard - 
                            <small><?php echo strtoupper(get_user_name()); ?></small>
                        </h1>
                    </div>
                </div>
    
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                       <div class='huge'> 
                                          <?php echo $posts_count = recordCount('posts'); ?>
                                        </div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'> 
                                          <?php echo $comments_count = recordCount('comments'); ?>
                                    </div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'> 
                                          <?php echo $users_count = recordCount('users'); ?>
                                        </div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'> 
                                          <?php echo $categories_count = recordCount('categories'); ?>
                                        </div>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.chart -->
                <?php
                $posts_publish_count = checkCount('posts', 'post_status', 'published');
                $posts_draft_count = checkCount('posts', 'post_status', 'draft');
                $comments_unapproved_count = checkCount('comments', 'comment_status', 'Unapproved');
                $users_subscribers_count = checkCount('users', 'user_role', 'Subscriber');

                ?>
                
                <div class="row"> 
                    <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
                            
                            <?php
                                $element_text = ['All Posts','Publish Posts' ,'Draft Posts', 'Comments', 'Unappoved comments', 'Users', 'Subscribers', 'Categories'];
                                $element_count = [$posts_count, $posts_publish_count, $posts_draft_count, $comments_count ,$comments_unapproved_count, $users_count, $users_subscribers_count, $categories_count];
                            
                               for($i =0; $i <8; $i++){
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}]," ;
                                }           
                            ?>
                            
                        ]);

                        var options = {
                          chart: {
                            title: 'Statistics',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
                <!-- /.chart -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php" ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>
    $(document).ready(function(){

        var pusher =   new Pusher('760a340531f5b1ef9e2e',{
            cluster: 'ap1',
            encrypted: true
        });

        var notificationChannel =  pusher.subscribe('notifications');
        notificationChannel.bind('new_user', function(notification){
            var message = notification.message;
            toastr.success(`${message} just registered`);
        });
    });
</script>
