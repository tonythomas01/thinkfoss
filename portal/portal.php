<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../signup.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ThinkFOSS - code | train | grow</title>
    <meta name="msvalidate.01" content="AACA4869B9C746F7F151D39BF5D19CB2" />
    <meta name="description" content=" ThinkFOSS aims at providing Open Source training and solutions to Individuals, Schools, Universities and Industries in need. ThinkFOSS is a collection of Open Source enthusiasts and entrepreneurs who are ready to spend their time spreading FOSS technologies">
    <meta name="keywords" content="thinkfoss, fossatamrita, training, open source, open source solutions">
    <meta name="author" content="thinkfoss.com">

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="../img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/apple-touch-icon-114x114.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="../css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/css/font-awesome.css">

    <!-- Stylesheet
    ================================================== -->
    <link rel="stylesheet" type="text/css"  href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/responsive.css">

    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,700,300,600,800,400' rel='stylesheet' type='text/css'>

    <script type="text/javascript" src="../js/modernizr.custom.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Latest compiled and minified CSS -->


    <!-- jQuery library -->
    <script src="../js/jquery.1.11.1.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!--[endif]-->
</head>
<body background="black">
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
            <a class="navbar-brand" href="../index.php"><i class="fa fa-home"></i> Think<span class="color">FOSS</span></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mentor <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="mentor/viewMyCourses.php">My courses</a></li>
                        <li><a href="mentor/addCourse.php">Add new course</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Learn <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="student/viewEnrolledCourses.php">My enrollments</a></li>
                        <li><a href="student/viewAllCourses.php">Available courses</a></li>
                    </ul>
                </li>
            </ul>


            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="cart/viewCart.php">View Cart</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="../../php/doSignOut.php">Empty Cart</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['loggedin_user'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Edit Profile</a></li>
                        <li><a href="#">Recommend</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="../php/doSignOut.php">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="portal">

            <?php
            session_start();
            if ( $_SESSION['message'] ) {
                $message = $_SESSION['message'];
                echo "<p class='alert-success' style='text-align: center'> $message</p>";
                unset( $_SESSION['message'] );
            }
            if ( $_SESSION['error'] ) {
                $errorMessage = $_SESSION['error'];
                echo "<p class='alert-warning' style='text-align: center' > $errorMessage </p>";
                unset( $_SESSION['error'] );
            }

            ?>

            <div class='col-xs-6'>
                <h1 class="section-title"> Want to Mentor ?</h1>
                <p class='intro'> Great! ThinkFOSS is happy to welcome mentors like you.You can add in more course, change your
                    personal settings and do a lot more from here. <br><br>
                <h2>What to do now ?</h2>
                <ul class='mentor-list'>
                    <li>
                        <span class='fa fa-scissors'></span>
                        <strong>Edit your profile</strong>
                    </li>
                    <li>
                        <span class='fa fa-plus'></span>
                        <strong>Add in new courses</strong>
                    </li>
                    <li>
                        <span class='fa fa-phone'></span>
                        <strong>Stuck ? Contact one of us</strong>
                    </li>

                </ul><br>

            </div>

            <div class='col-xs-6'>
                <h1 class="section-title"> Want to learn ?</h1>
                <p class='intro'> Awesome! Looks like you are at the right place. Please use the menu items over here to enroll to a course you like. If you
                    feel like, you can even mentor a course.<br><br>
                <h2>TODO</h2>
                <ul class='mentor-list'>
                    <li>
                        <span class='fa fa-scissors'></span>
                        <strong>Edit your profile</strong>
                    </li>
                    <li>
                        <span class='fa fa-list'></span>
                        <strong>List courses available</strong>
                    </li>
                    <li>
                        <span class='fa fa-check'></span>
                        <strong>Enroll to our courses</strong>
                    </li>
                    <li>
                        <span class='fa fa-phone'></span>
                        <strong>Stuck ? Contact one of us</strong>
                    </li>

                </ul><br>
            </div>
        </div>


            <div style="position: absolute; bottom: 0; width: 100%; background-color: gold">
                <div class="col-xs-12 col-sm-6 col-lg-8" style="text-align: right" >
                    <p style="opacity: 1; font-size: xx-large; font-family: 'Lato', sans-serif; color: black">Found a bug ? Report to our Phabricator</p>
                </div>
                <div class="col-xs-6 col-lg-4" style="text-align: left; padding-top: 5px">
                        echo "<a href='portal.php'> <button class='btn tf-btn btn-danger btn-lg' ><strong>Phabricator</strong></button></a>";

                </div>
            </div>

            </div>

        </div>
</div>
</body>
</html>