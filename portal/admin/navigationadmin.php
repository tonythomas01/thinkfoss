<?php
	require_once( '../../php/Token.php' );
	require_once( '../../php/access/accessTokens.php' );
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
                if ( $user->checkIfPrivelaged( $conn ) ) {
                    echo '<li><a href="adminPanel.php"><i class="fa fa-diamond"></i> Admin</a> </li>';
                }
                ?>
                <li><a href="../portal.php"><i class="fa fa-laptop"></i> Portal</a> </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-shopping-cart"></i> <span class="badge"><?php echo $user->getEnrolledCourses( $conn ); ?> </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../cart/viewCart.php">View Cart</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Empty Cart</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['loggedin_user'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../profile/myProfile.php">Edit Profile</a></li>
                        <li><a href="#">Recommend</a></li>
                        <li role="separator" class="divider"></li>
	                    <li>

		                    <form action="../../php/doSignOut.php" method="post">
			                    <?php
			                    $csrfToken = new Token( $csrfSecret );
			                    ?>
			                    <input type="hidden" name="CSRFToken" value='<?php echo $csrfToken->getCSRFToken(); ?>'/>
			                    <button type="submit" class="btn btn-danger btn-block">Sign Out</button>
		                    </form>
	                    </li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>