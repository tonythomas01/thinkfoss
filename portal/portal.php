<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user_id'] ) ) {
		header( 'Location: ../signup.php');
	}
        require_once('../assets/php/access/accessDB.php');
        require_once('../assets/php/User.php');
        require_once('../assets/php/Token.php');
        require_once('../assets/php/access/accessTokens.php');
        $user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );
        $csrfToken = new Token( $csrfSecret );

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

	<!-- Important Owl stylesheet -->
	<link rel="stylesheet" href="../css/owl.carousel.css">

	<!-- Default Theme -->
	<link rel="stylesheet" href="../css/owl.theme.css">


    <!--[endif]-->
</head>
<body>
<!-- Navigation
==========================================-->
<nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
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
                        <li><a href="solutions/mySolutionRequests.php">My Requests</a></li>
                    </ul>
                </li>
            </ul>

	        <ul class="nav navbar-nav navbar-right">
		        <?php
		        if ( isset( $_SESSION['loggedin_user'] ) ) {
			        $loggedinUser = $_SESSION['loggedin_user'];
			        if ( $user->checkIfPrivelaged( $conn ) ) {
				        echo '<li><a href="admin/adminPanel.php"><i class="fa fa-diamond"></i> Admin</a> </li>';
			        }
			        echo '
			<li style="padding-top: 1.5%; padding-right: 10px">
                    <div class="btn-group">
                        <div class="btn tf-btn" data-toggle="dropdown"  href="cart/viewCart.php"><i class="fa fa-shopping-cart fa-fw"></i> Cart</div>
                        <a class="btn tf-btn-grey dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="badge">'; echo $user->getEnrolledCourses( $conn ); echo '</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="cart/viewCart.php"   ><i class="fa fa-cart-arrow-down fa-fw"></i> View</a></li>
                        </ul>
                    </div>

                </li>
		<li style="padding-top: 1.5%; padding-right: 10px">
                                        <div class="btn-group">
                                        <div class="btn tf-btn-grey" data-toggle="dropdown" href="portal/profile/myProfile.php"><i class="fa fa-user fa-fw"></i>'; echo  $loggedinUser; echo '</div>
                                                  <a class="btn tf-btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <span class="fa fa-caret-down"></span></a>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="../portal/portal.php" ><i class="fa fa-laptop fa-fw"></i> Portal</a></li>
                                                    <li><a href="../portal/profile/myProfile.php" ><i class="fa fa-pencil fa-fw"></i> Edit Profile</a></li>
                                                    <li><a href="#" data-toggle="modal" data-target="#myModal"  ><i class="fa fa-phone fa-fw"></i> Contact</a></li>
                                                    <li class="divider"></li>
                                                     <form action = "../assets/php/doSignOut.php" method="post">
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
                                                    <li><a href="../signup.php"><i class="fa fa-user-plus fa-fw"></i> Sign Up</a></li>
                                                  </ul>
                                                </div></li>
                                        ';
		        }
		        ?>
	        </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div id="tf-portal" class="text-center">
    <div class="overlay">
            <?php
            if ( isset( $_SESSION['message'] ) ) {
	                $message = $_SESSION['message'];
	                echo "<p class='alert-success' style='text-align: center'> $message</p>";
	                unset( $_SESSION['message'] );
            }
            if ( isset( $_SESSION['error'] ) ) {
	                $errorMessage = $_SESSION['error'];
	                echo "<p class='alert-warning' style='text-align: center' > $errorMessage </p>";
	                unset( $_SESSION['error'] );
            }

            ?>


            <div class="container" style="padding-top: 50px; text-align: center">
	            <div class="row">
		            <h1 class="section-title"> Trending on <b>ThinkFOSS</b></h1>
		            <div class="customNavigation">
			            <a class="btn prev " style="padding: 4px; color: white;"><i class="fa fa-arrow-circle-left fa-2x"></i> </a>
			            <a class="btn next " style="padding: 4px; color: white;"><i class="fa fa-arrow-circle-right fa-2x"></i> </a>
		            </div>
		            <div id="owl-portal" class="owl-carousel owl-theme">
		            <?php
		            $statement = "SELECT `course_name`, `course_id`, `course_bio` FROM `course_details` WHERE `course_approved` = true";
		            if ( $res = $conn->query( $statement ) ) {
			            foreach( $res as $row ) {
				            $courseName = $row['course_name'];
				            $courseId = $row['course_id'];
				            $coruseBio = $row['course_bio'];
				            echo "
                                                <div class='panel panel-primary'  id='course-panel-portal'>
                                                <div class='panel-body'>
                                                <a href='portal/student/course.php?name=$courseName&course=course-$courseId'
                                                target='_blank' > <h3>$courseName</h3></a>
					                        <figcaption class='mask' style='text-align:center;'>
					                                   <form action='student/course.php' method='get' style='margin-left:15%;'>
										<input type='hidden' name='name' value='$courseName' "; echo ' />
										<button class="btn tf-btn-grey btn-lg"  name="course" value="course-' . $row['course_id'] . '"  style="opacity: 0.7" href="#">
		            <i class="fa fa-search-plus fa-2x pull-left"></i>More</button>
				                                        </form>
			                                        </figcaption>
					</div>

                                                </div>';

			            }
		            }
		            ?>
			</div>
		            <div class="col-md-6">

			            <h2 class="section-title" style="padding-bottom: 10px; text-align: center; padding-bottom: 30px"> <b>Mentoring</b></h2>

			            <div class="row" style="text-align: center">
				            <a class="btn tf-btn btn-lg" target="_blank" href="mentor/addCourse.php">
					            <i class="fa fa-plus  fa-2x pull-left"></i>Add new<br>Course</a>
				            <a class="btn tf-btn-grey" href="mentor/viewMyCourses.php" target="_blank">
					            <i class="fa fa-pencil  fa-2x pull-left"></i>Edit your<br>course</a>
				            <a class="btn tf-btn btn-lg" href="mentor/viewMyCourses.php" >
					            <i class="fa fa-mortar-board   fa-2x pull-left"></i>Teach your <br> course</a>


			            </div>

		            </div>

		            <div class="col-md-6">

			            <h2 class="section-title" style="padding-bottom: 10px;padding-bottom: 30px"><b>LEARNING</b></h2>

			            <div class="row" style="text-align: center">
				            <a class="btn tf-btn btn-lg" target="_blank" href="student/viewAllCourses.php">
					            <i class="fa fa-eye  fa-2x pull-left"></i>View our <br> courses</a>
				            <a class="btn tf-btn-grey" href="student/viewAllCourses.php" target="_blank">
					            <i class="fa fa-thumbs-up  fa-2x pull-left"></i>Enroll to <br>course</a>
				            <a class="btn tf-btn btn-lg" href="student/viewEnrolledCourses.php" target="_blank">
					            <i class="fa fa-heart fa-2x pull-left"></i>Review a<br> course</a>
			            </div>


		            </div>

		            </div>

		            <div style="padding-top: 50px; padding-bottom: 10px">
			            <h2 class="section-title" style="padding-bottom: 10px;padding-bottom: 30px"><b>Quick </b>Actions</h2>
		            <a class="btn btn-lg  tf-btn" href="student/viewAllCourses.php">
			            <i class="fa fa-lightbulb-o fa-2x pull-left"></i> View all<br>Courses</a>

			            <a class="btn btn-lg tf-btn-grey" href="solutions/newSolutionRequest.php">
				            <i class="fa fa-cogs fa-2x pull-left"></i> New Solution<br>Request</a>
		            </div>



    </div>
</div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color: black;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel" style="color: black">Contact Us</h4>
                    </div>
                    <div class="modal-body">
                        <form action="http://formspree.io/admin@thinkfoss.com" method="POST" style="padding-bottom: 10px">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Your name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="contact-name" readonly value="<?php echo $user->getValue('user_first_name') .' '. $user->getValue('user_last_name'); ?>" placeholder="<?php echo $user->getValue('user_first_name') .' '. $user->getValue('user_last_name'); ?>" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" readonly id="_replyto" value ="<?php echo $user->getValue('user_email'); ?>" placeholder="<?php echo $user->getValue('user_email'); ?>" name="_replyto">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="message" id="message" placeholder="Your message" ></textarea>
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer" style="padding-top: 10px">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn tf-btn-grey">Send Message <i class="fa fa-arrow-circle-right"></i> </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include '../footer.html' ?>

</body>

<script src="../js/owl.carousel.js"></script>
<!-- Javascripts
================================================== -->
<script type="text/javascript" src="../js/main.js"></script>
</html>
