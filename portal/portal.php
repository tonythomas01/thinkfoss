<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user_id'] ) ) {
		header( 'Location: ../signup.php');
	}

        require_once( '../php/access/accessDB.php' );
        require_once( '../php/User.php' );
        require_once( '../php/Token.php' );
        require_once( '../php/access/accessTokens.php' );
        $user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );

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

    <link href="../css/material/material-wfont.min.css" rel="stylesheet">
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
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66359518-1', 'auto');
        ga('send', 'pageview');

    </script>


    <!--[endif]-->
</head>
<body>
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
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Solutions <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="solutions/newSolutionRequest.php">New Request</a></li>
                        <li><a href="student/viewAllCourses.php">My Requests</a></li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php
                    if ( $user->checkIfPrivelaged( $conn ) ) {
                        echo '<li><a href="admin/adminPanel.php"><i class="fa fa-diamond"></i> Admin</a> </li>';
                    }
                ?>

                <li><a href="cart/viewCart.php"><i class="fa fa-shopping-cart"><span class="badge"><?php echo $user->getEnrolledCourses( $conn ); ?> </span></i></a> </li>
                <li><a href="portal.php"><i class="fa fa-laptop"></i> Portal</a> </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['loggedin_user'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile/myProfile.php">Edit Profile</a></li>
                        <li><a href="#">Recommend</a></li>
                        <li role="separator" class="divider"></li>
                        <li>

                            <form action="../php/doSignOut.php" method="post">
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
<div id="tf-portal" class="text-center">
    <div class="overlay">
        <div class="portal">

            <?php
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
                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <a href="mentor/addCourse.php" class="thumbnail" style="text-align: center; color: blue">
                            <i class="fa fa-plus fa-5x"> </i>
                            <div class="caption"><h2>Add</h2>course</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="mentor/viewMyCourses.php" class="thumbnail" style="text-align: center; color: red">
                            <i class="fa fa-pencil fa-5x"> </i>
                            <div class="caption"><h2>Edit</h2> your course</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" data-toggle="modal" data-target="#myModal" ><div class="thumbnail" style="text-align: center; color: green">
                                <i class="fa fa-phone fa-5x"> </i>
                                <div class="caption" ><h2>Help</h2>call</div>
                        </div></a>
                    </div>
                </div>

            </div>

            <div class='col-xs-6'>
                <h1 class="section-title"> Want to learn ?</h1>
                <p class='intro'> Awesome! Looks like you are at the right place. Please use the menu items over here to enroll to a course you like. If you
                    feel like, you can even mentor a course.<br><br>
                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <a href="student/viewAllCourses.php" class="thumbnail" style="text-align: center; color:#9c27b0">
                            <i class="fa fa-eye fa-5x"> </i>
                            <div class="caption"><h2>View</h2>courses</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="student/viewAllCourses.php" class="thumbnail" style="text-align: center; color:blue">
                            <i class="fa fa-thumbs-up fa-5x"> </i>
                            <div class="caption"><h2>Enroll</h2>course</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="student/viewEnrolledCourses.php" class="thumbnail" style="text-align: center; color:red">
                            <i class="fa fa-heart fa-5x"> </i>
                            <div class="caption"><h2>Review</h2>course</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" data-toggle="modal" data-target="#myModal" ><div class="thumbnail" style="text-align: center; color: green">
                            <i class="fa fa-phone fa-5x"> </i>
                            <div class="caption" ><h2>Help</h2>call</div>
                        </div></a>
                    </div>
                </div>
            </div>
        </div>

            <div>
                <h1 style="color: white">Solutions ?</h1>
                <div class="row">
                    <div class="col-md-2 col-lg-offset-5">
                        <a href="solutions/newSolutionRequest.php" class="thumbnail" style="text-align: center; color: limegreen">
                            <i class="fa fa-gears fa-5x"> </i>
                                <div class="caption"><h2>Solutions</h2>request</div>
                        </a>
                    </div>
                </div>
            </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="color: black">Contact Us</h4>
                    </div>
                    <div class="modal-body">

                        <form action="http://formspree.io/tony@thinkfoss.com" method="POST" >
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Your name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contact-name" disabled placeholder="<?php echo $user->getValue('user_first_name') .' '. $user->getValue('user_last_name'); ?>" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" disabled id="contact-email" placeholder="<?php echo $user->getValue('user_email'); ?>" name="_replyto">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="message" id="message" placeholder="Your message" ></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


        </div>

    </div>
<?php include '../footer.html' ?>

</body>
</html>