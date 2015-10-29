<?php
	require_once('../../assets/php/Token.php');
	require_once('../../assets/php/access/accessTokens.php');
        $csrfToken = new Token( $csrfSecret );
?>
<!-- Navigation
==========================================-->
<nav id='tf-menu' class="navbar navbar-default navbar-fixed-top" style="background-color: white">
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
                        <li><a href="../student/viewEnrolledCourses.php">Enrolled courses</a></li>
                        <li><a href="../student/viewAllCourses.php">Available courses</a></li>
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
                if ( isset( $_SESSION['loggedin_user'] ) ) {
                    $loggedinUser = $_SESSION['loggedin_user'];
                    if ( $user->checkIfPrivelaged( $conn ) ) {
                        echo '<li><a href="../admin/adminPanel.php"><i class="fa fa-diamond"></i> Admin</a> </li>';
                    }
                    echo '
			<li style="padding-top: 1.5%; padding-right: 10px">
                    <div class="btn-group">
                        <div class="btn tf-btn"  data-toggle="dropdown" href="cart/viewCart.php"><i class="fa fa-shopping-cart fa-fw"></i> Cart</div>
                        <a class="btn tf-btn-grey dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="badge">'; echo $user->getEnrolledCourses( $conn ); echo '</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="../cart/viewCart.php"   ><i class="fa fa-cart-arrow-down fa-fw"></i> View</a></li>
                        </ul>
                    </div>

                </li>
		<li style="padding-top: 1.5%; padding-right: 10px">
                                        <div class="btn-group">
                                        <div class="btn tf-btn-grey" data-toggle="dropdown" href="portal/profile/myProfile.php"><i class="fa fa-user fa-fw"></i>'; echo  $loggedinUser; echo '</div>
                                                  <a class="btn tf-btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fa fa-caret-down"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="../portal.php" ><i class="fa fa-laptop fa-fw"></i> Portal</a></li>
                                                    <li><a href="../profile/myProfile.php" ><i class="fa fa-pencil fa-fw"></i> Edit Profile</a></li>
                                                    <li class="divider"></li>
                                                     <form action = "../../assets/php/doSignOut.php" method="post">
                                                     <input type="hidden" name="CSRFToken" value='; echo $csrfToken->getCSRFToken(); echo '></input>
                                                        <li><button class="btn btn-link btn-block" type="submit" style="text-decoration: none" href="#" ><i class="fa fa-sign-out fa-fw"></i> Sign Out</button></li>
                                                     </form>
                                                  </ul>
                                        </div></li>
                                        ';
                } else {

                    echo'<li style="padding-top: 4%; padding-right: 10px">
                                        <div class="btn-group">
                                                  <div class="btn tf-btn-grey" data-toggle="modal" data-target="#login-modal" href="#"><i class="fa fa-user fa-fw"></i> Login</div>
                                                  <a class="btn tf-btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fa fa-caret-down"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="#"  data-toggle="modal" data-target="#login-modal" ><i class="fa fa-sign-in fa-fw"></i> Login</a></li>
                                                    <li><a href="../../signup.php"><i class="fa fa-user-plus fa-fw"></i> Sign Up</a></li>
                                                  </ul>
                                                </div></li>
                                        ';
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>