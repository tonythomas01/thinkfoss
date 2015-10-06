<?php
	session_start();
	if ( !isset( $_SESSION['loggedin_user'] ) ) {
		header( 'Location: ../../signup.php');
	}

	if ( !$_SERVER['REQUEST_METHOD'] == 'POST' ) {
		header( 'Location: viewAllCourses.php');
		return false;
	}
	require_once('../../assets/php/access/accessDB.php');
	require_once('../../assets/php/User.php');
	$user = User::newFromUserId( $_SESSION['loggedin_user_id'], $conn );


	require_once('../../assets/php/Statement.php');
	$preparedPost = new Statement( $_POST );
	if ( $preparedPost->checkIfEmptyPost() ) {
		$_SESSION['error'] = "Please make sure you add in all required details";
		header('Location: ' . '../student/viewAllCourses.php');
		return;
	}
	require_once('../../assets/php/Token.php');
	require_once('../../assets/php/access/accessTokens.php');
	$csrfToken = new Token( $csrfSecret );
	if( ! $csrfToken->validateCSRFToken( $preparedPost->getValue('CSRFToken') ) ) {
		$_SESSION['error'] = "Error: Invalid CSRF Token. Please contact one of the admins, or try againsss";
		header( 'Location: '.'../portal/cart/viewCart.php');
		return false;
	}

	$loggedInUser = $_SESSION['loggedin_user_id'];

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
	<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="../../img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/apple-touch-icon-114x114.png">

	<!-- Bootstrap -->
	<link rel="stylesheet" type="text/css"  href="../../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../../fonts/font-awesome/css/font-awesome.css">


	<!-- Stylesheet
	================================================== -->
	<link rel="stylesheet" type="text/css"  href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/responsive.css">

	<script type="text/javascript" src="../../js/modernizr.custom.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

	<!-- Latest compiled and minified CSS -->


	<!-- jQuery library -->
	<script src="../../js/jquery.1.11.1.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="../../js/bootstrap.min.js"></script>

	<link href="../../css/material/ripples.min.css" rel="stylesheet">

	<link href="../../css/material/flipper.css" rel="stylesheet">
	<link href="../../css/material/material-wfont.min.css" rel="stylesheet">

	<!--[endif]-->
</head>
<body >
<?php
	require_once('../../assets/php/Course.php');
	require_once('../../assets/php/User.php');
	$preparedPost->sanitize();
	$courseName = mysqli_real_escape_string( $conn, $preparedPost->getValue( 'course' ) );
	$courseRaw = explode( '-', $courseName );
	$course = Course::newFromId( $conn, $courseRaw[1] );
	$mentorId =  $course->getValue( 'course_mentor' );
	$mentor = User::newFromUserId( $mentorId, $conn );
	$mentor->getExtra( $conn );
	$reviews = $course->getReviews( $conn );
?>
<!-- Navigation
==========================================-->
<?php include 'navigationstudent.php' ?>


<div id="tf-portal" class="text-center">
	<div class="overlay">
		<div class="portal" >
			<?php
			if ( $_SESSION['message'] ) {
				$message = $_SESSION['message'];
				echo "<p class='alert-success' style='text-align: center'> $message</p>";
				unset( $_SESSION['message'] );
			} else if ( $_SESSION['error'] ) {
				$errorMessage = $_SESSION['error'];
				echo "<p class='alert-warning' style='text-align: center'> $errorMessage </p>";
				unset( $_SESSION['error'] );
			}
			?>

			<div>
				<h2><?php $courseIdTag = 'course-' . $course->getCourseId();

					echo $course->getCourseName(). " <small>Active : <i class='fa fa-check' ></i>";
					if ( $course->isEnrolled( $loggedInUser, $conn ) ) {
						echo " Enrolled : <span style='color: green; font-weight: bold'> Yes</span> </small>";
						echo '<small><span style="text-align: right; float: right;">
							 <form action="writeReview.php" method="post">
							<input type="hidden" name="CSRFToken" value="';
						echo $csrfToken->getCSRFToken();
						echo '"/>
						<button class="btn btn-info" type="submit" name="course-review"
						id="review"   value="'; echo $courseIdTag; echo '"><i class="fa fa-pencil-square" > Review</i></button>
							</form>
						</span></small></h2>';


					} else if ( $course->needsCheckout( $loggedInUser, $conn ) ) {
						echo " Enrolled : <span style='color: red; font-weight: bold'> NEEDS CHECKOUT</span> </small>";
						echo '<small><span style="text-align: right; float: right;">
							<a href="../cart/viewCart.php"> <button type="button"  class="btn btn-danger" name="course" value="course-' . $row['course_id'] . '" > <i class="fa fa-star" style="color:gold" ></i> Checkout </button></a>
							</span></small></h2>';
					} else{
						echo " Enrolled : <span style='color: red; font-weight: bold'> No</span> </small>";
						echo '<small><span style="text-align: right; float: right;">
							<form action="../../assets/php/doEnrollCourse.php" method="post">
							<input type="hidden" name="CSRFToken" value="'; echo $csrfToken->getCSRFToken(); echo '"/>
							<button class="btn btn-success" type="submit" name="course" value="'; echo $courseIdTag; echo '">Add <i class="fa fa-shopping-cart"></i></button>
							</form>
						</span></small></h2>';
					}

					?>

 				<hr>
			</div>

			<div class="row">
				<div class="col-md-6 well well">
					<h2>Course</h2> <br>
					<h5>Language </h5><?php echo $course->getValue('course_lang') ?>
					<h5>Difficulty </h5><?php echo $course->getValue('course_difficulty') ?>
					<h5>Fee </h5><?php echo $course->getValue('course_fees') ?>
					<h5>Description </h5><?php echo $course->getValue('course_bio') ?>
					<h5>From: <?php echo $course->getValue('course_date_from') . ' : ' . $course->getValue('course_time_from'); ?></h5>
					<h5>To: <?php echo $course->getValue('course_date_to' ) . ' : ' . $course->getValue('course_time_to'); ?></h5>
					<h5>Reviews </h5>
					<hr>
					<?php
						if ( !empty( $reviews ) ) {
							foreach( $reviews as $review ) {
								$revuser = User::newFromUserId( $review['user_id'], $conn );
								echo 'Recommended :' . $review['recommend'] .
									'<span style="text-align:right; float : right;"> User: ' . $revuser->getValue('user_first_name')  .' ' . $revuser->getValue('user_last_name') . ' </span>';
								echo '<h5>Review : </h5>' . $review['general_review'];
								echo '<hr>';

							}
						} else {
							echo 'No reviews yet.';
						}
					?>

				</div>
				<div class="col-md-6">
					<h2>Mentor</h2> <br>
					<h5>Name </h5><?php echo $mentor->getValue('user_first_name') . ' ' . $mentor->getValue('user_last_name'); ?>
					<h5>Github </h5> <i class="fa fa-github"></i> <?php echo $mentor->getValue( 'user_github'); ?>
					<h5>Linkedin </h5> <i class="fa fa-linkedin"></i> <?php echo $mentor->getValue( 'user_linkedin'); ?>
					<h5>Bio </h5> <?php echo $mentor->getValue( 'user_about'); ?>
					<h5>Nationality</h5> <?php echo $mentor->getValue( 'user_nation'); ?>
				</div>

			</div>


		</div>
	</div>
</div>

<script src="../../js/material/ripples.min.js"></script>
<script src="../../js/material/material.min.js"></script>


<?php include '../../footer.html' ?>
</body>
</html>