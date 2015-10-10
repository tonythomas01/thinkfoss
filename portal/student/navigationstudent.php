<?php
	require_once('../../assets/php/Token.php');
	require_once('../../assets/php/access/accessTokens.php');
?>
<link href="../../css/material/material-wfont.min.css" rel="stylesheet">
<!-- Navigation
==========================================-->
<nav id='tf-menu' class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../../index.php"><i class="fa fa-home"></i> Think<span class="color">FOSS</span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mentor <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="../mentor/viewMyCourses.php">My courses</a></li>
                        <li><a href="../mentor/addCourse.php">Add new course</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Learn <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="viewEnrolledCourses.php">Enrolled Courses</a></li>
                        <li><a href="viewAllCourses.php">Available courses</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solutions <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="../solutions/newSolutionRequest.php">New Request</a></li>
                        <li><a href="../solutions/mySolutionRequests.php">My Requests</a></li>
                    </ul>
                </li>
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <?php
                if ( $user ) {
                    if ( $user->checkIfPrivelaged( $conn ) ) {
                        echo '<li><a href="../admin/adminPanel.php"><i class="fa fa-diamond"></i> Admin</a> </li>';
                    }
                echo "
                    <li><a href='../cart/viewCart.php'><i class='fa fa-shopping-cart'><span class='badge'>"; echo $user->getEnrolledCourses( $conn ); echo "</span></i></a> </li>
                    <li><a href='../portal.php'><i class='fa fa-laptop'></i> Portal</a> </li>
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>"; echo $_SESSION['loggedin_user']; echo "<span class='caret'></span></a>
                        <ul class='dropdown-menu'>
                            <li><a href='../profile/myProfile.php'>Edit Profile</a></li>
                            <li><a href='#'>Recommend</a></li>
                            <li role='separator' class='divider'></li>
                                <li>
                                        <form action='../../assets/php/doSignOut.php' method='post'>";
                                                $csrfToken = new Token( $csrfSecret );
                                                echo "
                                                <input type='hidden' name='CSRFToken' value="; echo $csrfToken->getCSRFToken(); echo "/>
                                                <button type='submit' class='btn btn-danger btn-block'>Sign Out</button>
                                        </form>
                                </li>
                        </ul>
                    </li>";

                } else {
                    echo "<li>
                            <div>
                            <button type='button' class='btn btn-raised' data-toggle='modal' data-target='#login-modal' style='background-color: gold; color: black; padding-right: 10px; padding-left: 10px'>Login</button>
                            <a href='../../signup.php'> <button  class='btn btn-raised' style='background-color: #d0e9c6; padding-right: 10px; color:black; padding-left: 10px; margin-right: 10px'> SIGN UP </button></a>
                            </div>

                            </li>";
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<?php
    $csrfToken = new Token( $csrfSecret );
?>
<!-- Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <div class="modal-dialog" role="document"  style="width: 400px">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="section-title" style="text-align: center">
                    <h2><strong>Think<span style="color :orange">FOSS</span></strong></h2></div>
                <p style="text-align: center"> code | train | grow</p>

            </div>
            <div class="panel-body">
                <form  action = '../../assets/php/doSignIn.php' method = 'post' style="padding: 10px 10px 0px 10px;" >
                    <div class='form-group'>
                        <label class='sr-only' for='username' > Email id </label >
                        <div class='input-group' >
                            <div class='input-group-addon'><i class='fa fa-user'></i ></div >
                            <input type = 'text' class='form-control' id = 'username' name = 'username' placeholder = ' Email id'>
                        </div> <br>
                        <label class='sr-only' for='password'> Password</label >
                        <div class='input-group'>
                            <div class='input-group-addon' ><i class='fa fa-eye' ></i ></div >
                            <input type = 'password' class='form-control' id = 'password' name = 'password' placeholder = ' Password'>
                        </div>
                        <input type='hidden' name='CSRFToken' value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
                        <button type="submit" class="btn btn-success btn-raised btn-block">Sign in</button>

                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <p style="text-align: center;">
                    <a href='../../signup.php'> <button  class='btn btn-raised' style='background-color: #d0e9c6; padding-right: 10px; color:black; padding-left: 10px; margin-right: 10px'> SIGN UP </button></a>
                    or login using

                    <a href='../../assets/php/oauth/oauth2callback.php'> <button type='button' style="width: 50px; height:50px; border-radius: 25px;   padding: 10px 16px; " class='btn btn-material-deeporange btn-raised'><i class="fa fa-google-plus fa-2x"></i> </button></a>
                    <a href='../../assets/php/oauth/oauth2callbackgithub.php?action=login'> <button type='button' style=" width: 50px; height:50px; border-radius: 25px; padding: 10px 16px;" class='btn btn-material-bluegrey btn-raised'><i class="fa fa-github fa-2x"></i> </button></a>

                </p>
            </div>

        </div>

    </div>

</div>
